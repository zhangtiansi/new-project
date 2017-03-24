<?php

namespace app\modules\agent\controllers;

use Yii;
use app\models\GmPlayerInfo;
use app\models\GmPlayerInfoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PlayerController implements the CRUD actions for GmPlayerInfo model.
 */
class PlayerController extends AdmController
{
  
    /**
     * Lists all GmPlayerInfo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GmPlayerInfoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single GmPlayerInfo model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    protected function findModel($id)
    {
        if (($model = GmPlayerInfo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
