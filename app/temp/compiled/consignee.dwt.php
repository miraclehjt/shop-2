

<div class="m-all2 bg-color-w ulev-9">
  <div class="ubb ub border-f2 ub-ac h-min1">
    <div class="f-color-6 sc-text-hui uw-reg"> <font class="f-color-red">*</font>收件人 </div>
    <div class="uinput sc-text-hui">
      <input type="text" id="consignee" placeholder="请输入收件人" value="<?php echo htmlspecialchars($this->_var['consignee']['consignee']); ?>"/>
    </div>
  </div>
   
  <?php if ($_REQUEST['act'] != 'edit_order_address'): ?>
  <div class="ubb ub border-f2 ub-ac h-min1">
    <div class="f-color-6 sc-text-hui uw-reg"> <font class="f-color-red">*</font>所在地区 </div>
    <div class="uinput sc-text-hui ub-f1 styled-select">
      <select id='province'>
        <option value="0"><?php echo $this->_var['lang']['please_select']; ?></option>
        <?php $_from = $this->_var['province_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'province');if (count($_from)):
    foreach ($_from AS $this->_var['province']):
?>
        <option value="<?php echo $this->_var['province']['region_id']; ?>" <?php if ($this->_var['consignee']['province'] == $this->_var['province']['region_id']): ?>selected<?php endif; ?>><?php echo $this->_var['province']['region_name']; ?></option>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      </select>
      <select id='city'>
        <option value="0"><?php echo $this->_var['lang']['please_select']; ?></option>
        <?php $_from = $this->_var['city_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'city');if (count($_from)):
    foreach ($_from AS $this->_var['city']):
?>
        <option value="<?php echo $this->_var['city']['region_id']; ?>" <?php if ($this->_var['consignee']['city'] == $this->_var['city']['region_id']): ?>selected<?php endif; ?>><?php echo $this->_var['city']['region_name']; ?></option>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      </select>
      <select id='district'>
        <option value="0"><?php echo $this->_var['lang']['please_select']; ?></option>
        <?php $_from = $this->_var['district_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'district');if (count($_from)):
    foreach ($_from AS $this->_var['district']):
?>
        <option value="<?php echo $this->_var['district']['region_id']; ?>" <?php if ($this->_var['consignee']['district'] == $this->_var['district']['region_id']): ?>selected<?php endif; ?>><?php echo $this->_var['district']['region_name']; ?></option>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      </select>
    </div>
  </div>
  <?php endif; ?>
  <div class="ubb ub border-f2 ub-ac h-min1">
    <div class="f-color-6 sc-text-hui uw-reg"> <font class="f-color-red">*</font>街道地址 </div>
    <div class="uinput sc-text-hui">
      <input type="text" id="address" placeholder="请输入街道地址" value="<?php echo htmlspecialchars($this->_var['consignee']['address']); ?>"/>
    </div>
  </div>
  
  <div class="ubb ub border-f2 ub-ac h-min1">
    <div class="f-color-6 sc-text-hui uw-reg"> 电子邮箱 </div>
    <div class="uinput sc-text-hui">
      <input type="text" id="email" placeholder="请输入电子邮箱" value="<?php echo htmlspecialchars($this->_var['consignee']['email']); ?>" />
    </div>
  </div>
  <div class="ubb ub border-f2 ub-ac h-min1">
    <div class="f-color-6 sc-text-hui uw-reg"> 邮编 </div>
    <div class="uinput sc-text-hui">
      <input type="text" id="zipcode" placeholder="请输入邮编" value="<?php echo htmlspecialchars($this->_var['consignee']['zipcode']); ?>"/>
    </div>
  </div>
  <div class="ubb ub border-f2 ub-ac h-min1">
    <div class="f-color-6 sc-text-hui uw-reg"> <font class="f-color-red">*</font>手机号码 </div>
    <div class="uinput sc-text-hui">
      <input type="text" id="mobile" placeholder="请输入手机号码" value="<?php echo htmlspecialchars($this->_var['consignee']['mobile']); ?>"/>
    </div>
  </div>
  <div class="ubb ub border-f2 ub-ac h-min1">
    <div class="f-color-6 sc-text-hui uw-reg"> 固定电话 </div>
    <div class="uinput sc-text-hui">
      <input type="text" id="tel" placeholder="请输入固定电话" value="<?php echo htmlspecialchars($this->_var['consignee']['tel']); ?>"/>
    </div>
  </div>
</div>
<div class="m-all2" id='confirm_button'>
  <div class="user-btn"> 确定 </div>
</div>
