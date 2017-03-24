<?php

namespace app\modules\zjhadmin\controllers;

use Yii;
use app\models\LogFriendsMsgs;
use app\models\LogFriendsMsgsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\ApiErrorCode;

/**
 * LogmsgController implements the CRUD actions for LogFriendsMsgs model.
 */
class LogmsgController extends AdmController
{
 

    public function actionIndex()
    {
        $this->layout="main_admin";
        return $this->render('chat');
    }
    
    public function actionUnreadlist()
    {
        return json_encode(['code'=>0,'results'=>LogFriendsMsgs::getunreadlist()]);
    }
    public function actionReadlist()
    {
        return json_encode(['code'=>0,'results'=>LogFriendsMsgs::getresponselist()]);
    }
    
    public function actionFetchunread($fid)
    {
        return json_encode(['code'=>0,'results'=>LogFriendsMsgs::Fetch($fid)]);
    }
    public function actionSendcust()
    {
        Yii::error("====================");
        if(Yii::$app->getRequest()->isPost)
        {
//             Yii::error("===send cust get params : ".print_r(Yii::$app->getRequest()->getParams(),true));
//             Yii::error("===send cust post params : ".print_r(Yii::$app->getRequest()->getBodyParams(),true));
            $tid = Yii::$app->getRequest()->getQueryParam('fid');
            $typef = Yii::$app->getRequest()->getQueryParam('typef');
            $msg = Yii::$app->getRequest()->getBodyParam('msg');
            Yii::error("typef : ".$typef);
            if ($typef === "allread"){
                Yii::error("set all read ".$tid);
                LogFriendsMsgs::ReadAll($tid);
                return json_encode(ApiErrorCode::$OK);
            }else {
                Yii::error("get param : ".print_r($_GET,TRUE));
                if(LogFriendsMsgs::SendCustomer($tid,$msg))
                {
                    return json_encode(ApiErrorCode::$OK);
                }else {
                    return json_encode(ApiErrorCode::$InvalidateRequest);
                }
            }
        }else {
            Yii::error("not post");
            return json_encode(ApiErrorCode::$InvalidateRequest);
        }
    }
    
//     /**
//      * Lists all LogFriendsMsgs models.
//      * @return mixed
//      */
//     public function actionIndex()
//     {
//         $searchModel = new LogFriendsMsgsSearch();
//         $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

//         return $this->render('index', [
//             'searchModel' => $searchModel,
//             'dataProvider' => $dataProvider,
//         ]);
//     }

    /**
     * Displays a single LogFriendsMsgs model.
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
     * Creates a new LogFriendsMsgs model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new LogFriendsMsgs();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing LogFriendsMsgs model.
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
     * Deletes an existing LogFriendsMsgs model.
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
     * Finds the LogFriendsMsgs model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LogFriendsMsgs the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LogFriendsMsgs::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
