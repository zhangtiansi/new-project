<?php
namespace app\components;

class smsbao{
	private $smsapi;
	private $charset;
	private $user;
	private $pass;
	
	function __construct(){
		$this->smsapi = "api.smsbao.com"; //短信网关
		$this->charset = "utf8"; //文件编码
		$this->user = "hzyfs"; //短信平台帐号
		$this->pass = md5("zhulei1"); //短信平台密码
	}
	public function query(){
		$sendUrl='http://www.smsbao.com/query?u='.$this->user.'&p='.$this->pass;
		$res=$this->getSimpleClient($sendUrl);
		return $res;
	}
	
	public function sentSms($phone,$content)
	{
		$sendurl = "http://".$this->smsapi."/sms?u=".$this->user."&p=".$this->pass."&m=".$phone."&c=".urlencode($content);
		$res=$this->getClient($sendurl);
// 		$res=$this->getClient($sendurl);
		return $res;
	}	
	protected   function getSimpleClient($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);//
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);// 使用自动跳转
		curl_setopt($ch, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
		$output = curl_exec($ch);
		if (curl_errno($ch)) {
			echo 'Errno'.curl_error($ch);//捕抓异常
			return;
		}
		curl_close($ch);
		// 		var_dump($output);
		// 		print_r($output);
// 		$output=json_decode($output);
		return $output;
	}
	
	public  function getClient($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);//
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);// 使用自动跳转
		curl_setopt($ch, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
		$output = curl_exec($ch);
		if (curl_errno($ch)) {
			echo 'Errno'.curl_error($ch);//捕抓异常
			return;
		}
		curl_close($ch);
		// 		var_dump($output);
		// 		print_r($output);
		$output=json_decode($output);
		return $output;
	}
	

}