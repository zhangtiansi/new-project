<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\GmPlayerInfo;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LogCoinRecordsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '金币变更记录';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-coin-records-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= Html::a('导出', Yii::$app->getRequest()->getAbsoluteUrl()."&ctype=export", ['class' => 'btn btn-primary']) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
//             'id',
            'uid',
            'c_name', 
//             ['attribute'=>'uid',
//                 'format'=>'raw',
//                 'value'=>function($model){
//                     $hx="  ";
//                     $hx.= "UID:".Html::a($model->uid,'/zjhadmin/player/view?id='.$model->uid,['class'=>'btn btn-minier btn-purple modify','data-aid'=>$model->uid]);
//                     return $hx;
//             }],  
            'change_before',
            'change_coin',
            'change_after',
            'game_no',
            'prop_id',
            'ctime',
//             'card_num',
//             'card_type',
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