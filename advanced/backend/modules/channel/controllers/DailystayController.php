<?php

namespace app\modules\channel\controllers;

use Yii;
use app\models\Dailystay;
use app\models\DailystaySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * DailystayController implements the CRUD actions for DataDailyStay model.
 */
class DailystayController extends AdmController
{
    

    /**
     * Lists all DataDailyStay models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DailystaySearch();
        $dataProvider = $searchModel->searchChannel(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

//     /**
//      * Displays a single DataDailyStay model.
//      * @param integer $id
//      * @return mixed
//      */
//     public function actionView($id)
//     {
//         return $this->render('view', [
//             'model' => $this->findModel($id),
//         ]);
//     }

//     /**
//      * Creates a new DataDailyStay model.
//      * If creation is successful, the browser will be redirected to the 'view' page.
//      * @return mixed
//      */
//     public function actionCreate()
//     {
//         $model = new DataDailyStay();

//         if ($model->load(Yii::$app->request->post()) && $model->save()) {
//             return $this->redirect(['view', 'id' => $model->id]);
//         } else {
//             return $this->render('create', [
//                 'model' => $model,
//             ]);
//         }
//     }

//     /**
//      * Updates an existing DataDailyStay model.
//      * If update is successful, the browser will be redirected to the 'view' page.
//      * @param integer $id
//      * @return mixed
//      */
//     public function actionUpdate($id)
//     {
//         $model = $this->findModel($id);

//         if ($model->load(Yii::$app->request->post()) && $model->save()) {
//             return $this->redirect(['view', 'id' => $model->id]);
//         } else {
//             return $this->render('update', [
//                 'model' => $model,
//             ]);
//         }
//     }

//     /**
//      * Deletes an existing DataDailyStay model.
//      * If deletion is successful, the browser will be redirected to the 'index' page.
//      * @param integer $id
//      * @return mixed
//      */
//     public function actionDelete($id)
//     {
//         $this->findModel($id)->delete();

//         return $this->redirect(['index']);
//     }

//     /**
//      * Finds the DataDailyStay model based on its primary key value.
//      * If the model is not found, a 404 HTTP exception will be thrown.
//      * @param integer $id
//      * @return DataDailyStay the loaded model
//      * @throws NotFoundHttpException if the model cannot be found
//      */
//     protected function findModel($id)
//     {
//         if (($model = DataDailyStay::findOne($id)) !== null) {
//             return $model;
//         } else {
//             throw new NotFoundHttpException('The requested page does not exist.');
//         }
//     }
}
