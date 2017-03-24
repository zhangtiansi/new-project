<?php

namespace app\modules\agent\controllers;

use Yii;
use app\models\LogUserrequst;
use app\models\LogUserrequstSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LoguserController implements the CRUD actions for LogUserrequst model.
 */
class LoguserController extends AdmController
{
   
    /**
     * Lists all LogUserrequst models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LogUserrequstSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

}
