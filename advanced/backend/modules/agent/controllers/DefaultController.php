<?php

namespace app\modules\agent\controllers;
use yii;
use yii\web\Controller;
use app\models\AgentInfo;

class DefaultController extends AdmController
{
    public function actionIndex()
    {
        $agent = AgentInfo::findOne(['account_id'=>Yii::$app->user->id]);
        return $this->render('index',['model'=>$agent]);
    }
    
    public function actionError()
    {
        if (Yii::$app->getErrorHandler()->exception !== null) {
            return $this->render('error'
                , ['exception' => Yii::$app->getErrorHandler()->exception]
            );
        }
        //      return $this->render('error');
    }
}
