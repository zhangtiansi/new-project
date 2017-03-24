<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\GmChannelInfo;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DataDailyRechargeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '每日充值数据';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-daily-recharge-index">
<div><h1><?= Html::encode($this->title) ?></h1></div>
    <?php   echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="col-xs-12 row-block">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//         'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'udate',
            'channel',
            'source',
            ['attribute'=>'totalfee',
                'value'=>function($model){
                    $c = GmChannelInfo::findOne(['opname'=>Yii::$app->user->id]);
                    if (is_object($c)){
                        return Yii::$app->formatter->asDecimal($c->p_recharge*$model->totalfee,0);
                    }else {
                        return $model->totalfee;
                    }
                } ],
//             'totalfee',
            'pnum',
            ['attribute'=>'up',
            'value'=>function($model){
                $c = GmChannelInfo::findOne(['opname'=>Yii::$app->user->id]);
                if (is_object($c)){
                    return Yii::$app->formatter->asDecimal($c->p_recharge*$model->up,2);
                }else {
                    return $model->up;
                }
            } ],
//             'up:decimal',
        ],
    ]); ?>
</div>
</div>
<script>
jQuery(function($) {
	console.log(location.hostname);
    $('li.active').removeClass("active open");
    $('.data-recharge').addClass("active");
    $('.data-recharge').parent('ul').parent('li').addClass("active open");
});
</script>