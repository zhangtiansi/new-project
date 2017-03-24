<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\GmPlayerInfo;
use app\models\GmChannelInfo;

/* @var $this yii\web\View */
/* @var $model app\models\GmPlayerInfo */

$this->title = '用户信息：'.$model->name.", ID：".$model->account_id;
$this->params['breadcrumbs'][] = ['label' => 'Gm Player Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gm-player-info-view">

    <h1><?= Html::encode($this->title) ?></h1>
<div class="col-sm-12">
<div class="col-sm-3">
    <p>
    <?= Html::img('http://g.koudaishiji.com/images/avatars/'.$model->account_id.'.jpg',['height'=>'100px','width'=>'100px'])?>
       
    </p>
    <?= Html::a('充值记录',['/agent/order','gid'=>$model->account_id],['class'=>'btn btn-warning btn-xs']);?>
    <?php echo Html::a('金币记录',['/agent/logcoin','gid'=>$model->account_id],['class'=>'btn btn-info btn-xs']);?>
    <?php // echo Html::a('登录记录',['/agent/login','gid'=>$model->account_id],['class'=>'btn btn-primary btn-xs']);?>
    <p></p>
    <br>
</div>
<div class="col-sm-8">


<div >
	<span class="btn btn-app btn-sx btn-light no-hover">
		<span class="line-height-1 bigger-150 red"> <?=$model->power ?></span>
		<br>
		<span class="line-height-1 smaller-90"> VIP </span>
	</span>

	<span class="btn btn-app btn-sx btn-yellow no-hover">
		<span class="line-height-1 bigger-35"> <?= Yii::$app->formatter->asInteger($model->money) ?> </span>

		<br>
		<span class="line-height-1 smaller-90"> 金币 </span>
	</span>

	<span class="btn btn-app btn-sx btn-pink no-hover">
		<span class="line-height-1 bigger-35"> <?= Yii::$app->formatter->asInteger($model->point_box) ?> </span>

		<br>
		<span class="line-height-1 smaller-90"> 保险箱 </span>
	</span>

	<span class="btn btn-app btn-sx btn-grey no-hover">
		<span class="line-height-1 bigger-35"> <?= Yii::$app->formatter->asInteger($model->point) ?> </span>

		<br>
		<span class="line-height-1 smaller-90"> 钻石 </span>
	</span>

	<span class="btn btn-app btn-sx btn-success no-hover">
		<span class="line-height-1 bigger-35"> <?= Yii::$app->formatter->asInteger($model->charm) ?> </span>

		<br>
		<span class="line-height-1 smaller-90"> 魅力值 </span>
	</span>
	</div>
    

</div>
</div>
<div class="row col-sm-12">
<?php 
$htx="";
$orderinfo  =GmPlayerInfo::getOrderinfo($model->account_id);
if (isset($orderinfo) && count($orderinfo)>0){
    $htx .= html::tag("p","充值 ：".$orderinfo['num']." 笔，共 ".$orderinfo['cash']."元");
}else{
    $htx .= html::tag("p","充值 ：无");
}
$htc="";
$ar=GmPlayerInfo::getLoginfo($model->account_id);
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
    $htc .= html::tag("div","最近5次登录信息:".$tx);
}else {
    $htc .= html::tag("div","暂无登录信息" );
}
?>
<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            ['label'=>'战绩 </br>',
                'format'=>'raw',
            'value'=>$model->playerFlag->win."胜/".$model->playerFlag->lose."负 胜率：".Yii::$app->formatter->asPercent($model->playerFlag->win==0?0:($model->playerFlag->win/($model->playerFlag->win+$model->playerFlag->lose)),2),
            ],
            ['label'=>'充值信息</br>',
                'format'=>'raw',
                'value'=>$htx,
            ],
            ['label'=>'登录用户名',
                'value'=>$model->playerAccount->account_name,
            ],
//             ['label'=>'密保问题',
//             'value'=>$model->playerAccount->pwd_q,
//             ],
//             ['label'=>'密保答案',
//             'value'=>$model->playerAccount->pwd_a,
//             ],
            ['label'=>'SIM卡序列号',
            'value'=>$model->playerAccount->sim_serial,
            ],
            ['label'=>'IME/安卓设备号',
            'value'=>$model->playerAccount->device_id,
            ],
            ['label'=>'UUID',
            'value'=>$model->playerAccount->op_uuid,
            ],
            ['label'=>'帐号类型',
            'value'=>$model->playerAccount->type,
            ],
            ['label'=>'注册渠道',
            'value'=>GmChannelInfo::findChannelNamebyid($model->playerAccount->reg_channel),
            ],
            ['label'=>'注册时间',
            'value'=>$model->playerAccount->reg_time,
            ],
            ['label'=>'帐号状态',
            'value'=>$model->playerAccount->status,
            ],
            ['label'=>' 最近登录 </br>',
                'format'=>'raw',
                'value'=>$htc
            ],
        ],
    ]) ?>
</div>
</div>