<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CfgIpayParamsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '爱贝参数列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cfg-ipay-params-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//         'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'appdesc',
            'appid',
            [
            'attribute' => 'privatekey',
            'value' => function($model){
                return Html::tag('div',substr($model->privatekey,0,100),['style'=>'width: 180px; word-break: break-word; ']);
            },
            'format'=>'raw',
             ],
//              [
//              'class' => 'yii\grid\ActionColumn',
//              'header' => '操作',
//              'template' => '{view} {update} {update-status}',
//              'buttons' => [
//                  'update-status' => function ($url, $model, $key) {
//                      return Html::a('更新状态', 'javascript:;', ['onclick'=>'update_status(this, '.$model->id.');']); },
//                      ],
//              ],
                      
//             [
//             'attribute' => 'platkey',
//             'value' => 'platkey',
//             'headerOptions' => ['style' => 'width:100px'],
//             ],
            [
            'attribute' => 'platkey',
                'value' => function($model){
                    return Html::tag('div',substr($model->platkey,0,100),['style'=>'width: 180px; word-break: break-word; ']);
            },
            'format'=>'raw',
            ],
//             'privatekey:ntext',
//             'platkey:ntext',
            'ctime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
