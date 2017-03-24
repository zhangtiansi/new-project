<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\GmPlayerInfo;
use app\models\GmAccountInfo;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GmAccountInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '短信每日充值';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="smsrecharge">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//         'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'tdate',
            'uid',
            'total'
        ],
    ]); ?>

</div>
<script>
jQuery(function($) {
	console.log(location.hostname);
    $('.submenu li.active').removeClass("active open");
    $('.nav-list li.active').removeClass("active open");
    $('.smsrecharge').addClass("active");
    $('.smsrecharge').parent('ul').parent('li').addClass("active open");
    $('.mod').click(function(){
    	location.href='http://'+location.hostname+'/zjhadmin/player/view?id='+$(this).data("player");
    });
    $('.order').click(function(){
    	location.href='http://'+location.hostname+'/zjhadmin/order/index?gid='+$(this).data("player");
    }); 
});
</script>