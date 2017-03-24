<?php

namespace app\modules\zjhadmin\controllers;

use Yii;
use app\models\GmChannelInfo;
use app\models\GmChannelInfoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\User;

/**
 * ChannelController implements the CRUD actions for GmChannelInfo model.
 */
class ChannelController extends AdmController
{
 

    /**
     * Lists all GmChannelInfo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GmChannelInfoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single GmChannelInfo model.
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
     * Creates a new GmChannelInfo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new GmChannelInfo();
        $model->force=0;
        $modelacc = new User();
//         $modelacc->scenario="channel";
        if (Yii::$app->getRequest()->isPost){
            $model->load(Yii::$app->request->post());
            $modelacc->load(Yii::$app->request->post());
            $modelacc->roledesc=$model->channel_name;
            $modelacc->userdisplay  = $model->channel_name;
            if ($modelacc->validate() && $model->validate()){
                if ($modelacc->save()) {
                    $model->opname=strval($modelacc->id);
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

    /**
     * Updates an existing GmChannelInfo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelacc = User::findOne([$model->opname]);
        if (!is_object($modelacc))
            $modelacc=new User();
//         $modelacc->scenario="channel";
        if (Yii::$app->getRequest()->isPost){
            $model->load(Yii::$app->request->post());
            $modelacc->load(Yii::$app->request->post());
            $modelacc->roledesc=$model->channel_name;
            $modelacc->userdisplay  = $model->channel_name;
            Yii::error("controller ,get newpasswd  is ===".print_r($modelacc->attributes,true));
//             $modelacc->newpasswd=Yii::$app->getRequest()->getBodyParam('User')['newpasswd'];
            if (null !== Yii::$app->getRequest()->getBodyParam('User')['newpasswd'] && Yii::$app->getRequest()->getBodyParam('User')['newpasswd']!="")
                $modelacc->password_hash = md5(Yii::$app->getRequest()->getBodyParam('User')['newpasswd']);
//             $modelacc->update_at=time();
            if (!$modelacc->isNewRecord)
                $modelacc->updateAttributes($modelacc->attributes);
            if ($modelacc->validate() && $modelacc->save()) {
                Yii::error("model account is validate and saved");
                $model->status=0;
                $model->opname=strval($modelacc->id);
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
     * Deletes an existing GmChannelInfo model.
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
     * Finds the GmChannelInfo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GmChannelInfo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GmChannelInfo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
