<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GmAccountInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '胜率过高号';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="winmuch">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>当前筛选 胜率超过70% 局数超过30局</p>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//         'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
//             'gid',
            ['attribute'=>'gid',
                'format'=>'raw',
                'value'=>function($model){
                    return Html::a($model->gid,'#',['class'=>'btn btn-minier btn-purple clickplayerinfo','data-gid'=>$model->gid]);
                }
            ],
            'name',
            [
                'label'=>'胜负',
                'format'=>'raw',
                'value'=>function($model){
                    return Html::tag('p',$model->win.'胜/'.$model->lose."负");
                }
            ],
           'win',
           'lose',
            'last_login',
            'power',
            'money', 
            'reg_time',
            'reg_channel',
        ],
    ]); ?>

</div>
<script>
jQuery(function($) {
	console.log(location.hostname);
    $('.submenu li.active').removeClass("active open");
    $('.nav-list li.active').removeClass("active open");
    $('.winmuch').addClass("active");
    $('.winmuch').parent('ul').parent('li').addClass("active open");
});
</script>