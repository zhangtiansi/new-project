<?php

namespace app\modules\zjhadmin\controllers;

use Yii;
use app\models\LogGift;
use app\models\LogGiftSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LoggiftController implements the CRUD actions for LogGift model.
 */
class LoggiftController extends AdmController
{
 

    /**
     * Lists all LogGift models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LogGiftSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single LogGift model.
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
     * Creates a new LogGift model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new LogGift();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionTopgift()
    {
         return $this->render('topgift'); 
    }
    
    public function actionGettopgift()
    {
        $bg= Yii::$app->getRequest()->getQueryParam('bg');
        $end= Yii::$app->getRequest()->getQueryParam('end');
        $fromid= Yii::$app->getRequest()->getQueryParam('fromid');
        $toid= Yii::$app->getRequest()->getQueryParam('toid');
        $giftid= Yii::$app->getRequest()->getQueryParam('giftid');
        if ($bg==""|| $bg=="undefined" ||$bg==0){
            $bg=date('Y-m-d H:i:s',strtotime("-1 day"));
        }
        if ($end==""|| $end=="undefined"||$end==0){
            $end=date('Y-m-d H:i:s');
        }
        if ($fromid==""|| $fromid=="undefined"){
            $fromid=0;
        }
        if ($toid==""|| $toid==0){
            $toid=0;
        }
        if ($giftid==""|| $giftid=="undefined"){
            $giftid=0;
        } 
        $sql='call getGiftinfos("'.$bg.'","'.$end.'","'.$fromid.'","'.$toid.'","'.$giftid.'" )';
        $db=Yii::$app->db_readonly;

        $res=$db->createCommand($sql)
        //          ->bindValues($params)
        ->queryAll();
        $ar = ['aaData'=>$res];
        return json_encode($ar);
        
    }
    /**
     * Updates an existing LogGift model.
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
     * Deletes an existing LogGift model.
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
     * Finds the LogGift model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LogGift the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LogGift::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
