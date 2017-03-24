<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\GmPlayerInfo;
use app\models\GmAccountInfo;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GmAccountInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '帐号信息';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gm-account-info-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//         'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'gid',
            'name',
            'point',
            'power',
            [
                'attribute'=>'total_coin',
                'format' => 'raw',
                'value' => function($model) {
                        $ht=Html::tag('p',"总财富：".Yii::$app->formatter->asDecimal($model->total_coin/10000,2)."万");
                        $ht.=Html::tag('p',"携带：".Yii::$app->formatter->asDecimal($model->money/10000,2)."万");
                        $ht.=Html::tag('p',"保险箱：".Yii::$app->formatter->asDecimal($model->point_box/10000,2)."万");
                        $ht.=Html::tag('p',"VIP：".$model->power);
                    return $ht;
                },
            ],
//             'money',
//             'point_box',
//             'total_coin',
//             'level',
//             'power',
//             'win',
//             'lose',
//             'account_name',
//             'pwd_q',
//             'pwd_a',
            [
                'attribute'=>'last_login',
                'format' => 'raw',
                'value' => function($model) {
                    $ht=Html::tag('p',"最后登录时间：".$model->last_login);
                    $ht.=Html::tag('p',"注册时间：".$model->reg_time);
                    $ht.=Html::tag('p',"注册渠道：".$model->reg_channel);
                    $ht.=Html::tag('p',"注册帐号：".$model->account_name);
                    $ht.=Html::tag('p',"注册ime：".$model->ime);
                    $ar = GmAccountInfo::getImeAccounts($model->ime);
                    if(count($ar)>0){
                        $ht.="同设备帐号信息<br>";
                        foreach ($ar as $acc){
                            if (is_object($acc->player)){
                                $wd =  "UID:".$acc->gid.Html::a("昵称：".$acc->player->name,'/agent/player/view?id='.$acc->gid,['class'=>'btn btn-minier btn-purple modify','data-aid'=>$acc->gid]);
                                $wd.="vip:".$acc->player->power." 总金币：".$acc->player->total_coin."";
                                $ht.=Html::tag('p',$wd);
                            }
                        }
                    }
                    return $ht;
                },
            ],
//             'ime',
//             'op_uuid',
//             'reg_channel',
//             'reg_time' ,
//             'last_login',
//             'account_status',
                [
                'label'=>'游戏信息',
                    'format'=>'raw',
                    'value'=>function($model) {
                    $ht = html::tag("p","战绩：".$model->win."胜/".$model->lose."负 胜率：".Yii::$app->formatter->asPercent($model->win==0?0:($model->win/($model->win+$model->lose)),2));
                    $orderinfo  =GmPlayerInfo::getOrderinfo($model->gid);
                if (isset($orderinfo) && count($orderinfo)>0){
                $ht .= html::tag("p","充值 ：".$orderinfo['num']." 笔，共 ".Yii::$app->formatter->asDecimal($orderinfo['cash'],0)."元");
                }else{
                    $ht .= html::tag("p","充值 ：无");
                }
                $gft = GmPlayerInfo::getAgentOrderinfo($model->gid);
                if(count($gft)>0){
                    $ht .= html::tag("p","Agent 仙草 ：".Yii::$app->formatter->asDecimal($gft['cash'],0)." 元");
                }else{
                    $ht .= html::tag("p","Agent 仙草 ：无");
                }
                $gftbk = GmPlayerInfo::getAgentOrderBackinfo($model->gid);
                if(count($gftbk)>0){
                    $ht .= html::tag("p","Agent 仙草back ：".Yii::$app->formatter->asDecimal($gftbk['cash'],0)." 元");
                }else{
                    $ht .= html::tag("p","Agent 仙草back ：无");
                }
                $bkAgent = GmPlayerInfo::getAgentBackendinfo($model->gid);
                if(count($bkAgent)>0){
                    $ht .= html::tag("p","AGENT backend充值 ：".$bkAgent['num']." 笔，共 ".Yii::$app->formatter->asDecimal($bkAgent['cash'],0)."元");
                }else{
                    $ht .= html::tag("p","AGENT backend充值 ：无");
                }
                        $ar=GmPlayerInfo::getLoginfo($model->gid);
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
                    $ht = Html::tag('p',Html::a('<i class="icon-gift"></i>赠送', "#", ["data-player"=>$model->gid,'class' => 'gift btn btn-success']) );
                        $ht.=Html::tag('p',Html::a('<i class="icon-edit"></i>详细', "#", ["data-player"=>$model->gid,'class' => 'mod btn btn-warning'])) ;
                        $ht.=Html::tag('p',Html::a('<i class="icon-credit-card"></i>订单', "#", ["data-player"=>$model->gid,'class' => 'order btn btn-info']) );
                        $ht.=Html::tag('p',Html::a('<i class="icon-calendar"></i>日志', "#", ["data-player"=>$model->gid,'class' => 'login btn btn-success']) );
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
    $('.submenu li.active').removeClass("active open");
    $('.nav-list li.active').removeClass("active open");
    $('.customerplayer').addClass("active");
    $('.customerplayer').parent('ul').parent('li').addClass("active open");
    $('.gift').click(function(){
        location.href='http://'+location.hostname+'/agent/customer/create?uid='+$(this).data("player");
    });
    $('.mod').click(function(){
    	location.href='http://'+location.hostname+'/agent/player/view?id='+$(this).data("player");
    });
    $('.order').click(function(){
    	location.href='http://'+location.hostname+'/agent/order/index?gid='+$(this).data("player");
    });
    $('.login').click(function(){
    	location.href='http://'+location.hostname+'/agent/logrequest/index?gid='+$(this).data("player");
    });
});
</script>