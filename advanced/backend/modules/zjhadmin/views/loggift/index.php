<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\GmPlayerInfo;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LogGiftSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '礼物记录';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-gift-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//         'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
//             ['attribute'=>'from_uid','value'=>'fromplayer.name'],
            ['attribute'=>'from_uid',
            'format'=>'raw',
            'value'=>function($model){
                $hx="  ";
                $hx.= Html::a("UID:".$model->from_uid."昵称：".GmPlayerInfo::getNickbyId($model->from_uid),'/zjhadmin/player/view?id='.$model->from_uid,['class'=>'btn btn-minier btn-purple modify','data-aid'=>$model->from_uid]);
                if (is_object($model->fromplayer)){
                    $hx.= $model->fromplayer->status==98?" <<Agent帐号>>":"";
                }
                return $hx;
            },],
            ['attribute'=>'to_uid',
            'format'=>'raw',
            'value'=>function($model){
                $hx="  ";
                $hx.= Html::a("UID:".$model->to_uid."昵称：".GmPlayerInfo::getNickbyId($model->to_uid),'/zjhadmin/player/view?id='.$model->to_uid,['class'=>'btn btn-minier btn-purple modify','data-aid'=>$model->to_uid]);
                $hx.="  ";
                return $hx;
            },],
            ['attribute'=>'gift_id','value'=>'gift.prop_name'],
            'gift_num',
            'ctime',
        ],
    ]); ?>

</div>
<script>
jQuery(function($) {
	console.log(location.hostname);
    $('.submenu li.active').removeClass("active open");
    $('.nav-list li.active').removeClass("active open");
    $('.loggfit').addClass("active");
    $('.loggfit').parent('ul').parent('li').addClass("active open");
});
</script>
