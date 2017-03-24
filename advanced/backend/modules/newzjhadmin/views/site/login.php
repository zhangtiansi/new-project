<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <!--[if lt IE 9]>
    <script type="text/javascript" src="/assets/new_admin/lib/html5.js"></script>
    <script type="text/javascript" src="/assets/new_admin/lib/respond.min.js"></script>
    <script type="text/javascript" src="/assets/new_admin/lib/PIE_IE678.js"></script>
    <![endif]-->
    <link href="/assets/new_admin/css/H-ui.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/new_admin/css/H-ui.login.css" rel="stylesheet" type="text/css" />
    <link href="/assets/new_admin/css/style.css" rel="stylesheet" type="text/css" />
    <link href="/assets/new_admin/lib/Hui-iconfont/1.0.1/iconfont.css" rel="stylesheet" type="text/css" />
    <!--[if IE 6]>
    <script type="text/javascript" src="http://lib.h-ui.net/DD_belatedPNG_0.0.8a-min.js" ></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
    <title>后台登录</title>
    <meta name="keywords" content="后台登录">
    <meta name="description" content="后台登录">
</head>
<body>
<input type="hidden" id="TenantId" name="TenantId" value="" />
<!--<div class="header"></div>-->
<style>
    .loginWraper{ position:absolute;width:100%; left:0; top:0; bottom:0; right:0; z-index:1; background:#000 url(/assets/new_admin/timg.jpeg) no-repeat center; background-size:cover;}
</style>
<div class="loginWraper">
    <div id="loginform" class="loginBox">
        <h1 style="color:#fff; padding:20px 0; font-size:20px; text-align:center;">后台管理系统</h1>
        <form class="form form-horizontal" action="/newzjhadmin/site/login" method="post">
            <div class="row cl">
                <label class="form-label col-3"><i class="Hui-iconfont">&#xe60d;</i></label>
                <div class="formControls col-8">
                    <input id="" name="LoginForm[username]" type="text" placeholder="账户" class="input-text size-L">
                    <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-3"><i class="Hui-iconfont">&#xe60e;</i></label>
                <div class="formControls col-8">
                    <input id="" name="LoginForm[password]" type="password" placeholder="密码" class="input-text size-L">
                </div>
            </div>
            <!--
            <div class="row cl">
                <div class="formControls col-8 col-offset-3">
                    <input class="input-text size-L" type="text" placeholder="验证码" onblur="if(this.value==''){this.value='验证码:'}" onclick="if(this.value=='验证码:'){this.value='';}" value="验证码:" style="width:150px;">
                    <img src="images/VerifyCode.aspx.png"> <a id="kanbuq" href="javascript:;">看不清，换一张</a> </div>
            </div>
             -->
            <div class="row">
                <div class="formControls col-8 col-offset-3">
                    <label for="online">
                        <input type="checkbox" name="online" id="online" value="">使我保持登录状态</label>
                </div>
            </div>
            <div class="row">
                <div class="formControls col-8 col-offset-3">
                    <input name="" type="submit" class="btn btn-primary radius size-L" value="&nbsp;登&nbsp;&nbsp;&nbsp;&nbsp;录&nbsp;">
                    <input name="" type="reset" class="btn btn-default radius size-L" value="&nbsp;取&nbsp;&nbsp;&nbsp;&nbsp;消&nbsp;">
                </div>
            </div>
        </form>

        <p style="width:100%; color:#fff; text-align:center; position:absolute; bottom:10px;">copyright©2016</p>
    </div>
</div>
<!--<div class="footer">Copyright ZMG</div>-->
<script type="text/javascript" src="/assets/new_admin/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/assets/new_admin/js/H-ui.js"></script>
<script>
</script>
</body>
</html>