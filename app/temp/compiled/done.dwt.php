
<div class="bg-color-w">
  <div class="p-all4 ubb border-hui ulev-9 f-color-red ub ub-ac ub-pc">
    <div class="hook h-w-2 ub-img"></div>
    <div class="p-l1">订单提交成功！</div>
  </div>
  <?php if ($this->_var['split_order']['sub_order_count'] > 1): ?>
  <div class="p-all4 ubb border-hui ulev-1 f-color-6 tx-c">由于您的商品由不同的商家发出，此订单将分为<font class="sc-text-warn"><?php echo $this->_var['split_order']['sub_order_count']; ?></font>个不同的子订单配送：</div>
  <?php endif; ?>
  <?php $_from = $this->_var['split_order']['suborder_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'suborder');if (count($_from)):
    foreach ($_from AS $this->_var['suborder']):
?>
  <div class="ub bg-color-f2 ulev-1 f-color-6 p-all3 ubb border-faxian">
    <div class="w-min3 p-l1">订单号：</div>
    <div class=""><?php echo $this->_var['suborder']['order_sn']; ?></div>
  </div>
  <div class="ub bg-color-f2 ulev-1 f-color-6 p-all3 ubb border-faxian">
    <div class="w-min3 p-l1"><?php echo $this->_var['order']['pay_name']; ?>：</div>
    <div class=""><?php echo $this->_var['suborder']['order_amount_formated']; ?></div>
  </div>
  <div class="ub bg-color-f2 ulev-1 f-color-6 p-all3 ubb border-faxian">
    <div class="w-min3 p-l1"><?php echo $this->_var['order']['shipping_name']; ?>：</div>
    <div class=""><?php echo $this->_var['order']['best_time']; ?></div>
  </div>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
  <?php if ($this->_var['total']['real_goods_count'] == 0): ?> 
  <?php $_from = $this->_var['virtual_card']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'virtual_card1');if (count($_from)):
    foreach ($_from AS $this->_var['virtual_card1']):
?> 
  <?php $_from = $this->_var['virtual_card1']['info']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'virtual_card2');if (count($_from)):
    foreach ($_from AS $this->_var['virtual_card2']):
?>
  <div class="ub p-all3 ubb border-faxian ulev-1 f-color-6">
    <div class="ub-f1">虚拟商品编号: <?php echo $this->_var['virtual_card2']['card_sn']; ?></div>
    <div class="ub-pe"><?php if ($this->_var['virtual_cart2']['is_verification'] == 0): ?>未使用<?php else: ?>已使用<?php endif; ?></div>
  </div>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
  <?php endif; ?>
  <div class="ub p-all3 ubb border-faxian ub-pc ub-ac"> <?php if ($this->_var['pay_online']): ?>
    <div class='payment btn-red-2' pay_online='<?php echo $this->_var['pay_online']; ?>'> 立即支付</div>
	<div class="btn-red-2 m-l1 to_order_list" composite_status="<?php echo $this->_var['status']['await_pay']; ?>">进入我的订单中心</div>
    <?php else: ?>
    <div class="btn-red-2 m-all1 ulev-9 to_order_list" composite_status="<?php echo $this->_var['status']['await_pay']; ?>">进入我的订单中心</div>
    <font class="f-color-6 ulev-1">订单已经提交成功</font> <?php endif; ?> </div>
</div>
