<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GmChannelInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '渠道信息';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gm-channel-info-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新增渠道', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::tag('p','渠道方登录地址<span class="red"> '.Yii::$app->getRequest()->hostInfo.'/channel/site/login  </span>        Tips:测试时先右上角退出登录') ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//         'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'cid',
            'channel_name',
//             'channel_desc',
//             'any_channel',
//             'opname',
//             'oppasswd',
//             'status',
            'cur_version',
            [
            'attribute' => 'update_url',
            'value' => function($model){
                return Html::a($model->update_url,$model->update_url,['style'=>'width: 180px; word-break: break-word; ']);
             },
            'format'=>'raw',
             ],
//             'update_url:url',
            'version_code',
//             'changelog:ntext',
//             'force',
//             'p_user',
//             'p_recharge',
//             'p_gm',
            ['label'=>'支付方式',
            'format'=>'raw',
            'value'=>function($model){
                $hx=$model->pay_method==0?"默认":"爱贝支付"; 
                return $hx;
            },],
            [
                'attribute'=>'ipay',
                'value'=>'iapparam.appdesc',
            ],
//             'ipay',
            ['label'=>'ios审核状态',
                'format'=>'raw',
                'value'=>function($model){
                    $hx=$model->inreviewstat==0?"非审核状态":html::tag('p',"正在审核(屏蔽点当赠送开启IPV6)",['style'=>'color:red']);
                    return $hx;
                },],
            
//             'ctime',
            ['label'=>'登录帐号','value'=>'account.username'],
//             ['label'=>'操作',
//             'format'=>'raw',
//             'value'=>function($model){
//                 $hx="  ";
//                 $hx.= Html::a('修改','#',['class'=>'btn btn-minier btn-purple modify','data-aid'=>$model->cid]);
//                 $hx.= Html::a('查看详细','#',['class'=>'btn btn-minier btn-purple modify','data-aid'=>$model->cid]);
//                 $hx.="  ";
//                 return $hx;
//             },],
            [
                'label'=>'操作',
                'value' => function ($model, $key, $index, $column) {
                $hx="  ";
                $hx.= Html::a("修改", ['update', 'id' => $key],['class'=>'btn btn-minier btn-purple']); 
                $hx.="  ";
                $hx.= Html::a("查看详细", ['view', 'id' => $key],['class'=>'btn btn-minier btn-info']); 
                return $hx;
            },
            'format' => 'raw',
            ],
//             ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
<script>
jQuery(function($) {
	console.log(location.hostname);
    $('.submenu li.active').removeClass("active open");
    $('.nav-list li.active').removeClass("active open");
    $('.ops-channel').addClass("active");
    $('.ops-channel').parent('ul').parent('li').addClass("active open");
    $( ".modify" ).on('click', function(e) {
    	location.href='http://'+location.hostname+'/zjhadmin/channel/update?id='+$(this).data("aid");
        });
});
</script>