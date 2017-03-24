<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;
use yii\filters\VerbFilter;
use app\models\UploadForm;
use yii\web\UploadedFile;
use app\models\GmChannelInfo;
use yii\web\NotFoundHttpException;
use app\components\smsbao;
use app\components\sms;
use app\components\checkdb;
use app\components\wechatSend;
use app\models\GmOrderlist;
use app\components\HttpClient;
use yii\web\Response;
use app\models\LotterySsq;
use app\models\LotteryDlt;
/**
 * Site controller
 */
class SiteController extends Controller
{
    
    /**
     * @inheritdoc
     */
    public $enableCsrfValidation = false;
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error','lottery','countprivate','countgame','countking','checksms','checkwin','email','checkfade','coinchange','upload','testapi','warntowx','coinlargechange','coinbug','actinfo'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
//                     [
//                       'actions'=>['upload'],
//                         'allow'=>true,  
//                         'ips'=>['183.131.0.200'],
//                     ],
                    [
                    'actions'=>['smswarning','warntowx','yesterdaywx'],
                        'allow'=>true,
                        'ips'=>['121.41.80.10','183.131.0.200','127.0.0.1'],
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
        ];
    }
    
    public function actionTestapi()
    {
        $wx = new wechatSend();
        $x=$wx->getUserlist(5);
        return $x;
    }
    public function actionChecksms()
    {
        checkdb::checkYouyi();
        return "ok";
    }
    public function actionLottery()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $res = $this->getClient('http://f.apiplus.cn/ssq-1.json');
        $data = $res->data;
//         $ar = [];
//         foreach ($data as $sig){
//             array_push($ar, [$sig->expect,$sig->opencode,$sig->opentime]);
//         }
//         $db=Yii::$app->db;
//         $sql = $db->createCommand()->batchInsert('lottery_ssq', ['expect','opencode','opentime'], $ar)->execute();
        $c=LotterySsq::find()->where(['expect'=>$data[0]->expect])->count();
        if ($c==0)
        {
            echo "c==0";
            $lot = new LotterySsq();
            $lot->expect=$data[0]->expect;
            $lot->opencode=$data[0]->opencode;
            $lot->opentime=$data[0]->opentime;
            $lot->save();
        }
        $res2 = $this->getClient('http://f.apiplus.cn/dlt-1.json');
        $data2 = $res2->data;
        //         $ar = [];
        //         foreach ($data as $sig){
        //             array_push($ar, [$sig->expect,$sig->opencode,$sig->opentime]);
        //         }
        //         $db=Yii::$app->db;
        //         $sql = $db->createCommand()->batchInsert('lottery_ssq', ['expect','opencode','opentime'], $ar)->execute();
        $c2=LotteryDlt::find()->where(['expect'=>$data2[0]->expect])->count();
        if ($c2==0)
        {
            $lot2 = new LotteryDlt();
            $lot2->expect=$data2[0]->expect;
            $lot2->opencode=$data2[0]->opencode;
            $lot2->opentime=$data2[0]->opentime;
            $lot2->save();
        }
        $db=Yii::$app->db;
        $recent1 = $db->createCommand('select * from lottery_ssq order by expect desc limit 1;')->queryOne();
        $recent2 = $db->createCommand('select * from lottery_dlt order by expect desc limit 1;')->queryOne();
        $ax = ['双色球'=>$recent1,'大乐透'=>$recent2];
        
        $ssqall = $db->createCommand('select * from lottery_ssq order by expect desc limit 20')->queryAll();
        $dltall = $db->createCommand('select * from lottery_dlt order by expect desc limit 20')->queryAll();
        $allssqRed = [];
        $allssqBlue = [];
        $alldltRed = [];
        $alldltBlue = [];
        foreach ($ssqall as $v){
//             var_dump($v);
            $opencode = explode('+',$v['opencode']);
            $red = explode(',', $opencode[0]);
            foreach ($red as $redv)
            {
                array_push($allssqRed, $redv);
            } 
            array_push($allssqBlue, $opencode[1]);
        }
        echo "---双色球红球---";
        echo count($allssqRed);
        echo json_encode($allssqRed);
        echo "----<br>---";
        echo "---双色球蓝球---";
        echo count($allssqBlue);
        echo json_encode($allssqBlue);
        echo "----<br>---";
        foreach ($dltall as $v){
//             var_dump($v);
            $opencode = explode('+',$v['opencode']);
            $red = explode(',', $opencode[0]);
            $blue = explode(',', $opencode[1]);
            foreach ($red as $redv)
            {
                array_push($alldltRed, $redv);
            }
            foreach ($blue as $bluev)
            {
                array_push($alldltBlue, $bluev);
            }
        }
        echo "---大乐透红球---";
        echo count($alldltRed);
        echo json_encode($alldltRed);
        echo "----<br>---";
        echo "---大乐透蓝球---";
        echo count($alldltBlue);
        echo json_encode($alldltBlue);
//         var_dump($alldltBlue);
        echo "----<br>---";
        return $ax;
    }
    function ssqBlue($ar)
    {
        $arblueAll=[];
        for ($i=1;$i<16;$i++)
        {
            $c=0;
            foreach ($ar as $v){
                if (intval($v) == $i)
                {
                    $c++;
                }
            }
            array_push($arblueAll, [$i=>$c]);            
        }
        return asort($arblueAll);
    }
    //getLast5HisKing
    //5分钟执行一次
    public function actionCountking()
    {
        $WEIGHT_VIP=1;
        $WEIGHT_GAMENO=3;
        $WEIGHT_REGIST=5;
        $db=Yii::$app->db;
    
        $ssqall = $db->createCommand('call getLast5HisKing()')->queryAll();
        $afterCalc=[];
        foreach ($ssqall as $v){
            //             gameno,t1.uid,t1.change_coin,t2.power,(t2.money+t2.point_box) as money,
            //             (t3.win+t3.lose)as game_count,t3.win,t3.lose,UNIX_TIMESTAMP(t4.reg_time) as regtime
            if (!isset($afterCalc[$v['gameno']])){
                //                 echo "is not set ".$v['gameno']."<br>";
                $afterCalc[$v['gameno']]=[];
            }
            //             else {
            // //                 echo "is array ".$v['gameno']."count ".count($v['gameno'])."<br>";
            //             }
            $afterCalc[$v['gameno']]['ctime']=$v['ctime'];
            if ($v['change_coin']>0){
                $afterCalc[$v['gameno']]['win_uid']=$v['uid'];
                $afterCalc[$v['gameno']]['win_coin']=$v['change_coin'];
            }
            else
            {
                isset($afterCalc[$v['gameno']]['loser_uid'])?$afterCalc[$v['gameno']]['loser_uid'].=','.$v['uid']:$afterCalc[$v['gameno']]['loser_uid']=$v['uid'];
                isset($afterCalc[$v['gameno']]['loser_vip'])?$afterCalc[$v['gameno']]['loser_vip'].=','.$v['power']:$afterCalc[$v['gameno']]['loser_vip']=$v['power'];
                isset($afterCalc[$v['gameno']]['losePlayer'])?$afterCalc[$v['gameno']]['losePlayer']+=1:$afterCalc[$v['gameno']]['losePlayer']=1;
                if ($v['power']==0)//累加权值VIP
                {
                    isset($afterCalc[$v['gameno']]['loserWeight'])?$afterCalc[$v['gameno']]['loserWeight']+=$WEIGHT_VIP:$afterCalc[$v['gameno']]['loserWeight']=$WEIGHT_VIP;
                }
                if ($v['game_count']<10)
                {
                    isset($afterCalc[$v['gameno']]['loserWeight'])?$afterCalc[$v['gameno']]['loserWeight']+=$WEIGHT_GAMENO:$afterCalc[$v['gameno']]['loserWeight']=$WEIGHT_GAMENO;
                }
                if (time()-$v['regtime']<1200)//20分钟之内注册
                {
                    isset($afterCalc[$v['gameno']]['loserWeight'])?$afterCalc[$v['gameno']]['loserWeight']+=$WEIGHT_REGIST:$afterCalc[$v['gameno']]['loserWeight']=$WEIGHT_REGIST;
                }
                if (!isset($afterCalc[$v['gameno']]['loserWeight']))
                    $afterCalc[$v['gameno']]['loserWeight']=0;
            }
        }
        $vlas=[];
        foreach ($afterCalc as $gno=>$ginfo){
            $siggm=[$gno,$ginfo['win_uid'],$ginfo['win_coin'],
                isset($ginfo['losePlayer'])?$ginfo['losePlayer']:0,
                isset($ginfo['loser_uid'])?$ginfo['loser_uid']:"",
                isset($ginfo['loser_vip'])?$ginfo['loser_vip']:"",
                isset($ginfo['loserWeight'])?$ginfo['loserWeight']:0,
                $ginfo['ctime']];
            array_push($vlas, $siggm);
        }
        $connection=Yii::$app->db;
        $res = $connection->createCommand()->batchInsert(
            'log_game_kingweight',
            ['gameno', 'win_uid','win_coin','loser_no','loser_uid','loser_vip','loser_weight','ctime'],
            $vlas)->execute();
        //         print_r($afterCalc);
        return "sql exute result:".$res;
    }
    
    
    public function actionCountgame()
    {
        $WEIGHT_VIP=1;
        $WEIGHT_GAMENO=3;
        $WEIGHT_REGIST=5;
        $db=Yii::$app->db; 
        
        $ssqall = $db->createCommand('call getLast20His()')->queryAll(); 
        $afterCalc=[];
        foreach ($ssqall as $v){
//             gameno,t1.uid,t1.change_coin,t2.power,(t2.money+t2.point_box) as money,
//             (t3.win+t3.lose)as game_count,t3.win,t3.lose,UNIX_TIMESTAMP(t4.reg_time) as regtime
            if (!isset($afterCalc[$v['gameno']])){
//                 echo "is not set ".$v['gameno']."<br>";
                $afterCalc[$v['gameno']]=[];
            }
//             else {
// //                 echo "is array ".$v['gameno']."count ".count($v['gameno'])."<br>";
//             }
            $afterCalc[$v['gameno']]['ctime']=$v['ctime'];
            if ($v['change_coin']>0){
                $afterCalc[$v['gameno']]['win_uid']=$v['uid'];
                $afterCalc[$v['gameno']]['win_coin']=$v['change_coin'];
            }
            else 
            {
                isset($afterCalc[$v['gameno']]['loser_uid'])?$afterCalc[$v['gameno']]['loser_uid'].=','.$v['uid']:$afterCalc[$v['gameno']]['loser_uid']=$v['uid'];
                isset($afterCalc[$v['gameno']]['loser_vip'])?$afterCalc[$v['gameno']]['loser_vip'].=','.$v['power']:$afterCalc[$v['gameno']]['loser_vip']=$v['power'];
                isset($afterCalc[$v['gameno']]['losePlayer'])?$afterCalc[$v['gameno']]['losePlayer']+=1:$afterCalc[$v['gameno']]['losePlayer']=1;
                if ($v['power']==0)//累加权值VIP
                {
                    isset($afterCalc[$v['gameno']]['loserWeight'])?$afterCalc[$v['gameno']]['loserWeight']+=$WEIGHT_VIP:$afterCalc[$v['gameno']]['loserWeight']=$WEIGHT_VIP;
                }
                if ($v['game_count']<10)
                {
                    isset($afterCalc[$v['gameno']]['loserWeight'])?$afterCalc[$v['gameno']]['loserWeight']+=$WEIGHT_GAMENO:$afterCalc[$v['gameno']]['loserWeight']=$WEIGHT_GAMENO;
                }
                if (time()-$v['regtime']<1200)//20分钟之内注册
                {
                    isset($afterCalc[$v['gameno']]['loserWeight'])?$afterCalc[$v['gameno']]['loserWeight']+=$WEIGHT_REGIST:$afterCalc[$v['gameno']]['loserWeight']=$WEIGHT_REGIST;
                }
                if (!isset($afterCalc[$v['gameno']]['loserWeight']))
                    $afterCalc[$v['gameno']]['loserWeight']=0;
            }
        }
        $vlas=[];
        foreach ($afterCalc as $gno=>$ginfo){
            $siggm=[$gno,$ginfo['win_uid'],$ginfo['win_coin'],
                isset($ginfo['losePlayer'])?$ginfo['losePlayer']:0,
                isset($ginfo['loser_uid'])?$ginfo['loser_uid']:"",
                isset($ginfo['loser_vip'])?$ginfo['loser_vip']:"",
                isset($ginfo['loserWeight'])?$ginfo['loserWeight']:0,
                $ginfo['ctime']];
            array_push($vlas, $siggm);
        }
        $connection=Yii::$app->db;
        $res = $connection->createCommand()->batchInsert(
            'log_game_weight',
            ['gameno', 'win_uid','win_coin','loser_no','loser_uid','loser_vip','loser_weight','ctime'],
            $vlas)->execute();
//         print_r($afterCalc);
        return "sql exute result:".$res;
    }
    
    public function actionCountprivate()
    {
        $WEIGHT_VIP=1;
        $WEIGHT_GAMENO=3;
        $WEIGHT_REGIST=5;
        $db=Yii::$app->db;
    
        $ssqall = $db->createCommand('call getLast20HisPrivate()')->queryAll();
        $afterCalc=[];
        foreach ($ssqall as $v){
            //             gameno,t1.uid,t1.change_coin,t2.power,(t2.money+t2.point_box) as money,
            //             (t3.win+t3.lose)as game_count,t3.win,t3.lose,UNIX_TIMESTAMP(t4.reg_time) as regtime
            if (!isset($afterCalc[$v['gameno']])){
                //                 echo "is not set ".$v['gameno']."<br>";
                $afterCalc[$v['gameno']]=[];
            }
            //             else {
            // //                 echo "is array ".$v['gameno']."count ".count($v['gameno'])."<br>";
            //             }
            $afterCalc[$v['gameno']]['ctime']=$v['ctime'];
            if ($v['change_coin']>0){
                $afterCalc[$v['gameno']]['win_uid']=$v['uid'];
                $afterCalc[$v['gameno']]['win_coin']=$v['change_coin'];
            }
            else
            {
                isset($afterCalc[$v['gameno']]['loser_uid'])?$afterCalc[$v['gameno']]['loser_uid'].=','.$v['uid']:$afterCalc[$v['gameno']]['loser_uid']=$v['uid'];
                isset($afterCalc[$v['gameno']]['loser_vip'])?$afterCalc[$v['gameno']]['loser_vip'].=','.$v['power']:$afterCalc[$v['gameno']]['loser_vip']=$v['power'];
                isset($afterCalc[$v['gameno']]['losePlayer'])?$afterCalc[$v['gameno']]['losePlayer']+=1:$afterCalc[$v['gameno']]['losePlayer']=1;
                if ($v['power']==0)//累加权值VIP
                {
                    isset($afterCalc[$v['gameno']]['loserWeight'])?$afterCalc[$v['gameno']]['loserWeight']+=$WEIGHT_VIP:$afterCalc[$v['gameno']]['loserWeight']=$WEIGHT_VIP;
                }
                if ($v['game_count']<10)
                {
                    isset($afterCalc[$v['gameno']]['loserWeight'])?$afterCalc[$v['gameno']]['loserWeight']+=$WEIGHT_GAMENO:$afterCalc[$v['gameno']]['loserWeight']=$WEIGHT_GAMENO;
                }
                if (time()-$v['regtime']<1200)//20分钟之内注册
                {
                    isset($afterCalc[$v['gameno']]['loserWeight'])?$afterCalc[$v['gameno']]['loserWeight']+=$WEIGHT_REGIST:$afterCalc[$v['gameno']]['loserWeight']=$WEIGHT_REGIST;
                }
                if (!isset($afterCalc[$v['gameno']]['loserWeight']))
                    $afterCalc[$v['gameno']]['loserWeight']=0;
            }
        }
        $vlas=[];
        foreach ($afterCalc as $gno=>$ginfo){
            $siggm=[$gno,
                isset($ginfo['win_uid'])?$ginfo['win_uid']:0,
                isset($ginfo['win_coin'])?$ginfo['win_coin']:0,
                isset($ginfo['losePlayer'])?$ginfo['losePlayer']:0,
                isset($ginfo['loser_uid'])?$ginfo['loser_uid']:"",
                isset($ginfo['loser_vip'])?$ginfo['loser_vip']:"",
                isset($ginfo['loserWeight'])?$ginfo['loserWeight']:0,
                $ginfo['ctime']];
            array_push($vlas, $siggm);
        }
        $connection=Yii::$app->db;
        $res = $connection->createCommand()->batchInsert(
            'log_gameprivate_weight',
            ['gameno', 'win_uid','win_coin','loser_no','loser_uid','loser_vip','loser_weight','ctime'],
            $vlas)->execute();
//                 print_r($vlas);
        return "xsql exute result:".$res;
    }
    
    public function actionWarntowx()
    {
        $msg = Yii::$app->getRequest()->getQueryParam('msg','Warning Test.'.date('Y-m-d H:i:s'));
        $wx = new wechatSend();
        $x=$wx->warningTowx($msg);
        return json_encode($x);
    }
    public function actionYesterdaywx()
    {
        $msg = GmOrderlist::getYesterdayDataWX(1);
        $wx = new wechatSend();
        $userlist = $wx->getUserlist(5);
        $x=$wx->sendTowx($userlist,$msg);
        return json_encode($x);
    }
    
    public function actionActinfo()
    {
        $c=Yii::$app->getRequest()->getQueryParam('c');
        if ($c=="pwd")
        {
            if (checkdb::getActData())
                return "ok";
            return "failed";
        }
    }
    public function actionIndex()
    {
        return $this->render('index');
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
    
    public function actionEmail()
    {
        
        return "";
    }
    public function actionCheckfade()
    {
        if (checkdb::CheckFade())
            return "ok";
        return "failed";
    }
    public function actionCoinchange()
    {
        if (checkdb::checkLargeCoinChange())
            return "ok";
        return "failed";
    }
    public function actionCoinlargechange()
    {
        if (checkdb::checkLargeGameChange())
            return "ok";
        return "failed";
    }
    public function actionCoinbug()
    {
        if (checkdb::checkLargeChange())
            return "ok";
        return "failed";
    }
    public function actionCheckwin()
    {
        if (checkdb::checkTomuchWin())
            return "ok";
        return "failed";
    }
    
    public function actionUpload()
    {
        $model = new UploadForm();
        $passwd = Yii::$app->getRequest()->getQueryParam('pwd');
        if ($passwd!="zjh123")
            throw new NotFoundHttpException();
        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file');
    
            if ($model->validate()) {
                $filename=Yii::$app->params['apk_path']. $model->file->baseName . '.' . $model->file->extension;
                if ($model->file->saveAs($filename))
                {
                    $cid = yii::$app->getRequest()->getQueryParam('cid');
                    $vercode = yii::$app->getRequest()->getQueryParam('vercode');
                    $ver = yii::$app->getRequest()->getQueryParam('ver');
                    $mdc = GmChannelInfo::findOne($cid);
                    if (is_object($mdc)){
                        $mdc->update_url = 'http://dl.koudaishiji.com/apks/'.$model->file->baseName . '.' . $model->file->extension;
                        $mdc->force=0;
                        $mdc->version_code=$vercode;
                        $mdc->cur_version=$ver;
                        Yii::error('update url : '.$mdc->update_url);
                        if ($mdc->save())
                            return 'success saved :'.$model->file->baseName;
                        }else {
                            return 'save pkg faild of '.print_r($mdc->getErrors(),true);
                        }
                    }else {
                        return 'cid not found';
                    }
                }else {
                    return 'failed save';
                }
             
            }else {
                return 'model failed';
            }
    
        return $this->render('upload', ['model' => $model]);
    }
    
    public function actionSmswarning()
    {
        $pwd = Yii::$app->getRequest()->getQueryParam('pwd');
        $smstext = Yii::$app->getRequest()->getQueryParam('smsText');
        $subj = Yii::$app->getRequest()->getQueryParam('sub');
        $phone = Yii::$app->getRequest()->getQueryParam('phone');
        Yii::error("pwd : ".$pwd." smstext :".$smstext." phone : ".$phone );
        if ($pwd=="112211" && $smstext!="" && $phone!="")
        {
            $wx = new wechatSend();
            $res=$wx->SendWxMsg($phone, $subj.$smstext);
//             $sm = new smsbao();
//             $res = $sm->sentSms($phone, $subj.$smstext);
//             if (strlen($smstext)>100){
//                 $smstext = substr($smstext, 0,100);
//             }
//             $sm = new sms();
//             $res=$sm->sendTemplateSms($phone,$subj, "N","N",$smstext);
            return json_encode($res);
        }else
            throw new NotFoundHttpException();
    
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
}
