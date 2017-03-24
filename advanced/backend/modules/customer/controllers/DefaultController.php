<?php

namespace app\modules\customer\controllers;
use yii;
use yii\web\Controller;
use app\models\CfgServerlist;
use app\models\CfgBetconfig;
use app\models\LogBetResults;
use app\models\CfgBetchance;
use app\models\UploadForm;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\GmOrderlist;
use app\models\GmAccountInfo;
use yii\data\Pagination;

class DefaultController extends Controller
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
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['login', 'logout', 'signup','index','sysparam','customer','usersystem','datacenter'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'signup'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['sysparam','index','customer','usersystem','datacenter'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    public function actionIndex()
    {
        return $this->render('index');
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
