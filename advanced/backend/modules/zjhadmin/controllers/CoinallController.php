<?php

namespace app\modules\zjhadmin\controllers;

use Yii;
use app\models\Coinall;
use app\models\CoinallSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GmaccountinfoController implements the CRUD actions for GmAccountInfo model.
 */
class CoinallController extends AdmController
{
 

    /**
     * Lists all GmAccountInfo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CoinallSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
