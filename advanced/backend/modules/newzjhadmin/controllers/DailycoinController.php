<?php

namespace app\modules\newzjhadmin\controllers;

use Yii;
use app\models\DataDailyRecharge;
use app\models\DataDailyRechargeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\User;


class DailycoinController extends AdmController
{
    public function actionIndex(){
        return $this->render('index');
    }
}