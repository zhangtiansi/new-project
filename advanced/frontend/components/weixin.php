<?php 
//微信调用类
namespace app\components;
use yii;
use app\models\GmWechatInfo;
class weixin {
	private $token;
	private $url;
	private $grant_type;
	private $appid;
	private $secret;
	private $webTokenPath;
	private $timePath;
	private $webToken;
	private $expireTime;
	public  $fromUsername;//来源用户openid
	public  $toUsername;//公众平台ID
	public  $MsgType;//消息类型
	public  $content;//文本消息内容
	public  $msgid;//消息ID
	public  $event;//事件subscribe、unsubscribe、click
	public  $eventkey;//event为click时有
	public  $picUrl;//msgtype为image时imageURL
	public  $format;//msgtype为vedio时有，媒体格式
	public  $mediaId;//媒体ID
	public  $location_X;//msgtype=location时纬度坐标
	public  $location_Y;
	public  $scale;//缩放
	public  $Label;//描述
	private $openurl;
	
	public function __construct($postStr)
	{
		$this->grant_type="client_credential";//获取access_token填写client_credential
		$this->token=Yii::$app->params['wechattoken'];//token
		$this->appid=Yii::$app->params['wechatappid'];//appid
		$this->secret=Yii::$app->params['wechatsecret'];//secret
		$this->webTokenPath=Yii::$app->params['wechatwebTokenPath'];//webtoken的路径
		$this->timePath=Yii::$app->params['wechattimePath'];//过期时间
		$this->openurl=Yii::$app->params['wechatopenurl'];
 		if (isset($postStr) && $postStr != ""){
 			Yii::error($postStr);
			$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
			//print_r($postObj);
// 			echo $postObj->FromUserName;
// 			echo $postObj->MsgType;
// 			echo "||||||||";
			$this->fromUsername = $this->DelNullData($postObj->FromUserName);
			$this->toUsername = $this->DelNullData($postObj->ToUserName);
			$this->MsgType = $this->DelNullData($postObj->MsgType);
			$this->content = $this->DelNullData($postObj->Content);
			$this->msgid = $this->DelNullData($postObj->Msgid);
			$this->event = $this->DelNullData($postObj->Event);
			$this->eventkey = $this->DelNullData($postObj->EventKey);
			$this->picUrl = $this->DelNullData($postObj->PicUrl);
			$this->format = $this->DelNullData($postObj->Format);
			$this->mediaId = $this->DelNullData($postObj->MediaId);
			if ($postObj->Latitude != "" && $postObj->Longitude != "") {
				$this->location_X=$postObj->Latitude;
				$this->location_Y=$postObj->Longitude;
			}else {
				$this->location_X = $this->DelNullData($postObj->Location_X);
				$this->location_Y = $this->DelNullData($postObj->Location_Y);
			}
			$this->scale = $this->DelNullData($postObj->Scale);
			$this->Label = $this->DelNullData($postObj->Label);
		}
	}
	
	
	
	//析构函数
	public function __destruct()
	{
		 
	}
	
	private function DelNullData($data)
	{
		if ($data->isempty) {
			return " ";
		}else {
			return trim($data);
		}
	}
	
	/*
	 * 事件处理方法
	 * 
	 * 
	 */
	public function responseMsg($contentStr="")
	{
		if ($this->MsgType=="text"){//文本消息
			$keyword=$this->content;
		}elseif ($this->MsgType=="event"){
			$keyword=$this->eventkey;
		}else {
			$keyword="";
		}
		
		$arr_reply=WeixinResponseCfg::model()->findByAttributes(array('msgtype'=>$this->MsgType,'keyword'=>$keyword));
		if ($this->MsgType=="image"){//图片
			//$con="上传图片成功";
			echo $this->creat_xml_response($contentStr);
// 			echo "GET images!! you have n pic  to upload.";
		}elseif (is_object($arr_reply) && $arr_reply->replytype=="text"){
						$contentArr=explode('|', $arr_reply->replycontent);
						$extStr="";
						if (count($contentArr) > 1){
							foreach ($contentArr as $k=>$strpis){
								$last=count($contentArr)-1;
								if ($strpis !="" && $k != $last ){
									$extStr.="  ".$strpis;
									$extStr.="。\n";
								}else {
									$extStr.=$strpis;
								}
							}
						}else {
							$extStr.=$arr_reply->replycontent;
						}
						$contentStr=$extStr." ".$contentStr;
						echo $this->creat_xml_response($contentStr);
		}elseif(is_object($arr_reply) && $arr_reply->replytype=="news"){//2014.04.28修改支持多个图文
						$reply_arr=explode('|', $arr_reply->replycontent);
						if (count($reply_arr)>1){//多个图文
								//echo count($reply_arr);
// 								Yii::error('reply news:','error');
// 								Yii::error($this->creat_mutil_news_response($reply_arr),'error');
								echo $this->creat_mutil_news_response($reply_arr);
						}else{
								$reply_arr=explode(';', $arr_reply->replycontent);
								//$userinfo=UserBaseInfo::model()->findByAttributes(array('openid'=>$this->fromUsername));
								echo $this->creat_news_response($reply_arr[0], $reply_arr[1], $reply_arr[2], $reply_arr[3]);
								//Yii::error($this->creat_news_response($reply_arr[0], $reply_arr[1], $reply_arr[2], isset($pushurl)?$pushurl:$reply_arr[3]),'error');
							}

		}elseif($this->eventkey=="login"){
						$userid=$this->CreateUserInfo($this->fromUsername);
						echo $this->creat_img_welcome_response($this->fromUsername, $userid);
		}else{
			echo $this->create_cust_msg();
			//$contentStr="";
			//			echo $this->creat_xml_response($contentStr);
// 						$userid=$this->CreateUserInfo($this->fromUsername);
// 						echo $this->creat_img_welcome_response($this->fromUsername, $userid);
		}	
	}
	
	/**
	 * 保存post 日志
	 */
	public  function SavePost()
	{
		$model=new WeixinPostLog;
		//$arr_post=array();
		$model->fromuser =$this->fromUsername;
		$model->msgtype=$this->MsgType;
		$model->event=$this->event or "0";
		$model->eventkey=$this->eventkey or "0";
		$model->content=$this->content or "0";
		$model->picUrl=$this->picUrl or "0";
		$model->format=$this->format or "0";
		$model->mediaId=$this->mediaId or "0";
		$model->location_x=$this->location_X or "0";
		$model->location_y=$this->location_Y or "0";
		$model->scale=$this->scale or "0";
		$model->label=$this->Label or "0";
		//Yii::error($model->event,'error');
		if($this->event=="subscribe"){
			//Yii::error('subscribe ........','error');
			if ($model->save()){
				$userid=$this->CreateUserInfo($this->fromUsername);
				//$userid=$this->CreateUserInfoTest($this->fromUsername);
				echo $this->creat_img_welcome_response($this->fromUsername, $userid);
			}
			return ;
		}
		
		$contentStr="";
		if ($this->MsgType=="image"){//上传图片时
			//do save images
			$uname=$this->encrypt($this->fromUsername);
			$uname=substr($uname, 1,9);
			$imageName=time()."_".$uname.".jpg";
			//echo time();
			//echo $imageName;
			$imagePath=Yii::$app->params['gpPath'].$imageName;
// 			echo $this->picUrl;
// 			echo $imagePath;
			if($this->getImages($this->picUrl, $imagePath))
			{
				Yii::error(" pic saved");
				$model->content=$imageName;
				$userinfo=UserBaseInfo::model()->findByAttributes(array('openid'=>$this->fromUsername));
				if (isset($userinfo)&& isset($userinfo->id)){
					$model_pics=new ShUserPics();
					$model_pics->userid=$userinfo->id;
					$model_pics->pic_name=$imageName;
					//做上传的限制配置
					if (is_object(ShUserPics::model()->findByAttributes(array('userid'=>$userinfo->id,'is_del'=>0)))){
						$count=ShUserPics::model()->countByAttributes(array('userid'=>$userinfo->id,'is_del'=>0));
					}else {
						$count=0;
					}
					//$limit=80;
					$limit=UserBaseInfo::model()->getLimit($userinfo->id, 'pic_num');
					Yii::error('user'.$userinfo->id.' pic limit :'.$limit);
					//$limit=PageInfo::model()->findByAttributes(array('page_key'=>'max_images'))->page_value;
					if ($limit==0 || $count<$limit){//可以上传
						//2014.07.07加入水印设置
						$shopinfo=ShShopInfo::model()->findByAttributes(array('userid'=>$userinfo->id));
						if (is_object($shopinfo)){
							$iswatermark=$shopinfo->watermarks;
							if ($iswatermark==1){//需要水印
								$dst_path = $imagePath;
								$water_path=Yii::$app->params['gpPath'].'watermarks/'.$imageName;
								//$dst_im=imagecreatefromjpeg($dst_path);
								//imagejpeg($dst_im,$water_path);
								$avatar_path=Yii::$app->params['upPath'].$userinfo->id.'.jpeg';
								if (!file_exists($avatar_path)){
									$avatar_path=Yii::$app->params['upPath'].'default.jpeg';
								}
								Yii::error(' path : '.$avatar_path,'error');
								Yii::error(' path : '.$dst_path,'error');
								$small_path=Yii::$app->params['upPath'].'small/'.$userinfo->id.'.jpeg';
								if (!file_exists($small_path)){
									$small=new SimpleImage();
									$small->load($avatar_path);
									$small->resize(50, 50);
									$small->save($small_path);
								}
									
								$img=new SimpleImage;
								$img->load($dst_path);
								//Yii::error('get width:'.$img->getWidth().' height:'.$img->getHeight(),'error');
								// 							if ($dst_w==1280 && $dst_h==960){
								// 								$img->round_once();
								// 								$x=$dst_h-30;
								// 								$y=$dst_w-200;
								// 							}
								$img->resizeToWidth('600');
								$dst_w=$img->getWidth();
								$dst_h=$img->getHeight();
								$x=90;
								$y=$dst_h-30;
								Yii::error('img w : '.$dst_w.' img h:'.$dst_h,'error');
								$img->watermark($userinfo->nick, 25, $x, $y);
								$img->save($dst_path);
									
								$dst_im=imagecreatefromjpeg($dst_path);
								$src_im=imagecreatefromjpeg($small_path);
									
								imagecopymerge($dst_im, $src_im, 30, $y-40, 0, 0, 50, 50, 80);
								imagejpeg($dst_im,$dst_path);
							}
						}
						if($model_pics->save()){
							if ($limit==0){
								$contentStr="/::P 照片上传成功：\r\n您可以继续上传图片";
							}else {
								$count=$count+1;//新上传+1
								$last=$limit-$count;
								$contentStr="/::P 照片上传成功：\r\n您可以继续上传".$last."张图片";
							}
						}else{
							Yii::error("save pic model failed",'error');
						}
						Yii::error("find userinfo for pics,var pic model suc",'error');
					}else{//超出限制
						$contentStr="照片超出限制，请到【首页-设置-查看所有照片】\r\n中删除一些再上传，或者升级成为高级会员，即可不受限制";
					}
				}else {
					Yii::error("not find userinfo for pics ".$model->content,'error');
				}
				
			}
			
		}elseif($this->MsgType == "event" && $this->event=="LOCATION"){
			if ($model->save()){
				return ;
			}
			return ;
		}
		if ($model->save())
		{ 
// 			Yii::error(json_encode($model->attributes),'error' );
// 			Yii::error("save  model suc",'error');
			$this->responseMsg($contentStr);
		}else {
			//print_r($model->errors);
// 			Yii::error(json_encode($model->attributes),'error' );
// 			Yii::error(var_dump($model->errors),'error');
// 			Yii::error("save  model failed",'error');
			return false;
// 			print_r($model->attributes);
		}
	}
	
	/*oauth 验证*/
	public function getoauthUrl($rurl,$scope,$state){
		$rurl=urlencode($rurl);
		return $this->openurl.$this->appid.'&redirect_uri='.$rurl.'&response_type=code&scope='.$scope.'&state='.$state.'#wechat_redirect';
	}
	
	public function getBaseAccessUrl($code){
		return 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$this->appid.'&secret='.$this->secret.'&code='.$code.'&grant_type=authorization_code';
	}
	
	//验证token签名，微信认证使用
	
	private function checkSignature($signature,$timestamp,$nonce)
	{
	
		$token = $this->token;
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr,SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
	
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}

	//验证消息来源真实性
	public function validGet($signature,$timestamp,$nonce)
	{
		if ($this->checkSignature($signature,$timestamp,$nonce)){
			return true;
		}else {
			return false;
		}
	}
	
	/**
	 * 网址接入验证方法
	 * @signature — 微信加密签名
	 * @timestamp — 时间戳
	 * @nonce — 随机数
	 * @echostr — 随机字符串
	 * @return string
	 */
	public function valid($echoStr,$signature,$timestamp,$nonce)
	{
		//valid signature , option
		if ($this->checkSignature($signature,$timestamp,$nonce)) {
			return $echoStr;
		}
	}
	
	
	public function load_event()
	{
		return $this->event;
	}
	
	public function load_keyword()
	{
		return $this->content;
	}
	 
	/**
	 * 关注用户自动生成基本信息
	 *
	 *
	 *
	 */
	private function CreateUserInfoTest($openid="")
	{
		($openid=="")?"TEST-OPENid-abcde".rand('1111111', '9999999'):$openid;
		$uinfo=UserBaseInfo::model()->findByAttributes(array('openid'=>$openid));
		if (is_object($uinfo)){
			return $uinfo->id;
		}else{
			//$userinfo=$this->getUserInfo($openid);
			$json='{"subscribe": 1,
					"openid": "wwww",
					"nickname": "测试用户",
					"sex": 1,
					"language": "zh_CN",
					"city": "广州",
					"province": "广东",
					"country": "中国",
					"headimgurl":    "http://wx.qlogo.cn/mmopen/g3MonUZtNHkdmzicIlibx6iaFqAc56vxLSUfpb6n5WKSYVY0ChQKkiaJSgQ1dZuTOgvLLrhJbERQQ4eMsv84eavHiaiceqxibJxCfHe/0",
					"subscribe_time": 1382694957}';
			//Yii::error(var_dump($json),'error');
			//Yii::error($json,'error');
			$userinfo=json_decode($json);
			//var_dump($userinfo);
			//exit();
			$nickname=$userinfo->nickname.rand('111111', '999999');
			//Yii::error('headimgUrl:'.$userinfo->headimgurl,'error');
			if ($userinfo->headimgurl==""){
				$headerPic=Yii::$app->params['upPath']."default.jpeg";
			}else{
				$avartar=$this->getAvatar($userinfo->headimgurl, $openid);
				$headerPic=Yii::$app->params['upPath'].$openid.".jpeg";
			}
			//echo $avartar;
			$sex=$userinfo->sex;
			$usermodel=new UserBaseInfo();
			$usermodel->openid=$openid;
			$usermodel->nick=$nickname;
			$usermodel->sex=$sex;
			$usermodel->province=$userinfo->province;
			$usermodel->city=$userinfo->city;
			$usermodel->create_time=date('Y-m-d H:i:s');
			if($usermodel->save())
			{
				$uinfo=UserBaseInfo::model()->findByAttributes(array('openid'=>$openid));
				rename($headerPic, Yii::$app->params['upPath'].$uinfo->id.".jpeg");
				return  $uinfo->id;
			}
			else {
				Yii::error('save failed openid:'.$openid);
			}
		}
	}
	
	/**
	 * 关注用户自动生成基本信息
	 * 
	 * 
	 * 
	 */
    private function CreateUserInfo($openid)
    {
    	$uinfo=UserBaseInfo::model()->findByAttributes(array('openid'=>$openid));
    	if (is_object($uinfo)){
    		Yii::error('the user has already exsit ,'.$openid,'error');
    		$uinfo->sub=1;
    		$uinfo->save();
    		return $uinfo->id;
    	}else{
	    	$userinfo=$this->getUserInfo($openid);
	    	$nickname=$userinfo->nickname;
	    	//Yii::error('headimgUrl:'.$userinfo->headimgurl,'error');
	    	if ($userinfo->headimgurl==""){
	    		$headerPic=Yii::$app->params['upPath']."default.jpeg";
	    	}else{
	    		$avartar=$this->getAvatar($userinfo->headimgurl, $userinfo->openid);
	    		$headerPic=Yii::$app->params['upPath'].$openid.".jpeg";
	    	}
	    	//echo $avartar;
	        $sex=$userinfo->sex;
	        $usermodel=new UserBaseInfo();
	        $usermodel->openid=$openid;
	        $usermodel->nick=$nickname;
	        $usermodel->sex=$sex;
	        $usermodel->province=$userinfo->province;
	        $usermodel->city=$userinfo->city;
	        $usermodel->create_time=date('Y-m-d H:i:s');
	        $usermodel->sub=1;
	        if($usermodel->save())
	        {
	        	$uinfo=UserBaseInfo::model()->findByAttributes(array('openid'=>$openid));
	        	rename($headerPic, Yii::$app->params['upPath'].$uinfo->id.".jpeg");
	        	return  $uinfo->id;
	        }
    	}
    }
	
    /**
     * 网页授权用户生成用户信息
     *
     *
     *
     */
    public function CreateOauthUserInfo($openid,$accessToken)
    {
        $uinfo =GmWechatInfo::findOne(['openid'=>$openid]);
      	if (is_object($uinfo)){
    		return $uinfo->id;
    	}else{
    		$userinfo=$this->getOauthInfo($openid,$accessToken);
    		if (!isset($userinfo->nickname)){
    			Yii::error('userinfo have no nick','error');
    			return "";
    		}
    		$nickname=$userinfo->nickname;
    		//Yii::error('headimgUrl:'.$userinfo->headimgurl,'error');
    		if ($userinfo->headimgurl==""){
    			$headerPic=Yii::$app->params['upPath']."default.jpeg";
    		}else{
    			$avartar=$this->getAvatar($userinfo->headimgurl, $userinfo->openid);
    			$headerPic=Yii::$app->params['upPath'].$openid.".jpeg";
    		}
      		$usermodel=new GmWechatInfo();
    		$usermodel->openid=$openid;
    		$usermodel->nickname=$nickname;
    		$usermodel->country = $userinfo->country;
    		$usermodel->province=$userinfo->province;
    		$usermodel->city=$userinfo->city;
    		$usermodel->ctime=date('Y-m-d H:i:s');
    		$usermodel->headimgurl=$userinfo->headimgurl;
    		$usermodel->privilege = isset($userinfo->unionid)?$userinfo->unionid:$userinfo->privilege;
    		if($usermodel->save())
    		{
//     			$uinfo=UserBaseInfo::model()->findByAttributes(array('openid'=>$openid));
// 	    		if ($userinfo->headimgurl==""){
// 	    			copy($headerPic, Yii::$app->params['upPath'].$uinfo->id.".jpeg");
// 	    		}else{
// 	    			rename($headerPic, Yii::$app->params['upPath'].$uinfo->id.".jpeg");
// 	    		}
    			//rename($headerPic, Yii::$app->params['upPath'].$uinfo->id.".jpeg");
    			return  $usermodel->id;
    		}else {
    		    Yii::error(print_r($usermodel->getErrors(),true),'wechatwap');
    		    
    		}
    	}
    }
    /**
     * 投票module网页授权用户生成用户信息
     *
     *
     *
     */
    public function CreateVoteOauthUserInfo($openid,$accessToken)
    {
    	$uinfo=VotesUserInfo::model()->findByAttributes(array('openid'=>$openid));
    	if (is_object($uinfo)){
    	    Yii::error('Create vote oauth get openid user suc :'.$uinfo->id,'error');
    		return $uinfo->id;
    	}else{
    		$userinfo=$this->getOauthInfo($openid,$accessToken);
    		Yii::error('Create vote oauth get openid userinfo suc :'.print_r($userinfo,true),'error');
    		if (!isset($userinfo->nickname)){
    			Yii::error('userinfo have no nick','error');
    			return "";
    		}
    		$nickname=$userinfo->nickname;
    		//Yii::error('headimgUrl:'.$userinfo->headimgurl,'error');
    		if ($userinfo->headimgurl==""){
    			$headerPic=Yii::$app->params['votesAvatarPath']."default.jpeg";
    		}else{
    			$avartar=$this->getVotesAvatar($userinfo->headimgurl, $userinfo->openid);
    			$headerPic=Yii::$app->params['votesAvatarPath'].$openid.".jpeg";
    		}
    		//echo $avartar;
    		$sex=$userinfo->sex;
    		$usermodel=new VotesUserInfo();
    		$usermodel->openid=$openid;
    		$usermodel->nick=$nickname;
    		$usermodel->sex=$sex;
    		$usermodel->province=$userinfo->province;
    		$usermodel->city=$userinfo->city;
    		$usermodel->create_time=date('Y-m-d H:i:s');
    		if($usermodel->save())
    		{
    		    Yii::error('Create vote oauth usermodel save suc ','error');
    			$uinfo=VotesUserInfo::model()->findByAttributes(array('openid'=>$openid));
    			if ($userinfo->headimgurl==""){
    				copy($headerPic, Yii::$app->params['votesAvatarPath'].$uinfo->id.".jpeg");
    			}else{
    				rename($headerPic, Yii::$app->params['votesAvatarPath'].$uinfo->id.".jpeg");
    			}
    			//rename($headerPic, Yii::$app->params['upPath'].$uinfo->id.".jpeg");
    			return  $uinfo->id;
    		}
    	}
    }
    /**
     * 网页授权用户生成用户信息,只有openid的静默授权
     *
     *
     *
     */
    public function CreateOauthBaseUserInfo($openid)
    {
        $uinfo =GmWechatInfo::findOne(['openid'=>$openid]);
     	if (is_object($uinfo)){
    		return $uinfo->id;
    	}else{ 
    		$usermodel=new GmWechatInfo();
    		$usermodel->openid=$openid;
    		$usermodel->nickname = 
    		$usermodel->sex='';
    		$usermodel->province='';
    		$usermodel->city='';
    		$usermodel->create_time=date('Y-m-d H:i:s');
    		if($usermodel->save())
    		{
    			$uinfo=UserBaseInfo::model()->findByAttributes(array('openid'=>$openid));
    			//rename($headerPic, Yii::$app->params['upPath'].$uinfo->id.".jpeg");
    			return  $uinfo->id;
    		}
    	}
    }
    
    private function getOauthInfo($openid,$accessToken){
    	$url="https://api.weixin.qq.com/sns/userinfo?access_token=".$accessToken."&openid=".$openid."&lang=zh_CN";
    	return $this->getClient($url);
    }
    
    
    public function createMenu($menu)
    {	
    	$this->haveAccessToken();
    	$access_token=$this->webToken;
    	$url="https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;
    	$out=$this->postClient($url, $menu);
    	//print_r($out);
    	return $out;
    }
	
	/**
	 * 创建XML格式的response
	 * @fromUsername - 消息发送方微信号
	 * @toUsername - 消息接收方微信号
	 * @contentStr - 需要发送的文本内容
	 * @return xml
	 */
	public function creat_xml_response($contentStr)
	{
		$msgType = "text";
		$time = time();
		$textTpl = "<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[%s]]></MsgType>
                            <Content><![CDATA[%s]]></Content>
                            <FuncFlag>0</FuncFlag>
                            </xml>";
		$resultStr = sprintf($textTpl, $this->fromUsername, $this->toUsername, $time, $msgType, $contentStr);
		return $resultStr;
	}
	
	public function create_cust_msg(){//客服功能
		$time = time();
		$reply="
		<xml>
		<ToUserName><![CDATA[%s]]></ToUserName>
		<FromUserName><![CDATA[%s]]></FromUserName>
		<CreateTime>%s</CreateTime>
		<MsgType><![CDATA[transfer_customer_service]]></MsgType>
		</xml>";
		$reply_str=sprintf($reply,$this->fromUsername,$this->toUsername,$time);
		return $reply_str;
	}
	
	
	private function encrypt($str)
	{
		return md5($str);
	}
	
	//组合欢迎消息，本篇为1个图文消息
	public function creat_news_response($title,$desc,$purl,$url)
	{
		$time = time();
		$ArticleCount = "1";
		$title1=$title;
		$desc1=$desc;
		$purl1=$purl;
		$url1=$url;
		$textTpl = "<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[news]]></MsgType>
							<ArticleCount>1</ArticleCount>
                            <Articles>
							<item>
 							<Title><![CDATA[%s]]></Title>
 							<Description><![CDATA[%s]]></Description>
							<PicUrl><![CDATA[%s]]></PicUrl>
 							<Url><![CDATA[%s]]></Url>
 							</item>
                            </Articles>
                            </xml>";
		$resultStr = sprintf($textTpl, $this->fromUsername, $this->toUsername, $time,$title1,$desc1,$purl1,$url1);
		return $resultStr;
	}
	//组合图文列表消息，本篇为N个图文消息
	public function creat_mutil_news_response($arr_list)
	{
		$time = time();
		$ArticleCount = count($arr_list);
		$textTpl = "<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[news]]></MsgType>
							<ArticleCount>%s</ArticleCount>
                            <Articles>";
 							
		$siglenewsTpl="<item><Title><![CDATA[%s]]></Title>
 							<Description><![CDATA[%s]]></Description>
							<PicUrl><![CDATA[%s]]></PicUrl>
 							<Url><![CDATA[%s]]></Url></item>";
		$mutilNewsText="";
		foreach ($arr_list as $k=>$v){
			$news=explode(';', $v);
			if (count($news)=='4'){//长度一定是4 否则会出错
				$mutilNewsText.=sprintf($siglenewsTpl,$news['0'],$news['1'],$news['2'],$news['3']);
			}
		}
		$resultStr = sprintf($textTpl, $this->fromUsername, $this->toUsername, $time,$ArticleCount);
		$resultStr.=$mutilNewsText;
		$resultStr.="</Articles>
                            </xml>";
		return $resultStr;
	}
	//组合欢迎消息，本篇为1个图文消息
	public function creat_img_welcome_response($openid,$userid)
	{
		$time = time();
		$ArticleCount = "1";
		$title1="点击此处进入【蛙微购物平台】";
		$desc1="蛙微购物";
		$purl1="";
// 		$purl1="http://115.28.23.123/images/push/logo.jpg";
		//$purl1="http://wx.weixinmiyou.com/welcome/".$userid.".jpg";
		//$url1="http://wx.weixinmiyou.com/index.php?r=UserBaseInfo/view&token=".$this->encrypt($openid)."&id=".$userid;
		//$url1="http://wx.weixinmiyou.com".Yii::$app->createUrl('userBaseInfo/person',array('id'=>$userid,'token'=>$this->encrypt($openid)));
// 		$urlaction='index';
// 		$state='1000';
// 		$u=new MainUse();
// 		$url1=$u->oauthUrl($urlaction, $state,$userid,$this->encrypt($openid));
		$url1="http://wx.wawego.com/showindex.html";
		$textTpl = "<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[news]]></MsgType>
							<ArticleCount>1</ArticleCount>
                            <Articles>
							<item>
 							<Title><![CDATA[%s]]></Title> 
 							<Description><![CDATA[%s]]></Description>
							<PicUrl><![CDATA[%s]]></PicUrl>
 							<Url><![CDATA[%s]]></Url>
 							</item>
                            </Articles>
                            </xml>";
	
	
		$resultStr = sprintf($textTpl, $this->fromUsername, $this->toUsername, $time, 
				$title1,
				$desc1,
				$purl1,
				$url1
				);
		return $resultStr;
	}
	
	
	public function getClient($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);//
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); // 从证书中检查SSL加密算法是否存在
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);// 使用自动跳转
		curl_setopt($ch, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
		$output = curl_exec($ch);
		if (curl_errno($ch)) {
			Yii::error('Errno'.curl_error($ch));//捕抓异常
			return;
		}
		curl_close($ch);
		// 		var_dump($output);
		// 		print_r($output);
		Yii::error('get output : '.$output);
		$output=json_decode($output);
		return $output;
	}
	private function postClient($url,$post_data){//POST方法
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);//
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1); // 从证书中检查SSL加密算法是否存在
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);// 使用自动跳转
		curl_setopt($ch, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
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
	
	public function getQrTickets($postData)//生成二维码方法
	{
		$this->haveAccessToken();//刷新生成token
		$url="https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$this->webToken;
		$res=$this->postClient($url, $postData);//{"ticket":"gQG28DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0FuWC1DNmZuVEhvMVp4NDNMRnNRAAIEesLvUQMECAcAAA==","expire_seconds":1800}
		//var_dump($res);exit();
		//$res=json_decode($res);
		return $res->ticket;
	}
	public function getQrCode($ticket,$filename)
	{
		$ticket=urlencode($ticket);
		$url="https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".$ticket;
		if($this->getImages($url, $filename)){
			return true;
		}
	}
	
	
	public  function getAvatar($url,$openid){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);//
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); // 从证书中检查SSL加密算法是否存在
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);// 使用自动跳转
		curl_setopt($ch, CURLOPT_TIMEOUT, 10); // 设置超时限制防止死循环
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
		$output = curl_exec($ch);
		if (curl_errno($ch)) {
			echo 'Errno'.curl_error($ch);//捕抓异常
			return;
		}
		curl_close($ch);
		$avatarPath=Yii::$app->params['upPath'].$openid.".jpeg";
		$len = file_put_contents($avatarPath,$output);
		$avtar_img = imagecreatefromjpeg($avatarPath);
		return $avatarPath;
		//return $output;
	}
	
	/**
	 * 投票用户的头像
	 * 
	 * 
	 * @param unknown_type $url
	 * @param unknown_type $openid
	 * @return void|string
	 */
	public  function getVotesAvatar($url,$openid){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);//
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); // 从证书中检查SSL加密算法是否存在
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);// 使用自动跳转
		curl_setopt($ch, CURLOPT_TIMEOUT, 10); // 设置超时限制防止死循环
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
		$output = curl_exec($ch);
		if (curl_errno($ch)) {
			echo 'Errno'.curl_error($ch);//捕抓异常
			return;
		}
		curl_close($ch);
		$avatarPath=Yii::$app->params['votesAvatarPath'].$openid.".jpeg";
		$len = file_put_contents($avatarPath,$output);
		$avtar_img = imagecreatefromjpeg($avatarPath);
		return $avatarPath;
		//return $output;
	}
	
	public  function getImages($url,$filename){
		$ch = curl_init();
		//$url="http://mmbiz.qpic.cn/mmbiz/QME9wxV0u8hVdPhSv94rhBexRWyIXGv5XJWicg4Pab6bkIibPGLLtNSVIkvJMBBZJNANrS3fljkyxsxcPsuGC02A/0";
		curl_setopt($ch, CURLOPT_URL, $url);//
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); // 从证书中检查SSL加密算法是否存在
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);// 使用自动跳转
		curl_setopt($ch, CURLOPT_TIMEOUT, 10); // 设置超时限制防止死循环
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
		$output = curl_exec($ch);
		if (curl_errno($ch)) {
			echo 'Errno'.curl_error($ch);//捕抓异常
			Yii::error('err:'.curl_error($ch));
			return;
		}
		//Yii::error('url:'.$url.' file:'.$filename,'error');
		curl_close($ch);
		//$avatarPath=Yii::$app->params['avatarPath'].$openid.".jpeg";
		$len = file_put_contents($filename,$output);
		//Yii::error('put','error');
		$avtar_img = imagecreatefromjpeg($filename);
		//Yii::error('create','error');
		return true;
		//return $output;
	}
	
	public function getAccess(){
		$param=array("appid"=>$this->appid,"secret"=>$this->secret,"grant_type"=>$this->grant_type);
		$get_args="";
		foreach ($param as $k=>$v){
			$get_args .= $k."=".$v."&";
		}
		$ass_url="https://api.weixin.qq.com/cgi-bin/token?";
		$ass_url .=$get_args;
		//echo $ass_url;
		$output=$this->getClient($ass_url);
		// 		print_r($output);
		$expire_time=time()+7000;
		//echo "access_token: ".$output->access_token." expires: ".$expire_time;
		file_put_contents($this->webTokenPath, $output->access_token);//写入ｔｏｋｅｎ文件
		file_put_contents($this->timePath, time()+$output->expires_in);//写入过期时间
		return $output;
	}
	private function haveAccessToken(){
		Yii::error('token path: '.$this->webTokenPath);
		$this->webToken=file_get_contents($this->webTokenPath);
		$this->expireTime=file_get_contents($this->timePath);
		if ($this->webToken && $this->expireTime && $this->expireTime+100 > time()){//token存在并且没有过期
			return true;
		}else {
			$this->getAccess();
			$this->webToken=file_get_contents($this->webTokenPath);
			$this->expireTime=file_get_contents($this->timePath);
			return true;
		}
	}
	
	public function getUserInfo($openid){
		$this->haveAccessToken();
		$userUrl="https://api.weixin.qq.com/cgi-bin/user/info?";
		$param=array('access_token'=>$this->webToken,'openid'=>$openid);
		$get_args="";
		foreach ($param as $k=>$v){
			$get_args .= $k."=".$v."&";
		}
		$userUrl .=$get_args;
// 		echo $userUrl;
		$output=$this->getClient($userUrl);
		return $output;
	}
}




