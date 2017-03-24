<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LogWarRecordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '百人开奖金币记录';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-war-record-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//         'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'war_id',
            'men1_coin',
            'men1_prize',
            'men2_coin',
            'men2_prize',
            'men3_coin',
            'men3_prize',
            'men4_coin',
            'men4_prize',
            ['label'=>'门1牌型',
               'format'=>'raw',
                'value'=>function($model){
                    return $model->cards->men_card_1;
                }
            ],
            ['label'=>'门2牌型',
                'format'=>'raw',
                'value'=>function($model){
                    return $model->cards->men_card_2;
                }
            ],
            ['label'=>'门3牌型',
                'format'=>'raw',
                'value'=>function($model){
                    return $model->cards->men_card_3;
                }
            ],
            ['label'=>'门4牌型',
                'format'=>'raw',
                'value'=>function($model){
                    return $model->cards->men_card_4;
                    }
            ],
            ['attribute'=>'banker_id',
                'format'=>'raw',
                'value'=>function($model){
                    $hx = "UID:".$model->banker_id.Html::a("昵称：".$model->banker->name,'/zjhadmin/player/view?id='.$model->banker_id,['class'=>'btn btn-minier btn-purple modify','data-aid'=>$model->banker_id]);
                    return $hx;
                }
            ],
            'banker_coin',
            'ctime',
        ],
    ]); ?>

</div>
<script>
jQuery(function($) {
	console.log(location.hostname);
    $('.submenu li.active').removeClass("active open");
    $('.nav-list li.active').removeClass("active open");
    $('.logwarrecord').addClass("active");
    $('.logwarrecord').parent('ul').parent('li').addClass("active open");
     
   //logfirstorders
});
</script>