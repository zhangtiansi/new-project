<?php 
use yii\helpers\Html;
use app\models\CfgGameParam;
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

<?php if (is_object($modelreyes) && is_object($modelreyes2) && is_object($modeluseryes) && is_object($modeluseryes2)):?>
<div class="center"> 昨日数据(<?= date('Y-m-d',time()-86400)?>) </div>
<div class="col-sm-12 infobox-container">
<div class="infobox infobox-green  ">
	<div class="infobox-icon">
		<i class="icon-user"></i>
	</div>

	<div class="infobox-data">
		<span class="infobox-data-number"><?= $modeluseryes->totalreg?></span>
		<div class="infobox-content">新增用户</div>
	</div>
	     <?php $tx= Yii::$app->formatter->asPercent($modeluseryes2->totalreg==0?"0":($modeluseryes->totalreg-$modeluseryes2->totalreg)/$modeluseryes2->totalreg);
        if ($tx>=0){
	         echo '<div class="stat stat-success">';
	     }else {
	         echo '<div class="stat stat-important">';
	     }
	     echo $tx.'</div>';
	?>
</div>

<div class="infobox infobox-blue  ">
	<div class="infobox-icon">
		<i class="icon-group"></i>
	</div>

	<div class="infobox-data">
		<span class="infobox-data-number"><?= $modeluseryes->regactive?></span>
		<div class="infobox-content">注册活跃</div>
	</div>

     <?php $tx= Yii::$app->formatter->asPercent($modeluseryes2->regactive==0?"0":($modeluseryes->regactive-$modeluseryes2->regactive)/$modeluseryes2->regactive);
        if ($tx>=0){
	         echo '<div class="stat stat-success">';
	     }else {
	         echo '<div class="stat stat-important">';
	     }
	     echo $tx.'</div>';
	?>
</div>

<div class="infobox infobox-pink  ">
	<div class="infobox-icon">
		<i class="icon-user"></i>
	</div>

	<div class="infobox-data">
		<span class="infobox-data-number"><?= $modeluseryes->activenum?></span>
		<div class="infobox-content">活跃人数</div>
	</div>
	<?php $tx= $modeluseryes2->activenum==0?"0":Yii::$app->formatter->asPercent(($modeluseryes->activenum-$modeluseryes2->activenum)/$modeluseryes2->activenum);
	     if ($tx>=0){
	         echo '<div class="stat stat-success">';
	     }else {
	         echo '<div class="stat stat-important">';
	     }
	     echo $tx.'</div>';
	?>
	
</div>
<div class="space-6"></div>
<div class="infobox infobox-red  ">
	<div class="infobox-icon">
		<i class="icon-cny"></i>
	</div>

	<div class="infobox-data">
		<span class="infobox-data-number"><?= $modelreyes->totalfee.'元'?></span>
		<div class="infobox-content">充值总数</div>
	</div>
	<?php $tx= $modelreyes2->totalfee==0?"0":Yii::$app->formatter->asPercent(($modelreyes->totalfee-$modelreyes2->totalfee)/$modelreyes2->totalfee);
	     if ($tx>=0){
	         echo '<div class="stat stat-success">';
	     }else {
	         echo '<div class="stat stat-important">';
	     }
	     echo $tx.'</div>';
	?>
	
</div>
<div class="infobox infobox-blue  ">
	<div class="infobox-icon">
		<i class="icon-user"></i>
	</div>

	<div class="infobox-data">
		<span class="infobox-data-number"><?= $modelreyes->pnum?></span>
		<div class="infobox-content">充值人数</div>
	</div>
	<?php $tx= $modelreyes2->pnum==0?"0":Yii::$app->formatter->asPercent(($modelreyes->pnum-$modelreyes2->pnum)/$modelreyes2->pnum);
	     if ($tx>=0){
	         echo '<div class="stat stat-success">';
	     }else {
	         echo '<div class="stat stat-important">';
	     }
	     echo $tx.'</div>';
	?>
	
</div>
<div class="infobox infobox-orange  ">
	<div class="infobox-icon">
		<i class="icon-cny"></i>
	</div>

	<div class="infobox-data">
		<span class="infobox-data-number"><?= Yii::$app->formatter->asDecimal($modelreyes->up,2)?></span>
		<div class="infobox-content">充值UP</div>
	</div>
	<?php $tx= $modelreyes2->up==0?"0":Yii::$app->formatter->asPercent(($modelreyes->up-$modelreyes2->up)/$modelreyes2->up);
	     if ($tx>=0){
	         echo '<div class="stat stat-success">';
	     }else {
	         echo '<div class="stat stat-important">';
	     }
	     echo $tx.'</div>';
	?>
	
</div>
<?php endif;?>
<div class="widget-body">
<div class="widget-main padding-4">
	<div id="sales-charts"></div>
</div><!-- /widget-main -->
</div><!-- /widget-body -->
<div class="space-6"></div>

</div>

<div class="row-block col-sm-12"  >
<div class='col-sm-5'>
<table class="table table-striped table-bordered detail-view col-sm-10">
<tbody id="tbContent">
<?php 

foreach ($recentData as $ar){
    echo '<tr><td>'.$ar['k'].'</td><td>'.$ar['v'].'</td></tr>';
}
?>
</tbody></table>
</div>
<div class='col-sm-5'>
<p>时时乐今日排行榜</p>
<table class="table table-striped table-bordered detail-view col-sm-10">
<tbody id="tbSSL">
<?php 
echo '<tr><td>名次</td><td>GID</td><td>昵称</td><td>VIP</td><td>中奖(万)</td><td>中奖局数</td></tr>';
foreach ($ssl as $k=>$ar){
    echo '<tr><td>'.($k+1).'</td><td>'.$ar['gid'].'</td><td>'.$ar["name"].'</td><td>'.$ar["power"].'</td><td>'.$ar["totalReward"].'</td><td>'.$ar["totalNum"].'</td></tr>';
}
?>
</tbody></table>
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
jQuery(function($) {
	console.log(location.hostname);
    $('.submenu li.active').removeClass("active open");
    $('.nav-list li.active').removeClass("active open");
    $('.data-recent').addClass("active");
    $('.data-recent').parent('ul').parent('li').addClass("active open");


    
function refreshData(){
	loadData();
// 	loadDataC();
}
function loadData(){
	$.ajax({
		 type: "GET",
		 url: '/zjhadmin/default/getrecentdata',
		 dataType: "json",
		 success: function(data) {
			 console.log(data);
			 if(data.code == 0 ){
				 var items=data.results;
				 var appendarr=[];
					tpl(appendarr,items);
					$('#online-text').html(data.online);
					$("#tbContent").html(appendarr.join(''));
				 }
		 }
		});
}

function tpl(array,items,dataid){
	for (var i in items){
		var item = items[i];
		console.log(item);
		var li = '<tr><td>'+item.k+'</td><td>'+item.v+'</td></tr>';
		array.push(li);
		}
	
}

// refreshData();
setInterval(refreshData,300000);
});
</script>
