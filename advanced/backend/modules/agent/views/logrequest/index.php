<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\LogBlacklist;
use app\models\GmPlayerInfo;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LogUserrequstSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '玩家登录信息';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-userrequst-index">

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
                $hx="  ";
                if (is_object($model->player)){
                    $hx.= "UID:".$model->gid.Html::a("昵称：".$model->player->name,'/agent/player/view?id='.$model->gid,['class'=>'btn btn-minier btn-purple modify','data-aid'=>$model->gid]);
                    $hx.= $model->player->status==98?" <<Agent帐号>>":"";
                    $hx.= " VIP".$model->player->power;
                }
                return $hx;
            }],
            ['label'=>'登录用户名',
            'value'=>function($model){
                return   $model->accountinfo->account_name;
            },
            'format'=>'raw',
            ],
            [
            'label'=>'充值信息',
                'format'=>'raw',
                'value'=>function($model) {
                $ht = "";
                $orderinfo  =GmPlayerInfo::getOrderinfo($model->gid);
                if (isset($orderinfo) && count($orderinfo)>0){
                    $ht .= html::tag("p","客户端充值 ：".Yii::$app->formatter->asDecimal($orderinfo['num'])." 笔，共 ".Yii::$app->formatter->asDecimal($orderinfo['cash'],0)."元");
                }else{
                    $ht .= html::tag("p","客户端充值 ：无");
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
                return $ht;
            },
            ],
            'osver',
            'appver',
//             'lineNo',
//             'uuid',
//             'simSerial',
//             'dev_id',
            ['label'=>'注册IME/安卓设备号',
                'format'=>'raw',
                'value'=>function($model){
                   return Html::a("查设备登录记录",['/agent/logrequest','ime'=>$model->dev_id],['class'=>'btn btn-info btn-xs ']);
                
                },
            ],
//             'channel',
            ['attribute'=>'channel','value'=>'channelinfo.channel_name'],
            'ctime',
//             'request_ip',
            ['label'=>'登录IP',
            'format'=>'raw',
            'value'=>function($model){
                return Html::a("查IP登录记录",['/agent/logrequest','ip'=>$model->request_ip],['class'=>'btn btn-info btn-xs ']);
        
            },
            ],
            'city',
            'isp',
        ],
    ]); ?>

</div>
<script>
jQuery(function($) {
    $('.submenu li.active').removeClass("active open");
    $('.nav-list li.active').removeClass("active open");
    $('.log-request').addClass("active");
    $('.log-request').parent('ul').parent('li').addClass("active open");
    $( ".black-ime" ).on('click', function(e) {
		e.preventDefault();
	    var ime =$(this).data("ime"); 
	    var csrfToken="<?=Yii::$app->request->csrfToken?>";
		$.ajax({
	       		 type: "GET",
	       		 url: '/agent/default/blacklist?type=1&ime='+ime,
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
	       		 url: '/agent/default/unblacklist?type=1&ime='+ime,
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
	       		 url: '/agent/default/blacklist?type=2&gid='+gid,
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
       		 url: '/agent/default/unblacklist?type=2&gid='+gid,
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
});
</script>