<?php

namespace app\modules\zjhadmin\controllers;

use Yii;
use app\models\AgentInfo;
use app\models\AgentInfoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\User;
use app\components\ApiErrorCode;
use app\models\SysOplogs;

/**
 * AgentController implements the CRUD actions for AgentInfo model.
 */
class AgentController extends AdmController
{
 

    /**
     * Lists all AgentInfo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AgentInfoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AgentInfo model.
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
     * Creates a new AgentInfo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AgentInfo();
        $modelacc = new User();
        $modelacc->scenario="agent";
        if (Yii::$app->getRequest()->isPost){
            $model->load(Yii::$app->request->post());
            $modelacc->load(Yii::$app->request->post());
            $modelacc->roledesc=$model->agent_desc;
            $modelacc->userdisplay  = $model->agent_name;
            if ($modelacc->validate() && $model->validate()){
                if ($modelacc->save()) {
                    $model->account_id=$modelacc->id;
                    $model->status=0;
                    if($model->save()){
                        return $this->redirect(['index']);
                    }else {
                        Yii::error("model  save failed ".print_r($model->getErrors(),true));
                    }
                }else {
                    Yii::error('modelaccount save failed '.print_r($modelacc->getErrors(),true));
                }
            }else {
                return $this->render('create', [
                    'model' => $model,
                    'modelacc'=>$modelacc,
                ]);
            }
           } else {
            return $this->render('create', [
                'model' => $model,
                'modelacc'=>$modelacc,
            ]);
        }
    }
    
    public function actionAddmoney()
    {
        $aid=Yii::$app->getRequest()->getQueryParam('aid');
        if (Yii::$app->getRequest()->isPost)
        {
            $user = User::findOne(Yii::$app->user->id);
            if ($user->role !=User::ROLE_ADMIN && $user->role !=User::ROLE_AGENT_ADMIN){
                return json_encode(ApiErrorCode::$RuleError);
            }
            $money = Yii::$app->getRequest()->getBodyParam('money');
            $model = AgentInfo::findOne($aid);
            $model->money = $model->money + $money;
            if ($model->save()){
                $sy = new SysOplogs();
                $sy->opid=Yii::$app->user->id;
                $sy->keyword="addagentmoney";
                $sy->cid=$money;
                $sy->gid=$aid;
                $sy->logs=$user->userdisplay." 给Agent ".$model->agent_name."加了 ".$money." 元预存金";
                $sy->desc="addmoney";
                $sy->ctime=date('Y-m-d H:i:s');
                $sy->save();
                return json_encode(ApiErrorCode::$OK);
            }
        }
        
    }

    /**
     * Updates an existing AgentInfo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelacc = User::findOne([$model->account_id]);
        $modelacc->scenario="agent";
//         if ($model->load(Yii::$app->request->post()) && $model->save()) {
//             return $this->redirect(['view', 'id' => $model->id]);
//         }
        if (Yii::$app->getRequest()->isPost){
            $model->load(Yii::$app->request->post());
            $modelacc->load(Yii::$app->request->post());
            $modelacc->roledesc=$model->agent_desc;
            $modelacc->userdisplay  = $model->agent_name;
            Yii::error("controller ,get newpasswd  is ===".print_r($modelacc->attributes,true));
//             $modelacc->newpasswd=Yii::$app->getRequest()->getBodyParam('User')['newpasswd'];
            if (Yii::$app->getRequest()->getBodyParam('User')['newpasswd']!="")
                $modelacc->password_hash = md5(Yii::$app->getRequest()->getBodyParam('User')['newpasswd']);
//             $modelacc->update_at=time();
            $modelacc->updateAttributes($modelacc->attributes);
            if ($modelacc->validate() && $modelacc->save()) {
                $model->status=0;
                if($model->save()){
                    return $this->redirect(['index' ]);
                }else {
                    Yii::error("model  save failed ".print_r($model->getErrors(),true));
                }
            }else {
                Yii::error('modelaccount save failed '.print_r($modelacc->getErrors(),true));
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'modelacc'=>$modelacc,
            ]);
        }
    }

    /**
     * Deletes an existing AgentInfo model.
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
     * Finds the AgentInfo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AgentInfo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AgentInfo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
