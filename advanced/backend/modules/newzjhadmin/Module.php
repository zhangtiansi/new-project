<?php
namespace app\modules\newzjhadmin;
use yii;
class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\newzjhadmin\controllers';
    
    public function init()
    {
        parent::init();
        $this->layout="main_admin";
        Yii::$app->errorHandler->errorAction = 'newzjhadmin/default/error';
        $this->setComponents([
            'user'=>[
                'class'=>'yii\web\User',
                'loginUrl' => ['newzjhadmin/site/login'],
                'identityClass' => 'app\models\User',
                'enableAutoLogin' => true,
            ],
            'log' => [
                'class' => 'yii\log\FileTarget',
                'traceLevel' => YII_DEBUG ? 3 : 0,
                'targets' => [
                    ['class' => 'yii\log\FileTarget',
                        'levels' => ['info','error','warning'],
                        'logFile' => '@app/runtime/logs/newzjhadmin.log',
                        'maxFileSize' => 1024 * 2,
                        'maxLogFiles' => 20,
                    ],
                ],
            ],
            'errorHandler' => [
                'class'=>'yii\web\ErrorHandler',
                'errorAction' => 'newzjhadmin/site/error',
            ],
        ]);
//         \Yii::configure($this, require(__DIR__ . '/config.php'));
    }
}
