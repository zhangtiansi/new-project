<?php

namespace app\modules\channel\controllers;

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

    /**
     * Lists all DataDailyUser models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DataDailyUserSearch();
        $dataProvider = $searchModel->searchChannel(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

  
}
