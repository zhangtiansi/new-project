<?php 
$apkurl=$uinfo->update_url;

?> 

        <div class="wrap"> 
        <div class="container">        
       <a id="allpg" style="margin-top:0;margin-left:0;height:2000px;width:100%;position:absolute"  href="#"></a>
<img src="/images/app/page_01.jpg">
<img src="/images/app/page_02.jpg">
<img src="/images/app/page_03.jpg">
<img src="/images/app/page_04.jpg">
<img src="/images/app/page_05.jpg">
        </div>
    </div>
    
<script>
var wd = window.innerWidth;
var scale = wd/640;
console.log("wd : "+wd+" scale :"+scale); 
var ap=document.getElementById('allpg');
ap.style.height=scale*3247+"px";
// var btnct=document.getElementById('btnct');
var cw = scale*281;
// console.log("cw : "+cw);
// btnct.style.width=cw+"px";
// btnct.style.top=scale*700+"px";
// btnct.style.left= scale*(320-281/2)+"px";
// var btntp=document.getElementById('btntp');
// var ttw = scale*166;
// btntp.style.width= ttw+"px";
// console.log("ttw : "+ttw);
</script>
<script>
jQuery(function($) {
var apkurl ="<?php echo $apkurl;?>";
var iosurl ="<?php echo $apkurl;?>";

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
$('#allpg').click(function(){
	downloadClick();
});
});


</script>