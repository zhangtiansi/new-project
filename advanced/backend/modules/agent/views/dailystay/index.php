<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\DataDailyStay;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DataDailyStaySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '每日留存';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-daily-stay-index">
<div><h1><?= Html::encode($this->title) ?></h1></div>

<div class="col-xs-12 row-block">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//         'filterModel' => $searchModel,
        'columns' => [
            'udate',
            'channel',
            [
                'attribute'=>'stay2',
                'value'=>
                function($model){
                    return  DataDailyStay::getPercentText($model->stay2,$model->regtotal);   //主要通过此种方式实现
                },
                ],
            [
            'attribute'=>'activestay2',
                'value'=>
                function($model){
                    return  DataDailyStay::getPercentText($model->activestay2,$model->regtotal);   //主要通过此种方式实现
            },
            ],
            [
            'attribute'=>'paystay2',
                'value'=>
                function($model){
                    return  DataDailyStay::getPercentText($model->paystay2,$model->regtotal);   //主要通过此种方式实现
            },
            ],
            [
            'attribute'=>'stay3',
                'value'=>
                function($model){
                    return  DataDailyStay::getPercentText($model->stay3,$model->regtotal);   //主要通过此种方式实现
            },
            ],
            [
            'attribute'=>'activestay3',
                'value'=>
                function($model){
                    return  DataDailyStay::getPercentText($model->activestay3,$model->regtotal);   //主要通过此种方式实现
            },
            ],
            [
            'attribute'=>'paystay3',
                'value'=>
                function($model){
                    return  DataDailyStay::getPercentText($model->paystay3,$model->regtotal);   //主要通过此种方式实现
            },
            ],
            [
            'attribute'=>'stay7',
                'value'=>
                function($model){
                    return  DataDailyStay::getPercentText($model->stay7,$model->regtotal);   //主要通过此种方式实现
            },
            ],
            [
            'attribute'=>'activestay7',
                'value'=>
                function($model){
                    return  DataDailyStay::getPercentText($model->activestay7,$model->regtotal);   //主要通过此种方式实现
            },
            ],
            [
            'attribute'=>'paystay7',
            'value'=>
                function($model){
                return  DataDailyStay::getPercentText($model->paystay7,$model->regtotal);   //主要通过此种方式实现
            },
            ],
            'regtotal',
        ],
    ]); ?>
</div>
</div>
<script>
jQuery(function($) {
	console.log(location.hostname);
    $('li.active').removeClass("active open");
    $('.data-stay').addClass("active");
    $('.data-stay').parent('ul').parent('li').addClass("active open");
});
</script>