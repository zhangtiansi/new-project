<?php 
use yii\helpers\Html;
/**
 * 
 * 
 * 
 * 'modelreyes'=>$modelreyes,
            'modelreyes2'=>$modelreyes2,
            'modeluseryes'=>$modeluseryes,
            'modeluseryes2'=>$modeluseryes2,
 */
?>


<div class="widget-body">
<div class="widget-main padding-4">
	<div id="sales-charts"></div>
</div>
</div>
<div class="space-6"></div>

<?php echo $tt_recharge;?>
<table class="table table-striped table-bordered detail-view col-sm-12">
<tbody id="tbContent">
<tr>
<td>日期</td>
<?php foreach ($data as $line):?>
<td><?php echo $line['udate']?></td> 
<?php endforeach;?>
</tr>
<tr>
<td>alipay</td>
<?php foreach ($data as $line):?>
<td><?php echo $line['Alipay']?></td> 
<?php endforeach;?>
</tr>
<tr>
<td>短信</td>
<?php foreach ($data as $line):?>
<td><?php echo $line['sms']?></td> 
<?php endforeach;?>
</tr>
<tr>
<td>银联</td>
<?php foreach ($data as $line):?>
<td><?php echo $line['unionpay']?></td> 
<?php endforeach;?>
</tr>
<tr>
<td>微信</td>
<?php foreach ($data as $line):?>
<td><?php echo $line['wxpay']?></td> 
<?php endforeach;?>
</tr>
<tr>
<td>易宝</td>
<?php foreach ($data as $line):?>
<td><?php echo $line['yeepay']?></td> 
<?php endforeach;?>
</tr>
<tr>
<td>appstore</td>
<?php foreach ($data as $line):?>
<td><?php echo $line['appstore']?></td> 
<?php endforeach;?>
</tr>
<tr>
<td>总计</td>
<?php foreach ($data as $line):?>
<td><?php echo $line['totalfee']?></td> 
<?php endforeach;?>
</tr>
<tr>
<td style="width: 80px !important">Agent</td>
<?php foreach ($data as $line):?>
<td><?php echo $line['agent']?></td> 
<?php endforeach;?>
</tr>
</tbody></table>
<div class="space-6"></div>
<div>
上月数据 <?php echo $tt_last;?>
</div>
<div class="space-6"></div>
<table class="table table-striped table-bordered detail-view col-sm-12">
<tbody id="tbContent">
<tr>
<td>日期</td>
<?php foreach ($data_2 as $line):?>
<td><?php echo $line['udate']?></td> 
<?php endforeach;?>
</tr>
<tr>
<td>alipay</td>
<?php foreach ($data_2 as $line):?>
<td><?php echo $line['Alipay']?></td> 
<?php endforeach;?>
</tr>
<tr>
<td>短信</td>
<?php foreach ($data_2 as $line):?>
<td><?php echo $line['sms']?></td> 
<?php endforeach;?>
</tr>
<tr>
<td>银联</td>
<?php foreach ($data_2 as $line):?>
<td><?php echo $line['unionpay']?></td> 
<?php endforeach;?>
</tr>
<tr>
<td>微信</td>
<?php foreach ($data_2 as $line):?>
<td><?php echo $line['wxpay']?></td> 
<?php endforeach;?>
</tr>
<tr>
<td>易宝</td>
<?php foreach ($data_2 as $line):?>
<td><?php echo $line['yeepay']?></td> 
<?php endforeach;?>
</tr>
<tr>
<td>appstore</td>
<?php foreach ($data_2 as $line):?>
<td><?php echo $line['appstore']?></td> 
<?php endforeach;?>
</tr>
<tr>
<td>总计</td>
<?php foreach ($data_2 as $line):?>
<td><?php echo $line['totalfee']?></td> 
<?php endforeach;?>
</tr>
<tr>
<td style="width: 80px !important">Agent</td>
<?php foreach ($data_2 as $line):?>
<td><?php echo $line['agent']?></td> 
<?php endforeach;?>
</tr>
</tbody></table>
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
jQuery(function($) {
	console.log(location.hostname);
    $('.submenu li.active').removeClass("active open");
    $('.nav-list li.active').removeClass("active open");
    $('.data-recharge-chart').addClass("active");
    $('.data-recharge-chart').parent('ul').parent('li').addClass("active open");

    var d1 = [];
	for (var i = 0; i < Math.PI * 2; i += 0.5) {
		d1.push([i, Math.sin(i)]);
	}
	d1=[[0,11],[1,22],[2,66],[2.5,32],[3,67],[3.5,111]];
	var d2 = [];
	for (var i = 0; i < Math.PI * 2; i += 0.5) {
		d2.push([i, Math.cos(i)]);
	}
	d2=[[0,3],[1,66],[2,33],[2.5,15],[3,45],[3.5,120]];
	var d3 = [];
	for (var i = 0; i < Math.PI * 2; i += 0.2) {
		d3.push([i, Math.tan(i)]);
	}
	//recharge

	var sales_charts = $('#sales-charts').css({'width':'100%' , 'height':'220px'});
	
	console.log(d1);
	console.log(d2);
	console.log(d3);
	function loadChart(){
		$.ajax({
			 type: "GET",
			 url: '/zjhadmin/default/getrecentdata?dddd=recharge',
			 dataType: "json",
			 success: function(data) {
// 				 console.log(data);
				 if(data.code == 0 ){
					 console.log(data.results);
// 					 var dataAr = new Array();
// 					 dataAr.push([]);
// 					 var dataValue = new Array(); //数据  
// 	                   var ticks = new Array(); //横坐标值  
// 	                   $(msg).each(function (  value) {  
// 	                       dataValue.push(value.Consume);  
// 	                       ticks.push(value.YearMonth);  
// 	                   });  
					 $.plot("#sales-charts", 
							 [
								 {label:"总金额",data:data.results.total.data},
								 {label:"支付宝",data:data.results.alipay.data},
								 {label:"短信",data:data.results.sms.data},
								 {label:"银联",data:data.results.unionpay.data},
								 {label:"微信",data:data.results.wxpay.data},
								 {label:"易宝",data:data.results.yeepay.data},
								 {label:"appstore",data:data.results.appstore.data},
								 {label:"Agent",data:data.results.agent.data},
							 ],
// 							 [
// 					                  		{ label: "Domains", data: d1 },
// 					                  		{ label: "Hosting", data: d2 },
// 					                  		// { label: "Services", data: d3 }
// 					                  	], 
					                  	{
					                  		hoverable: true,
					                  		shadowSize: 0,
					                  		series: {
					                  			lines: { show: true },
					                  			points: { show: true }
					                  		},
					                  		xaxis: {
					                  			tickLength: 0
					                  		},
					                  		yaxis: {
					                  			ticks: 4,
					                  		},
					                  		grid: {
					                  			backgroundColor: { colors: [ "#fff", "#fff" ] },
					                  			borderWidth: 1,
					                  			borderColor:'#555'
					                  		}
					                  	});
					 }
			 }
			});

	}
	loadChart();
});
</script>
