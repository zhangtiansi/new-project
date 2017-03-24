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
<head> 
	<title>快乐三张牌</title>
</head>
<body>
<?php 
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

	<script>
	
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
	downloadClick();
	</script>
</body>
</html>