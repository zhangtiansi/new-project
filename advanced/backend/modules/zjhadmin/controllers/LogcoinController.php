<?php

namespace app\modules\zjhadmin\controllers;

use Yii;
use app\models\LogCoinRecords;
use app\models\LogCoinRecordsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\SqlDataProvider;
use yii\web\Response;

/**
 * LogcoinController implements the CRUD actions for LogCoinRecords model.
 */
class LogcoinController extends AdmController
{
 

    /**
     * Lists all LogCoinRecords models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LogCoinRecordsSearch();
        if (Yii::$app->getRequest()->getQueryParam('gid',"")!="")
        {
            $dataProvider = $searchModel->search(['LogCoinRecordsSearch'=>['uid'=>Yii::$app->getRequest()->getQueryParam('gid')]]);
        }elseif (Yii::$app->getRequest()->getQueryParam('gameno',"")!="" || Yii::$app->getRequest()->getQueryParam('propid',"")!=""){
            $dataProvider = $searchModel->search(['LogCoinRecordsSearch'=>[
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
    public function actionTbs()
    {
        
        return $this->render('indextbs');
    }
    
    public function actionCoin()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $uid= Yii::$app->getRequest()->getQueryParam('uid');
        $indate= Yii::$app->getRequest()->getQueryParam('indate');
        if ($indate==""|| $indate=="undefined"||$indate==0){
            $indate=date('ymd');
        }
        $sql='CALL findUserCoin(:uid, :indate);';
        $db=Yii::$app->db_readonly;
    
        $res=$db->createCommand($sql)
                 ->bindValues([':uid'=>$uid,':indate'=>$indate])
                ->queryAll();
        $ar = ['aaData'=>$res];
        return $ar;
    }
    /**
     * Displays a single LogCoinRecords model.
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
     * Creates a new LogCoinRecords model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new LogCoinRecords();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing LogCoinRecords model.
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
     * Deletes an existing LogCoinRecords model.
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
     * Finds the LogCoinRecords model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LogCoinRecords the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LogCoinRecords::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
