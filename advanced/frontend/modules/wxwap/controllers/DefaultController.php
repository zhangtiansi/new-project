<?php

namespace app\modules\wxwap\controllers;

use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $this->layout="main"; 
        return $this->render('index');
    }
}
