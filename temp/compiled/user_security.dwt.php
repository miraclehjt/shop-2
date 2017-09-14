<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="http://localhost/weishop/" />
<meta name="Generator" content="HongYuJD v7_2" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />

<title><?php echo $this->_var['page_title']; ?></title>



<link rel="shortcut icon" href="favicon.ico" />
<link rel="icon" href="animated_favicon.gif" type="image/gif" />
<link href="<?php echo $this->_var['ecs_css_path']; ?>" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="themes/68ecshopcom_360buy/css/new_order_member.css" />
<script type="text/javascript" src="themes/68ecshopcom_360buy/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="themes/68ecshopcom_360buy/js/validate/jquery.validate.js"></script>
<script type="text/javascript" src="themes/68ecshopcom_360buy/js/validate/messages_zh.js"></script>
<?php echo $this->smarty_insert_scripts(array('files'=>'jquery.json.js,transport.js')); ?>  <?php echo $this->smarty_insert_scripts(array('files'=>'common.js,user.js')); ?>
<script type="text/javascript">
var wait = 60;
function countdown(obj, msg) {
	obj = $(obj);

	if (wait == 0) {
		obj.removeAttr("disabled");
		obj.val(msg);
		wait = 60;
	} else {
		if (msg == undefined || msg == null) {
			msg = obj.val();
		}
		obj.attr("disabled", "disabled");
		obj.val(wait + "秒后重新获取");
		wait--;
		setTimeout(function() {
			countdown(obj, msg)
		}, 1000)
	}
}
</script>
</head>
<body>
	
	<div id="site-nav">
		<?php echo $this->fetch('library/page_header.lbi'); ?>
		<div class="blank"></div>
		
		<?php echo $this->fetch('library/ur_here.lbi'); ?>
		
		<div class="block clearfix">
			
			<div class="AreaL">
				<div class="box">
					<?php echo $this->fetch('library/user_info.lbi'); ?>
					<?php echo $this->fetch('library/user_menu.lbi'); ?>
				</div>
			</div>
			
			
			<div class="AreaR">
				<div class="box">
					<div class="box_1">
						<div class="userCenterBox boxCenterList clearfix" style="_height: 1%;">
							
							<?php if ($this->_var['action'] == 'account_security'): ?>
							<h5 class="user-title user-title-t">
								<span>
									安全级别：
									
									<?php if ($this->_var['info']['is_validated'] == 0 && $this->_var['info']['validated'] == 0 && $this->_var['info']['is_surplus_open'] == 0): ?>很危险&nbsp;
									<i class="validated1"></i>
									&nbsp;建议您启动全部安全设置，以保障账户及资金安全<?php endif; ?> <?php if ($this->_var['info']['is_validated'] == 0 && $this->_var['info']['validated'] == 0 && $this->_var['info']['is_surplus_open'] == 1): ?>较低&nbsp;
									<i class="validated2"></i>
									&nbsp;建议您启动全部安全设置，以保障账户及资金安全<?php endif; ?> <?php if ($this->_var['info']['is_validated'] == 0 && $this->_var['info']['validated'] == 1 && $this->_var['info']['is_surplus_open'] == 0): ?>较低&nbsp;
									<i class="validated2"></i>
									&nbsp;建议您启动全部安全设置，以保障账户及资金安全<?php endif; ?> <?php if ($this->_var['info']['is_validated'] == 1 && $this->_var['info']['validated'] == 0 && $this->_var['info']['is_surplus_open'] == 0): ?>较低&nbsp;
									<i class="validated2"></i>
									&nbsp;建议您启动全部安全设置，以保障账户及资金安全<?php endif; ?> <?php if ($this->_var['info']['is_validated'] == 0 && $this->_var['info']['validated'] == 1 && $this->_var['info']['is_surplus_open'] == 1): ?>一般&nbsp;
									<i class="validated3"></i>
									<?php endif; ?> <?php if ($this->_var['info']['is_validated'] == 1 && $this->_var['info']['validated'] == 1 && $this->_var['info']['is_surplus_open'] == 0): ?>一般&nbsp;
									<i class="validated3"></i>
									<?php endif; ?> <?php if ($this->_var['info']['is_validated'] == 1 && $this->_var['info']['validated'] == 0 && $this->_var['info']['is_surplus_open'] == 1): ?>一般&nbsp;
									<i class="validated3"></i>
									<?php endif; ?> <?php if ($this->_var['info']['is_validated'] == 1 && $this->_var['info']['validated'] == 1 && $this->_var['info']['is_surplus_open'] == 1): ?>高&nbsp;
									<i class="validated5"></i>
									<?php endif; ?>
									
								</span>
							</h5>
							<div class="blank"></div>
							<div class="m m5" id="safe05">
								<div class="mc">
									<div class="fore1">
										<s class="fore1_3"></s>
										<strong>登录密码</strong>
									</div>
									<div class="fore2">
										<span class="ftx-03">互联网账号存在被盗风险，建议您定期更改密码以保护账户安全。</span>
										<span style="color: #CF0F02;"></span>
									</div>
									<div class="fore3">
										<input type="button" value="修改" onclick="window.location.href='security.php?act=password_reset'" class="btn btn-7" />
									</div>
								</div>
								<div class="mc">
									<div class="fore1">
										<s class="<?php if ($this->_var['info']['is_validated'] == 0): ?>fore1_1<?php else: ?>fore1_3<?php endif; ?>"></s>
										<strong>邮箱验证</strong>
									</div>
									<div class="fore2">
										<?php if ($this->_var['info']['is_validated'] == 0): ?>
										<span style="color: #ED5854;">验证后，可用于快速找回登录密码，接收账户余额变动提醒</span>
										<?php else: ?>
										<span class="ftx-03">您验证的邮箱：<?php echo $this->_var['info']['email']; ?><?php endif; ?></span>
									</div>
									<div class="fore3">
										<?php if ($this->_var['info']['email'] == ''): ?>
										<a href="security.php?act=email_binding" class="btn btn-7">绑定邮箱</a>
										<?php elseif ($this->_var['info']['is_validated'] == 0): ?>
										<input type="button" value="验证邮箱" onclick="window.location.href='security.php?act=email_validate'" class="btn btn-7" />
										<input type="button" value="修改" onclick="window.location.href='security.php?act=email_binding'" class="btn btn-7" />
										<?php else: ?>
										<input type="button" value="修改" onclick="window.location.href='security.php?act=email_binding'" class="btn btn-7" />
										<?php endif; ?>
									</div>
								</div>
								<div class="mc">
									<div class="fore1">
										<s class="<?php if ($this->_var['info']['validated'] == 0): ?>fore1_1<?php else: ?>fore1_3<?php endif; ?>"></s>
										<strong>手机验证</strong>
									</div>
									<div class="fore2">
										<?php if ($this->_var['info']['validated'] == 0): ?>
										<span style="color: #ED5854;">验证后，可用于快速找回登录密码及支付密码，接收账户余额变动提醒</span>
										<?php else: ?>
										<span class="ftx-03">您验证的手机：<?php echo $this->_var['info']['mobile_phone']; ?>,若已丢失或停用，请立即更换，避免账户被盗<?php endif; ?></span>
									</div>
									<div class="fore3">
										<?php if ($this->_var['info']['mobile_phone'] == ''): ?>
										<a href="security.php?act=mobile_binding" class="btn btn-7">绑定手机</a>
										<?php elseif ($this->_var['info']['validated'] == 0): ?>
										<input type="button" value="验证手机" onclick="window.location.href='security.php?act=mobile_validate'" class="btn btn-7" />
										<input type="button" value="修改" onclick="window.location.href='security.php?act=mobile_binding'" class="btn btn-7" />
										<?php else: ?>
										<input type="button" value="修改" onclick="window.location.href='security.php?act=mobile_binding'" class="btn btn-7" />
										<?php endif; ?>
									</div>
								</div>
								
								<div class="mc" id="surplus-mc">
									<div class="fore1">
										<s class="<?php if ($this->_var['info']['is_surplus_open'] == 0): ?>fore1_1<?php else: ?>fore1_3<?php endif; ?>"></s>
										<strong>余额支付</strong>
									</div>
									<div class="fore2">
										<?php if ($this->_var['info']['is_surplus_open'] == 0): ?>
										<span style="color: #CF0F02;">开启后，可保障您账户余额支付的安全</span>
										<?php else: ?>
										<span class="ftx-03">您已开启账户余额支付密码功能<?php endif; ?></span>
									</div>
									<div class="fore3">
										<?php if ($this->_var['info']['is_surplus_open'] == 0): ?>
										<input type="button" value="开启支付密码" onclick="window.location.href='security.php?act=payment_password_reset'" class="btn btn-7" />
										<?php else: ?>
										<input type="button" value="关闭支付密码" onclick="window.location.href='security.php?act=payment_password_close'" class="btn btn-7" />
										<?php endif; ?>
                                    </div>
                                    <div class="fore4">
                        				<p>
                        					<a href="security.php?act=payment_password_reset">忘记支付密码？</a>
                            			</p>
                            			<p>
                        					<a href="security.php?act=payment_password_reset">修改支付密码</a>
                            			</p>
                        			</div>
								</div>
								
								
								<?php if ($this->_var['is_supplier'] == 1): ?>
								<div class="mc">
									<div class="fore1">
										<s class="<?php if ($this->_var['info']['is_surplus_open'] == 0): ?>fore1_1<?php else: ?>fore1_3<?php endif; ?>"></s>
										<strong>我是卖家</strong>
									</div>
									<div class="fore2">
										<span style="color: #CF0F02;">同步后，可以用您当前的用户名、邮箱、手机号登录商家后台</span>
									</div>
									<div class="fore3">
										<input type="button" value="同步" onclick="window.location.href='security.php?act=sync_supplier'" class="btn btn-7" />
                                    </div>
                                    <div class="fore4">
                                    	<!-- 
                        				<p>
                        					<a href="security.php?act=payment_password_reset">忘记支付密码？</a>
                            			</p>
                            			<p>
                        					<a href="security.php?act=payment_password_reset">修改支付密码</a>
                            			</p>
                            			 -->
                        			</div>
									</div>
								</div>
								<?php endif; ?>
								
							</div>
							</div>
							<?php endif; ?>
							
							
							<?php if ($this->_var['action'] == 'password_reset'): ?>
							<h5 title="修改登录密码" class="user-title user-title-t">
								<span>修改登录密码</span>
							</h5>
							<?php if ($this->_var['step'] == 'step_1'): ?>
							<div class="blank" ></div>
							<div id="find_pw" class="find_pw2">
								<div class="find_con">
									<div id="sflex04" class="stepflex">
										<dl class="first doing">
											<dt class="s-num">1</dt>
											<dd class="s-text">
												验证身份
												<s></s>
												<b></b>
											</dd>
										</dl>
										<dl class="normal">
											<dt class="s-num">2</dt>
											<dd class="s-text">
												设置新密码
												<s></s>
												<b></b>
											</dd>
										</dl>
										<dl class="last">
											<dt class="s-num">&nbsp;</dt>
											<dd class="s-text">
												完成
												<s></s>
												<b></b>
											</dd>
										</dl>
									</div>
									<div id="find-box" class="uc_box">
										<form action="security.php" method="post" id="fpForm" name="fpForm">
											<div id="error_container"></div>
											<div class="item">
												<label class="con_un">请选择验证身份方式：</label>
												<select id="validate_type" name="validate_type">
													<?php $_from = $this->_var['validate_types']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
													<option id="validate_type_<?php echo $this->_var['item']['type']; ?>" value="<?php echo $this->_var['item']['type']; ?>" val="<?php echo $this->_var['item']['value']; ?>"><?php echo $this->_var['item']['name']; ?></option>
													<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
												</select>
											</div>
											<div class="item v_mobile_phone v_item" style="display: none">
												<label class="con_un">手机号：</label>
												<span id="l_mobile_phone"></span>
											</div>
											<div id="c_mobile_code" class="item v_mobile_phone v_item" style="display: none">
												<label class="con_un">请输入手机验证码：</label>
												<input type="text" id="mobile_code" name="mobile_code" class="text text_te2" value="" />
												<input id="zphone" type="button" value="获取手机验证码" class="code" />
											</div>
											<div class="item v_email v_item" style="display: none">
												<label class="con_un">邮箱地址：</label>
												<span id="l_email"></span>
											</div>
											<div id="c_email" class="item v_email v_item" style="display: none">
												<label class="con_un">请输入邮箱验证码：</label>
												<input type="text" id="email_code" name="email_code" class="text text_te2" value="" />
												<input id="zemail" type="button" value="获取邮箱验证码" class="code" />
											</div>
											<div class="item v_password v_item" style="display: none">
												<label class="con_un">用户名：</label>
												<span id="l_password"></span>
											</div>
											<div id="c_password" class="item v_password v_item" style="display: none">
												<label class="con_un">请输入登录密码：</label>
												<input type="password" id="password" name="password" class="text text_te2" value="" />
											</div>
											<div class="item">
												<label class="con_un">请输入验证码：</label>
												<input type="text" id="captcha" name="captcha" class="text text_te" placeholder="<?php echo $this->_var['lang']['comment_captcha']; ?>" style="ime-mode: disabled" autocomplete="off" MaxLength="6" />
												<label class="img" style="margin-left: 5px">
													<img src="captcha.php?<?php echo $this->_var['rand']; ?>" alt="captcha" style="vertical-align: middle; cursor: pointer;" onClick="this.src='captcha.php?'+Math.random();$('#captcha').focus();" />
												</label>
											</div>
											<div class="item">
                                            	<label class="con_un">&nbsp;</label>
												<input type="hidden" name="act" value="to_password_reset" />
												<input type="button" name="button" id="btn_submit" class="btn_next" value="提交" />
											</div>
										</form>
									</div>
								</div>
								<script type="text/javascript">
								function show_validate_type(validate_type_obj){
									var type = $(validate_type_obj).val();
									var value = $("#validate_type_"+type).attr("val");
									$("#l_"+type).html(value);
									$(".v_item").hide();
									$(".v_"+type).show();
								}
								
								function send_email_code(emailCodeObj, sendButton){
									// 发送邮件
									var url = 'validate.php';
									$.post(url, {
										act: 'send_email_code'
									}, function(result) {
										if (result == 'ok') {
											//倒计时
											countdown(sendButton);
										} else {
											alert(result);
										}
									}, 'text');
								}
								
								function send_mobile_code(mobileCodeObj, sendButton) {
									// 发送邮件
									var url = 'validate.php';
									$.post(url, {
										act: 'send_mobile_code'
									}, function(result) {
										if (result == 'ok') {
											//倒计时
											countdown(sendButton);
										} else {
											alert(result);
										}
									}, 'text');
								}
								
								$().ready(function(){
									
									show_validate_type($("#validate_type"));
									
									var validator = $("#fpForm").validate({
										debug: false,
										rules: {
											mobile_code: {
												required: true
											},
											email_code: {
												required: true
											},
											captcha: {
												required: true
											}
										},
										messages: {
											mobile_code: {
												required: "请输入手机验证码"
											},
											email_code: {
												required: "请输入邮箱验证码"
											},
											captcha: {
												required: "请输入验证码"
											}
										},
										errorPlacement: function(error, element) {
											error.appendTo(element.parent());  
										}
									});
									
									$("#validate_type").change(function(){
										show_validate_type($(this));
									});
									
									$("#zphone").click(function(){
										send_mobile_code($("#mobile_code"), $(this));
									});
									
									$("#zemail").click(function(){
										send_email_code($("#email_code"), $(this));
									});
									
									$("#btn_submit").click(function(){
										
										if(!validator.form()){
											return;
										}
										
										var type = $("#validate_type").val();
										
										var url = "security.php";
										var validate_type = $("#validate_type").val();
										$.post(url, {act: "validate", mobile_code: $("#mobile_code").val(), email_code: $("#email_code").val(), password: $("#password").val(), validate_type: validate_type, captcha: $("#captcha").val()}, function(data){
											if(data.error == 1){
												alert(data.content);
												if(data.url != undefined && data.url.length > 0){
													window.location.href = data.url;
												}
											}else{
												$("#fpForm").submit();
											}
										}, "json");
									});
									
								});
							</script>
							</div>
							<?php endif; ?>
							<?php if ($this->_var['step'] == 'step_2'): ?>
							<div class="blank"></div>
							<div id="find_pw3">
								<div class="find_con">
									<div id="sflex04" class="stepflex">
										<dl class="first done">
											<dt class="s-num">1</dt>
											<dd class="s-text">
												验证身份
												<s></s>
												<b></b>
											</dd>
										</dl>
										<dl class="normal doing">
											<dt class="s-num">2</dt>
											<dd class="s-text">
												设置新密码
												<s></s>
												<b></b>
											</dd>
										</dl>
										<dl class="last">
											<dt class="s-num">&nbsp;</dt>
											<dd class="s-text">
												完成
												<s></s>
												<b></b>
											</dd>
										</dl>
									</div>
									<div id="find-box" class="uc_box">
										<form action="security.php" method="post" id="fpForm" name="fpForm">
											<div id="error_container"></div>
											<div class="item">
												<label class="con_un">设置密码</label>
												<input name="password" id="password" type="password" tabindex="1" placeholder="请输入密码" class="text" />
											</div>
											<div class="item">
												<label class="con_un">确认密码</label>
												<input name="confirm_password" id="confirm_password" type="password" tabindex="2" placeholder="请再次确认密码" class="text" />
											</div>
											<div class="item">
                                            	<label class="con_un">&nbsp;</label>
												<input type="hidden" name="act" value="password_reset_success" />
												<input type="button" id="btn_submit" name="btn_submit" class="btn_next" value="提交" />
											</div>
										</form>
									</div>
								</div>
								<script type="text/javascript">
								$().ready(function(){
								var validator = $("#fpForm").validate({
									debug: false,
									rules: {
										password: {
											required: true,
											minlength: 6
										},
										confirm_password: {
											required: true,
											equalTo: "#password"
										}
									},
									messages: {
										password: {
											required: "请输入密码",
											minlength: "登录密码不能少于 6 个字符"
										},
										confirm_password: {
											required: "请再次输入新密码",
											equalTo: "两次输入的密码不一致，请重新输入"
										}
									},
									errorPlacement: function(error, element) {
										error.appendTo(element.parent());  
									}
								});
								
								$("#btn_submit").click(function(){
									if(!validator.form()){
										return;
									}
									
									var url = "security.php";
									$.post(url, {act: 'do_password_reset', password: $("#password").val()}, function(data){
										if(data.error == 1){
											alert(data.content);
											if(data.url != undefined && data.url.length > 0){
												window.location.href = data.url;
											}
										}else{
											$("#fpForm").submit();
										}
									}, "json");
										
								});
							});
							</script>
							</div>
							<?php endif; ?>
							<?php if ($this->_var['step'] == 'step_3'): ?>
							
							<div class="blank"></div>
							<div id="find_pw3">
								<div class="find_con">
									<div id="sflex04" class="stepflex">
										<dl class="first done">
											<dt class="s-num">1</dt>
											<dd class="s-text">
												验证身份
												<s></s>
												<b></b>
											</dd>
										</dl>
										<dl class="normal done">
											<dt class="s-num">2</dt>
											<dd class="s-text">
												设置新密码
												<s></s>
												<b></b>
											</dd>
										</dl>
										<dl class="last doing">
											<dt class="s-num">&nbsp;</dt>
											<dd class="s-text">
												完成
												<s></s>
												<b></b>
											</dd>
										</dl>
									</div>
									<div id="find-box" class="uc_box">
										<div class="find_box_end">
											<p>
												<i></i>
												新密码设置成功！
											</p>
											<p>请您牢记新密码！</p>
											<p class="on_go">
												<a href="security.php" title="立即购物" class="back">返回账户安全中心&gt;&gt;</a>
											</p>
										</div>
									</div>
								</div>
							</div>
							<?php endif; ?>
							<?php endif; ?>
							
							<?php if ($this->_var['action'] == 'email_binding'): ?>
							<h5 title="邮箱绑定" class="user-title user-title-t">
								<span>邮箱绑定</span>
							</h5>
							
							<?php if ($this->_var['step'] == 'step_1'): ?>
							<div class="blank" ></div>
							<div id="find_pw" class="find_pw2">
								<div class="find_con">
									<div id="sflex04" class="stepflex">
										<dl class="first doing">
											<dt class="s-num">1</dt>
											<dd class="s-text">
												验证身份
												<s></s>
												<b></b>
											</dd>
										</dl>
										<dl class="normal">
											<dt class="s-num">2</dt>
											<dd class="s-text">
												邮箱绑定
												<s></s>
												<b></b>
											</dd>
										</dl>
										<dl class="last">
											<dt class="s-num">&nbsp;</dt>
											<dd class="s-text">
												完成
												<s></s>
												<b></b>
											</dd>
										</dl>
									</div>
									<div id="find-box" class="uc_box">
										<form action="security.php" method="post" id="fpForm" name="fpForm">
											<div id="error_container"></div>
											<div class="item">
												<label class="con_un">请选择验证身份方式：</label>
												<select id="validate_type" name="validate_type">
													<?php $_from = $this->_var['validate_types']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
													<option id="validate_type_<?php echo $this->_var['item']['type']; ?>" value="<?php echo $this->_var['item']['type']; ?>" val="<?php echo $this->_var['item']['value']; ?>"><?php echo $this->_var['item']['name']; ?></option>
													<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
												</select>
											</div>
											<div class="item v_mobile_phone v_item" style="display: none">
												<label class="con_un">您的手机号：</label>
												<span id="l_mobile_phone"></span>
											</div>
											<div id="c_mobile_code" class="item v_mobile_phone v_item" style="display: none">
												<label class="con_un">请输入手机验证码：</label>
												<input type="text" id="mobile_code" name="mobile_code" class="text text_te2" value="" />
												<input id="zphone" type="button" value="获取手机验证码" class="code" />
											</div>
											<div class="item v_email v_item" style="display: none">
												<label class="con_un">您的邮箱地址：</label>
												<span id="l_email"></span>
											</div>
											<div id="c_email" class="item v_email v_item" style="display: none">
												<label class="con_un">请输入邮箱验证码：</label>
												<input type="text" id="email_code" name="email_code" class="text text_te2" value="" />
												<input id="zemail" type="button" value="获取邮箱验证码" class="code" />
											</div>
											<div class="item v_password v_item" style="display: none">
												<label class="con_un">用户名：</label>
												<span id="l_password"></span>
											</div>
											<div id="c_password" class="item v_password v_item" style="display: none">
												<label class="con_un">请输入登录密码：</label>
												<input type="password" id="password" name="password" class="text text_te2" value="" />
											</div>
											<div class="item">
												<label class="con_un">请输入验证码：</label>
												<input type="text" id="captcha" size="8" name="captcha" class="text text_te" placeholder="<?php echo $this->_var['lang']['comment_captcha']; ?>" style="ime-mode: disabled" autocomplete="off" MaxLength="6" />
												<label class="img" style="margin-left: 5px">
													<img src="captcha.php?<?php echo $this->_var['rand']; ?>" alt="captcha" style="vertical-align: middle; cursor: pointer;" onClick="this.src='captcha.php?'+Math.random();$('#captcha').focus();" />
												</label>
											</div>
											<div class="item">
                                            <label class="con_un">&nbsp;</label>
												<input type="hidden" name="act" value="to_email_binding" />
												<input type="button" name="button" id="btn_submit" class="btn_next" value="提交" />
											</div>
										</form>
									</div>
								</div>
								<script type="text/javascript">
								function show_validate_type(validate_type_obj){
									var type = $(validate_type_obj).val();
									var value = $("#validate_type_"+type).attr("val");
									$("#l_"+type).html(value);
									$(".v_item").hide();
									$(".v_"+type).show();
								}
								
								function send_email_code(emailCodeObj, sendButton){
									// 发送邮件
									var url = 'validate.php';
									$.post(url, {
										act: 'send_email_code'
									}, function(result) {
										if (result == 'ok') {
											//倒计时
											countdown(sendButton);
										} else {
											alert(result);
										}
									}, 'text');
								}
								
								function send_mobile_code(mobileCodeObj, sendButton) {
									// 发送邮件
									var url = 'validate.php';
									$.post(url, {
										act: 'send_mobile_code'
									}, function(result) {
										if (result == 'ok') {
											//倒计时
											countdown(sendButton);
										} else {
											alert(result);
										}
									}, 'text');
								}
								
								$().ready(function(){
									
									show_validate_type($("#validate_type"));
									
									var validator = $("#fpForm").validate({
										debug: false,
										rules: {
											mobile_code: {
												required: true
											},
											email_code: {
												required: true
											},
											captcha: {
												required: true
											}
										},
										messages: {
											mobile_code: {
												required: "请输入手机验证码"
											},
											email_code: {
												required: "请输入邮箱验证码"
											},
											captcha: {
												required: "请输入验证码"
											}
										},
										errorPlacement: function(error, element) {
											error.appendTo(element.parent());  
										}
									});
									
									$("#validate_type").change(function(){
										show_validate_type($(this));
									});
									
									$("#zphone").click(function(){
										send_mobile_code($("#mobile_code"), $(this));
									});
									
									$("#zemail").click(function(){
										send_email_code($("#email_code"), $(this));
									});
									
									$("#btn_submit").click(function(){
										
										if(!validator.form()){
											return;
										}
										
										var type = $("#validate_type").val();
										
										var url = "security.php";
										var validate_type = $("#validate_type").val();
										$.post(url, {act: "validate", mobile_code: $("#mobile_code").val(), email_code: $("#email_code").val(), password: $("#password").val(), validate_type: validate_type, captcha: $("#captcha").val()}, function(data){
											if(data.error == 1){
												alert(data.content);
												if(data.url != undefined && data.url.length > 0){
													window.location.href = data.url;
												}
											}else{
												$("#fpForm").submit();
											}
										}, "json");
									});
									
								});
							</script>
							</div>
							<?php endif; ?>
							<?php if ($this->_var['step'] == 'step_2'): ?>
							<div class="blank"></div>
							<div id="find_pw3">
								<div class="find_con">
									<div id="sflex04" class="stepflex">
										<dl class="first done">
											<dt class="s-num">1</dt>
											<dd class="s-text">
												验证身份
												<s></s>
												<b></b>
											</dd>
										</dl>
										<dl class="normal doing">
											<dt class="s-num">2</dt>
											<dd class="s-text">
												邮箱绑定
												<s></s>
												<b></b>
											</dd>
										</dl>
										<dl class="last">
											<dt class="s-num">&nbsp;</dt>
											<dd class="s-text">
												完成
												<s></s>
												<b></b>
											</dd>
										</dl>
									</div>
									<div id="find-box" class="uc_box">
										<form action="security.php" method="post" id="fpForm" name="fpForm">
											<div id="error_container"></div>
											<div class="item">
												<label class="con_un">您的邮箱地址：</label>
												<input name="email" id="email" type="text" tabindex="1" placeholder="请输入邮箱地址" class="text" />
											</div>
											<div class="item">
												<label class="con_un">邮箱验证码：</label>
												<input name="email_code" id="email_code" type="text" tabindex="2" placeholder="请输入邮箱验证码" class="text text_te" />
												<input id="zemail" type="button" value="获取邮箱验证码" class="code" />
											</div>
											<div class="item">
                                            <label class="con_un">&nbsp;</label>
												<input type="hidden" name="act" value="email_binding_success" />
												<input type="button" id="btn_submit" name="btn_submit" class="btn_next" value="提交" />
											</div>
										</form>
									</div>
								</div>
								<script type="text/javascript">
								function send_email_code(emailCodeObj, sendButton){
									// 发送邮件
									var url = 'security.php';
									$.post(url, {
										act: 'send_email_code', 
										email: $("#email").val()
									}, function(result) {
										if (result == 'ok') {
											//倒计时
											countdown(sendButton);
										} else {
											alert(result);
										}
									}, 'text');
								}
								
								$().ready(function(){
									
									var validator = $("#fpForm").validate({
										debug: false,
										rules: {
											email: {
												required: true,
												email: true,
												remote: {  
												    url: "security.php",     //后台处理程序  
												    type: "post",               //数据发送方式  
												    dataType: "json",           //接受数据格式     
												    data: {                     //要传递的数据  
												    	act: 'check_email_exist',
												        email: function() {  
												            return $("#email").val();  
												        }  
												    }
												}
											},
											email_code: {
												required: true
											}
										},
										messages: {
											email: {
												required: "请输入邮箱验证码",
												email: "邮箱格式不正确",
												remote: "邮箱已存在"
											},
											email_code: {
												required: "请输入邮箱验证码"
											}
										},
										errorPlacement: function(error, element) {
											error.appendTo(element.parent());  
										}
									});
																		
									$("#email").blur(function(){
										$("#email").valid();
									});
									
									$("#zemail").click(function(){
										if(!$("#email").valid()){
											return;
										}
										send_email_code($("#email_code"), $(this));
									});
									
									$("#btn_submit").click(function(){
										
										if(!validator.form()){
											return;
										}
										
										var type = $("#validate_type").val();
										
										var url = "security.php";
										$.post(url, {act: "do_email_binding", email: $("#email").val(), email_code: $("#email_code").val()}, function(data){
											if(data.error == 1){
												alert(data.content);
												if(data.url != undefined && data.url.length > 0){
													window.location.href = data.url;
												}
											}else{
												$("#fpForm").submit();
											}
										}, "json");
									});
									
								});
							</script>
							</div>
							<?php endif; ?>
							<?php if ($this->_var['step'] == 'step_3'): ?>
							<div class="blank"></div>
							<div id="find_pw3">
								<div class="find_con">
									<div id="sflex04" class="stepflex">
										<dl class="first done">
											<dt class="s-num">1</dt>
											<dd class="s-text">
												验证身份
												<s></s>
												<b></b>
											</dd>
										</dl>
										<dl class="normal done">
											<dt class="s-num">2</dt>
											<dd class="s-text">
												绑定邮箱
												<s></s>
												<b></b>
											</dd>
										</dl>
										<dl class="last doing">
											<dt class="s-num">&nbsp;</dt>
											<dd class="s-text">
												完成
												<s></s>
												<b></b>
											</dd>
										</dl>
									</div>
									<div id="find-box" class="uc_box">
										<div class="find_box_end">
											<p>
												<i></i>
												绑定邮箱成功！
											</p>
											<p class="on_go">
												<a href="security.php" title="立即购物" class="back">返回账户安全中心&gt;&gt;</a>
											</p>
										</div>
									</div>
								</div>
							</div>
							<?php endif; ?>
							
							<?php endif; ?>
							
							<?php if ($this->_var['action'] == 'email_validate'): ?>
							<h5 title="邮箱验证" class="user-title user-title-t">
								<span>邮箱验证</span>
							</h5>
							
							<?php if ($this->_var['step'] == 'step_1'): ?>
							<div class="blank"></div>
							<div id="find_pw3">
								<div class="find_con">
									<div id="sflex04" class="stepflex stepflex_te">
										<dl class="first doing">
											<dt class="s-num">1</dt>
											<dd class="s-text">
												邮箱验证
												<s></s>
												<b></b>
											</dd>
										</dl>
										<dl class="last">
											<dt class="s-num">&nbsp;</dt>
											<dd class="s-text">
												完成
												<s></s>
												<b></b>
											</dd>
										</dl>
									</div>
									<div id="find-box" class="uc_box">
										<form action="security.php" method="post" id="fpForm" name="fpForm">
											<div id="error_container"></div>
											<div class="item">
												<label class="con_un">您的邮箱地址：</label>
												<span id="l_email"><?php echo $this->_var['email']; ?></span>
											</div>
											<div class="item">
												<label class="con_un">请输入邮箱验证码：</label>
												<input name="email_code" id="email_code" type="text" tabindex="2" placeholder="请输入邮箱验证码" class="text text_te" />
												<input id="zemail" type="button" value="获取邮箱验证码" class="code" />
											</div>
											<div class="item">
												<label class="con_un">请输入验证码：</label>
												<input type="text" id="captcha" size="8" name="captcha" class="text text_te" placeholder="<?php echo $this->_var['lang']['comment_captcha']; ?>" style="ime-mode: disabled" autocomplete="off" MaxLength="6" />
												<label class="img" style="margin-left: 5px">
													<img src="captcha.php?<?php echo $this->_var['rand']; ?>" alt="captcha" style="vertical-align: middle; cursor: pointer;" onClick="this.src='captcha.php?'+Math.random();$('#captcha').focus();" />
												</label>
											</div>
											<div class="item">
                                            <label class="con_un">&nbsp;</label>
												<input type="hidden" name="act" value="email_validate_success" />
												<input type="button" id="btn_submit" name="btn_submit" class="btn_next" value="提交" />
											</div>
										</form>
									</div>
								</div>
								<script type="text/javascript">
								function send_email_code(emailCodeObj, sendButton){
									// 发送邮件
									var url = 'validate.php';
									$.post(url, {
										act: 'send_email_code'
									}, function(result) {
										if (result == 'ok') {
											//倒计时
											countdown(sendButton);
										} else {
											alert(result);
										}
									}, 'text');
								}
								
								$().ready(function(){
									
									var validator = $("#fpForm").validate({
										debug: false,
										rules: {
											captcha: {
												required: true
											},
											email_code: {
												required: true
											}
										},
										messages: {
											captcha: {
												required: "请输入验证码"
											},
											email_code: {
												required: "请输入邮箱验证码"
											}
										},
										errorPlacement: function(error, element) {
											error.appendTo(element.parent());  
										}
									});
									
									$("#zemail").click(function(){
										send_email_code($("#email_code"), $(this));
									});
									
									$("#btn_submit").click(function(){
										
										if(!validator.form()){
											return;
										}
										
										var type = $("#validate_type").val();
										
										var url = "security.php";
										$.post(url, {act: "do_email_validate", email_code: $("#email_code").val(), captcha: $("#captcha").val()}, function(data){
											if(data.error == 1){
												alert(data.content);
												if(data.url != undefined && data.url.length > 0){
													window.location.href = data.url;
												}
											}else{
												$("#fpForm").submit();
											}
										}, "json");
									});
									
								});
							</script>
							</div>
							<?php endif; ?>
							<?php if ($this->_var['step'] == 'step_2'): ?>
							<div class="blank"></div>
							<div id="find_pw3">
								<div class="find_con">
									<div id="sflex04" class="stepflex stepflex_te">
										<dl class="normal done">
											<dt class="s-num">1</dt>
											<dd class="s-text">
												邮箱验证
												<s></s>
												<b></b>
											</dd>
										</dl>
										<dl class="last doing">
											<dt class="s-num">&nbsp;</dt>
											<dd class="s-text">
												完成
												<s></s>
												<b></b>
											</dd>
										</dl>
									</div>
									<div id="find-box" class="uc_box">
										<div class="find_box_end">
											<p>
												<i></i>
												邮箱验证成功！
											</p>
											<p class="on_go">
												<a href="security.php" title="立即购物" class="back">返回账户安全中心&gt;&gt;</a>
											</p>
										</div>
									</div>
								</div>
							</div>
							<?php endif; ?>
							
							<?php endif; ?>
							
							<?php if ($this->_var['action'] == 'email_reset'): ?>
							
							<?php if ($this->_var['step'] == 'step_1'): ?>
							
							<?php endif; ?>
							<?php if ($this->_var['step'] == 'step_2'): ?>
							
							<?php endif; ?>
							<?php if ($this->_var['step'] == 'step_3'): ?>
							<div class="blank"></div>
							<div id="find_pw3">
								<div class="find_con">
									<div id="sflex04" class="stepflex">
										<dl class="first done">
											<dt class="s-num">1</dt>
											<dd class="s-text">
												验证身份
												<s></s>
												<b></b>
											</dd>
										</dl>
										<dl class="normal done">
											<dt class="s-num">2</dt>
											<dd class="s-text">
												设置新邮箱
												<s></s>
												<b></b>
											</dd>
										</dl>
										<dl class="last doing">
											<dt class="s-num">&nbsp;</dt>
											<dd class="s-text">
												完成
												<s></s>
												<b></b>
											</dd>
										</dl>
									</div>
									<div id="find-box" class="uc_box">
										<div class="find_box_end">
											<p>
												<i></i>
												设置新邮箱成功！
											</p>
											<p class="on_go">
												<a href="security.php" title="立即购物" class="back">返回账户安全中心&gt;&gt;</a>
											</p>
										</div>
									</div>
								</div>
							</div>
							<?php endif; ?>
							
							<?php endif; ?>
							
							<?php if ($this->_var['action'] == 'mobile_binding'): ?>
							
							<h5 title="手机绑定" class="user-title user-title-t">
								<span>手机绑定</span>
							</h5>
							<?php if ($this->_var['step'] == 'step_1'): ?>
							<div class="blank" ></div>
							<div id="find_pw" class="find_pw2">
								<div class="find_con">
									<div id="sflex04" class="stepflex">
										<dl class="first doing">
											<dt class="s-num">1</dt>
											<dd class="s-text">
												验证身份
												<s></s>
												<b></b>
											</dd>
										</dl>
										<dl class="normal">
											<dt class="s-num">2</dt>
											<dd class="s-text">
												手机绑定
												<s></s>
												<b></b>
											</dd>
										</dl>
										<dl class="last">
											<dt class="s-num">&nbsp;</dt>
											<dd class="s-text">
												完成
												<s></s>
												<b></b>
											</dd>
										</dl>
									</div>
									<div id="find-box" class="uc_box">
										<form action="security.php" method="post" id="fpForm" name="fpForm">
											<div id="error_container"></div>
											<div class="item">
												<label class="con_un">请选择验证身份方式：</label>
												<select id="validate_type" name="validate_type">
													<?php $_from = $this->_var['validate_types']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
													<option id="validate_type_<?php echo $this->_var['item']['type']; ?>" value="<?php echo $this->_var['item']['type']; ?>" val="<?php echo $this->_var['item']['value']; ?>"><?php echo $this->_var['item']['name']; ?></option>
													<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
												</select>
											</div>
											<div class="item v_mobile_phone v_item" style="display: none">
												<label class="con_un">您的手机号：</label>
												<span id="l_mobile_phone"></span>
											</div>
											<div id="c_mobile_code" class="item v_mobile_phone v_item" style="display: none">
												<label class="con_un">请输入手机验证码：</label>
												<input type="text" id="mobile_code" name="mobile_code" class="text text_te2" value="" />
												<input id="zphone" type="button" value="获取手机验证码" class="code" />
											</div>
											<div class="item v_email v_item" style="display: none">
												<label class="con_un">邮箱地址：</label>
												<span id="l_email"></span>
											</div>
											<div id="c_email" class="item v_email v_item" style="display: none">
												<label class="con_un">请输入邮箱验证码：</label>
												<input type="text" id="email_code" name="email_code" class="text text_te2" value="" />
												<input id="zemail" type="button" value="获取邮箱验证码" class="code" />
											</div>
											<div class="item v_password v_item" style="display: none">
												<label class="con_un">用户名：</label>
												<span id="l_password"></span>
											</div>
											<div id="c_password" class="item v_password v_item" style="display: none">
												<label class="con_un">请输入登录密码：</label>
												<input type="password" id="password" name="password" class="text text_te2" value="" />
											</div>
											<div class="item">
												<label class="con_un">请输入验证码：</label>
												<input type="text" id="captcha" size="8" name="captcha" class="text text_te" placeholder="<?php echo $this->_var['lang']['comment_captcha']; ?>" style="ime-mode: disabled" autocomplete="off" MaxLength="6" />
												<label class="img" style="margin-left: 5px">
													<img src="captcha.php?<?php echo $this->_var['rand']; ?>" alt="captcha" style="vertical-align: middle; cursor: pointer;" onClick="this.src='captcha.php?'+Math.random();$('#captcha').focus();" />
												</label>
											</div>
											<div class="item">
                                            <label class="con_un">&nbsp;</label>
												<input type="hidden" name="act" value="to_mobile_binding" />
												<input type="button" name="button" id="btn_submit" class="btn_next" value="提交" />
											</div>
										</form>
									</div>
								</div>
								<script type="text/javascript">
								function show_validate_type(validate_type_obj){
									var type = $(validate_type_obj).val();
									var value = $("#validate_type_"+type).attr("val");
									$("#l_"+type).html(value);
									$(".v_item").hide();
									$(".v_"+type).show();
								}
								
								function send_email_code(emailCodeObj, sendButton){
									// 发送邮件
									var url = 'validate.php';
									$.post(url, {
										act: 'send_email_code'
									}, function(result) {
										if (result == 'ok') {
											//倒计时
											countdown(sendButton);
										} else {
											alert(result);
										}
									}, 'text');
								}
								
								function send_mobile_code(mobileCodeObj, sendButton) {
									// 发送邮件
									var url = 'validate.php';
									$.post(url, {
										act: 'send_mobile_code'
									}, function(result) {
										if (result == 'ok') {
											//倒计时
											countdown(sendButton);
										} else {
											alert(result);
										}
									}, 'text');
								}
								
								$().ready(function(){
									
									show_validate_type($("#validate_type"));
									
									var validator = $("#fpForm").validate({
										debug: false,
										rules: {
											mobile_code: {
												required: true
											},
											email_code: {
												required: true
											},
											captcha: {
												required: true
											}
										},
										messages: {
											mobile_code: {
												required: "请输入手机验证码"
											},
											email_code: {
												required: "请输入邮箱验证码"
											},
											captcha: {
												required: "请输入验证码"
											}
										},
										errorPlacement: function(error, element) {
											error.appendTo(element.parent());  
										}
									});
									
									$("#validate_type").change(function(){
										show_validate_type($(this));
									});
									
									$("#zphone").click(function(){
										send_mobile_code($("#mobile_code"), $(this));
									});
									
									$("#zemail").click(function(){
										send_email_code($("#email_code"), $(this));
									});
									
									$("#btn_submit").click(function(){
										
										if(!validator.form()){
											return;
										}
										
										var type = $("#validate_type").val();
										
										var url = "security.php";
										var validate_type = $("#validate_type").val();
										$.post(url, {act: "validate", mobile_code: $("#mobile_code").val(), email_code: $("#email_code").val(), password: $("#password").val(), validate_type: validate_type, captcha: $("#captcha").val()}, function(data){
											if(data.error == 1){
												alert(data.content);
												if(data.url != undefined && data.url.length > 0){
													window.location.href = data.url;
												}
											}else{
												$("#fpForm").submit();
											}
										}, "json");
									});
									
								});
							</script>
							</div>
							<?php endif; ?>
							<?php if ($this->_var['step'] == 'step_2'): ?>
							<div class="blank"></div>
							<div id="find_pw3">
								<div class="find_con">
									<div id="sflex04" class="stepflex">
										<dl class="first done">
											<dt class="s-num">1</dt>
											<dd class="s-text">
												验证身份
												<s></s>
												<b></b>
											</dd>
										</dl>
										<dl class="normal doing">
											<dt class="s-num">2</dt>
											<dd class="s-text">
												手机绑定
												<s></s>
												<b></b>
											</dd>
										</dl>
										<dl class="last">
											<dt class="s-num">&nbsp;</dt>
											<dd class="s-text">
												完成
												<s></s>
												<b></b>
											</dd>
										</dl>
									</div>
									<div id="find-box" class="uc_box">
										<form action="security.php" method="post" id="fpForm" name="fpForm">
											<div id="error_container"></div>
											<div class="item">
												<label class="con_un">手机号码：</label>
												<input name="mobile" id="mobile" type="text" tabindex="1" placeholder="请输入手机号码" class="text" />
											</div>
											<div class="item">
												<label class="con_un">请输入手机验证码：</label>
												<input name="mobile_code" id="mobile_code" type="text" tabindex="2" placeholder="请输入手机验证码" class="text text_te" />
												<input id="zphone" type="button" value="获取短信验证码" class="code" />
											</div>
											<div class="item">
                                            <label class="con_un">&nbsp;</label>
												<input type="hidden" name="act" value="mobile_binding_success" />
												<input type="button" id="btn_submit" name="btn_submit" class="btn_next" value="提交" />
											</div>
										</form>
									</div>
								</div>
								<script type="text/javascript">
								function send_mobile_code(mobileCodeObj, sendButton){
									// 发送邮件
									var url = 'security.php?XDEBUG_SESSION_START=ECLIPSE_DBGP';
									$.post(url, {
										act: 'send_mobile_code', 
										mobile: $("#mobile").val()
									}, function(result) {
										if (result == 'ok') {
											//倒计时
											countdown(sendButton);
										} else {
											alert(result);
										}
									}, 'text');
								}
								
								$().ready(function(){
									
									$.validator.addMethod("mobile", function(value, element){
										return Utils.isMobile(value);
									});
									
									var validator = $("#fpForm").validate({
										debug: false,
										rules: {
											mobile: {
												required: true,
												mobile: true,
												remote: {  
												    url: "security.php",     //后台处理程序  
												    type: "post",               //数据发送方式  
												    dataType: "json",           //接受数据格式     
												    data: {                     //要传递的数据  
												    	act: 'check_mobile_exist',
												    	mobile: function() {  
												            return $("#mobile").val();  
												        }
												    }
												}
											},
											mobile_code: {
												required: true
											}
										},
										messages: {
											mobile: {
												required: "请输入手机验证码",
												mobile: "手机号码格式不正确",
												remote: "手机号码已存在"
											},
											mobile_code: {
												required: "请输入手机验证码"
											}
										},
										errorPlacement: function(error, element) {
											error.appendTo(element.parent());  
										}
									});
									
									$("#mobile").blur(function(){
										$(this).valid();
									});
									
									$("#zphone").click(function(){
										if(!$("#mobile").valid()){
											return;
										}
										send_mobile_code($("#mobile_code"), $(this));
									});
									
									$("#btn_submit").click(function(){
										
										if(!validator.form()){
											return;
										}
										
										var type = $("#validate_type").val();
										
										var url = "security.php";
										$.post(url, {act: "do_mobile_binding", mobile: $("#mobile").val(), mobile_code: $("#mobile_code").val()}, function(data){
											if(data.error == 1){
												alert(data.content);
												if(data.url != undefined && data.url.length > 0){
													window.location.href = data.url;
												}
											}else{
												$("#fpForm").submit();
											}
										}, "json");
									});
									
								});
							</script>
							</div>
							<?php endif; ?>
							<?php if ($this->_var['step'] == 'step_3'): ?>
							<div class="blank"></div>
							<div id="find_pw3">
								<div class="find_con">
									<div id="sflex04" class="stepflex">
										<dl class="first done">
											<dt class="s-num">1</dt>
											<dd class="s-text">
												验证身份
												<s></s>
												<b></b>
											</dd>
										</dl>
										<dl class="normal done">
											<dt class="s-num">2</dt>
											<dd class="s-text">
												手机绑定
												<s></s>
												<b></b>
											</dd>
										</dl>
										<dl class="last doing">
											<dt class="s-num">&nbsp;</dt>
											<dd class="s-text">
												完成
												<s></s>
												<b></b>
											</dd>
										</dl>
									</div>
									<div id="find-box" class="uc_box">
										<div class="find_box_end">
											<p>
												<i></i>
												手机绑定成功！
											</p>
											<p class="on_go">
												<a href="security.php" title="立即购物" class="back">返回账户安全中心&gt;&gt;</a>
											</p>
										</div>
									</div>
								</div>
							</div>
							<?php endif; ?>
							
							<?php endif; ?>
							
							<?php if ($this->_var['action'] == 'mobile_validate'): ?>
							<h5 title="手机验证" class="user-title user-title-t">
								<span>手机验证</span>
							</h5>
							
							<?php if ($this->_var['step'] == 'step_1'): ?>
							<div class="blank"></div>
							<div id="find_pw3">
								<div class="find_con">
									<div id="sflex04" class="stepflex stepflex_te">
										<dl class="first doing">
											<dt class="s-num">1</dt>
											<dd class="s-text">
												手机验证
												<s></s>
												<b></b>
											</dd>
										</dl>
										<dl class="last">
											<dt class="s-num">&nbsp;</dt>
											<dd class="s-text">
												完成
												<s></s>
												<b></b>
											</dd>
										</dl>
									</div>
									<div id="find-box" class="uc_box">
										<form action="security.php" method="post" id="fpForm" name="fpForm">
											<div id="error_container"></div>
											<div class="item">
												<label class="con_un">手机号码：</label>
												<span id="l_mobile"><?php echo $this->_var['mobile']; ?></span>
											</div>
											<div class="item">
												<label class="con_un">请输入手机验证码：</label>
												<input name="mobile_code" id="mobile_code" type="text" tabindex="2" placeholder="请输入手机验证码" class="text text_te" />
												<input id="zphone" type="button" value="获取短信验证码" class="code" />
											</div>
											<div class="item">
												<label class="con_un">请输入验证码：</label>
												<input type="text" id="captcha" size="8" name="captcha" class="text text_te" placeholder="<?php echo $this->_var['lang']['comment_captcha']; ?>" style="ime-mode: disabled" autocomplete="off" MaxLength="6" />
												<label class="img" style="margin-left: 5px">
													<img src="captcha.php?<?php echo $this->_var['rand']; ?>" alt="captcha" style="vertical-align: middle; cursor: pointer;" onClick="this.src='captcha.php?'+Math.random();$('#captcha').focus();" />
												</label>
											</div>
											<div class="item">
                                            <label class="con_un">&nbsp;</label>
												<input type="hidden" name="act" value="mobile_validate_success" />
												<input type="button" id="btn_submit" name="btn_submit" class="btn_next" value="提交" />
											</div>
										</form>
									</div>
								</div>
								<script type="text/javascript">
								function send_mobile_code(emailCodeObj, sendButton){
									// 发送邮件
									var url = 'validate.php';
									$.post(url, {
										act: 'send_mobile_code'
									}, function(result) {
										if (result == 'ok') {
											//倒计时
											countdown(sendButton);
										} else {
											alert(result);
										}
									}, 'text');
								}
								
								$().ready(function(){
									
									var validator = $("#fpForm").validate({
										debug: false,
										rules: {
											captcha: {
												required: true
											},
											mobile_code: {
												required: true
											}
										},
										messages: {
											captcha: {
												required: "请输入验证码"
											},
											mobile_code: {
												required: "请输入手机验证码"
											}
										},
										errorPlacement: function(error, element) {
											error.appendTo(element.parent());  
										}
									});
									
									$("#zphone").click(function(){
										send_mobile_code($("#mobile_code"), $(this));
									});
									
									$("#btn_submit").click(function(){
										
										if(!validator.form()){
											return;
										}
										
										var type = $("#validate_type").val();
										
										var url = "security.php?XDEBUG_SESSION_START=ECLIPSE_DBGP";
										$.post(url, {act: "do_mobile_validate", mobile_code: $("#mobile_code").val(), captcha: $("#captcha").val()}, function(data){
											if(data.error == 1){
												alert(data.content);
												if(data.url != undefined && data.url.length > 0){
													window.location.href = data.url;
												}
											}else{
												$("#fpForm").submit();
											}
										}, "json");
									});
									
								});
							</script>
							</div>
							<?php endif; ?>
							<?php if ($this->_var['step'] == 'step_2'): ?>
							<div class="blank"></div>
							<div id="find_pw3">
								<div class="find_con">
									<div id="sflex04" class="stepflex">
										<dl class="normal done">
											<dt class="s-num">1</dt>
											<dd class="s-text">
												手机验证
												<s></s>
												<b></b>
											</dd>
										</dl>
										<dl class="last doing">
											<dt class="s-num">&nbsp;</dt>
											<dd class="s-text">
												完成
												<s></s>
												<b></b>
											</dd>
										</dl>
									</div>
									<div id="find-box" class="uc_box">
										<div class="find_box_end">
											<p>
												<i></i>
												手机验证成功！
											</p>
											<p class="on_go">
												<a href="security.php" title="立即购物" class="back">返回账户安全中心&gt;&gt;</a>
											</p>
										</div>
									</div>
								</div>
							</div>
							<?php endif; ?>
							
							<?php endif; ?>
							
							<?php if ($this->_var['action'] == 'payment_password_reset'): ?>
							
							<h5 title="设置支付密码" class="user-title user-title-t">
								<span>设置支付密码</span>
							</h5>
							<?php if ($this->_var['step'] == 'step_1'): ?>
							<div class="blank" ></div>
							<div id="find_pw" class="find_pw2">
								<div class="find_con">
									<div id="sflex04" class="stepflex">
										<dl class="first doing">
											<dt class="s-num">1</dt>
											<dd class="s-text">
												验证身份
												<s></s>
												<b></b>
											</dd>
										</dl>
										<dl class="normal">
											<dt class="s-num">2</dt>
											<dd class="s-text">
												设置支付密码
												<s></s>
												<b></b>
											</dd>
										</dl>
										<dl class="last">
											<dt class="s-num">&nbsp;</dt>
											<dd class="s-text">
												完成
												<s></s>
												<b></b>
											</dd>
										</dl>
									</div>
									<div id="find-box" class="uc_box">
										<form action="security.php" method="post" id="fpForm" name="fpForm">
											<div id="error_container"></div>
											<div class="item">
												<label class="con_un">请选择验证身份方式：</label>
												<select id="validate_type" name="validate_type">
													<?php $_from = $this->_var['validate_types']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
													<option id="validate_type_<?php echo $this->_var['item']['type']; ?>" value="<?php echo $this->_var['item']['type']; ?>" val="<?php echo $this->_var['item']['value']; ?>"><?php echo $this->_var['item']['name']; ?></option>
													<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
												</select>
											</div>
											<div class="item v_mobile_phone v_item" style="display: none">
												<label class="con_un">您的手机号：</label>
												<span id="l_mobile_phone"></span>
											</div>
											<div id="c_mobile_code" class="item v_mobile_phone v_item" style="display: none">
												<label class="con_un">请输入手机验证码：</label>
												<input type="text" id="mobile_code" name="mobile_code" class="text text_te2" value="" />
												<input id="zphone" type="button" value="获取手机验证码" class="code" />
											</div>
											<div class="item v_email v_item" style="display: none">
												<label class="con_un">您的邮箱地址：</label>
												<span id="l_email"></span>
											</div>
											<div id="c_email" class="item v_email v_item" style="display: none">
												<label class="con_un">请输入邮箱验证码：</label>
												<input type="text" id="email_code" name="email_code" class="text text_te2" value="" />
												<input id="zemail" type="button" value="获取邮箱验证码" class="code" />
											</div>
											<div class="item v_password v_item" style="display: none">
												<label class="con_un">用户名：</label>
												<span id="l_password"></span>
											</div>
											<div id="c_password" class="item v_password v_item" style="display: none">
												<label class="con_un">请输入登录密码：</label>
												<input type="password" id="password" name="password" class="text text_te2" value="" />
											</div>
											<div class="item">
												<label class="con_un">请输入验证码：</label>
												<input type="text" id="captcha" size="8" name="captcha" class="text text_te" placeholder="<?php echo $this->_var['lang']['comment_captcha']; ?>" style="ime-mode: disabled" autocomplete="off" MaxLength="6" />
												<label class="img" style="margin-left: 5px">
													<img src="captcha.php?<?php echo $this->_var['rand']; ?>" alt="captcha" style="vertical-align: middle; cursor: pointer;" onClick="this.src='captcha.php?'+Math.random();$('#captcha').focus();" />
												</label>
											</div>
											<div class="item">
                                            <label class="con_un">&nbsp;</label>
												<input type="hidden" name="act" value="to_payment_password_reset" />
												<input type="button" name="button" id="btn_submit" class="btn_next" value="提交" />
											</div>
										</form>
									</div>
								</div>
								<script type="text/javascript">
								function show_validate_type(validate_type_obj){
									var type = $(validate_type_obj).val();
									var value = $("#validate_type_"+type).attr("val");
									$("#l_"+type).html(value);
									$(".v_item").hide();
									$(".v_"+type).show();
								}
								
								function send_email_code(emailCodeObj, sendButton){
									// 发送邮件
									var url = 'validate.php';
									$.post(url, {
										act: 'send_email_code'
									}, function(result) {
										if (result == 'ok') {
											//倒计时
											countdown(sendButton);
										} else {
											alert(result);
										}
									}, 'text');
								}
								
								function send_mobile_code(mobileCodeObj, sendButton) {
									// 发送邮件
									var url = 'validate.php';
									$.post(url, {
										act: 'send_mobile_code'
									}, function(result) {
										if (result == 'ok') {
											//倒计时
											countdown(sendButton);
										} else {
											alert(result);
										}
									}, 'text');
								}
								
								$().ready(function(){
									
									show_validate_type($("#validate_type"));
									
									var validator = $("#fpForm").validate({
										debug: false,
										rules: {
											mobile_code: {
												required: true
											},
											email_code: {
												required: true
											},
											captcha: {
												required: true
											}
										},
										messages: {
											mobile_code: {
												required: "请输入手机验证码"
											},
											email_code: {
												required: "请输入邮箱验证码"
											},
											captcha: {
												required: "请输入验证码"
											}
										},
										errorPlacement: function(error, element) {
											error.appendTo(element.parent());  
										}
									});
									
									$("#validate_type").change(function(){
										show_validate_type($(this));
									});
									
									$("#zphone").click(function(){
										send_mobile_code($("#mobile_code"), $(this));
									});
									
									$("#zemail").click(function(){
										send_email_code($("#email_code"), $(this));
									});
									
									$("#btn_submit").click(function(){
										
										if(!validator.form()){
											return;
										}
										
										var type = $("#validate_type").val();
										
										var url = "security.php";
										var validate_type = $("#validate_type").val();
										$.post(url, {act: "validate", mobile_code: $("#mobile_code").val(), email_code: $("#email_code").val(), password: $("#password").val(), validate_type: validate_type, captcha: $("#captcha").val()}, function(data){
											if(data.error == 1){
												alert(data.content);
												if(data.url != undefined && data.url.length > 0){
													window.location.href = data.url;
												}
											}else{
												$("#fpForm").submit();
											}
										}, "json");
									});
									
								});
							</script>
							</div>
							<?php endif; ?>
							<?php if ($this->_var['step'] == 'step_2'): ?>
							<div class="blank"></div>
							<div id="find_pw3">
								<div class="find_con">
									<div id="sflex04" class="stepflex">
										<dl class="first done">
											<dt class="s-num">1</dt>
											<dd class="s-text">
												验证身份
												<s></s>
												<b></b>
											</dd>
										</dl>
										<dl class="normal doing">
											<dt class="s-num">2</dt>
											<dd class="s-text">
												设置支付密码
												<s></s>
												<b></b>
											</dd>
										</dl>
										<dl class="last">
											<dt class="s-num">&nbsp;</dt>
											<dd class="s-text">
												完成
												<s></s>
												<b></b>
											</dd>
										</dl>
									</div>
									<div id="find-box" class="uc_box">
										<form action="security.php" method="post" id="fpForm" name="fpForm">
											<div id="error_container"></div>
											<div class="item">
												<label class="con_un">设置支付密码：</label>
												<input name="password" id="password" type="password" tabindex="1" placeholder="请输入支付密码" class="text" />
											</div>
											<div class="item">
												<label class="con_un">重新输入密码：</label>
												<input name="confirm_password" id="confirm_password" type="password" tabindex="1" placeholder="请输再次输入确认密码" class="text" />
											</div>
											<div class="item">
                                            <label class="con_un">&nbsp;</label>
												<input type="hidden" name="act" value="payment_password_reset_success" />
												<input type="button" id="btn_submit" name="btn_submit" class="btn_next" value="提交" />
											</div>
										</form>
									</div>
								</div>
								<script type="text/javascript">
								$().ready(function(){
									var validator = $("#fpForm").validate({
										debug: false,
										rules: {
											password: {
												required: true,
												minlength: 6
											},
											confirm_password: {
												required: true,
												equalTo: "#password"
											}
										},
										messages: {
											password: {
												required: "请输入密码",
												minlength: "登录密码不能少于 6 个字符"
											},
											confirm_password: {
												required: "请再次输入新密码",
												equalTo: "两次输入的密码不一致，请重新输入"
											}
										},
										errorPlacement: function(error, element) {
											error.appendTo(element.parent());
										}
									});
									
									$("#btn_submit").click(function(){
										if(!validator.form()){
											return;
										}
										
										var url = "security.php";
										$.post(url, {act: 'do_payment_password_reset', password: $("#password").val()}, function(data){
											if(data.error == 1){
												alert(data.content);
												if(data.url != undefined && data.url.length > 0){
													window.location.href = data.url;
												}
											}else{
												$("#fpForm").submit();
											}
										}, "json");
											
									});
								});
								</script>
							</div>
							<?php endif; ?>
							<?php if ($this->_var['step'] == 'step_3'): ?>
							<div class="blank"></div>
							<div id="find_pw3">
								<div class="find_con">
									<div id="sflex04" class="stepflex">
										<dl class="first done">
											<dt class="s-num">1</dt>
											<dd class="s-text">
												验证身份
												<s></s>
												<b></b>
											</dd>
										</dl>
										<dl class="normal done">
											<dt class="s-num">2</dt>
											<dd class="s-text">
												设置支付密码
												<s></s>
												<b></b>
											</dd>
										</dl>
										<dl class="last doing">
											<dt class="s-num">&nbsp;</dt>
											<dd class="s-text">
												完成
												<s></s>
												<b></b>
											</dd>
										</dl>
									</div>
									<div id="find-box" class="uc_box">
										<div class="find_box_end">
											<p>
												<i></i>
												设置支付密码成功！
											</p>
											<p class="on_go">
												<a href="security.php" title="立即购物" class="back">返回账户安全中心&gt;&gt;</a>
											</p>
										</div>
									</div>
								</div>
							</div>
							<?php endif; ?>
							
							<?php endif; ?>
							
							<?php if ($this->_var['action'] == 'payment_password_close'): ?>
							
							<h5 title="关闭支付密码" class="user-title user-title-t">
								<span>关闭支付密码</span>
							</h5>
							<?php if ($this->_var['step'] == 'step_1'): ?>
							<div class="blank" ></div>
							<div id="find_pw" class="find_pw2">
								<div class="find_con">
									<div id="sflex04" class="stepflex stepflex_te">
										<dl class="first doing">
											<dt class="s-num">1</dt>
											<dd class="s-text">
												验证身份
												<s></s>
												<b></b>
											</dd>
										</dl>
										<dl class="last">
											<dt class="s-num">&nbsp;</dt>
											<dd class="s-text">
												完成
												<s></s>
												<b></b>
											</dd>
										</dl>
									</div>
									<div id="find-box" class="uc_box">
										<form action="security.php" method="post" id="fpForm" name="fpForm">
											<div id="error_container"></div>
											<div class="item">
												<label class="con_un">请选择验证身份方式：</label>
												<select id="validate_type" name="validate_type">
													<?php $_from = $this->_var['validate_types']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
													<option id="validate_type_<?php echo $this->_var['item']['type']; ?>" value="<?php echo $this->_var['item']['type']; ?>" val="<?php echo $this->_var['item']['value']; ?>"><?php echo $this->_var['item']['name']; ?></option>
													<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
												</select>
											</div>
											<div class="item v_mobile_phone v_item" style="display: none">
												<label class="con_un">您的手机号：</label>
												<span id="l_mobile_phone"></span>
											</div>
											<div id="c_mobile_code" class="item v_mobile_phone v_item" style="display: none">
												<label class="con_un">请输入手机验证码：</label>
												<input type="text" id="mobile_code" name="mobile_code" class="text text_te2" value="" />
												<input id="zphone" type="button" value="获取手机验证码" class="code" />
											</div>
											<div class="item v_email v_item" style="display: none">
												<label class="con_un">您的邮箱地址：</label>
												<span id="l_email"></span>
											</div>
											<div id="c_email" class="item v_email v_item" style="display: none">
												<label class="con_un">请输入邮箱验证码：</label>
												<input type="text" id="email_code" name="email_code" class="text text_te2" value="" />
												<input id="zemail" type="button" value="获取邮箱验证码" class="code" />
											</div>
											<div class="item v_password v_item" style="display: none">
												<label class="con_un">用户名：</label>
												<span id="l_password"></span>
											</div>
											<div id="c_password" class="item v_password v_item" style="display: none">
												<label class="con_un">请输入登录密码：</label>
												<input type="password" id="password" name="password" class="text text_te2" value="" />
											</div>
											<div class="item">
												<label class="con_un">请输入验证码：</label>
												<input type="text" id="captcha" size="8" name="captcha" class="text text_te" placeholder="<?php echo $this->_var['lang']['comment_captcha']; ?>" style="ime-mode: disabled" autocomplete="off" MaxLength="6" />
												<label class="img" style="margin-left: 5px">
													<img src="captcha.php?<?php echo $this->_var['rand']; ?>" alt="captcha" style="vertical-align: middle; cursor: pointer;" onClick="this.src='captcha.php?'+Math.random();$('#captcha').focus();" />
												</label>
											</div>
											<div class="item">
                                            <label class="con_un">&nbsp;</label>
												<input type="hidden" name="act" value="do_payment_password_close" />
												<input type="button" name="button" id="btn_submit" class="btn_next" value="提交" />
											</div>
										</form>
									</div>
								</div>
								<script type="text/javascript">
								function show_validate_type(validate_type_obj){
									var type = $(validate_type_obj).val();
									var value = $("#validate_type_"+type).attr("val");
									$("#l_"+type).html(value);
									$(".v_item").hide();
									$(".v_"+type).show();
								}
								
								function send_email_code(emailCodeObj, sendButton){
									// 发送邮件
									var url = 'validate.php';
									$.post(url, {
										act: 'send_email_code'
									}, function(result) {
										if (result == 'ok') {
											//倒计时
											countdown(sendButton);
										} else {
											alert(result);
										}
									}, 'text');
								}
								
								function send_mobile_code(mobileCodeObj, sendButton) {
									// 发送邮件
									var url = 'validate.php';
									$.post(url, {
										act: 'send_mobile_code'
									}, function(result) {
										if (result == 'ok') {
											//倒计时
											countdown(sendButton);
										} else {
											alert(result);
										}
									}, 'text');
								}
								
								$().ready(function(){
									
									show_validate_type($("#validate_type"));
									
									var validator = $("#fpForm").validate({
										debug: false,
										rules: {
											mobile_code: {
												required: true
											},
											email_code: {
												required: true
											},
											captcha: {
												required: true
											}
										},
										messages: {
											mobile_code: {
												required: "请输入手机验证码"
											},
											email_code: {
												required: "请输入邮箱验证码"
											},
											captcha: {
												required: "请输入验证码"
											}
										},
										errorPlacement: function(error, element) {
											error.appendTo(element.parent());  
										}
									});
									
									$("#validate_type").change(function(){
										show_validate_type($(this));
									});
									
									$("#zphone").click(function(){
										send_mobile_code($("#mobile_code"), $(this));
									});
									
									$("#zemail").click(function(){
										send_email_code($("#email_code"), $(this));
									});
									
									$("#btn_submit").click(function(){
										
										if(!validator.form()){
											return;
										}
										
										var type = $("#validate_type").val();
										
										var url = "security.php";
										var validate_type = $("#validate_type").val();
										$.post(url, {act: "validate", mobile_code: $("#mobile_code").val(), email_code: $("#email_code").val(), password: $("#password").val(), validate_type: validate_type, captcha: $("#captcha").val()}, function(data){
											if(data.error == 1){
												alert(data.content);
												if(data.url != undefined && data.url.length > 0){
													window.location.href = data.url;
												}
											}else{
												$("#fpForm").submit();
											}
										}, "json");
									});
									
								});
							</script>
							</div>
							<?php endif; ?>
							<?php if ($this->_var['step'] == 'step_2'): ?>
							<div class="blank"></div>
							<div id="find_pw3">
								<div class="find_con">
									<div id="sflex04" class="stepflex stepflex_te">
										<dl class="first done">
											<dt class="s-num">1</dt>
											<dd class="s-text">
												验证身份
												<s></s>
												<b></b>
											</dd>
										</dl>
										<dl class="last doing">
											<dt class="s-num">&nbsp;</dt>
											<dd class="s-text">
												完成
												<s></s>
												<b></b>
											</dd>
										</dl>
									</div>
									<div id="find-box" class="uc_box">
										<div class="find_box_end">
											<p>
												<i></i>
												关闭支付密码成功！
											</p>
											<p class="on_go">
												<a href="security.php" title="立即购物" class="back">返回账户安全中心&gt;&gt;</a>
											</p>
										</div>
									</div>
								</div>
							</div>
							<?php endif; ?>
							
							<?php endif; ?>
							<?php if ($this->_var['action'] == 'sync_supplier'): ?>
							<h5 title="同步商家信息" class="user-title user-title-t">
								<span>同步商家信息</span>
							</h5>
							<?php if ($this->_var['step'] == 'step_1'): ?>
							<div class="blank" ></div>
							<div id="find_pw" class="find_pw2">
								<div class="find_con">
									<div id="sflex04" class="stepflex">
										<dl class="first doing">
											<dt class="s-num">1</dt>
											<dd class="s-text">
												验证身份
												<s></s>
												<b></b>
											</dd>
										</dl>
										<dl class="normal">
											<dt class="s-num">2</dt>
											<dd class="s-text">
												同步商家信息
												<s></s>
												<b></b>
											</dd>
										</dl>
										<dl class="last">
											<dt class="s-num">&nbsp;</dt>
											<dd class="s-text">
												完成
												<s></s>
												<b></b>
											</dd>
										</dl>
									</div>
									<div id="find-box" class="uc_box">
										<form action="security.php" method="post" id="fpForm" name="fpForm">
											<div id="error_container"></div>
											<div class="item">
												<label class="con_un">请选择验证身份方式：</label>
												<select id="validate_type" name="validate_type">
													<?php $_from = $this->_var['validate_types']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
													<option id="validate_type_<?php echo $this->_var['item']['type']; ?>" value="<?php echo $this->_var['item']['type']; ?>" val="<?php echo $this->_var['item']['value']; ?>"><?php echo $this->_var['item']['name']; ?></option>
													<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
												</select>
											</div>
											<div class="item v_mobile_phone v_item" style="display: none">
												<label class="con_un">手机号：</label>
												<span id="l_mobile_phone"></span>
											</div>
											<div id="c_mobile_code" class="item v_mobile_phone v_item" style="display: none">
												<label class="con_un">请输入手机验证码：</label>
												<input type="text" id="mobile_code" name="mobile_code" class="text text_te2" value="" />
												<input id="zphone" type="button" value="获取手机验证码" class="code" />
											</div>
											<div class="item v_email v_item" style="display: none">
												<label class="con_un">邮箱地址：</label>
												<span id="l_email"></span>
											</div>
											<div id="c_email" class="item v_email v_item" style="display: none">
												<label class="con_un">请输入邮箱验证码：</label>
												<input type="text" id="email_code" name="email_code" class="text text_te2" value="" />
												<input id="zemail" type="button" value="获取邮箱验证码" class="code" />
											</div>
											<div class="item v_password v_item" style="display: none">
												<label class="con_un">用户名：</label>
												<span id="l_password"></span>
											</div>
											<div id="c_password" class="item v_password v_item" style="display: none">
												<label class="con_un">请输入登录密码：</label>
												<input type="password" id="password" name="password" class="text text_te2" value="" />
											</div>
											<div class="item">
												<label class="con_un">请输入验证码：</label>
												<input type="text" id="captcha" name="captcha" class="text text_te" placeholder="<?php echo $this->_var['lang']['comment_captcha']; ?>" style="ime-mode: disabled" autocomplete="off" MaxLength="6" />
												<label class="img" style="margin-left: 5px">
													<img src="captcha.php?<?php echo $this->_var['rand']; ?>" alt="captcha" style="vertical-align: middle; cursor: pointer;" onClick="this.src='captcha.php?'+Math.random();$('#captcha').focus();" />
												</label>
											</div>
											<div class="item">
                                            	<label class="con_un">&nbsp;</label>
												<input type="hidden" name="act" value="to_sync_supplier" />
												<input type="button" name="button" id="btn_submit" class="btn_next" value="提交" />
											</div>
										</form>
									</div>
								</div>
								<script type="text/javascript">
								function show_validate_type(validate_type_obj){
									var type = $(validate_type_obj).val();
									var value = $("#validate_type_"+type).attr("val");
									$("#l_"+type).html(value);
									$(".v_item").hide();
									$(".v_"+type).show();
								}
								
								function send_email_code(emailCodeObj, sendButton){
									// 发送邮件
									var url = 'validate.php';
									$.post(url, {
										act: 'send_email_code'
									}, function(result) {
										if (result == 'ok') {
											//倒计时
											countdown(sendButton);
										} else {
											alert(result);
										}
									}, 'text');
								}
								
								function send_mobile_code(mobileCodeObj, sendButton) {
									// 发送邮件
									var url = 'validate.php';
									$.post(url, {
										act: 'send_mobile_code'
									}, function(result) {
										if (result == 'ok') {
											//倒计时
											countdown(sendButton);
										} else {
											alert(result);
										}
									}, 'text');
								}
								
								$().ready(function(){
									
									show_validate_type($("#validate_type"));
									
									var validator = $("#fpForm").validate({
										debug: false,
										rules: {
											mobile_code: {
												required: true
											},
											email_code: {
												required: true
											},
											captcha: {
												required: true
											}
										},
										messages: {
											mobile_code: {
												required: "请输入手机验证码"
											},
											email_code: {
												required: "请输入邮箱验证码"
											},
											captcha: {
												required: "请输入验证码"
											}
										},
										errorPlacement: function(error, element) {
											error.appendTo(element.parent());  
										}
									});
									
									$("#validate_type").change(function(){
										show_validate_type($(this));
									});
									
									$("#zphone").click(function(){
										send_mobile_code($("#mobile_code"), $(this));
									});
									
									$("#zemail").click(function(){
										send_email_code($("#email_code"), $(this));
									});
									
									$("#btn_submit").click(function(){
										
										if(!validator.form()){
											return;
										}
										
										var type = $("#validate_type").val();
										
										var url = "security.php";
										var validate_type = $("#validate_type").val();
										$.post(url, {act: "validate", mobile_code: $("#mobile_code").val(), email_code: $("#email_code").val(), password: $("#password").val(), validate_type: validate_type, captcha: $("#captcha").val()}, function(data){
											if(data.error == 1){
												alert(data.content);
												if(data.url != undefined && data.url.length > 0){
													window.location.href = data.url;
												}
											}else{
												$("#fpForm").submit();
											}
										}, "json");
									});
									
								});
							</script>
							</div>
							<?php endif; ?>
							<?php if ($this->_var['step'] == 'step_2'): ?>
							<div class="blank"></div>
							<div id="find_pw3">
								<div class="find_con">
									<div id="sflex04" class="stepflex">
										<dl class="first done">
											<dt class="s-num">1</dt>
											<dd class="s-text">
												验证身份
												<s></s>
												<b></b>
											</dd>
										</dl>
										<dl class="normal doing">
											<dt class="s-num">2</dt>
											<dd class="s-text">
												同步商家信息
												<s></s>
												<b></b>
											</dd>
										</dl>
										<dl class="last">
											<dt class="s-num">&nbsp;</dt>
											<dd class="s-text">
												完成
												<s></s>
												<b></b>
											</dd>
										</dl>
									</div>
									<div id="find-box" class="uc_box">
										<form action="security.php" method="post" id="fpForm" name="fpForm">
											<div id="error_container"></div>
											<div class="item">
												<label class="con_un">用户名：</label><?php echo $this->_var['user_name']; ?>
											</div>
											<div class="item">
												<label class="con_un">邮箱地址：</label>
												<?php if ($this->_var['email'] == ''): ?>
												尚未绑定
												<?php else: ?>
												<?php echo $this->_var['email']; ?>
												<?php endif; ?>
											</div>
											<div class="item">
												<label class="con_un">手机号码：</label>
												<?php if ($this->_var['mobile_phone'] == ''): ?>
												尚未绑定
												<?php else: ?>
												<?php echo $this->_var['mobile_phone']; ?>
												<?php endif; ?>
											</div>
											<div class="item">
												<label class="con_un">登录密码：</label>
												**********
											</div>
											<div class="item">
                                            	<label class="con_un">&nbsp;</label>
												<input type="hidden" name="act" value="sync_supplier_success" />
												<input type="button" id="btn_submit" name="btn_submit" class="btn_next" value="开始同步" />
											</div>
										</form>
									</div>
								</div>
								<script type="text/javascript">
								$().ready(function(){
									
								$("#btn_submit").click(function(){
									
									var url = "security.php";
									$.post(url, {act: 'do_sync_supplier'}, function(data){
										if(data.error == 1){
											alert(data.content);
											if(data.url != undefined && data.url.length > 0){
												window.location.href = data.url;
											}
										}else{
											$("#fpForm").submit();
										}
									}, "json");
										
								});
							});
							</script>
							</div>
							<?php endif; ?>
							<?php if ($this->_var['step'] == 'step_3'): ?>
							
							<div class="blank"></div>
							<div id="find_pw3">
								<div class="find_con">
									<div id="sflex04" class="stepflex">
										<dl class="first done">
											<dt class="s-num">1</dt>
											<dd class="s-text">
												验证身份
												<s></s>
												<b></b>
											</dd>
										</dl>
										<dl class="normal done">
											<dt class="s-num">2</dt>
											<dd class="s-text">
												同步商家信息
												<s></s>
												<b></b>
											</dd>
										</dl>
										<dl class="last doing">
											<dt class="s-num">&nbsp;</dt>
											<dd class="s-text">
												完成
												<s></s>
												<b></b>
											</dd>
										</dl>
									</div>
									<div id="find-box" class="uc_box">
										<div class="find_box_end">
											<p>
												<i></i>
												同步商家信息成功！
											</p>
											<p class="on_go">
												<a href="security.php" title="立即购物" class="back">返回账户安全中心&gt;&gt;</a>
											</p>
										</div>
									</div>
								</div>
							</div>
							<?php endif; ?>
							<?php endif; ?>
						</div>
					</div>
					
				</div>
			</div>
			<div style="height: 15px; line-height: 15px; clear: both;"></div>
		</div>
		<?php echo $this->fetch('library/help.lbi'); ?>
		<?php echo $this->fetch('library/page_footer.lbi'); ?>
		<?php echo $this->fetch('library/site_bar.lbi'); ?>
		
		<script language="javascript">
	document.getElementById("retData").innerHTML="<center>正在查询物流信息，请稍后...</center>";
	var expressid = document.getElementById("shipping_name").innerHTML.replace(/(^\s*)|(\s*$)/g, "");
	var expressno = '<?php echo $this->_var['order']['invoice_no']; ?>';
	Ajax.call('plugins/kuaidi100/kuaidi100_post.php?com='+ expressid+'&nu=' + expressno,'showtest=showtest', function(data){document.getElementById("retData").innerHTML=data;}, 'GET', 'TEXT');
</script>
		
</body>
<script type="text/javascript">
<?php $_from = $this->_var['lang']['clips_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</script>
</html>
