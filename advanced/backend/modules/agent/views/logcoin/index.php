<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\GmPlayerInfo;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LogCoinRecordsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '金币变更记录';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-coin-records-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
//             'id',
            ['attribute'=>'uid',
                'format'=>'raw',
                'value'=>function($model){
                    $hx="  ";
                    $hx.= "UID:".$model->uid.Html::a("昵称：".$model->player->name,'/agent/player/view?id='.$model->uid,['class'=>'btn btn-minier btn-purple modify','data-aid'=>$model->uid]);
                    if (is_object($model->player)){
                        $hx.= $model->player->status==98?" <<Agent帐号>>":"";
                    }
                    return $hx;
          
            }],
            
//             'uid',
//             'from_uid',
//             'change_type',
            ['attribute'=>'change_type',
               'value'=>'changeType.c_name'],
            'change_before',
            'change_coin',
            'change_after',
            [
                'attribute'=>'game_no',
                'format'=>'raw',
                'value'=>function($model){
                    $hx="  ";
                    $hx.= Html::a("<追踪该局『".$model->game_no."==".$model->prop_id."』>",'/agent/logcoin?gameno='.$model->game_no.'&propid='.$model->prop_id,['class'=>'btn btn-minier btn-purple modify']);
                    $hx.= Html::a("<追踪该桌『".$model->game_no."』>",'/agent/logcoin?gameno='.$model->game_no,['class'=>'btn btn-minier btn-yellow modify']);
                    return $hx;
                }
            ],
            'game_no',
            'prop_id',
            'ctime',
            'card_num',
            'card_type',
            'card_result',
        ],
    ]); ?>

</div>
<script>
jQuery(function($) {
	console.log(location.hostname);
    $('.submenu li.active').removeClass("active open");
    $('.nav-list li.active').removeClass("active open");
    $('.logcoin').addClass("active");
    $('.logcoin').parent('ul').parent('li').addClass("active open");
     
   //logfirstorders
});
</script>