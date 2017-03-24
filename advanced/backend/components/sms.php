<?php
namespace app\components;
use yii;
class sms {
	private $AppId;
	private $AppSecret;
	private $templateid;
	private $tokenPath;
	//private $tokenAPI = "https://oauth.api.189.cn/emp/oauth2/v2/access_token";
	private $tokenUrl="https://oauth.api.189.cn/emp/oauth2/v2/access_token";
	private $smsUrl="http://api.189.cn/v2/emp/templateSms/sendSms";
	private $smsStatus="http://api.189.cn/v2/EMP/nsagSms/appnotify/querysmsstatus";
	public function __construct()
	{
		$this->AppId=Yii::$app->params['smsAppId'];
		$this->AppSecret=Yii::$app->params['smsAppSecret'];
		$this->templateid=Yii::$app->params['smsCkTemplateId'];
		$this->tokenPath=Yii::$app->params['smsToken'];
	}
	
	public function __destruct()
	{
			
	}
	
	public function sendSms($phone,$content){
		echo $phone;echo $content;	
	}
	
	public function sendTemplateSms($userTel,$param1,$param2,$param3,$param4)
	{
		$params=array("param1"=>$param1,"param2"=>$param2,"param3"=>$param3,'param4'=>$param4);
		$postdata=array();
		$postdata['app_id']="app_id=".$this->AppId;
		$postdata['access_token']="access_token=".$this->getToken();
		$postdata['acceptor_tel']="acceptor_tel=".$userTel;
		$postdata['template_id']="template_id=".$this->templateid;
		$postdata['template_param']="template_param=".json_encode($params);
		$postdata['timestamp']="timestamp=".date('Y-m-d H:i:s');
		ksort($postdata);
		$plaintext = implode("&",$postdata);
		$postdata['sign'] =  "sign=".rawurlencode(base64_encode(hash_hmac("sha1", $plaintext, $this->AppSecret, $raw_output=True)));
		ksort($postdata);
		$datastr=implode("&",$postdata);
		//echo "post data str: ".$datastr."<br>";
		//正式时调用接口
		$sendRes=$this->curl_post($this->smsUrl,$datastr);
		$sendRes=json_decode($sendRes);
		return $sendRes;
	}
	
	public function ChkSmsStatus($identifier)
	{
		$postdata=array();
		$postdata['app_id']="app_id=".$this->AppId;
		$postdata['access_token']="access_token=".$this->getToken();
		$postdata['timestamp']="timestamp=".date('Y-m-d H:i:s');
		$postdata['identifier']="identifier=".$identifier;
		ksort($postdata);
		$plaintext = implode("&",$postdata);
		$postdata['sign'] =  "sign=".rawurlencode(base64_encode(hash_hmac("sha1", $plaintext, $this->AppSecret, $raw_output=True)));
		ksort($postdata);
		$datastr=implode("&",$postdata);
		$sendRes=$this->curl_post($this->smsStatus,$datastr);
		$sendRes=json_decode($sendRes);
		print_r($sendRes);
	}
	
	
	public function getToken()//获取令牌
	{
		$tokenstr=file_get_contents($this->tokenPath);
		$tokenar=explode('|', $tokenstr);
		if (count($tokenar) == "2" ) {//没有过期令牌
			$expireTime=$tokenar[0];
			$token=$tokenar[1];
			if ($expireTime > time() ) {//时间未过期
				return $token;
			}
		}
		$newTokenArr=$this->refreshToken('client_credentials');//重新获取令牌
		if ($newTokenArr['res_code']==0) {//请求成功
			$newExpire=$newTokenArr['expires_in']+time()-30;//过期时间戳，预留30秒缓冲
			$newToken=$newTokenArr['access_token'];
			$newTokenStr=$newExpire."|".$newToken;
			file_put_contents($this->tokenPath, $newTokenStr);
			return $newToken;
		}
	}
	
	public function refreshToken($grant_type,$refreshtoken="")//获取令牌
	{
		//echo $this->AppId." ".$this->AppSecret." ".$grant_type;
		$send = 'app_id='.$this->AppId.'&app_secret='.$this->AppSecret.'&grant_type='.$grant_type;
		if($grant_type=="refresh_token")
			$send .='&refresh_token='.$refreshtoken;
		//echo $send;
		$access_token = $this->curl_post($this->tokenUrl, $send);
		//var_dump($access_token);
		$access_token = json_decode($access_token, true);
		return $access_token;
		//print_r($access_token);
		//Array ( [res_code] => 0 [res_message] => Success [access_token] => cf64e7a819bd08f2771ab739e8af59a01396405814990 [expires_in] => 2580696 )
		if($grant_type=="refresh_token")
		{
			echo "Access_Token has been refreshed!";
			echo "<br/>The latest Access_Token is ".$access_token['access_token'];
		}
	}
	private function curl_post($url='', $postdata='', $options=array()){
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
		curl_setopt($ch, CURLOPT_TIMEOUT, 5);
		if (!empty($options)){
			curl_setopt_array($ch, $options);
		}
		$data = curl_exec($ch);
		if (curl_errno($ch)) {
			echo 'Errno ：'.curl_error($ch);//捕抓异常
			echo '<br>url: '.$url;
			echo '<br>data: '.$postdata;
			return;
		}
		curl_close($ch);
		return $data;
	}
}
