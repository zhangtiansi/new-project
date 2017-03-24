<?php

namespace app\modules\zjhadmin\controllers;

use Yii;
use app\models\ToprechargeSearch;
use app\models\Gameweightlist;
use app\models\GameweightlistSearch;

/**
 * GmaccountinfoController implements the CRUD actions for toprecharge model.
 */
class WeightgameController extends AdmController
{
    public function actionIndex()
    {
        $searchModel = new GameweightlistSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
