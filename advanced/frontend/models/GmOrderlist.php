<?php

namespace app\models;

use Yii;
use app\components\ApiErrorCode;
use app\components\HttpClient;
use yii\db\Exception;
/**
 * This is the model class for table "gm_orderlist".
 *
 * @property integer $id
 * @property integer $playerid
 * @property string $orderid
 * @property string $productid
 * @property string $reward
 * @property string $source
 * @property string $transaction_id
 * @property string $transaction_time
 * @property integer $status
 * @property string $ctime
 * @property string $utime
 * @property integer $vipcard_g
 * @property integer $vipcard_s
 * @property integer $vipcard_c
 */
class GmOrderlist extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gm_orderlist';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['playerid', 'orderid', 'productid', 'reward', 'status', 'ctime'], 'required'],
            [['playerid', 'status', 'vipcard_g', 'vipcard_s', 'vipcard_c'], 'integer'],
            [['transaction_time', 'ctime', 'utime','coin','card_kick','card_laba','card_rename'], 'safe'],
            [['orderid','price','fee','productid'], 'string', 'max' => 50], 
            [['reward'], 'string', 'max' => 20],
            [['source'], 'string', 'max' => 10],
            [['transaction_id'], 'string', 'max' => 60],
            [['orderid'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'playerid' => '玩家id',
            'orderid' => '订单号',
            'productid' => '产品id',
            'reward' => '钻石数',
            'source' => '渠道',
            'transaction_id' => '渠道交易号',
            'transaction_time' => '渠道交易时间',
            'status' => '状态',
            'ctime' => '创建时间',
            'utime' => '修改时间',
            'coin'=>'金币数',
            'card_kick'=>'踢人卡',
            'card_laba'=>'喇叭卡',
            'card_rename'=>'改名卡',
            'vipcard_g' => 'Vip金卡',
            'vipcard_s' => 'Vip银卡',
            'vipcard_c' => 'Vip铜卡',
            'price'=>'价格'
        ];
    }
    public function getProduct()
    {//一对一
        return $this->hasOne(CfgProducts::className(), ['product_id' => 'productid']);
    }
    /**
     * 生成订单号
     *
     */
    public function genOrder($player,$productid,$flag=0)
    {
        $res = array();
        //flag=0 安卓，1ios，产品id不同
        if ($productid=="card_week"||$productid=="card_month"){
            $prod = CfgProducts::findOne(['product_id'=>$productid]);
        }else{
            $prod = CfgProducts::findOne(['product_id'=>$productid,'product_type'=>$flag]);
        }
        $playerinfo = GmPlayerInfo::findOne($player);
        if (!is_object($playerinfo))
            return json_encode(ApiErrorCode::$PlayerInfoError);
        if (is_object($prod)){
            
            $model = new GmOrderlist();
            $model->playerid = $player;
            $model->orderid = substr(strtoupper(md5($player)),5,7).time().rand(1000, 9999);
            $model->productid = $productid;
            $model->reward = strval($prod->diamonds);
            /**
             20160112首充功能
             */
            if ($this->isInFirst($productid)){
                $cFirst=GmOrderlist::find()->where(['status'=>2,'productid'=>$productid,'playerid'=>$player])->count(); //是否首次充值该产品id
                if ($cFirst==0)
                    $model->reward = strval($prod->diamonds*2);
            }
            $model->vipcard_g = $prod->vipcard_g;
            $model->vipcard_s = $prod->vipcard_s;
            $model->vipcard_c = $prod->vipcard_c;
            $model->coin = $prod->coin;
            if ($prod->coin==0)
                $model->coin =1;
            $model->card_kick = $prod->card_kick;
            $model->card_laba = $prod->card_laba;
            $model->card_rename = $prod->card_rename;
            $model->status = 0;
            $model->price = $prod->price;
            $model->fee = $prod->price;
            $model->ctime = date('Y-m-d H:i:s');
            if ($model->save()){
                $res=ApiErrorCode::$OK;
                $res['info']=['orderid'=>$model->orderid,'price'=>strval($prod->price),'productid'=>$productid,'product_name'=>$prod->product_name];
                Yii::error("gen order id success ".print_r($res,true));
            }else {
                Yii::error("save order failed ".print_r($model->getErrors(),true));
                $res=ApiErrorCode::$RuleError;
                Yii::error("gen order id error ".print_r($res,true));
            }
        }else {
            $res = ApiErrorCode::$ProductidError;
            Yii::error("gen order id error ".print_r($res,true));
        }
        return $res;
    }
    function isInFirst($productid)
    {
        foreach (Yii::$app->params['firstRecharge'] as $pid){
            if ($productid == $pid)
                return true;
        }
        return false;
    }
    
    public function afterSave($insert,$changedAttributes)
    {
        parent::afterSave($insert,$changedAttributes);
        if ($this->status==1){
            $str = "";
            /**
             * 'id' => 'ID',
            'playerid' => '玩家id',
            'orderid' => '订单号',
            'productid' => '产品id',
            'reward' => '钻石数',
            'source' => '渠道',
            'transaction_id' => '渠道交易号',
            'transaction_time' => '渠道交易时间',
            'status' => '状态',
            'ctime' => '创建时间',
            'utime' => '修改时间',
            'coin'=>'金币数',
             */
            $str.="订单处理 gid:".$this->playerid."订单号:".$this->orderid." 产品ID：".$this->productid." 钻石".$this->reward." 支付方式:".$this->source." 渠道订单号".$this->transaction_id;
            $logpath = Yii::$app->params['selflogs']['order'];
            $str = date('Y-m-d H:i:s')."  ".$str."\r\n";
            $f=fopen($logpath,"a+");
            fwrite( $f,$str);
            fclose( $f);
            if ($this->productid==GmMonthCard::PRODUCT_CARD_WEEK||$this->productid==GmMonthCard::PRODUCT_CARD_MONTH)
            {//周卡或者月卡充值到账，需要加相应的卡
                if (GmMonthCard::AddCard($this->playerid, $this->productid, $this->orderid))
                {
                    Yii::error("Order save addCard success ".$this->orderid,'buycard');
                }else {
                    Yii::error("Order save addCard failed ".$this->orderid,'buycard');
                }
            }
        }

    }
    
    
    public static function checkSmsDaily($gid)
    {
        $db = Yii::$app->db;
        $sql = 'select sum(fee) from gm_orderlist where status=2 and `source`="Sms" and date_format(utime,"%Y-%m-%d")=date_format(Now(),"%Y-%m-%d") and playerid=:playerid';
        $res = $db->createCommand($sql)->bindValues([":playerid"=>$gid])->queryScalar();
        if ($res >= Yii::$app->params['smsday'])
        {
            return  false;
        }else {
            return true;
        }
    }
    public static function checkSmsMonth($gid)
    {
        $db = Yii::$app->db;
        $sql = 'select sum(fee) from gm_orderlist where status=2 and `source`="Sms" and date_format(utime,"%Y-%m")=date_format(Now(),"%Y-%m") and playerid=:playerid';
        $res = $db->createCommand($sql)->bindValues([":playerid"=>$gid])->queryScalar();
        if ($res >= Yii::$app->params['smsmonth'])
        {
            return  false;
        }else {
            return true;
        }
    }
    
    public function getReqHmacString($p0_Cmd,$p2_Order,$p3_Amt,$p4_verifyAmt,$p5_Pid,$p6_Pcat,$p7_Pdesc,$p8_Url,$pa_MP,$pa7_cardAmt,$pa8_cardNo,$pa9_cardPwd,$pd_FrpId,$pr_NeedResponse,$pz_userId,$pz1_userRegTime)
    {
    
        $merchantKey = Yii::$app->params['merchantKey'];
        $sbOld		=	"";
        $sbOld		=	$sbOld.$p0_Cmd;
        $sbOld		=	$sbOld.Yii::$app->params['p1_MerId'];
        $sbOld		=	$sbOld.$p2_Order;
        $sbOld		=	$sbOld.$p3_Amt;
        $sbOld		=	$sbOld.$p4_verifyAmt;
        $sbOld		=	$sbOld.$p5_Pid;
        $sbOld		=	$sbOld.$p6_Pcat;
        $sbOld		=	$sbOld.$p7_Pdesc;
        $sbOld		=	$sbOld.$p8_Url;
        $sbOld 		= $sbOld.$pa_MP;
        $sbOld 		= $sbOld.$pa7_cardAmt;
        $sbOld		=	$sbOld.$pa8_cardNo;
        $sbOld		=	$sbOld.$pa9_cardPwd;
        $sbOld		=	$sbOld.$pd_FrpId;
        $sbOld		=	$sbOld.$pr_NeedResponse;
        $sbOld		=	$sbOld.$pz_userId;
        $sbOld		=	$sbOld.$pz1_userRegTime;
       	return $this->HmacMd5($sbOld,$merchantKey);
    
    }
    
    function getCallbackHmacString($r0_Cmd,$r1_Code,$p1_MerId,$p2_Order,$p3_Amt,$p4_FrpId,$p5_CardNo,
        $p6_confirmAmount,$p7_realAmount,$p8_cardStatus,$p9_MP,$pb_BalanceAmt,$pc_BalanceAct)
    {
    
        $merchantKey = Yii::$app->params['merchantKey'];
        
        $sbOld="";
        $sbOld = $sbOld.$r0_Cmd;
        $sbOld = $sbOld.$r1_Code;
        $sbOld = $sbOld.Yii::$app->params['p1_MerId'];
        $sbOld = $sbOld.$p2_Order;
        $sbOld = $sbOld.$p3_Amt;
        $sbOld = $sbOld.$p4_FrpId;
        $sbOld = $sbOld.$p5_CardNo;
        $sbOld = $sbOld.$p6_confirmAmount;
        $sbOld = $sbOld.$p7_realAmount;
        $sbOld = $sbOld.$p8_cardStatus;
        $sbOld = $sbOld.$p9_MP;
        $sbOld = $sbOld.$pb_BalanceAmt;
        $sbOld = $sbOld.$pc_BalanceAct;
         
        return $this->HmacMd5($sbOld,$merchantKey);
    
    }
    function HmacMd5($data,$key)
    {
        # RFC 2104 HMAC implementation for php.
        # Creates an md5 HMAC.
        # Eliminates the need to install mhash to compute a HMAC
        # Hacked by Lance Rushing(NOTE: Hacked means written)
    
//         $key = iconv("GBK","UTF-8",$key);
//         $data = iconv("GBK","UTF-8",$data);
        $b = 64; # byte length for md5
        if (strlen($key) > $b) {
        $key = pack("H*",md5($key));
    }
    $key = str_pad($key, $b, chr(0x00));
    $ipad = str_pad('', $b, chr(0x36));
    $opad = str_pad('', $b, chr(0x5c));
        $k_ipad = $key ^ $ipad ;
    $k_opad = $key ^ $opad;
    
    return md5($k_opad . pack("H*",md5($k_ipad . $data)));
    
    }
    public function getCallBackValue(&$r0_Cmd,&$r1_Code,&$p1_MerId,&$p2_Order,&$p3_Amt,&$p4_FrpId,&$p5_CardNo,&$p6_confirmAmount,&$p7_realAmount,
        &$p8_cardStatus,&$p9_MP,&$pb_BalanceAmt,&$pc_BalanceAct,&$hmac)
    {
    
        $r0_Cmd = $_REQUEST['r0_Cmd'];
        $r1_Code = $_REQUEST['r1_Code'];
        $p1_MerId = $_REQUEST['p1_MerId'];
        $p2_Order = $_REQUEST['p2_Order'];
        $p3_Amt = $_REQUEST['p3_Amt'];
        $p4_FrpId = $_REQUEST['p4_FrpId'];
        $p5_CardNo = $_REQUEST['p5_CardNo'];
        $p6_confirmAmount = $_REQUEST['p6_confirmAmount'];
        $p7_realAmount = $_REQUEST['p7_realAmount'];
        $p8_cardStatus = $_REQUEST['p8_cardStatus'];
        $p9_MP = $_REQUEST['p9_MP'];
        $pb_BalanceAmt = $_REQUEST['pb_BalanceAmt'];
        $pc_BalanceAct = $_REQUEST['pc_BalanceAct'];
        $hmac = $_REQUEST['hmac'];
    
        return null;
    
    }
    
    
    public function CheckHmac($r0_Cmd,$r1_Code,$p1_MerId,$p2_Order,$p3_Amt,$p4_FrpId,$p5_CardNo,$p6_confirmAmount,$p7_realAmount,$p8_cardStatus,$p9_MP,$pb_BalanceAmt,
        $pc_BalanceAct,$hmac)
    {
        if($hmac==$this->getCallbackHmacString($r0_Cmd,$r1_Code,$p1_MerId,$p2_Order,$p3_Amt,
            $p4_FrpId,$p5_CardNo,$p6_confirmAmount,$p7_realAmount,$p8_cardStatus,$p9_MP,$pb_BalanceAmt,$pc_BalanceAct))
                return true;
            else
                return false;
    
    }
    public function annulCard($p2_Order,$p3_Amt,$p4_verifyAmt,$p5_Pid,$p6_Pcat,$p7_Pdesc,$p8_Url,$pa_MP,$pa7_cardAmt,$pa8_cardNo,$pa9_cardPwd,$pd_FrpId,$pz_userId,$pz1_userRegTime)
    {

    $p0_Cmd					= "ChargeCardDirect";

    $pr_NeedResponse	= "1";
    $hmac	= $this->getReqHmacString($p0_Cmd,$p2_Order,$p3_Amt,$p4_verifyAmt,$p5_Pid,$p6_Pcat,$p7_Pdesc,$p8_Url,$pa_MP,$pa7_cardAmt,$pa8_cardNo,$pa9_cardPwd,$pd_FrpId,$pr_NeedResponse,$pz_userId,$pz1_userRegTime);
    $params = array(
    'p0_Cmd'						=>	$p0_Cmd,
		'p1_MerId'					=>	Yii::$app->params['p1_MerId'],
		'p2_Order' 					=>	$p2_Order,
		'p3_Amt'						=>	$p3_Amt,
		'p4_verifyAmt'						=>	$p4_verifyAmt,
		'p5_Pid'						=>	$p5_Pid,
		'p6_Pcat'						=>	$p6_Pcat,
		'p7_Pdesc'						=>	$p7_Pdesc,
		'p8_Url'						=>	$p8_Url,
		'pa_MP'					  	=> 	$pa_MP,
		'pa7_cardAmt'				=>	$pa7_cardAmt,
		'pa8_cardNo'				=>	$pa8_cardNo,
		'pa9_cardPwd'				=>	$pa9_cardPwd,
		'pd_FrpId'					=>	$pd_FrpId,
		'pr_NeedResponse'		=>	$pr_NeedResponse,
		'hmac' 							=>	$hmac,
		'pz_userId'			=>	$pz_userId,
		'pz1_userRegTime' 		=>	$pz1_userRegTime
    );
    
    Yii::error(" hmac : ".$hmac);
    Yii::error(" url : ".Yii::$app->params['reqURL_SNDApro']);
    Yii::error("params : ".print_r($params,true));
    $querystring="";
    foreach ($params as $k => $v){
        $querystring.=urlencode($k)."=".urlencode($v)."&";
    }
    Yii::error("querystring ".$querystring);
    $pageContents = $this->postClient(Yii::$app->params['reqURL_SNDApro'], $querystring);
//     echo "pageContents:".$pageContents;
//     return $pageContents;
    if (!$pageContents)
        return false;
    Yii::error($pageContents);
    $result = explode("\n",$pageContents);

    $r0_Cmd	 =	"";							
    $r1_Code =	"";						
    $r2_TrxId =	"";					
    $r6_Order =	"";				
    $rq_ReturnMsg =	"";				
    $hmac =	"";					
    $unkonw = "";		

    $arr = [];
        for($index=0;$index<count($result);$index++){	
            $result[$index] = trim($result[$index]);
            if (strlen($result[$index]) == 0) {
                continue;
            }
            $aryReturn	= explode("=",$result[$index]);
        		$sKey	= $aryReturn[0];
        		$sValue	= $aryReturn[1];
        		if($sKey=="r0_Cmd"){				
        		    $r0_Cmd= $sValue;
        		}elseif($sKey == "r1_Code"){			      
        		    $r1_Code= $sValue;
        		}elseif($sKey == "r2_TrxId"){			       
        		    $r2_TrxId= $sValue;
        		}elseif($sKey == "r6_Order"){			      
        		    $r6_Order= $sValue;
        		}elseif($sKey == "rq_ReturnMsg"){
        		    iconv("GBK", "UTF-8", $sValue);
        		    Yii::error("rq_ReturnMsg : ".$sValue);	
        		  $rq_ReturnMsg= $sValue;
            	}elseif($sKey == "hmac"){	
            		$hmac=$sValue;
                } else{
                    return $result[$index];
                }
                $arr[$sKey]=$sValue;
        }


        $sbOld="";
        $sbOld = $sbOld.$r0_Cmd;
        $sbOld = $sbOld.$r1_Code;
        $sbOld = $sbOld.$r2_TrxId;
        $sbOld = $sbOld.$r6_Order;
        $sbOld = $sbOld.$rq_ReturnMsg;
        $sNewString = $this->HmacMd5($sbOld,Yii::$app->params['merchantKey']);
        if($sNewString==$hmac) {
            if($r1_Code=="1"){
                Yii::error("<br>充值成功 ".$rq_ReturnMsg);
                Yii::error("<br>系统订单号:".$r6_Order."<br>");
//                 return;
                } else if($r1_Code=="2"){
                Yii::error("<br>卡密成功处理过或者提交卡号过于频繁".$rq_ReturnMsg);
                Yii::error("<br>卡密成功处理过或者提交卡号过于频繁!");
//                     return;
                } 
                Yii::error("<br>充值hmac 校验成功");
                return $arr;
    	} else{
            Yii::error("<br>:".$sNewString);
    		Yii::error("<br>YeePay:".$hmac);
    		Yii::error("<br>");
//             exit;
        return false;
    	}
    }
    
    public function postClient($url,$post_data){//POST方法
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);//
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); // 从证书中检查SSL加密算法是否存在
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);// 使用自动跳转
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        $output = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Errno'.curl_error($ch);//捕抓异常
            Yii::error("http请求 结果异常: ".'Errno'.curl_error($ch));
            return false;
        }
        curl_close($ch);
        // 		var_dump($output);
        Yii::warning("http请求 结果: ".print_r($output,true));
//         $output=json_decode($output);
        return $output;
    }
    
    /**
     * 生成签名结果
     * @param $para_sort 已排序要签名的数组
     * return 签名结果字符串
     */
    function buildRequestMysign($para_sort) {
        //把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
        $prestr = $this->createLinkstring($para_sort);
        $mysign = "";
        //PHP5.3 版本以上 风控参数去斜杠
        $prestr =stripslashes($prestr);
        Yii::warning( "prestr 新的签名:".$prestr."\n", "llpay");
        switch (strtoupper(trim(Yii::$app->params['sign_type']))) {
            case "MD5" :
                $mysign = $this->md5Sign($prestr, Yii::$app->params['md5key']);
                Yii::warning( "MD5 mysign ".$mysign."\n", "llpay");
                break;
            case "RSA":
                $mysign = $this->Rsasign($prestr, Yii::$app->params['rsaPrivate_key']);
                Yii::warning( "RSA mysign ".$mysign."\n", "llpay");
                break;
            default :
                $mysign = "";
        }
//          Yii::warning( "签名:".$mysign."\n", "llpay");
        return $mysign;
    }
    
    /**
     * 生成要请求给连连支付的参数数组
     * @param $para_temp 请求前的参数数组
     * @return 要请求的参数数组
     */
    function buildRequestPara($para_temp) {
        //除去待签名参数数组中的空值和签名参数
        $para_filter = $this->paraFilter($para_temp);
        //对待签名参数数组排序
        $para_sort = $this->argSort($para_filter);
        //生成签名结果
        $mysign = $this->buildRequestMysign($para_sort);
        //签名结果与签名方式加入请求提交参数组中
        $para_sort['sign'] = $mysign;
        $para_sort['sign_type'] = strtoupper(trim(Yii::$app->params['sign_type']));
        foreach ($para_sort as $key => $value) {
            $para_sort[$key] = urlencode($value);
        }
        return urldecode(json_encode($para_sort));
    }
    
    /**
     * 生成要请求给连连支付的参数数组
     * @param $para_temp 请求前的参数数组
     * @return 要请求的参数数组字符串
     */
    public function buildRequestParaToString($para_temp) {
        //待请求参数数组
        $para = $this->buildRequestPara($para_temp);
    
        //把参数组中所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串，并对字符串做urlencode编码
        $request_data = $this->createLinkstringUrlencode($para);
    
        return $request_data;
    }
    /**
     * 建立请求，以模拟远程HTTP的POST请求方式构造并获取连连支付的处理结果
     * @param $para_temp 请求参数数组
     * @return 连连支付处理结果
     */
    function buildRequestHttp($para_temp) {
        $sResult = '';
    
        //待请求参数数组字符串
        $request_data = $this->buildRequestPara($para_temp);
    
        //远程获取数据
        $sResult = $this->getHttpResponsePOST($this->llpay_gateway_new, Yii::$app->params['cacert'], $request_data, trim(strtolower(Yii::$app->params['input_charset'])));
    
        return $sResult;
    }
    
    /**
     * 建立请求，以模拟远程HTTP的POST请求方式构造并获取连连支付的处理结果，带文件上传功能
     * @param $para_temp 请求参数数组
     * @param $file_para_name 文件类型的参数名
     * @param $file_name 文件完整绝对路径
     * @return 连连支付返回处理结果
     */
    function buildRequestHttpInFile($para_temp, $file_para_name, $file_name) {
    
        //待请求参数数组
        $para = $this->buildRequestPara($para_temp);
        $para[$file_para_name] = "@" . $file_name;
    
        //远程获取数据
        $sResult = $this->getHttpResponsePOST($this->llpay_gateway_new, Yii::$app->params['cacert'], $para, trim(strtolower(Yii::$app->params['input_charset'])));
    
        return $sResult;
    }
    
    /**
     * 用于防钓鱼，调用接口query_timestamp来获取时间戳的处理函数
     * 注意：该功能PHP5环境及以上支持，因此必须服务器、本地电脑中装有支持DOMDocument、SSL的PHP配置环境。建议本地调试时使用PHP开发软件
     * return 时间戳字符串
     */
    function query_timestamp() {
        $url = $this->llpay_gateway_new . "service=query_timestamp&partner=" . trim(strtolower(Yii::$app->params['partner'])) . "&_input_charset=" . trim(strtolower(Yii::$app->params['input_charset']));
        $encrypt_key = "";
    
        $doc = new DOMDocument();
        $doc->load($url);
        $itemEncrypt_key = $doc->getElementsByTagName("encrypt_key");
        $encrypt_key = $itemEncrypt_key->item(0)->nodeValue;
    
        return $encrypt_key;
    }
    /**
     * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
     * @param $para 需要拼接的数组
     * return 拼接完成以后的字符串
     */
    function createLinkstring($para) {
        $arg  = "";
        foreach ($para as $key=>$val)
        {
            $arg.=$key."=".$val."&";
        }
        //去掉最后一个&字符
        $arg = substr($arg,0,count($arg)-2);
        //file_put_contents("log.txt","转义前:".$arg."\n", FILE_APPEND);
        //如果存在转义字符，那么去掉转义
        if(get_magic_quotes_gpc()){$arg = stripslashes($arg);}
        //file_put_contents("log.txt","转义后:".$arg."\n", FILE_APPEND);
        return $arg;
    }
    /**
     * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串，并对字符串做urlencode编码
     * @param $para 需要拼接的数组
     * return 拼接完成以后的字符串
     */
    function createLinkstringUrlencode($para) {
        $arg  = "";
        foreach (json_decode($para) as $key=>$val)
        {
            $arg.=$key."=".urlencode($val)."&";
        }
        //去掉最后一个&字符
        $arg = substr($arg,0,count($arg)-2);
    
        //如果存在转义字符，那么去掉转义
        if(get_magic_quotes_gpc()){$arg = stripslashes($arg);}
    
        return $arg;
    }
    /**
     * 除去数组中的空值和签名参数
     * @param $para 签名参数组
     * return 去掉空值与签名参数后的新签名参数组
     */
    function paraFilter($para) {
        $para_filter = array();
        foreach ($para as $key=>$val)
        {
            if($key == "sign" || $val == "")continue;
            else	$para_filter[$key] = $para[$key];
        }
        return $para_filter;
    }
    /**
     * 对数组排序
     * @param $para 排序前的数组
     * return 排序后的数组
     */
    function argSort($para) {
        ksort($para);
        reset($para);
        return $para;
    }
    /**
     * 写日志，方便测试（看网站需求，也可以改成把记录存入数据库）
     * 注意：服务器需要开通fopen配置
     * @param $word 要写入日志里的文本内容 默认值：空值
     */
    function logResult($word='') {
        $fp = fopen("log.txt","a");
        flock($fp, LOCK_EX) ;
        fwrite($fp,"执行日期：".strftime("%Y%m%d%H%M%S",time())."\n".$word."\n");
        flock($fp, LOCK_UN);
        fclose($fp);
    }
    
    /**
     * 远程获取数据，POST模式
     * 注意：
     * 1.使用Crul需要修改服务器中php.ini文件的设置，找到php_curl.dll去掉前面的";"就行了
     * 2.文件夹中cacert.pem是SSL证书请保证其路径有效，目前默认路径是：getcwd().'\\cacert.pem'
     * @param $url 指定URL完整路径地址
     * @param $cacert_url 指定当前工作目录绝对路径
     * @param $para 请求的数据
     * @param $input_charset 编码格式。默认值：空值
     * return 远程输出的数据
     */
    function getHttpResponsePOST($url, $cacert_url, $para, $input_charset = '') {
    
        if (trim($input_charset) != '') {
            $url = $url."_input_charset=".$input_charset;
        }
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);//SSL证书认证
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);//严格认证
        curl_setopt($curl, CURLOPT_CAINFO,$cacert_url);//证书地址
        curl_setopt($curl, CURLOPT_HEADER, 0 ); // 过滤HTTP头
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, 1);// 显示输出结果
        curl_setopt($curl,CURLOPT_POST,true); // post传输数据
        curl_setopt($curl,CURLOPT_POSTFIELDS,$para);// post传输数据
        $responseText = curl_exec($curl);
        //var_dump( curl_error($curl) );//如果执行curl过程中出现异常，可打开此开关，以便查看异常内容
        curl_close($curl);
    
        return $responseText;
    }
    
    /**
     * 远程获取数据，GET模式
     * 注意：
     * 1.使用Crul需要修改服务器中php.ini文件的设置，找到php_curl.dll去掉前面的";"就行了
     * 2.文件夹中cacert.pem是SSL证书请保证其路径有效，目前默认路径是：getcwd().'\\cacert.pem'
     * @param $url 指定URL完整路径地址
     * @param $cacert_url 指定当前工作目录绝对路径
     * return 远程输出的数据
     */
    function getHttpResponseGET($url,$cacert_url) {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, 0 ); // 过滤HTTP头
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, 1);// 显示输出结果
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);//SSL证书认证
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);//严格认证
        curl_setopt($curl, CURLOPT_CAINFO,$cacert_url);//证书地址
        $responseText = curl_exec($curl);
        //var_dump( curl_error($curl) );//如果执行curl过程中出现异常，可打开此开关，以便查看异常内容
        curl_close($curl);
    
        return $responseText;
    }
    
    /**
     * 实现多种字符编码方式
     * @param $input 需要编码的字符串
     * @param $_output_charset 输出的编码格式
     * @param $_input_charset 输入的编码格式
     * return 编码后的字符串
     */
    function charsetEncode($input,$_output_charset ,$_input_charset) {
        $output = "";
        if(!isset($_output_charset) )$_output_charset  = $_input_charset;
        if($_input_charset == $_output_charset || $input ==null ) {
            $output = $input;
        } elseif (function_exists("mb_convert_encoding")) {
            $output = mb_convert_encoding($input,$_output_charset,$_input_charset);
        } elseif(function_exists("iconv")) {
            $output = iconv($_input_charset,$_output_charset,$input);
        } else die("sorry, you have no libs support for charset change.");
        return $output;
    }
    /**
     * 实现多种字符解码方式
     * @param $input 需要解码的字符串
     * @param $_output_charset 输出的解码格式
     * @param $_input_charset 输入的解码格式
     * return 解码后的字符串
     */
    function charsetDecode($input,$_input_charset ,$_output_charset) {
        $output = "";
        if(!isset($_input_charset) )$_input_charset  = $_input_charset ;
        if($_input_charset == $_output_charset || $input ==null ) {
            $output = $input;
        } elseif (function_exists("mb_convert_encoding")) {
            $output = mb_convert_encoding($input,$_output_charset,$_input_charset);
        } elseif(function_exists("iconv")) {
            $output = iconv($_input_charset,$_output_charset,$input);
        } else die("sorry, you have no libs support for charset changes.");
        return $output;
    }
    
    //格式化时间戳
    function local_date($format, $time = NULL)
    {
        if ($time === NULL)
        {
            $time = gmtime();
        }
        elseif ($time <= 0)
        {
            return '';
        }
        return date($format, $time);
    }
    
    
    function getJsonVal($json, $k){
        if(isset($json->{$k})){
            return trim($json->{$k});
        }
        return "";
    }
    
    /**
     * 验证签名
     * @param $prestr 需要签名的字符串
     * @param $sign 签名结果
     * @param $key 私钥
     * return 签名结果
     */
    public function md5Verify($prestr, $sign, $key) {
        $prestr = $prestr ."&key=". $key;
        Yii::warning("prestr:".$prestr."\n", "llpay");
        $mysgin = md5($prestr);
        Yii::warning( "mysgin:".$mysgin."\n", "llpay");
        if($mysgin == $sign) {
            return true;
        }
        else {
            return false;
        }
    }
    /**
     * 签名字符串
     * @param $prestr 需要签名的字符串
     * @param $key 私钥
     * return 签名结果
     */
    function md5Sign($prestr, $key) {
        $prestr = $prestr ."&key=". $key;
        Yii::warning("签名原串 :".$prestr."\n", "llpay");
        return md5($prestr);
    }
    /**RSA签名
     * $data签名数据(需要先排序，然后拼接)
     * 签名用商户私钥，必须是没有经过pkcs8转换的私钥
     * 最后的签名，需要用base64编码
     * return Sign签名
     */
    function Rsasign($data) {
        //读取私钥文件
        $priKey = file_get_contents(Yii::$app->params['pkPath']);
        Yii::warning("prikey read: ".$priKey,'llpay');
        //转换为openssl密钥，必须是没有经过pkcs8转换的私钥
        $res = openssl_get_privatekey($priKey);
    
        //调用openssl内置签名方法，生成签名$sign
        openssl_sign($data, $sign, $res,OPENSSL_ALGO_MD5);
    
        //释放资源
        openssl_free_key($res);
    
        //base64编码
        $sign = base64_encode($sign);
        Yii::warning( "签名原串:".$data."\n", 'llpay');
        return $sign;
    }
    
    /********************************************************************************/
    
    /**RSA验签
     * $data待签名数据(需要先排序，然后拼接)
     * $sign需要验签的签名,需要base64_decode解码
     * 验签用连连支付公钥
     * return 验签是否通过 bool值
     */
    function Rsaverify($data, $sign)  {
        //读取连连支付公钥文件
        $pubKey = file_get_contents(Yii::$app->params['publicKeyPath']);
        Yii::warning("pubKey read: ".$pubKey,'llpay');
        //转换为openssl格式密钥
        $res = openssl_get_publickey($pubKey);
        //调用openssl内置方法验签，返回bool值
        $result = (bool)openssl_verify($data, base64_decode($sign), $res,OPENSSL_ALGO_MD5);
        //释放资源
        openssl_free_key($res);
        //返回资源是否成功
        return $result;
    }
    
    /**
     * 获取返回时的签名验证结果
     * @param $para_temp 通知返回来的参数数组
     * @param $sign 返回的签名结果
     * @return 签名验证结果
     */
    public function getSignVeryfy($para_temp, $sign) {
        //除去待签名参数数组中的空值和签名参数
        $para_filter = $this->paraFilter($para_temp);
    
        //对待签名参数数组排序
        $para_sort = $this->argSort($para_filter);
    
        //把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
        $prestr = $this->createLinkstring($para_sort);
    
        // file_put_contents("log.txt", "原串:" . $prestr . "\n", FILE_APPEND);
        // file_put_contents("log.txt", "sign:" . $sign . "\n", FILE_APPEND);
        $isSgin = false;
        switch (strtoupper(trim(Yii::$app->params['sign_type']))) {
            case "MD5" :
                $isSgin = $this->md5Verify($prestr, $sign, Yii::$app->params['md5key']);
                break;
            default :
                $isSgin = false;
        }
    
        return $isSgin;
    }
}