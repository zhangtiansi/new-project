<?php

namespace app\modules\zjhadmin\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\FirstorderSearch;
use app\modules\zjhadmin\controllers\AdmController;

/**
 * GmaccountinfoController implements the CRUD actions for GmAccountInfo model.
 */
class FirstorderController extends AdmController
{
 

    /**
     * Lists all GmAccountInfo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FirstorderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
