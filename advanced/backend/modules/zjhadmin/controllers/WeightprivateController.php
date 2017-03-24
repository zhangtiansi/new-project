<?php

namespace app\modules\zjhadmin\controllers;

use Yii;
use app\models\ToprechargeSearch;
use app\models\PrivateweightlistSearch;

/**
 * GmaccountinfoController implements the CRUD actions for toprecharge model.
 */
class WeightprivateController extends AdmController
{
    public function actionIndex()
    {
        $searchModel = new PrivateweightlistSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
