<?php

namespace app\modules\agent\controllers;

use Yii;
use app\models\LogUserlogin;
use app\models\LogUserloginSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LogloginController implements the CRUD actions for LogUserlogin model.
 */
class LogloginController extends AdmController
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
     * Lists all LogUserlogin models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LogUserloginSearch();
        if (Yii::$app->getRequest()->getQueryParam('gid',"")!="")
        {
            $dataProvider = $searchModel->search(['LogUserloginSearch'=>['uid'=>Yii::$app->getRequest()->getQueryParam('gid')]]);
        }else{
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Finds the LogUserlogin model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LogUserlogin the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LogUserlogin::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
