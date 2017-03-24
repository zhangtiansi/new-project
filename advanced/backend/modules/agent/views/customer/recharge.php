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

<div class="col-sm-12" style="font-size:24px">  
				<div class="input-group input-group-sm form-group-cus">
				    <label style="width: 100px ;font-size:24px">玩家帐号</label>
					<input type="text" id="gid" class="form-control" style="width: 300px;" value="0"/> 
				</div>
				<hr>
				<div class="input-group input-group-sm form-group-cus" >
				    <label style="width: 100px ;font-size:24px">充值金额</label>
					<input type="text" id="coin" class="form-control" style="width: 300px;"  value="0"/>
					单位(元) 
				</div> 
				<hr>
				<div class="input-group input-group-sm form-group-cus" >
				    <label style="width: 100px;font-size:24px">VIP 金卡</label>
					<input type="text" id="g-card" class="form-control" style="width: 300px;"  value="0"/>
				</div>
				<hr>
				<div class="input-group input-group-sm form-group-cus" >
				    <label style="width: 100px;font-size:24px">VIP  银卡</label>
					<input type="text" id="s-card" class="form-control" style="width: 300px;"  value="0"/>
				</div>
				<hr>
				<div class="input-group input-group-sm form-group-cus" >
				    <label style="width: 100px;font-size:24px">VIP  铜卡</label>
					<input type="text" id="c-card" class="form-control" style="width: 300px;"  value="0"/>
				</div>
				<hr>
				<div class="input-group"><a class='btn btn-info btn-large' id="recharge" href="#">充值</a></div> 
</div>
</div>
<script>
jQuery(function($) {
	console.log(location.hostname);
    $('li.active').removeClass("active open");
    $('.cusrecharge').addClass("active");
    $('.cusrecharge').parent('ul').parent('li').addClass("active open"); 
    var csrfToken="<?=Yii::$app->request->csrfToken?>";
    var inputGid= $('#gid');
    var inputcoin= $('#coin');
    var inputlaba= $('#laba');
    var inputgc= $('#g-card');
    var inputsc= $('#s-card');
    var inputcc= $('#c-card');

    $( "#recharge" ).on('click', function(e) {
        rec();
    });
    function rec(){
        var gid=inputGid.val();
        var coin=inputcoin.val();
        var laba=0;
        var vg=inputgc.val();
        var vs=inputsc.val();
        var vc=inputcc.val();
        if(gid==""||gid==0){
            alert("GID不能为空");
        }
        
    	$.ajax({
      		 type: "POST",
      		 url: '/agent/customer/rec',
      		 data:{
      		        gid:gid,
      		        coin:coin,
      		        laba:laba,
      		        vg:vg,
      		        vs:vs,
      		        vc:vc, 
        		   _csrf:csrfToken
            		 },
        		 dataType: "json",
        		 beforeSend:function(){clear();}, 
        		 success: function(data) {
        			 console.log(data);
        			 if(data.code == 0 ){//success
        				alert("添加成功");
        		      }else{
        		    	alert(data.msg);
                	 }   
        		 },
    		error:function(){
				alert("提交失败");
		        },
      		});
    }
    function clear()
    {
    	inputGid.val('0');
        inputcoin.val('0');
        inputlaba.val('0');
        inputgc.val('0');
        inputsc.val('0');
        inputcc.val('0');
     }
    
});
</script>