<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\LogBetResults;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GmAccountInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '时时乐押注/返奖记录';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="betinfos-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//         'filterModel' => $searchModel,
        'columns' => [
            'gid',
            ['label'=>'玩家信息',
            'format'=>'raw',
            'value'=>function($model){
                $hx="  ";
                $hx.= Html::a("昵称：".$model->player->name,'/zjhadmin/player/view?id='.$model->gid,['class'=>'btn btn-minier btn-purple modify','data-aid'=>$model->gid]);
                if (is_object($model->player)){
                    $hx.= $model->player->status==98?" <<Agent帐号>>":"";
                    $hx.=" VIP:".$model->player->power;
                }
                return $hx;
            }],
            'bid', 
            'bet_1', 
            'bet_2', 
            'bet_3', 
            'bet_4',
            'bet_5', 
            'bet_6',
            ['attribute'=>'bettype',
            'format'=>'raw',
            'value'=>function($model){
                return LogBetResults::$px[$model->bettype];
            },],
            'bettime',
            [
                'attribute'=>'reward',
                'value'=>function($model){
                    if ($model->reward>0){
                        return Yii::$app->formatter->asInteger($model->reward/10000)."万";
                    }else {
                        return 0;
                    }     
                }
            ],
            'rewardtime'
        ],
    ]); ?>

</div>
<script>
jQuery(function($) {
    $('.submenu li.active').removeClass("active open");
    $('.nav-list li.active').removeClass("active open");
    $('.betinfo').addClass("active");
    $('.betinfo').parent('ul').parent('li').addClass("active open");

});
</script>