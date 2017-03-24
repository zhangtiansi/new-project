<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\GmChannelInfo;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DailystaySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '留存率';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dailystay-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//         'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'udate',
            [
                'attribute'=>'channel',
                'value'=>function($model){
                    return GmChannelInfo::findChannelNamebyid($model->channel);
                },
            ],
            'r_num',
            [
             'attribute'=>'s_num2',
                'value'=>function($model){
                    return $model->s_num2." ~ ".Yii::$app->formatter->asPercent($model->s_num2/$model->r_num);
                },   
            ],[
             'attribute'=>'s_num3',
                'value'=>function($model){
                    return $model->s_num3." ~ ".Yii::$app->formatter->asPercent($model->s_num3/$model->r_num);
                },   
            ],[
             'attribute'=>'s_num7',
                'value'=>function($model){
                    return $model->s_num7." ~ ".Yii::$app->formatter->asPercent($model->s_num7/$model->r_num);
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
    $('.data-stay').addClass("active");
    $('.data-stay').parent('ul').parent('li').addClass("active open");
});
</script>