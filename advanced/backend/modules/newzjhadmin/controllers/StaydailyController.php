<?php

namespace app\modules\newzjhadmin\controllers;

use Yii;
use app\models\Dailystay;
use app\models\DailystaySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\DataDailyRechargeSearch;


class StaydailyController extends AdmController
{
    public function actionIndex(){
        $request = Yii::$app->request;
        $stayDailySearchModel = new DailystaySearch();
        $rechargeSearchModel = new DataDailyRechargeSearch();
        $channel_name_list = $rechargeSearchModel->channel_name();
        $parameter = $request->get();
        $list = $stayDailySearchModel->new_search($parameter);
        return $this->render('index',['channel_name_list'=>$channel_name_list,'list'=>$list['0'],'pagination'=>$list['1'],'count'=>$list['2'],'cid'=>isset($parameter['cid']) ? $parameter['cid'] : '','source'=>isset($parameter['source']) ? $parameter['source'] : '','pay_time'=>isset($parameter['pay_time']) ? $parameter['pay_time'] : '']);
    }
}