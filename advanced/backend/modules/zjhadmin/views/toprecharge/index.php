<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GmAccountInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '个人充值数据';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="toprecharge">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//         'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['attribute'=>'gid',
                'format'=>'raw',
                'value'=>function($model){
                    return Html::a($model->gid,'#',['class'=>'btn btn-minier btn-purple clickplayerinfo','data-gid'=>$model->gid]);
                }
            ],
            'name',
            'vip',
            'reg_time',
            'reg_channel',
            'last_login',
            ['attribute'=>'TotalFee',
                'value'=>function($model){
                  return Yii::$app->formatter->asInteger($model->TotalFee)."元";
                }
            ],
//             'TotalFee',
            ['attribute'=>'XiancaoBack',
                'value'=>function($model){
                    return Yii::$app->formatter->asInteger($model->XiancaoBack)."元";
                }
            ],
//             'XiancaoBack',
            ['attribute'=>'TotalCost',
                'value'=>function($model){
                    return Yii::$app->formatter->asInteger($model->TotalCost)."元";
                }
            ],
//             'TotalCost',
            'XiancaoBackNum',
            ['attribute'=>'ClientFee',
                'value'=>function($model){
                    return Yii::$app->formatter->asInteger($model->ClientFee)."元";
                }
            ],
//             'ClientFee',
            'ClientFeeNum',
//             'BackendFee',
            ['attribute'=>'BackendFee',
                'value'=>function($model){
                    return Yii::$app->formatter->asInteger($model->BackendFee)."元";
                }
            ],
            'BackendFeeNum',
//             'XiancaoFee',
            ['attribute'=>'XiancaoFee',
                'value'=>function($model){
                    return Yii::$app->formatter->asInteger($model->XiancaoFee)."元";
                }
            ],
            'XiancaoFeeNum'
        ],
    ]); ?>

</div>
<script>
jQuery(function($) {
	console.log(location.hostname);
    $('.submenu li.active').removeClass("active open");
    $('.nav-list li.active').removeClass("active open");
    $('.toprecharge').addClass("active");
    $('.toprecharge').parent('ul').parent('li').addClass("active open");
    $('.mod').click(function(){
    	location.href='http://'+location.hostname+'/zjhadmin/player/view?id='+$(this).data("player");
    });
    $('.order').click(function(){
    	location.href='http://'+location.hostname+'/zjhadmin/order/index?gid='+$(this).data("player");
    }); 
});
</script>