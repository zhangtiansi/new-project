<?php
namespace app\components;
use Yii;
use app\components\WxPayApi;
use app\models\GmOrderlist;
/**
 * 
 * 回调基础类
 * @author widyhu
 *
 */
class WxPayNotify extends WxPayNotifyReply
{
	/**
	 * 
	 * 回调入口
	 * @param bool $needSign  是否需要签名输出
	 */
	final public function Handle($needSign = true)
	{
		$msg = "OK";
		//当返回false的时候，表示notify中调用NotifyCallBack回调失败获取签名校验失败，此时直接回复失败
		$result = WxPayApi::notify(array($this, 'NotifyCallBack'), $msg);
		if($result == false){
			$this->SetReturn_code("FAIL");
			$this->SetReturn_msg($msg);
			$this->ReplyNotify(false);
			return;
		} else {
			//该分支在成功回调到NotifyCallBack方法，处理完成之后流程
			$this->SetReturn_code("SUCCESS");
			$this->SetReturn_msg("OK");
		}
		$this->ReplyNotify($needSign);
	}
	
	/**
	 * 
	 * 回调方法入口，子类可重写该方法
	 * 注意：
	 * 1、微信回调超时时间为2s，建议用户使用异步处理流程，确认成功之后立刻回复微信服务器
	 * 2、微信服务器在调用失败或者接到回包为非确认包的时候，会发起重试，需确保你的回调是可以重入
	 * @param array $data 回调解释出的参数
	 * @param string $msg 如果回调处理失败，可以将错误信息输出到该方法
	 * @return true回调出来完成不需要继续回调，false回调处理未完成需要继续回调
	 */
	public function NotifyProcess($data, &$msg)
	{
		//TODO 用户基础该类之后需要重写该方法，成功的时候返回true，失败返回false
		Yii::error("all data: ".print_r($data,true),"wxpay");
		/**
            Array
(
    [appid] => wx0d2f5bd9dd619438
    [attach] => zuanshi_android_6  FA95CF014461048992605  145895
    [bank_type] => CFT
    [cash_fee] => 1
    [fee_type] => CNY
    [is_subscribe] => N
    [mch_id] => 1280663501
    [nonce_str] => 654ad60ebd1ae29cedc37da04b6b0672
    [openid] => oXiH6vgh96RuJFovdi1UkRi0zD48
    [out_trade_no] => FA95CF014461048992605
    [result_code] => SUCCESS
    [return_code] => SUCCESS
    [sign] => 027B2447C436F45CEA9CDC43B6730DA4
    [time_end] => 20151029154825
    [total_fee] => 1
    [trade_type] => APP
    [transaction_id] => 1002831000201510291377656447
)
		 */
		$arattch =explode(",",  preg_replace("/(\s{1,}|\+\+)/",",",$data['attach']));
		$orderid = $arattch[1];
		$gid = $arattch[2];
		$ord = GmOrderlist::findOne(['playerid'=>$gid,'orderid'=>$orderid,'status'=>0]);
		if (is_object($ord) && $data['result_code']=="SUCCESS" &&$data['total_fee']==($ord->fee*100) )
		{
		    $ord->status=1;
		    $ord->source='WXPAY';
		    $ord->utime = date('Y-m-d H:i:s');
		    $ord->transaction_id=$data['transaction_id'];
		    if ($ord->save()){
		        $msg = "OK";
		        return true;
		    }else {
		        Yii::error("error saveorder  save ".print_r($ord->getErrors(),true),"wxpay");
		        return false;
		    }
		}else {
		        Yii::error("order not found playerid:".$gid."order: ".$orderid." or data result code:".$data['result_code'],"wxpay");
		        return false;
		    }
	}
	
	/**
	 * 
	 * notify回调方法，该方法中需要赋值需要输出的参数,不可重写
	 * @param array $data
	 * @return true回调出来完成不需要继续回调，false回调处理未完成需要继续回调
	 */
	final public function NotifyCallBack($data)
	{
		$msg = "OK";
		$result = $this->NotifyProcess($data, $msg);
		
		if($result == true){
			$this->SetReturn_code("SUCCESS");
			$this->SetReturn_msg("OK");
		} else {
			$this->SetReturn_code("FAIL");
			$this->SetReturn_msg($msg);
		}
		return $result;
	}
	
	/**
	 * 
	 * 回复通知
	 * @param bool $needSign 是否需要签名输出
	 */
	final private function ReplyNotify($needSign = true)
	{
		//如果需要签名
		if($needSign == true && 
			$this->GetReturn_code() == "SUCCESS")
		{
			$this->SetSign();
		}
		WxpayApi::replyNotify($this->ToXml());
	}
}