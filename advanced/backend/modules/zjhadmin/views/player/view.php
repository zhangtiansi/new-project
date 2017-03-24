<script src="http://cdn.hcharts.cn/highcharts/highcharts.js"></script> 

<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\GmPlayerInfo;
use app\models\GmChannelInfo;
use app\models\LogBlacklist;
use app\models\GmAccountInfo;
use app\models\User;
/* @var $this yii\web\View */
/* @var $model app\models\GmPlayerInfo */

$this->title = '用户信息：'.$model->name.", ID：".$model->account_id." VIP :".$model->power ;
$allcoin = $model->money+$model->point_box;
if ($allcoin>100000000)
{
    $allcoin=Yii::$app->formatter->asDecimal($allcoin/100000000,3)."亿金币";
}elseif ($allcoin>10000){
    $allcoin=Yii::$app->formatter->asDecimal($allcoin/10000,3)."万金币";
} 
$htx="";
$recharge = GmPlayerInfo::getRechargeInfo($model->account_id);
if(count($recharge)>0){
    $htx.=html::tag("p","净支出:".Yii::$app->formatter->asDecimal($recharge['allcash'],0)."元");
    $htx.=html::tag("p","总回:".$recharge['backnum']." 笔，共 ".Yii::$app->formatter->asDecimal($recharge['backcash'],0)."元");
    $htx.=html::tag("p","客户端:".$recharge['clientnum']." 笔，共 ".Yii::$app->formatter->asDecimal($recharge['clientcash'],0)."元");
    $htx.=html::tag("p","后台:".$recharge['agentnum']." 笔，共 ".Yii::$app->formatter->asDecimal($recharge['agentcash'],0)."元");
    $htx.=html::tag("p","仙草:".$recharge['xiancaonum']." 笔，共 ".Yii::$app->formatter->asDecimal($recharge['xiancaocash'],0)."元");
}

$opu = User::findOne(Yii::$app->user->id);
$pw="";
if ($opu->checkRole(User::ROLE_ADMIN))
    $pw= $model->playerAccount->pwd_q.'/'.$model->playerAccount->pwd_a;
else
    $pw= "联系运营获取";
$this->params['breadcrumbs'][] = ['label' => 'Gm Player Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gm-player-info-view">
 
    <h1><?= Html::encode($this->title) ?></h1>
<div class="col-sm-12">
    <div class="col-sm-4  "> 
        <?= Html::img('http://g.koudaishiji.com/images/avatars/'.$model->account_id.'.jpg',['height'=>'100px','width'=>'100px'])?>
         <p>
         <?php $user = User::findIdentity(Yii::$app->user->id);
                if (is_object($user) && $user->checkRole(User::ROLE_ADMIN)):  ?>
         <?= Html::a('更新信息', ['update', 'id' => $model->account_id], ['class' => 'btn-primary btn btn-sx ']) ?>
         <?php endif;?>
            <?= Html::a('重置头像', "#", ['class' => 'btn-error btn btn-sx reset-avatar','data-gid'=>$model->account_id]) ?>
        </p>
        <?= Html::a('充值记录',['/zjhadmin/order','gid'=>$model->account_id],['class'=>'btn btn-warning btn-sx']);?>
        <?= Html::a('金币记录',['/zjhadmin/logcoin','gid'=>$model->account_id],['class'=>'btn btn-info btn-sx']);?>
        <?= Html::a('登录记录',['/zjhadmin/logrequest','gid'=>$model->account_id],['class'=>'btn btn-primary btn-sx']);?>
        <p></p> 
        
    </div>
    <div class="col-sm-4 ">
        <div style="border: 1px dotted; border-color: #d8d8d8!important;">
        <?= Html::tag('p',"总身家".$allcoin);?>
        <?= Html::tag('p',"携带金币".Yii::$app->formatter->asInteger($model->money));?>
        <?= Html::tag('p',"保险箱金币".Yii::$app->formatter->asInteger($model->point_box));?>
        <?= Html::tag('p',"携带钻石".$model->point);?>  
        </div>  
        <div style="border: 1px dotted; border-color: #d8d8d8!important;">
            <?= $htx;?> 
        </div>  
    </div>
<div class="col-sm-12" id="info-chart">
</div>
<div class="col-sm-12" id="coin-chart">
</div>
</div>
<div class="row col-sm-12">
<?php 

// $orderinfo  =GmPlayerInfo::getOrderinfo($model->account_id);
// if (isset($orderinfo) && count($orderinfo)>0){
//     $ht .= html::tag("p","充值 ：".$orderinfo['num']." 笔，共 ".$orderinfo['cash']."元");
// }else{
//     $ht .= html::tag("p","充值 ：无");
// }
// $orderinfo  =GmPlayerInfo::getOrderinfo($model->account_id);
// if (isset($orderinfo) && count($orderinfo)>0){
//     $htx .= html::tag("p","充值 ：".$orderinfo['num']." 笔，共 ".Yii::$app->formatter->asDecimal($orderinfo['cash'],0)."元");
// }else{
//     $htx .= html::tag("p","充值 ：无");
// }
// $gft = GmPlayerInfo::getAgentOrderinfo($model->account_id);
// if(count($gft)>0){
//     $htx .= html::tag("p","Agent 仙草 ：".$gft['cash']." 元");
// }else{
//     $htx .= html::tag("p","Agent 仙草 ：无");
// }
// $gftbk = GmPlayerInfo::getAgentOrderBackinfo($model->account_id);
// if(count($gftbk)>0){//Yii::$app->formatter->asDecimal(,0)
//     $htx .= html::tag("p","Agent 仙草back ：".$gftbk['cash']." 元");
// }else{
//     $htx .= html::tag("p","Agent 仙草back ：无");
// }
// $bkAgent = GmPlayerInfo::getAgentBackendinfo($model->account_id);
// if(count($bkAgent)>0){
//     $htx .= html::tag("p","AGENT backend充值 ：".$bkAgent['num']." 笔，共 ".Yii::$app->formatter->asDecimal($bkAgent['cash'],0)."元");
// }else{
//     $htx .= html::tag("p","AGENT backend充值 ：无");
// }
 
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
                                    <td>城市</td>
                                    <td>运营商</td>
                                    </tr>';
    foreach ($ar as $loginfo){
        $tx.='<tr>';
        $tx.='<td>'.$loginfo['ctime'].'</td>';
        $tx.='<td>'.$loginfo['osver'].'</td>';
        $tx.='<td>'.$loginfo['appver'].'</td>';
        $tx.='<td>'.$loginfo['lineNo'].'</td>';
        $tx.='<td>'.$loginfo['dev_id'];
        $tx.=LogBlacklist::find()->where(['ime'=>$model->playerAccount->device_id,'status'=>0])->count()==0?
        Html::a("禁止设备登录",'#',['class'=>'btn btn-warning btn-xs black-ime','data-ime'=>$loginfo['dev_id']])
        :Html::a("解除设备黑名单",'#',['class'=>'btn btn-info btn-xs unblack-ime','data-ime'=>$loginfo['dev_id']]).'</td>';
        $tx.='<td>'.$loginfo['channel'].'</td>';
        $tx.='<td>'.$loginfo['request_ip'].'</td>';
        $tx.='<td>'.$loginfo['city'].'</td>';
        $tx.='<td>'.$loginfo['isp'].'</td>';
        
        $tx.='</tr>';
    }
    $tx.='</tbody></table>';
    $htc .= html::tag("div","最近5次登录信息:".$tx);
}else {
    $htc .= html::tag("div","暂无登录信息" );
}
$ar = GmAccountInfo::getImeAccounts($model->playerAccount->device_id);
if(count($ar)>0){
        $ht="同设备帐号信息 共计 ".count($ar)." 条<br>";
    foreach ($ar as $k=>$acc){
        if ($k>100) break; 
        if (is_object($acc->player)){
            $wd =  "UID:".$acc->gid.Html::a("昵称：".$acc->player->name,'/zjhadmin/player/view?id='.$acc->gid,['class'=>'btn btn-minier btn-purple modify','data-aid'=>$acc->gid]);
            $wd.="vip:".$acc->player->power." 总金币：".$acc->player->total_coin."";
            $ht.=Html::tag('p',$wd);
        }
    }
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
                'value'=>$model->playerAccount->status==0?
                $model->playerAccount->account_name.Html::a("禁止帐号登录",'#',['class'=>'btn btn-warning btn-xs black-gid','data-gid'=>$model->playerAccount->gid])
                :$model->playerAccount->account_name.Html::a("解除帐号黑名单",'#',['class'=>'btn btn-info btn-xs unblack-gid','data-gid'=>$model->playerAccount->gid]),
                'format'=>'raw',
            ],
            ['label'=>'密保问题/密保答案',
            'value'=>$pw,
                
                'format'=>'raw',
            ],
            ['label'=>'注册IME/安卓设备号',
                'format'=>'raw',
            'value'=>LogBlacklist::find()->where(['ime'=>$model->playerAccount->device_id,'status'=>0])->count()==0?
                $model->playerAccount->device_id.Html::a("禁止设备登录",'#',['class'=>'btn btn-warning btn-xs black-ime','data-ime'=>$model->playerAccount->device_id])
                :$model->playerAccount->device_id.Html::a("解除设备黑名单",'#',['class'=>'btn btn-info btn-xs unblack-ime','data-ime'=>$model->playerAccount->device_id]),
            ], 
            ['label'=>'帐号类型',
            'value'=>$model->playerAccount->type==0?"帐号注册":"快速进入",
            ],
            ['label'=>'注册渠道',
            'value'=>GmChannelInfo::findChannelNamebyid($model->playerAccount->reg_channel),
            ],
            ['label'=>'注册时间/最后登录',
            'value'=>$model->playerAccount->reg_time.'/'.$model->playerAccount->last_login,
            ],
            ['label'=>'帐号状态',
            'value'=>$model->playerAccount->status==0?"正常":"黑名单不允许登录",
            ],
            ['label'=>' 最近登录 </br>',
                'format'=>'raw',
                'value'=>$htc
            ],
            ['label'=>'同设备帐号 </br>',
            'format'=>'raw',
            'value'=>$ht
            ],
        ],
    ]) ?>
</div>
</div>
<script>
jQuery(function($) {
	
    $( ".black-ime" ).on('click', function(e) {
		e.preventDefault();
	    var ime =$(this).data("ime"); 
	    var csrfToken="<?=Yii::$app->request->csrfToken?>";
		$.ajax({
	       		 type: "GET",
	       		 url: '/zjhadmin/default/blacklist?type=1&ime='+ime,
         		 dataType: "json",
         		 success: function(data) {
         			 console.log(data);
         			 if(data.code == 0 ){//success
         				alert("添加黑名单成功");
						location.reload() ;
         		      }else{
       		    	    alert(data.msg);
                    	}
         		 },
         		error:function(){
    				alert("提交失败，请检查网络");
    		        },
	       		});
	});

    $( ".unblack-ime" ).on('click', function(e) {
		e.preventDefault();
	    var ime =$(this).data("ime"); 
	    var csrfToken="<?=Yii::$app->request->csrfToken?>";
		$.ajax({
	       		 type: "GET",
	       		 url: '/zjhadmin/default/unblacklist?type=1&ime='+ime,
         		 dataType: "json",
         		 success: function(data) {
         			 console.log(data);
         			 if(data.code == 0 ){//success
         				alert("解除黑名单成功");
						location.reload() ;
         		      }else{
         		    	    alert(data.msg);
                  	}
         		 },
         		error:function(){
    				alert("提交失败，请检查网络");
    		        },
	       		});
	});

    $( ".black-gid" ).on('click', function(e) {
		e.preventDefault();
	    var gid =$(this).data("gid"); 
	    var csrfToken="<?=Yii::$app->request->csrfToken?>";
		$.ajax({
	       		 type: "GET",
	       		 url: '/zjhadmin/default/blacklist?type=2&gid='+gid,
         		 dataType: "json",
         		 success: function(data) {
         			 console.log(data);
         			 if(data.code == 0 ){//success
         				alert("添加黑名单成功");
						location.reload() ;
         		      }else{
       		    	    alert(data.msg);
                    	}
         		 },
         		error:function(){
    				alert("提交失败，请检查网络");
    		        },
	       		});
	});

    $( ".unblack-gid" ).on('click', function(e) {
		e.preventDefault();
	    var gid =$(this).data("gid"); 
	    var csrfToken="<?=Yii::$app->request->csrfToken?>";
		$.ajax({
       		 type: "GET",
       		 url: '/zjhadmin/default/unblacklist?type=2&gid='+gid,
     		 dataType: "json",
     		 success: function(data) {
     			 console.log(data);
     			 if(data.code == 0 ){//success
     				alert("解除黑名单成功");
					location.reload() ;
     		      }else{
   		    	    alert(data.msg);
   		    	  }
     		 },
     		error:function(){
				alert("提交失败，请检查网络");
		        },
       		});
	});
	$('.reset-avatar').on('click',function(e) {
		e.preventDefault();
	    var gid =$(this).data("gid"); 
	    var csrfToken="<?=Yii::$app->request->csrfToken?>";
		$.ajax({
       		 type: "GET",
       		 url: '/zjhadmin/player/resetavatar?gid='+gid,
     		 dataType: "json",
     		 success: function(data) {
     			 console.log(data);
     			 if(data.code == 0 ){//success
     				alert("重置头像成功");
					location.reload() ;
     		      }else{
   		    	    alert(data.msg);
   		    	  }
     		 },
     		error:function(){
				alert("提交失败，请检查网络");
		        },
       		});
	});

 
	var player=<?php echo $model->account_id;?>;
	function loadChart(player){
		$.ajax({
			 type: "GET",
			 url: '/zjhadmin/'+player+'/his',
			 dataType: "json",
			 success: function(data) {
				 console.log(data);
				 var xA = [];
				 var xData=[];
				 for (var i in data){
					 var item = data[i];
					 console.log(item[0]);
					 console.log(item[1]);
					xA.push(item[0]);
					xData.push(item[1]);
			     } 
				 $('#info-chart').highcharts({
				        chart: {
				        	borderColor: '#000000',
				            borderWidth: 1,
				            type: 'line'
				        },
				        credits: {
				            text: '离岛游戏',
				            href: 'http://www.outlandjoy.com'
				        },
				        title: {
				            text: '个人金币变更'
				        },
				        xAxis: {
				            categories:xA, 
				        },
				        yAxis: {
				            title: {
				                text: '金币（万）'
				            }
				        },
				        series: [
    						{
    				            name: '总财产',
    				            data: xData
    				        }, 
//     				        {
//     				            name: 'John',
//     				            data: [5, 7, 3]
//     				        }
				        ]
				    });
			 }
			});

	}
	loadChart(player);

	function loadcoinChart(player){
		$.ajax({
			 type: "GET",
			 url: '/zjhadmin/'+player+'/hischange',
			 dataType: "json",
			 success: function(data) {
				 console.log(data); 
				 $('#coin-chart').highcharts({
				        chart: {
				        	borderColor: '#000000',
				            borderWidth: 1,
				            type: 'line'
				        },
				        credits: {
				            text: '离岛游戏',
				            href: 'http://www.outlandjoy.com'
				        },
				        title: {
				            text: '每小时金币变化'
				        },
				        xAxis: {
				            categories:data.xA, 
				        },
				        yAxis: {
				            title: {
				                text: '金币（万）'
				            }
				        },
				        series: data.xData
				    });
			 }
			});

	}
	loadcoinChart(player);
});
</script>