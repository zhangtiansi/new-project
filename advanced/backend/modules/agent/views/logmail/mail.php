<?php

use yii\helpers\Html;
use app\models\User;
use app\models\GmPlayerInfo;

/* @var $this yii\web\View */
/* @var $model app\models\LogCustomer */

$this->title = '发邮件'; 
?>
<div class="log-customer-create">
    <h1><?= Html::encode($this->title) ?></h1>

<div class="col-sm-12" style="font-size:24px">  
				<div class="input-group input-group-sm form-group-cus">
				    <label style="width: 100px ;font-size:18px">玩家UID</label>
					<input type="text" id="gid" class="form-control" style="width: 300px;" value="0"/> 
				</div>
				<hr>
				<div class="input-group input-group-sm form-group-cus">
				    <label style="width: 100px ;font-size:18px">发件人UID</label>
					<input type="text" id="sender" class="form-control" style="width: 300px;" value="0"/> 
				</div>
				<hr>
				<div class="input-group input-group-sm form-group-cus" >
				    <label style="width: 100px ;font-size:18px">邮件标题</label>
					<input type="text" id="mailtitle" class="form-control" style="width: 300px;"  value="0"/>
				</div>
				<hr>
				<div class="input-group input-group-sm form-group-cus" >
				    <label style="width: 100px ;font-size:18px">邮件内容</label>
					<textarea  id="mailcontent" class="form-control" style="width: 300px;height:200px" rows="6" cols="30">
					</textarea> 
				</div> 
				<hr>
				<div class="input-group"><a class='btn btn-info btn-large' id="send" href="#">发送</a></div> 
</div>
</div>
<script>
jQuery(function($) {
	console.log(location.hostname);
    $('li.active').removeClass("active open");
    $('.sendmail').addClass("active");
    $('.sendmail').parent('ul').parent('li').addClass("active open"); 
    var csrfToken="<?=Yii::$app->request->csrfToken?>";
    var inputGid= $('#gid');
    var inputsendGid= $('#sender');
    var inputTitle= $('#mailtitle');
    var inputContent= $('#mailcontent'); 

    $( "#send" ).on('click', function(e) {
        rec();
    });
    function rec(){
        var gid=inputGid.val();
        var sender=inputsendGid.val();
        var title=inputTitle.val();
        var content=inputContent.val(); 
        if(gid==""||gid==0){
            alert("GID不能为空");
        }
        
    	$.ajax({
      		 type: "POST",
      		 url: '/agent/logmail/send',
      		 data:{
      		        gid:gid,
      		        sender:sender,
      		        title:title,
      		      content:content,
        		   _csrf:csrfToken
            		 },
        		 dataType: "json",
//         		 beforeSend:function(){clear();}, 
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
//     function clear()
//     {
//     	inputGid.val('0');
//         inputcoin.val('0');
//         inputlaba.val('0');
//         inputgc.val('0');
//         inputsc.val('0');
//         inputcc.val('0');
//      }
    
});
</script>