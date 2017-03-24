

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
<div class="title">
	<img src="/images/dl/1_logo.png" width="50%">
</div>

<div class="dl">
		<i class="dl-btn" id="dl-btn"></i>
</div>
<!-- 广告-->
<div class="ad">
	<img src="/images/dl/activity.png" width="30%">
	<img src="/images/dl/ad.png" width="30%">
</div>
<!-- 轮播 -->
<div class="banner" id="b04">
    <ul>
        <li><img src="/images/dl/p01.jpg" alt="" width="100%" height="100%" ></li>
        <li><img src="/images/dl/p02.jpg" alt="" width="100%" height="100%" ></li>
        <li><img src="/images/dl/p03.jpg" alt="" width="100%" height="100%"  ></li>
        <li><img src="/images/dl/p04.jpg" alt="" width="100%" height="100%"  ></li>
        <li><img src="/images/dl/p05.jpg" alt="" width="100%" height="100%"  ></li>
    </ul>
</div>
<!--footer -->
<div  class="footer-dl">
	<img src="/images/dl/6.png">
	<img src="/images/dl/7.png">
	<img src="/images/dl/8.png">
</div>

<script type="text/javascript">
$(document).ready(function(e) {
    

var apkurl ="<?php echo $apkurl;?>";
var iosurl ="<?php echo $iosurl;?>";
function redirect(){ 
// 	alert("url is "+href+" ua :"+ua);
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
//         alert('抱歉，暂不支持IOS下载 '); 
        setTimeout(redirect, 500); 
    } else if (/android/.test(ua)) { 
    	href = apkurl;
    	setTimeout(redirect, 500); 
    } else if (/windows phone|blackberry/.test(ua)) {
//     	alert('抱歉，暂不支持您的系统 '); 
    	href = apkurl;
    	setTimeout(redirect, 500); 
    }else { 
//     	alert('抱歉，暂不支持您的系统 ');
    	href = apkurl;
    	setTimeout(redirect, 500);
    } 
}
$( "#dl-btn" ).on('click', function(e) {
	downloadClick(); 
});
var unslider04 = $('#b04').unslider({
// 	dots: true
});
});
</script>