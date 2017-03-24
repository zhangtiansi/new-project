<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DataDailyUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '每日用户数据';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-daily-user-index">
    <div><h1><?= Html::encode($this->title) ?></h1></div>

    <div class="col-xs-12 row-block">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//         'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'udate',
            'channel',
            'totalreg',
            'loginp',
            'loginnum',
            'activenum',
            'regactive'
        ],
    ]); ?>
</div>
</div>
<script>
jQuery(function($) {
	console.log(location.hostname);
    $('li.active').removeClass("active open");
    $('.data-user').addClass("active");
    $('.data-user').parent('ul').parent('li').addClass("active open");
});
</script>