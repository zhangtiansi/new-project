<?php
namespace app\components;
use Yii;
class yeepay{
    
    public function getReqHmacString($p0_Cmd,$p2_Order,$p3_Amt,$p4_verifyAmt,$p5_Pid,$p6_Pcat,$p7_Pdesc,$p8_Url,$pa_MP,$pa7_cardAmt,$pa8_cardNo,$pa9_cardPwd,$pd_FrpId,$pr_NeedResponse,$pz_userId,$pz1_userRegTime)
    {
    
        $merchantKey = Yii::$app->params['merchantKey_niu'];
        $sbOld		=	"";
        $sbOld		=	$sbOld.$p0_Cmd;
        $sbOld		=	$sbOld.Yii::$app->params['p1_MerId_niu'];
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
    
        $merchantKey = Yii::$app->params['merchantKey_niu'];
    
        $sbOld="";
        $sbOld = $sbOld.$r0_Cmd;
        $sbOld = $sbOld.$r1_Code;
        $sbOld = $sbOld.Yii::$app->params['p1_MerId_niu'];
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
            'p1_MerId'					=>	Yii::$app->params['p1_MerId_niu'],
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
    $sNewString = $this->HmacMd5($sbOld,Yii::$app->params['merchantKey_niu']);
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
}