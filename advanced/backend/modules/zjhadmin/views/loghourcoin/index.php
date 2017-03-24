<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LogHourCoinchangeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '每小时玩家变更金币';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-hour-coinchange-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//         'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['attribute'=>'gid',
                'format'=>'raw',
                'value'=>function($model){
                    $hx="  ";
                    $hx.= "UID:".$model->gid.Html::a("昵称：".$model->player->name,'/zjhadmin/player/view?id='.$model->gid,['class'=>'btn btn-minier btn-purple modify','data-aid'=>$model->gid]);
                    if (is_object($model->player)){
                        $hx.= $model->player->status==98?" <<Agent帐号>>":"";
                    }
                    return $hx;
            }],
            ['attribute'=>'change_type',
               'value'=>'changeType.c_name'],
            'totalchange',
            'chour',
        ],
    ]); ?>

</div>
<script>
jQuery(function($) {
	console.log(location.hostname);
    $('.submenu li.active').removeClass("active open");
    $('.nav-list li.active').removeClass("active open");
    $('.loghourcoin').addClass("active");
    $('.loghourcoin').parent('ul').parent('li').addClass("active open");
     
   //logfirstorders
});
</script>