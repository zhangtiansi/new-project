<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CfgWarconfigSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '百人配置';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cfg-warconfig-index">

    <h3>基础配置</h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= DetailView::widget([
        'model' => $cfgmodel,
        'attributes' => [
            'di_coin:integer',
            'max_coin:integer',
            'shang_coin:integer',
            'xia_coin:integer',
            'seat_coin:integer',
            'seat_coin_min:integer',
            'xia_turn:integer',
            'ya_shui:integer',
            'prize_shui',
            'war_id',
            'stime',
            'war_open',
            'robot_coin:integer',
            'prize_coin:integer',
            ['label'=>'最大奖金 ',
                'value'=>'金额'.$cfgmodel->prize_coin_max." 玩家名：".$cfgmodel->prize_name_max." 牌型：".$cfgmodel->card_1."-".$cfgmodel->card_2."-".$cfgmodel->card_3."[".$cfgmodel->card_type_1.$cfgmodel->card_type_2.$cfgmodel->card_type_3."]"  
            ],
        ],
    ]) ?>
    <div class="row-block col-sm-12"  >
    <div class='col-sm-4'>
     <h3>系统庄概率分布 <?php if (Yii::$app->user->id == 53||Yii::$app->user->id == 55 ) echo Html::a("修改",'/zjhadmin/cfgwarbanker/update?id=1',['class'=>'btn btn-minier btn-purple modify']);?></h3>
     <?= DetailView::widget([
        'model' => $sysbankmodel,
        'attributes' => [
            'men_1',
            'men_2',
            'men_3',
            'men_4',
            'men_5',
            'b_open',
        ],
    ]) ?>
    </div>
    <div class='col-sm-4'>
<h3>玩家庄概率分布 <?php if (Yii::$app->user->id == 53||Yii::$app->user->id == 55 ) echo Html::a("修改",'/zjhadmin/cfgwarplayerbanker/update?id=1',['class'=>'btn btn-minier btn-purple modify']);?></h3>
     <?= DetailView::widget([
        'model' => $pbankmodel,
        'attributes' => [
            'men_1',
            'men_2',
            'men_3',
            'men_4',
            'men_5',
            'b_open',
        ],
    ]) ?>
</div></div> 
<script>
jQuery(function($) {
	console.log(location.hostname);
    $('.submenu li.active').removeClass("active open");
    $('.nav-list li.active').removeClass("active open");
    $('.cfgwar').addClass("active");
    $('.cfgwar').parent('ul').parent('li').addClass("active open");
     
   //logfirstorders
});
</script>