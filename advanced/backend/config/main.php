<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'language'=>'zh-CN',
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'zjhadmin' => [
            'class' => 'app\modules\zjhadmin\Module',
//             'components' => [
//                 'errorHandler' => [
//                     'class' => 'yii\web\ErrorAction',
//                     'errorAction' => 'zjhadmin/default/error',
//                 ],
//              ],
        ],
        'customer' => [
            'class' => 'app\modules\customer\Module',
            
        ],
        'agent' => [
            'class' => 'app\modules\agent\Module',
            
        ],
        'channel' => [
            'class' => 'app\modules\channel\Module',
        ],
        'wxapi' => [
            'class' => 'app\modules\wxapi\Module',
        ],
        'newzjhadmin' => [
            'class' => 'app\modules\newzjhadmin\Module',
        ],
        'gridview' => [
            'class' => 'kartik\grid\Module',
        ],
    ],
    'components' => [
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
            'errorAction' => 'site/error',
        ],
    ],
    'params' => $params,
];
