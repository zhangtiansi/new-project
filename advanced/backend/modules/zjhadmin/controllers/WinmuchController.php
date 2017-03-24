<?php

namespace app\modules\zjhadmin\controllers;

use Yii; 
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter; 
use app\models\WinmuchSearch;

/**
 * GmaccountinfoController implements the CRUD actions for GmAccountInfo model.
 */
class WinmuchController extends AdmController
{
 

    /**
     * Lists all GmAccountInfo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WinmuchSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
