<?php

namespace app\modules\channel;
use Yii;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\channel\controllers';

    public function init()
    {
        parent::init();
        $this->layout="main_channel";
        Yii::$app->errorHandler->errorAction = 'channel/site/error';
        $this->setComponents([
            'user'=>[
                'class'=>'yii\web\User',
                'loginUrl' => ['channel/site/login'],
                    'identityClass' => 'app\models\User',
                    'enableAutoLogin' => true,
                    ],
                    'log' => [
                        'class' => 'yii\log\FileTarget',
                        'traceLevel' => YII_DEBUG ? 3 : 0,
                        'targets' => [
                            ['class' => 'yii\log\FileTarget',
                                'levels' => ['info','error','warning'],
                                    'logFile' => '@app/runtime/logs/channel.log',
                                    'maxFileSize' => 1024 * 2,
                                    'maxLogFiles' => 20,
                                ],
                            ],
                        ],
                        'errorHandler' => [
                            'class'=>'yii\web\ErrorHandler',
                            'errorAction' => 'channel/site/error',
                        ],
                    ]);
        // custom initialization code goes here
    }
}
