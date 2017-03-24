<?php

namespace app\modules\zjhadmin\controllers;

use Yii;
use app\models\GmAccountInfo;
use app\models\GmAccountInfoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\SmsrechargeSearch;

/**
 * GmaccountinfoController implements the CRUD actions for GmAccountInfo model.
 */
class SmsrechargeController extends AdmController
{
 

    /**
     * Lists all GmAccountInfo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SmsrechargeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
