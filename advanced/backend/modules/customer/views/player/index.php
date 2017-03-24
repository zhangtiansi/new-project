<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;
use app\models\GmPlayerInfo;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GmPlayerInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '玩家信息';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gm-player-info-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'account_id',
            'name',
            [
            'label'=>'基本信息',
            'format'=>'raw',
                'value'=>function($model) {
                    
                    $ht = html::tag("p","VIP:".$model->power);
                    $ht .= html::tag("p","金币:".$model->money);
                    $ht .= html::tag("p","保险箱:".$model->point_box);
                    $ht .= html::tag("p","钻石:".$model->point);
                    $ht .= html::tag("p","魅力值:".$model->charm);
                    $ht .= html::tag("p","创建:".date('Y-m-d H:i:s',$model->create_time));
                    $ht .= html::tag("p","最后登录:".date('Y-m-d H:i:s',$model->last_login));
                    return $ht;
                },
            	],
            	[
            	'label'=>'游戏信息',
            	    'format'=>'raw',
            	    'value'=>function($model) {
                	    $ht = html::tag("p","战绩：".$model->playerFlag->win."胜/".$model->playerFlag->lose."负 胜率：".Yii::$app->formatter->asPercent($model->playerFlag->win==0?0:($model->playerFlag->win/($model->playerFlag->win+$model->playerFlag->lose)),2));
                	    $orderinfo  =GmPlayerInfo::getOrderinfo($model->account_id);
                	    if (isset($orderinfo) && count($orderinfo)>0){
                	        $ht .= html::tag("p","充值 ：".$orderinfo['num']." 笔，共 ".$orderinfo['cash']."元");
                	    }else{
                	       $ht .= html::tag("p","充值 ：无");
                	    }
                	    $ar=GmPlayerInfo::getLoginfo($model->account_id);
                	    if (count($ar)>0){
                	        $tx=html::tag("p","时间:".$ar[0]['ctime']);
                	        $tx.=html::tag("p","版本:".$ar[0]['osver']);
                	        $tx.=html::tag("p","手机型号:".$ar[0]['appver']);
                	        $tx.=html::tag("p","手机号码:".$ar[0]['lineNo']);
                	        $tx.=html::tag("p","IME:".$ar[0]['dev_id']);
                	        $tx.=html::tag("p","渠道:".$ar[0]['channel']);
                	        $tx.=html::tag("p","IP:".$ar[0]['request_ip']);
                	        $ht .= html::tag("p","最近登录信息:".$tx);
                	    }else {
                	        $ht .= html::tag("p","暂无登录信息" );
                	    }
            	        return $ht;
            	},
            	],
            [
            'label' => "操作",
                'format' => 'raw',
                'value' => function($model) {
                     $ht = Html::tag('p',Html::a('<i class="icon-gift"></i>赠送', "#", ["data-player"=>$model->account_id,'class' => 'gift btn btn-success']) );
                     $ht.=Html::tag('p',Html::a('<i class="icon-edit"></i>修改', "#", ["data-player"=>$model->account_id,'class' => 'mod btn btn-warning'])) ;
                     $ht.=Html::tag('p',Html::a('<i class="icon-credit-card"></i>订单', "#", ["data-player"=>$model->account_id,'class' => 'order btn btn-info']) );
                    $ht.=Html::tag('p',Html::a('<i class="icon-calendar"></i>日志', "#", ["data-player"=>$model->account_id,'class' => 'login btn btn-success']) );
                    return $ht;
                    },
                'contentOptions'=>['style'=>'max-width: 100px;'],
                                ],
        ],
    ]); ?>

</div>

<script>
jQuery(function($) {
	console.log(location.hostname);
    $('li.active').removeClass("active open");
    $('.customerplayer').addClass("active");
    $('.customerplayer').parent('ul').parent('li').addClass("active open");
    $('.gift').click(function(){
          location.href='http://'+location.hostname+'/customer/customer/create?uid='+$(this).data("player");
    });
    $('.mod').click(function(){
    	location.href='http://'+location.hostname+'/customer/player/view?id='+$(this).data("player");
    });
    $('.order').click(function(){
        
    });
    $('.login').click(function(){
        
    });
});
</script>