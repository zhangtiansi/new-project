<?php

namespace app\modules\channel\controllers;


class DefaultController extends AdmController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
