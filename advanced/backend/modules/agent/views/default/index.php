<?php 
use app\models\LogCustomer;
$agent = LogCustomer::getAgentorders(Yii::$app->user->id);
?>
<div class="agent-default-index">
<div class="center"> 我的信息</div>
<div class="col-sm-12 infobox-container">

<div class="infobox infobox-green  ">
	<div class="infobox-icon">
		<i class="icon-user"></i>
	</div>
	<div class="infobox-data">
		<span class="infobox-data-number"> <?= $model->money;?> <i class="icon-cny"></i></span>
		<div class="infobox-content">余额</div>
	</div>
</div>
</div>
<div class="center"> 累计信息</div>
<div class="col-sm-12 infobox-container">
<div class="infobox infobox-green  ">
	<div class="infobox-icon">
		<i class="icon-list"></i>
	</div>
	<div class="infobox-data">
		<span class="infobox-data-number"> <?= $agent['num'];?> </span>
		<div class="infobox-content">充值比数</div>
	</div>
</div>
<div class="infobox infobox-orange ">
	<div class="infobox-icon">
		<i class="icon-list"></i>
	</div>
	<div class="infobox-data">
		<span class="infobox-data-number"> <?= $agent['totalcoin']==""?0:$agent['totalcoin'];?> 万</span>
		<div class="infobox-content">充值总金币</div>
	</div>
</div>

<div class="infobox infobox-blue ">
	<div class="infobox-icon">
		<i class="icon-list"></i>
	</div>
	<div class="infobox-data">
		<span class="infobox-data-number"> <?= $agent['point']==""?0:$agent['point'];?> </span>
		<div class="infobox-content">送出钻石数</div>
	</div>
</div>


</div>
</div>
