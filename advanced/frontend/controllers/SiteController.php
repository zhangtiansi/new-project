<?php
namespace frontend\controllers;

use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\LogUserrequst;
use Faker\Provider\Uuid;
use app\components\WxPayConfig;
use app\components\WxPayApi;
use app\components\WxPayData;
use app\components\WxPayUnifiedOrder;
use app\models\GmOrderlist;
use app\components\Acts;
use yii\base\Action;
/**
 * Site controller
 */
class SiteController extends Controller
{
    public $enableCsrfValidation = false;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    
    public function actionVersion()
    {
        return  "1.0.2";
    }
    public function actionDownload()
    {
        return "This is download URL for versionXXX";
    }
    public function actionLtupdate()
    {
        $x = [
            'download_url'=>urlencode("https://zjh.koudaishiji.com/clientupdate/"),
            'latest_version'=>['release'=>1,'debug'=>1],
            'update_list'=>[
//                     ['filename'=>urlencode('/src/app/views/DeLuView.lua'),
//                      'filesize'=>'29', 
//                     ], 
                ],
        ];
        return json_encode($x);
    }   
    public function actionTstxml()
    {
        $arx = [['a'=>1,'b'=>2,'c'=>3,'d'=>'xxxxx'],
        ['a'=>1,'b'=>66,'c'=>2,'d'=>'cccc'],
        ['a'=>1,'b'=>2,'c'=>3,'d'=>'wwwww'],
        ['a'=>1,'b'=>2,'c'=>3,'d'=>'tttt']];
        Yii::$app->response->format=\yii\web\Response::FORMAT_XML;
        return $arx;
    }
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionDoactman()
    {   //充值满送活动
        $x = GmOrderlist::actMan();
        if ($x)
            return "yes";
        else 
            return "no";
    }
    public function actionDoactmanios()
    {//IOS满送活动
        $x = GmOrderlist::actManIos();
        if ($x)
            return "yes";
        else
            return "no";
    }
    public function actionDologiniosact()
    {//连续登录IOS活动
        $x = GmOrderlist::actLoginIos();
        if ($x)
            return "yes";
        else
            return "no";
    }

    public function actionVipgift()
    {//VIP等级送金币只在次日登录赠送,每5分种执行一次（程序判断为20分钟内登录）
        $x = GmOrderlist::actVipGift();
        if ($x)
            return "yes";
        else
            return "no";
    }
    
    public function actionSslrank()
    {//时时乐排行榜奖励，每天9点执行
        $x = GmOrderlist::actSslRank();
        if ($x)
            return "yes";
        else
            return "no";
    }
    public function actionWup()
    {
        return $this->redirect('https://www.pgyer.com/wupa');
    }
    public function actionWupa()
    {
        return $this->redirect('https://www.pgyer.com/wupa');
    }
    public function actionWupi()
    {
        return $this->redirect('https://www.pgyer.com/wupi');
    }
    public function actionCardtype()
    {//特殊牌型豹子奖励，每5分钟执行
        $x = GmOrderlist::actEspecialCardType();
        if ($x)
            return "yes";
        else
            return "no";
    }
    
    public function actionRechargeprice()
    {//充值特定金额送,每分钟执行
        $x = GmOrderlist::actRechargePrice();
        if ($x)
            return "yes";
        else
            return "no";
    }
    public function actionFirstprice()
    {//首次充值特定金额送,每分钟执行
        $x = GmOrderlist::actFirst();
        if ($x)
            return "yes";
        else
            return "no";
    }
    public function actionType10()
    {//充值比比返送，每1分钟执行
        $x = Acts::actRechargeSinglePrice();
        if ($x)
            return "yes";
        else
            return "no";
    }
    
    public function actionType11()
    {//水浒传次数奖励，每1分钟执行
        $x = Acts::actSlotTimes();
        if ($x)
            return "yes";
        else
            return "no";
    }
    
    public function actionType12()
    {//百人4门全胜，每1分钟执行
        $x = Acts::actWarWinFour();
        if ($x)
            return "yes";
        else
            return "no";
    }
    

    public function actionType13()
    {//游戏满N局送9点
    $x = Acts::actGamePlayed();
    if ($x)
        return "yes";
    else
        return "no";
    }
    public function actionType14()
    {//时时彩押注返10点
        $x = Acts::actSslBet();
        if ($x)
            return "yes";
        else
            return "no";
    }
    public function actionType15()
    {//充值返9.30
        $x = Acts::actRechargeManTomorrow();
        if ($x)
            return "yes";
        else
            return "no";
    }
    public function actionType16()
    {//充值返9.30
    $x = Acts::actWarbetrank();
    if ($x)
        return "yes";
    else
        return "no";
    }
    
    
    public function actionTx()
    {
        $ar= [
    'accessType' => '0',
    'bizType' => '000201',
    'certId' => '21267647932558653966460913033289351200',
    'currencyCode' => '156',
    'encoding' => 'utf-8',
    'merId' => '898110257340180',
    'orderId' => 'FA95CF014467907837898',
    'queryId' => '201511061419447023968',
    'reqReserved' => '145895_._FA95CF014467907837898_._zuanshi_android_6_._0.01',
    'respCode' => '00',
    'respMsg' => 'Success!',
    'settleAmt' => '1',
    'settleCurrencyCode' => '156',
    'settleDate' => '1106',
    'signMethod' => '01',
    'traceNo' => '702396',
    'traceTime' => '1106141944',
    'txnAmt' => '1',
    'txnSubType' => '01',
    'txnTime' => '20151106141944',
    'txnType' => '01',
    'version' => '5.0.0',
    'signature' => 'wE5EyPgnVNUroOxSYvjQak6H7YuBYDBPs8woH5tDHiGAgdv+rCqVFt5QwRjYquM7cUB8Qz/9ZwfacXAcNcdBlNP2Js7Ela7wOvWl/Cm9MidLQfBf796x6YgUY++sBgUwm5mw8+CeZYtOu1FlvD8Ci/duzQ9AlqUl1ieYoLm6iCwSWuScwTvQ5pkg6J0Qm8Mp976a3O+MmVVdseb2xuDYhPz48C35S0xHueVsWHOEf7AApK1ELKaVCr6HnBJRbiLxYweNetq4dkmdLAOnxLY+MobgNBUU09jShzHNoZZQfkqLVFK3RSmoD36UwrPV95fd8vOywQm9zsqV4/ndVoqgVQ=='
];
       $xx=[];
       foreach ($ar as $k=>$v){
           array_push($xx, $k."=".$v);
       }
       echo implode('&', $xx);
        
    }
    public function actionRedis()
    {
        $r=["	221939|.|quickRegister|.|1.4.2|.|Coolpad 5263|.||.|00000000-6f3c-69f4-ffff-ffffca1bc909|.|89860315248350456808|.|99000560855038|.|2026|.|111.9.184.65|.|2015-10-12 10:25:15	",
"	216874|.|normalLogin|.|1.4.1|.|TCL P316L|.||.|ffffffff-ad7c-a29b-ffff-ffffb933de41|.|89860315248790392472|.|A1000047E95575|.|2026|.|106.60.186.188|.|2015-10-12 10:25:18	",
"	203235|.|quickRegister|.|1.3|.|m4281|.||.|ffffffff-f254-de65-ffff-ffffe378d4a5|.|89860062111559002686|.|864439020500950|.|2010|.|112.17.246.140|.|2015-10-12 10:25:22	",
"	193396|.|quickRegister|.|1.4|.|SM-N9006|.||.|ffffffff-fc72-4916-ffff-fffffe320caf|.|89860022091588000982|.|359786055253299|.|2010|.|101.228.170.216|.|2015-10-12 10:25:26	",
"	221946|.|quickRegister|.|1.4|.|vivo Y622|.||.|00000000-4014-63a8-ffff-ffff9ef02438|.|898602a31615f1392607|.|865574021193840|.|2003|.|123.52.227.163|.|2015-10-12 10:25:27	",
"	212611|.|quickRegister|.|1.4.1|.|2014811|.||.|00000000-638e-f367-27a5-7d377f29227b|.|89860098245401627017|.|866048025765886|.|2026|.|117.136.84.156|.|2015-10-12 10:25:45	",
"	219346|.|normalLogin|.|1.4.2|.|LG-D620|.||.|00000000-7242-4ad4-6d7c-bfe262cce3ff|.|898600|.|352930060604503|.|2026|.|111.22.7.195|.|2015-10-12 10:25:47	",
"	193109|.|quickRegister|.|1.4.1|.|vivo X5S L|.||.|00000000-6d39-7fda-ffff-ffff880c3000|.|89860006111597006131|.|867194027641151|.|2026|.|60.181.101.104|.|2015-10-12 10:25:48	",
"	193109|.|quickRegister|.|1.4.1|.|vivo X5S L|.||.|00000000-6d39-7fda-ffff-ffff880c3000|.|89860006111597006131|.|867194027641151|.|2026|.|60.181.101.104|.|2015-10-12 10:25:53	",
"	221575|.|quickRegister|.|1.4.2|.|Lenovo A670t|.||.|00000000-3ca6-03ca-ffff-ffffb47f1bec|.|898600f0231480df1457|.|860366023942299|.|2026|.|218.201.227.254|.|2015-10-12 10:25:56	",
"	218790|.|normalLogin|.|1.4|.|HM NOTE 1W|.||.|00000000-5fd7-5963-ffff-ffff889d2f08|.|898600151314f8041517|.|865317025083793|.|2009|.|117.136.75.71|.|2015-10-12 10:26:30	",
"	168409|.|normalLogin|.|1.4|.|vivo Y13L|.|15126109373|.|ffffffff-a44a-b6c4-09b6-56a16b0d25c1|.|89860028244493414557|.|866299025194037|.|2010|.|223.104.12.41|.|2015-10-12 10:26:32	",
"	122248|.|normalLogin|.|1.4|.|m1 note|.||.|ffffffff-8ec5-4a63-ffff-fffff2b1d446|.|89860097179442991814|.|867348022661008|.|2000|.|116.210.192.29|.|2015-10-12 10:26:34	",
"	221790|.|normalLogin|.|1.4.1|.|GT-S7562C|.||.|00000000-59e9-64ad-6a8d-e9656b123b2f|.|89860109155312589768|.|358423058919772|.|2026|.|118.206.185.105|.|2015-10-12 10:26:37	",
"	215218|.|quickRegister|.|1.4.1|.|G621-TL00|.||.|00000000-57e4-b2e4-d8c4-b31b6328713c|.|898602A9261484401214|.|867064027799871|.|2026|.|113.142.234.211|.|2015-10-12 10:26:37	",
"	173720|.|quickRegister|.|1.4|.|MI 2SC|.||.|ffffffff-e3a8-5b51-ffff-ffffc7e76277|.|89860094088476796790|.|863361026499212|.|2013|.|1.56.84.4|.|2015-10-12 10:26:40	",
"	214671|.|quickRegister|.|1.4.1|.|R8207|.||.|00000000-33fe-8c59-38d9-1a5d2cc31d88|.|89860013045474587539|.|867275026563189|.|2012|.|117.136.4.179|.|2015-10-12 10:27:11	",
"	218790|.|normalLogin|.|1.4|.|HM NOTE 1W|.||.|00000000-5fd7-5963-ffff-ffff889d2f08|.|898600151314f8041517|.|865317025083793|.|2009|.|117.136.75.71|.|2015-10-12 10:27:14	",
"	214616|.|normalLogin|.|1.4|.|Lenovo S820|.||.|00000000-2620-9dea-b6b3-a1967c9a90f6|.|89860013045858296802|.|863802026107719|.|2009|.|101.107.233.97|.|2015-10-12 10:27:18	",
"	131396|.|quickRegister|.|1.4|.|SM-G3508I|.||.|ffffffff-ea79-42fb-ffff-ffffccb4dcaa|.|89860037175581493479|.|359787058409581|.|2010|.|117.136.74.181|.|2015-10-12 10:27:22	",
"	187779|.|normalLogin|.|1.4|.|vivo Y28L|.||.|00000000-5037-c5be-ffff-fffff0a589fb|.|898600d8243490182207|.|866724020953335|.|2010|.|117.136.84.222|.|2015-10-12 10:27:23	",
"	219754|.|quickRegister|.|1.4.1|.|HM NOTE 1S|.||.|ffffffff-91d5-c3ef-ffff-ffff8d3bb277|.|898602c31613fc263210|.|867514028603399|.|2026|.|117.136.36.187|.|2015-10-12 10:27:24	",
"	221961|.|quickRegister|.|1.4|.|vivo Y928|.||.|ffffffff-c591-75bd-ffff-ffffd3fd110e|.|89860313807570913666|.|A100003A5DED0E|.|2007|.|221.220.135.72|.|2015-10-12 10:27:24	",
"	214753|.|normalLogin|.|1.4.1|.|MI NOTE LTE|.|+8613155853151|.|00000000-531b-bc85-ffff-ffffc4a839dc|.|89860115875010103784|.|865982027454647|.|2026|.|118.212.205.24|.|2015-10-12 10:27:28	",
"	214671|.|quickRegister|.|1.4.1|.|R8207|.||.|00000000-33fe-8c59-38d9-1a5d2cc31d88|.|89860013045474587539|.|867275026563189|.|2012|.|117.136.4.179|.|2015-10-12 10:27:28	",
"	219754|.|quickRegister|.|1.4.1|.|HM NOTE 1S|.||.|ffffffff-91d5-c3ef-ffff-ffff8d3bb277|.|898602c31613fc263210|.|867514028603399|.|2026|.|117.136.36.187|.|2015-10-12 10:27:35	",
"	221910|.|normalLogin|.|1.4.2|.|GT-I9152P|.||.|00000000-28d7-98fa-f445-5e2d2af3162d|.|89860056221448269748|.|359901051557946|.|2026|.|171.221.126.34|.|2015-10-12 10:27:44	",
"	219799|.|quickRegister|.|1.4.2|.|SM-A5000|.||.|ffffffff-b29c-d903-ffff-ffff9a23cf6c|.|89860008221589|.|357095065650292|.|2026|.|182.132.80.161|.|2015-10-12 10:27:47	",
"	193065|.|quickRegister|.|1.4.2|.|G621-TL00|.|000000|.|00000000-288b-7c11-ffff-fffff960e5c2|.|89860114995311111343|.|000000000000000|.|2026|.|112.97.38.161|.|2015-10-12 10:27:54	",
"	213206|.|normalLogin|.|1.4|.|M812C|.||.|00000000-5daa-e79d-a82e-ccb762cce3ff|.|898600|.|865488025586950|.|2007|.|117.136.80.134|.|2015-10-12 10:27:59	",
"	218790|.|normalLogin|.|1.4|.|HM NOTE 1W|.||.|00000000-5fd7-5963-ffff-ffff889d2f08|.|898600151314f8041517|.|865317025083793|.|2009|.|117.136.75.71|.|2015-10-12 10:28:00	",
"	204143|.|normalLogin|.|1.4.2|.|SM-A7000|.||.|ffffffff-f8cb-784f-4308-065523bb913f|.|89860039261593869465|.|357092065875110|.|2026|.|223.104.11.123|.|2015-10-12 10:28:02	",
"	220294|.|quickRegister|.|1.4.2|.|J326T|.||.|ffffffff-c2ea-1540-ffff-ffff8b57491e|.|89860082191495340371|.|864558021213477|.|2026|.|221.13.42.28|.|2015-10-12 10:28:03	",
"	181483|.|quickRegister|.|1.3|.|HM NOTE 1LTETD|.||.|00000000-2bdc-d529-ffff-ffffa1158396|.|89860064243408194428|.|865198026271144|.|2010|.|117.136.84.190|.|2015-10-12 10:28:09	",
"	217739|.|normalLogin|.|1.4.1|.|Coolpad 8670|.||.|00000000-6775-c0cd-0259-1c111c889c4b|.|898600c2031470236432|.|864837025953506|.|2026|.|111.224.177.130|.|2015-10-12 10:28:41	",
"	221936|.|quickRegister|.|1.4|.|vivo Y17T|.||.|ffffffff-b3e3-5cf6-3885-f2fb00000000|.||.|864395024786898|.|2003|.|220.173.212.132|.|2015-10-12 10:28:46	",
"	220551|.|quickRegister|.|1.4.2|.|vivo Y33|.||.|ffffffff-8047-01b1-ffff-fffff653caad|.|89860043191482992705|.|868264020626746|.|2026|.|218.16.115.175|.|2015-10-12 10:28:51	",
"	214097|.|quickRegister|.|1.4.1|.|MI 3|.||.|00000000-6409-fdb2-ffff-ffff8ad0ebde|.|898600e82213003d9035|.|866001028143569|.|2026|.|175.155.149.231|.|2015-10-12 10:28:52	",
"	202969|.|normalLogin|.|1.4.2|.|m1 note|.|+8618600285595|.|00000000-5c6f-d731-dc7a-f6cd31e416b9|.|89860114811042658009|.|866184026174925|.|2026|.|114.242.248.102|.|2015-10-12 10:29:00	"];
        
        //$rd = rand(11111, 99999999);
        //Yii::$app->redis->lpush("keyy",$rd);
        foreach ($r as $v){
            Yii::$app->redis->lpush("Keylogin",$v);
            echo $v."<br>";
        }
        return "push success";
    }
    public function actionIpt()
    {
        $ip=Yii::$app->getRequest()->getQueryParam('ip',Yii::$app->getRequest()->userIP);
        $res = $this->getClient('http://api.map.baidu.com/location/ip?ak=FE70eb7ce52aa9fa527c45e8d3a370be&ip='.$ip.'&coor=bd09ll');
//         {"address":"CN|\u6d59\u6c5f|\u676d\u5dde|None|CHINANET|0|0",
//         "content":{
//             "address":"\u6d59\u6c5f\u7701\u676d\u5dde\u5e02",
//             "address_detail":{
//                 "city":"\u676d\u5dde\u5e02",
//                 "city_code":179,
//                 "district":"",
//                 "province":"\u6d59\u6c5f\u7701",
//                 "street":"",
//                 "street_number":""},
//             "point":{"x":"120.21937542","y":"30.25924446"}
//          },
//         "status":0}
        return json_encode($res);
    }
    
    public function actionPop()
    {
        $x=[];
        for ($i=1;$i<=10;$i++){
            $rd = Yii::$app->redis->brpop("keyy",1);
            if (count($rd)>0 ){
                array_push($x, $rd);
            }else {
                echo "POP OVER";
            }
        }
        print_r($x);
        return "pop redis  success";
    }
    
    public function actionLoginpop()
    {
        $x=[];
        for ($i=1;$i<=20;$i++){
            $rd = Yii::$app->redis->brpop("Keylogin",1);
            if (count($rd)>0 ){
                array_push($x, $rd);
            }else {
                echo "POP OVER";
            }
        }
        if (count($x)>0){
            $vlas=[];
            foreach ($x as $rdv){
                //每一条记录
                $arrParams= explode('|.|', $rdv[1]);
                $gid=$arrParams[0];
                $keyword=$arrParams[1];
                $osver=$arrParams[2];
                $appver=$arrParams[3];
                $lineNo=$arrParams[4];
                $uuid=$arrParams[5];
                $simSerial=$arrParams[6];
                $dev_id=$arrParams[7];
                $channel=$arrParams[8];
                $ip=$arrParams[9];
                if (isset($arrParams[10]))
                    $ctime=$arrParams[10];
                $data = Yii::$app->cache[$ip];
                //过滤ip登录过多情况
                if (($channel=="2014"||$channel=="2044"||$channel=="2038") &&$ip!="115.238.55.114"){
                    $keywordIP='countip'.$ip;
                    $dataIpCount= Yii::$app->cache[$keywordIP];
                    if ($dataIpCount === false||count($dataIpCount)==0) {
                        Yii::$app->cache->set($keywordIP, 1,300);//缓存5分钟
                    }else {
                        $dataIpCount+=1;
                        Yii::$app->cache->set($keywordIP, $dataIpCount+1,300);
                        if ($dataIpCount>5)
                        {//黑名单IP列表
                            Yii::warning("黑名单快速登录超过5个id的ip ".$ip,"llpay");
                            $dataBlackList=Yii::$app->cache["blackQuickRegisterList"];
                            if($dataBlackList === false||count($dataBlackList)==0){
                                $blacklist=[];
                                array_push($blacklist, $ip);
                                Yii::$app->cache->set('blackQuickRegisterList', $blacklist,600);
                            }else {
                                if (is_array($dataBlackList)){
                                    array_push($dataBlackList, $ip);
                                    Yii::$app->cache->set('blackQuickRegisterList', $dataBlackList,600); 
                                }else {
                                    $blacklist=[];
                                    array_push($blacklist, $ip);
                                    Yii::$app->cache->set('blackQuickRegisterList', $blacklist,600);
                                } 
                            }
                        }
                    }
                }
                $city='N/A';
                $city_id='1';
                $isp="未知";
                //2016年04月26日加入 特定渠道推送adid等的接口
                if ($channel==2069||$channel==2071||$channel==2072)
                {
                    Yii::warning("PUSH INFO TO JINHUA  start ","llpay");
                    $this->pushToJh($gid, $dev_id, $simSerial,$channel);
                }
                //
                if ($data === false||count($data)==0) { 
                    $iptest = $this->getClient('http://ip.taobao.com/service/getIpInfo.php?ip='.$ip);
                    //         Yii::error("ip request :".print_r($iptest,true));
                    if (is_object($iptest)){
                        if ($iptest->code===0 && $iptest->data->region!="" &&$iptest->data->city!=""){
                            $city=$iptest->data->region.$iptest->data->city ;
                            $city_id=$iptest->data->city_id ;
                            $isp=$iptest->data->isp;
                        }
                    }
                    Yii::$app->cache->set($ip, $iptest,386400);
                }else {
                    $iptest = $data;
                    if (is_object($iptest)){
                        if ($iptest->code===0 && $iptest->data->region!="" &&$iptest->data->city!=""){
                            $city=$iptest->data->region.$iptest->data->city ;
                            $city_id=$iptest->data->city_id ;
                            $isp=$iptest->data->isp;
                        }
                    }
                }
                
                $xeach=[$gid,$keyword,$osver,$appver,$lineNo,$uuid,$simSerial,$dev_id,$channel,$ip,$ctime,$city,$city_id,$isp];
                array_push($vlas, $xeach);
            }
            $connection=Yii::$app->db;
            $res = $connection->createCommand()->batchInsert(
                'log_userrequst', 
                ['gid', 'keyword','osver','appver','lineNo','uuid','simSerial','dev_id','channel','request_ip','ctime','city','city_id','isp'],
                $vlas)->execute();
            return  "save results :".$res;
        }else{
            return "POP OVER ";
        }
//         $rd = Yii::$app->redis->brpop("Keylogin",1);
//         if (!isset($rd)||$rd==""||count($rd)==0 ){
//             return "pop over";
//         }else {
// //             return print_r($rd,true);
//                $arrParams= explode('|.|', $rd[1]);
//                $gid=$arrParams[0];
//                $keyword=$arrParams[1];
//                $osver=$arrParams[2];
//                $appver=$arrParams[3];
//                $lineNo=$arrParams[4];
//                $uuid=$arrParams[5];
//                $simSerial=$arrParams[6];
//                $dev_id=$arrParams[7];
//                $channel=$arrParams[8];
//                $ip=$arrParams[9];
//             $log = new LogUserrequst();
//             $log->gid=$gid;
//             $log->keyword = $keyword;
//             $log->osver = $osver;
//             $log->appver = $appver;
//             $log->lineNo = $lineNo;
//             $log->uuid = $uuid;
//             $log->simSerial = $simSerial;
//             $log->dev_id = $dev_id;
//             $log->channel = $channel;
//             $log->request_ip = $ip;
//             if (isset($arrParams[10]))
//                 $log->ctime=$arrParams[10];
//             $iptest = $this->getClient('http://ip.taobao.com/service/getIpInfo.php?ip='.$ip);
//             //         Yii::error("ip request :".print_r($iptest,true));
//             if (is_object($iptest)){
//                 if ($iptest->code===0 && $iptest->data->region!="" &&$iptest->data->city!=""){
//                     $log->city=$iptest->data->region.$iptest->data->city ;
//                     $log->city_id=$iptest->data->city_id ;
//                     $log->isp=$iptest->data->isp;
//                 }
//             }
//             if ($log->save()){
//                 return "save success, id:".$log->id;
//             }else {
//                 $logpath = Yii::$app->params['selflogs']['error'];
//                 $str = date('[Y-m-d H:i:s][error] ')."  ".print_r($log->getErrors(),true)."\r\n";
//                 $f=fopen($logpath,"a+");
//                 fwrite( $f,$str);
//                 fclose( $f);
//             }
//         }
    }
    function pushToJh($gid,$dev_id,$simSerial,$channel)
    {
        $adid='OCVBNoUMrpQ=';
        $key='q9w2eb4n2yg6it7yr5';
        if ($channel==2071)
        {
            $adid='rcXHNRkYg80=';
            $key='q9w2eb4n2yg6it7yr5';
        }
        if ($channel==2072)
        {
            $adid='1C8JoT9SE/E=';
            $key='q9w2eb4n2yg6it7yr5';
        }
        
        $url='http://101.71.43.46/WebService/mer/AdAppDownloadBack.aspx';
        $merid=$gid;
        $mername=$channel.'_'.$gid;
        $devid=$dev_id;
        $simid=$simSerial;
        $logintype=2;
        
        $keycode=md5($merid.$mername.$devid.$adid.$logintype.$key);
        
        $url.='?merid='.$merid."&mername=".$mername."&devid=".$dev_id."&simid=".$simid."&adid=".$adid."&logintype=".$logintype."&keycode=".$keycode;
        Yii::warning("PUSH INFO TO JINHUA url:".$url,"llpay");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);//
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);// 使用自动跳转
        curl_setopt($ch, CURLOPT_TIMEOUT, 5); // 设置超时限制防止死循环
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回 
        $output = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Errno'.curl_error($ch);//捕抓异常
            return;
        }
        curl_close($ch);
        // 		var_dump($output);
        // 		print_r($output);
        echo $output;
        return $output;
    }
    
    function getClient($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);//
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);// 使用自动跳转
        curl_setopt($ch, CURLOPT_TIMEOUT, 5); // 设置超时限制防止死循环
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
    
    /**
     * 
     * <xml>
   <appid>wx0d2f5bd9dd619438</appid>
   <attach>支付测试</attach>
   <body>APP支付测试</body>
   <mch_id>1280663501</mch_id>
   <nonce_str>1add1a30ac87aa2db72f57a2375d8fec</nonce_str>
   <notify_url>http://wxpay.weixin.qq.com/pub_v2/pay/notify.v2.php</notify_url>
   <openid>oUpF8uMuAJO_M2pxb1Q9zNjWeS6o</openid>
   <out_trade_no>1415659990</out_trade_no>
   <spbill_create_ip>14.23.150.211</spbill_create_ip>
   <total_fee>1</total_fee>
   <trade_type>JSAPI</trade_type>
   <sign>0CB01533B8C1EF103065174F50BCA001</sign>
</xml>
     */
    public function actionWxapi()
    {
        $input = new WxPayUnifiedOrder();
        $input->SetBody("virtual coin");
        $input->SetAttach("test coin");
        $input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));
        $input->SetTotal_fee("1");
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag("coin");
        $input->SetNotify_url("http://wxpay.koudaishiji.com/example/notify.php");
        $input->SetTrade_type("APP");
        $order = WxPayApi::unifiedOrder($input);
        return  json_encode($order);
           $ss='appid=wx0d2f5bd9dd619438&body=6钻石&mch_id=1280663501&nonce_str=f106b7f99d2cb30c3db1c3cc0fde9ccb&notify_url=http://zjh.koudaishiji.com/wxnotify/FA95CF014459985643698/145895&out_trade_no=FA95CF014459985643698&spbill_create_ip=127.0.0.1&total_fee=6&trade_type=APP&attach=zuanshi_android_6++FA95CF014459985643698++145895&product_id=zuanshi_android_6'; 
//            <xml><appid>wx0d2f5bd9dd619438</appid><body>6钻石</body><mch_id>1280663501</mch_id><nonce_str>f106b7f99d2cb30c3db1c3cc0fde9ccb</nonce_str><notify_url>http://zjh.koudaishiji.com/wxnotify/FA95CF014459985643698/145895</notify_url><out_trade_no>FA95CF014459985643698</out_trade_no><spbill_create_ip>127.0.0.1</spbill_create_ip><total_fee>6</total_fee><trade_type>APP</trade_type><attach>zuanshi_android_6++FA95CF014459985643698++145895</attach><product_id>zuanshi_android_6</product_id><sign>7215F942A80031277C5BB6C1B22448CF</sign></xml>
            //&key=65f8ef63bd1bd773145dd0e227565aeb
           $sk=['appid'=>'wx0d2f5bd9dd619438',
                'body'=>'6钻石',
                'mch_id'=>'1280663501',
                'nonce_str'=>'f106b7f99d2cb30c3db1c3cc0fde9ccb',
                'notify_url'=>'http://zjh.koudaishiji.com/wxnotify/FA95CF014459985643698/145895','out_trade_no'=>'FA95CF014459985643698','spbill_create_ip'=>'127.0.0.1','total_fee'=>'6','trade_type'=>'APP','attach'=>'zuanshi_android_6++FA95CF014459985643698++145895','product_id'=>'zuanshi_android_6' ];
           ksort($sk);
           $strl = [];
           foreach ($sk as $k=>$v)
           {
               array_push($strl,$k."=".$v);
               echo  "key :".$k." v :".$v." <br>";
           }
           echo "all key : ".implode($strl, '&')." <br>";
           echo "add key : ".implode($strl, '&')."&key=65f8ef63bd1bd773145dd0e227565aeb <br>";
           echo "sign : ".strtoupper(md5(implode($strl, '&')."&key=65f8ef63bd1bd773145dd0e227565aeb"))."<br>";
           
           $xmlstr = '<xml>';
//            $Ra = Yii::$app->getRequest()->getQueryParam('ra');
//            $Rb = Yii::$app->getRequest()->getQueryParam('rb');
//            $Rs = Yii::$app->getRequest()->getQueryParam('rs');
//            $rs = $this->eloRating($Ra, $Rb, $Rs);
//            return "TOTAL GET SCORE:".$rs;
    }
    
    function eloRating($Ra,$Rb,$Rs)
    {
        $Ea = 1/(1+pow(10, ($Rb-$Ra)/400));
        $Eb = 1/(1+pow(10, ($Ra-$Rb)/400));
        $RSa = "";
        $RSb = "";
        $K=32;
        switch ($Rs){
            case 1:
                echo "Ra win <br>";
                $RSa = intval($K * (1 - $Ea));
                echo "Ra rewards: ".$RSa."<br>";
                $RSb = intval($K * (0 - $Eb));
                echo "Rb rewards: ".$RSb."<br>";
                break;
            case -1:
                echo "Ra lose <br>";
                $RSa = intval($K * (0 - $Ea));
                echo "Ra rewards: ".$RSa."<br>";
                $RSb = intval($K * (1 - $Eb));
                echo "Ra rewards: ".$RSb."<br>";
                break;
            case 0:
                echo "Ra dogfall with Rb <br>";
                $RSa = intval($K * (0.5 - $Ea));
                echo "Ra rewards: ".$RSa."<br>";
                $RSb = intval($K * (0.5 - $Eb));
                echo "Ra rewards: ".$RSb."<br>";
                break;
            default:
                return "give a result";            
        }
        return $RSa;
    }
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }
    public function actionJsonp()
    {
        return json_encode(['code'=>0,'msg'=>'hello world!']);
    }
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
