<?php

namespace app\modules\agent\controllers;

use Yii;
use app\models\LogMail;
use app\models\LogMailSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\ApiErrorCode;

/**
 * LogmailController implements the CRUD actions for LogMail model.
 */
class LogmailController extends AdmController
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
     * Lists all LogMail models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LogMailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single LogMail model.
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
     * Creates a new LogMail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionSend()
    {
        if (Yii::$app->getRequest()->isPost){
            $model = new LogMail();
            $model->status=0;
            $model->ctime=date('Y-m-d H:i:s');
            $model->gid=Yii::$app->getRequest()->getBodyParam('gid');
            $model->from_id=Yii::$app->getRequest()->getBodyParam('sender');
            $model->title=Yii::$app->getRequest()->getBodyParam('title');
            $model->content=Yii::$app->getRequest()->getBodyParam('content');
            if ($model->save())
                return json_encode(ApiErrorCode::$OK);
            else 
                return json_encode(['code'=>111,'msg'=>'保存失败'.print_r($model->getErrors(),true)]);
        }
    }

    
    public function actionCreate()
    {
//         $model = new LogMail();
//         $model->status=0;
//         $model->ctime=date('Y-m-d H:i:s');
//         if ($model->load(Yii::$app->request->post()) && $model->save()) {
//             return $this->redirect(['view', 'id' => $model->id]);
//         } else {
            return $this->render('mail', [
//                 'model' => $model,
            ]);
//         }
    }

    /**
     * Updates an existing LogMail model.
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
     * Deletes an existing LogMail model.
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
     * Finds the LogMail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LogMail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LogMail::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
