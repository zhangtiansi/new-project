<?php 
use yii\helpers\Html;
use app\models\GmAnnouncement;
?>
<script src="/assets/6c0ad4db/jquery.js"></script>
<script src="/assets/18c673af/yii.js"></script>
<script src="/assets/7bca57a6/js/bootstrap.js"></script>
<h1>系统配置项</h1>
	<div class="row">
		<div class="col-xs-4 row-block">
		<p>时时乐当前参数:</p>
			<ul  style="list-style: none;">
				<li>
				    当前押注场次ID ： <span id="ssl_now_id"  class="text-danger"></span>
				</li>
				<li>
					当前押注阈值 ： <span id="ssl_now_yu" class="text-danger"></span>,单轮间隔时间：<span id="ssl_cfg_time" class="text-danger"></span>秒
				</li>
				<li>
					上场结束时间 ： <span id="ssl_last_time" class="text-danger"></span>
				</li>
				<li>
					上场押注总数（单注2万） ： <span id="ssl_last_sum" class="text-danger"></span>
				</li>
				<li>
					上场派奖金额 ： <span id="ssl_last_reward" class="text-danger"></span>
				</li>
				<li>
					上场派奖人数 ： <span id="ssl_last_num" class="text-danger"></span>
				</li>
				<li>
					上场结束奖池 ： <span id="ssl_last_pool" class="text-danger"></span>
				</li>
				<li>
				</li>
				<li>
				</li>
			</ul>
		</div>

		<div class="col-xs-4 row-block">
		<p>系统配置参数:</p>
<div class="col-xs-8" style="border-bottom: 1px solid #CCC; padding-top:20px">
       <?php 
       $x=count(GmAnnouncement::getAnnu())>0?GmAnnouncement::getAnnu()['content']:"空";
       echo Html::tag("div","滚屏公告：".$x.Html::a("修改公告",'#',['class'=>'btn btn-warning btn-xs modannu']),['class'=>'col-xs-8','id'=>'annu']); 
       ?> 
    </div>
		</div>
	</div>
		
<style>
.row-block{
margin-left: 0px;
  margin-top: 10px;
  padding: 30px 15px 15px;
  border: 1px solid #DDDDDD;
  border-radius: 4px;
  position: relative;
  word-wrap: break-word;
}
<!--

-->
</style>
<script>
// 
function refreshData(){
	loadServerid();
	loadBet();
}
function loadServerid(){
	$.ajax({
		 type: "GET",
		 url: '/zjhadmin/default/getserverid',
		 dataType: "json",
		 success: function(data) {
			 console.log(data);
			 if(data.code == 0 ){
				 $("#now_server_id").text(data.msg);
				 $("#now_server_name").text(data.servername);
// 				   var lists = data.results;
// 				   var li_array = [];
// 				   fitdpdtpl(li_array,lists);
// 				   $('#accordion').html(li_array.join(''));
// 				   map.clearOverlays();
// 				   for(var i in lists){
// 					     var item = lists[i];
// 					   }
				 }
		 }
		});
}
function loadBet(){
	$.ajax({
		 type: "GET",
		 url: '/zjhadmin/default/getbet',
		 dataType: "json",
		 success: function(data) {
			 console.log(data);
			 if(data.code == 0 ){//{"id":1,"min_num":1,"max_num":98,"ntime":60,"num_yu":20,"num_coin":5000000,"bidnow":72702,"code":0,
				 //"bid":"72701","result":"4","ctime":"2015-06-30 18:27:04","betCoin":"21","coin":"0","player_num":"0","coin_pool":"2992000"}
				 $("#ssl_now_id").text(data.bidnow);
				 $("#ssl_now_yu").text(data.num_coin);
				 $("#ssl_cfg_time").text(data.ntime);
				 $("#ssl_last_time").text(data.ctime);
				 $("#ssl_last_sum").text(data.betCoin);
				 $("#ssl_last_reward").text(data.coin);
				 $("#ssl_last_num").text(data.player_num);
				 $("#ssl_last_pool").text(data.coin_pool);
// 				   var lists = data.results;
// 				   var li_array = [];
// 				   fitdpdtpl(li_array,lists);
// 				   $('#accordion').html(li_array.join(''));
// 				   map.clearOverlays();
// 				   for(var i in lists){
// 					     var item = lists[i];
// 					   }
				 }
		 }
		});
}

setInterval(refreshData,5000);
refreshData();
</script>
