<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\GmChannelInfo;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GmAccountInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '私人房刷号权重';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="weight-private-list">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//         'filterModel' => $searchModel,//'win_uid', 'ct', 'power', 'money', 'status', 'gamePlay', 'game_win','win_coin', 'totalweight', 'avg_weight','last_login','reg_channel'
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['attribute'=>'win_uid',
                'format'=>'raw',
                'value'=>function($model){
                    return Html::a($model->win_uid,'#',['class'=>'btn btn-minier btn-purple clickplayerinfo','data-gid'=>$model->win_uid])." ".$model->player->name;
                }
            ],
            'ct',
            'totalweight',
            'avg_weight',
            'win_coin',
//             'status',
            ['attribute'=>'status',
                'value'=>function($model){
                    return $model->status==0?"正常":"已封号";
                }
            ],
            'power', 'money',  'gamePlay', 'game_win',
            'last_login',
            ['attribute'=>'reg_channel',
                'value'=>function($model){
                  return GmChannelInfo::findChannelNamebyid($model->reg_channel);
                }
            ],
        ],
    ]); ?>

</div>
<script>
jQuery(function($) {
	console.log(location.hostname);
    $('.submenu li.active').removeClass("active open");
    $('.nav-list li.active').removeClass("active open");
    $('.weightprivate').addClass("active");
    $('.weightprivate').parent('ul').parent('li').addClass("active open");
    $('.mod').click(function(){
    	location.href='http://'+location.hostname+'/zjhadmin/player/view?id='+$(this).data("player");
    }); 
});
</script>