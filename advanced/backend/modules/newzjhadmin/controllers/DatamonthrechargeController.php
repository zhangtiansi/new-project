<?php

namespace app\modules\newzjhadmin\controllers;

use Yii;
use app\models\DataMonthRecharge;
use app\models\DataMonthRechargeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\User;
use yii\filters\AccessControl;
use app\models\DataDailyRechargeSearch;


class DatamonthrechargeController extends AdmController
{
    public function actionIndex(){
        $request = Yii::$app->request;
        $rechargeSearchModel = new DataDailyRechargeSearch();
        $DataMonthRechargeModel = new DataMonthRechargeSearch();
        $channel_name_list = $rechargeSearchModel->channel_name();
        $parameter = $request->get();
        $list = $DataMonthRechargeModel->new_search($parameter);
        return $this->render('index',['channel_name_list'=>$channel_name_list,'list'=>$list['0'],'pagination'=>$list['1'],'count'=>$list['2'],'cid'=>isset($parameter['cid']) ? $parameter['cid'] : '','source'=>isset($parameter['source']) ? $parameter['source'] : '','pay_time'=>isset($parameter['pay_time']) ? $parameter['pay_time'] : '']);
    }
}