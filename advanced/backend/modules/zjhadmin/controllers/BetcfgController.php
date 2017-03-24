<?php

namespace app\modules\zjhadmin\controllers;

use Yii;
use app\models\CfgBetconfig;
use app\models\CfgBetconfigSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\ApiErrorCode;
use app\models\CfgGameParam;

/**
 * BetcfgController implements the CRUD actions for CfgBetconfig model.
 */
class BetcfgController extends AdmController
{
 

    /**
     * Lists all CfgBetconfig models.
     * @return mixed
     */
    public function actionIndex()
    {
         return $this->render('index', [
            'model' => $this->findModel(1),
        ]);
    }



    /**
     * Updates an existing CfgBetconfig model.
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
    
    public function actionMod()
    {
        if (Yii::$app->getRequest()->isPost){
            $coin = Yii::$app->getRequest()->getBodyParam('coin');
            $btcfg=CfgBetconfig::findOne(1);
            if ($coin>10000000){
                $btcfg->num_coin=$coin;
            }
            if ($btcfg->save())
            {
                if (CfgGameParam::ReloadParam())
                    return json_encode(ApiErrorCode::$OK);
                else 
                    return json_encode(ApiErrorCode::$ReloadSysParamERR);
            }else {
                return json_encode(ApiErrorCode::$SetSSLcfgFailed);
            }
        }else 
            throw new NotFoundHttpException();
        
    }
    /**
     * Displays a single Betcfg model.
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
     * Finds the CfgBetconfig model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CfgBetconfig the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CfgBetconfig::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
