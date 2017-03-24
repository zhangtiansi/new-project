<?php

namespace app\modules\zjhapi\controllers;

use yii;
use yii\web\Controller;
use app\components\ApiCheck;
use app\components\ApiErrorCode;
use app\models\GmAccountInfo;
use app\models\AlipayNoticeLogs;
use yii\grid\DataColumn;
use app\models\GmOrderlist;
use app\models\GmPlayerInfo;
use app\models\GmActivity;
use app\models\GmAnnouncement;
use app\models\GmVersion;
use app\models\LogYeepayNotice;
use app\models\CfgProducts;
use yii\web\NotFoundHttpException;
use app\models\LogSyserror;
use app\models\LogLlpayNotice;
use app\models\IosPaylogs;
use app\models\ReceiptData;
use app\models\LogUserlogin;
use app\models\LogUserrequst;
use app\models\CfgServerlist;
use app\models\GmChannelInfo;
use app\models\Ttszp;
use app\components\yeepay;
use app\models\CfgTree;
use app\models\LogTree;
use app\models\LogBlacklist;
use app\components\HttpClient;
use yii\web\Response;
use app\models\LogImeRegister;
use app\components\WxPayNotify;
use app\models\LogWxpay;
use app\modules\agent\controllers\OrderController;
use app\components\secureUtil;
use app\models\DataChannelUser;
use app\components\AnySDK;
use app\models\AnyOrderLogs;
use app\models\GmNotice;
use app\components\WxPayUnifiedOrder;
use app\components\WxPayConfig;
use app\components\WxPayApi;
use app\components\WxPayDataBase;
use app\components\WxPayBizPayUrl;
use app\models\LogMail;
use yii\helpers\Html;
use app\components\ipay;
use app\models\LogIpaynotice;
use app\models\CfgGameParam;
use app\models\CfgIpayParams;

class AuthController extends Controller
{
    
    public $enableCsrfValidation = false;
    
    public function beforeAction($action){
        if (Yii::$app->getRequest()->userIP=="127.0.0.1" ||Yii::$app->getRequest()->hostInfo=="http://zjh.koudaishiji.com"){
            return true;
        }
        if (parent::beforeAction($action)) {
            if ($this->tryAction($action->id)){
                return true;
            }
            else{
                $ck = new ApiCheck();
                $token=Yii::$app->getRequest()->getQueryParam('token');
                $ts=Yii::$app->getRequest()->getQueryParam('ts');
                $sign = Yii::$app->getRequest()->getQueryParam('sign');
                if ($token == ""||$ts == ""){
                    echo json_encode(ApiErrorCode::$invalidParam);
                    return false;
                }elseif (!$ck->checkToken($token, $ts,$sign,Yii::$app->request->queryString)){
                    echo json_encode(ApiErrorCode::$CheckFailed);
                    return false;
                }else {
                    return  true;
                }
    
            }
    
        } else {
            return false;
        }
    
    }
    function tryAction($aid)
    {//在白名单的action不需要校验签名
        $list=['index','alipay','baidu','app','uc','dl','tg','ttszp','update','avatarup',"yeepay","xieyi","llpay","llpayreturn",
            "llpaynotify","yeepayresult","yeepay_callback",'yeepayniu',"yeepayresultniu","avatars",
            "niuavatar","niuavatar",'randvatars','wxpaynotify','unpay','auth','paynotice','wxprepay','iosaibei','aibei','wj','s2s'
        ];
        foreach ($list as $id)
        {
            if ($id == $aid)
                return true;
        }
        return FALSE;
    }
     
    public function actionRegister($type)
    {//正常注册接口    
//         $udid=Yii::$app->getRequest()->getQueryParam('udid');
        $name=Yii::$app->getRequest()->getQueryParam('name');
        $pwd=Yii::$app->getRequest()->getQueryParam('pwd');
        $pwd_q=Yii::$app->getRequest()->getQueryParam('pwd_q');
        $pwd_a=Yii::$app->getRequest()->getQueryParam('pwd_a');
        $channel=Yii::$app->getRequest()->getQueryParam('channel');
        $rlchannel= GmChannelInfo::findOne(['any_channel'=>$channel]);//匹配注册渠道 不能影响官方渠道编号，只能在渠道信息里做配置
        if (is_object($rlchannel)){
            $channel =$rlchannel->cid;
        }
        $dev=Yii::$app->getRequest()->getQueryParam('d');
        $ver=Yii::$app->getRequest()->getQueryParam('v');
        $param_v_info = explode('_._', $ver);
        $osver = $param_v_info[0];
//         if ($osver!="1.5")
        if(Yii::$app->params["ServiceNotValiable"])
            return json_encode(ApiErrorCode::$ServiceNotValiable);
        $appver = $param_v_info[1];
        $lineNo = $param_v_info[2];
        $param_dev_uuid = explode('_._', $dev);
        $uuid = $param_dev_uuid[0];
        $simSerial = $param_dev_uuid[1];
        $dev_id = $param_dev_uuid[2];
        if ($dev_id=="")
            $dev_id=$uuid;
//         if ($simSerial == 898600||$simSerial==898602||$simSerial==898601||$simSerial==898603){//移动无法获取sim卡号的手机
//             $simSerial = $dev_id;//保护sim卡信息的情况下直接用ime号
//         }
        $realIp = Yii::$app->getRequest()->getUserIP();
        if ($this->isinblack($dev_id)){
            return json_encode(ApiErrorCode::$BlackListError);
        }
        if ($this->isinblack($realIp)){
            return json_encode(ApiErrorCode::$BlackListError);
        } 
        if($type == 1) {//快速注册 
            $user = GmAccountInfo::findOne(['op_uuid'=>$uuid,'type'=>1]);
            if (!$user){
                $user = new GmAccountInfo();
                $user->op_uuid = $uuid;
                $user->type = 1;
                $user->account_name = "Quick_".time().rand(111, 999);
                $user->account_pwd = "NoPasswd";
                $user->pwd_q = 0;
                $user->pwd_a = "Quick";
                $user->sim_serial = $simSerial==""?$uuid:$simSerial;
                $user->reg_channel = strval($channel);
                $user->reg_time = date('Y-m-d H:i:s');
                $user->device_id = $dev_id;
            }
            elseif ($user->status==1){
                return json_encode(ApiErrorCode::$BlackListError);
            }
            elseif (strtotime($user->last_login)>(time()-15)){ 
                return json_encode(ApiErrorCode::$RequestToMuch);
            }
            $user->last_login = date('Y-m-d H:i:s');
            $token = md5(time().$user->gid);
            $user->token = $token;
            if ($user->isNewRecord)
                $keywords = 'quickRegister';
            else 
                $keywords = 'quickLogin'; 
            if($user->save()){
                
                $info = ['gid'=>$user->gid,'token'=>$token,
                 ];
    
                $res = ApiErrorCode::$OK;
                $gs = $this->getServerInfo($channel,$user->gid,$appver);
                $info = array_merge($info,$gs); 
                $res['info']=$info; 
                $this->saveLogin($keywords, $user->gid, $channel, Yii::$app->getRequest()->getUserIP(), $ver, $dev); 
                return  json_encode($res);
            }else {
                $this->savesLog("Save  quick account info failed ".print_r($user->getErrors(),true),'error');
                return json_encode(ApiErrorCode::$AccountError);
            }
        }else if($type == 2) {//SDK注册和登录 
            $channeluid=Yii::$app->getRequest()->getQueryParam('channeluid');
            $sdkchannel=Yii::$app->getRequest()->getQueryParam('sdkchannel');
            $name=$sdkchannel.$channeluid;
            $rlchannel= GmChannelInfo::findOne(['any_channel'=>$sdkchannel]);//匹配注册渠道 不能影响官方渠道编号，只能在渠道信息里做配置
            if (is_object($rlchannel)){
                $sdkchannel =$rlchannel->cid;
            }
            $user = GmAccountInfo::findOne(['account_name'=>$name,'type'=>2]);
            if (!$user){
                $countSim = GmAccountInfo::find()->where(['type'=>2,'device_id'=>$dev_id])->count();
                if ($countSim >= 5 && !$this->whiteIme($dev_id))
                    return json_encode(ApiErrorCode::$SimError);
                $user = new GmAccountInfo();
                $user->op_uuid = $uuid; 
                $user->type = 2;
                $user->account_name =$name;
                $user->account_pwd = "NoPasswd";
                $user->pwd_q = 0;
                $user->pwd_a = "SDKlogin";
                $user->sim_serial = $simSerial==""?$uuid:$simSerial;
                $user->reg_channel = strval($sdkchannel);
                $user->reg_time = date('Y-m-d H:i:s');
                $user->device_id = $dev_id;
            }elseif ($user->status!=0){
                $this->savesLog(" SDKlogin account in blacklist ",'error');
                return json_encode(ApiErrorCode::$AccountError);
            }
            if (strtotime($user->last_login)>(time()-15) &&  Yii::$app->getRequest()->userIP!="115.238.73.242")
                return json_encode(ApiErrorCode::$RequestToMuch);
            $user->last_login = date('Y-m-d H:i:s');
            $token = md5(time().$user->gid);
            $user->token = $token;
            if($user->save()){
                $info = ['gid'=>$user->gid,'token'=>$token,
                ];
                $res = ApiErrorCode::$OK;
                $gs = $this->getServerInfo($channel,$user->gid,$appver);
                $info = array_merge($info,$gs);
                $res['info']=$info;
                $this->saveLogin("SDKlogin", $user->gid, $sdkchannel, Yii::$app->getRequest()->getUserIP(), $ver, $dev);
                return  json_encode($res);
            }else {
                $this->savesLog("Save  SDKlogin account info failed ".print_r($user->getErrors(),true),'error');
                return json_encode(ApiErrorCode::$AccountError);
            }
        }else if($type == 3) {//手机验证码直接登录
            $vercode=Yii::$app->getRequest()->getQueryParam('vercode');
            $phone=Yii::$app->getRequest()->getQueryParam('phone');  
            //先验证
            
            
            $user = GmAccountInfo::findOne(['account_name'=>$name,'type'=>2]);
            if (!$user){
                $countSim = GmAccountInfo::find()->where(['type'=>2,'device_id'=>$dev_id])->count();
                if ($countSim >= 5 && !$this->whiteIme($dev_id))
                    return json_encode(ApiErrorCode::$SimError);
                $user = new GmAccountInfo();
                $user->op_uuid = $uuid; 
                $user->type = 2;
                $user->account_name =$name;
                $user->account_pwd = "NoPasswd";
                $user->pwd_q = 0;
                $user->pwd_a = "SDKlogin";
                $user->sim_serial = $simSerial==""?$uuid:$simSerial;
                $user->reg_channel = strval($sdkchannel);
                $user->reg_time = date('Y-m-d H:i:s');
                $user->device_id = $dev_id;
            }elseif ($user->status!=0){
                $this->savesLog(" SDKlogin account in blacklist ",'error');
                return json_encode(ApiErrorCode::$AccountError);
            }
            if (strtotime($user->last_login)>(time()-15) &&  Yii::$app->getRequest()->userIP!="115.238.73.242")
                return json_encode(ApiErrorCode::$RequestToMuch);
            $user->last_login = date('Y-m-d H:i:s');
            $token = md5(time().$user->gid);
            $user->token = $token;
            if($user->save()){
                $info = ['gid'=>$user->gid,'token'=>$token,
                ];
                $res = ApiErrorCode::$OK;
                $gs = $this->getServerInfo($channel,$user->gid,$appver);
                $info = array_merge($info,$gs);
                $res['info']=$info;
                $this->saveLogin("SDKlogin", $user->gid, $sdkchannel, Yii::$app->getRequest()->getUserIP(), $ver, $dev);
                return  json_encode($res);
            }else {
                $this->savesLog("Save  SDKlogin account info failed ".print_r($user->getErrors(),true),'error');
                return json_encode(ApiErrorCode::$AccountError);
            }
        }
    }
    public function actionLogin($type)
    {
        //         return $this->render('index');
        $name=Yii::$app->getRequest()->getQueryParam('name');
        $pwd=Yii::$app->getRequest()->getQueryParam('pwd');
        $channel=Yii::$app->getRequest()->getQueryParam('channel');
        $rlchannel= GmChannelInfo::findOne(['any_channel'=>$channel]);//匹配注册渠道 不能影响官方渠道编号，只能在渠道信息里做配置
        if (is_object($rlchannel)){
            $channel =$rlchannel->cid;
        }
        $dev=Yii::$app->getRequest()->getQueryParam('d');
        $ver=Yii::$app->getRequest()->getQueryParam('v');
        $param_v_info = explode('_._', $ver);
        $osver = $param_v_info[0];
        if(Yii::$app->params["ServiceNotValiable"] &&  Yii::$app->getRequest()->userIP!="115.238.73.242")
            return json_encode(ApiErrorCode::$ServiceNotValiable);
        $appver = $param_v_info[1];
        $lineNo = $param_v_info[2];
        $param_dev_uuid = explode('_._', $dev);
        $uuid = $param_dev_uuid[0];
        $simSerial = $param_dev_uuid[1];
        $dev_id = $param_dev_uuid[2];
        $realIp = Yii::$app->getRequest()->getUserIP();
        if ($this->isinblack($dev_id)){
            return json_encode(ApiErrorCode::$BlackListError);
        }
        if ($this->isinblack($realIp)){
            return json_encode(ApiErrorCode::$BlackListError);
        }
        if ($dev_id == "")
            $dev_id = $uuid;
        if ($type == 0){//正常登录
            if ($name==""||$pwd=="" ||$dev == "" ||count($param_dev_uuid)<3)
            {
                return json_encode(ApiErrorCode::$invalidParam);
            }
            $usercount = GmAccountInfo::find()->where(['account_name'=>$name,'account_pwd'=>$pwd])->count();
            if ($usercount == 0)
            {
                return json_encode(ApiErrorCode::$AccountPwdError);
            }
            $user = GmAccountInfo::findOne(['account_name'=>$name,'account_pwd'=>$pwd,'status'=>0]);
            if (!$user){
                return json_encode(ApiErrorCode::$BlackListError);
            }
            if (strtotime($user->last_login)>(time()-15) &&  Yii::$app->getRequest()->userIP!="115.238.73.242")
                return json_encode(ApiErrorCode::$RequestToMuch);
            $user->last_login = date('Y-m-d H:i:s');
            $token = md5(time().$user->gid);
            $user->token = $token;
            if($user->save()){
                $info = ['gid'=>$user->gid,'token'=>$token,                    
                ];
                $res = ApiErrorCode::$OK;
                $gs = $this->getServerInfo($channel,$user->gid,$appver);
                $info = array_merge($info,$gs);
//                 if ($channel==1000||$channel==1002||$channel==1004)
//                     $info['isdiandangoff']=1;
                $res['info']=$info;
                $this->saveLogin("normalLogin", $user->gid, $channel, Yii::$app->getRequest()->getUserIP(), $ver, $dev);
                return  json_encode($res);
            }else {
                $this->savesLog("Save account info failed ".print_r($user->getErrors(),true),'error');
                return json_encode(ApiErrorCode::$AccountError);
            }
        }elseif ($type == 2){
            //手机登录
            $vercode=Yii::$app->getRequest()->getQueryParam('vercode');
            $phone=Yii::$app->getRequest()->getQueryParam('phone');
            $x = $this->verSmscheck($phone, $vercode);
            $errcodes=['200'=>'验证成功',
                '405'=>'AppKey为空',
                '406'=>'AppKey无效',
                '456'=>'国家代码或手机号码为空',
                '457'=>'手机号码格式错误',
                '466'=>'请求校验的验证码为空',
                '467'=>'请求校验验证码频繁',
                '468'=>'验证码错误',
                '474'=>'没有打开服务端验证开关', ];
            if (is_object($x) && isset($x->status))
            {
                $status = $x->status; 
                if ($status != "200"){
                    $ret =ApiErrorCode::$verError;
                     if (isset($errcodes[$status]))
                        $ret['msg'].=$errcodes[$status];
                    else 
                        $ret['msg'].="代码".$status;
                    return json_encode($ret);
                }else{
                    $countname = GmAccountInfo::find()->where(['account_name'=>$phone])->count();
                    $countphone = GmAccountInfo::find()->where(['phone'=>$phone])->count(); 
                    if ($countname > 0|| $countphone>0)
                    {//手机号已经注册已绑定以绑定手机为准
                        $user = GmAccountInfo::findOne(['phone'=>$phone]); 
                        if ($user->status !=0){
                            return json_encode(ApiErrorCode::$BlackListError);
                        }
//                         if (strtotime($user->last_login)>(time()-15) &&  Yii::$app->getRequest()->userIP!="115.238.73.242")
//                             return json_encode(ApiErrorCode::$RequestToMuch);
                        $user->last_login = date('Y-m-d H:i:s');
                        $token = md5(time().$user->gid);
                        $user->token = $token;
                        if($user->save()){
                            $info = ['gid'=>$user->gid,'token'=>$token,'phone'=>$user->phone
                            ];
                            $res = ApiErrorCode::$OK;
                            $gs = $this->getServerInfo($channel,$user->gid,$appver);
                            $info = array_merge($info,$gs); 
                            $res['info']=$info;
                            $this->saveLogin("phoneLogin", $user->gid, $channel, Yii::$app->getRequest()->getUserIP(), $ver, $dev);
                            return  json_encode($res);
                        }else {
                            $this->savesLog("Save account info failed ".print_r($user->getErrors(),true),'error');
                            return json_encode(ApiErrorCode::$AccountError);
                        }
                        
                    }else {//手机号未注册未绑定
                       if ($simSerial == ""){
                           $simSerial=$dev_id;
                        }
                       $countSim = GmAccountInfo::find()->where(['device_id'=>$dev_id])->count();
                       if ($countSim >= 5 && !$this->whiteIme($dev_id))
                           return json_encode(ApiErrorCode::$SimError);
                       $countname = GmAccountInfo::find()->where(['account_name'=>$phone])->count();
                       $countphone = GmAccountInfo::find()->where(['phone'=>$phone])->count();
                       if ($countname > 0|| $countphone>0)
                           return json_encode(ApiErrorCode::$PhoneError);
                       $user = new GmAccountInfo();
                       $user->account_name = $phone;
                       $user->account_pwd = $phone."PWD";
                       $user->pwd_a = "x";
                       $user->pwd_q = "x";
                       $user->pwd_q = $phone;
                       $user->device_id = $dev_id;
                       $user->op_uuid = $uuid;
                       $user->reg_channel = strval($channel);
                       $user->reg_time = date('Y-m-d H:i:s');
                       $user->sim_serial = $simSerial;
                       $user->type = 0;
                       $token = md5(time().$user->account_name);
                       $user->token = $token;
                       $user->last_login = date('Y-m-d H:i:s');
                       if ($user->save())
                       { 
                               $info = ['gid'=>$user->gid,'token'=>$token,'phone'=>$phone
                               //                     'servip'=>Yii::$app->params['serip'],'servport'=>Yii::$app->params['serport'],'servid'=>Yii::$app->params['serid']
                               ];
                               $res = ApiErrorCode::$OK;
                               $gs = $this->getServerInfo($channel,$user->gid,$appver);
                               $info = array_merge($info,$gs);
                               //                 if ($channel==1000||$channel==1002||$channel==1004)
                                   //                     $info['isdiandangoff']=1;
                               $res['info']=$info;
                               $this->saveLogin("phoneRegister", $user->gid, $channel, Yii::$app->getRequest()->getUserIP(), $ver, $dev); 
                               return  json_encode($res);
                       }else{
                           $this->savesLog("Save account  info failed ".print_r($user->getErrors(),true),'error');
                           return json_encode(ApiErrorCode::$AccountError);
                       }
                    }    
                    
                }
            }
        }
    }
    
    public function actionBind()
    {
        //手机绑定
        $vercode=Yii::$app->getRequest()->getQueryParam('code');
        $phone=Yii::$app->getRequest()->getQueryParam('phone');
        $gid=Yii::$app->getRequest()->getQueryParam('gid');
        $token=Yii::$app->getRequest()->getQueryParam('usertoken');
        $x = $this->verSmscheck($phone, $vercode);
        $errcodes=['200'=>'验证成功',
            '405'=>'AppKey为空',
            '406'=>'AppKey无效',
            '456'=>'国家代码或手机号码为空',
            '457'=>'手机号码格式错误',
            '466'=>'请求校验的验证码为空',
            '467'=>'请求校验验证码频繁',
            '468'=>'验证码错误',
            '474'=>'没有打开服务端验证开关', ];
        if (is_object($x) && isset($x->status))
        {
            $status = $x->status;
            if ($status != "200"){
                $ret =ApiErrorCode::$verError;
                if (isset($errcodes[$status]))
                    $ret['msg'].=$errcodes[$status];
                else
                    $ret['msg'].="代码".$status;
                return json_encode($ret);
            }else{//验证成功
                $gm = GmAccountInfo::find()->where(['gid'=>$gid,'token'=>$token])->one();
                if (!is_object($gm))
                    return json_encode(ApiErrorCode::$TokenError);
                else {
                    $cp=GmAccountInfo::find()->where(['phone'=>$phone])->count();
                    if ($cp>0)
                        return json_encode(ApiErrorCode::$PhoneError);
                    else if ($gm->phone !=0 || strlen($gm->phone)==11)
                    {//已绑定其他号
                        return json_encode(ApiErrorCode::$ALREADYBIND);
                    }else 
                    {
                        $gm->phone = $phone;
                        if ($gm->save())
                            return json_encode(ApiErrorCode::$OK);
                        else 
                            return json_encode(ApiErrorCode::$SAVEERR);   
                    }
                }
            }
        }else {
            return json_encode(ApiErrorCode::$BindcheckError);
        }
        
    }
    function verSmscheck($phone,$vercode)
    {  
        $params=[
            'appkey'=>Yii::$app->params['smskey'],
            'phone'=>$phone,
            'zone' =>'86',
            'code' =>$vercode,
        ];
         $api='https://webapi.sms.mob.com/sms/verify';
            $ch = curl_init();
            curl_setopt( $ch, CURLOPT_URL, $api );
            // 以返回的形式接收信息
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
            // 设置为POST方式
            curl_setopt( $ch, CURLOPT_POST, 1 );
            curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $params ) );
            // 不验证https证书
            curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
            curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
            curl_setopt( $ch, CURLOPT_TIMEOUT, 20 );
            curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded;charset=UTF-8',
            'Accept: application/json',
            ) );
            // 发送数据
            $response = curl_exec( $ch );
            // 不要忘记释放资源
            curl_close($ch);
       
           $x = json_decode($response);
           return $x;
    } 
    function isindebug($gid)
    {
        foreach (Yii::$app->params['debuggid'] as $ggid)
        {
            if ($ggid==$gid)
                return true;
        }
        return false;
    }
    function isinblack($ime)
    { 
        $count = LogBlacklist::find()->where(['ime'=>$ime,'status'=>0])->count();
        if ($count!=0){
            Yii::error("count is ".$count);
            return true;
        }
        return false;
    }
    function whiteIme($ime)
    {
        foreach (Yii::$app->params['whiteime'] as $iime)
        {
            if ($iime==$ime)
                return true;
        }
        return false;
    }
    
    function getServerInfo($channel,$gid,$appver)
    {
        $serverinfo=[];
        $player = GmPlayerInfo::findOne(['account_id'=>$gid]);
        if (is_object($player)){
            //已注册用户
            if ($player->power >=10){
                $db = Yii::$app->db;
                $sql = 'select serverid,serverip,serverport from cfg_serverlist where server_type=4 and status=0';
                $res = $db->createCommand($sql)->queryAll();
                if (count($res)>0)
                {
                    $sv=$res[array_rand($res)];
                    $serverinfo['servip'] = $sv['serverip'];
                    $serverinfo['servport'] = strval($sv['serverport']);
                    $serverinfo['servid'] = intval($sv['serverid']);
                } 
            }elseif ($player->power >=1){
                $db = Yii::$app->db;
                $sql = 'select serverid,serverip,serverport from cfg_serverlist where server_type=3 and status=0';
                $res = $db->createCommand($sql)->queryAll();
                if (count($res)>0)
                {
                    $sv=$res[array_rand($res)];
                    $serverinfo['servip'] = $sv['serverip'];
                    $serverinfo['servport'] = strval($sv['serverport']);
                    $serverinfo['servid'] = intval($sv['serverid']);
                }
            }else {
                $gs = CfgServerlist::findOne(['status'=>0,'server_type'=>0]);
                if (is_object($gs))//服务器地址
                {
                    $serverinfo['servip'] = $gs->serverip;
                    $serverinfo['servport'] = strval($gs->serverport);
                    $serverinfo['servid'] = $gs->serverid;
                }
            }
        }else{
            //新注册用户
            $gs = CfgServerlist::findOne(['status'=>0,
                'server_type'=>0
            ]);
            if (is_object($gs))//服务器地址
            {
                $serverinfo['servip'] = $gs->serverip;
                $serverinfo['servport'] = strval($gs->serverport);
                $serverinfo['servid'] = $gs->serverid;
            } 
        }
        
        $jackpot = CfgGameParam::findOne(['param_key'=>'JACKPOT_OPEN']);
        if (is_object($jackpot))//水浒传的开关
            $serverinfo['isjackpotopen']=$jackpot->param_value;
        if ($channel == "2088"||$channel == "2089"||$channel == "2090")//点当和送礼界面的参数
            $serverinfo['isdiandangoff']=1;
        $ch = GmChannelInfo::findOne($channel);
        if (is_object($ch) && $ch->ipay!="")
            $serverinfo['ippayparam']=CfgIpayParams::findOne($ch->ipay)->attributes;
        return $serverinfo;
    }
     
    function logtodb($keywords,$contents,$loglevel="error")
    {
        $log = new LogSyserror();
        $log->keyword = $keywords;
        $log->contents = $contents;
        $log->loglevel = $loglevel;
        if (!$log->save())
        {
            Yii::warning("log sys error saved failed  ".print_r($log->getErrors(),true),'llpay');
        }
    }  
    function checkBid($bid)
    {
        foreach (Yii::$app->params['bundleid'] as $v)
        {
            if ($bid == $v)
                return true;
        }
        return false;
    } 
    function saveLogin($keyword,$gid,$channel,$ip,$vparam,$dparam)
    {
        $param_v_info = explode('_._', $vparam);
        $osver = $param_v_info[0];
        $appver = $param_v_info[1];
        $lineNo = $param_v_info[2];
        $param_dev_uuid = explode('_._', $dparam);
        $uuid = $param_dev_uuid[0];
        $simSerial = $param_dev_uuid[1];
        $dev_id = $param_dev_uuid[2];
        if ($dev_id=="")
            $dev_id=$uuid;
        $logintime=date('Y-m-d H:i:s');
        $pieces=[$gid,$keyword,$osver,$appver,$lineNo,$uuid,$simSerial,$dev_id,$channel,$ip,$logintime];
        $log2=implode('|.|', $pieces); 
        $this->savesLog($log2,"login");
        Yii::$app->redis->lpush("Keylogin",$log2); 
    } 
    function savesLog($str,$key)
    {
        $logpath = Yii::$app->params['selflogs'][$key];
        $str = date('Y-m-d H:i:s')."  ".$str."\r\n";
        $f=fopen($logpath,"a+");
        fwrite( $f,$str);
        fclose( $f);
    }
}
