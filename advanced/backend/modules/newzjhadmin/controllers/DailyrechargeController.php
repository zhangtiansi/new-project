<?php

namespace app\modules\newzjhadmin\controllers;

use Yii;
use app\models\DataDailyRecharge;
use app\models\DataDailyRechargeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\User;


class DailyrechargeController extends AdmController
{
    public function actionIndex(){
        $request = Yii::$app->request;
        $rechargeSearchModel = new DataDailyRechargeSearch();
        $channel_name_list = $rechargeSearchModel->channel_name();
        $parameter = $request->get();
        $list = $rechargeSearchModel->new_search($parameter);
        return $this->render('index',['channel_name_list'=>$channel_name_list,'list'=>$list['1'],'pagination'=>$list['0'],'cid'=>isset($parameter['cid']) ? $parameter['cid'] : '','source'=>isset($parameter['source']) ? $parameter['source'] : '','pay_time'=>isset($parameter['pay_time']) ? $parameter['pay_time'] : '']);
    }
}