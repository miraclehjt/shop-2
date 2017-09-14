<?php if ($this->_var['is_full_page'] == 1): ?>
<div class="ub bg-color-w ub-ae f-color-6 m-btm1">
      <div class="ub ub-f1 ub-pc ub-ac ulev-1 p-t-b6 order-list-top _checkbox <?php if ($_REQUEST['composite_status'] == - 1): ?>checked<?php endif; ?>" radio="true" name="composite_status" value="-1" cancel="false">
        全部(<?php echo empty($this->_var['order_count']['all']) ? '0' : $this->_var['order_count']['all']; ?>)
      </div>
      <div class="ub ub-f1 ub-pc ub-ac ulev-1 p-t-b6 order-list-top _checkbox <?php if ($_REQUEST['composite_status'] == $this->_var['status']['await_pay']): ?>checked<?php endif; ?>" radio="true" name="composite_status" value="<?php echo $this->_var['status']['await_pay']; ?>" cancel="false">
        待付款(<?php echo empty($this->_var['order_count']['await_pay']) ? '0' : $this->_var['order_count']['await_pay']; ?>)
      </div>
      <div class="ub ub-f1 ub-pc ub-ac ulev-1 p-t-b6 order-list-top _checkbox <?php if ($_REQUEST['composite_status'] == $this->_var['status']['await_ship']): ?>checked<?php endif; ?>" radio="true" name="composite_status" value="<?php echo $this->_var['status']['await_ship']; ?>" cancel="false">
        待发货(<?php echo empty($this->_var['order_count']['await_ship']) ? '0' : $this->_var['order_count']['await_ship']; ?>)
      </div>
      <div class="ub ub-f1 ub-pc ub-ac ulev-1 p-t-b6 order-list-top _checkbox <?php if ($_REQUEST['composite_status'] == $this->_var['status']['shipped']): ?>checked<?php endif; ?>" radio="true" name="composite_status" value="<?php echo $this->_var['status']['shipped']; ?>" cancel="false">
        待收货(<?php echo empty($this->_var['order_count']['shipped']) ? '0' : $this->_var['order_count']['shipped']; ?>)
      </div>
      <div class="ub ub-f1 ub-pc ub-ac ulev-1 p-t-b6 order-list-top _checkbox <?php if ($_REQUEST['composite_status'] == $this->_var['status']['finished']): ?>checked<?php endif; ?>" radio="true" name="composite_status" value="<?php echo $this->_var['status']['finished']; ?>" cancel="false">
		已完成(<?php echo empty($this->_var['order_count']['finished']) ? '0' : $this->_var['order_count']['finished']; ?>)
      </div>
    </div>
<div id="order_list_container">
<?php endif; ?>
<?php $_from = $this->_var['orders']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
<div class="ub ub-ver bg-color-w m-btm1 ubb border-hui">
  <div class="bg-color-w ub ub-ac uinn-a1">
    <div class="ub-img h-w-1 shop-icon"></div>
    <div class="f-color-zi ub ub-f1 ut-m ulev-9 p-l-r5"><?php echo $this->_var['item']['shopname']; ?><div class="chat-btn1 p-l-r5 _chat" chat_attr="supplier_id|order_id" supplier_id="<?php echo $this->_var['item']['supplier_id']; ?>" order_id="<?php echo $this->_var['item']['order_id']; ?>"></div></div>
    <div class="f-color-red ulev-1 lv_subTitle m-top4"> <?php echo $this->_var['item']['order_status_text']; ?><span class="m-l-r2"><?php echo $this->_var['item']['pay_status_text']; ?></span><?php echo $this->_var['item']['shipping_status_text']; ?> </div>
  </div>
  <div class="ub ub-ver">
    <div class="ub ub-ac cart-box goods_list" order_id='<?php echo $this->_var['item']['order_id']; ?>'>
      <div id="check_order_detail" style="width:100%;"> <?php $_from = $this->_var['item']['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['goods']['iteration']++;
?>
        <div class="ub uinn-a1 m-btm2 bc-grey">
          <div class="lis-icon ub-img" style="background-image:url(<?php echo $this->_var['url']; ?><?php echo $this->_var['goods']['thumb']; ?>)"></div>
          <div class="ub-f1">
            <div class="bc-text ub ulev-1 f-color-6 l-h-1"><?php echo $this->_var['goods']['goods_name']; ?></div>
            <div class="ulev-2 sc-text-hui p-t-b3"><?php if ($this->_var['goods']['goods_attr']): ?><?php echo nl2br($this->_var['goods']['goods_attr']); ?><?php endif; ?></div>
          </div>
          <div class="ub-ver ulev-1 l-h-1 m-l1">
            <div class="f-color-zi lv_subTitle"><span class="ulev-2"></span><?php echo $this->_var['goods']['formated_goods_price']; ?></div>
            <div class="ulev-2 uinn3 sc-text-hui">x<?php echo $this->_var['goods']['goods_number']; ?></div>
          </div>
        </div>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> </div>
    </div>
    <div class="ub ub-ac uinn-a1 ubb border-faxian">
      <div class="ub-f1 ub-pe ub"> <span class="ulev-1 f-color-6">合计：</span><span class="f-color-red"><span class="ulev-2"></span><?php echo $this->_var['item']['total_fee']; ?></span></div>
    </div>
    <div class="ub ub-pe uinn-a1 order_action_container ub-ac"
	   order_id="<?php echo $this->_var['item']['order_id']; ?>"> <?php $_from = $this->_var['item']['handler']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'handler');if (count($_from)):
    foreach ($_from AS $this->_var['handler']):
?>
      <div class="ub btn-w2 m-l2 order_action" order_action="<?php echo $this->_var['handler']['code']; ?>" ><?php echo $this->_var['handler']['name']; ?></div>
      <?php if ($this->_var['handler']['code'] == 'affirm_received'): ?>
      <div class="ulev-1 sc-text-hui m-l2">还剩<?php echo $this->_var['item']['receive_confirm_deadline']; ?>天自动收货</div>
      <?php endif; ?>
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> </div>
  </div>
</div>
<?php endforeach; else: ?>
<div class="ub ub-pc umar-t1 f-color-6">没有找到任何订单</div>
<?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
<?php if ($this->_var['is_full_page'] == 1): ?>
</div>
<?php endif; ?>