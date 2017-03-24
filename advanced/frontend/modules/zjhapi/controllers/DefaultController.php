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

class DefaultController extends Controller
{
    
    public $enableCsrfValidation = false;
    
    public function beforeAction($action){
        if (Yii::$app->getRequest()->userIP=="127.0.0.1" || Yii::$app->getRequest()->userIP=="115.238.73.242" ){
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
    
    public function actionTtszp()
    {
        Yii::warning("ttszp post :".print_r(Yii::$app->getRequest()->getBodyParams(),true),'ttszp');
        //'buyer' => '731973'
//     'verifycode' => ''
//     'order' => 'D8055961728949808674'
//     'game' => '0001'
//     'money' => '6'
//     'goods' => '购买6颗钻石'
//     'payment' => 'alipay'
        $tt = new Ttszp();
        $tt->attributes = Yii::$app->getRequest()->getBodyParams();
        $tt->ctime = date('Y-m-d H:i:s');
        $tt->save();
    }
    public function actionIndex()
    {
//         return $this->render('index');
//         $db=Yii::$app->db;
//         for ($i=1;$i<1000;$i++){
//             $sql = 'insert into log_betlog(account_id,bet_1,bet_2,bet_3,bet_4,bet_5,bet_6,mark,bid) values("'.$i.'","'.rand(0,999999).'","'.rand(0,999999).'","'.rand(0,999999).'","'.rand(0,999999).'","'.rand(0,999999).'","'.rand(0,999999).'","0",333)';
//             $orders = $db->createCommand($sql)->query();
//         }
        return  "xxxx";
    }
    public function actionS2s()
    {
        $idfa = strtolower(Yii::$app->getRequest()->getQueryParam('idfa'));
        $transaction_id = Yii::$app->getRequest()->getQueryParam('transaction_id',0); 
        $affiliate_id = Yii::$app->getRequest()->getQueryParam('affiliate_id',0); 
        $aff_sub8 = Yii::$app->getRequest()->getQueryParam('aff_sub8',0); 
        $source = Yii::$app->getRequest()->getQueryParam('source',0); 
        $channel = Yii::$app->getRequest()->getQueryParam('channel',"1003"); 
        $conte = ['transaction_id'=>$transaction_id,'affiliate_id'=>$affiliate_id,'aff_sub8'=>$aff_sub8,'source'=>$source,'channel'=>$channel];
        $kw = "s2s_".$idfa;
        Yii::$app->cache->set($kw, $conte,3600);
        $this->savesLog("s2s redirect suc idfa : ".$idfa." transaction: ".$transaction_id."   affiliate_id:".$affiliate_id." aff_sub8:".$aff_sub8, 'debug');
        $this->redirect("https://itunes.apple.com/cn/app/tian-tian-zha-jin-hua-yu-le/id1107360427?mt=8");
    }
    public function actionAvatarup()
    {
//         $data=Yii::$app->request->getRawBody();
        $data = $_POST;
//         foreach ($data as $key => $value) {
//             $data[$key] = urldecode($value);
//         }
        
        if (isset($data['gid'])&& isset($data['picdata']))
        {
            Yii::error("postimage params ok");
            $gid = $data['gid'];
            $base64 = $data['picdata'];
            Yii::error("base64 lenth : ".strlen($base64));
            $file = Yii::$app->params['avatarPath'].$gid.".jpg";
            Yii::error('the file path is '.$file);
            if (file_exists($file))
            {
//                 Yii::error("file is exist ,base64 img: ".$base64);
            }
            $img64 = base64_decode($base64);
            $a=file_put_contents($file, $img64);
//             Yii::error("a: ".print_r($a,true));
//             $player = GmPlayerInfo::findOne(['account_id'=>$gid]);
//             if ($player){
//                 $player->avatar64=$base64;
//                 if ($player->save()){
//                     Yii::error("saved img base64 encode in db");
                    $this->getClient("http://120.26.129.162/aliyun-cdn/cdn_refresh.php?gid=".$gid);
//                 }
//                 else 
//                     Yii::error("saved img base64 encode in dbfailed ".print_r($player->getErrors(),true));
//             }
            return json_encode(ApiErrorCode::$OK);
        }
        return json_encode(ApiErrorCode::$RuleError);
    }
    
    public function actionIosupload()
    {
        Yii::error("avatar upload start !");
        $base64=Yii::$app->request->getRawBody();
        $gid =  Yii::$app->getRequest()->getQueryParam('gid');
        $usertoken =  Yii::$app->getRequest()->getQueryParam('usertoken');
        $ac = GmAccountInfo::find()->where(['gid'=>$gid,'token'=>$usertoken])->count();
        if ($ac == 0 )
            return json_encode(ApiErrorCode::$AccountError);
        Yii::error("base64 lenth : ".strlen($base64));
        $file = Yii::$app->params['avatarPath'].$gid.".jpg";
        Yii::error('the file path is '.$file);
        if (file_exists($file))
        {
//             Yii::error("file is exist ,base64 img: ".$base64);
        }
        $img64 = base64_decode($base64);
        $a=file_put_contents($file, $img64);
//         Yii::error("a: ".print_r($a,true));
        $player = GmPlayerInfo::findOne(['account_id'=>$gid]);
        if ($player){
//             $player->avatar64=$base64;
//             if ($player->save()){
//                 Yii::error("saved img base64 encode in db");
                $this->getClient("http://120.26.129.162/aliyun-cdn/cdn_refresh.php?gid=".$gid);
//             }
//             else
//                 Yii::error("saved img base64 encode in dbfailed ".print_r($player->getErrors(),true));
        }
        return json_encode(ApiErrorCode::$OK);
    }
    
    public function actionNiuavatar()
    {
        Yii::error("niuniu avatar upload start !");
        $base64=Yii::$app->request->getRawBody();
        $fname =  Yii::$app->getRequest()->getQueryParam('fname');
//         Yii::error("base64 lenth : ".strlen($base64));
        $file = Yii::$app->params['niuAvatarPath'].$fname.".jpg";
//         Yii::error('the file path is '.$file);
        if (file_exists($file))
        {
            Yii::error("file is exist ,base64 img: ".$base64);
        }
        $img64 = base64_decode($base64);
        $a=file_put_contents($file, $img64);
        $this->getClient("http://120.26.129.162/aliyun-cdn/cdn_refreshniu.php?fname=".$fname);
        return json_encode(ApiErrorCode::$OK);
    }
    public function actionRandvatars($gid)
    {
        Yii::error("niu Rand avatarrequst : gid : ".$gid);
        $response = Yii::$app->getResponse();
        $response->headers->set('Content-Type', 'image/jpeg');
        $response->format = Response::FORMAT_RAW;
//         $imgFullPath=Yii::$app->params['avatarPath'].$gid.".jpg";
//         if (file_exists($imgFullPath)){
//             if ( !is_resource($response->stream = fopen($imgFullPath, 'r')) ) {
//                 throw new \yii\web\ServerErrorHttpException('file access failed: permission deny');
//             }
//         }else {
        $randnu = $gid%399 +1;
        $imgFullPath=Yii::$app->params['avatarPath'].$randnu.".jpg";
        $response->stream = fopen($imgFullPath, 'r');
//         }
        return $response->send();
    
    }
    public function actionAuth()
    {//anysdk 登录验证
        $params = $_REQUEST;
        if (!(isset($params['channel']) && isset($params['uapi_key']) && isset($params['uapi_secret']))) {
            return json_encode(ApiErrorCode::$invalidParam);
        }else {
            $url = 'http://oauth.anysdk.com/api/User/LoginOauth/';
            $post_data = $this->buildHttpQuery($params);
            $result=$this->postD($url, $post_data);
            Yii::error('<<<<<<----=====post auth result : '.$result);
            return $result;
        }
    }
    function postD($url,$post_data){//POST方法
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);//
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);// 使用自动跳转
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,30);
        curl_setopt($ch, CURLOPT_TIMEOUT,30);
        curl_setopt($ch, CURLOPT_USERAGENT,'px v1.0');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $output = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Errno'.curl_error($ch);//捕抓异常
            return false;
        }
        curl_close($ch);
        return $output;
    }
    /**
     * Build HTTP Query.
     * @param array $params Name => value array of parameters.
     * @return string HTTP query.
     */
    public function buildHttpQuery(array $params, $method = 'GET') {
        if (empty($params)) {
            return '';
        }
    
        if ('GET' == $method) {
            $keys = $this->urlencode(array_keys($params));
            $values = $this->urlencode(array_values($params));
        } else {
            $keys = array_keys($params);
            $values = array_values($params);
        }
    
        $params = array_combine($keys, $values);
    
        uksort($params, 'strcmp');
    
        $pairs = array();
        foreach ($params as $key => $value) {
            $pairs[] = $key . '=' . $value;
        }
    
        return implode('&', $pairs);
    }
    
    /**
     * URL Encode.
     * @param mixed $item string or array of items to url encode.
     * @return mixed url encoded string or array of strings.
     */
    public function urlencode($item) {
        static $search = array('%7E');
        static $replace = array('~');
    
        if (is_array($item)) {
            return array_map(array(&$this, 'urlencode'), $item);
        }
    
        if (is_scalar($item) === false) {
            return $item;
        }
    
        return str_replace($search, $replace, rawurlencode($item));
    }
    
    /**
     * URL Decode.
     * @param mixed $item Item to url decode.
     * @return string URL decoded string.
     */
    public function urldecode($item) {
        if (is_array($item)) {
            return array_map(array(&$this, 'urldecode'), $item);
        }
    
        return urldecode($item);
    }
    public function actionIosaibei()
    {
        $tp = Yii::$app->getRequest()->getQueryParam('tp',1);
        $string = Yii::$app->getRequest()->getBodyParams();
        Yii::error("All Post data: -----\r\n".print_r($string,true));
    
        Yii::error("\r\n------All Post data end -------\r\n");
        $ipK = CfgIpayParams::findOne($tp);
        $source = "ipayios";
        //应用编号
        $appid=$ipK->appid;
        //应用私钥
//         $appkey="MIICXAIBAAKBgQCYy2UPvQIrjdNtbyCBfcTjxCP9df8JE18GJfPGuHkLDfuXcSkfI8I+mjxnr6eIkBvCwJYrbry1DNSG+9mfw/kpgnjqcdHffCvHSnqC6pORwu7t2q8H7au1LTXdTc99qdCa9QH2B9V3IKDatqZpohdSTbTU9PTsj+csD9rNRT8PFQIDAQABAoGABwd8a7/vRJ+utV8iaLKnhy7z1OpDxGAexAKk92RvNSH8jBgJo0Qa4JRp6P88vtyaWlhP0Em05sNjV55ogaAba0pBxNeZrp9sX5aRIvxyCBE21ZFpygKj+8tFCfFYQilDQS7i0uhrokpgQi2q1G787MmeFIEorJV1UNtcFde6zSECQQDGBoiss3gdAz0nB5DztJHVPL2IZnt8kF7kQdX+28+F22hCp6Ij/tCljCEHfPyEKJViXFuwJP2b0UvVuKJdBRUNAkEAxYbr4p9cfpMvHw6e9YLUhO1Nw4V6JmM3x/2wqzsLqmsDebfUa9D8aFq6XqrnUO6sD7Ki8FAVJrMZpylIYt1wKQJAabBfDd2Tg9iQsN4G7Ss4kliix8P6sFbVbnn83tMuhUC++qRBk3iSn2iU0ExS8a4/XInynaaAfMNN+Dlc3syxmQJBAIMk6Ug1djuzjP2Zv4BRtLfstkyyOj9ycH6fuMR3F2+2TUBrBOXwgyTl2AcygRIC5MonWHclNGXVU5rglebODsECQBUbb2cPFDWvFf7N2D8P6hOb5j15KLbPi6wjSeJjKg0qhAPpi7c6a5Nnm8Ka/JKF+pI4Y2/zGyW4MZ/J/WDh7HI=";
        $appkey = $ipK->privatekey;
        //平台公钥
        $platpkey = $ipK->platkey;
//         $platpkey="MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDIV5HiWUJ5Gou6vWXpArmNVdCEqvnmakIpCngoptQSlk29/+TzrBqdmom3EBAmBNEpHbbi5fqF2iG9fMRaWLRyxyqQnrftIBnHgYYRqvLUlzD7TH8kvS6L3oMP4bvu3JdaLohg8kIedikSvDrE/k+4XLj7YmGwjN4Bv0UWAt/GtQIDAQAB";
//         if ($tp==2)
//         {//应用编号
//             Yii::error("iosaibei 22222");
//             $source = "ipayios2";
//             $appid="3006530711";
//             //应用私钥
//             $appkey="MIICXAIBAAKBgQCKdepLCdyiO3uC8ZWde/1qHNo/DJk8DFndfToXcIDb5R8F0NkBL+lfNdMZwoyBd+oE3TH4uunb8nDUA12P0cMVe/BpKpLQUWSAoMYg4KIYC9JMZ149xS6xXcUd7K2KPvk3aCZz4wwdJkHXtyhgywLIGKPgNaEdeHlCCKvSCn0g8QIDAQABAoGAIyyrdZ6uv0QPL4fB830RNsjXpNbFgty8Y6kxfczl33cId4jD6CpMxhQ9abjjyuw0tkGfNUn+qRKhGSs1tJicT1NdRtAigHkdEFP+es7ZVj8FyNNf9+YuOBn7HnMD3adrNtlk/5y9mSH+kWqZ6jTo2j+1YJPoU9Sx63bSHLTHZgECQQDXzA8hXRrsGIYinnBHceAMjEqfNIqE7SBHUIu37Kb+t1r4Fk3YthKXbtQ2fO8Gk46p1xyk+t/qVFp1ktJ0OkRhAkEApEF4wGH/k63Hw/dlW2tmkQJyIlE6e7bmIYXc4v4q1rN1AeTs+6IUOHHgErF9gIwVTiV3I/St0TgrLDyaDxYmkQJAFZ+d+ILi2ruOXVOw/oe7oqZAJ/nU04MLU/oPNgvho+5tkCR0An4kGMaDPz5/mRIaHoyukx2MaGexdMyUiA76oQJARbpZdWnkoh96lzE1wNpV/ycHppPO/OfGx+JYw6/cJaqm+Dfjdmr2pIOK+MSKH4DYJoV3Dzd2dkOe6DeNuuvPUQJBAInZGA4GxBwgVyaSGOlEQ7qqLYAk2jBYKjVOH3W4vzuVpSzH+UMoCvrG+y94cQzcD7qv7QO8Tren4dBs2RiuNlQ=";
//             //平台公钥
//             $platpkey="MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCNAKaCSBWWbzA0GZwy8p1LOOEz2Wuk2QzeauN/ilm5BlYOhoPRTLFDeu1UgMKSfPq9UF+4aGXYbQYMTQhBnqGRoNeZGpRNYEPOsdlR4IIVYMNCjGU4g5bS5kYwzVwqd13tkFjfS39UeUrlsONk4DvrRZTEGm+eAA4Vd9hNLPSoPwIDAQAB";
//         }
    
        $transdata=$string['transdata'];
        //         echo "$transdata\n";
        if(stripos("%22",$transdata)){ //判断接收到的数据是否做过 Urldecode处理，如果没有处理则对数据进行Urldecode处理
            $string= array_map ('urldecode',$string);
        }
        $respData = 'transdata='.$string['transdata'].'&sign='.$string['sign'].'&signtype='.$string['signtype'];//把数据组装成验签函数要求的参数格式
        //  验签函数parseResp（） 中 只接受明文数据。数据如：transdata={"appid":"3003686553","appuserid":"10123059","cporderid":"1234qwedfq2as123sdf3f1231234r","cpprivate":"11qwe123r23q232111","currency":"RMB","feetype":0,"money":0.12,"paytype":403,"result":0,"transid":"32011601231456558678","transtime":"2016-01-23 14:57:15","transtype":0,"waresid":1}&sign=jeSp7L6GtZaO/KiP5XSA4vvq5yxBpq4PFqXyEoktkPqkE5b8jS7aeHlgV5zDLIeyqfVJKKuypNUdrpMLbSQhC8G4pDwdpTs/GTbDw/stxFXBGgrt9zugWRcpL56k9XEXM5ao95fTu9PO8jMNfIV9mMMyTRLT3lCAJGrKL17xXv4=&signtype=RSA
        //         echo "进入了2".$respData;
        $nIpay = new ipay();
        $respJson="";
        if(!$nIpay->parseResp($respData, $platpkey, $respJson)) {
        //验签失败
        Yii::error("验签失败");
        echo 'failed'."\n";
        }else{
        //验签成功
            //             echo 'success'."\n";
            //以下是 验签通过之后 对数据的解析。
            $transdata=$string['transdata'];
            $arr=json_decode($transdata);
            $transtype = $arr->transtype;
            $appidx=$arr->appid;
            $appuserid=$arr->appuserid;
            $cporderid=$arr->cporderid;
            $cpprivate=$arr->cpprivate;
            $money=$arr->paytype;
            $result=$arr->result;
            $transid=$arr->transid;
            $transtime=$arr->transtime;
            $waresid=$arr->waresid;
            $tryexist = LogIpaynotice::find()->where(['cporderid'=>$cporderid])->count();
            if ($tryexist ==0 ){
            Yii::error("ipay订单信息未录入，现在录入");
                $ipaylog = new LogIpaynotice();
            $ipaylog->appid=$appidx;
                $ipaylog->appuserid=$appuserid;
                $ipaylog->cporderid=$cporderid;
                $ipaylog->cpprivate=$cpprivate;
                $ipaylog->currency=$arr->currency;
                $ipaylog->transtype=$arr->transtype;
                $ipaylog->transid=$arr->transid;
                $ipaylog->transtime=$arr->transtime;
                $ipaylog->feetype=$arr->feetype;
                $ipaylog->money=strval($money);
                $ipaylog->paytype=$arr->paytype;
                $ipaylog->result=$arr->result;
                $ipaylog->Sign="xx";
                if ($ipaylog->save())
                {
                //                 echo "save ipaylog success ";
                Yii::error("保存订单信息成功");
            }else {
            //                 echo "save ipaylog success ";
            Yii::error(print_r($ipaylog->getErrors(),true));
            }
    
            }
            if ($appid==$appidx){
            $orderx= GmOrderlist::findOne(['orderid'=>$cporderid,'playerid'=>$appuserid]);
            if (is_object($orderx))
            {
            Yii::error("订单号找到,订单金额".$orderx->fee." 通知金额".$money);
            if ($orderx->status==0)
            {
            Yii::error("订单状态为未支付，现在支付");
            $orderx->status=1;
            $orderx->transaction_id=$transid;
            $orderx->transaction_time = $transtime;
            $orderx->utime=date('Y-m-d H:i:s');
            $orderx->source=$source;
            if ($orderx->save()){
            Yii::error("订单状态修改成功，等待服务器处理".$cporderid);
                echo 'SUCCESS';
            }else {
            Yii::error("订单状态修改失败".print_r($orderx->getErrors(),true));
            }
            }else {

            Yii::error("订单号找到,订单『".$cporderid."』状态不为0");
            return 'SUCCESS';
            }
            }else{
            Yii::error("订单号未找到，".$cporderid);
            }
            }else
            {
            Yii::error("appid商户appid 错误不匹配");
            }
        } 
    }
    
    public function actionAibei()
    {
        $string = Yii::$app->getRequest()->getBodyParams();
        Yii::error("All Post data: -----\r\n".print_r($string,true));

        Yii::error("\r\n------All Post data end -------\r\n");
        

        //应用编号
        $appid="3004732206";
        //应用私钥
        $appkey="MIICXAIBAAKBgQCmxsgy+gegjpt777uhkkSgs6Z9k9/Jy6Jw0TDjJTei2hDYJLTBSbz97qjBOda1MafWy/fxVH9ALOnkWNnheccaxX0JlHxsWZNzD01SxkYT841QA98BkoLZ/EW9tvWHWyIFpkJygUheHh47ELh5a6t4CrVswSPUD/mu6fWVvBprTwIDAQABAoGAWEkgj8PGJ9t2OayV0hlBFSUk/JM8Q3H2AuzqiUQZaK8xfYoo2a10S6R8VxWMMI0hwVZmYa2OU2WzRzs10+OIXyuBnvDxcaLDuTzOzWIRlVIsWgFIigodiK2TfS15RY+m79LK5l/GHyy9DmCXwC6P5V4HPiaqWjT24ocD97+Ly+ECQQDbp7sllX4t4swyy14mcmrls8+6ACTWAk8AZ2WC+OHSevKNbxpi5FAmrBMhMYlrH4amG5IcFeaDTIWakXwOfGvRAkEAwl8v8GDz6PWBXVwQHLHVBSFKSqnZW/r94bGm1YZeQrBF0J3aP/2+tazTXg5s2GWaJOS8JeF+Eo2ZA6n5UUPNHwJBAKuRyhZDPHmu6vzJ6NJzEJg26QxJzHv09axFFv9EU29KZWaf36Za21g5k/+bZ9DqoQviATA60wC/pqPi+1l9SeECQDTs4EvOyntzZf860zRNA9j6wJTl/MZ76GdtDSV1CfOUtd3hLY1hFW24mnEw8lhWCgvjsIuMA90fazvBK58CHDcCQG0Vw03Va92H8s9CpyoxikuQOk5bBMtJcTzfzG1WqBmchgVTHQ5HJu3us23teqNQxWHH8hh/+6SFBWldj0w47M8=";
        //平台公钥
        $platpkey="MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDQT7zbCuIqvrhQt0Z2BKAdQWmV2OySKEyJgs/TYk/i0JwK5P8v91NRLRaEunrHhhmV9iHIMSxpYFQqo1y4gglpQZPg9DeK7dfFyerp2OpNjB+8L4/SfoFUbKZWcUW+YqhXzTh+T67Rrk7p85e0DqeUju8ZS4stHEH/knbOwROrEwIDAQAB";
        
        
        $transdata=$string['transdata'];
//         echo "$transdata\n";
        if(stripos("%22",$transdata)){ //判断接收到的数据是否做过 Urldecode处理，如果没有处理则对数据进行Urldecode处理
        $string= array_map ('urldecode',$string);
        }
        $respData = 'transdata='.$string['transdata'].'&sign='.$string['sign'].'&signtype='.$string['signtype'];//把数据组装成验签函数要求的参数格式
        //  验签函数parseResp（） 中 只接受明文数据。数据如：transdata={"appid":"3003686553","appuserid":"10123059","cporderid":"1234qwedfq2as123sdf3f1231234r","cpprivate":"11qwe123r23q232111","currency":"RMB","feetype":0,"money":0.12,"paytype":403,"result":0,"transid":"32011601231456558678","transtime":"2016-01-23 14:57:15","transtype":0,"waresid":1}&sign=jeSp7L6GtZaO/KiP5XSA4vvq5yxBpq4PFqXyEoktkPqkE5b8jS7aeHlgV5zDLIeyqfVJKKuypNUdrpMLbSQhC8G4pDwdpTs/GTbDw/stxFXBGgrt9zugWRcpL56k9XEXM5ao95fTu9PO8jMNfIV9mMMyTRLT3lCAJGrKL17xXv4=&signtype=RSA
//         echo "进入了2".$respData;
        $nIpay = new ipay();
        $respJson="";
        if(!$nIpay->parseResp($respData, $platpkey, $respJson)) {
            //验签失败
            Yii::error("验签失败");
            echo 'failed'."\n";
        }else{
            //验签成功
//             echo 'success'."\n";
            //以下是 验签通过之后 对数据的解析。
                $transdata=$string['transdata'];
                $arr=json_decode($transdata);
                    $transtype = $arr->transtype;
					$appidx=$arr->appid;
        					$appuserid=$arr->appuserid;
        					$cporderid=$arr->cporderid;
        					$cpprivate=$arr->cpprivate;
        					$money=$arr->paytype;
        					$result=$arr->result;
        					$transid=$arr->transid;
        					$transtime=$arr->transtime;
        					$waresid=$arr->waresid;
//         					echo "$appidx\n";
//                 echo "$appuserid\n";
//                 echo "$cporderid\n";
//                 echo "$cpprivate\n";
//                 echo "$money\n";
//                 echo "$result\n";
//                 echo "$transid\n";
//                 echo "$transtime\n";
//                 echo "$waresid\n";
            $tryexist = LogIpaynotice::find()->where(['cporderid'=>$cporderid])->count();
            if ($tryexist ==0 ){
                Yii::error("ipay订单信息未录入，现在录入"); 
                $ipaylog = new LogIpaynotice();
                $ipaylog->appid=$appidx;
                $ipaylog->appuserid=$appuserid;
                $ipaylog->cporderid=$cporderid;
                $ipaylog->cpprivate=$cpprivate;
                $ipaylog->currency=$arr->currency;
                $ipaylog->transtype=$arr->transtype;
                $ipaylog->transid=$arr->transid;
                $ipaylog->transtime=$arr->transtime;
                $ipaylog->feetype=$arr->feetype;
                $ipaylog->money=strval($money);
                $ipaylog->paytype=$arr->paytype;
                $ipaylog->result=$arr->result;
                $ipaylog->Sign="xx";
                if ($ipaylog->save())
                {
    //                 echo "save ipaylog success ";
                    Yii::error("保存订单信息成功");
                }else {
    //                 echo "save ipaylog success ";
                    Yii::error(print_r($ipaylog->getErrors(),true));
                }
            
            }
            if ($appid==$appidx){
               $orderx= GmOrderlist::findOne(['orderid'=>$cporderid,'playerid'=>$appuserid]);
               if (is_object($orderx))
               { 
                   Yii::error("订单号找到,订单金额".$orderx->fee." 通知金额".$money);
                   if ($orderx->status==0)
                   {
                       Yii::error("订单状态为未支付，现在支付");
                       $orderx->status=1;
                       $orderx->transaction_id=$transid;
                       $orderx->transaction_time = $transtime;
                       $orderx->utime=date('Y-m-d H:i:s');
                       $orderx->source="ipay";
                       if ($orderx->save()){ 
                           Yii::error("订单状态修改成功，等待服务器处理".$cporderid);
                           echo 'SUCCESS';
                       }else { 
                           Yii::error("订单状态修改失败".print_r($orderx->getErrors(),true));
                       }
                   }else {

                       Yii::error("订单号找到,订单『".$cporderid."』状态不为0");
                        return 'SUCCESS';
                   }
               }else{
                   Yii::error("订单号未找到，".$cporderid); 
               }
            }else
            { 
                Yii::error("appid商户appid 错误不匹配");
            }
         }
        
        
    }

    /**
     * ANYSDK 支付通知
     * 
     * @param unknown $type
     * @return string
     */
    public function actionPaynotice()
    {
        $an = new AnySDK();
//         if (AnySDK::checkAnySDKSever()){
        $privateKey = "696064B29E9A0B7DDBD6FCB88F34A555";
        $enhancedKey = 'MmZlMGQ0YTEwOTllZDViNTVkMTc';
        Yii::error(print_r(Yii::$app->getRequest()->getBodyParams(),true),'anysdk');
        $params = $_POST;
        //注意：$_POST数据如果服务器没有自动处理urldecode，请做一次urldecode(参考rfc1738标准)处理
        //foreach ($params as $key => $value) {
        //        $params[$key] = urldecode($value);
        //}
        /**
         * 参数	参数类型	说明
order_id	string	订单号，AnySDK产生的订单号
product_count	string	要购买商品数量（暂不提供具体数量）
amount	string	支付金额，单位元 值根据不同渠道的要求可能为浮点类型
下列渠道请不要使用此金额字段作为发放道具的依据，而应该使用product_id作为发放道具的依据：
    GooglePlay
    Apple appstore
    心动（非越狱）
pay_status	string	支付状态，1为成功，非1则为其他异常状态
pay_time	string	支付时间，YYYY-mm-dd HH:ii:ss格式
user_id	string	用户id，用户系统的用户id
order_type	string	支付方式，详见支付渠道标识表
game_user_id	string	游戏内用户id,支付时传入的Role_Id参数
server_id	string	服务器id，支付时传入的server_id 参数
product_name	string	商品名称，支付时传入的product_name 参数
product_id	string	商品id,支付时传入的product_id 参数
下列渠道请使用此product_id作为发放道具的依据，而不要使用金额amount字段作为发放道具的依据：
    GooglePlay
    Apple appstore
    心动（非越狱）
private_data	string	自定义参数，调用客户端支付函数时传入的EXT参数，透传给游戏服务器
channel_number	string	渠道编号
sign	string	通用签名串，通用验签参考签名算法
source	string	渠道服务器通知 AnySDK 时请求的参数
enhanced_sign	string	增强签名串，验签参考签名算法（有增强密钥的游戏有效）
channel_order_id	string	渠道订单号，如果渠道通知过来的参数没有渠道订单号则为空。
         */
        //注意：如果没有增强密钥的游戏只需要通用验签即可，即只需要checkSign
        //if (checkSign($params, $privateKey)) {
        if ($an->checkEnhancedSign($params, $enhancedKey)) {
//             checkAmount($params);
            $this->savesLog("anysdk notice : ".json_encode($params), "error");
            // @todo 验证成功，游戏服务器处理逻辑
            if ($params['pay_status']==1){
                $anyorderid = $params['order_id'];
                $any = AnyOrderLogs::findOne(['order_id'=>$anyorderid]);
                $arext = explode('_._', $params['private_data']);
                $gm_proid= $arext[0];
                $gm_orderid = $arext[1];
                $gm_uid=$arext[2];
                if (!is_object($any)){
                    $any = new AnyOrderLogs();
                    $any->attributes = $params;
                    $arext = explode('_._', $params['private_data']);
                    $any->gm_proid= $arext[0];
                    $any->gm_orderid = $arext[1];
                    $any->gm_uid=$arext[2];
                    $any->save();
                }
                $trascount= GmOrderlist::find()->where(['transaction_id'=>$params['order_id']])->count();//查看是否有其他订单被渠道订单支付过
                if ($trascount==1) {
                    $this->savesLog("anysdk pay notice order has been resolved  ".$gm_orderid." trans id :".$params['order_id'], 'error');
                    return "ok";//已通知过
                }
                $ordercount = GmOrderlist::find()->where(['orderid'=>$gm_orderid,'playerid'=>$gm_uid,'status'=>0])->count();//找订单
                if ($ordercount==1){ 
                    $order =  GmOrderlist::find()->where(['orderid'=>$gm_orderid,'playerid'=>$gm_uid,'status'=>0])->one();
                    if ($order->productid != $gm_proid)
                    {
                        $this->savesLog("anysdk order notice error orderid: ".$gm_orderid.",productid  ".$gm_proid." orderProduct : ".$order->product_id, "anysdk");
                        return "ok";
                    }
                    if (intval($order->fee)!=intval($params['amount']))
                    {
                        $this->savesLog("玩家伪造支付价格,订单号".$gm_orderid, 'anysdkfade');
                        return "ok";
                    }
                    $order->source = $params['channel_number'];
                    $order->status=1;
                    $order->transaction_id = $params['order_id'];
                    $order->transaction_time = $params['pay_time'];
                    $order->utime = date('Y-m-d H:i:s');
                    if ($order->save()){
                        return "ok";
                    }else {
                        $this->savesLog("anysdk pay notice save orderid: ".$gm_orderid." failed :".print_r($order->getErrors(),true), 'error');
                        return "error when save ";
                    }
                }else {
                    $this->savesLog("anysdk pay notice order not found orderid ".$gm_orderid, 'error');
                }
            }
//             echo "ok";
        } else {
            //@todo
            Yii::error("anysdk check sign failed ","anysdk");
//             echo "Wrong signature.";
            return "failed";
        }
        echo "\n check sdk server";
//         }
        
    }
    public function actionGmnotice()
    {
//         $type=Yii::$app->getRequest()->getQueryParam('type',0);
        
        $lists_0 = GmNotice::getNoticeList(0);
        $lists_1 = GmNotice::getNoticeList(1);
        $ua = Yii::$app->getRequest()->getHeaders()['user-agent'];
	    
	        
        $res = ApiErrorCode::$OK;
        $res['gonggao']=$lists_0;
        $res['huodong']=$lists_1;

        $ver=Yii::$app->getRequest()->getQueryParam('v');
        $param_v_info = explode('_._', $ver);
        $osver = $param_v_info[0];
        if (preg_match('/(iphone|ipad|ipod|ios)/i',strtolower($ua))||preg_match('/(iphone|ipad|ipod|ios)/i',strtolower($osver))){
            $res['huodong']=array_merge( $res['huodong'],GmNotice::getNoticePlatform(1,0));
        }
        return json_encode($res);
    }
    public function actionWxprepay($orderid)
    {
        $orderid = Yii::$app->getRequest()->getQueryParam('orderid');
        $orderinfo = GmOrderlist::findOne(['orderid'=>$orderid,'status'=>0]);
        if (!is_object($orderinfo)){
            return json_encode(ApiErrorCode::$OrderIdError);
        }
        
        $input = new WxPayUnifiedOrder();
        $input->SetBody($orderinfo->product->product_desc);
        $input->SetAttach( $orderinfo->productid." ".$orderid." ".$orderinfo->playerid);
        $input->SetOut_trade_no($orderid);
        $input->SetTotal_fee($orderinfo->fee*100);
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetNotify_url(Yii::$app->getRequest()->getHostInfo()."/wxnotify/".$orderid."/".$orderinfo->playerid);
        $input->SetTrade_type("APP");
        $order = WxPayApi::unifiedOrder($input);
        Yii::error("发起微信支付统一下单请求结果 : ".json_encode($order),"wxpay");
        
        $data=["appid"=>$order['appid'],
        "noncestr"=>$order['nonce_str'],
        "package"=>"Sign=WXPay",
        "partnerid"=>$order['mch_id'],
        "prepayid"=>$order['prepay_id'],
        "timestamp"=>time()];
        $sign = WxPayDataBase::MakeOnlySign($data);
        $data['sign']=$sign;
        /**{ "appid":"wxb4ba3c02aa476ea1",
         "noncestr":"40fa4fd12b3898e22f9c881c67903fc7",
         "package":"Sign=WXPay", 
         "partnerid":"10000100", 
         "prepayid":"wx201512172356171fb4e859f70466072389", 
         "timestamp":"1450367777", 
         "sign":"0C248F0D1A157F0E1C7F866D406E0425" }
         {"appid":"wx0d2f5bd9dd619438",
         "noncestr":"VU0DBpCF9DA8bYH8",
         "package":"Sign=WXPay",
         "partnerid":"1280663501",
         "prepayid":"wx20151218004222e2deace4d00184632662",
         "timestamp":1450370543,
         "sign":"CEC1E447442F54629021CF36B25CA64C"}
        //{"appid":"wx0d2f5bd9dd619438",
         * "mch_id":"1280663501",
         * "nonce_str":"YYpq4iCIgEXrFMKq",
         * "prepay_id":"wx201512172355045909e2f49c0055105926",
         * "result_code":"SUCCESS",
         * "return_code":"SUCCESS",
         * "return_msg":"OK",
         * "sign":"3A5E275B9E4848F2580CE92FE027E4E8",
         * "trade_type":"APP"}
        **/
        
        return  json_encode($data);
    }
    public function actionMails($type)
    {
        $gid=Yii::$app->getRequest()->getQueryParam('gid');
        $usertoken = Yii::$app->getRequest()->getQueryParam('usertoken');
        $usercount = GmAccountInfo::find()->where(['gid'=>$gid,'token'=>$usertoken])->count();
        if ($usercount == 0)
        {
            return json_encode(ApiErrorCode::$AccountLoginError);
        } 
         if ($type=="list"){
            $res=ApiErrorCode::$OK;
            $mailList=LogMail::getMailList($gid);
            if (count($mailList)>0)
                $res['lists']=$mailList;
            $channel = Yii::$app->getRequest()->getQueryParam('channel');
            $dev=Yii::$app->getRequest()->getQueryParam('d');
            $param_dev_uuid = explode('_._', $dev);
            $dev_id = isset($param_dev_uuid[2])?$param_dev_uuid[2]:"x";
            if ($channel==1003)
                $this->s2scallback($dev_id);
        }elseif ($type=="read"){
            $res=ApiErrorCode::$OK;
            $mailid=Yii::$app->getRequest()->getQueryParam('mailid',0);
            if($mailid!=0){
                LogMail::readMail($mailid);
            }
        }elseif ($type=="count"){
            $c = LogMail::getUnread($gid);
            $res=ApiErrorCode::$OK;
            $res['count']=$c;
        }
        return json_encode($res);
    }
    public function actionRegister($type)
    {//正常注册接口    
//         $udid=Yii::$app->getRequest()->getQueryParam('udid');
        $name=Yii::$app->getRequest()->getQueryParam('name');
        $pwd=Yii::$app->getRequest()->getQueryParam('pwd');
        $pwd_q=Yii::$app->getRequest()->getQueryParam('pwd_q');
        $pwd_a=Yii::$app->getRequest()->getQueryParam('pwd_a');
        $channel=Yii::$app->getRequest()->getQueryParam('channel'); 
        //
        $buildcode = Yii::$app->getRequest()->getQueryParam('vercode',0);
        $ua=Yii::$app->getRequest()->getUserAgent();
        //
        $platformios = false;
        preg_match('/ios/', $ua,$mchd);
        if (count($mchd)>0)
        {//ios用户
            $platformios=true;
        }
        $rlchannel= GmChannelInfo::findOne(['any_channel'=>$channel]);//匹配注册渠道 不能影响官方渠道编号，只能在渠道信息里做配置
        if (is_object($rlchannel)){
            $channel =$rlchannel->cid;
        }
        $dev=Yii::$app->getRequest()->getQueryParam('d');
        $ver=Yii::$app->getRequest()->getQueryParam('v');
        $param_v_info = explode('_._', $ver);
        $osver = $param_v_info[0];
//         if ($osver!="1.5")
        if(Yii::$app->params["ServiceNotValiable"] &&  Yii::$app->getRequest()->userIP!="101.251.1.147")
            return json_encode(ApiErrorCode::$ServiceNotValiable);
        $appver = $param_v_info[1];
        preg_match('/iToolsAVM/', $appver,$mxc);
        if (count($mxc)>0)
        {
            $this->logtodb('guanggao', "广告用户iToolsAVM_T拒绝登录 ".$appver);
            return json_encode(ApiErrorCode::$BlackListxError);
        }
        $lineNo = $param_v_info[2];
        $param_dev_uuid = explode('_._', $dev);
        $uuid = $param_dev_uuid[0];
        $simSerial = $param_dev_uuid[1];
        $dev_id = $param_dev_uuid[2];
        if ($dev_id=="")
            $dev_id=$uuid;
        preg_match('/^3522840/', $appver,$mxc);
        if (count($mxc)>0 && $channel=="2060")
        {
            $this->logtodb('guanggao', "广告用户3522840拒绝登录 ".$dev_id);
            return json_encode(ApiErrorCode::$BlackListxError);
        }
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
//         if($channel==2044||$channel==2014)
//         {
//             $kw="black".$realIp;
//             $dt =  Yii::$app->cache[$kw];
//             if ($dt === false){
// //                 $this->savesLog("ip无记录,初始1 ".$kw, "error");
//                 Yii::$app->cache->set($kw, 1,600);
//             }else {
// //                 $this->savesLog("ip有记录记录,+1 ".$kw." 记录数".$dt, "error");
//                 Yii::$app->cache->set($kw, $dt+1,600);
//                 if ($dt >= 5 ){
//                     $this->savesLog("|刷号ip |".$realIp."|累计 超过|".$dt."|直接黑名单", "black");
//                     return json_encode(ApiErrorCode::$BlackListError);
//                 }
//             }
//         }
//         $dataBlackList=Yii::$app->cache["blackQuickRegisterList"];
//         if(is_array($dataBlackList)){
//             foreach ($dataBlackList as $v)
//             {
//                 if ($realIp==$v)
//                     return json_encode(ApiErrorCode::$BlackListError);
//             }
//         }
//         $mxid = Yii::$app->db->createCommand("select max(gid) from gm_account_info")->queryScalar();
        //@TODO 靓号过滤
        if ($type == 0){//正常注册
            if ($name==""||$pwd==""||$pwd_a==""||$pwd_q==""|| $dev == "" ||count($param_dev_uuid)<3)
            {
                Yii::error("param miss ".$name." pwd : ".$pwd." dev: ".$dev." count dev : ".count($param_dev_uuid));
                return json_encode(ApiErrorCode::$invalidParam);
            }
            if ($pwd=='123456'&& $channel==2014 && $pwd_q==4)
            {
                $this->savesLog('优异刷号'.$channel." pwd: ".$pwd." name:".$name, 'ttszp');
                return json_encode(ApiErrorCode::$OK);
            }
            if ($simSerial == ""){
                $simSerial=$dev_id;
//                 return json_encode(ApiErrorCode::$AccountSimNoneError);
            }
            $countSim = GmAccountInfo::find()->where(['type'=>0,'device_id'=>$dev_id])->count();
            if ($countSim >= 5 && !$this->whiteIme($dev_id))
                return json_encode(ApiErrorCode::$SimError);
            $countSim = GmAccountInfo::find()->where(['type'=>0,'account_name'=>$name])->count();
            if ($countSim > 0)
                return json_encode(ApiErrorCode::$AccountNameError);
            $user = new GmAccountInfo();
            $user->account_name = urldecode($name);
            $user->account_pwd = $user->encryptPass(urldecode($pwd));
            $user->pwd_a = $pwd_a;
            $user->pwd_q = $pwd_q;
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
//                 if ($channel == 1003)
//                 { 
//                     $x=$this->s2scallback($dev_id); 
//                 }
                $info = ['gid'=>$user->gid,'token'=>$token,
//                     'servip'=>Yii::$app->params['serip'],'servport'=>Yii::$app->params['serport'],'servid'=>Yii::$app->params['serid']
                ];
                $res = ApiErrorCode::$OK;
                $gs = $this->getServerInfo($channel,$user->gid,$appver,$buildcode);
                $info = array_merge($info,$gs);
//                 if ($channel==1000||$channel==1002||$channel==1004)
//                     $info['isdiandangoff']=1; 
                $res['info']=$info;
                $this->saveLogin("normalRegister", $user->gid, $channel, Yii::$app->getRequest()->getUserIP(), $ver, $dev);
                
                return  json_encode($res);
            }else{
                $this->savesLog("Save account  info failed ".print_r($user->getErrors(),true),'error');
                return json_encode(ApiErrorCode::$AccountError);
            }
                
        }else if($type == 1) {//快速注册
            
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
//             elseif (strtotime($user->last_login)>(time()-15) && Yii::$app->getRequest()->getHostInfo()!="http://zjh.koudaishiji.com"){
//                 $rex=ApiErrorCode::$RequestToMuch;
//                 $rex['msg'].=" last :".$user->last_login." time:".time();
//                 $this->savesLog("gid:".$user->gid."last login :".$user->last_login, 'error');
//                 return json_encode(ApiErrorCode::$RequestToMuch);
//             }
            $user->last_login = date('Y-m-d H:i:s');
            $token = md5(time().$user->gid);
            $user->token = $token;
            if ($user->isNewRecord)
                $keywords = 'quickRegister';
            else 
                $keywords = 'quickLogin';
//             if ($channel == 1003)
//             {
//                 $x=$this->s2scallback($dev_id);
//             }
            if($user->save()){
                
                $info = ['gid'=>$user->gid,'token'=>$token,
//                     'servip'=>Yii::$app->params['serip'],'servport'=>Yii::$app->params['serport'],'servid'=>Yii::$app->params['serid']
                ];
    
                $res = ApiErrorCode::$OK;
                $gs = $this->getServerInfo($channel,$user->gid,$appver,$buildcode);
                $info = array_merge($info,$gs);
//                 if ($channel==1000||$channel==1002||$channel==1004)
//                     $info['isdiandangoff']=1;
                $res['info']=$info;
//                 if ($user->isNewRecord)
//                     $this->savesLog("gid:".$user->gid." keywords:".$keywords." save last login :".$user->last_login, 'error');
                $this->saveLogin($keywords, $user->gid, $channel, Yii::$app->getRequest()->getUserIP(), $ver, $dev);
//                 else 
//                     $this->saveLogin("quickLogin", $user->gid, $channel, Yii::$app->getRequest()->getUserIP(), $ver, $dev);
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
            //应用宝uid太长直接写入uuid判断
            if ($sdkchannel==550){
                $user = GmAccountInfo::findOne(['op_uuid'=>$channeluid,'type'=>2]);
            }
            if (!$user){
                $countSim = GmAccountInfo::find()->where(['type'=>2,'device_id'=>$dev_id])->count();
                if ($countSim >= 5 && !$this->whiteIme($dev_id))
                    return json_encode(ApiErrorCode::$SimError);
                $user = new GmAccountInfo();
                $user->op_uuid = $uuid; 
                $user->type = 2;
                $user->account_name =$name;
                if ($sdkchannel==550){
                    $user->op_uuid = $channeluid;
                    $user->account_name ='YSDK'.time().rand(000, 999);
                }
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
//             if (strtotime($user->last_login)>(time()-15) && Yii::$app->getRequest()->getHostInfo()!="http://zjh.koudaishiji.com")
//                 return json_encode(ApiErrorCode::$RequestToMuch);
            $user->last_login = date('Y-m-d H:i:s');
            $token = md5(time().$user->gid);
            $user->token = $token;
            if($user->save()){
                $info = ['gid'=>$user->gid,'token'=>$token,
//                     'servip'=>Yii::$app->params['serip'],'servport'=>Yii::$app->params['serport'],'servid'=>Yii::$app->params['serid']
                ];
                if ($sdkchannel=="215")//百度不开放娱乐城
                    $info['enableYLC']="NO";
                $res = ApiErrorCode::$OK;
                $gs = $this->getServerInfo($channel,$user->gid,$appver,$buildcode);
                $info = array_merge($info,$gs);
                $res['info']=$info;
                $this->saveLogin("SDKlogin", $user->gid, $sdkchannel, Yii::$app->getRequest()->getUserIP(), $ver, $dev);
                return  json_encode($res);
            }else {
                $this->savesLog("Save  SDKlogin account info failed ".print_r($user->getErrors(),true),'error');
                return json_encode(ApiErrorCode::$AccountError);
            }
        }else if($type == 3) {//YSDK登录
            $countSim = GmAccountInfo::find()->where(['type'=>3,'device_id'=>$dev_id])->count();
            if ($countSim >= 2 && !$this->whiteIme($dev_id))
                return json_encode(ApiErrorCode::$SimError);
            $openid=Yii::$app->getRequest()->getQueryParam('openid');
            $platform=Yii::$app->getRequest()->getQueryParam('platform');
            if ($platform==1){
                $name="Y_QQ_".time().rand(111, 999);
            }else {
                $name="Y_WX_".time().rand(111, 999);
            }
            
            $user = GmAccountInfo::findOne(['op_uuid'=>$openid,'type'=>3]); 
            if (!$user){
                $user = new GmAccountInfo();
                $user->op_uuid = $openid; 
                $user->type = 3;
                $user->account_name =$name;  
                $user->account_pwd = "NoPasswd";
                $user->pwd_q = 0;
                $user->pwd_a = "YSDKlogin";
                $user->sim_serial = $simSerial==""?$uuid:$simSerial;
                $user->reg_channel = strval($channel);
                $user->reg_time = date('Y-m-d H:i:s');
                $user->device_id = $dev_id;
            }elseif ($user->status!=0){
                $this->savesLog(" YSDKlogin account in blacklist ",'error');
                return json_encode(ApiErrorCode::$AccountError);
            }
//             if (strtotime($user->last_login)>(time()-15) && Yii::$app->getRequest()->getHostInfo()!="http://zjh.koudaishiji.com")
//                 return json_encode(ApiErrorCode::$RequestToMuch);
            $user->last_login = date('Y-m-d H:i:s');
            $token = md5(time().$user->gid);
            $user->token = $token;
            if($user->save()){
                $info = ['gid'=>$user->gid,'token'=>$token,
//                     'servip'=>Yii::$app->params['serip'],'servport'=>Yii::$app->params['serport'],'servid'=>Yii::$app->params['serid']
                ]; 
                $res = ApiErrorCode::$OK; 
                $gs = $this->getServerInfo($channel,$user->gid,$appver,$buildcode);
                $info = array_merge($info,$gs);
                $res['info']=$info;
                $this->saveLogin("YSDKlogin", $user->gid, $channel, Yii::$app->getRequest()->getUserIP(), $ver, $dev);
                return  json_encode($res);
            }else {
                $this->savesLog("Save  YSDKlogin account info failed ".print_r($user->getErrors(),true),'error');
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
        //
        $buildcode = Yii::$app->getRequest()->getQueryParam('vercode',0);
        $rlchannel= GmChannelInfo::findOne(['any_channel'=>$channel]);//匹配注册渠道 不能影响官方渠道编号，只能在渠道信息里做配置
        if (is_object($rlchannel)){
            $channel =$rlchannel->cid;
        }
        $dev=Yii::$app->getRequest()->getQueryParam('d');
        $ver=Yii::$app->getRequest()->getQueryParam('v');
        $param_v_info = explode('_._', $ver);
        $osver = $param_v_info[0];
        if(Yii::$app->params["ServiceNotValiable"] &&  Yii::$app->getRequest()->userIP!="101.251.1.147")
            return json_encode(ApiErrorCode::$ServiceNotValiable);
        $appver = $param_v_info[1];
        preg_match('/iToolsAVM_T/', $appver,$mxc);
        if (count($mxc)>0 && $channel=="2060")
        {
            $this->logtodb('guanggao', "广告用户iToolsAVM_T拒绝登录 ".$appver);
            return json_encode(ApiErrorCode::$BlackListxError);
        }
        $lineNo = $param_v_info[2];
        $param_dev_uuid = explode('_._', $dev);
        $uuid = $param_dev_uuid[0];
        $simSerial = $param_dev_uuid[1];
        $dev_id = $param_dev_uuid[2];
        preg_match('/^3522840/', $appver,$mxc);
        if (count($mxc)>0 && $channel=="2060")
        {
            $this->logtodb('guanggao', "广告用户3522840拒绝登录 ".$dev_id);
            return json_encode(ApiErrorCode::$BlackListxError);
        }
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
//             if (strtotime($user->last_login)>(time()-15) && Yii::$app->getRequest()->getHostInfo()!="http://zjh.koudaishiji.com")
//                 return json_encode(ApiErrorCode::$RequestToMuch);
            $user->last_login = date('Y-m-d H:i:s');
            $token = md5(time().$user->gid);
            $user->token = $token;
            if($user->save()){
                $info = ['gid'=>$user->gid,'token'=>$token,                    
                ];
                $res = ApiErrorCode::$OK;
                $gs = $this->getServerInfo($channel,$user->gid,$appver,$buildcode);
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
        }
    }
    
    
    function s2scallback($dev)
    {
        $kw="s2s_".strtolower($dev);
        $trans =  Yii::$app->cache[$kw];
        if ($trans != false && is_array($trans)){
            $transid = $trans['transaction_id'];
            $affiliate_id = $trans['affiliate_id'];
            $aff_sub8 = $trans['aff_sub8'];
            $source =  $trans['source'];
            $channel = $trans['channel'];
            $this->savesLog("s2s transid is not null :".$transid, "debug");
            $urlx="http://global.ymtracking.com/conv?transaction_id={".$transid."}&affiliate_id={".$affiliate_id."}&aff_sub8={".$aff_sub8."}&source=".$source."&channel=".$channel;
            $this->savesLog("s2s channel register callback url: ".$urlx, "debug");
            $rex=$this->getClient($urlx);
            //                         $this->savesLog("s2s channel register callback url: ".$urlx." response:".$rex, "debug");
        } 
        return "";
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
//         foreach (Yii::$app->params['blacklist'] as $ggid)
//         {
//             if ($ggid==$ime)
//                 return true;
//         }
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
    
    function getServerInfo($channel,$gid,$appver,$buildcode) 
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
//                 $gs = CfgServerlist::findOne(['status'=>0,'server_type'=>'2']);
//                 if (is_object($gs))//服务器地址
//                 {
//                     $serverinfo['servip'] = $gs->serverip;
//                     $serverinfo['servport'] = strval($gs->serverport);
//                     $serverinfo['servid'] = $gs->serverid;
//                 }
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
        $ch = GmChannelInfo::findOne($channel);
        if (is_object($ch))
        {
            if ($ch->ipay!="")
                $serverinfo['ippayparam']=CfgIpayParams::findOne($ch->ipay)->attributes; 
            $serverinfo['pay_method']=intval($ch->pay_method);  
            if ($ch->inreviewstat == 1 && $buildcode>= $ch->inreviewbuild)
            {
                $serverinfo['servip'] = "gfgs.koudaishiji.com";
                $serverinfo['isdiandangoff']=1;
            }
        }else {
            Yii::error("channelnot exist:".$channel);
        } 
        return $serverinfo;
    }
    
    public function actionTree($type)
    {
        $gid=Yii::$app->getRequest()->getQueryParam('gid');
        $usertoken = Yii::$app->getRequest()->getQueryParam('usertoken');
        $usercount = GmAccountInfo::find()->where(['gid'=>$gid,'token'=>$usertoken])->count();
        if ($usercount == 0)
        {
            return json_encode(ApiErrorCode::$AccountLoginError);
        }
        if ($type=="get"){
            $res = LogTree::getTreeCoin($gid);
        }elseif ($type=="do"){
            $res = LogTree::doTreeCoin($gid);
        }
        return json_encode($res);
    }
    
    public function actionDaily()
    {
        $gid=Yii::$app->getRequest()->getQueryParam('gid');
        $usertoken = Yii::$app->getRequest()->getQueryParam('usertoken');
        $usercount = GmAccountInfo::find()->where(['gid'=>$gid,'token'=>$usertoken])->count();
        if ($usercount == 0)
        {
            return json_encode(ApiErrorCode::$AccountLoginError);
        }
        $coinlist=[1000,6000,3000,7000,8000,4000,9000,5000,2000,10000];
        $player = GmPlayerInfo::findOne($gid);
        $vip=0;
        if (is_object($player))
            $vip=$player->power;
        $vipRatio=[1,2,3,4,5,6,7,8,9,10,
                  12,14,16,18,20,22,24,26,28,30,32];
        $rad=array_rand($coinlist);
        $continueDays = 0;
        $res = ApiErrorCode::$OK;
        $res['info']=[
            'totalGain'=>intval($coinlist[$rad]*(1+0.1*$continueDays)*$vipRatio[$vip]),
            'indexGain'=>intval($rad),
        ];
        return json_encode($res);
    }
    
    public function actionAvatars($gid)
    {
        $response = Yii::$app->getResponse();
        $response->headers->set('Content-Type', 'image/jpeg');
        $response->format = Response::FORMAT_RAW;
        $imgFullPath=Yii::$app->params['avatarPath'].$gid.".jpg";
        if (file_exists($imgFullPath)){
            if ( !is_resource($response->stream = fopen($imgFullPath, 'r')) ) {
                throw new \yii\web\ServerErrorHttpException('file access failed: permission deny');
            }
        }else {
            $randnu = $gid%399 +1;
            $imgFullPath=Yii::$app->params['avatarPath'].$randnu.".jpg";
            $response->stream = fopen($imgFullPath, 'r');
        }
        return $response->send();
        
    }
    public function actionGenorder()
    {
        //         return $this->render('index');
        $gid=Yii::$app->getRequest()->getQueryParam('gid');
        $channel=Yii::$app->getRequest()->getQueryParam('channel');
        $rlchannel= GmChannelInfo::findOne(['any_channel'=>$channel]);//匹配注册渠道 不能影响官方渠道编号，只能在渠道信息里做配置
        if (is_object($rlchannel)){
            $channel =$rlchannel->cid;
        }
        $usertoken = Yii::$app->getRequest()->getQueryParam('usertoken');
        $productid = Yii::$app->getRequest()->getQueryParam('product');
        $dev=Yii::$app->getRequest()->getQueryParam('d');
        $ver=Yii::$app->getRequest()->getQueryParam('v');
        $paytype=Yii::$app->getRequest()->getQueryParam('paytype');
        $payflag=Yii::$app->getRequest()->getQueryParam('payflag',0);//2越狱
        $param_dev_uuid = explode('_._', $dev);
        $uuid = $param_dev_uuid[0];
        $simSerial = $param_dev_uuid[1];
        $dev_id = $param_dev_uuid[2];
        if ($dev == "" ||count($param_dev_uuid)<3)
        {
            return json_encode(ApiErrorCode::$invalidParam);
        }
        $usercount = GmAccountInfo::find()->where(['gid'=>$gid,'token'=>$usertoken])->count();
        if ($usercount == 0)
        {
            return json_encode(ApiErrorCode::$AccountLoginError);
        }
        $user = GmAccountInfo::findOne(['gid'=>$gid,'token'=>$usertoken]);
        if (!$user){
            return json_encode(ApiErrorCode::$AccountError);
        }
        if ($paytype=="5")
        {//短信充值方式
            return json_encode(ApiErrorCode::$smsError);
            if (!GmOrderlist::checkSmsMonth($gid))
            {
                $this->savesLog("gid: ".$gid."  uid 短信扣费达到月限 ",'error');
                return json_encode(ApiErrorCode::$smsMonthTomuchError);
            }
            if (!GmOrderlist::checkSmsDaily($gid))
            {
                $this->savesLog("gid: ".$gid."  uid 短信扣费达到日限 ",'error');
                return json_encode(ApiErrorCode::$smsDayTomuchError);
            }
        }
        $flag=0;//默认安卓用户
        if ($channel == "1000"|| $channel =="1001"|| $channel =="1002"|| $channel =="1003"||$channel==1004)
            $flag = 1;
        $gorder = new GmOrderlist();
        if ($payflag!=0)
            $flag=$payflag;
        $res = $gorder->genOrder($gid, $productid,$flag); 
//         $cInfo = GmChannelInfo::findOne($channel);
//         if (is_object($cInfo))
//             $res['pay_method']=intval($cInfo->pay_method);
        $pInfo=GmPlayerInfo::findOne($gid);
        if (is_object($pInfo)){
//             $c = GmOrderlist::find()->where(['playerid'=>$gid,'status'=>2])->count();
//             if ($pInfo->level >= 5 && $c>0){
                $cInfo = GmChannelInfo::findOne($channel);
                if (is_object($cInfo))
                    $res['pay_method']=intval($cInfo->pay_method);
//             }
        }
        return json_encode($res);
    }
    public function actionResetpasswd($type)
    {
        $channel=Yii::$app->getRequest()->getQueryParam('channel');
        $rlchannel= GmChannelInfo::findOne(['any_channel'=>$channel]);//匹配注册渠道 不能影响官方渠道编号，只能在渠道信息里做配置
        if (is_object($rlchannel)){
            $channel =$rlchannel->cid;
        }
        $dev=Yii::$app->getRequest()->getQueryParam('d');
        $ver=Yii::$app->getRequest()->getQueryParam('v');
        $param_dev_uuid = explode('_._', $dev);
        $uuid = $param_dev_uuid[0];
        $simSerial = $param_dev_uuid[1];
        $dev_id = $param_dev_uuid[2];
        if ($dev == "" ||count($param_dev_uuid)<3)
        {
            return json_encode(ApiErrorCode::$invalidParam);
        }
        if ($type == "check"){
            //校验密保
            $name=Yii::$app->getRequest()->getQueryParam('name');
            $pwdq = Yii::$app->getRequest()->getQueryParam('pwdq');
            $pwda = Yii::$app->getRequest()->getQueryParam('pwda');
            $usercount = GmAccountInfo::find()->where(['account_name'=>$name,'pwd_q'=>$pwdq,'pwd_a'=>$pwda])->count();
            if ($usercount == 0)
            {
                return json_encode(ApiErrorCode::$AccountPwdqWrong);
            }else {
                //密保答案正确
                $user = GmAccountInfo::findOne(['account_name'=>$name,'pwd_q'=>$pwdq,'pwd_a'=>$pwda]);
                $res = ApiErrorCode::$OK;
                $res['info']=['gid'=>$user->gid,'usertoken'=>$user->token];
                return json_encode($res);
            }
        }else if($type == "reset"){
            //重置密码
            $gid=Yii::$app->getRequest()->getQueryParam('gid');
            $pwd = Yii::$app->getRequest()->getQueryParam('pwd');
            $usertoken = Yii::$app->getRequest()->getQueryParam('usertoken');
            $usercount = GmAccountInfo::find()->where(['gid'=>$gid,'token'=>$usertoken])->count();
            if ($usercount == 0)
            {
                return json_encode(ApiErrorCode::$AccountPwdqWrong);
            }else {
                $user = GmAccountInfo::findOne(['gid'=>$gid,'token'=>$usertoken]);
                $user->account_pwd = $user->encryptPass($pwd);
                if ($user->save())
                {
                    $res = ApiErrorCode::$OK;
                    $res['msg']='重置成功';
                    return json_encode(ApiErrorCode::$OK);
                }else {
                    Yii::error("save new passwd failed ,: ".print_r($user->getErrors(),true));
                    return json_encode(ApiErrorCode::$RuleError);
                }
            }
        }else {
            Yii::error("invalidate request");
            return json_encode(ApiErrorCode::$InvalidateRequest);
        }
    }
    public function actionAnnouncement()
    {
        //系统公告
        $an = new GmAnnouncement();
        $res = ApiErrorCode::$OK;
        $res['info']=$an->getLast();
        return json_encode($res);
    }
    public function actionAct()
    {
        //活动
        $channel = Yii::$app->getRequest()->getQueryParam('channel');
        $an = new GmActivity();
        $res = ApiErrorCode::$OK;
        $res['info'] = $an->getLast($channel);
        return json_encode($res);
    }
    public function actionCheckupdate()
    {
        //更新提示
        $verCode=Yii::$app->getRequest()->getQueryParam('verCode');
        $channel = Yii::$app->getRequest()->getQueryParam('channel');

        $res = ApiErrorCode::$OK;
        if ($channel=="appstore"|| $channel=="Enterprise"){
            $res['info']['force']='1';
            $res['info']['updateurl']="http://fir.im/zjhEnt";
            return json_encode($res);
        }
        $update = GmChannelInfo::find()->where(['cid'=>$channel])->andWhere("version_code>".$verCode)->one();
        if (is_object($update))
        {
            $res['info']['force']=$update->force;
            if ($channel<2000){
                if ($verCode<70)
                    $res['info']['force']=1;
                $res['info']['updateurl']=$update->update_url."?v=".date('Ymd');
                $res['info']['changelog']=$update->changelog==""?"无":$update->changelog;
            }else {
                if ($verCode<70)
                    $res['info']['force']=1;
                $res['info']['updateurl']=Yii::$app->getRequest()->getHostInfo().'/'.$update->cid.'/update'."?v=".date('Ymd');
                $res['info']['changelog']=$update->changelog;
                $res['info']['changelog']=$update->changelog==""?"无":$update->changelog;
            }
            //($update->update_url!="")?$update->update_url:Yii::$app->getRequest()->getHostInfo()."/dlpage/".$update->cid;
        }
//         $this->logtodb("checkupdate", json_encode($res));
        return json_encode($res);
        
    }
    public function actionRank($type)
    {
        //排行榜
        $u = new GmPlayerInfo();
        if ($type == "Charm")
        {
            return json_encode($u->getCharmRank());
        }elseif ($type == "Rich")
        {
            return json_encode($u->getRichRank());
        }elseif ($type == "Max")
        {
            return json_encode($u->getMaxRank());
        }elseif ($type == "Ssl")
        {
            return json_encode($u->getSslRank());
        }
    }
    public function actionAnalytic()
    {
        
        $dtype=Yii::$app->getRequest()->getQueryParam('datatype');
        $gid=Yii::$app->getRequest()->getQueryParam('gid');
        $usertoken=Yii::$app->getRequest()->getQueryParam('usertoken');
        Yii::error("analytic gid : ".$gid." datatype: ".$dtype." usertoken:".$usertoken);
        return json_encode(ApiErrorCode::$OK);
    }
    public function actionAlipay()
    {
        if (Yii::$app->request->isPost){
            $order = Yii::$app->getRequest()->getBodyParam('Orderid');
            Yii::warning("====received alipayNotice Post Begin====",'alipay');
            Yii::warning(print_r($_POST,true),'alipay');
            Yii::warning("====received alipayNotice Post End====",'alipay');
            if (Yii::$app->getRequest()->getBodyParam('trade_status') == 'TRADE_SUCCESS'){
                Yii::warning("=====alipayNotice TRADE_SUCCESS=====",'alipay');
                $alipay = new AlipayNoticeLogs();
                $alipay->attributes = Yii::$app->getRequest()->getBodyParams();
                $alipay->order = $order;
                $alipay->accid = Yii::$app->getRequest()->getBodyParam('accid');
                if ($alipay->save()){
                    //@todo 可以在保存时先去根据notifyid 校验是否支付宝来源
                    Yii::warning("<<--alipay订单已保存-->>",'alipay');
                    //@todo 更新订单信息
                    $orderlist  = GmOrderlist::findOne(['playerid'=> Yii::$app->getRequest()->getBodyParam('accid'),'orderid'=>$order,'status'=>0 ]);
                    if (is_object($orderlist) && $orderlist->price==intval( Yii::$app->getRequest()->getBodyParam('total_fee'))){
                        $orderlist->status = 1;
                        $orderlist->source = "Alipay";
                        $orderlist->transaction_id = Yii::$app->getRequest()->getBodyParam('trade_no');//支付宝交易号
                        $orderlist->transaction_time = Yii::$app->getRequest()->getBodyParam('gmt_payment');//支付宝付款时间
                        $orderlist->fee = Yii::$app->getRequest()->getBodyParam('total_fee');
                        //测试用，每次算49元
//                                                 $orderlist->fee="50";
                        $orderlist->utime = date('Y-m-d H:i:s');
                        if ($orderlist->save())
                        {
                            Yii::warning($order."订单状态已更新",'alipay');
                            $this->savesLog("gid:".$alipay->accid."orderid: ".$order."订单状态已更新",'pay');
                            //@todo打印success 以通知支付宝已接收结果
                            echo "success";
                        }else {
                            Yii::warning($order."订单状态更新失败".print_r($orderlist->getErrors(),true),'alipay');
                        }
                    }elseif (is_object($orderlist) && $orderlist->price!=intval( Yii::$app->getRequest()->getBodyParam('total_fee')))
                    {
                        Yii::warning($order."订单金额有误",'alipay');
                    }
                    else {
                        Yii::warning($order."没找到订单",'alipay');
                        
                    }
    
                }else {
                    Yii::error("saved failed ");
                    Yii::error(print_r($alipay->getErrors(),true),'alipay');
                }
            }
        }
    }
    public function actionWxpaynotify()
    {
        $Orderid = Yii::$app->getRequest()->getQueryParam('orderid');
        $gid =  Yii::$app->getRequest()->getQueryParam('gid');
        $data = Yii::$app->getRequest()->getRawBody();
        $this->savesLog($data, "wxpay");
        Yii::error("wxpay,receive data : ".$data,"wxpay");
        $ordercount = GmOrderlist::find()->where(['orderid'=>$Orderid,'playerid'=>$gid,'status'=>0])->count();
        if ($ordercount!=1){
            Yii::error("error order count not 1  ","wxpay");
            return '<xml>
              <return_code><![CDATA[SUCCESS]]></return_code>
              <return_msg><![CDATA[OK]]></return_msg>
            </xml>';
        }else {
            $logwx = LogWxpay::findOne(['orderid'=>$Orderid]);
            if (!is_object($logwx)){
                $logwx = new LogWxpay();
                $logwx->orderid = $Orderid;
                $logwx->gid = $gid;
                $logwx->xml_data = $data;
                $logwx->ctime = date('Y-m-d H:i:s');
                if (!$logwx->save()){
                    Yii::error("error logwx save ".print_r($logwx->getErrors(),true),"wxpay");
                }
            }else {
                Yii::error("error logwxpay is found",'wxpay');
            }
        }
        $not = new WxPayNotify();
        $not->Handle();
//         return '<xml>
//           <return_code><![CDATA[SUCCESS]]></return_code>
//           <return_msg><![CDATA[OK]]></return_msg>
//         </xml>';
//         return "xx";
    }
    public function actionSmsnotice()
    {
        $gid=Yii::$app->getRequest()->getQueryParam('gid');
        $order=Yii::$app->getRequest()->getQueryParam('orderid');
        $usertoken=Yii::$app->getRequest()->getQueryParam('usertoken');
        $productid=Yii::$app->getRequest()->getQueryParam('productid');
        $uc = GmPlayerInfo::find(['gid'=>$gid,'token'=>$usertoken])->count();
        if ($uc==0)
            return json_encode(ApiErrorCode::$TokenExpired);
        //@todo 更新订单信息
        $dev=Yii::$app->getRequest()->getQueryParam('d');
        $ver=Yii::$app->getRequest()->getQueryParam('v');
        $param_dev_uuid = explode('_._', $dev);
        $uuid = $param_dev_uuid[0];
        $simSerial = $param_dev_uuid[1];
        $dev_id = $param_dev_uuid[2];
        if ($dev_id=="542481101574545")
        {
            $this->savesLog("gid: ".$gid." orderid: ".$order." ime号黑名单SMS扣费 ",'error');
            return json_encode(ApiErrorCode::$BlackListError);
        }
        if (!GmOrderlist::checkSmsMonth($gid))
        {
            $this->savesLog("gid: ".$gid."  uid 短信扣费达到月限 ",'error');
            return json_encode(ApiErrorCode::$smsMonthTomuchError);
        }
        if (!GmOrderlist::checkSmsDaily($gid))
        {
            $this->savesLog("gid: ".$gid."  uid 短信扣费达到日限 ",'error');
            return json_encode(ApiErrorCode::$smsDayTomuchError);
        }
        $orderlist  = GmOrderlist::findOne(['playerid'=> $gid,'orderid'=>$order,'status'=>0 ]);
        if (is_object($orderlist)){
            $orderlist->status = 1;
            $orderlist->source = "Sms";
            $orderlist->transaction_id = "";
            $orderlist->transaction_time = "";
            $orderlist->fee = "6";
            //测试用，每次算49元
            //$orderlist->fee="50";
            $orderlist->utime = date('Y-m-d H:i:s');
            if ($orderlist->save())
            {
                $this->savesLog("gid: ".$gid." orderid: ".$order."短代订单状态已更新",'pay');
                //@todo打印success 以通知支付宝已接收结果
                return json_encode(ApiErrorCode::$OK);
            }else {
                $this->savesLog($order."订单状态更新失败".print_r($orderlist->getErrors(),true),'error');
                return json_encode(ApiErrorCode::$RuleError);
            }
        }else {
            Yii::error($order."没找到订单",'rule');
            return json_encode(ApiErrorCode::$RuleError);
        }
    }
    public function actionYeepayresult()
    {
        $this->layout="main";
        
        $issuccess=Yii::$app->getRequest()->getQueryParam('issuccess');
        if ($issuccess==0){
            Yii::error(" is success : ".$issuccess);
            return $this->render("yeepaysuccess",['issuccess'=>$issuccess]);
        }else {
            $params=Yii::$app->getRequest()->getQueryParam('params');
            Yii::error(" is success : ".$issuccess." \r\n params: ".print_r($params,true));
            return $this->render("yeepaysuccess",['issuccess'=>$issuccess,'params'=>$params]);
        }
        
    }
    public function actionYeepay_callback()
    {
        Yii::warning(" url get params : ".print_r($_GET,true),'yeepay');
        Yii::warning(" url post params : ".print_r($_POST,true),'yeepay');
//         echo "success";
        $Yee = new LogYeepayNotice();
        if (Yii::$app->getRequest()->isPost)
        {
            $Yee->attributes = $_POST;
            $Yee->orderid = $_POST['order'];
        }else {
            $Yee->attributes = $_GET;
            $Yee->orderid = $_GET['order'];
        }
        //重复的yeepay订单通知,更新掉订单通知
        $Yee_already = LogYeepayNotice::findOne(['orderid'=>$Yee->orderid]);
        if (is_object($Yee_already)){
//             $this->logtodb("yeepay", "YeePay result got another :".json_encode($Yee_already->attributes));
        }
        if ($Yee->save()){
            Yii::error("Saved yeepay notice at ".date('Y-m-d H:i:s'));
            $order = GmOrderlist::findOne(['orderid'=>$Yee->orderid,'playerid'=>$Yee->gid,'productid'=>$Yee->productid]);
            if (is_object($order) && $Yee->r1_Code==1 && intval($Yee->p3_Amt)==$order->price && $order->status==0)
            {//
                $r0_Cmd="";
                $r1_Code="";
                $p1_MerId="";
                $p2_Order="";
                $p3_Amt="";
                $p4_FrpId="";
                $p5_CardNo="";
                $p6_confirmAmount="";
                $p7_realAmount="";
                $p8_cardStatus="";
                $p9_MP="";
                $pb_BalanceAmt="";
                $pc_BalanceAct="";
                $hmac="";
                $gmord = new GmOrderlist();
                $return = $gmord->getCallBackValue($r0_Cmd,$r1_Code,$p1_MerId,$p2_Order,$p3_Amt,$p4_FrpId,$p5_CardNo,$p6_confirmAmount,$p7_realAmount,$p8_cardStatus,
                    $p9_MP,$pb_BalanceAmt,$pc_BalanceAct,$hmac);
                $bRet = $gmord->CheckHmac($r0_Cmd,$r1_Code,$p1_MerId,$p2_Order,$p3_Amt,$p4_FrpId,$p5_CardNo,$p6_confirmAmount,$p7_realAmount,$p8_cardStatus,
                    $p9_MP,$pb_BalanceAmt,$pc_BalanceAct,$hmac);
                
                if($bRet){
                   $order->status=1;
                   $order->source="Yeepay";
                   $order->fee = $Yee->p3_Amt;
                   $order->transaction_time = date('Y-m-d H:i:s'); 
                   $order->utime = date('Y-m-d H:i:s');
                   $order->transaction_id = $p5_CardNo;
                   if ($order->save())
                   {
                       Yii::warning("Yeepay success saved",'yeepay');
                       return "success";
                   }else {
                       Yii::warning("Yeepay save failed ".print_r($Yee->getErrors(),true),'yeepay');
                       return "failed";
                   }
                }else {
                    Yii::warning("CheckHmac failed ",'yeepay');
                    return "CheckHmac failed";
                }
            }else {
                if (!is_object($order))
                    Yii::warning("order not found",'yeepay');
                if ($Yee->r1_Code!=1)
                    Yii::warning("r1_Code not 1,status error",'yeepay');
                if (intval($Yee->p3_Amt)!=$order->price)
                    Yii::warning("p3_Amt not match the price amt is :".$Yee->p3_Amt." price is ".$order->price,'yeepay');
                if ($order->status!=0)
                    Yii::warning("status is not 0  now is ".$order->status,'yeepay');
                return "failed";
            }
         }else {
             Yii::warning("Yeepay notice save failed  ".print_r($Yee->getErrors(),true),'yeepay');
             return "failed";
         }

        /**
         *  url post params : Array
(
        [ptype] => TELECOM
    [order] => 85E8F5514363251107724
    [gid] => 120056
    [productid] => zuanshi_android_6
    [r0_Cmd] => ChargeCardDirect
    [r1_Code] => 2
    [p1_MerId] => 10001126856
    [p2_Order] => 85E8F5514363251107724
    [p3_Amt] => 0.0
    [p4_FrpId] => TELECOM
    [p5_CardNo] => 646466944
    [p6_confirmAmount] => 0.0
    [p7_realAmount] => 0.0
    [p8_cardStatus] => 7
    [p9_MP] =>
    [pb_BalanceAmt] =>
    [pc_BalanceAct] =>
    [r2_TrxId] =>
    [hmac] => 441b139127686fab1036d0f9ff9081df
)
         */
    }
    public function actionYeepay()
    {
        $this->layout="main";
        $ptype=Yii::$app->getRequest()->getQueryParam('paytype');
        $gid=Yii::$app->getRequest()->getQueryParam('gid');
        $order=Yii::$app->getRequest()->getQueryParam('orderid');
        $usertoken=Yii::$app->getRequest()->getQueryParam('usertoken');
        $productid=Yii::$app->getRequest()->getQueryParam('productid');
        $price=Yii::$app->getRequest()->getQueryParam('price');
        Yii::warning("request yeepay ",'yeepay');
        $cc = GmAccountInfo::find(['gid'=>$gid,'token'=>$usertoken,'status'=>0])->count();
        if ($cc == 0){
            Yii::warning('page user token check failed gid:'.$gid." token : ".$usertoken,'yeepay');
            throw new NotFoundHttpException();
            return ;
        }
        if (Yii::$app->getRequest()->isPost){
            switch ($ptype){
                    case 6://yidong
                        $card = "SZX";
                        $card_price = Yii::$app->getRequest()->getBodyParam('card_price');
                        break;
                    case 7://liantong
                        $card = "UNICOM";
                        $card_price = Yii::$app->getRequest()->getBodyParam('card_price');
                        break;
                    case 8://dianxin
                        $card = "TELECOM";
                        $card_price = Yii::$app->getRequest()->getBodyParam('card_price');
                        break;
                    default:
                        $card = Yii::$app->getRequest()->getBodyParam('card');
                        $card_price = $price;
                        break;
                }
            $card_num = Yii::$app->getRequest()->getBodyParam('card_num');
            $card_pwd = Yii::$app->getRequest()->getBodyParam('card_pwd');
            $ext="";
            $p3_Amt=$card_price.'.00';
            $p4_verifyAmt="false";
            $p5_Pid=$productid;
            $p6_Pcat="";
            $p7_Pdesc="";
            $p8_Url=Yii::$app->getRequest()->getHostInfo()."/yeepay_callback?ptype=".$card."&order=".$order."&gid=".$gid."&productid=".$productid;
            Yii::error(" card type : ".$card." card id : ".$card_num." card pwd ".$card_pwd);
            $gmor = new GmOrderlist();
            $res = $gmor->annulCard($order, $p3_Amt, $p4_verifyAmt, $p5_Pid, $p6_Pcat, $p7_Pdesc, $p8_Url, $ext,
                 $price, $card_num, $card_pwd, $card, $gid, date('Y-m-d H:i:s'));
            if (!$res) {
//                 Yii::$app->getSession()->setFlash('error', '提交失败');
                return $this->redirect(['yeepayresult','issuccess'=>'0']);
            } else {
                Yii::error("called back result: ".print_r($res,true));
//                 Yii::$app->getSession()->setFlash('success', '提交成功');
                return $this->redirect(['yeepayresult','issuccess'=>'1','params'=>[
                'gid'=>$gid,
                'orderid'=>$order,
                'usertoken'=>$usertoken,
                'productid'=>$productid,
                'res'=>$res]]);
                
            }
        }else {
            $view = "";
            $source = "";
            switch ($ptype){
                case 3:
                    $view="yeepay";
                    break;
                case 4:
                    $view="yeepay";
                    break;
                case 6://yidong
                    $view="yeepay_phone";
                    $source = "移动充值卡";
                    break;
                case 7://liantong
                    $view="yeepay_phone";
                    $source = "联通充值卡";
                    break;
                case 8://dianxin
                    $view="yeepay_phone";
                    $source = "电信充值卡";
                    break;
                default:
                    $view="yeepay";
                    break;
            }
            $priceList = [10,20,30,50,100,200,300,500,1000];
            $cardprice = $price;
            foreach ($priceList as $p){
                if ($price<=$p)
                {
                    $cardprice = $p;
                    break;
                }
            }
            $pro = CfgProducts::findOne(['product_id'=>$productid]);
            $productname = "";
            if (is_object($pro))
                $productname = $pro->product_name;
            return $this->render($view,[
                'gid'=>$gid,
                'orderid'=>$order,
                'usertoken'=>$usertoken,
                'productid'=>$productid,
                'product_name'=>$productname,
                'price'=>$price,
                'cardprice'=>$cardprice,
                'source'=>$source,
            ]);
        }
    }
    public function actionLlpay()
    {
//         return $this->redirect('http://ap.koudaishiji.com/');
        $gid=Yii::$app->getRequest()->getQueryParam('gid');
        $order=Yii::$app->getRequest()->getQueryParam('orderid');
        $usertoken=Yii::$app->getRequest()->getQueryParam('usertoken');
        $productid=Yii::$app->getRequest()->getQueryParam('productid');
        $price=Yii::$app->getRequest()->getQueryParam('price');
        $tc=implode('_._',[$gid,$order,$productid,$price]);
        $notify = Yii::$app->getRequest()->getHostInfo().'/unpay/'.$order.'/'.$gid;
        $url='http://unpay.koudaishiji.com/demo/utf8/Form_6_2_FrontConsume.php?orderid='.$order.'&price='.$price.'&tc='.$tc.'&notifyurl='.$notify;
        return $this->redirect($url);
        $this->layout="main";
        
//         $cc = GmAccountInfo::find(['gid'=>$gid,'token'=>$usertoken,'status'=>0])->count();
//         if ($cc == 0){
//             Yii::warning('page user token check failed gid:'.$gid." token : ".$usertoken,'llpay');
//             throw new NotFoundHttpException();
//             return ;
//         }
        $pro = CfgProducts::findOne(['product_id'=>$productid]);
        $productname = "";
        if (is_object($pro))
            $productname = $pro->product_name;
        if (Yii::$app->getRequest()->isPost){
            //风控
            $risk_item='{\"user_info_mercht_userno\":\"'.$gid.'\",\"user_info_dt_register\":\"'.date("YmdHis").'\",\"risk_state\":\"1\",\"frms_ware_category\":\"1003\",\"game_id\":\"'.$gid.'\",\"game_id_belongs\":\"1\"}';
            /**************************请求参数**************************/
            $llpaylog = LogLlpayNotice::find()
                        ->where(['gid' => $gid])
                        ->orderBy('id desc')
                        ->one();
            //协议号
            $no_agree = "";
            if ($llpaylog!=null or $llpaylog!="")
            {
                Yii::warning("no agree is ".$llpaylog->no_agree,'llpay');
                $no_agree=isset($llpaylog->no_agree )?$llpaylog->no_agree:"";
            }
            //商户用户唯一编号
            $user_id = $gid;
            //支付类型 虚拟商品销售：101001
            $busi_partner = 101001;
            //商户订单号
            $no_order = $order;
            //商户网站订单系统中唯一订单号，必填
            //付款金额
            $money_order = $price;
            //必填
            //商品名称
            $name_goods = $productname;
            //订单描述
            $info_order = $productid.">>_<<".$gid.">>_<<".$productname;
            //卡号
            $card_no = Yii::$app->getRequest()->getBodyParam('card_no');
            //姓名
            $acct_name = Yii::$app->getRequest()->getBodyParam('acct_name') ;
            //身份证号
            $id_no =  Yii::$app->getRequest()->getBodyParam('id_no');
            
            //风险控制参数
//             $risk_item = $_POST['risk_item'];
            //订单有效期(分钟)
            $valid_order = 1440;
            //服务器异步通知页面路径
            $notify_url = Yii::$app->getRequest()->getHostInfo()."/llpaynotify";
            //需http://格式的完整路径，不能加?id=123这类自定义参数
            
            //页面跳转同步通知页面路径
            $return_url = Yii::$app->getRequest()->getHostInfo()."/llpayreturn";
            //需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/
            
            /************************************************************/
            
            //构造要请求的参数数组，无需改动
            $parameter = array (
            "oid_partner" => trim(Yii::$app->params['oid_partner']),
            "app_request" => trim(Yii::$app->params['app_request']),
            "sign_type" => trim(Yii::$app->params['sign_type']),
            "valid_order" => trim(Yii::$app->params['valid_order']),
            "user_id" => $user_id,
            "busi_partner" => $busi_partner,
            "no_order" => $no_order,
            "dt_order" => date('YmdHis'),
            "name_goods" => $name_goods,
            "info_order" => $info_order,
            "money_order" => $money_order,
            "notify_url" => $notify_url,
            "url_return" => $return_url,
            "card_no" => $card_no,
            "acct_name" => $acct_name,
            "id_no" => $id_no,
            "no_agree" => $no_agree,
            "risk_item" => $risk_item,
            "valid_order" => $valid_order
            );
            $ord = new GmOrderlist();
//             $para = $ord->buildRequestParaToString($parameter);
            $para = $ord->buildRequestPara($parameter);
//             $params = ['req_data'=>$value];
            $sHtml = "<form id='llpaysubmit' name='llpaysubmit' action='" .Yii::$app->params['llpay_gateway_new']. "' method='POST'>";
            $sHtml .= "<input type='hidden' name='req_data' value='" . $para . "'/>";
            //submit按钮控件请不要含有name属性
            $sHtml = $sHtml . "<input type='submit'  ></form>";
            $sHtml = $sHtml."<script>document.forms['llpaysubmit'].submit();</script>";
//             $res = ['redurl'=>Yii::$app->params['llpay_gateway_new'],'args'=>['req_data'=>$para]];
//             Yii::warning(json_encode($res),'llpay');
            Yii::warning($sHtml,'llpay');
            return $sHtml;
//             return json_encode($res);
        }
        return $this->render('llpay',[
                'gid'=>$gid,
                'orderid'=>$order,
                'usertoken'=>$usertoken,
                'productid'=>$productid,
                'product_name'=>$productname,
                'price'=>$price,
        ]);
        
    }
    public function actionUpdate($channel)
    {
        $this->layout="main_none";
        $updateinfo = GmChannelInfo::findOne(['cid'=>$channel]);
        if (!is_object($updateinfo))
        {
            throw new NotFoundHttpException();
        }else {
            if ($channel==2006){
                $this->layout="main_dl";
                return $this->render('dlpage',[
                    'uinfo'=>$updateinfo,
                    'cid'=>$channel,
                ]);
            }else {
                return $this->render('update',[
                    'uinfo'=>$updateinfo,
                    'cid'=>$channel,
                ]);
            }
        }
    }
    
    public function actionTg($channel)
    {
        $this->layout="main_tg";
        $updateinfo = GmChannelInfo::findOne(['cid'=>$channel]);
        if (!is_object($updateinfo))
        {
            throw new NotFoundHttpException();
        }else { 
            return $this->render('tg',[
                'uinfo'=>$updateinfo,
                'cid'=>$channel,
            ]); 
        }
    }
    public function actionApp()
    {
        $this->layout="blank";
        $channel = Yii::$app->getRequest()->getQueryParam('channel',2000);
        $updateinfo = GmChannelInfo::findOne(['cid'=>$channel]);
        if (!is_object($updateinfo))
        {
            $updateinfo = GmChannelInfo::findOne(['cid'=>2000]);
        }
        if ($channel==2006){
            $this->layout="main_dl";
            return $this->render('dlpage',[
                'uinfo'=>$updateinfo,
                'cid'=>$channel,
            ]);
        }else {
            return $this->render('app',[
                'uinfo'=>$updateinfo,
                'cid'=>$channel,
            ]);
        }
    }
    public function actionBaidu()
    {
        $this->layout="blank";
        //user-agent
        $ua = Yii::$app->getRequest()->getHeaders()['user-agent'];
        $channel = Yii::$app->getRequest()->getQueryParam('channel',2066);
        $updateinfo = GmChannelInfo::findOne(['cid'=>$channel]);
        if (!is_object($updateinfo))
        {
            $updateinfo = GmChannelInfo::findOne(['cid'=>2066]);
        }
        if (preg_match('/micromessenger/',strtolower($ua))){
            Yii::error("dev matchs weixin");
            return Html::tag('h2','由于微信限制下载，请点击右上角"在safari中打开"或"用浏览器打开"或者复制链接到常用浏览器地址中打开');
        }elseif (preg_match('/(iphone|ipad|ipod)/i',strtolower($ua))){
            Yii::error("dev matchs ios");
            return $this->redirect('https://itunes.apple.com/us/app/kuai-le-san-zhang-2015nian/id985117912?l=zh&ls=1&mt=8');
        }else {
            Yii::error("dev matchs other,".$ua);
            return $this->redirect($updateinfo->update_url);
        }
        
//             return $this->render('baidu',[
//                 'uinfo'=>$updateinfo,
//                 'cid'=>$channel,
//             ]);
    }
    
    public function actionUc()
    {
        $this->layout="blank";
        //user-agent
        $ua = Yii::$app->getRequest()->getHeaders()['user-agent'];
        $channel = Yii::$app->getRequest()->getQueryParam('channel',2068);
        $updateinfo = GmChannelInfo::findOne(['cid'=>$channel]);
        if (!is_object($updateinfo))
        {
            $updateinfo = GmChannelInfo::findOne(['cid'=>2068]);
        }
        if (preg_match('/micromessenger/',strtolower($ua))){
            Yii::error("dev matchs weixin");
            return Html::tag('h2','由于微信限制下载，请点击右上角"在safari中打开"或"用浏览器打开"或者复制链接到常用浏览器地址中打开');
        }elseif (preg_match('/(iphone|ipad|ipod)/i',strtolower($ua))){
            Yii::error("dev matchs ios");
            return $this->redirect('https://itunes.apple.com/us/app/kuai-le-san-zhang-2015nian/id985117912?l=zh&ls=1&mt=8');
        }else {
            Yii::error("dev matchs other,".$ua);
            return $this->redirect($updateinfo->update_url);
        } 
    }
    
    public function actionDl($channel)
    {
        $this->layout="blank";
        //user-agent
        $ua = Yii::$app->getRequest()->getHeaders()['user-agent'];
        $channel = Yii::$app->getRequest()->getQueryParam('channel',$channel);
        $updateinfo = GmChannelInfo::findOne(['cid'=>$channel]);
        if (!is_object($updateinfo))
        {
            $updateinfo = GmChannelInfo::findOne(['cid'=>2000]);
        }
        if (preg_match('/micromessenger/',strtolower($ua))){
            Yii::error("dev matchs weixin");
            return Html::tag('h2','由于微信限制下载，请点击右上角"在safari中打开"或"用浏览器打开"或者复制链接到常用浏览器地址中打开');
        }elseif (preg_match('/(iphone|ipad|ipod)/i',strtolower($ua))){
            Yii::error("dev matchs ios");
            return $this->redirect('https://itunes.apple.com/us/app/kuai-le-san-zhang-2015nian/id985117912?l=zh&ls=1&mt=8');
        }else {
            Yii::error("dev matchs other,".$ua);
            return $this->redirect($updateinfo->update_url);
        }
    }
    
    public function actionWj()
    {
        $this->layout="blank";
        //user-agent
        $ua = Yii::$app->getRequest()->getHeaders()['user-agent'];
        $channel = Yii::$app->getRequest()->getQueryParam('channel',2068);
        $updateinfo = GmChannelInfo::findOne(['cid'=>$channel]);
        if (!is_object($updateinfo))
        {
            $updateinfo = GmChannelInfo::findOne(['cid'=>2068]);
        }
        if (preg_match('/micromessenger/',strtolower($ua))){
            Yii::error("dev matchs weixin");
            return Html::tag('h2','由于微信限制下载，请点击右上角"在safari中打开"或"用浏览器打开"或者复制链接到常用浏览器地址中打开');
        }elseif (preg_match('/(iphone|ipad|ipod)/i',strtolower($ua))){
            Yii::error("dev matchs ios");
            return $this->redirect('https://itunes.apple.com/us/app/kuai-le-san-zhang-2015nian/id985117912?l=zh&ls=1&mt=8');
        }else {
            Yii::error("dev matchs other,".$ua);
            return $this->redirect($updateinfo->update_url);
        }
    }
    public function actionLlpayreturn()
    {
        /**
        {"dt_order":"20150709154736","money_order":"0.01","no_order":"85E8F5514363251107724","oid_partner":"201507071000401506",
        "oid_paybill":"2015070993456105","result_pay":"SUCCESS","settle_date":"20150709",
        "sign":"bf0f95b8c81dae5c234ac29b2af7a27d","sign_type":"MD5"}
         */
        $this->layout="main";
        if (Yii::$app->getRequest()->isPost){
            $req_data = Yii::$app->getRequest()->getBodyParam('res_data');
            if (strlen($req_data)>1)
            {//call back success!
                $params = json_decode($req_data);
                $oid_partner = $params->oid_partner;
                $sign_type = $params->sign_type ;
                $sign = $params->sign ;
                $dt_order = $params->dt_order ;
                $no_order = $params->no_order ;
                $oid_paybill = $params->oid_paybill ;
                $money_order = $params->money_order ;
                $result_pay = $params->result_pay ;
                $settle_date = $params->settle_date ;
//                 $info_order = $params->info_order or "";
//                 $pay_type = $params->pay_type ;
//                 $bank_code = $params->bank_code ;
//                 $no_agree = $params->no_agree ;
//                 $id_type = $params->id_type ;
//                 $id_no = $params->id_no ;
//                 $acct_name = $params->acct_name ;
                //生成签名结果
        		$parameter = array (
        			'oid_partner' =>$oid_partner,
        			'sign_type' => $params->sign_type ,
        			'dt_order' => $params->dt_order,
        			'no_order' => $params->no_order,
        			'oid_paybill' => $params->oid_paybill,
        			'money_order' => $params->money_order,
        			'result_pay' => $params->result_pay,
        			'settle_date' => $params->settle_date
        		);
                if ($oid_partner != Yii::$app->params['oid_partner'] || $result_pay!="SUCCESS" )
                {
                    if ($oid_partner != Yii::$app->params['oid_partner'])
                        Yii::warning("llpay res Error, partner id ".$oid_partner." not match",'llpay');
                    if ($result_pay!="SUCCESS") 
                        Yii::warning("llpay res Error, result pay ".$result_pay." not SUCCESS",'llpay');
                    //return $this->render('llpayreturn',['issuccess'=>1]);
                }else {
                    $ord = new GmOrderlist();
                    if($ord->getSignVeryfy($parameter, $sign))
                        return  $this->render('llpayreturn',['issuccess'=>0]);
                }
            }
        }
        return $this->render('llpayreturn',['issuccess'=>1]);
    }
    public function actionLlpaynotify()
    {
//         $this->layout="main";
        if (Yii::$app->getRequest()->isPost){
            $req_data = Yii::$app->getRequest()->getRawBody();
            if (strlen($req_data)>1)
            {//call back success!
                /**
                 * {"acct_name":"胡志伟","bank_code":"03080000","dt_order":"20150709163012","id_no":"330127198706101718",
                 * "id_type":"0","info_order":"用户id：120056 购买商品6钻石","money_order":"0.01","no_agree":"2015070998065065",
                 * "no_order":"85E8F5514364305728400","oid_partner":"201507071000401506","oid_paybill":"2015070993477832",
                 * "pay_type":"2","result_pay":"SUCCESS","settle_date":"20150709","sign":"a0e3a5e3024531c6de82095e67d745ee","sign_type":"MD5"}
                 */
                Yii::warning("req data: ".$req_data,'llpay');
                $params = json_decode($req_data);
                $oid_partner = isset($params->oid_partner)?$params->oid_partner:"";
                $sign_type = isset($params->sign_type)?$params->sign_type:"";
                $sign = isset($params->sign)?$params->sign:"";
                $dt_order = isset($params->dt_order)?$params->dt_order:"";
                $no_order = isset($params->no_order)?$params->no_order:"";
                $oid_paybill = isset($params->oid_paybill)?$params->oid_paybill:"";
                $money_order = isset($params->money_order)?$params->money_order:"";
                $result_pay = isset($params->result_pay)?$params->result_pay:"";
                $settle_date = isset($params->settle_date)?$params->settle_date:"";
                $info_order = isset($params->info_order)?$params->info_order:"";
//                 $productid.">>_<<".$gid.">>_<<".$productname;
                $otparam = explode('>>_<<', $info_order);
                $gid="";
                $productid="";
                $productname="";
                if (count($otparam)==3)
                {
                    $gid=$otparam[1];
                    $productid=$otparam[0];
                    $productname=$otparam[2];
                }
                $pay_type = isset($params->pay_type)?$params->pay_type:"";
                $bank_code = isset($params->bank_code)?$params->bank_code:"";
                $no_agree = isset($params->no_agree)?$params->no_agree:"";
                $id_type = isset($params->id_type)?$params->id_type:"";
                $id_no = isset($params->id_no)?$params->id_no:"";
                $acct_name = isset($params->acct_name)?$params->acct_name:"";
                $parameter = array (
                    'oid_partner' => $oid_partner,
                    'sign_type' => $sign_type,
                    'dt_order' => $dt_order,
                    'no_order' => $no_order,
                    'oid_paybill' => $oid_paybill,
                    'money_order' => $money_order,
                    'result_pay' => $result_pay,
                    'settle_date' => $settle_date,
                    'info_order' => $info_order,
                    'pay_type' => $pay_type,
                    'bank_code' => $bank_code,
                    'no_agree' => $no_agree,
                    'id_type' => $id_type,
                    'id_no' => $id_no,
                    'acct_name' => $acct_name
                );
                $llpaylog = new LogLlpayNotice();
                $llpaylog->oid_partner = $oid_partner;
                $llpaylog->dt_order = $dt_order;
                $llpaylog->no_order = $no_order;
                $llpaylog->oid_paybill = $oid_paybill;
                $llpaylog->money_order = $money_order;
                $llpaylog->result_pay =$result_pay;
                $llpaylog->settle_date = $settle_date;
                $llpaylog->info_order = $info_order;
                $llpaylog->pay_type = $pay_type;
                $llpaylog->bank_code = $bank_code;
                $llpaylog->no_agree = $no_agree;
                $llpaylog->id_type = $id_type;
                $llpaylog->id_no = $id_no;
                $llpaylog->acct_name = $acct_name;
                $llpaylog->sign_type = $sign_type;
                $llpaylog->gid = intval($gid);
                $llpaylog->orderid = $no_order;
                if ($llpaylog->save()){
                 
                /**
                 * {
                    "oid_partner":"201103171000000000",//商户编号
                    "dt_order":"20130515094013",//商户订单时间
                    "no_order":"2013051500001",//商户唯一订单号
                    "oid_paybill":"2013051613121201",//连连支付支付单号
                    "money_order":"210.97",//交易金额
                    "result_pay":"SUCCESS",//支付结果
                    "settle_date":"20130516",//清算日期
                    "info_order":"用户13958069593购买了3桶羽毛球",//订单描述
                    "pay_type":"2",//支付方式2：快捷支付（借记卡）3：快捷支付（信用卡）
                    "bank_code":"01020000",//银行编号 列表见附录，余额支付没有此项
                    "no_agree":"xxx",//快捷协议号可空
                     "sign_type":"RSA",//签名方式
                    "sign":"ZPZULntRpJwFmGNIVKwjLEF2Tze7bqs60rxQ22CqT5J1UlvGo575QK9z/
                    +p+7E9cOoRoWzqR6xHZ6WVv3dloyGKDR0btvrdqPgUAoeaX/YOWzTh00vwcQ+HBtX
                    E+vPTfAqjCTxiiSJEOY7ATCF1q7iP3sfQxhS0nDUug1LP3OLk="//签名
                    }
                 */
                if ($oid_partner != Yii::$app->params['oid_partner'] || $result_pay!="SUCCESS" )
                {
                    if ($oid_partner != Yii::$app->params['oid_partner']){
                        Yii::warning("llpay res Error, partner id ".$oid_partner." not match",'llpay');
                        $this->logtodb("llpay", "llpay res Error, partner id ".$oid_partner." not match",'error');
                    }
                    if ($result_pay!="SUCCESS"){
                        Yii::warning("llpay res Error, result pay ".$result_pay." not SUCCESS",'llpay');
                        $this->logtodb("llpay", "llpay res Error, result pay ".$result_pay." not SUCCESS",'error');
                    }
                    //return $this->render('llpayreturn',['issuccess'=>1]);
                }else {
                    $ord = new GmOrderlist();
                    if($ord->getSignVeryfy($parameter, $sign)){
//                         "ret_code":"0000",
//                         "ret_msg":"交易成功"
                        $this->logtodb("llpay", $no_order." 交易成功 playerid  ".$gid,'info');
                        $orderlist = GmOrderlist::findOne(['orderid'=>$no_order,'status'=>0,'playerid'=>$gid]);
                        if (is_object($orderlist) )
                        {
                            $orderlist->status = 1;
                            $orderlist->source = "llpay";
                            $orderlist->transaction_id =  $oid_paybill;// 交易号
                            $orderlist->transaction_time =  $dt_order;// 付款时间
                            $orderlist->utime = date('Y-m-d H:i:s');
                            $orderlist->fee = $money_order;
                            if ($orderlist->save())
                            {
                                return json_encode(['ret_code'=>"0000",'ret_msg'=>'交易成功']);
                            }else {
                                Yii::warning("${no_order} saved failed  ".print_r($orderlist->getErrors(),true),'llpay');
                                $this->logtodb("llpay","${no_order} saved failed  ".print_r($orderlist->getErrors(),true));
                            }
                        }else {
                            Yii::warning("llpay order list is not found ".$no_order,'llpay');
                            $this->logtodb("llpay", "llpay order list is not found ".$no_order);
                        }
                    }else {
                        Yii::warning("llpay getSignVeryfy failed  ",'llpay');
                        $this->logtodb("llpay", "llpay getSignVeryfy failed  ");
                    }
                } 
                }else {
                    Yii::warning("llpay notice saved failed  ".print_r($llpaylog->getErrors(),true),'llpay');
                    $this->logtodb("llpay", "llpay getSignVeryfy failed  ".print_r($llpaylog->getErrors(),true));
                    
                }
                return json_encode(['ret_code'=>"0002",'ret_msg'=>'订单处理失败']);
            }
        }
        throw new NotFoundHttpException(); 
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
    public function  actionXieyi()
    {
        $this->layout="main";
        if (Yii::$app->getRequest()->getQueryParam('channel')==1002)
        {//快乐炸金花
            return $this->render('xieyi2');
        }else{
            return $this->render('xieyi');
        }
    }
    public function actionUnpay()
    {
        if (Yii::$app->getRequest()->isPost)
        {
            $gid=Yii::$app->getRequest()->getQueryParam('gid');
            $orderid=Yii::$app->getRequest()->getQueryParam('orderid');
            $data = Yii::$app->getRequest()->getBodyParams();
            /**
             * 'accessType' => '0'
    'bizType' => '000201'
    'certId' => '21267647932558653966460913033289351200'
    'currencyCode' => '156'
    'encoding' => 'utf-8'
    'merId' => '898110257340180'
    'orderId' => 'FA95CF014467907837898'
    'queryId' => '201511061419447023968'
    'reqReserved' => '145895_._FA95CF014467907837898_._zuanshi_android_6_._0.01'
    'respCode' => '00'
    'respMsg' => 'Success!'
    'settleAmt' => '1'
    'settleCurrencyCode' => '156'
    'settleDate' => '1106'
    'signMethod' => '01'
    'traceNo' => '702396'
    'traceTime' => '1106141944'
    'txnAmt' => '1'
    'txnSubType' => '01'
    'txnTime' => '20151106141944'
    'txnType' => '01'
    'version' => '5.0.0'
    'signature' => 'wE5EyPgnVNUroOxSYvjQak6H7YuBYDBPs8woH5tDHiGAgdv+rCqVFt5QwRjYquM7cUB8Qz/9ZwfacXAcNcdBlNP2Js7Ela7wOvWl/Cm9MidLQfBf796x6YgUY++sBgUwm5mw8+CeZYtOu1FlvD8Ci/duzQ9AlqUl1ieYoLm6iCwSWuScwTvQ5pkg6J0Qm8Mp976a3O+MmVVdseb2xuDYhPz48C35S0xHueVsWHOEf7AApK1ELKaVCr6HnBJRbiLxYweNetq4dkmdLAOnxLY+MobgNBUU09jShzHNoZZQfkqLVFK3RSmoD36UwrPV95fd8vOywQm9zsqV4/ndVoqgVQ=='
             */
            $this->savesLog(json_encode($data), "unpay");
            $su = new secureUtil();
            if ($su->verify($data))
            {
                Yii::error("check success");
                $info="";
                foreach ($data as $k=>$v){
                    $info.="|".$k."=>".$v."|";
                }
                $str = "order:".$orderid." gid:".$gid.",info : ".$info;
                $this->savesLog($str, 'unpay');
                if ($data['respCode']=='00')
                {//成功
                    if ($orderid==$data['orderId']){
                        $ordercount=GmOrderlist::find()->where(['orderid'=>$orderid,'playerid'=>$gid,'status'=>0])->count();
                        if ($ordercount!=1){
                            Yii::error("error union order count not 1 ");
                            return 'failed';
                        }else {
                            $order = GmOrderlist::findOne(['orderid'=>$orderid]);
                            $order->source="unionpay";
                            $order->status=1;
                            $order->utime = date('Y-m-d H:i:s');
                            $order->transaction_id = $data['queryId'];
                            $order->transaction_time = $data['txnTime'];
                            if ($order->save())
                                return "success";
                            else{
                                $this->savesLog("Unionpay SAVE failed ".print_r($order->getErrors(),true), 'unpay');
                                return "failed";
                            } 
                        }
                    }
                }
                return "success";
            }else {
                Yii::error("check FAILED");
                return "FAILED";
            }
            
        }
    }
    public function  actionReceipt()
    {
        if (Yii::$app->getRequest()->isPost)
        {
            $data = Yii::$app->getRequest()->getRawBody();
            $player=Yii::$app->getRequest()->getQueryParam('gid');
            $orderid=Yii::$app->getRequest()->getQueryParam('orderid');
            $usertoken=Yii::$app->getRequest()->getQueryParam('usertoken');
            $productid=Yii::$app->getRequest()->getQueryParam('productid');
            $receipt = new ReceiptData();
            $receipt->orderid = $orderid;
            $receipt->player = $player;
            $receipt->productid = $productid;
            $receipt->data = $data;
            $receipt->ctime = date('Y-m-d H:i:s');
//             $receipt->save();
            if (!$receipt->save())
                $this->logtodb("iospay", "save receipt failed ".print_r($receipt->getErrors(),true),"error");
            $source = "appstore";
            $str=json_encode(['receipt-data'=>$data]);
            $res = $this->checkReceipt($str);//true直接调沙盒结果
            if (!$res)
            {
                Yii::warning("HTTP 请求 appstore失败，http漏单了 orderid: ".$orderid,'iospay');
                $this->logtodb("iospay","HTTP 请求 appstore失败，http漏单了 orderid: ".$orderid,'error');
                return ApiErrorCode::$ReceiptStatusError;
            }
                
            if (!is_object($res)){
                Yii::warning("结果为空",'iospay');
                return ApiErrorCode::$ReceiptStatusError;
            }
            Yii::warning("开始>>>---收据校验信息 gid : ".$player.", orderid: ".$orderid.", 状态 :".isset($res->status),'iospay');
            if ($res->status==21007){//sandbox收据
                $source = "sandbox";
                $res =  $this->checkReceipt($str,true);
            }
//             Yii::warning(" res : ".print_r($res,true),'iospay');
            if (($res->status==0||$res->status==21007) && is_object($res->receipt)){
                Yii::warning("status==0 is_object( receipt) ",'iospay');
                $uinfo = GmAccountInfo::findOne(['gid'=>$player,'status'=>0,'token'=>$usertoken]);
                $ord = GmOrderlist::findOne(['orderid'=>$orderid,'playerid'=>$player,'status'=>0]);
                $fiosorder = GmOrderlist::findOne(['transaction_id'=>$res->receipt->transaction_id]);
                $product=CfgProducts::findOne(['product_id'=>$res->receipt->product_id]);
                //伪造收费
                $mesg="bid  :".$res->receipt->bid."player:".$player."  order ：".$orderid." product id:".$res->receipt->product_id;
                Yii::warning("开始校验bid  :".$mesg,'iospay');
                if (!$this->checkBid($res->receipt->bid))
//                     $res->receipt->bid !=Yii::$app->params['bundleid'])
                {//伪造收据的扣费id直接至为黑名单
                   Yii::warning("收据信息产品id 是伪装的，用户可能使用了外挂 ，信息：".$mesg,'iospay');
                   $this->logtodb("iospay", $mesg,'error');
                }else {
                    if ($res->receipt->bid=='com.caigou.threecard'){
                        $source='appstore2';
                    }elseif ($res->receipt->bid=='com.hano.zyb.zjh'){
                        $source='appstore3';
                    }elseif ($res->receipt->bid=='com.hano.zjh.appstore10'){
                        $source='appstore4';
                    }elseif ($res->receipt->bid=='com.hano.2583694780.zjh'){
                        $source='appstore5';
                    }elseif ($res->receipt->bid=='com.hano.Youqian1huaxiu1.zjh'){
                        $source='appstore11';
                    }elseif ($res->receipt->bid=='com.hano.ll.zjh'){
                       $this->savesLog("com.hano.ll.zjh paylog orderid:".$orderid, 'pay');
                    }
                    if (!is_object($uinfo)){
                        $this->logtodb("iospay", "iosReceipt user notfound gid: ".$player." order: ".$orderid." token :".$usertoken,'error');
                        return ApiErrorCode::$NoAccountError;
                    }
                    Yii::warning("产品收据信息正常",'iospay');
                    $this->logtodb("iospay", $mesg."产品收据信息正常",'info');
                    //产品收据信息正常
                    if ($res->receipt->product_id != $ord->productid){
                        $this->logtodb("iospay", "收据与产品编号不一致 订单productid :".$ord->productid."订单号：".$orderid." ios产品：".$this->receipt->product_id,'error');
                        return json_encode(ApiErrorCode::$CheckFailed);
                    }
                    if (is_object($ord)  && !is_object($fiosorder) ){
                        if ($ord->status == 0){
                            Yii::warning("status 0",'iospay');
                            $ord->status = 1;
                        }
                        $ord->source = $source;
                        $ord->transaction_id = $res->receipt->transaction_id;
                        $ord->transaction_time = $res->receipt->original_purchase_date;
                        $ord->utime = date('Y-m-d H:i:s');
                        if($ord->save()){
                            Yii::warning("成功处理订单状态",'iospay');
                        }else {
                            Yii::warning("保存处理订单状态失败".print_r($ord->getErrors(),true),'iospay');
                            $this->logtodb("iospay","保存处理订单状态失败".print_r($ord->getErrors(),true) ,'error');
                        }
                    }else {
                        Yii::warning("ORDER id 没找到或者transaction_id 已经存在",'iospay');
                        if (!is_object($ord))
                            $this->logtodb("iospay","ORDER id".$orderid." gid:".gid." 没找到或者 order 状态不为0 " ,'error');
                        if (is_object($fiosorder))
                            $this->logtodb("iospay","transaction_id ".$res->receipt->transaction_id."已经存在 " ,'error');
                    }
                }
                Yii::warning("<<--开始保存数据-->>",'iospay');
                if (!is_object(IosPaylogs::findOne(['transaction_id'=>$res->receipt->transaction_id]))){
                    $model = new IosPaylogs();
                    $model->receipt = $data;
                    $model->status = $res->status;
                    $model->original_purchase_date_pst = isset($res->receipt->original_purchase_date_pst)?$res->receipt->original_purchase_date_pst:"";
                    $model->purchase_date_ms = isset($res->receipt->purchase_date_ms)?$res->receipt->purchase_date_ms:"";
                    $model->unique_identifier = isset($res->receipt->unique_identifier)?$res->receipt->unique_identifier:"";
                    $model->original_transaction_id = isset($res->receipt->original_transaction_id)?$res->receipt->original_transaction_id:"";
                    $model->bvrs = isset($res->receipt->bvrs)?$res->receipt->bvrs:"";
                    $model->transaction_id = isset($res->receipt->transaction_id)?$res->receipt->transaction_id:"";
                    $model->unique_vendor_identifier = isset($res->receipt->unique_vendor_identifier)?$res->receipt->unique_vendor_identifier:"";
                    $model->item_id = isset($res->receipt->item_id)?$res->receipt->item_id:"";
                    $model->product_id = isset($res->receipt->product_id)?$res->receipt->product_id:"";
                    $model->purchase_date = isset($res->receipt->purchase_date)?$res->receipt->purchase_date:"";
                    $model->original_purchase_date = isset($res->receipt->original_purchase_date)?$res->receipt->original_purchase_date:"";
                    $model->purchase_date_pst = isset($res->receipt->purchase_date_pst)?$res->receipt->purchase_date_pst:"";
                    $model->bid = isset($res->receipt->bid)?$res->receipt->bid:"";
                    $model->original_purchase_date_ms = isset($res->receipt->original_purchase_date_ms)?$res->receipt->original_purchase_date_ms:"";
                    $model->create_time = date('Y-m-d H:i:s');
                    $model->player = $player;
                    $model->orderid = $orderid;
                    Yii::warning("<<--model 复制完成-->>",'iospay');
                    if($model->save()){
                        if ($res->status==0 && is_object($product)){
                            Yii::warning("收据信息保存成功，且收据产品id 状态已验证",'iospay');
                            return json_encode(ApiErrorCode::$OK);
                        }else {
                            Yii::warning("收据信息保存成功，收据状态验证失败status",'iospay');
                            return json_encode(ApiErrorCode::$ReceiptStatusError);
                        }
                    }else {
                        Yii::warning("Receipt save error".print_r($model->getErrors(),true),'iospay');
                        return json_encode(ApiErrorCode::$ReceiptSaveError);
                    }
                }else {
                    Yii::warning("trans id saved before",'iospay');
                    return json_encode(ApiErrorCode::$OK);
                }
            }else {
                Yii::warning("收据状态验证失败status",'iospay');
                $this->logtodb("iospay","orderid : ".$orderid."收据状态验证失败status ".$res->status ,'error');
                return json_encode(ApiErrorCode::$ReceiptStatusError);
            }
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
    function checkReceipt($str,$sandbox = FALSE)
    {
        if ($sandbox){
            $veryfyUrl="https://sandbox.itunes.apple.com/verifyReceipt";
        }else {
            $veryfyUrl="https://buy.itunes.apple.com/verifyReceipt";
        }
//         Yii::warning("校验收据POSTurl $veryfyUrl",'iospay');
        $res=$this->postClient($veryfyUrl, $str);
        return $res;
    }
    function postClient($url,$post_data){//POST方法
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
            Yii::warning("http请求appstore 结果异常: ".'Errno'.curl_error($ch),'iospay');
            return false;
        }
        curl_close($ch);
        // 		var_dump($output);
        Yii::warning("http请求appstore 结果: ".print_r($output,true),'iospay');
        $output=json_decode($output);
        return $output;
    }
    function getClient($url){
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
//         $log2=$gid;
//         $log2.=" keyword:";
//         $log2.=$keyword;
//         $log2.=" osver: ".$osver;
//         $log2.=" appver:".$appver;
//         $log2.=" No:".$lineNo;
//         $log2.=" uuid:".$uuid;
//         $log2.=" ime:".$dev_id;
//         $log2.=" channel:".$channel;
//         $log2.=" ip:".$ip;
//         $log2.=" city:".$log->city;
//         $log2.=" isp:".$log->isp;
        $this->savesLog($log2,"login");
        Yii::$app->redis->lpush("Keylogin",$log2);
//         if (!$log->save())
//             $this->savesLog("save login log failed ".print_r($log->getErrors(),true),'error');
    }
    public function actionYeepayresultniu()
    {
        Yii::error("yeepay niu ");
        $this->layout="main_niu";
        $issuccess=Yii::$app->getRequest()->getQueryParam('issuccess');
//         if ($issuccess==0){
            
            return $this->render("niu_yepsuc",['issuccess'=>$issuccess]);
//         }else {
//             $params=Yii::$app->getRequest()->getQueryParam('params');
//             return $this->render("yeepaysuccess",['issuccess'=>$issuccess,'params'=>$params]);
//         }
    
    }
    public function actionYeepayniu()
    {
        $this->layout="main_niu";
        $ctype = Yii::$app->getRequest()->getQueryParam('ctype');//ctype=1表示游戏卡充值，默认电话卡充值
        $ptype=Yii::$app->getRequest()->getQueryParam('ptype');
        
        $gid=Yii::$app->getRequest()->getQueryParam('gid');
        $order=Yii::$app->getRequest()->getQueryParam('orderid');
        $productid=Yii::$app->getRequest()->getQueryParam('productid');
        $price=Yii::$app->getRequest()->getQueryParam('price');
        
        if (Yii::$app->getRequest()->isPost){
            $card = Yii::$app->getRequest()->getQueryParam('ptype');
            $card_num = Yii::$app->getRequest()->getBodyParam('card_num');
            $card_pwd = Yii::$app->getRequest()->getBodyParam('card_pwd');
            $price = Yii::$app->getRequest()->getBodyParam('money');
            $ext="";
            $p3_Amt=$price.'.00';
            $p4_verifyAmt="false";
            $p5_Pid=$productid;
            $p6_Pcat="";
            $p7_Pdesc="";
            $p8_Url="http://bf.koudaishiji.com/callback/yeepay/payreturn?ptype=".$card."&order=".$order."&gid=".$gid."&productid=".$productid;
            Yii::error(" card type : ".$card." card id : ".$card_num." card pwd ".$card_pwd);
            $gmor = new yeepay();
            $res = $gmor->annulCard($order, $p3_Amt, $p4_verifyAmt, $p5_Pid, $p6_Pcat, $p7_Pdesc, $p8_Url, $ext,
                $price, $card_num, $card_pwd, $card, $gid, date('Y-m-d H:i:s'));
            if (!$res) {
//                 return $this->render('niu_yepsuc',['issuccess'=>'0']);
                return 0;
            } else {
                Yii::error("called back result: ".print_r($res,true));
//                 return 1;
                    return json_encode($res);
//                 return $this->render('niu_yepsuc',['issuccess'=>'1']);
            }
        }else {
            if ($ptype==""){
                if ($ctype!=""){
                    return $this->render('niu_yechose',['gamecard'=>$ctype]);
                }
                return $this->render('niu_yechose');
            }else{
                return $this->render('niu_yeepay');
            }
        }
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
