<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html lang="zh">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,member-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<meta content="yes" name="apple-mobile-web-app-capable">
<meta content="black" name="apple-mobile-web-app-status-bar-style">
<meta name="format-detection" content="telephone=no">
<meta name="keywords" content="" />
<meta name="description" content="" />
<link rel="Bookmark" href="/favicon.ico" />
<link rel="Shortcut Icon" href="/favicon.ico" />
<head>
	<link rel="stylesheet" href="/app/css/reset.css" />
	<link rel="stylesheet" href="/app/css/toup.css" />
	<link rel="stylesheet" href="/app/swiper/swiper.min.css">
	<script src="/app/js/jquery-1.11.3.js"></script>
	<script src="/app/js/fontSize.js"></script>
	<title>快乐三张牌</title>
</head>
<body>
<?php
use yii\helpers\Html;
$apkurl=$uinfo->update_url;
$iosurl="#";
if ($cid==1001)
{
    $iosurl="http://fir.im/zjhEnt";
}else{
    //if ($cid==1000||$cid==2000){//appstore
    $iosurl="https://itunes.apple.com/us/app/kuai-le-san-zhang-2015nian/id985117912?l=zh&ls=1&mt=8";
}
?>
	<section class="toup" id="t2">
		<div class="logo">
			<h2>应用详情</h2>
		</div>
		<div class="app_icon">
			<div class="icon_pic"><img src="/app/images/Icon_pic.png" /></div>
			<div class="icon_desc">
				<div class="icon_title">快乐三张牌</div>
				<div class="icon_size">大小:16.8MB&nbsp;下载:126万次</div>
				<div class="icon_size">
					<img src="/app/images/star.png" />
					<img src="/app/images/star.png" />
					<img src="/app/images/star.png" />
					<img src="/app/images/star.png" />
					<img src="/app/images/star.png" />
				</div>
			</div>
			<div class="down_icon">
				<a href="#" onclick="downloadClick()"><img src="/app/images/az_down.png" /></a>
				<a href="#" onclick="downloadClick()"><img src="/app/images/ap_down.png" /></a>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="app_version">
			<div>
				<span class="s_left">版本:<font><?= $uinfo->cur_version;?></font></span>
				<span class="s_right">支持固件:<font>Android2.3.3/IOS4.3以上</font></span>
				<div class="clearfix"></div>
			</div>
			<div>
				<span class="s_left">开发者:<font>免费游戏</font></span>
				<span class="s_right">更新日期:<font><?php echo date('Y-m-d',strtotime($uinfo->ctime));?></font></span>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="app_pic">
			<div class="swipers">
				<div class="swiper-container">
					<div class="swiper-wrapper">
						<div class="swiper-slide">
							<div class="scores">
								<img src="/app/images/b1.jpg" />
								<img src="/app/images/b2.jpg" class="last" />
								<div class="clearfix"></div>
							</div>
						</div>
						<div class="swiper-slide">
							<div class="scores">
								<img src="/app/images/b3.jpg" />
								<img src="/app/images/b4.jpg" class="last" />
								<div class="clearfix"></div>
							</div>
						</div>
						<div class="swiper-slide">
							<div class="scores">
								<img src="/app/images/b5.jpg" />
								<div class="clearfix"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="app_desc">
			<h3>简介</h3>
			<div>
				<p>快乐三张牌是一款非常正宗的交友棋牌游戏，美女约战，真人社交，让普通的游戏不在枯燥！</p>
				<p>特色玩法：增加了真人对战、辛运礼物，时时彩票，骰王争霸、马儿快跑好友追踪、激情道具、等非常多的热点创新玩法，将游戏的激情体验升温到极致。</p>
				<p>赚钱容易，妹子多，玩法丰富！免费金币天天送，输完再送3次。</p>
			</div>
		</div>
		<div class="bottom_down">
			<a href="#" onclick="downloadClick()"><img src="/app/images/az_down.png" /></a>
			<a href="#" onclick="downloadClick()"><img src="/app/images/ap_down.png" /></a>
		</div>
		<div class="bottom_down">
			&copy; 2016 <a href="http://www.cggame.cc" target="_blank">浙江彩狗文化传播有限公司</a>
		</div>
	</section>
	<script src="/app/swiper/swiper.min.js"></script>
	<script>
	var mySwiper  = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev',
        slidesPerView: 1,
        paginationClickable: true,
        spaceBetween: 30,
        loop: false,
		onReachEnd: function(swiper){
			
		}
    });
	$(".swiper-container label,.swiper-container input").click(function(){
		var this_active = $(this).parents(".swiper-slide").index();
		setTimeout(function(){
			mySwiper.slideTo(this_active+1,1000)
		},500);
	});
	var apkurl ="<?php echo $apkurl;?>";
	var iosurl ="<?php echo $iosurl;?>";
	function redirect(){ 
//	 	alert("url is "+href+" ua :"+ua);
		location.href = href; 
		} 
	var url_parts = document.URL.split('?'); 
	var query = url_parts.length == 2 ? ('?' + url_parts[1]) : ''; 
	var href = '#'; 
	var ua = navigator.userAgent.toLowerCase(); 
	function downloadClick(){
		if (/micromessenger/.test(ua)) {
	    	alert('由于微信限制下载，请点击右上角"在safari中打开"或"用浏览器打开"或者复制链接到常用浏览器地址中打开'); 
	    	location.href = '#'; 
	    }else if (/iphone|ipad|ipod/.test(ua)) { 
	    	href = iosurl;
//	         alert('抱歉，暂不支持IOS下载 '); 
	        setTimeout(redirect, 500); 
	    } else if (/android/.test(ua)) { 
	    	href = apkurl;
	    	setTimeout(redirect, 500); 
	    } else if (/windows phone|blackberry/.test(ua)) {
//	     	alert('抱歉，暂不支持您的系统 '); 
	    	href = apkurl;
	    	setTimeout(redirect, 500); 
	    }else { 
//	     	alert('抱歉，暂不支持您的系统 ');
	    	href = apkurl;
	    	setTimeout(redirect, 500);
	    } 
	}
	</script>
</body>
</html>