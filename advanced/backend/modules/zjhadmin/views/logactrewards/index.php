<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LogActrewardsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title ='外围活动记录';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-actrewards-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//         'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'gid',
            'point',
            'coin',
            'propid',
            'propnum',
            'card_g',
            'card_s',
            'card_c',
            'ctime',
            'change_type',
            'desc',
            ['label'=>'昵称',
            'value'=>'player.name',
            ],
            ['attribute'=>'change_type',
               'value'=>'changeType.c_name'],
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
	console.log(location.hostname);
    $('.submenu li.active').removeClass("active open");
    $('.nav-list li.active').removeClass("active open");
    $('.log-activereward').addClass("active");
    $('.log-activereward').parent('ul').parent('li').addClass("active open");
});
</script>