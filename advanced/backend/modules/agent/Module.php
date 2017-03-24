<?php

namespace app\modules\agent;
use Yii;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\agent\controllers';

    public function init()
    {
        parent::init();
        $this->layout="main_admin";
        Yii::$app->errorHandler->errorAction = 'agent/default/error';
        // custom initialization code goes here
    }
}
