<?php

namespace app\modules\newzjhadmin\controllers;

use app\models\DataDailyRechargeSearch;
use Yii;
use app\models\DataDailyUser;
use app\models\DataDailyUserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * DailyuserController implements the CRUD actions for DataDailyUser model.
 */
class DailyuserController extends AdmController
{
    public function actionIndex(){
        $request = Yii::$app->request;
        $searchModel = new DataDailyUserSearch();
        $rechargeSearchModel = new DataDailyRechargeSearch();
        $channel_name_list = $rechargeSearchModel->channel_name();
        $parameter = $request->get();
        $result = $searchModel->newSearch($parameter);

        return $this->render('index',[
        'list' => $result['0'],
            'pagination'=> $result['1'],
            'channel_name_list'=>$channel_name_list,
            'cid' => isset($parameter['cid']) ? $parameter['cid'] : '',
            'pay_time' => isset($parameter['pay_time']) ? $parameter['pay_time'] : '',
            'count'=>$result['2']
        ]);
    }
}