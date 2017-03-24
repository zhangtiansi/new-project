<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\User;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SysOplogsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '我的操作日志';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-oplogs-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'ctime',
//             'keyword',
             ['attribute'=>'cid',
                 'format'=>'raw',
                'value'=>function($model){
                return Html::a('赠送记录id:'.$model->cid,['customer/view','id'=>$model->cid]);
            }],
            ['attribute'=>'gid',
            'format'=>'raw',
            'value'=>function($model){
                return Html::a('玩家id:'.$model->gid,['player/view','id'=>$model->gid]);
            }],
            'logs',
            'desc',
        ],
    ]); ?>

</div>
<script>
jQuery(function($) {
	console.log(location.hostname);
    $('li.active').removeClass("active open");
    $('.opslogs').addClass("active");
    $('.opslogs').parent('ul').parent('li').addClass("active open");
});
</script>
    