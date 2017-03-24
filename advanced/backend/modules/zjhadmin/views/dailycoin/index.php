<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DataDailyCoinchangeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '每日金币变更总数';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-daily-coinchange-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'udate',
            ['attribute'=>'change_type',
               'value'=>'changeType.c_name'],
            'sum_coin',
            ['attribute'=>'sum_coin',
                'format'=>'raw',
                'value'=>function($model){
                    if (abs($model->sum_coin)>100000000){
                        return Yii::$app->formatter->asDecimal($model->sum_coin/100000000,2)."亿";
                    }elseif (abs($model->sum_coin)>10000){
                        return Yii::$app->formatter->asDecimal($model->sum_coin/10000,2)."万";
                    }else {
                        return $model->sum_coin;
                    }
                },
            ],
        ],
    ]); ?>

</div>
<script>
jQuery(function($) {
	console.log(location.hostname);
    $('.submenu li.active').removeClass("active open");
    $('.nav-list li.active').removeClass("active open");
    $('.data-coin').addClass("active");
    $('.data-coin').parent('ul').parent('li').addClass("active open");
});
</script>