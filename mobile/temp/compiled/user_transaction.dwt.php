<!DOCTYPE html >
<html>
<head>
<meta name="Generator" content="ECSHOP v2.7.3" />
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width">
<title><?php echo $this->_var['page_title']; ?></title>
<meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
<link rel="stylesheet" type="text/css" href="themesmobile/68ecshopcom_mobile/css/public.css"/>
<link rel="stylesheet" type="text/css" href="themesmobile/68ecshopcom_mobile/css/user.css"/> 


<script type="text/javascript" src="themesmobile/68ecshopcom_mobile/js/jquery.js"></script>
<?php echo $this->smarty_insert_scripts(array('files'=>'jquery.json.js,transport.js')); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'common.js,utils.js,shopping_flow.js')); ?>
<?php if ($this->_var['action'] == 'account_security' || $this->_var['action'] == 'order_detail'): ?>
<script lang='javascript' type='text/javascript'>
var action = '';//open_surplus,close_surplus,verify_surplus

function open_surplus_window() {
  if(action == 'close_surplus' || action == 'verify_surplus'){
    document.getElementById("popup_window").style.display = "";
    document.getElementById("surplus_label2").style.display = "none";
    document.getElementById("surplus_password_input2").style.display = "none";
  }
  else if(action == 'open_surplus'){
    document.getElementById("popup_window").style.display = "";
    document.getElementById("surplus_label2").style.display = "";
    document.getElementById("surplus_password_input2").style.display = "";
  }
}

function close_surplus_window(){
  document.getElementById("surplus_password_input1").value="";
  document.getElementById("surplus_password_input2").value="";
  document.getElementById("popup_window").style.display="none";
  document.getElementById("surplus_label2").style.display="none";
  document.getElementById("surplus_password_input2").style.display="none";
  action = '';
}

function open_surplus(){
  action = 'open_surplus';
  open_surplus_window();
}

function close_surplus(){
  action = 'close_surplus';
  open_surplus_window();
}

function end_input_surplus(){
  if(action == 'open_surplus')
  {
    var pwd1 = document.getElementById("surplus_password_input1").value;
    var pwd2 = document.getElementById("surplus_password_input2").value;
    var msg = '';
    if(pwd1 !== pwd2)
    {
      msg = "密码不匹配\n";
    }
    if(pwd1.length < 6)
    {
      msg = msg + "您输入的密码太短\n"
    }

    if(msg.length > 0)
    {
      alert(msg);
    }
    else
    {
      Ajax.call('user.php?act=open_surplus_password','surplus_password='+pwd1,open_surplus_response,'GET','TEXT',true,true);
    }
  }
  else if(action == 'close_surplus')
  {
    var pwd1 = document.getElementById("surplus_password_input1").value;
    Ajax.call('user.php?act=close_surplus_password','surplus_password='+pwd1,close_surplus_response,'GET','TEXT',true,true);
  }
  else if(action == 'verify_surplus')
  {
    var pwd1 = document.getElementById("surplus_password_input1").value;
    Ajax.call('user.php?act=verify_surplus_password','surplus_password='+pwd1,verify_surplus_response,'GET','TEXT',true,true);
  }
}

function cancel_input_surplus()
{
  close_surplus_window();
}

function open_surplus_response(obj)
{
  if(obj == 1)
  {
    window.location="?act=account_security";
  }
  else
  {
    close_surplus_window();
    alert('开启失败！');
  }
}

function close_surplus_response(obj)
{
  if(obj == 1)
  {
    window.location="?act=account_security";
  }
  else
  {
    close_surplus_window();
    alert('关闭失败！');

  }
}

function verify_surplus_response(result)
{
  if(result == 1)
  {
    submit_surplus_form();
  }
  else
  {
    alert('密码错误！');
  }
}

function check_surplus_open(form)
{
  var surplus = form[0].value;
  if(surplus > 0)
  {
    Ajax.call("user.php?act=check_surplus_open","",check_surplus_open_response,"GET",true,true);
  }
  else
  {
    alert('输入的余额必须大于零！');
  }
  return false;
}

function check_surplus_open_response(result)
{
  if(result == '1')
  {
    action = 'verify_surplus';
    open_surplus_window();
  }
  else
  {
    submit_surplus_form();
  }
}

function submit_surplus_form(){
  document.getElementById("formFee").submit();
}
</script>
<?php endif; ?>
</head>
<body>
<?php if ($this->_var['action'] == 'account_security' || $this->_var['action'] == 'order_detail'): ?>

<div id="popup_window" style="background:#EFEFF4;box-shadow: 0 0 10px #ccc;border: 1px solid #ccc;border-radius: 6px;width:85%;height:auto;margin-left:-43%;margin-top:-20%;left:50%;top:50%;position:fixed;display:none;z-index:9999;">
<label class="yezf_tit" style="float:left;margin:15px;width: 90%;text-align: center;"><span>请输入余额支付密码</span></label>
<input id="surplus_password_input1" type="password" style='float:left;margin:10px 3%;width:91%;background-color:white;height:30px;border: 1px solid #ccc;padding-left: 6px;'/>
<label id="surplus_label2" style="width:90%;float:left;font-size:1.3em;display:none;margin:5px 10px;height:20px;"><span style="display: block;color:#A9A9AA;font-size: 15px;text-align: center;font-weight: bold;width: 91%;">请确认余额支付密码</span></label>
<input id="surplus_password_input2" type="password" style='float:left;margin:5px 18px;width:91%;background-color:white;height:30px;border: 1px solid #ccc;padding-left: 6px;display:none;'/>
<input class='yezf_QRB' type="button" onclick="end_input_surplus()" style="float:left;width: 50%;margin: 5px; padding:2% 0px; background: #EFEFF4;" value="确定" />
<input class='yezf_QXB' type="button" onclick="cancel_input_surplus()" style="float:left; width:40%;margin: 5px;padding:2% 0px;background: #EFEFF4;" value="取消" />
</div>

<?php endif; ?>
      <header>
      <div class="tab_nav">
        <div class="header">
          <div class="h-left"><a class="sb-back" href="javascript:history.back(-1)" title="返回"></a></div>
          <div class="h-mid"><?php if ($this->_var['action'] == 'profile'): ?>信息修改<?php elseif ($this->_var['action'] == 'default'): ?>用户中心<?php elseif ($this->_var['action'] == 'bonus'): ?>我的红包<?php elseif ($this->_var['action'] == 'order_list'): ?>我的订单<?php elseif ($this->_var['action'] == 'order_detail'): ?>订单详情<?php elseif ($this->_var['action'] == 'account_log' || $this->_var['action'] == 'account_deposit' || $this->_var['action'] == 'account_raply' || $this->_var['action'] == 'account_detail' || $this->_var['action'] == 'act_account' || $this->_var['action'] == 'pay'): ?>资金管理<?php elseif ($this->_var['action'] == 'address_list'): ?>地址管理<?php elseif ($this->_var['action'] == 'address'): ?>地址管理<?php elseif ($this->_var['action'] == 'vc_login'): ?>储值卡充值<?php endif; ?></div>
          <div class="h-right">
            <aside class="top_bar">
              <div onClick="show_menu();$('#close_btn').addClass('hid');" id="show_more"><a href="javascript:;"></a> </div>
            </aside>
          </div>
        </div>
      </div>
      </header>
       	<?php echo $this->fetch('library/up_menu.lbi'); ?> 
<div id="tbh5v0">
		<?php if ($this->_var['action'] == 'default'): ?>
			<div class="user_info">
				<div class="username"><?php echo $this->_var['info']['username']; ?></div>
			</div>
			<?php echo $this->fetch('library/user_nav.lbi'); ?>
		<?php endif; ?>

		<?php if ($this->_var['action'] == 'profile'): ?>
		<?php echo $this->fetch('library/user_welcome.lbi'); ?>
		<?php endif; ?>
		<?php if ($this->_var['action'] == 'order_list'): ?>
		<?php echo $this->fetch('library/user_order_list.lbi'); ?>
		<?php endif; ?>
		<?php if ($this->_var['action'] == 'bonus'): ?>
		<?php echo $this->fetch('library/user_bonus.lbi'); ?>
		<?php endif; ?>
		<?php if ($this->_var['action'] == 'address_list'): ?>
		<?php echo $this->fetch('library/user_address_list.lbi'); ?>
		<?php endif; ?>

		<?php if ($this->_var['action'] == 'order_detail'): ?>
		<?php echo $this->fetch('library/user_order_detail.lbi'); ?>
		<?php endif; ?>
		<?php if ($this->_var['action'] == "account_raply" || $this->_var['action'] == "account_log" || $this->_var['action'] == "act_account" || $this->_var['action'] == "account_deposit" || $this->_var['action'] == "account_detail"): ?>
			<?php echo $this->fetch('library/user_account.lbi'); ?>
		<?php endif; ?>
		<?php if ($this->_var['action'] == "vc_login"): ?>
		<?php echo $this->fetch('library/user_vclogin.lbi'); ?>
		<?php endif; ?>
        <?php if ($this->_var['action'] == 'address'): ?><?php echo $this->fetch('library/user_address.lbi'); ?><?php endif; ?>
        <?php if ($this->_var['action'] != 'order_detail'): ?><?php elseif ($this->_var['action'] == 'address_list'): ?>
		<?php echo $this->fetch('library/page_footer.lbi'); ?>
<?php echo $this->fetch('library/footer_nav.lbi'); ?>
<?php endif; ?>
</div>

<script language="javascript">
$(function(){ 
$('input[type=text],input[type=password]').bind({ 
focus:function(){ 
 $(".global-nav").css("display",'none'); 
}, 
blur:function(){ 
 $(".global-nav").css("display",'flex'); 
} 
}); 
}) 
</script>
</body>
</html>