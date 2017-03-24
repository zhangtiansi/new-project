<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LogHourPlayerinfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '每小时玩家信息';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-hour-playerinfo-index">

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
                $hx.= "gid:".$model->gid.Html::a("当前信息",'/zjhadmin/player/view?id='.$model->gid,['class'=>'btn btn-minier btn-purple modify','data-aid'=>$model->gid]);
                return $hx;
            }],
            'name',
            'point',
            'money',
            'level',
            'power',
            'charm',
            'chour',
        ],
    ]); ?>

</div>
<script>
jQuery(function($) {
	console.log(location.hostname);
    $('.submenu li.active').removeClass("active open");
    $('.nav-list li.active').removeClass("active open");
    $('.loghourplayer').addClass("active");
    $('.loghourplayer').parent('ul').parent('li').addClass("active open");
     
   //logfirstorders
});
</script>