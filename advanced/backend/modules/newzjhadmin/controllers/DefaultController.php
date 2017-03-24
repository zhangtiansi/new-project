<?php
namespace app\modules\newzjhadmin\controllers;

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

/**
 * Default controller
 */
class DefaultController extends AdmController
{
    public function actionIndex(){

    }

    public function actionRecent(){

        $modelreyes = DataDailyRecharge::findOne(['udate'=>date('Y-m-d',time()-3600*24),'channel'=>'999','source'=>'所有支付']);
        $modelreyes2 = DataDailyRecharge::findOne(['udate'=>date('Y-m-d',time()-3600*24*2),'channel'=>'999','source'=>'所有支付']);
        $modeluseryes = DataDailyUser::findOne(['udate'=>date('Y-m-d',time()-3600*24),'channel'=>999]);
        $modeluseryes2 = DataDailyUser::findOne(['udate'=>date('Y-m-d',time()-3600*24*2),'channel'=>999]);
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

    public function actionMonth(){
        $res = DataDailyRecharge::newGetRechargeData();
        $agentres = DataDailyRecharge::getAgentRecharge();
        $reslast = DataDailyRecharge::newGetLastMonthRechargeData();
        return $this->render('month.php',[
            'data'=>$res,'agentres'=>$agentres,'reslast'=>$reslast
        ]);

    }
}
?>