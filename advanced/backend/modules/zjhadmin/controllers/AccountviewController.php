<?php

namespace app\modules\zjhadmin\controllers;

use Yii;
use app\models\GmAccountInfo;
use app\models\GmAccountInfoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\AccountViewSearch;
use yii\data\ActiveDataProvider;

/**
 * GmaccountinfoController implements the CRUD actions for GmAccountInfo model.
 */
class AccountviewController extends AdmController
{
 

    /**
     * Lists all GmAccountInfo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AccountViewSearch(); 
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams); 
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
