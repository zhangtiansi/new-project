<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\LogBetResults;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LogBetResultsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '时时乐开奖结果';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-bet-results-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'bid',
            ['attribute'=>'result',
            'format'=>'raw',
            'value'=>function($model){
                return LogBetResults::$px[$model->result];
            },],
            'ctime',
            'coin',
            ['attribute'=>'coin',
            'format'=>'raw',
            'value'=>function($model){
                return Yii::$app->formatter->asDecimal($model->coin/10000,0)."万";
            },],
            'player_num',

        ],
    ]); ?>

</div>
<script>
jQuery(function($) {
	console.log(location.hostname);
    $('.submenu li.active').removeClass("active open");
    $('.nav-list li.active').removeClass("active open");
    $('.ops-ssl-result').addClass("active");
    $('.ops-ssl-result').parent('ul').parent('li').addClass("active open");
});
</script>