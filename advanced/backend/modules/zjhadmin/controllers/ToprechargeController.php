<?php

namespace app\modules\zjhadmin\controllers;

use Yii;
use app\models\ToprechargeSearch;

/**
 * GmaccountinfoController implements the CRUD actions for toprecharge model.
 */
class ToprechargeController extends AdmController
{
    public function actionIndex()
    {
        $searchModel = new ToprechargeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
