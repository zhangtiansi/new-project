<?php
use yii\helpers\Html;
$apkurl=$uinfo->update_url."?v=".date('Ymdhis');
$iosurl="#";
if ($cid==1001)
{
    $iosurl="http://fir.im/zjhEnt";
}else{
    //if ($cid==1000||$cid==2000){//appstore
    $iosurl="https://itunes.apple.com/us/app/kuai-le-san-zhang-2015nian/id985117912?l=zh&ls=1&mt=8";
}
?>
<br>
<br>
<?= Html::img('/images/Icon-180.png',['style'=>'height:100px;width:100px']) ?>
<div style="padding:10px">
<?= Html::a('马上下载！', "#", ['class' => 'btn btn-lg btn-info dl-btn','onclick'=>'downloadClick()']) ?>
</div>
<div style="padding:10px">
<p style="font-size: 18px; color:BLUE">
当前版本<?= $uinfo->cur_version;?>
<br>更新时间：
<?= $uinfo->ctime;?></p>
</div>
<div>
<p style="font-size: 18px;">1.7版本更新日志</p>
<div style="text-align:left;color: #1B2B2F;font-size: 14px;-webkit-font-smoothing: antialiased;">
优化内容：<br>
1：优化骰子和时时乐中奖广播信息，减少刷屏情况<br>
2：时时乐每秒发奖人数增加，减少延迟到账时间<br>
3：优化服务器性能减少在线高峰期的卡顿延迟情况<br>
玩法更新内容：<br>
1：新增千王场（享受偷天换日的打牌乐趣）<br>
2：新增至尊场（身价300万入场，底注5万；比富豪更土豪的玩法）<br>
3：新增百人玩法（独乐乐不如众乐乐，与百人同台赢亿万大奖）<br>
4：新增私人房系统（自建隐密空间的打牌房）<br>
5：首充功能，固定金额第一次充值可以获得双倍钻石<br>
6：新增邮件提醒功能<br>
</div>
</div>
<script>
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


</script>