<?php

namespace app\modules\agent\controllers;

use Yii;
use app\models\LogCoinHistory;
use app\models\LogCoinHistorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LogcoinhisController implements the CRUD actions for LogCoinHistory model.
 */
class LogcoinhisController extends AdmController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all LogCoinHistory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LogCoinHistorySearch();
        if (Yii::$app->getRequest()->getQueryParam('gid',"")!="")
        {
            $dataProvider = $searchModel->search(['LogCoinHistorySearch'=>['uid'=>Yii::$app->getRequest()->getQueryParam('gid')]]);
        }elseif (Yii::$app->getRequest()->getQueryParam('gameno',"")!="" || Yii::$app->getRequest()->getQueryParam('propid',"")!=""){
            $dataProvider = $searchModel->search(['LogCoinHistorySearch'=>[
                'game_no'=>Yii::$app->getRequest()->getQueryParam('gameno'),
                    'prop_id'=>Yii::$app->getRequest()->getQueryParam('propid'),
                    ]
                    ]);
        }else{
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Displays a single LogCoinHistory model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new LogCoinHistory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new LogCoinHistory();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing LogCoinHistory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing LogCoinHistory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the LogCoinHistory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LogCoinHistory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LogCoinHistory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
