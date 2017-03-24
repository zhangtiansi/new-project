<?php

use yii\helpers\Html;
use app\models\User;
use app\models\GmPlayerInfo;

/* @var $this yii\web\View */
/* @var $model app\models\LogCustomer */

$this->title = '充值';
$this->params['breadcrumbs'][] = ['label' => 'Log Customers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-customer-create">
    <h1><?= Html::encode($this->title) ?></h1>

<div class="col-sm-12">
<div class="col-sm-5">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    </div>
    <div class="col-sm-7">
    <h3>玩家详情</h3>
    <?php 
    $modelp = GmPlayerInfo::findOne($model->gid);
    $ht = html::tag("p","VIP:".$modelp->power);
    $ht .= html::tag("p","金币:".$modelp->money);
    $ht .= html::tag("p","保险箱:".$modelp->point_box);
    $ht .= html::tag("p","钻石:".$modelp->point);
    $ht .= html::tag("p","魅力值:".$modelp->charm);
    $ht .= html::tag("p","创建:".date('Y-m-d H:i:s',$modelp->create_time));
    $ht .= html::tag("p","最后登录:".date('Y-m-d H:i:s',$modelp->last_login));
    $ht .= html::tag("p","战绩：".$modelp->playerFlag->win."胜/".$modelp->playerFlag->lose."负 胜率：".Yii::$app->formatter->asPercent($modelp->playerFlag->win==0?0:($modelp->playerFlag->win/($modelp->playerFlag->win+$modelp->playerFlag->lose)),2));
    $orderinfo  =GmPlayerInfo::getOrderinfo($modelp->account_id);
    if (isset($orderinfo) && count($orderinfo)>0){
        $ht .= html::tag("p","充值 ：".$orderinfo['num']." 笔，共 ".$orderinfo['cash']."元");
    }else{
        $ht .= html::tag("p","充值 ：无");
    }
    $ar=GmPlayerInfo::getLoginfo($model->gid);
    if (count($ar)>0){
        $tx='<table class="table table-striped table-bordered detail-view">
    		            <tbody>
    		            <tr>
                        <td>时间</td>
                        <td>版本</td>
                        <td>手机型号</td>
                        <td>手机号码</td>
                        <td>IME</td>
                        <td>渠道</td>
                        <td>IP</td>
                        </tr>';
        foreach ($ar as $loginfo){
            $tx.='<tr>';
            $tx.='<td>'.$loginfo['ctime'].'</td>';
            $tx.='<td>'.$loginfo['osver'].'</td>';
            $tx.='<td>'.$loginfo['appver'].'</td>';
            $tx.='<td>'.$loginfo['lineNo'].'</td>';
            $tx.='<td>'.$loginfo['dev_id'].'</td>';
            $tx.='<td>'.$loginfo['channel'].'</td>';
            $tx.='<td>'.$loginfo['request_ip'].'</td>';
            $tx.='</tr>';
        }
        $tx.='</tbody></table>';
        $ht .= html::tag("div","最近5次登录信息:".$tx);
    }else {
        $ht .= html::tag("div","暂无登录信息" );
    }
    
    echo $ht;
    ?>
    </div>
</div>
</div>
