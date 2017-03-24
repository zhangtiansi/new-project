<?php

namespace app\modules\customer;
use yii;
use yii\filters\AccessControl;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\customer\controllers';

    public function init()
    {
        parent::init();
        $this->layout="main_admin";
        Yii::$app->errorHandler->errorAction = 'customer/default/error';
        // custom initialization code goes here
        $this->setComponents([
            'components' => [
                'class' => 'app\modules\customer\Module',
                'user' => [
                    'identityClass' => 'app\models\User',
                    'enableAutoLogin' => true,
                ],
                'log' => [
                    'traceLevel' => YII_DEBUG ? 3 : 0,
                    'targets' => [
                        [
                            'class' => 'yii\log\FileTarget',
                            'levels' => ['error', 'warning'],
                        ],
                    ],
                ],
                'errorHandler' => [
                    'errorAction' => 'customer/site/error',
                ],
            ],
        ]);
        
    }
}
