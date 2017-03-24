<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\GmPlayerInfo;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LogBetlogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '押注记录';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-betlog-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'account_id',
            ['attribute'=>'account_id',
            'format'=>'raw',
            'value'=>function($model){
                $hx="  ";
                $hx.= Html::a("UID:".$model->account_id."昵称：".GmPlayerInfo::getNickbyId($model->account_id),'/zjhadmin/player/view?id='.$model->account_id,['class'=>'btn btn-minier btn-purple modify','data-aid'=>$model->account_id]);
                return $hx;
            },],
            'bet_1',
            'bet_2',
            'bet_3',
            'bet_4',
            'bet_5',
            'bet_6',
            'mark',
            'bid',
        ],
    ]); ?>

</div>

<script>
jQuery(function($) {
	console.log(location.hostname);
    $('.submenu li.active').removeClass("active open");
    $('.nav-list li.active').removeClass("active open");
    $('.ops-ssl-bet').addClass("active");
    $('.ops-ssl-bet').parent('ul').parent('li').addClass("active open");
});
</script>
