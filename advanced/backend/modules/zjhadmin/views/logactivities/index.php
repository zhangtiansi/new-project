<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LogActivitiesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '玩家活动参与记录';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-activities-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'uid',
            [
            'label'=>'昵称',
                'value'=>'player.name',
                    ],
            ['attribute'=>'actid',
            'value'=>'act.act_title'],
            ['attribute'=>'marks',
            'value'=>'marks'],
            'ctime',
            [
                'label'=>'现有金币',
                'value'=>'player.money',
            ],[
                'label'=>'保险箱',
                'value'=>'player.point_box',
            ],[
                'label'=>'现有钻石',
                'value'=>'player.point',
            ],[
                'label'=>'VIP等级',
                'value'=>'player.power',
            ],[
                'label'=>'登录IME',
                'value'=>'account.device_id',
            ],
        ],
    ]); ?>

</div>
<script>
jQuery(function($) {
    $('.submenu li.active').removeClass("active open");
    $('.nav-list li.active').removeClass("active open");
    $('.opt-actlogs').addClass("active");
    $('.opt-actlogs').parent('ul').parent('li').addClass("active open");


    
});
</script>