<?php

namespace app\modules\zjhadmin\controllers;

use Yii;
use app\models\TopbackSearch;

/**
 * GmaccountinfoController implements the CRUD actions for toprecharge model.
 */
class TopbackController extends AdmController
{
    public function actionIndex()
    {
        $searchModel = new TopbackSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
