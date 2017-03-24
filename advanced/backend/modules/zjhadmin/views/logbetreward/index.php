<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\GmPlayerInfo;
use app\models\LogBetlog;
use app\models\LogBetResults;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LogBetRewardSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '时时乐返奖';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-bet-reward-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'bid',
            ['attribute'=>'bettype',
            'format'=>'raw',
            'value'=>function($model){
                return LogBetResults::$px[$model->bettype];
            },],
            ['attribute'=>'gid',
            'format'=>'raw',
            'value'=>function($model){
                $hx="  ";
                $hx.= Html::a("UID:".$model->gid."昵称：".GmPlayerInfo::getNickbyId($model->gid),'/zjhadmin/player/view?id='.$model->gid,['class'=>'btn btn-minier btn-purple modify','data-aid'=>$model->gid]);
                
                return $hx;
            },],
            ['attribute'=>'reward',
            'format'=>'raw',
            'value'=>function($model){
                return Yii::$app->formatter->asDecimal($model->reward/10000,0)."万";
            },],
            'ctime',
            'status',
        ],
    ]); ?>

</div>
<script>
jQuery(function($) {
	console.log(location.hostname);
    $('.submenu li.active').removeClass("active open");
    $('.nav-list li.active').removeClass("active open");
    $('.ops-ssl-reward').addClass("active");
    $('.ops-ssl-reward').parent('ul').parent('li').addClass("active open");
});
</script>