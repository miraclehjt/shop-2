<div class=" bg-color-w ubb border-hui" style="padding:0.2em 0.5em 0; overflow:hidden">
  <div id="sflex04" class="stepflex ub">
    <dl class="first ub-f1 <?php if ($this->_var['action'] == 'step_1'): ?>doing<?php else: ?>done<?php endif; ?>">
      
      <dt class="s-num"> 1 </dt>
      <dd class="s-text"> 填写账户名 <s></s><b></b> </dd>
    </dl>
    <dl class="normal ub-f1 <?php if ($this->_var['action'] == 'step_2'): ?>doing <?php elseif ($this->_var['action'] == 'step_3' || $this->_var['action'] == 'step_4'): ?>done<?php endif; ?>">
      <dt class="s-num"> 2 </dt>
      <dd class="s-text"> 验证身份 <s></s><b></b> </dd>
    </dl>
    <dl class="normal ub-f1 <?php if ($this->_var['action'] == 'step_3'): ?>doing<?php elseif ($this->_var['action'] == 'step_4'): ?>done<?php endif; ?>">
      <dt class="s-num"> 3 </dt>
      <dd class="s-text"> 设置新密码 <s></s><b></b> </dd>
    </dl>
    <dl class="last ub-f1 <?php if ($this->_var['action'] == 'step_4'): ?>doing<?php endif; ?>">
      <dt class="s-num">&nbsp; </dt>
      <dd class="s-text"> 完成 <s></s><b></b> </dd>
    </dl>
  </div>
</div>
<?php if ($this->_var['action'] == 'step_1'): ?>
<div class="m-all2 bg-color-w">
  <div class="ubb ub border-f2 ub-ac h-min1">
    <div class="f-color-6 sc-text-hui uw-reg ulev-1"> 账户名 </div>
    <div class="uinput sc-text-hui ulev-1 ub-f1">
      <input type="text" placeholder="<?php echo $this->_var['lang']['label_input_uname']; ?>" id='u_name'/>
    </div>
  </div>
</div>
<div class="ub ub-pe ub-ac p-l-r3">
  <div class="ulev-1 m-l3 sc-text-active1"> 如果您忘记了账户名，将无法找回您的账户信息，您还可以重新 <font class="f-color-red" id='register_button'>注册&gt;&gt;</font> </div>
</div>
<div class="m-all2" id='confirm_step_one_button'>
  <div class="user-btn"> 下一步 </div>
</div>
<?php endif; ?> 
<?php if ($this->_var['action'] == 'step_2'): ?>
<div id="find_pw" class="m-all2 bg-color-w">
  <form action="findPwd.php" method="post" id="fpForm" name="fpForm">
    <input type="hidden" name="act" value="to_reset_password" />
    <div id="error_container"></div>
    <div class="ubb ub border-f2 ub-ac h-min1">
      <div class="f-color-6 sc-text-hui uw-reg ulev-1"> 请选择验证身份方式： </div>
      <div class="uinput sc-text-hui ulev-1 styled-select">
        <select id="validate_type" name="validate_type">
          <?php $_from = $this->_var['validate_types']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
          <option id="validate_type_<?php echo $this->_var['item']['type']; ?>" value="<?php echo $this->_var['item']['type']; ?>" val="<?php echo $this->_var['item']['value']; ?>"><?php echo $this->_var['item']['name']; ?></option>
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </select>
      </div>
    </div>
    
    <div style="display: block" class='v_mobile_phone v_item'>
      <div class="ubb ub border-f2 ub-ac h-min1">
        <div class="f-color-6 sc-text-hui uw-reg ulev-1"> 手机号： </div>
        <div class="uinput sc-text-hui ulev-1"id="l_mobile_phone"></div>
      </div>
    </div>
    <div style="display: block" class='v_mobile_phone v_item'>
      <div class="ubb ub border-f2 ub-ac h-min1">
        <div class="f-color-6 sc-text-hui uw-reg ulev-1"> 验证码： </div>
        <div class="uinput sc-text-hui ulev-1 ub-f1" style="width:6em">
          <input type="text" id="mobile_code" name="mobile_code" value="" placeholder="请输入短信验证码"/>
        </div>
        <div class="btn-red-1 ulev-2" id='send_mobile_code_button' data-origin_html='获取手机验证码' data-origin_count='60'> 获取手机验证码 </div>
      </div>
    </div>
     
    
    <div style="display: block" class='v_email v_item'>
      <div class="ubb ub border-f2 ub-ac h-min1">
        <div class="f-color-6 sc-text-hui uw-reg ulev-1"> 邮箱地址： </div>
        <div class="uinput sc-text-hui ulev-1"id="l_email"></div>
      </div>
    </div>
    <div style="display: block" class='v_email v_item'>
      <div class="ubb ub border-f2 ub-ac h-min1">
        <div class="f-color-6 sc-text-hui uw-reg ulev-1"> 验证码： </div>
        <div class="uinput sc-text-hui ulev-1 ub-f1" style="width:6em">
          <input type="text" id="email_code" name="email_code" value="" placeholder="请输入邮箱验证码"/>
        </div>
        <div class="btn-red-1 ulev-2" id='send_email_code_button' data-origin_html='获取邮箱验证码' data-origin_count='60'> 获取邮箱验证码 </div>
      </div>
    </div>
    
    <div class="m-all2" id='confirm_step_two_button'>
      <div class="user-btn"> 提交 </div>
    </div>
  </form>
</div>
<?php endif; ?> 
<?php if ($this->_var['action'] == 'step_3'): ?>
<form action="findPwd.php" method="post" id="fpForm" name="fpForm">
  <div class="m-all2 bg-color-w">
    <input type="hidden" name="act" value="to_success" />
    <div id="error_container"></div>
    <div class="ubb ub border-f2 ub-ac h-min1">
      <div class="f-color-6 sc-text-hui uw-reg ulev-1"> 设置密码 </div>
      <div class="uinput sc-text-hui ulev-1">
        <input id='password1' type="password" placeholder="请输入密码"/>
      </div>
    </div>
    <div class="ubb ub border-f2 ub-ac h-min1">
      <div class="f-color-6 sc-text-hui uw-reg ulev-1"> 确认密码 </div>
      <div class="uinput sc-text-hui ulev-1">
        <input id='password2' type="password" placeholder="请再次确认密码"/>
      </div>
    </div>
  </div>
  <div class="m-all2" id='confirm_step_three_button'>
    <div class="user-btn"> 提交 </div>
  </div>
</form>
<?php endif; ?> 
<?php if ($this->_var['action'] == 'step_4'): ?>
<div class="m-all2 bg-color-w ub ub-ac ub-pc p-all4">
  <div class="ub-img redio-on h-w-1"></div>
  <span class="ulev-1 f-color-6 m-l1">新密码设置成功！请您牢记新密码！</span> </div>
<div class="m-all2 _login" id='login_button'>
  <div class="user-btn"> 立即登录&gt;&gt; </div>
</div>
<?php endif; ?>