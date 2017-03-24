<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GmOrderlistSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '订单列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gm-orderlist-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['attribute'=>'playerid',
            'format'=>'raw',
            'value'=>function($model){
                $hx="  ";
                $hx.= "UID:".$model->playerid.Html::a("昵称：".$model->player->name,'/zjhadmin/player/view?id='.$model->playerid,['class'=>'btn btn-minier btn-purple modify','data-aid'=>$model->playerid]);
                if (is_object($model->player)){
                    $hx.= $model->player->status==98?" <<Agent帐号>>":"";
                }
                return $hx;
            }],
            ['label'=>'VIP',
                'format'=>'raw',
                'value'=>function($model){
                    return ($model->player->power)?$model->player->power:"0";
                },
            ],
            ['label'=>'渠道','format'=>'raw',
                'value'=>function($model){
                    if (is_object($model->account->channels))
                        return ($model->account->channels->channel_name)?$model->account->channels->channel_name:"未知";
                    else 
                        return $model->account->reg_channel;
                 }
             ],
            'orderid',
            'productid',
            'reward',
            'coin',
            'source',
            'fee',
            ['attribute'=>'status',
                'value'=>function($model){
                    $st=[ '创建','支付中','已支付'];
                    return $st[$model->status];
                },
            ],
            'ctime',
            'utime',
            'vipcard_g',
            'vipcard_s',
            'vipcard_c',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
<script>
jQuery(function($) {
	console.log(location.hostname);
    $('.submenu li.active').removeClass("active open");
    $('.nav-list li.active').removeClass("active open");
    $('.logorders').addClass("active");
    $('.logorders').parent('ul').parent('li').addClass("active open");
     
    $( "#idstart_tm" ).datepicker({
    	dateFormat:'yy-mm-dd',
		showOtherMonths: true,
		selectOtherMonths: false,
		//isRTL:true,

		
		/*
		changeMonth: true,
		changeYear: true,
		
		showButtonPanel: true,
		beforeShow: function() {
			//change button colors
			var datepicker = $(this).datepicker( "widget" );
			setTimeout(function(){
				var buttons = datepicker.find('.ui-datepicker-buttonpane')
				.find('button');
				buttons.eq(0).addClass('btn btn-xs');
				buttons.eq(1).addClass('btn btn-xs btn-success');
				buttons.wrapInner('<span class="bigger-110" />');
			}, 0);
		}
*/
	});
    $( "#idend_tm" ).datepicker({
    	dateFormat:'yy-mm-dd',
		showOtherMonths: true,
		selectOtherMonths: false,
		//isRTL:true,

		
		/*
		changeMonth: true,
		changeYear: true,
		
		showButtonPanel: true,
		beforeShow: function() {
			//change button colors
			var datepicker = $(this).datepicker( "widget" );
			setTimeout(function(){
				var buttons = datepicker.find('.ui-datepicker-buttonpane')
				.find('button');
				buttons.eq(0).addClass('btn btn-xs');
				buttons.eq(1).addClass('btn btn-xs btn-success');
				buttons.wrapInner('<span class="bigger-110" />');
			}, 0);
		}
*/
	});

});                
</script>