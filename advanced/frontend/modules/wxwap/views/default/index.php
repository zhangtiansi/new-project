<?php 
use Yii; 
use app\models\GmWechatInfo;
$session = Yii::$app->session; 
$u = GmWechatInfo::findOne(['openid'=>$session->get('wechatsessionid')]);
if (!is_object($u)||$session->get('wechatsessionid')==""){
    echo "您的访问异常 ".$session->get('wechatsessionid');
}
elseif ($u->gid==0||$u->gid==""){
echo '
    <div class="container" id="container">
<div class="page layers js_show">
<div class="page home js_show"> 
<div class="page__bd">
        <p class="page__title">快乐三张主页欢迎</p> 
<div class="weui-cells__title">你还没有绑定帐号，绑定你的游戏ID</div>
<div class="weui-cells weui-cells_form">
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">用户名</label></div>
        <div class="weui-cell__bd">
            <input class="weui-input"  placeholder="请输入用户名"/>
        </div>
    </div> 
    
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">密码</label></div>
        <div class="weui-cell__bd">
            <input class="weui-input"  placeholder="请输入密码"/>
        </div> 
    </div>
    
    <div class="weui-cell">
    <div class="weui-cell__bd">
        <a href="javascript:;" class="weui-btn weui-btn_primary">绑定</a>
    </div>
    </div>
</div>
</div>
</div>
</div>
</div> ';
}else {
    $ts='您已绑定帐号：'.$u->gid;
    echo '
        <div class="container" id="container">
<div class="page layers js_show">
<div class="page home js_show">
    <div class="page__hd">
        <p class="page__desc">快乐三张主页欢迎 '.$ts.'</p> 
</div>
</div>
</div></div>';
    
}
?>