<?php

namespace app\modules\agent\controllers;

use Yii;
use app\models\LogCustomer;
use app\models\LogCustomerSearch;
use yii\web\NotFoundHttpException;
/**
 * CustomerController implements the CRUD actions for LogCustomer model.
 */
class CustomerController extends AdmController
{
 

    /**
     * Lists all LogCustomer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LogCustomerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single LogCustomer model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model= $this->findModel($id);
        if ($model->ops != Yii::$app->user->id)
            throw new NotFoundHttpException('页面不存在.');
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new LogCustomer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout="main_admin";
        $model = new LogCustomer();
        $model->scenario="recharge";
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }else {
            if (Yii::$app->getRequest()->getQueryParam('uid')!=""){
                $model->gid = Yii::$app->getRequest()->getQueryParam('uid');
                return $this->render('create', [
                    'model' => $model,
                ]);
            }else{
                return ;
            }
        }
    }

    public function actionRecharge()
    {
        $this->layout="main_admin";
        $model = new LogCustomer();
        $model->scenario="recharge"; 
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }else { 
            if (count($model->getErrors())>0)
                Yii::error(print_r($model->getErrors(),true));
            return $this->render('recharge', [
                'model' => $model,
            ]);  
        }
    }
    public function actionRec()
    { 
        if (Yii::$app->getRequest()->isPost)
        {
            $gid=Yii::$app->getRequest()->getBodyParam('gid',0);
            $coin=Yii::$app->getRequest()->getBodyParam('coin',0);
            $laba=Yii::$app->getRequest()->getBodyParam('laba',0);
            $vg=Yii::$app->getRequest()->getBodyParam('vg',0);
            $vs=Yii::$app->getRequest()->getBodyParam('vs',0);
            $vc=Yii::$app->getRequest()->getBodyParam('vc',0);
            
            $model = new LogCustomer();
            $model->scenario="recharge";
            $model->gid=$gid;
            $model->coin=$coin;
            $model->point=0;
            $model->propid=7;
            $model->propnum=$laba;
            $model->card_g=$vg;
            $model->card_s=$vs;
            $model->card_c=$vc;
            $model->desc="快速操作。";
            if($model->save()){
                return json_encode(['code'=>0,'msg'=>'赠送成功' ]);
            }else {
                $msgx='';
                foreach ($model->getErrors() as $msgggs)
                {
                    foreach ($msgggs as $vvv){
                        $msgx.=$vvv."\n";
                    }
                }
                return json_encode(['code'=>111,'msg'=>'失败，'.$msgx ]);
            }
        }
    }
    public function actionGift()
    {
        $this->layout="main_admin";
        $model = new LogCustomer();
        $model->scenario="recharge";
        $model->coin=0;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }else { 
            if (count($model->getErrors())>0)
                Yii::error(print_r($model->getErrors(),true));
            return $this->render('gift', [
                'model' => $model,
            ]);
        }
    }
    
    /**
     * Updates an existing LogCustomer model.
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
     * Deletes an existing LogCustomer model.
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
     * Finds the LogCustomer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LogCustomer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LogCustomer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('页面不存在.');
        }
    }
}
