<!DOCTYPE html>
<html ng-app="lubanlockApp">
	<head>
		<meta charset="utf-8" />
		<meta name="renderer" content="webkit" />
		<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
		
		<title><?=$this->company->sysname?></title>

		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		
		<link rel="stylesheet" href="css/font-awesome.min.css?v=3.2.1" />
		<link rel="stylesheet" href="css/bootstrap.min.css?v=3.2.0" />
		<link rel="stylesheet" href="css/ace.css?v=2014-12-3" />
		
		<!--[if lt IE 9]>
		<link rel="stylesheet" href="css/ace-ie.css" />
		<![endif]-->

		<!--[if lt IE 9]>
		<script type="text/javascript" src="js/es5-shim.min.js"></script>
		<![endif]-->
		
		<!--[if !IE]> -->
		<script type="text/javascript" src="js/jquery/jquery.min.js?v=2.1.1"></script>
		<!-- <![endif]-->
		<!--[if IE]>
		<script type="text/javascript" src="js/jquery/jquery-1.x.min.js?v=1.11.1"></script>
		<![endif]-->
					
		<script type="text/javascript" src="js/angular/angular.min.js?v=1.2.27"></script>
		<script type="text/javascript" src="js/angular/angular-locale_zh-cn.js?v=1.2.27"></script>
		<script type="text/javascript" src="js/angular/angular-route.min.js?v=1.2.27"></script>
		<script type="text/javascript" src="js/angular/angular-resource.min.js?v=1.2.27"></script>
		<script type="text/javascript" src="js/angular/ui-bootstrap.min.js?v=0.12.0"></script>
		<script type="text/javascript" src="js/angular/angular-file-upload.min.js?v=1.6.12"></script>
		
		<script type="text/javascript" src="app.js?v=2014-12-03"></script>
		<script type="text/javascript" src="controllers/component.js?v=2014-12-03"></script>
		<script type="text/javascript" src="controllers/dialog.js?v=2014-12-03"></script>
		<script type="text/javascript" src="controllers/object.js?v=2014-12-03"></script>
		<script type="text/javascript" src="controllers/user.js?v=2014-12-03"></script>
		<script type="text/javascript" src="directives.js?v=2014-12-03"></script>
		<script type="text/javascript" src="filters.js?v=2014-12-03"></script>
		<script type="text/javascript" src="services.js?v=2014-12-03"></script>

		<!--[if lt IE 9]>
		<script type="text/javascript" src="js/html5shiv.min.js?v=3.7.2"></script>
		<script type="text/javascript" src="js/respond.min.js?v=1.4.2"></script>
		<![endif]-->
		
		<?php if($this->company->config('modules')): foreach($this->company->config('modules') as $module): ?>
		<script type="text/javascript" src="modules/<?=$module?>/index.js"></script>
		<?php endforeach; endif; ?>

		<script type="text/javascript">
			var company = <?=json_encode($this->company)?>;
			var user = <?=json_encode($this->session->user)?>;
		</script>
		
	</head>
	
	<body class="navbar-fixed">
		
		<div class="navbar navbar-default navbar-fixed-top" id="navbar" ng-controller="TopBarCtrl">

			<div class="navbar-container" id="navbar-container">
				<div class="navbar-header pull-left">
					<a href="" class="navbar-brand">
						<small>
							<i class="icon-book"></i>
							<?=$this->company->sysname?>
						</small>
					</a>
				</div>

				<div class="navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav">
						<li class="blue">
							<a href="#/dialog">
								<i class="icon-envelope" ng-class="{'icon-animated-vertical':unread_messages>0}"></i>
								<span class="badge badge-danger" ng-show="unread_messages>0">{{unread_messages}}</span>
							</a>
						</li>
						<li class="light-blue" dropdown>
							<a href="" dropdown-toggle>
								<span class="user-info">
									<small>你好,</small>
									<?=$this->session->user_name?>
								</span>

								<i class="icon-caret-down"></i>
							</a>

							<ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								<li>
									<a href="#/user/<?=$this->user->id?>">
										<i class="icon-cog"></i>
										设置
									</a>
								</li>

								<li>
									<a href="#/detail/<?=$this->user->id?>">
										<i class="icon-user"></i>
										个人信息
									</a>
								</li>

								<li class="divider"></li>

								<li>
									<a href="<?=site_url()?>logout">
										<i class="icon-off"></i>
										退出
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="main-container" id="main-container">
			<div class="main-container-inner">
		
