<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\GmPlayerInfo;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LogCustomerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '后台赠送记录';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-customer-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//         'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
//             'gid',
            ['attribute'=>'gid',
            'format'=>'raw',
            'value'=>function($model){
                $hx="  ";
                $hx.= Html::a("UID:".$model->gid."昵称：".GmPlayerInfo::getNickbyId($model->gid),'/zjhadmin/player/view?id='.$model->gid,['class'=>'btn btn-minier btn-purple modify','data-aid'=>$model->gid]);
                if (is_object($model->player)){
                    $hx.= $model->player->status==98?" <<Agent帐号>>":"";
                }
                return $hx;
            },],
            'point',
//             'coin',
            ['attribute'=>'coin',
            'format'=>'raw',
            'value'=>function($model){
                $hx="  ";
                $hx.= Html::tag("p",$model->coin."=>".Yii::$app->formatter->asDecimal($model->coin/80000,0)."RMB");
                return $hx;
            },],
//             'propid',
            ['attribute'=>'propid','value'=>'gift.prop_name'],
            'propnum',
            'card_g',
            'card_s',
            'card_c',
            ['attribute'=>'status','value'=>function($model){
                        return $model->status==2?"赠送成功":"创建成功";
                    }
                ],
            'ctime',
//             'ops',
            ['attribute'=>'ops','value'=>'opuser.userdisplay'],
            'desc',
        ],
    ]); ?>

</div>
<script>
jQuery(function($) {
	console.log(location.hostname);
    $('.submenu li.active').removeClass("active open");
    $('.nav-list li.active').removeClass("active open");
    $('.log-customer').addClass("active");
    $('.log-customer').parent('ul').parent('li').addClass("active open");
});
</script>