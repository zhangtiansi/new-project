<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\GmChannelInfo;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DataMonthRechargeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '月充值数据';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-month-recharge-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'c_month',
            [
                'attribute'=>'channel',
                'format'=>'raw',
                'value'=>function($model){
                    return GmChannelInfo::findChannelNamebyid($model->channel);
                },
            ],
            'pay_source',
            'recharge',
            'num',
            'unum',
            'arpu:decimal',
            'pay_avg:decimal',
        ],
    ]); ?>

</div>
<script>
jQuery(function($) {
	console.log(location.hostname);
    $('.submenu li.active').removeClass("active open");
    $('.nav-list li.active').removeClass("active open");
    $('.data-monthrecharge').addClass("active");
    $('.data-monthrecharge').parent('ul').parent('li').addClass("active open");
});
</script>