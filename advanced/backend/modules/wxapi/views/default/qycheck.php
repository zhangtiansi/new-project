<?php

use app\components\WXBizMsgCrypt;
use app\components\wechat;

$encodingAesKey = "eJdG3Uyenqsry9YjnMnbJnY3BTERfnqXIP5bY1Ex42q";
$token = "I7H1cF";
$corpId = "wxe5c9ce4af07f638e";

/*
------------使用示例一：验证回调URL---------------
*企业开启回调模式时，企业号会向验证url发送一个get请求 
假设点击验证时，企业收到类似请求：
* GET /cgi-bin/wxpush?msg_signature=5c45ff5e21c57e6ad56bac8758b79b1d9ac89fd3&timestamp=1409659589&nonce=263014780&echostr=P9nAzCzyDtyTWESHep1vC5X9xho%2FqYX3Zpb4yKa9SKld1DsH3Iyt3tP3zNdtp%2B4RPcs8TgAE7OaBO%2BFZXvnaqQ%3D%3D 
* HTTP/1.1 Host: qy.weixin.qq.com

接收到该请求时，企业应
1.解析出Get请求的参数，包括消息体签名(msg_signature)，时间戳(timestamp)，随机数字串(nonce)以及公众平台推送过来的随机加密字符串(echostr),
这一步注意作URL解码。
2.验证消息体签名的正确性 
3. 解密出echostr原文，将原文当作Get请求的response，返回给公众平台
第2，3步可以用公众平台提供的库函数VerifyURL来实现。

*/

$sVerifyMsgSig = Yii::$app->getRequest()->getQueryParam("msg_signature");
// $sVerifyMsgSig = "5c45ff5e21c57e6ad56bac8758b79b1d9ac89fd3";
$sVerifyTimeStamp = Yii::$app->getRequest()->getQueryParam("timestamp");
// $sVerifyTimeStamp = "1409659589";
$sVerifyNonce = Yii::$app->getRequest()->getQueryParam("nonce");
// $sVerifyNonce = "263014780";
$sVerifyEchoStr = Yii::$app->getRequest()->getQueryParam("echostr");
// $sVerifyEchoStr = "P9nAzCzyDtyTWESHep1vC5X9xho/qYX3Zpb4yKa9SKld1DsH3Iyt3tP3zNdtp+4RPcs8TgAE7OaBO+FZXvnaqQ==";

// 需要返回的明文
$EchoStr = "";

$wxcpt = new WXBizMsgCrypt($token, $encodingAesKey, $corpId);
if ($sVerifyEchoStr !=""){
    Yii::error('wxapi echo str api ','wxapi');
    //带echostr时为接口验证，没有则为普通消息
    $errCode = $wxcpt->VerifyURL($sVerifyMsgSig, $sVerifyTimeStamp, $sVerifyNonce, $sVerifyEchoStr, $EchoStr);
    // Yii::log(print_r($errCode,true),'error');
    if ($errCode == 0) {
    	//
    	// 验证URL成功，将sEchoStr返回
    	echo $EchoStr;
        Yii::error('recieve msg check suc .code == 0 EchoStr is : '.$EchoStr,'wxapi');
    } else {
        Yii::error('sig check failed '.$errCode,'wxapi');
        print("ERR: " . $errCode . "\n\n");
    }
}else {
    Yii::error('wxapi not echo str api ','wxapi');
    if (isset($GLOBALS["HTTP_RAW_POST_DATA"])){
        $postStr=($GLOBALS["HTTP_RAW_POST_DATA"]);
        //$weixin = new weixin($postStr);
        //$weixin->SavePost();
        $sMsg = "";  // 解析之后的明文
        
        $errCode = $wxcpt->DecryptMsg($sVerifyMsgSig, $sVerifyTimeStamp, $sVerifyNonce, $postStr, $sMsg);
        if ($errCode == 0) {
        	// 解密成功，sMsg即为xml格式的明文
        	// TODO: 对明文的处理
        	// For example:
        	/***
        	$xml = new DOMDocument();
        	$xml->loadXML($sMsg);
        	Yii::error("xml: " . print_r($xml,true) . "\n\n");
        	$touser = $xml->getElementsByTagName('ToUserName')->item(0)->nodeValue;
        	$fromuser = $xml->getElementsByTagName('FromUserName')->item(0)->nodeValue;
        	$ctime = $xml->getElementsByTagName('CreateTime')->item(0)->nodeValue;
        	$msgtype = $xml->getElementsByTagName('MsgType')->item(0)->nodeValue;
        	$agentid = $xml->getElementsByTagName('AgentID')->item(0)->nodeValue;
        	if ($msgtype == "text"){
        	   $content = $xml->getElementsByTagName('Content')->item(0)->nodeValue;
        	}else {
        	   $content = "您好，消息类型：".$msgtype." \n FromUser：".$fromuser." Ctime: ".$ctime." 员工编号： ".$agentid;
        	}
        	
        	$sRespData = "<xml><ToUserName><![CDATA[mycreate]]></ToUserName><FromUserName><![CDATA[wx5823bf96d3bd56c7]]></FromUserName><CreateTime>1348831860</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[".$content."]]></Content><MsgId>1234567890123456</MsgId><AgentID>128</AgentID></xml>";
        	
        	**/
            Yii::error("sMsg: " . $sMsg . "\n\n ");
            $wechat = new wechat($sMsg);
//             $wechat->saveModel();
            $sRespData = $wechat->responseMsg();
            
        	$sEncryptMsg = ""; //xml格式的密文
        	$errCode = $wxcpt->EncryptMsg($sRespData, $sVerifyTimeStamp, $sVerifyNonce, $sEncryptMsg);
        	if ($errCode == 0) {
        	    // TODO:
        	    // 加密成功，企业需要将加密之后的sEncryptMsg返回
        	    // HttpUtils.SetResponce($sEncryptMsg);  //回复加密之后的密文
        	    Yii::error(' response :'.$sEncryptMsg,'wxapi');
        	    echo $sEncryptMsg;
        	} else {
        	    print("ERR: " . $errCode . "\n\n");
        	    // exit(-1);
        	}
        	
        	// ...
        	// ...
        } else {
            Yii::error("ERR: " . $errCode . "\n\n",'wxapi');
        	print("ERR: " . $errCode . "\n\n");
        	//exit(-1);
        }
    }else {
        //$postStr="";
        Yii::error('no post data ','wxapi');
//         echo $EchoStr;
    }

}
