<?php

namespace app\modules\zjhadmin\controllers;
use yii;
use app\models\CfgServerlist;
use app\models\CfgBetconfig;
use app\models\LogBetResults;
use app\models\CfgBetchance;
use app\models\UploadForm;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\GmOrderlist;
use app\models\GmAccountInfo;
use yii\data\Pagination;
use app\models\DataDailyRecharge;
use app\models\DataDailyUser;
use app\models\CfgGameParam;
use yii\web\NotFoundHttpException;
use app\components\smsbao;
use app\models\LogBlacklist;
use app\components\ApiErrorCode;
use app\models\CfgSslNew;
use app\models\SysOplogs;
use app\models\CfgSslNewDui;
use app\components\checkdb;
use app\models\LogKillUser;

class DefaultController extends AdmController
{
    
    
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionSysconf()
    {
        return $this->render('sysconf');
    }
    public function actionSslconf()
    {
        $getType=Yii::$app->getRequest()->getQueryParam('type');
        $db=Yii::$app->db_readonly;
         if ($getType =="ssl4"){
             $sql="select id,begin_id,end_id from cfg_ssl_new";
         }elseif ($getType=="sslcard"){
             $sql="SELECT * FROM cfg_ssl_new_dui ORDER BY id";
         }
        $res=$db->createCommand($sql)
        //          ->bindValues($params)
        ->queryAll();
        $s = ApiErrorCode::$OK;
        $s['data']=$res;
        if (Yii::$app->user->id == 53 || Yii::$app->user->id == 55 ){
            $s['hasaccess']=1;
        }
        return json_encode($s);
    }
    
    public function actionModssl4()
    {
        if (Yii::$app->user->id != 53 && Yii::$app->user->id != 55 ){
            return json_encode(ApiErrorCode::$AccessDenied);
        }
        if (Yii::$app->getRequest()->isPost){
            $type = Yii::$app->getRequest()->getQueryParam('type');
            if ($type=="card"){
                $id = Yii::$app->getRequest()->getQueryParam('modid');
                $js = Yii::$app->getRequest()->getBodyParam('jstr');
                Yii::error("card id:".$id." jstr : ".$js);
                $ar = json_decode($js);
                Yii::error("card decode : ".print_r($ar,true));
                $cardp = CfgSslNewDui::findOne($id);
                if (is_object($cardp)){
                    $cardp->staus=1;
                    $cardp->cfg_jin=$ar[0]->sslc1;
                    $cardp->cfg_shun=$ar[0]->sslc2;
                    $cardp->cfg_dui=$ar[0]->sslc3;
                    $cardp->cfg_san=$ar[0]->sslc4;
                    if ($cardp->save()){
                        if (CfgGameParam::ReloadParam()){
                            $syslog = new SysOplogs();
                            $syslog->opid=Yii::$app->user->id;
                            $syslog->keyword=SysOplogs::$KEYWORD_SSL_CARD;
                            $syslog->logs="修改了时时乐 ID:".$id." 配比 金花 ".$cardp->cfg_jin." 顺子".$cardp->cfg_shun." 对子".$cardp->cfg_dui." 散牌 ".$cardp->cfg_san;
                            $syslog->cid = 0;
                            $syslog->gid = 0;
                            $syslog->desc = SysOplogs::$KEYWORD_SSL_CARD;
                            $syslog->ctime = date('Y-m-d H:i:d');
                            if(!$syslog->save())
                            {
                                Yii::error(print_r($syslog->getErrors(),true));
                            }
                            return json_encode(ApiErrorCode::$OK);
                        }
//                         return json_encode(ApiErrorCode::$OK);
                    }else {
                        return json_encode(ApiErrorCode::$SAVEERR);
                    }
                }
            }elseif ($type=="cardclose"){
                $id = Yii::$app->getRequest()->getQueryParam('modid');
                $cardp = CfgSslNewDui::findOne($id);
                if (is_object($cardp)){
                    $cardp->staus=0;
                    if ($cardp->save()){
                        if (CfgGameParam::ReloadParam()){
                            $syslog = new SysOplogs();
                            $syslog->opid=Yii::$app->user->id;
                            $syslog->keyword=SysOplogs::$KEYWORD_SSL_CARD;
                            $syslog->logs="关闭了时时乐 ID:".$id." 配比";
                            $syslog->cid = 0;
                            $syslog->gid = 0;
                            $syslog->desc = SysOplogs::$KEYWORD_SSL_CARD;
                            $syslog->ctime = date('Y-m-d H:i:d');
                            if(!$syslog->save())
                            {
                                Yii::error(print_r($syslog->getErrors(),true));
                            }
                            return json_encode(ApiErrorCode::$OK);
                        }
                    }
                }
                
            }else {
                $js = Yii::$app->getRequest()->getBodyParam('jstr');
                Yii::error("jstr : ".$js);
                $ar = json_decode($js);
                Yii::error("decode : ".print_r($ar,true));
                /**
                 * Array
    (
        [0] => stdClass Object
            (
                [sslp1] => 4
                [sslp2] => 4
                [sslp3] => 4
                [sslp4] => 4
                [sslp5] => 5
                [sslp6] => 5
                [sslp7] => 5
                [sslp8] => 5
            )
    
    )
                 */
                $res = $ar[0];
                $sslp1 = $res->sslp1;
                //配置第一路：
                $sl1 = CfgSslNew::findOne(1);
                $sl2 = CfgSslNew::findOne(2);
                $sl3 = CfgSslNew::findOne(3);
                $sl4 = CfgSslNew::findOne(4);
                $sl1->begin_id = $res->sslp1;
                $sl1->end_id = $res->sslp2;
                $sl2->begin_id = $res->sslp3;
                $sl2->end_id = $res->sslp4;
                $sl3->begin_id = $res->sslp5;
                $sl3->end_id = $res->sslp6;
                $sl4->begin_id = $res->sslp7;
                $sl4->end_id = $res->sslp8;
                if ($sl1->save()&& $sl2->save() && $sl3->save() && $sl4->save())
                {
                    if (CfgGameParam::ReloadParam()){
                        $syslog = new SysOplogs();
                        $syslog->opid=Yii::$app->user->id;
                        $syslog->keyword=SysOplogs::$KEYWORD_SSL_OPS;
                        $syslog->logs="修改了时时乐4路牌配置 ".$res->sslp1."-".$res->sslp2.";".$res->sslp3."-".$res->sslp4.";".$res->sslp5."-".$res->sslp6.";".$res->sslp7."-".$res->sslp8.";";
                        $syslog->cid = 0;
                        $syslog->gid = 0;
                        $syslog->desc = SysOplogs::$KEYWORD_SSL_OPS;
                        $syslog->ctime = date('Y-m-d H:i:d');
                        if(!$syslog->save())
                        {
                            Yii::error(print_r($syslog->getErrors(),true));
                        }
                        return json_encode(ApiErrorCode::$OK);
                    }
                    else
                        return json_encode(ApiErrorCode::$ReloadSysParamERR);
                }else {
                    Yii::error("save sslp4 error ".print_r($sl1->getErrors(),true).print_r($sl2->getErrors(),true).print_r($sl3->getErrors(),true).print_r($sl4->getErrors(),true));
                    return json_encode(ApiErrorCode::$SAVEERR);
                }
            }
        }
//         $s = ApiErrorCode::$OK;
//         return json_encode($s);
    }
    public function actionDatacenter()
    {
        $datatype = Yii::$app->getRequest()->getQueryParam('datatype','1');
        $q = GmOrderlist::getdailyRecharge($datatype);
//         $acc = GmAccountInfo::getdailyRecharge();
        Yii::error(print_r($q,true));
        $countQuery = clone $q;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $models = $q->offset($pages->offset)
        ->limit($pages->limit)
        ->all();
        
        return $this->render('datacenter', [
            'models' => $models,
            'pages' => $pages,
            'datatype'=>$datatype,
        ]);
        
    }
    
    public function actionDatalogin()
    {
        
        Yii::$app->response->format=\yii\web\Response::FORMAT_XML;
    }
    public function actionGetsslper()
    {
        $bg= Yii::$app->getRequest()->getQueryParam('bg');
        $end= Yii::$app->getRequest()->getQueryParam('end');
        if ($bg==""|| $bg=="undefined" ||$bg==0){
            $bg=date('Y-m-d H:i:s',strtotime("-1 day"));
        }
        if ($end==""|| $end=="undefined"||$end==0){
            $end=date('Y-m-d H:i:s');
        }
        $sql='call getSslPercent("'.$bg.'","'.$end.'")';
        $db=Yii::$app->db_readonly;
        
        $res=$db->createCommand($sql)
        //          ->bindValues($params)
        ->queryAll();
        $ar = ['aaData'=>$res];
        return json_encode($ar);
    }
    public function actionGetsslwin()
    {
        $bg= Yii::$app->getRequest()->getQueryParam('bg');
        $end= Yii::$app->getRequest()->getQueryParam('end');
        if ($bg==""|| $bg=="undefined" ||$bg==0){
            $bg=date('Y-m-d H:i:s',strtotime("-1 day"));
        }
        if ($end==""|| $end=="undefined"||$end==0){
            $end=date('Y-m-d H:i:s');
        }
        $sql='call getSslWinner("'.$bg.'","'.$end.'")';
        $db=Yii::$app->db_readonly;
    
        $res=$db->createCommand($sql)
        //          ->bindValues($params)
        ->queryAll();
        $ar = ['aaData'=>$res];
        return json_encode($ar);
    }
    public function actionGetdata()
    {
        $bg= Yii::$app->getRequest()->getQueryParam('bg');
        $end= Yii::$app->getRequest()->getQueryParam('end');
        $uid= Yii::$app->getRequest()->getQueryParam('uid'); 
        $ctype= Yii::$app->getRequest()->getQueryParam('ctype');
        if ($bg==""|| $bg=="undefined" ||$bg==0){
            $bg=date('Y-m-d H:i:s',strtotime("-1 day"));
        }
        if ($end==""|| $end=="undefined"||$end==0){
            $end=date('Y-m-d H:i:s');
        }
        switch ($ctype)
        {
            case 1:
                $sql='call getPlayerRechargeTop("'.$bg.'","'.$end.'")';
                break ;
            case 2:
                $sql='call findUserRechargeDetail("'.$uid.'","'.$bg.'","'.$end.'")';
                break ; 
            case 3:
                $sql='call getPlayerRechargeClientTop("'.$bg.'","'.$end.'")';
                break ; 
            case 4:
                $sql='call getBairenZhuangWin("'.$bg.'","'.$end.'")';
                break ; 
            case 5:
                $sql='call getBairenZhuangLose("'.$bg.'","'.$end.'")';
                break ; 
            case 6:
                $sql='call getBairenBetwin("'.$bg.'","'.$end.'")';
                break ;
            case 7:
                $sql='call getBairenTotalwin("'.$bg.'","'.$end.'")';
                break ;
            case 8:
                $sql='call getPlayerBkCardtop("'.$bg.'","'.$end.'")';
                break ;
            case 9:
                $sql='call getChannelsRecharge("'.$bg.'","'.$end.'")';
                break ;
            default: 
                $sql="";
                break;          
        } 
//         if ($ctype==1)
//             $sql='call getPlayerRechargeTop("'.$bg.'","'.$end.'")';
        $db=Yii::$app->db_readonly;
        
        $res=$db->createCommand($sql)
        //          ->bindValues($params)
        ->queryAll();
        $ar = ['aaData'=>$res];
        return json_encode($ar);
    }
    public function actionFindout()
    { 
        return $this->render('tops');
    }
    
    public function actionBlacklist()
    {
        $type =  Yii::$app->getRequest()->getQueryParam('type');
        if ($type==1){//ban 设备ime号
            $ime = Yii::$app->getRequest()->getQueryParam('ime');
            $c = LogBlacklist::find()->where(['ime'=>$ime])->count();
            if ($c == 0){
                $xl = new LogBlacklist();
                $xl->ime = $ime;
                $xl->status = 0;
                if ($xl->save()){
                    return json_encode(ApiErrorCode::$OK);
                }else {
                    return json_encode(array_merge(ApiErrorCode::$SAVEERR,["log"=>print_r($xl->getErrors(),true)]));
                }
            }else {
                if(LogBlacklist::updateAll(['status'=>0],['ime'=>$ime]))
                {
                    return json_encode(ApiErrorCode::$OK);
                }else {
                    return json_encode(ApiErrorCode::$SAVEERR);
                }
            }
        }else if ($type==2){
            $gid = Yii::$app->getRequest()->getQueryParam('gid');
            $c = GmAccountInfo::find()->where(['gid'=>$gid])->count();
            if (GmAccountInfo::updateAll(['status'=>1],['gid'=>$gid])){
                $lk = new LogKillUser();
                $lk->aid=$gid;
                $lk->mark=0;
                $lk->save();
                return json_encode(ApiErrorCode::$OK);
            }else {
                return json_encode(ApiErrorCode::$SAVEERR);
            }
        }
    }
    public function actionUnblacklist()
    {//取消黑名单
        $type =  Yii::$app->getRequest()->getQueryParam('type');
        if ($type==1){//ban 设备ime号
            $ime = Yii::$app->getRequest()->getQueryParam('ime');
            $c = LogBlacklist::find()->where(['ime'=>$ime])->count();
            if ($c == 1){
                $xl = LogBlacklist::findOne(['ime'=>$ime]);
                $xl->status = 1;
                if ($xl->save()){
                    return json_encode(ApiErrorCode::$OK);
                }else {
                    return json_encode(array_merge(ApiErrorCode::$SAVEERR,["log"=>print_r($xl->getErrors(),true)]));
                }
            }else {
                if(LogBlacklist::updateAll(['status'=>1],['ime'=>$ime]))
                {
                    return json_encode(ApiErrorCode::$OK);
                }else {
                    return json_encode(ApiErrorCode::$SAVEERR);
                }
            }
        }else if ($type==2){
            $gid = Yii::$app->getRequest()->getQueryParam('gid');
            $c = GmAccountInfo::find()->where(['gid'=>$gid])->count();
            if (GmAccountInfo::updateAll(['status'=>0],['gid'=>$gid])){
                return json_encode(ApiErrorCode::$OK);
            }else {
                return json_encode(ApiErrorCode::$SAVEERR);
            }
        }
    }
    public function actionUsersystem()
    {
        return $this->render('usersystem');
    }
    public function actionCustomer()
    {
        return $this->render('customer');
    }
    public function actionSysparam()
    {
        return $this->render('sysparam');
    }
    public function actionBanip()
    {
        $ip = Yii::$app->getRequest()->getQueryParam('ip');
        return checkdb::BanIpgid($ip);
    }
    
    public function actionSmswarning()
    {
        $pwd = Yii::$app->getRequest()->getQueryParam('pwd');
        $smstext = Yii::$app->getRequest()->getQueryParam('smsText');
        $phone = Yii::$app->getRequest()->getQueryParam('phone');
        if ($pwd=="11211" && $smstext!="" && $phone!="")
        {
            $sm = new smsbao();
            $res = $sm->sentSms($phone, $smstext);
            return $res;
        }else 
            throw new NotFoundHttpException();
        
    }
    
    public function actionWxdata()
    {
        $this->layout = "none";
        return $this->render('qycheck');
    }
    
    public function actionRecent()
    {
        $modelreyes = DataDailyRecharge::findOne(['udate'=>date('Y-m-d',time()-3600*24),'channel'=>'999','source'=>'所有支付']);
        $modelreyes2 = DataDailyRecharge::findOne(['udate'=>date('Y-m-d',time()-3600*24*2),'channel'=>'999','source'=>'所有支付']);
        $modeluseryes = DataDailyUser::findOne(['udate'=>date('Y-m-d',time()-3600*24),'channel'=>999]);
        $modeluseryes2 = DataDailyUser::findOne(['udate'=>date('Y-m-d',time()-3600*24*2),'channel'=>999]);
        if (Yii::$app->getRequest()->getQueryParam('type')=="money")
        {
            $res = DataDailyRecharge::getRechargeData();
            $alltotalfee=0;
            $allAlipay=0;
            $allsms=0;
            $allunionpay=0;
            $allwxpay=0;
            $allyeepay=0;
            $allappstore=0;
            $allagent=0;
            foreach ($res as $v){
                foreach ($v as $k=>$vday)
                {
                    if ($k=='totalfee'){
                        $alltotalfee+=$vday;
                    }elseif ($k=='Alipay'){
                        $allAlipay+=$vday;
                    }elseif ($k=='sms'){
                        $allsms+=$vday;
                    }elseif ($k=='unionpay'){
                        $allunionpay+=$vday;
                    }elseif ($k=='wxpay'){
                        $allwxpay+=$vday;
                    }elseif ($k=='yeepay'){
                        $allyeepay+=$vday;
                    }elseif ($k=='appstore'){
                        $allappstore+=$vday;
                    }elseif ($k=='agent'){
                        $allagent+=$vday;
                    }
                } 
            }
            $tt_recharge ="前后台总数:".Yii::$app->formatter->asInteger($alltotalfee+$allagent)."RMB";
            $tt_recharge.="|客户端充值总数:".Yii::$app->formatter->asInteger($alltotalfee)."RMB";
            $tt_recharge.="|Agent充值总数:".Yii::$app->formatter->asInteger($allagent)."RMB";
            $tt_recharge.="|alipay:".$allAlipay."RMB";
            $tt_recharge.="|sms:".$allsms."RMB";
            $tt_recharge.="|union:".$allunionpay."RMB";
            $tt_recharge.="|wxpay:".$allwxpay."RMB";
            $tt_recharge.="|yeepay:".$allyeepay."RMB";
            $tt_recharge.="|appstore:".$allappstore."RMB";
            
            
            $agentres = DataDailyRecharge::getAgentRecharge();
            $reslast = DataDailyRecharge::getLastMonthRechargeData();
            $alltotalfee2=0;
            $allAlipay2=0;
            $allsms2=0;
            $allunionpay2=0;
            $allwxpay2=0;
            $allyeepay2=0;
            $allappstore2=0;
            $allagent2=0;
            foreach ($reslast as $v){
                foreach ($v as $k=>$vday)
                {
                    if ($k=='totalfee'){
                        $alltotalfee2+=$vday;
                    }elseif ($k=='Alipay'){
                        $allAlipay2+=$vday;
                    }elseif ($k=='sms'){
                        $allsms2+=$vday;
                    }elseif ($k=='unionpay'){
                        $allunionpay2+=$vday;
                    }elseif ($k=='wxpay'){
                        $allwxpay2+=$vday;
                    }elseif ($k=='yeepay'){
                        $allyeepay2+=$vday;
                    }elseif ($k=='appstore'){
                        $allappstore2+=$vday;
                    }elseif ($k=='agent'){
                        $allagent2+=$vday;
                    }
                } 
            }
            $tt_last ="前后台总数:".Yii::$app->formatter->asInteger($alltotalfee2+$allagent2)."RMB";
            $tt_last.="|客户端充值总数:".Yii::$app->formatter->asInteger($alltotalfee2)."RMB";
            $tt_last.="|Agent充值总数:".Yii::$app->formatter->asInteger($allagent2)."RMB";
            $tt_last.="|alipay:".$allAlipay2."RMB";
            $tt_last.="|sms:".$allsms2."RMB";
            $tt_last.="|unionpay:".$allunionpay2."RMB";
            $tt_last.="|wxpay:".$allwxpay2."RMB";
            $tt_last.="|yeepay:".$allyeepay2."RMB";
            $tt_last.="|appstore:".$allappstore2."RMB";
            
            
            return $this->render('recent_money',[
                'data'=>$res,'agent'=>$agentres,'data_2'=>$reslast,'tt_recharge'=>$tt_recharge,'tt_last'=>$tt_last
            ]);
        }
        $recentData = GmOrderlist::getRecentStable();
        $ssl = GmOrderlist::getSsl();
        return $this->render('recent',[
            'modelreyes'=>$modelreyes,
            'modelreyes2'=>$modelreyes2,
            'modeluseryes'=>$modeluseryes,
            'modeluseryes2'=>$modeluseryes2,
            'recentData'=>$recentData,
            'ssl'=>$ssl,
        ]);
    }
    public function actionError()
    {
        if (Yii::$app->getErrorHandler()->exception !== null) {
            return $this->render('error'
                , ['exception' => Yii::$app->getErrorHandler()->exception]
                );
        }   
//      return $this->render('error');
    }
    public function actionGetserverid()
    {
        $gs = new CfgServerlist();
        $s = $gs->getRecent();
        $s['code']=0;
        $s['msg']=$s['serverid'];
        return json_encode($s);
    }
    
    public function actionGetbet()
    {
        $gs = new CfgBetconfig();
        $s = $gs->getRecent();
        $s['code']=0;
        $btlog = new LogBetResults();
        $ar = $btlog->getRecent();
        $res=array_merge($s,$ar);
        $betcfg = new CfgBetchance();
        $ar = $betcfg->getbetChance();
        $res = array_merge($res,$ar);
//         $s['msg']=$s['serverid'];
        return json_encode($res);
    }
    public function actionGetrecentdata()
    {
        $ar = ['code'=>0];
        $type = Yii::$app->getRequest()->getQueryParam('dddd');
        $ar['online']=CfgGameParam::getOnline();
        if ($type==""){
            $ar['results']=GmOrderlist::getRecentStable();
        }else if ($type=='c'){
            return 111;
            $ar['results']=GmOrderlist::getRecentCdata();
        }else if ($type=='recharge'){
            $res = DataDailyRecharge::getRechargeData();
            $agentres = DataDailyRecharge::getAgentRecharge();
            $aresult = [];
            $aresult['total']=[];
            $aresult['alipay']=[];
            $aresult['sms']=[];
            $aresult['unionpay']=[];
            $aresult['yeepay']=[];
            $aresult['appstore']=[];
            $aresult['agent']=[];
            $aresult['total']['label']=['总金额'];
            $aresult['total']['data']=[];
            $aresult['alipay']['label']=['支付宝'];
            $aresult['alipay']['data']=[];
            $aresult['sms']['label']=['短信'];
            $aresult['sms']['data']=[];
            $aresult['unionpay']['label']=['银联'];
            $aresult['unionpay']['data']=[];
            $aresult['wxpay']['label']=['微信'];
            $aresult['wxpay']['data']=[];
            $aresult['yeepay']['label']=['易宝'];
            $aresult['yeepay']['data']=[];
            $aresult['appstore']['label']=['appstore'];
            $aresult['appstore']['data']=[];
            $aresult['agent']['label']=['Agent'];
            $aresult['agent']['data']=[];
            foreach ($res as $line){
                array_push($aresult['total']['data'],[$line['udate'],$line['totalfee']]);
                array_push($aresult['alipay']['data'],[$line['udate'],$line['Alipay']]);
                array_push($aresult['sms']['data'],[$line['udate'],$line['sms']]);
                array_push($aresult['unionpay']['data'],[$line['udate'],$line['unionpay']]);
                array_push($aresult['yeepay']['data'],[$line['udate'],$line['yeepay']]);
                array_push($aresult['wxpay']['data'],[$line['udate'],$line['wxpay']]);
                array_push($aresult['appstore']['data'],[$line['udate'],$line['appstore']]);
                array_push($aresult['agent']['data'],[$line['udate'],$line['agent']]);
            }
            $ar['results']=$aresult;
        }else if ($type=='lastrecharge'){
            $res = DataDailyRecharge::getLastMonthRechargeData();
            $aresult = [];
            $aresult['total']=[];
            $aresult['alipay']=[];
            $aresult['sms']=[];
            $aresult['llpay']=[];
            $aresult['yeepay']=[];
            $aresult['appstore']=[];
            $aresult['agent']=[];
            $aresult['total']['label']=['总金额'];
            $aresult['total']['data']=[];
            $aresult['alipay']['label']=['支付宝'];
            $aresult['alipay']['data']=[];
            $aresult['sms']['label']=['短信'];
            $aresult['sms']['data']=[];
            $aresult['llpay']['label']=['连连'];
            $aresult['llpay']['data']=[];
            $aresult['yeepay']['label']=['易宝'];
            $aresult['yeepay']['data']=[];
            $aresult['appstore']['label']=['appstore'];
            $aresult['appstore']['data']=[];
            $aresult['agent']['label']=['Agent'];
            $aresult['agent']['data']=[];
            foreach ($res as $line){
                array_push($aresult['total']['data'],[$line['udate'],$line['totalfee']]);
                array_push($aresult['alipay']['data'],[$line['udate'],$line['Alipay']]);
                array_push($aresult['sms']['data'],[$line['udate'],$line['sms']]);
                array_push($aresult['llpay']['data'],[$line['udate'],$line['llpay']]);
                array_push($aresult['yeepay']['data'],[$line['udate'],$line['yeepay']]);
                array_push($aresult['yeepay']['data'],[$line['udate'],$line['appstore']]);
                array_push($aresult['agent']['data'],[$line['udate'],$line['agent']]);
            }
            $ar['results']=$aresult;
        }
        return json_encode($ar);
    }
    
    public function actions()
    {
        return [
//             'error' => [
//                 'class' => 'yii\web\ErrorAction',
//             ],
        ];
    }
    
    public function actionUploadapk()
    {
        $file = $_FILES;
        
        return "...";
    }
}
