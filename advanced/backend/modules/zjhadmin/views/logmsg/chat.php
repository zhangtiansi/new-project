<?php
use yii\helpers\Html;
$this->title = '客服消息';
$this->params['breadcrumbs'][] = $this->title;
?>

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="col-md-3">
        <div id="chat-nav" class="list-group">
        <div class="list-group-item">用户1</div>
         <div class="list-group-item active">用户2</div>
          <div class="list-group-item">用户3</div>
           <div class="list-group-item">用户4</div>
        </div>
        <div id="chat-nav2" class="list-group">
            <div class="list-group-item">用户1</div>
        </div>
    </div>
    <div class="col-sm-9">
	<div class="widget-box ">
		<div class="widget-header">
			<h4 class="lighter smaller">
				<i class="icon-comment blue"></i>
				<span id="comment-title"></span>
			</h4>
		</div>

		<div class="widget-body">
			<div class="widget-main no-padding">
				<div class="dialogs" id="scroll-msgdia">
					<div class="itemdiv dialogdiv">
						<div class="user">
							<img alt="Alexa's Avatar" src="/assets/admin/avatars/avatar1.png" />
						</div>

						<div class="body">
							<div class="time">
								<i class="icon-time"></i>
								<span class="green">4秒钟前</span>
							</div>

							<div class="name">
								<a href="#">Alexa</a>
							</div>
							<div class="text">大家好啊</div>

							<div class="tools">
								<a href="#" class="btn btn-minier btn-info">
									<i class="icon-only icon-share-alt"></i>
								</a>
							</div>
						</div>
					</div>

			
                </div><!-- /widget-main -->
				<form>
					<div class="form-actions">
						<div class="input-group">
						      <span class="input-group-btn">
						          <button class="btn btn-sm btn-warning no-radius" id="allread-btn" type="button">
									<i class="icon-share-alt"></i>
									标记已读
								</button>
								</span>
							<input placeholder="输入内容..." type="text" id="msg-input" class="form-control" name="message"  />
							<span class="input-group-btn">
								<button class="btn btn-sm btn-info no-radius" id="sd-btn" type="button">
									<i class="icon-share-alt"></i>
									发送
								</button>
								
							</span>
						</div>
					</div>
				</form>
			
		</div><!-- /widget-body -->
	</div><!-- /widget-box -->
</div><!-- /span -->
</div>
<style>
.row-block{
font-family: "Helvetica Neue",Helvetica,"Hiragino Sans GB","Microsoft YaHei","微软雅黑",Arial,sans-serif;
margin-left: 0px;
  margin-top: 2px;
  padding: 2px 2px 2px;
  border: 1px solid #DDDDDD;
  border-radius: 4px;
  position: relative;
  word-wrap: break-word;
}
.msg-box{
  min-height:340px;
  height: 500px;
  
}
.msg-dia{
  position: absolute;
  overflow: hidden!important;
  padding: 0!important;
  box-sizing: content-box!important;
  height: auto;
  left: 0;
  margin: 0;
  max-height: none!important;
  max-width: none!important;
  padding: 0;
  position: relative!important;
  top: 0;
  width: auto!important;
   overflow-y:scroll!important;
   height:400px;
}
.msg-dia .msg-dia-left{
    display:block;
    min-height:60px;
    line-height:25px;
    border-bottom:1px solid #d6d6d6;
}
.msg-dia .msg-dia-right{
  display:block;
    min-height:60px;
    line-height:25px;
    border-bottom:1px solid #d6d6d6;
}

.msg-dia .msg-dia-left .content-desc{
    margin:1px;
    display:block;
    border:1px;
    border-radius:3px;
    color:red;
}
.msg-dia .msg-dia-right .content-desc{
    background:#4cae4c;
    float: right;
    text-align: right;
    clear: right;
    display:block;
    margin:2px;
    border-radius:3px;
}

.msg-dia .msg-dia-right .content-time{
    float: right;
    text-align: right;
    clear: right;
    display:block;
    margin:2px;
}
.foot-input{
    position: absolute;
  right: 0;
  bottom: 0;
  left: 0;
    width:100%;
    height:35px;
}
.foot-input .msg-content{
    width:85%;
    height:100%;
}
.foot-input .sd-btn{
    width:15%;
    height:100%;
}
.itemdiv .body .text{
    word-wrap: break-word;
  word-break: break-all;
}
</style>
<script>
$(function(){
//customer-msg
    $('.submenu li.active').removeClass("active open");
    $('.nav-list li.active').removeClass("active open");
	$('.customer-msg').addClass("active");
	$('.customer-msg').parent('ul').parent('li').addClass("active open");

	
    var dialogfid="";
	var itemContainer=$('#scroll-msgdia');
	var scrollTo_int = itemContainer.prop('scrollHeight') + 'px';
    itemContainer.slimScroll({
        scrollTo : scrollTo_int,
        height: '350px',
        alwaysVisible: true
    });
	
	var nav=$("#chat-nav");
	var nav2=$("#chat-nav2");
    function getUnreadList(){
//     	var navitem='<div class="list-group-item">用户1</div>';
        	$.ajax({
       		 type: "GET",
       		 url: '/zjhadmin/logmsg/unreadlist',
       		 dataType: "json",
       		 success: function(data) {
       			 console.log(data);
       			 if(data.code == 0 ){
       				var items=data.results;
       				 var appendarr=[];
       			        tplnav(appendarr,items);
       			        nav.html(appendarr.join(''));
       				 }
       		 }
       		});
        }
    function getreadList(){
//     	var navitem='<div class="list-group-item">用户1</div>';
        	$.ajax({
       		 type: "GET",
       		 url: '/zjhadmin/logmsg/readlist',
       		 dataType: "json",
       		 success: function(data) {
       			 console.log(data);
       			 if(data.code == 0 ){
       				var items=data.results;
       				 var appendarr=[];
       			        tplnav(appendarr,items);
       			        nav2.html(appendarr.join(''));
       				 }
       		 }
       		});
        }
    function tplnav(array,items){
    	for (var i in items){
    		var item = items[i];
    		console.log(item);
    		var li = '';
    		if(item.fid==dialogfid){
    			li+='<div class="list-group-item active"';
    		}else{
    			li+='<div class="list-group-item"';
        	}
    		li+= 'data-name="'+item.name+'"  data-fid="'+item.fid+'"  data-money="'+item.money+'"  data-point="'+item.point+'">';
    		li+=item.name+"(『VIP"+item.power+"』)   ";
    		if(item.unread!=null){
    			  li+='<span class="badge badge-important">'+item.unread+'</span> ';
    		}
    		li+='<div><i class="icon-time"></i>'+item.latest+'</div></div>';
  
    		array.push(li);
    		}
    }

    function startDialog(fid)
    {
    	$.ajax({
      		 type: "GET",
      		 url: '/zjhadmin/logmsg/fetchunread?fid='+fid,
      		 dataType: "json",
      		 success: function(data) {
      			 console.log(data);
      			 if(data.code == 0 ){
      				var items=data.results;
      				var appendarr=[];
      		        tplContent(appendarr,items);
      		        itemContainer.html(appendarr.join(''));
      		        console.log("container height: "+document.getElementById('scroll-msgdia').scrollHeight);
      		      document.getElementById('scroll-msgdia').scrollTop = document.getElementById('scroll-msgdia').scrollHeight;
      		      }
      		 }
      		});
    	
    }
    function tplContent(array,items)
    {
    	for (var i in items){
    		var item = items[i];
            var li='<div class="itemdiv dialogdiv">';
            li+='<div class="user">';
            if(item.fid==0){
            	li+='<img src="/assets/admin/avatars/avatar1.png" />';
            }else{
                li+='<img src="http://g.koudaishiji.com/images/avatars/'+item.fid+'.jpg" />';
            }
            li+='</div>';
            li+='<div class="body">';
            li+='<div class="time">';
            li+='<i class="icon-time"></i>';
            li+='<span class="green">'+item.mtime+'</span>';
            li+='</div>';
            li+='<div class="name">';
            if(item.fid==0){
            	li+='<a href="#">我：</a>';
            }else{
            	li+='<a href="#">'+item.name+'</a>';
            }
            li+='</div>';
            li+='<div class="text">'+item.content+'</div>';
            li+='</div>';
            li+='</div>';
            array.push(li);
        }
    }
    
	$("#sd-btn").click(function(){
// 		append(this.eq(0).clone()).html();
        var cont=$("#msg-input").val();
        var csrfToken="<?=Yii::$app->request->csrfToken?>";
        
        if(cont !=""&&dialogfid!=""){
//         	alert(" sd btn click send msg: "+cont+ " to"+dialogfid);
        	$.ajax({
         		 type: "POST",
         		 url: '/zjhadmin/logmsg/sendcust?fid='+dialogfid,
         		 data:{
         		    msg:cont,
         		   _csrf:csrfToken
             		 },
         		 dataType: "json",
         		 success: function(data) {
         			 console.log(data);
         			 if(data.code == 0 ){//success
         				$("#msg-input").val("");
         	        	startDialog(dialogfid);
         		      }
         		 },
         		error:function(){
    				alert("提交失败，请检查网络");
    		        },
         		});
        }
	 });
	$("#allread-btn").click(function(){
// 		append(this.eq(0).clone()).html();
        var csrfToken="<?=Yii::$app->request->csrfToken?>";
        if(dialogfid!=""){
        	alert(" sd btn click send  read to"+dialogfid);
        	$.ajax({
         		 type: "POST",
         		 url: '/zjhadmin/logmsg/sendcust?fid='+dialogfid+'&typef=allread',
         		 data:{
         		   _csrf:csrfToken
             		 },
         		 dataType: "json",
         		 success: function(data) {
         			 console.log(data);
         			 if(data.code == 0 ){//success
         				getUnreadList();
         				getreadList();
         		      }
         		 },
         		error:function(){
    				alert("提交失败，请检查网络");
    		        },
         		});
        }
	 });
	
	$("#chat-nav").delegate(".list-group-item","click",function(data){
		var fid = $(this).data("fid"),fname=$(this).data("name"),fmoney=$(this).data("money"),fpoint=$(this).data("point");
		$('.list-group-item').removeClass("active");
		$(this).addClass("active");
		var title = '<span>'+fname+'</span><em class="text-muted text-sm">当前金币:'+fmoney+'当前钻石：'+fpoint+'    </em><a class="btn btn-sm btn-info" href="/zjhadmin/player/view?id='+fid+'">详细</a>';
	    
		$('#comment-title').html(title);
		startDialog(fid);
		dialogfid=fid;
// 		$('.customer-op').parent('ul').parent('li').addClass("active open");
// 		   alert("hi ,clicked "+fid);
		});

	$("#chat-nav2").delegate(".list-group-item","click",function(data){
		var fid = $(this).data("fid"),fname=$(this).data("name"),fmoney=$(this).data("money"),fpoint=$(this).data("point");
		$('.list-group-item').removeClass("active");
		$(this).addClass("active");
		var title = '<span>'+fname+'</span><em class="text-muted text-sm">当前金币:'+fmoney+'当前钻石：'+fpoint+'    </em><a  class="btn btn-sm btn-info" href="/zjhadmin/player/view?id='+fid+'">详细</a>';
 		$('#comment-title').html(title);
		startDialog(fid);
		dialogfid=fid;
// 		$('.customer-op').parent('ul').parent('li').addClass("active open");
// 		   alert("hi ,clicked "+fid);
		});
	
	function refreshData(){
		getUnreadList();
		getreadList();
		startDialog(dialogfid);
		}
	refreshData();
	setInterval(refreshData,15000);
});
</script>