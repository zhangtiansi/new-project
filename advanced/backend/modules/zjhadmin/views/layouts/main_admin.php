<?php
// use yii;
use backend\assets\AppAsset;
use yii\helpers\Html;
use app\models\User;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>后台管理</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<!-- basic styles -->
		
		<link href="<?php echo Yii::$app->getRequest()->getHostInfo() ?>/assets/admin/css/bootstrap.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="<?php echo  Yii::$app->getRequest()->getHostInfo()?>/assets/admin/css/font-awesome.min.css" />

		<!--[if IE 7]>
		  <link rel="stylesheet" href="<?php echo  Yii::$app->getRequest()->getHostInfo()?>/assets/admin/css/font-awesome-ie7.min.css" />
		<![endif]-->

		<!-- page specific plugin styles -->
        <link rel="stylesheet" href="/assets/admin/css/jquery-ui-1.10.3.full.min.css">
		<!-- ace styles -->
		<link rel="stylesheet" href="<?php echo  Yii::$app->getRequest()->getHostInfo()?>/assets/admin/css/dropzone.css" />
		<link rel="stylesheet" href="<?php echo  Yii::$app->getRequest()->getHostInfo()?>/assets/admin/css/ace.min.css" />
		<link rel="stylesheet" href="<?php echo  Yii::$app->getRequest()->getHostInfo()?>/assets/admin/css/ace-rtl.min.css" />
		<link rel="stylesheet" href="<?php echo  Yii::$app->getRequest()->getHostInfo()?>/assets/admin/css/ace-skins.min.css" />
		<link rel="stylesheet" href="<?php echo  Yii::$app->getRequest()->getHostInfo()?>/assets/e3ecaab1/css/yii.css" />
		<link rel="stylesheet" type="text/css" href="/assets/admin/css/jquery-ui-timepicker-addon.css" /> 
		<!--[if lte IE 8]>
		  <link rel="stylesheet" href="<?php echo  Yii::$app->getRequest()->getHostInfo()?>/assets/admin/css/ace-ie.min.css" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- ace settings handler -->
		<script src="http://libs.baidu.com/jquery/2.0.3/jquery.min.js"></script>
		<script src="<?php echo  Yii::$app->getRequest()->getHostInfo()?>/assets/admin/js/ace-extra.min.js"></script>
		<script src="<?php echo  Yii::$app->getRequest()->getHostInfo();?>/assets/admin/js/dropzone.min.js"></script>

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

		<!--[if lt IE 9]>
		<script src="<?php echo  Yii::$app->getRequest()->getHostInfo()?>/assets/admin/js/html5shiv.js"></script>
		<script src="<?php echo  Yii::$app->getRequest()->getHostInfo()?>/assets/admin/js/respond.min.js"></script>
		<![endif]-->
	</head>

	<body>
		<div class="navbar navbar-default" id="navbar">
			<script type="text/javascript">
				try{ace.settings.check('navbar' , 'fixed')}catch(e){}
			</script>

			<div class="navbar-container" id="navbar-container">
				<div class="navbar-header pull-left">
					<a href="#" class="navbar-brand">
						<small>
							<i class="icon-leaf"></i>
							后台管理
						</small>
					</a><!-- /.brand -->
				</div><!-- /.navbar-header -->

				<div class="navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav">
						<li class="light-blue">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
								<img class="nav-user-photo" src="<?php echo  Yii::$app->getRequest()->getHostInfo()?>/assets/admin/avatars/user.jpg" alt="Jason's Photo" />
								<span class="user-info">
									<small>欢迎光临,</small>
									<?php echo Yii::$app->user->isGuest?"Guest":User::getNamebyid(Yii::$app->user->id);?>
								</span>

								<i class="icon-caret-down"></i>
							</a>

							<ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								<li>
									<a href="#">
										<i class="icon-cog"></i>
										设置
									</a>
								</li>

								<li>
									<a href="#">
										<i class="icon-user"></i>
										个人资料
									</a>
								</li>

								<li class="divider"></li>

								<li>
									<?= Html::a('<i class="icon-off"></i>退出', '/zjhadmin/site/logout', ['data-method' => 'post'])?>
								</li>
							</ul>
						</li>
					</ul><!-- /.ace-nav -->
				</div><!-- /.navbar-header -->
			</div><!-- /.container -->
		</div>

		<div class="main-container" id="main-container">
			<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>

			<div class="main-container-inner">
				<a class="menu-toggler" id="menu-toggler" href="#">
					<span class="menu-text"></span>
				</a>

				<div class="sidebar" id="sidebar"><!-- 左边侧边栏 -->
					<script type="text/javascript">
						try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
					</script>	

					<ul class="nav nav-list">
						<li class="active">
							<a href="<?php // echo Yii::app()->createUrl('BkAdmin')?>">
								<i class="icon-dashboard"></i>
								<span class="menu-text">概况</span>
							</a>
						</li>
						<?php $user = User::findIdentity(Yii::$app->user->id);
                                if (is_object($user) &&( $user->checkRole(User::ROLE_ADMIN)||$user->checkRole(User::ROLE_DATA) ||$user->checkRole(User::ROLE_BUSS))):
                            ?>
						<li>
							<a href="#" class="dropdown-toggle">
								<i class="icon-bar-chart red"></i>
								<span class="menu-text">日常数据 </span>
								<b class="arrow icon-angle-down"></b>
							</a>
							
                            <ul class="submenu">
								<li class="data-recent">
									<a href="/zjhadmin/default/recent">
										<i class="icon-double-angle-right"></i>
										<i class="icon-bar-chart"></i>今日实时数据
									</a>
								</li>
                                <li class="data-recharge-chart">
									<a href="/zjhadmin/default/recent?type=money">
										<i class="icon-double-angle-right"></i>
										<i class="icon-bar-chart"></i>当月充值
									</a>
								</li>
								<li class="data-user">
									<a href="/zjhadmin/dailyuser">
										<i class="icon-double-angle-right"></i>
										<i class="icon-bar-chart"></i>每日用户数据
									</a>
								</li>
								<li class="data-recharge">
									<a href="/zjhadmin/dailyrecharge">
										<i class="icon-double-angle-right"></i>
										<i class="icon-bar-chart"></i>每日充值数据
									</a>
								</li>
								<li class="data-coin">
									<a href="/zjhadmin/dailycoin">
										<i class="icon-double-angle-right"></i>
										<i class="icon-bar-chart"></i>每日金币数据
									</a>
								</li>
								<li class="data-stay">
									<a href="/zjhadmin/staydaily">
										<i class="icon-double-angle-right"></i>
										<i class="icon-bar-chart"></i>每日留存数据
									</a>
								</li>
								<li class="data-monthrecharge">
									<a href="/zjhadmin/datamonthrecharge">
										<i class="icon-double-angle-right"></i>
										<i class="icon-bar-chart"></i>月充值数据
									</a>
								</li>
							</ul>
							
						</li>
						<?php endif;?>
						<?php $user = User::findIdentity(Yii::$app->user->id);
                                if (is_object($user) &&( $user->checkRole(User::ROLE_ADMIN) ||$user->checkRole(User::ROLE_BUSS))):
                            ?>
						<li>
							<a href="#" class="dropdown-toggle">
								<i class="icon-glass"></i>
								<span class="menu-text">渠道运营</span>
								<b class="arrow icon-angle-down"></b>
							</a>

							<ul class="submenu">

								<li class="ops-channel">
									<a href="/zjhadmin/channel">
										<i class="icon-double-angle-right"></i>
										<i class="icon-glass"></i>渠道设置
									</a>
								</li>
							</ul>
						</li>
						
						<?php endif;?>
						<li >
							<a href="#" class="dropdown-toggle">
								<i class="icon-bell orange"></i>
								<span class="menu-text">客服功能 </span>
								<b class="arrow icon-angle-down"></b>
							</a>

							<ul class="submenu">
							     
								<li class="customer-msg">
									<a href="/zjhadmin/logmsg">
										<i class="icon-double-angle-right"></i>
										<i class="icon-comments-alt"></i>客服消息
									</a>
								</li>
								<?php $user = User::findIdentity(Yii::$app->user->id);
                                    if (is_object($user) && ($user->checkRole(User::ROLE_ADMIN)||$user->checkRole(User::ROLE_OPS))):
                                ?>
                                <li class="customerplayer">
									<a href="/zjhadmin/accountview/index">
										<i class="icon-double-angle-right"></i>
										<i class="icon-group"></i>客户管理
									</a>
								</li>
								<li class="logtop">
									<a href="/zjhadmin/default/findout">
										<i class="icon-double-angle-right"></i>
										<i class="icon-group"></i>常用查询
									</a>
								</li> 
								 <li class="loggfit">
									<a href="/zjhadmin/loggift">
										<i class="icon-double-angle-right"></i>
										<i class="icon-gift"></i>礼品日志
									</a>
								</li>
								<li class="gifttop">
									<a href="/zjhadmin/loggift/topgift">
										<i class="icon-double-angle-right"></i>
										<i class="icon-gift"></i>礼品统计
									</a>
								</li>
								
								<li class="sendmail">
									<a href="/zjhadmin/logmail/create">
										<i class="icon-double-angle-right"></i>
										<i class="icon-gift"></i>发文字邮件
									</a>
								</li> 
								<li class="log-customer">
									<a href="/zjhadmin/customer/index">
										<i class="icon-double-angle-right"></i>
										<i class="icon-comments"></i>后台赠送记录
									</a>
								</li>
								<li class="log-activereward">
									<a href="/zjhadmin/logactrewards/index">
										<i class="icon-double-angle-right"></i>
										<i class="icon-comments"></i>活动赠送记录
									</a>
								</li>
								<li class="log-request">
									<a href="/zjhadmin/logrequest">
										<i class="icon-double-angle-right"></i>
										<i class="icon-exchange"></i>玩家登录记录
									</a>
								</li>
								<li class="blacklist">
									<a href="/zjhadmin/blacklist">
										<i class="icon-double-angle-right"></i>
										<i class="icon-list"></i>设备黑名单列表
									</a>
								</li>
								<li class="logorders">
									<a href="/zjhadmin/order">
										<i class="icon-double-angle-right"></i>
										<i class="icon-list"></i>充值明细
									</a>
								</li>
								<li class="logfirstorders">
									<a href="/zjhadmin/firstorder">
										<i class="icon-double-angle-right"></i>
										<i class="icon-list"></i>首充明细
									</a>
								</li>
								<li class="logcoin">
									<a href="/zjhadmin/logcoin?gid=1">
										<i class="icon-double-angle-right"></i>
										<i class="icon-list"></i>金币变更记录
									</a>
								</li>
								<li class="logcoinhis">
									<a href="/zjhadmin/logcoinhis?gid=1">
										<i class="icon-double-angle-right"></i>
										<i class="icon-list"></i>金币变更记录(汇总单局)
									</a>
								</li>
								<li class="loghourcoin">
									<a href="/zjhadmin/loghourcoin">
										<i class="icon-double-angle-right"></i>
										<i class="icon-list"></i>玩家每小时金币
									</a>
								</li>
								<li class="loghourplayer">
									<a href="/zjhadmin/loghourplayer">
										<i class="icon-double-angle-right"></i>
										<i class="icon-list"></i>玩家历史信息(每小时)
									</a>
								</li>
								
								<li class="logfriendsmsgs">
									<a href="/zjhadmin/logfriendsmsgs">
										<i class="icon-double-angle-right"></i>
										<i class="icon-list"></i>游戏内好友聊天记录
									</a>
								</li>
								
								<li class="toprecharge">
									<a href="/zjhadmin/toprecharge">
										<i class="icon-double-angle-right"></i>
										<i class="icon-group"></i>充值排行榜
									</a>
								</li>
							
								<li class="topback">
									<a href="/zjhadmin/topback">
										<i class="icon-double-angle-right"></i>
										<i class="icon-group"></i>仙草back排行
									</a>
								</li>
								<li class="smsrecharge">
									<a href="/zjhadmin/smsrecharge">
										<i class="icon-double-angle-right"></i>
										<i class="icon-group"></i>短信充值榜
									</a>
								</li>
								<li class="winmuch">
									<a href="/zjhadmin/winmuch">
										<i class="icon-double-angle-right"></i>
										<i class="icon-group"></i>胜率过高榜
									</a>
								</li>
								<li class="weightgame">
									<a href="/zjhadmin/weightgame">
										<i class="icon-double-angle-right"></i>
										<i class="icon-group"></i>经典场刷号权重
									</a>
								</li>
								<li class="weightprivate">
									<a href="/zjhadmin/weightprivate">
										<i class="icon-double-angle-right"></i>
										<i class="icon-group"></i>私人房刷号权重
									</a>
								</li>
								<li class="monthcard">
									<a href="/zjhadmin/gmmonthcard">
										<i class="icon-double-angle-right"></i>
										<i class="icon-group"></i>月卡
									</a>
								</li> 
								<li class="monthcard">
									<a href="/zjhadmin/gmmonthcard/create">
										<i class="icon-double-angle-right"></i>
										<i class="icon-group"></i>月卡添加
									</a>
								</li>
								<?php 
								endif;
								?>
							</ul>
						</li>
						
								<?php $user = User::findIdentity(Yii::$app->user->id);
                                    if (is_object($user) && ($user->checkRole(User::ROLE_ADMIN)||$user->checkRole(User::ROLE_OPS))):
                                ?>
						<li>
							<a href="#" class="dropdown-toggle">
								<i class="icon-group"></i>
								<span class="menu-text">百人</span>
								<b class="arrow icon-angle-down"></b>
							</a>

							<ul class="submenu">
                                  <li class="logwarrecord">
									<a href="/zjhadmin/logwarrecord">
										<i class="icon-double-angle-right"></i>
										<i class="icon-list"></i>百人牌型记录
									</a>
								</li>
								<li class="logwarresult">
									<a href="/zjhadmin/logwarresult">
										<i class="icon-double-angle-right"></i>
										<i class="icon-list"></i>百人开奖记录
									</a>
								</li>
								<?php $user = User::findIdentity(Yii::$app->user->id);
                                if (is_object($user) && $user->checkRole(User::ROLE_ADMIN)):
                            ?>
								<li class="cfgwar">
									<a href="/zjhadmin/cfgwar">
										<i class="icon-double-angle-right"></i>
										<i class="icon-list"></i>百人基础配置
									</a>
								</li>
								<?php endif;?>
							</ul>
						</li>
						<?php endif;?>
						<?php $user = User::findIdentity(Yii::$app->user->id);
                                if (is_object($user) && $user->checkRole(User::ROLE_ADMIN)):
                            ?>
						<li>
							<a href="#" class="dropdown-toggle">
								<i class="icon-group"></i>
								<span class="menu-text">Agent管理</span>
								<b class="arrow icon-angle-down"></b>
							</a>

							<ul class="submenu"> 
								<li class="opsagent">
									<a href="/zjhadmin/agent">
										<i class="icon-double-angle-right"></i>
										<i class="icon-group"></i>管理Agent号
									</a>
								</li>
							</ul>
						</li>
						
                        <li>
							<a href="#" class="dropdown-toggle">
								<i class="icon-cogs"></i>
								<span class="menu-text">参数设置</span>
								<b class="arrow icon-angle-down"></b>
							</a>

							<ul class="submenu">

								
								<li class="ops-syserr">
									<a href="/zjhadmin/syslogs">
										<i class="icon-double-angle-right"></i>
										<i class="icon-comments-alt"></i>系统日志
									</a>
								</li>
								<li class="ops-sysparam">
									<a href="/zjhadmin/sysparam">
										<i class="icon-double-angle-right"></i>
										<i class="icon-cogs"></i>设置参数
									</a>
								</li>
								
							</ul>
						</li>
						<?php endif;?> 
						
 						<?php $user = User::findIdentity(Yii::$app->user->id);
                                    if (is_object($user) && ($user->checkRole(User::ROLE_ADMIN)||$user->checkRole(User::ROLE_OPS))):
                                ?>
                                
						<li>
							<a href="#" class="dropdown-toggle">
								<i class="icon-group"></i>
								<span class="menu-text">日志</span>
								<b class="arrow icon-angle-down"></b>
							</a>

							<ul class="submenu">

								<li class="opslogs">
									<a href="/zjhadmin/sysoplogs">
										<i class="icon-double-angle-right"></i>
										<i class="icon-fire"></i>操作日志
									</a>
								</li> 
							</ul>
						</li>
						<li>
							<a href="#" class="dropdown-toggle">
								<i class="icon-heart"></i>
								<span class="menu-text">时时乐信息</span>
								<b class="arrow icon-angle-down"></b>
							</a>
                            
								
							<ul class="submenu">

								<li class="ops-ssl-bet">
									<a href="/zjhadmin/logbetlog">
										<i class="icon-double-angle-right"></i>
										<i class="icon-flag"></i>时时乐押注记录
									</a>
								</li>
								<li class="ops-ssl-result">
									<a href="/zjhadmin/logbetresults">
										<i class="icon-double-angle-right"></i>
										<i class="icon-briefcase"></i>时时乐开奖记录
									</a>
								</li>
								<li class="ops-ssl-reward">
									<a href="/zjhadmin/logbetreward">
										<i class="icon-double-angle-right"></i>
										<i class="icon-bookmark"></i>时时乐返奖记录
									</a>
								</li>
								<li class="betinfo">
									<a href="/zjhadmin/betinfos">
										<i class="icon-double-angle-right"></i>
										<i class="icon-flag"></i>时时乐押注/返奖记录
									</a>
								</li>
								<?php $user = User::findIdentity(Yii::$app->user->id);
                                if (is_object($user) && $user->checkRole(User::ROLE_ADMIN)):
                            ?>
								<li class="ops-ssl">
									<a href="/zjhadmin/default/sysconf">
										<i class="icon-double-angle-right"></i>
										<i class="icon-cog"></i>时时乐概率
									</a>
								</li>
								<?php endif;?>
							</ul>
							
						</li>
						<?php endif;?>
						<?php $user = User::findIdentity(Yii::$app->user->id);
                                    if (is_object($user) && ($user->checkRole(User::ROLE_ADMIN)||$user->checkRole(User::ROLE_OPS))):
                                ?>
						<li>
							<a href="#" class="dropdown-toggle">
								<i class="icon-coffee"></i>
								<span class="menu-text">运营功能</span>
								<b class="arrow icon-angle-down"></b>
							</a>

							<ul class="submenu">

								<li class="opt-actlogs">
									<a href="/zjhadmin/logactivities">
										<i class="icon-double-angle-right"></i>
										<i class="icon-bar-chart"></i>活动参与日志
									</a>
								</li>
								<li class="gmoptact">
									<a href="/zjhadmin/gmoptact">
										<i class="icon-double-angle-right"></i>
										<i class="icon-cog"></i>活动配置信息
									</a>
								</li>
								<li class="gm-notice">
									<a href="/zjhadmin/notice">
										<i class="icon-double-angle-right"></i>
										<i class="icon-cog"></i>公告配置信息
									</a>
								</li>
								
							</ul>
						</li>
						<?php endif;?>
					</ul><!-- /.nav-list -->

					<div class="sidebar-collapse" id="sidebar-collapse">
						<i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
					</div>

					<script type="text/javascript">
						try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
					</script>
				</div>

				<div class="main-content">
					<div class="page-content">
						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS 正文中间 -->

									<?php echo $content; ?>

								<!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.page-content -->
				</div><!-- /.main-content -->

			</div><!-- /.main-container-inner -->

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="icon-double-angle-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->

		<!-- basic scripts -->

		<!--[if !IE]> -->

<!-- 		<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script> -->

		<!-- <![endif]-->

		<!--[if IE]>
<script src="http://libs.baidu.com/jquery/1.10.2/jquery.min.js"></script>
<![endif]-->

		<!--[if !IE]> -->

		<script type="text/javascript">
			window.jQuery || document.write("<script src='<?php echo  Yii::$app->getRequest()->getHostInfo()?>/assets/admin/js/jquery-2.0.3.min.js'>"+"<"+"script>");
		</script>

		<!-- <![endif]-->

		<!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='<?php echo  Yii::$app->getRequest()->getHostInfo()?>/assets/admin/js/jquery-1.10.2.min.js'>"+"<"+"script>");
</script>
<![endif]-->

		<script type="text/javascript">
			if("ontouchend" in document) document.write("<script src='<?php echo  Yii::$app->getRequest()->getHostInfo()?>/assets/admin/js/jquery.mobile.custom.min.js'>"+"<"+"script>");
		</script>
		<script src="<?php echo  Yii::$app->getRequest()->getHostInfo()?>/assets/admin/js/bootstrap.min.js"></script>
		<script src="<?php echo  Yii::$app->getRequest()->getHostInfo()?>/assets/admin/js/typeahead-bs2.min.js"></script>

		<!-- page specific plugin scripts -->

		<!--[if lte IE 8]>
		  <script src="<?php echo  Yii::$app->getRequest()->getHostInfo()?>/assets/admin/js/excanvas.min.js"></script>
		<![endif]-->
        
		<script src="<?php echo  Yii::$app->getRequest()->getHostInfo()?>/assets/admin/js/jquery-ui-1.10.3.custom.min.js"></script>
		<script src="<?php echo  Yii::$app->getRequest()->getHostInfo()?>/assets/admin/js/jquery-ui-1.10.3.full.min.js"></script>
		<script src="<?php echo  Yii::$app->getRequest()->getHostInfo()?>/assets/admin/js/jquery.ui.touch-punch.min.js"></script>
		<script src="<?php echo  Yii::$app->getRequest()->getHostInfo()?>/assets/admin/js/jquery.slimscroll.min.js"></script>
		<script src="<?php echo  Yii::$app->getRequest()->getHostInfo()?>/assets/admin/js/jquery.easy-pie-chart.min.js"></script>
		<script src="<?php echo  Yii::$app->getRequest()->getHostInfo()?>/assets/admin/js/jquery.sparkline.min.js"></script>
		<script src="<?php echo  Yii::$app->getRequest()->getHostInfo()?>/assets/admin/js/flot/jquery.flot.min.js"></script>
		<script src="<?php echo  Yii::$app->getRequest()->getHostInfo()?>/assets/admin/js/flot/jquery.flot.pie.min.js"></script>
		<script src="<?php echo  Yii::$app->getRequest()->getHostInfo()?>/assets/admin/js/flot/jquery.flot.resize.min.js"></script>
		
		<!-- ace scripts -->

		<script src="<?php echo  Yii::$app->getRequest()->getHostInfo()?>/assets/admin/js/ace-elements.min.js"></script>
		<script src="<?php echo  Yii::$app->getRequest()->getHostInfo()?>/assets/admin/js/ace.min.js"></script>
		<!-- ace settings handler -->

		<script src="<?php echo  Yii::$app->getRequest()->getHostInfo()?>/assets/admin/js/ace-extra.min.js"></script>
        <script>
            $('.clickplayerinfo').click(function(){
            	location.href='http://'+location.hostname+'/zjhadmin/player/view?id='+$(this).data("gid");
            });
        </script>
</body>
</html>





