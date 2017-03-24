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

class GameController extends Controller
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
        $list=['index','iappay','getdata','showres','iapred','iapweb','moremoney','bairenbang'
        ];
        foreach ($list as $id)
        {
            if ($id == $aid)
                return true;
        }
        return FALSE;
    }
    
    public function actionResupdate()
    {
        $resbuild = Yii::$app->getRequest()->getQueryParam('resbuild');
        if ($resbuild < 2)
        {
                $x = [
                'download_url'=>urlencode("http://zjh.koudaishiji.com/clientupdate/"),
                'resbuild'=>'8',
                'update_list'=>[
                        [
                            'filename'=>'src',
                            'filesize'=>'29',
                        ],
                        [   'filename'=>'res',
                             'filesize'=>'29',
                        ],
                    ],
                'update_type'=>'3',//
                'apkname'=>'kldyj.apk.zip',//只有当updatetype = 1的时候强更apk包
                'totalsize'=>'0.1',//总大小，单位Mb，用来显示文字
                
            ];
            $res = ApiErrorCode::$OK;
            $res['info']=$x;
            return json_encode($res);
        }else {
            return json_encode(ApiErrorCode::$OK);
        }
    }
    public function actionShowres()
    {
        echo "Showres";
    }
    public function actionIapred()
    {
        echo "Showres";
    }
    public function actionMoremoney()
    {
        $this->layout="main_none";
        return $this->render('more');
    }
    
    public function actionIapweb()
    {
        Yii::error("iapweb postdata: ".print_r(Yii::$app->getRequest()->getBodyParams(),true));
        $order = Yii::$app->getRequest()->getQueryParam('order');
        $od = GmOrderlist::findOne(['orderid'=>$order]);
        if (!is_object($od))
        {
            Yii::error("order not found!");
            return "error  ordernot found!";
        }
        $acc= GmAccountInfo::findOne($od->playerid);
        $chn = GmChannelInfo::findOne($acc->reg_channel);
        $tp =$chn->ipay ;
        $string = Yii::$app->getRequest()->getBodyParams();
        Yii::error("All iapweb Post data: -----\r\n".print_r($string,true),'iap');
        
        Yii::error("\r\n------All Post data end -------\r\n",'iap');
        $ipK = CfgIpayParams::findOne($tp);
        $source = "ipayweb".$tp;
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
                    $money=$arr->money;
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
                                    Yii::error("订单号找到,订单金额".$orderx->fee." 通知金额".$money,'iap');
                                    if (intval($orderx->fee)!=intval($money))
                                    {
                                        $this->logtodb('iappayError', "订单金额与支付金额不一致".$orderx->orderid."，订单金额".$orderx->fee." 通知金额".$money);
                                        return "failed";
                                    } 
                                    if ($orderx->status==0)
                                    {
                                        Yii::error("订单状态为未支付，现在支付",'iap');
                                        $orderx->status=1;
                                        $orderx->transaction_id=$transid;
                                        $orderx->transaction_time = $transtime;
                                        $orderx->utime=date('Y-m-d H:i:s');
                                        $orderx->source=$source;
                                        if ($orderx->save()){
                                            Yii::error("订单状态修改成功，等待服务器处理".$cporderid,'iap');
                                            echo 'SUCCESS';
                                        }else {
                                            Yii::error("订单状态修改失败".print_r($orderx->getErrors(),true));
                                        }
                                    }else { 
                                        Yii::error("订单号找到,订单『".$cporderid."』状态不为0",'iap');
                                        return 'SUCCESS';
                                    }
                        }else{
                            Yii::error("订单号未找到，".$cporderid,'iap');
                        }
                    }else
                    {
                        Yii::error("appid商户appid 错误不匹配",'iap');
                    }
                }
    }
    
    public function actionIappay()
    {
        $this->layout="main_none";
        $gid = Yii::$app->getRequest()->getQueryParam('gid',0);
        $orderid = Yii::$app->getRequest()->getQueryParam('orderid',0);
        $qtype = Yii::$app->getRequest()->getQueryParam('type',0);
        if ($qtype == 1)//1ajax json 请求
        {
//             echo "yes in getiap order";
            $data = $this->getipayOrder($gid, $orderid); 
            if (!$data)
                echo "data false";
            return $data;
        }  
        return $this->render('iappay');
    }
    public function actionGetdata(){
        $gid = Yii::$app->getRequest()->getQueryParam('gid',0);
        $orderid = Yii::$app->getRequest()->getQueryParam('orderid',0);
        $qtype = Yii::$app->getRequest()->getQueryParam('type',0);
        if ( $qtype==1)//1ajax json 请求
        {
//             echo "yes in getiap order";
            $data = $this->getipayOrder($gid, $orderid);
//             if (!$data)
//                 echo "data false";
            return $data;
        }else {
            echo  $gid." gid ".$orderid." orderid qtype:".$qtype;
        }
    }
    function getipayOrder($gid,$orderid) {
         //爱贝参数
        $acc = GmAccountInfo::findOne($gid);
        if (!is_object($acc))
        {
            Yii::error($gid."user not exsit");
            return "user not exsit";
        }
        $ch = GmChannelInfo::findOne($acc->reg_channel);
        $iappayParams=[
            'id'=>1,
            'appid'=>'3005985459',
            'appdesc'=>'天天大赢家',
            'privatekey'=>'MIICXAIBAAKBgQCYy2UPvQIrjdNtbyCBfcTjxCP9df8JE18GJfPGuHkLDfuXcSkfI8I+mjxnr6eIkBvCwJYrbry1DNSG+9mfw/kpgnjqcdHffCvHSnqC6pORwu7t2q8H7au1LTXdTc99qdCa9QH2B9V3IKDatqZpohdSTbTU9PTsj+csD9rNRT8PFQIDAQABAoGABwd8a7/vRJ+utV8iaLKnhy7z1OpDxGAexAKk92RvNSH8jBgJo0Qa4JRp6P88vtyaWlhP0Em05sNjV55ogaAba0pBxNeZrp9sX5aRIvxyCBE21ZFpygKj+8tFCfFYQilDQS7i0uhrokpgQi2q1G787MmeFIEorJV1UNtcFde6zSECQQDGBoiss3gdAz0nB5DztJHVPL2IZnt8kF7kQdX+28+F22hCp6Ij/tCljCEHfPyEKJViXFuwJP2b0UvVuKJdBRUNAkEAxYbr4p9cfpMvHw6e9YLUhO1Nw4V6JmM3x/2wqzsLqmsDebfUa9D8aFq6XqrnUO6sD7Ki8FAVJrMZpylIYt1wKQJAabBfDd2Tg9iQsN4G7Ss4kliix8P6sFbVbnn83tMuhUC++qRBk3iSn2iU0ExS8a4/XInynaaAfMNN+Dlc3syxmQJBAIMk6Ug1djuzjP2Zv4BRtLfstkyyOj9ycH6fuMR3F2+2TUBrBOXwgyTl2AcygRIC5MonWHclNGXVU5rglebODsECQBUbb2cPFDWvFf7N2D8P6hOb5j15KLbPi6wjSeJjKg0qhAPpi7c6a5Nnm8Ka/JKF+pI4Y2/zGyW4MZ/J/WDh7HI=',
            'platkey'=>'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDIV5HiWUJ5Gou6vWXpArmNVdCEqvnmakIpCngoptQSlk29/+TzrBqdmom3EBAmBNEpHbbi5fqF2iG9fMRaWLRyxyqQnrftIBnHgYYRqvLUlzD7TH8kvS6L3oMP4bvu3JdaLohg8kIedikSvDrE/k+4XLj7YmGwjN4Bv0UWAt/GtQIDAQAB', 
        ];
        if (is_object($ch) && $ch->ipay!="")
            $iappayParams=CfgIpayParams::findOne($ch->ipay)->attributes;
        else 
            $iappayParams=CfgIpayParams::findOne(1)->attributes;
        $ordinfo = GmOrderlist::findOne(['orderid'=>$orderid,'status'=>0]);
        $priceorder = 0.01;
        if (is_object($ordinfo))
            $priceorder = $ordinfo->price;
        $ext = sprintf("%s_._%s_._%d",$ordinfo->productid,$orderid,$gid);
        
        $waresid = 7;
        if ($ordinfo->productid == "zuanshi_android_6"||$ordinfo->productid == "zuanshi_ios_6"||$ordinfo->productid == "com.yuwan.whuanlezjhld1"){
            $waresid = 1;
        }elseif ($ordinfo->productid == "zuanshi_android_10"||$ordinfo->productid == "zuanshi_ios_18"||$ordinfo->productid == "com.yuwan.whuanlezjhld2"){
            $waresid = 2;
        }elseif ($ordinfo->productid == "zuanshi_android_30"||$ordinfo->productid == "zuanshi_ios_30"||$ordinfo->productid == "com.yuwan.whuanlezjhld3"){
            $waresid = 3;
        }elseif ($ordinfo->productid == "zuanshi_android_50"||$ordinfo->productid == "zuanshi_ios_60"||$ordinfo->productid == "com.yuwan.whuanlezjhld4"){
            $waresid = 4;
        }elseif ($ordinfo->productid == "zuanshi_android_100"||$ordinfo->productid == "zuanshi_ios_128"||$ordinfo->productid == "com.yuwan.whuanlezjhld5"){
            $waresid = 5;
        }elseif ($ordinfo->productid == "zuanshi_android_300"||$ordinfo->productid == "zuanshi_ios_328"||$ordinfo->productid == "com.yuwan.whuanlezjhld6"){
            $waresid = 6;
        }elseif ($ordinfo->productid == "zuanshi_android_500"||$ordinfo->productid == "zuanshi_ios_648"||$ordinfo->productid == "com.yuwan.whuanlezjhld7"){
            $waresid = 7;
        }elseif ($ordinfo->productid == "zuanshi_android_1000"||$ordinfo->productid == "zuanshi_ios_1000"){
            $waresid = 8;
        }elseif ($ordinfo->productid == "fast_android_6"||$ordinfo->productid == "fast_ios_6"){
            $waresid = 9;
        }elseif ($ordinfo->productid == "fast_android_10"||$ordinfo->productid == "fast_ios_18"){
            $waresid = 10;
        }elseif ($ordinfo->productid == "fast_android_30"||$ordinfo->productid == "fast_ios_30"){
            $waresid = 11;
        }elseif ($ordinfo->productid == "fast_android_50"||$ordinfo->productid == "fast_ios_60"){
            $waresid = 12;
        }elseif ($ordinfo->productid == "fast_android_100"||$ordinfo->productid == "fast_ios_128"){
            $waresid = 13;
        }elseif ($ordinfo->productid == "fast_android_300"||$ordinfo->productid == "fast_ios_328"){
            $waresid = 14;
        }elseif ($ordinfo->productid == "card_week"||$ordinfo->productid == "card_week"){
            $waresid = 15;
        }elseif ($ordinfo->productid == "card_month"||$ordinfo->productid == "card_month"){
            $waresid = 16;
        }else {
            $waresid = 7;
        }
         
        $iap = new ipay();
        //下单接口
        $orderReq['appid'] = $iappayParams['appid'];
        $orderReq['waresid'] = $waresid;
        $orderReq['cporderid'] = $orderid; //确保该参数每次 都不一样。否则下单会出问题。
//         echo "microtime()";
//         $orderReq['price'] = $priceorder;   //单位：元
        $orderReq['currency'] = 'RMB';
        $orderReq['appuserid'] = $gid;
        $orderReq['cpprivateinfo'] = $ext;
        $orderReq['notifyurl'] = Yii::$app->getRequest()->getHostInfo().'/game/iapweb/'.$orderid;
        //组装请求报文  对数据签名 
        Yii::error("orderReq: ".print_r($orderReq,true));
        $reqData = $iap->composeReq($orderReq, $iappayParams['privatekey']);
        Yii::error("iappayParams: ".print_r($iappayParams,true));
        Yii::error("orderRequst: ".print_r($orderReq,true)." aibei 组装签名 reqData :".$reqData);
        $orderUrl='http://ipay.iapppay.com:9999/payapi/order';
        //发送到爱贝服务后台请求下单
        $respData = $iap->request_by_curl($orderUrl, $reqData, 'HanoHttp');  
        Yii::error("aibei respData   :".$respData);
        //验签数据并且解析返回报文
        if(!$iap->parseResp($respData, $iappayParams['platkey'], $respJson)) {
            Yii::error("parse failed!!!!");
            return false;
        }else{
            Yii::error("parse success!!!!".print_r($respJson,true)); 
//             return $respJson->transid;
        } 
        $rtData = [
            'transId'=>$respJson->transid,
            'retFunc'=>"callbackData", 
            'redirecturl'=>Yii::$app->getRequest()->getHostInfo()."/game/iapred",
            'cpurl'=>Yii::$app->getRequest()->getHostInfo()."/game/showres",
        ];
        $rtData['sign']=$iap->sign($rtData['transId'].$rtData['redirecturl'].$rtData['cpurl'], $iap->formatPriKey($iappayParams['privatekey']));
        $rtData['signtype']="RSA";
        $rtData['baseZIndex']=88;
        $rtData['closeTxt']="返回app"; 
        return json_encode($rtData);
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
    
    public function actionWarseat()
    {
        $ar=ApiErrorCode::$OK;
        $kw = "WarSeatNow2";
        $dataws=Yii::$app->cache[$kw];
        if ($dataws == false){
            $sql='call getLastwar20()';
            $db=Yii::$app->db_readonly;
            $res=$db->createCommand($sql)
             ->queryAll();
            $dataws=$res[0];
            Yii::$app->cache->set($kw, $dataws,60);
        }
        
        if (is_array($dataws)){
            foreach ($dataws as $k =>$v)
            {
                $dataws[$k]=strval($v);
            }
            
            $ar['info']=[
                'hao'=>[
                    'gid'=>intval($dataws['Haouid']),
                    'vip'=>intval($dataws['Haovip']),
                    'nick'=>strval($dataws['Haonick']),
                    'money'=>$dataws['Haomoney'],
                    'last20Bet'=>$dataws['Haolast20Bet'],
                    'last20Win'=>$dataws['Haolast20Win'],
                    'todayWin'=>$dataws['HaotodayWin'],
                    'todayWinno'=>$dataws['HaotodayWinno'],
                ],
                'lucky'=>[
                    'gid'=>intval($dataws['Luckyuid']),
                    'vip'=>intval($dataws['Luckyvip']),
                    'nick'=>$dataws['Luckynick'],
                    'money'=>$dataws['Luckymoney'],
                    'last20Bet'=>$dataws['Luckylast20Bet'],
                    'last20Win'=>$dataws['Luckylast20Win'],
                    'todayWin'=>$dataws['LuckytodayWin'],
                    'todayWinno'=>$dataws['LuckytodayWinno'],
                ],
            ];
        }else{
            $ar['info']=[
                'hao'=>[
                    'gid'=>192220,
                    'vip'=>11,
                    'nick'=>"HaoName1",
                    'money'=>'11亿',
                    'last20Bet'=>'4亿',
                    'last20Win'=>'2亿',
                    'todayWin'=>'6亿',
                    'todayWinno'=>'18局',
                ],
                'lucky'=>[
                    'gid'=>192220,
                    'vip'=>0,
                    'nick'=>"N33Lucky",
                    'money'=>'303.3万',
                    'last20Bet'=>'202万',
                    'last20Win'=>'326.3万',
                    'todayWin'=>'4420万',
                    'todayWinno'=>'30局', 
                ],
            ];
        }
        return json_encode($ar);
    }
    public function actionBairenbang()
    {//百人榜单说明
        $this->layout="main";
        return $this->render('bairen');
    }
    
    public function actionSslext()
    {
//         getBetRanksInfo
        $ar=ApiErrorCode::$OK;
        $kw = "SSLextNow";
        $dataws=Yii::$app->cache[$kw];
        if ($dataws === false){
            $sql='call getBetRanksInfo()';
            $db=Yii::$app->db_readonly;
            $res=$db->createCommand($sql)
            //          ->bindValues($params)
            ->queryAll();
            $dataws=$res[0];
            Yii::$app->cache->set($kw, $dataws,60);
        }
        
        if (is_array($dataws)){
            $arrrr = $dataws;
            foreach($arrrr as $k=>$v)
            {
                $arrrr[$k]=strval($v);
            }
//             print_r($arrrr);
            $ar['info']=$arrrr;
        }else {
            $ar['info']=[
                'vTime3A'=>'2017-02-20 11:31',
                'V3Acoin'=>'10亿',
                'vTimeBaozi'=>'2017-02-20 11:31',
                'vBaoziCoin'=>'10亿',
                'xLastBiggid'=>'120110',
                'xLastBignick'=>'快乐萌三张',
                'xLastBigvip'=>'10',
                'xLastBigtype'=>'豹子',
                'xLastBigreward'=>'10亿',
                'xLastBigtime'=>'2017-02-20 11:31'
            ];
        } 
        Yii::$app->response->format=\yii\web\Response::FORMAT_JSON;
        return $ar;
    }
    
    public function actionWarrank()
    {
        //SELECT uid,round(sum(change_coin)/10000,0) as totalWin FROM `log_coin_war`
//where ctime > date_format(Now(),"%y-%m-%d 00:00:00")
//and prop_id=0
//group by uid order by totalWin desc 
        $ar=ApiErrorCode::$OK;
        $kw1 = "CacheresTdbet2";
        $resTdbet=Yii::$app->cache[$kw1];
        if ($resTdbet === false){
            $sql='call getWarRankTdbet()';
            $db=Yii::$app->db_readonly;
            $resTdbet=$db->createCommand($sql)
            //          ->bindValues($params)
            ->queryAll();
//             $dataws1=$res[0];
            Yii::$app->cache->set($kw1, $resTdbet,180);
        }
        
        $kw2 = "CacheresTdbanker2";
        $resTdbanker=Yii::$app->cache[$kw2];
        if ($resTdbanker === false){
            $sql2='call getWarRankTdbanker()';
            $db2=Yii::$app->db_readonly;
            $resTdbanker=$db2->createCommand($sql2)
            ->queryAll(); 
//             $dataws2=$resTdbanker[0];
            Yii::$app->cache->set($kw2, $resTdbanker,180);
        }
        $kw3 = "CacheresYesbet2".date('Ymd');
        $resYesbet=Yii::$app->cache[$kw3];
        if ($resYesbet === false){
            $sql3='call getWarRankYesbet()';
            $db=Yii::$app->db_readonly;
            $resYesbet=$db->createCommand($sql3)
            //          ->bindValues($params)
            ->queryAll();
//             $dataws1=$resYesbet[0];
            Yii::$app->cache->set($kw3, $resYesbet,86000);
        }
        $kw4 = "CacheresYesbanker2".date('Ymd');
        $resYesbanker=Yii::$app->cache[$kw4];
        if ($resYesbanker === false){
            $sql4='call getWarRankYesbanker()';
            $db=Yii::$app->db_readonly;
            $resYesbanker=$db->createCommand($sql4)
            //          ->bindValues($params)
            ->queryAll();
//             $dataws1=$res[0];
            Yii::$app->cache->set($kw4, $resYesbanker,86000);
        }
        
        $kw5 = "CacheresTdHongbao2";
        $resTdHongbao=Yii::$app->cache[$kw5];
        if ($resTdHongbao === false){
            $sql5='call getWarHongbao()';
            $db=Yii::$app->db_readonly;
            $resTdHongbao=$db->createCommand($sql5)
            //          ->bindValues($params)
            ->queryAll();
            //             $dataws1=$res[0];
            Yii::$app->cache->set($kw5, $resTdHongbao,600);
        }
//         $sql='call getWarRankTdbet()';
//         $db=Yii::$app->db_readonly;
//         $resTdbet=$db->createCommand($sql) 
//         ->queryAll();
//         $sql2='call getWarRankTdbanker()';
//         $db2=Yii::$app->db_readonly;
//         $resTdbanker=$db2->createCommand($sql2)
//         ->queryAll(); 
//         $sql3='call getWarRankYesbet()';
//         $db3=Yii::$app->db_readonly;
//         $resYesbet=$db3->createCommand($sql3)
//         ->queryAll();
//         $sql4='call getWarRankYesbanker()';
//         $db4=Yii::$app->db_readonly;
//         $resYesbanker=$db4->createCommand($sql4)
//         ->queryAll();
        
        if (count($resTdbet)>0){
            foreach ($resTdbet as $ka=>$v)
            {
                foreach ($v as $kk=>$vv)
                {
                    $resTdbet[$ka]["rank"]=strval($ka+1);
                    if ($kk=="totalwin"){
                        $resTdbet[$ka][$kk]=strval(abs($vv)."万");
                    }else {
                        $resTdbet[$ka][$kk]=strval($vv);
                    }
                }
            }
        }
        if (count($resTdbanker)>0){
            foreach ($resTdbanker as $ka=>$v)
            {
                foreach ($v as $kk=>$vv)
                {
                    $resTdbanker[$ka]["rank"]=strval($ka+1); 
                    if ($kk=="totalwin"){
                        $resTdbanker[$ka][$kk]=strval($vv."万");
                    }else {
                        $resTdbanker[$ka][$kk]=strval($vv);
                    }
                }
            }
        }
        if (count($resYesbet)>0){
            foreach ($resYesbet as $ka=>$v)
            {
                foreach ($v as $kk=>$vv)
                {
                    $resYesbet[$ka]["rank"]=strval($ka+1); 
                    if ($kk=="totalwin"){
                        $resYesbet[$ka][$kk]=strval(abs($vv)."万");
                    }else {
                        $resYesbet[$ka][$kk]=strval($vv);
                    }
                }
            }
        }
        if (count($resYesbanker)>0){
            foreach ($resYesbanker as $ka=>$v)
            {
                foreach ($v as $kk=>$vv)
                {
                    $resYesbanker[$ka]["rank"]=strval($ka+1); 
                    if ($kk=="totalwin"){
                        $resYesbanker[$ka][$kk]=strval($vv."万");
                    }else {
                        $resYesbanker[$ka][$kk]=strval($vv);
                    }
                }
            }
        }
        if (count($resTdHongbao)>0){
            foreach ($resTdHongbao as $ka=>$v)
            {
                foreach ($v as $kk=>$vv)
                {
                    $resTdHongbao[$ka]["rank"]=strval($ka+1);
                    if ($kk=="totalcost"){
                        $resTdHongbao[$ka][$kk]=strval($vv."万");
                    }else {
                        $resTdHongbao[$ka][$kk]=strval($vv);
                    }
                }
            }
        }
        $ranksTdbet=$resTdbet;
        $ranksTdbanker=$resTdbanker;
        $ranksYesbet = $resYesbet;
        $ranksYesbanker = $resYesbanker;
        $ranksHongbao = $resTdHongbao;
//         $ranksTdbet=[
//              ['gid'=>'120110','rank'=>'1','nick'=>'aaaa','avatar'=>'120110.jpg','viplevel'=>'1','value'=>'780万'],
//              ['gid'=>'120122','rank'=>'2','nick'=>'aaaxa','avatar'=>'120110.jpg','viplevel'=>'20','value'=>'600万'],
//              ['gid'=>'120134','rank'=>'3','nick'=>'aaxaa','avatar'=>'120110.jpg','viplevel'=>'10','value'=>'600万'],
//              ['gid'=>'120222','rank'=>'4','nick'=>'aaxaa','avatar'=>'120110.jpg','viplevel'=>'12','value'=>'600万'],
//              ['gid'=>'199155','rank'=>'5','nick'=>'axaaaa','avatar'=>'120110.jpg','viplevel'=>'12','value'=>'600万'],
//              ['gid'=>'120110','rank'=>'6','nick'=>'1aaxaa','avatar'=>'120110.jpg','viplevel'=>'12','value'=>'600万'],
//              ['gid'=>'120110','rank'=>'7','nick'=>'2aaxaa','avatar'=>'120110.jpg','viplevel'=>'12','value'=>'600万'],
//              ['gid'=>'120110','rank'=>'8','nick'=>'a2aaa','avatar'=>'120110.jpg','viplevel'=>'12','value'=>'600万'],
//              ['gid'=>'120110','rank'=>'9','nick'=>'3aaaa','avatar'=>'120110.jpg','viplevel'=>'12','value'=>'600万'],
//              ['gid'=>'120110','rank'=>'10','nick'=>'xaaaa','avatar'=>'120110.jpg','viplevel'=>'12','value'=>'600万'],
//              ['gid'=>'120110','rank'=>'11','nick'=>'aa4aa','avatar'=>'120110.jpg','viplevel'=>'12','value'=>'600万'],
//              ['gid'=>'120110','rank'=>'12','nick'=>'taaaa','avatar'=>'120110.jpg','viplevel'=>'12','value'=>'600万'],
//              ['gid'=>'120110','rank'=>'13','nick'=>'taaaa','avatar'=>'120110.jpg','viplevel'=>'12','value'=>'600万'],
//              ['gid'=>'120110','rank'=>'14','nick'=>'taaaa','avatar'=>'120110.jpg','viplevel'=>'12','value'=>'600万'],
//              ['gid'=>'120110','rank'=>'15','nick'=>'taaaa','avatar'=>'120110.jpg','viplevel'=>'12','value'=>'600万'],
//         ];
//         $ranksTdbanker=[
//             ['gid'=>'199148','rank'=>'1','nick'=>'aaaa','avatar'=>'120110.jpg','viplevel'=>'1','value'=>'890万'],
//             ['gid'=>'199056','rank'=>'2','nick'=>'aaaxa','avatar'=>'120110.jpg','viplevel'=>'20','value'=>'772万'],
//             ['gid'=>'120110','rank'=>'3','nick'=>'aaxaa','avatar'=>'120110.jpg','viplevel'=>'10','value'=>'600万'],
//             ['gid'=>'120110','rank'=>'4','nick'=>'aaxaa','avatar'=>'120110.jpg','viplevel'=>'12','value'=>'600万'],
//             ['gid'=>'120110','rank'=>'5','nick'=>'axaaaa','avatar'=>'120110.jpg','viplevel'=>'12','value'=>'600万'],
//             ['gid'=>'120110','rank'=>'6','nick'=>'1aaxaa','avatar'=>'120110.jpg','viplevel'=>'12','value'=>'600万'],
//             ['gid'=>'120110','rank'=>'7','nick'=>'2aaxaa','avatar'=>'120110.jpg','viplevel'=>'12','value'=>'600万'],
//             ['gid'=>'120110','rank'=>'8','nick'=>'a2aaa','avatar'=>'120110.jpg','viplevel'=>'12','value'=>'600万'],
//             ['gid'=>'120110','rank'=>'9','nick'=>'3aaaa','avatar'=>'120110.jpg','viplevel'=>'12','value'=>'600万'],
//             ['gid'=>'120110','rank'=>'10','nick'=>'xaaaa','avatar'=>'120110.jpg','viplevel'=>'12','value'=>'600万'],
//             ['gid'=>'120110','rank'=>'11','nick'=>'aa4aa','avatar'=>'120110.jpg','viplevel'=>'12','value'=>'600万'],
//             ['gid'=>'120110','rank'=>'12','nick'=>'taaaa','avatar'=>'120110.jpg','viplevel'=>'12','value'=>'600万'],
//             ['gid'=>'120110','rank'=>'13','nick'=>'taaaa','avatar'=>'120110.jpg','viplevel'=>'12','value'=>'600万'],
//             ['gid'=>'120110','rank'=>'14','nick'=>'taaaa','avatar'=>'120110.jpg','viplevel'=>'12','value'=>'600万'],
//             ['gid'=>'120110','rank'=>'15','nick'=>'taaaa','avatar'=>'120110.jpg','viplevel'=>'12','value'=>'600万'],
//         ];
//         $ranksYesbet=[
//             ['gid'=>'120110','rank'=>'1','nick'=>'TTTaaaa','avatar'=>'120110.jpg','viplevel'=>'1','value'=>'600万'],
//             ['gid'=>'120110','rank'=>'2','nick'=>'XXXaaaxa','avatar'=>'120110.jpg','viplevel'=>'20','value'=>'600万'],
//             ['gid'=>'120110','rank'=>'3','nick'=>'GGGaaxaa','avatar'=>'120110.jpg','viplevel'=>'10','value'=>'600万'],
//             ['gid'=>'120110','rank'=>'4','nick'=>'GGGaaxaa','avatar'=>'120110.jpg','viplevel'=>'12','value'=>'600万'],
//             ['gid'=>'120110','rank'=>'5','nick'=>'YYYaxaaaa','avatar'=>'120110.jpg','viplevel'=>'12','value'=>'600万'],
//             ['gid'=>'120110','rank'=>'6','nick'=>'NNN1aaxaa','avatar'=>'120110.jpg','viplevel'=>'12','value'=>'600万'],
//             ['gid'=>'120110','rank'=>'7','nick'=>'JJJ2aaxaa','avatar'=>'120110.jpg','viplevel'=>'12','value'=>'600万'],
//             ['gid'=>'120110','rank'=>'8','nick'=>'UUa2aaa','avatar'=>'120110.jpg','viplevel'=>'12','value'=>'600万'],
//             ['gid'=>'120110','rank'=>'9','nick'=>'II3aaaa','avatar'=>'120110.jpg','viplevel'=>'12','value'=>'600万'],
//             ['gid'=>'120110','rank'=>'10','nick'=>'OOxaaaa','avatar'=>'120110.jpg','viplevel'=>'12','value'=>'600万'],
//             ['gid'=>'120110','rank'=>'11','nick'=>'IIaa4aa','avatar'=>'120110.jpg','viplevel'=>'12','value'=>'600万'],
//             ['gid'=>'120110','rank'=>'12','nick'=>'taaaa','avatar'=>'120110.jpg','viplevel'=>'12','value'=>'600万'],
//             ['gid'=>'120110','rank'=>'13','nick'=>'taaaa','avatar'=>'120110.jpg','viplevel'=>'12','value'=>'600万'],
//             ['gid'=>'120110','rank'=>'14','nick'=>'taaaa','avatar'=>'120110.jpg','viplevel'=>'12','value'=>'600万'],
//             ['gid'=>'120110','rank'=>'15','nick'=>'taaaa','avatar'=>'120110.jpg','viplevel'=>'12','value'=>'600万'],
//         ];
//         $ranksYesbanker=[
//             ['gid'=>'120110','rank'=>'1','nick'=>'aaaa','avatar'=>'120110.jpg','viplevel'=>'1','value'=>'600万'],
//             ['gid'=>'120110','rank'=>'2','nick'=>'aaaxa','avatar'=>'120110.jpg','viplevel'=>'20','value'=>'600万'],
//             ['gid'=>'120110','rank'=>'3','nick'=>'aaxaa','avatar'=>'120110.jpg','viplevel'=>'10','value'=>'600万'],
//             ['gid'=>'120110','rank'=>'4','nick'=>'aaxaa','avatar'=>'120110.jpg','viplevel'=>'12','value'=>'600万'],
//             ['gid'=>'120110','rank'=>'5','nick'=>'axaaaa','avatar'=>'120110.jpg','viplevel'=>'12','value'=>'600万'],
//             ['gid'=>'120110','rank'=>'6','nick'=>'1aaxaa','avatar'=>'120110.jpg','viplevel'=>'12','value'=>'600万'],
//             ['gid'=>'120110','rank'=>'7','nick'=>'2aaxaa','avatar'=>'120110.jpg','viplevel'=>'12','value'=>'600万'],
//             ['gid'=>'120110','rank'=>'8','nick'=>'a2aaa','avatar'=>'120110.jpg','viplevel'=>'12','value'=>'600万'],
//             ['gid'=>'120110','rank'=>'9','nick'=>'3aaaa','avatar'=>'120110.jpg','viplevel'=>'12','value'=>'600万'],
//             ['gid'=>'120110','rank'=>'10','nick'=>'xaaaa','avatar'=>'120110.jpg','viplevel'=>'12','value'=>'600万'],
//             ['gid'=>'120110','rank'=>'11','nick'=>'aa4aa','avatar'=>'120110.jpg','viplevel'=>'12','value'=>'600万'],
//             ['gid'=>'120110','rank'=>'12','nick'=>'taaaa','avatar'=>'120110.jpg','viplevel'=>'12','value'=>'600万'],
//             ['gid'=>'120110','rank'=>'13','nick'=>'taaaa','avatar'=>'120110.jpg','viplevel'=>'12','value'=>'600万'],
//             ['gid'=>'120110','rank'=>'14','nick'=>'taaaa','avatar'=>'120110.jpg','viplevel'=>'12','value'=>'600万'],
//             ['gid'=>'120110','rank'=>'15','nick'=>'taaaa','avatar'=>'120110.jpg','viplevel'=>'12','value'=>'600万'],
//         ];
        $myYesbet='9999名';
        $myYesbanker='无名次';
        $myTdbet='234名';
        $myTdbanker='50名';
        $myTdhong = '暂无名次';
        
        $ar['info']=[
            'tdbet'=>['ranks'=>$ranksTdbet,'my'=>$myTdbet],
            'tdbanker'=>['ranks'=>$ranksTdbanker,'my'=>$myTdbanker],
            'yesbet'=>['ranks'=>$ranksYesbet,'my'=>$myYesbet],
            'yesbanker'=>['ranks'=>$ranksYesbanker,'my'=>$myYesbanker], 
            'tdhongbao'=>['ranks'=>$ranksHongbao,'my'=>$myTdhong], 
        ];
        return json_encode($ar);
    }
}
