<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>登录 - <?=$this->company->sysname?></title>

		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		
		<!--[if !IE]> -->
		<script type="text/javascript" src="js/jquery/jquery.min.js?v=2.1.1"></script>
		<!-- <![endif]-->
		<!--[if IE]>
		<script type="text/javascript" src="js/jquery/jquery-1.x.min.js?v=1.11.1"></script>
		<![endif]-->
					
		<link rel="stylesheet" href="css/font-awesome.min.css?v=3.2.1" />
		<link rel="stylesheet" href="css/bootstrap.min.css?v=3.2.0" />
		<link rel="stylesheet" href="css/ace.css" />
		
		<!--[if lt IE 9]>
		<link rel="stylesheet" href="css/ace-ie.css" />
		<![endif]-->

		<!--[if lt IE 9]>
		<script src="js/html5shiv.js"></script>
		<script src="js/respond.min.js"></script>
		<![endif]-->

	</head>

	<body class="login-layout">
		<div class="main-container">
			<div class="main-content">
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<div class="login-container">
							<div class="center">
								<h1>
									<i class="icon-book green"></i>
									<span class="white"><?=$this->company->sysname?></span>
								</h1>
								<h4 class="blue"><?=$this->company->name?></h4>
							</div>

							<div class="space-6"></div>

							<div class="position-relative">
								<div id="login-box" class="login-box visible widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header blue lighter bigger">
												<i class="icon-coffee green"></i>
												请输入登录信息
											</h4>

											<div class="space-6"></div>

											<form method="post">
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" name="username" class="form-control" placeholder="用户名">
															<i class="icon-user"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" name="password" class="form-control" placeholder="密码">
															<i class="icon-lock"></i>
														</span>
													</label>

													<div class="space"></div>

													<div class="clearfix">
														<label class="inline">
															<input type="checkbox" name="remember" class="ace">
															<span class="lbl"> 记住登录</span>
														</label>

														<button type="submit" name="login" class="width-35 pull-right btn btn-sm btn-primary">
															<i class="icon-key"></i>
															登录
														</button>
													</div>

													<div class="space-4"></div>
												</fieldset>
											</form>

											<?php if($this->company->config('oauth_login')){ ?>
											<div class="social-or-login center">
												<span class="bigger-110">其他登录方式</span>
											</div>
											
											<div class="social-login center">
												<?php if($this->company->config('oauth_login')->weibo){ ?>
												<a class="btn btn-primary">
													<i class="icon-weibo"></i>
												</a>
												<?php } ?>
												<?php if($this->company->config('oauth_login')->weixin){ ?>
												<a class="btn btn-info">
													<i class="icon-qrcode"></i>
												</a>
												<?php } ?>
											</div>
											<?php } ?>
										</div>

										<div class="toolbar clearfix">
											<?php if($this->company->config('allow_reset_password')){ ?>
											<div>
												<a href="#" onclick="show_box('forgot-box'); return false;" class="forgot-password-link">
													<i class="icon-arrow-left"></i>
													忘记密码
												</a>
											</div>
											<?php } ?>
											<?php if($this->company->config('allow_register')){ ?>
											<div>
												<a href="#" onclick="show_box('signup-box'); return false;" class="user-signup-link">
													我要注册
													<i class="icon-arrow-right"></i>
												</a>
											</div>
											<?php } ?>
										</div>
									</div>
								</div>

								<div id="forgot-box" class="forgot-box widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header red lighter bigger">
												<i class="icon-key"></i>
												找回密码
											</h4>

											<div class="space-6"></div>
											<p>
												输入你的Email开始找回密码
											</p>

											<form method="post">
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="email" name="email" class="form-control" placeholder="Email">
															<i class="icon-envelope"></i>
														</span>
													</label>

													<div class="clearfix">
														<button type="submit" name="forgot-password" class="width-35 pull-right btn btn-sm btn-danger">
															<i class="icon-lightbulb"></i>
															发送
														</button>
													</div>
												</fieldset>
											</form>
										</div><!-- /widget-main -->

										<div class="toolbar center">
											<a href="#" onclick="show_box('login-box'); return false;" class="back-to-login-link">
												返回到登录
												<i class="icon-arrow-right"></i>
											</a>
										</div>
									</div><!-- /widget-body -->
								</div><!-- /forgot-box -->

								<div id="signup-box" class="signup-box widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header green lighter bigger">
												<i class="icon-group blue"></i>
												新用户注册
											</h4>

											<div class="space-6"></div>
											<p> 请输入注册信息： </p>

											<form id="register" method="post">
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="email" name="email" class="form-control" placeholder="Email">
															<i class="icon-envelope"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" name="username" class="form-control" placeholder="用户名">
															<i class="icon-user"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" name="password" class="form-control" placeholder="密码">
															<i class="icon-lock"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" name="password_confirm" class="form-control" placeholder="重复密码">
															<i class="icon-retweet"></i>
														</span>
													</label>

<!--													<label class="block">
														<input type="checkbox" name="agree" class="ace">
														<span class="lbl">
															我同意
															<a href="#">使用协议</a>
														</span>
													</label>
-->
													<div class="space-24"></div>

													<div class="clearfix">
														<button type="reset" class="width-30 pull-left btn btn-sm">
															<i class="icon-refresh"></i>
															重置
														</button>

														<button type="submit" name="signup" class="width-65 pull-right btn btn-sm btn-success">
															注册
															<i class="icon-arrow-right icon-on-right"></i>
														</button>
													</div>
												</fieldset>
											</form>
										</div>

										<div class="toolbar center">
											<a href="#" onclick="show_box('login-box'); return false;" class="back-to-login-link">
												<i class="icon-arrow-left"></i>
												返回到登录
											</a>
										</div>
									</div><!-- /widget-body -->
								</div><!-- /signup-box -->
							</div>
						</div>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div>
		</div><!-- /.main-container -->

		<script type="text/javascript">
			function show_box(id) {
				jQuery('.widget-box.visible').removeClass('visible');
				jQuery('#'+id).addClass('visible');
			}
			
			jQuery(function($){
				$('form#register').on('submit', function(){
					if($(this).find('[name="password"]').val() !== $(this).find('[name="password_confirm"]').val()){
						alert('两次密码输入不一致');
						return false;
					}
				});
			});
		</script>
	</body>
</html>
