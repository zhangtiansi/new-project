<?php

namespace app\modules\wxapi\controllers;
use Yii;
use yii\web\Controller;

class DefaultController extends Controller
{
    public $enableCsrfValidation = false;
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionApi()
    {
        Yii::error("check api start");
        $this->layout = "none";
        return $this->render('qycheck');
//         return "aaaa";
    }
}
