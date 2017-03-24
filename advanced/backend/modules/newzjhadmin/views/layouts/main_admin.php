<?php
// use yii;
use backend\assets\AppAsset;
use yii\helpers\Html;
use app\models\User;
use yii\widgets\LinkPager;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>管理后台</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="/assets/new_admin/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- FontAwesome 4.3.0 -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons 2.0.0 -->
    <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="/assets/new_admin/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link href="/assets/new_admin/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="/assets/new_admin/plugins/iCheck/flat/blue.css" rel="stylesheet" type="text/css" />
    <link href="/assets/new_admin/plugins/colorpicker/bootstrap-colorpicker.min.css" rel="stylesheet" type="text/css" />
    <!-- Morris chart -->
    <!-- <link href="plugins/morris/morris.css" rel="stylesheet" type="text/css" /> -->
    <!-- jvectormap -->
    <!-- <link href="plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" /> -->
    <!-- Date Picker -->
     <link href="/assets/new_admin/plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
    <!-- Daterange picker -->
    <!-- <link href="plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" /> -->
    <!-- bootstrap wysihtml5 - text editor -->
    <link href="/assets/new_admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body class="skin-blue">
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="index.html" class="logo">后台</a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- Messages: style can be found in dropdown.less-->
                    <li class="dropdown messages-menu">

                    </li>
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="hidden-xs"><?php echo Yii::$app->user->isGuest?"Guest":User::getNamebyid(Yii::$app->user->id);?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <p>
                                    <?php echo Yii::$app->user->isGuest?"Guest":User::getNamebyid(Yii::$app->user->id);?>
<!--                                    <small>项目经理</small>-->
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-right">
                                    <a href="/newzjhadmin/site/logout" class="btn btn-default btn-flat">退出</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <!--<li class="header">MAIN NAVIGATION</li>-->
                <li class="<?php $menu = array('/newzjhadmin/default/recent','/newzjhadmin/default/month', '/newzjhadmin/dailyuser/index','/newzjhadmin/dailyrecharge/index','/newzjhadmin/dailycoin/index','/newzjhadmin/staydaily/index','/newzjhadmin/datamonthrecharge/index'); if (in_array($_SERVER['REQUEST_URI'], $menu)) {
                    echo 'active';
                }?> treeview">
                    <a href="#">
                        <span>日常数据</span> <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li class="<?php if($_SERVER['REQUEST_URI'] == '/newzjhadmin/default/recent') {
                            echo 'active';
                        }?> "><a href="/newzjhadmin/default/recent"><i class="fa fa-circle-o"></i>今日实时数据</a></li>
                        <li class="<?php if($_SERVER['REQUEST_URI'] == '/newzjhadmin/default/month') {
                            echo 'active';
                        }?> "><a href="/newzjhadmin/default/month"><i class="fa fa-circle-o"></i>当月充值</a></li>
                        <li class="<?php if($_SERVER['REQUEST_URI'] == '/newzjhadmin/dailyuser/index') {
                            echo 'active';
                        }?> "><a href="/newzjhadmin/dailyuser/index"><i class="fa fa-circle-o"></i>每日用户数据</a></li>
                        <li class="<?php if($_SERVER['REQUEST_URI'] == '/newzjhadmin/dailyrecharge/index') {
                            echo 'active';
                        }?> "><a href="/newzjhadmin/dailyrecharge/index"><i class="fa fa-circle-o"></i>每日充值数据</a></li>
                        <li class="<?php if($_SERVER['REQUEST_URI'] == '/newzjhadmin/dailycoin/index') {
                            echo 'active';
                        }?> "><a href="/newzjhadmin/dailycoin/index"><i class="fa fa-circle-o"></i>每日金币数据</a></li>
                        <li class="<?php if($_SERVER['REQUEST_URI'] == '/newzjhadmin/staydaily/index') {
                            echo 'active';
                        }?> "><a href="/newzjhadmin/staydaily/index"><i class="fa fa-circle-o"></i>每日留存数据</a></li>
                        <li class="<?php if($_SERVER['REQUEST_URI'] == '/newzjhadmin/datamonthrecharge/index') {
                            echo 'active';
                        }?> "><a href="/newzjhadmin/datamonthrecharge/index"><i class="fa fa-circle-o"></i>月充值数据</a></li>
                    </ul>
                </li>
                <li class="<?php $menus = array('/newzjhadmin/channel/index'); if (in_array($_SERVER['REQUEST_URI'], $menus)) {
                        echo 'active';
                    }?>">
                    <a href="#">
                        <span>渠道运营</span> <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li class="<?php if($_SERVER['REQUEST_URI'] == '/newzjhadmin/channel/index') {
                            echo 'active';
                        }?> "><a href="/newzjhadmin/channel/index"><i class="fa fa-circle-o"></i>渠道设置</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <span>客服功能</span> <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="returngoods.html"><i class="fa fa-circle-o"></i>客服消息</a></li>
                        <li><a href="returnrefund.html"><i class="fa fa-circle-o"></i>客户管理</a></li>
                        <li><a href="returnrefund.html"><i class="fa fa-circle-o"></i>常用查询</a></li>
                        <li><a href="returnrefund.html"><i class="fa fa-circle-o"></i>礼品日记</a></li>
                        <li><a href="returnrefund.html"><i class="fa fa-circle-o"></i>礼品统计</a></li>
                        <li><a href="returnrefund.html"><i class="fa fa-circle-o"></i>发文字邮件</a></li>
                        <li><a href="returnrefund.html"><i class="fa fa-circle-o"></i>后台赠送记录</a></li>
                        <li><a href="returnrefund.html"><i class="fa fa-circle-o"></i>活动赠送记录</a></li>
                        <li><a href="returnrefund.html"><i class="fa fa-circle-o"></i>玩家登录记录</a></li>
                        <li><a href="returnrefund.html"><i class="fa fa-circle-o"></i>设备黑名单列表</a></li>
                        <li><a href="returnrefund.html"><i class="fa fa-circle-o"></i>充值明细</a></li>
                        <li><a href="returnrefund.html"><i class="fa fa-circle-o"></i>首充明细</a></li>
                        <li><a href="returnrefund.html"><i class="fa fa-circle-o"></i>金币变更记录</a></li>
                        <li><a href="returnrefund.html"><i class="fa fa-circle-o"></i>金币变更记录(汇总单局)</a></li>
                        <li><a href="returnrefund.html"><i class="fa fa-circle-o"></i>玩家每小时金币</a></li>
                        <li><a href="returnrefund.html"><i class="fa fa-circle-o"></i>玩家历史信息(每小时)</a></li>
                        <li><a href="returnrefund.html"><i class="fa fa-circle-o"></i>游戏内好友聊天记录</a></li>
                        <li><a href="returnrefund.html"><i class="fa fa-circle-o"></i>充值排行榜</a></li>
                        <li><a href="returnrefund.html"><i class="fa fa-circle-o"></i>仙草back排行</a></li>
                        <li><a href="returnrefund.html"><i class="fa fa-circle-o"></i>短信充值榜</a></li>
                        <li><a href="returnrefund.html"><i class="fa fa-circle-o"></i>胜率过高榜</a></li>
                        <li><a href="returnrefund.html"><i class="fa fa-circle-o"></i>经典场刷号权重</a></li>
                        <li><a href="returnrefund.html"><i class="fa fa-circle-o"></i>私人房刷号权重</a></li>
                        <li><a href="returnrefund.html"><i class="fa fa-circle-o"></i>月卡</a></li>
                        <li><a href="returnrefund.html"><i class="fa fa-circle-o"></i>月卡添加</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <span>促销管理</span> <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="specialtopic.html"><i class="fa fa-circle-o"></i>专题管理</a></li>
                        <li><a href="groupbuy.html"><i class="fa fa-circle-o"></i>团购管理</a></li>
                        <li><a href="coupon.html"><i class="fa fa-circle-o"></i>优惠券</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <span>游购管理</span> <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="yougoulist.html"><i class="fa fa-circle-o"></i>游购列表</a></li>
                        <li><a href="yougouadd.html"><i class="fa fa-circle-o"></i>添加游购</a></li>
                        <li><a href="reporting.html"><i class="fa fa-circle-o"></i>举报列表</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <span>广告管理</span> <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="appbanner.html"><i class="fa fa-circle-o"></i>APP Banner</a></li>
                        <li><a href="apprecommend.html"><i class="fa fa-circle-o"></i>APP 推荐单品</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <span>会员管理</span> <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="viplist.html"><i class="fa fa-circle-o"></i>会员列表</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <span>报表统计</span> <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="stockstatistics.html"><i class="fa fa-circle-o"></i>库存统计</a></li>
                        <li><a href="orderstatistics.html"><i class="fa fa-circle-o"></i>订单统计</a></li>
                        <li><a href="clientstatistics.html"><i class="fa fa-circle-o"></i>客户统计</a></li>
                        <li><a href="vipstatistics.html"><i class="fa fa-circle-o"></i>会员排行</a></li>
                        <li><a href="salesstatistics.html"><i class="fa fa-circle-o"></i>销售排行</a></li>
                        <li><a href="accessstatistics.html"><i class="fa fa-circle-o"></i>访问购买率</a></li>
                        <li><a href="collectstatistics.html"><i class="fa fa-circle-o"></i>收藏统计</a></li>
                        <li><a href="searchstatistics.html"><i class="fa fa-circle-o"></i>搜索设计</a></li>
                    </ul>
                </li>
                <li class="<?php $menu_permission = array('/newzjhadmin/permission/index','/newzjhadmin/user/index','/newzjhadmin/roles/index'); if (in_array($_SERVER['REQUEST_URI'], $menu_permission)) {
                    echo 'active';
                }?> treeview">
                    <a href="#">
                        <span>权限设置</span> <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li class="<?php if($_SERVER['REQUEST_URI'] == '/newzjhadmin/roles/index') {
                            echo 'active';
                        }?> "><a href="/newzjhadmin/roles/index"><i class="fa fa-circle-o"></i>角色管理</a></li>
                        <li class="<?php if($_SERVER['REQUEST_URI'] == '/newzjhadmin/permission/index') {
                            echo 'active';
                        }?> "><a href="/newzjhadmin/permission/index"><i class="fa fa-circle-o"></i>权限管理</a></li>
                        <li class="<?php if($_SERVER['REQUEST_URI'] == '/newzjhadmin/user/index') {
                            echo 'active';
                        }?> "><a href="/newzjhadmin/user/index"><i class="fa fa-circle-o"></i>管理员列表</a></li>
                    </ul>
                </li>
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>
<?= $content?>
</div><!-- ./wrapper -->

<!-- jQuery 2.1.3 -->
<script src="/assets/new_admin/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- jQuery UI 1.11.2 -->
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.min.js" type="text/javascript"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.2 JS -->
<script src="/assets/new_admin/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="/assets/new_admin/plugins/morris/morris.min.js" type="text/javascript"></script>
<!-- Sparkline -->
<!-- <script src="plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script> -->
<!-- jvectormap -->
<!-- <script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script> -->
<!-- <script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script> -->
<!-- jQuery Knob Chart -->
<!-- <script src="plugins/knob/jquery.knob.js" type="text/javascript"></script> -->
<!-- daterangepicker -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script> -->
<!-- <script src="plugins/daterangepicker/daterangepicker.js"></script> -->
<!-- datepicker -->
 <script src="/assets/new_admin/plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="/assets/new_admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
<script src="/assets/new_admin/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
<!-- iCheck -->
<script src="/assets/new_admin/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
<!-- Slimscroll -->
<script src="/assets/new_admin/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<!-- FastClick -->
<script src='/assets/new_admin/plugins/fastclick/fastclick.min.js'></script>
<!-- AdminLTE App -->
<script src="/assets/new_admin/dist/js/app.min.js" type="text/javascript"></script>

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="/assets/new_admin/dist/js/pages/dashboard.js" type="text/javascript"></script>

<!-- AdminLTE for demo purposes -->
<script src="/assets/new_admin/dist/js/demo.js" type="text/javascript"></script>
<script src="/assets/new_admin/lib/layer/1.9.3/layer.js" type="text/javascript"></script>
<script type="text/javascript" src="/assets/new_admin/lib/Validform/5.3.2/Validform.min.js"></script>
</body>
<script>
        //Colorpicker
        $(".my-colorpicker").colorpicker();
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        //CKEDITOR.replace('editor');
        //bootstrap WYSIHTML5 - text editor
        //$(".textarea").wysihtml5();
        //datepicker
        $("#datepicker").datepicker();
        //umeditor
//        var um = UM.getEditor('myEditor');
</script>
</html>