<div class="red-pag ub ub-ac p-all5 ubb border-hui bg-color-w ulev-9"> <font class="f-color-6">当前账户余额：</font><font class="ulev0 f-color-red"><?php echo $this->_var['info']['surplus']; ?></font> </div>
<div class="m-all2 bg-color-w ulev-9">
  <div class="ubb ub border-f2 ub-ac h-min1">
    <div class="f-color-6 sc-text-hui uw-reg">储值卡卡号</div>
    <div class="uinput sc-text-hui">
      <input type="text" id="vcard" placeholder="请输入储值卡卡号"/>
    </div>
  </div>
  <div class="ubb ub border-f2 ub-ac h-min1">
    <div class="f-color-6 sc-text-hui uw-reg">储值卡密码</div>
    <div class="uinput sc-text-hui">
      <input type="password" id="pwd" placeholder="请输入储值卡密码"/>
    </div>
  </div>
  <div class="ubb ub border-f2 ub-ac h-min1">
    <div class="f-color-6 sc-text-hui uw-reg">充值卡账号</div>
    <div class="uinput sc-text-hui">
      <input type="text" id='card' value='<?php echo $_SESSION['user_name']; ?>' placeholder="用户名" readonly/>
    </div>
  </div>
</div>
<div class="ub ub-pe ub-ac p-l-r3">
  <div class="ulev-1 m-l3 sc-text-active1">充值卡账号默认为登录用户，不可编辑</div>
</div>
<div class="m-all2" id='confirm_button'>
  <div class="user-btn"> 确认 </div>
</div>
