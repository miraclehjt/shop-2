<div class="ub bc-blue p-all4" id='address' 
  <?php if ($this->_var['consignee']): ?> address_id="<?php echo $this->_var['consignee']['address_id']; ?>"<?php else: ?>address_id=""<?php endif; ?>> <?php if ($this->_var['consignee']): ?>
  <div class="ub-img address-icon mar-ar1 h-w-6"> </div>
  <div class="ub ub-f1" id="edit_address_button">
    <div class="ub ub-f1 ub-ver t-wh bc-text-head">
      <div class="ub ulev-9 p-r1">
        <div class="ulev-app2 ub-f1"> 收货人：<?php echo $this->_var['consignee']['consignee']; ?> </div>
        <div class="ulev-app2 ub-pe ufm1"> <?php echo $this->_var['consignee']['mobile']; ?> </div>
      </div>
      <div class="ulev-1 umar-t1"> 地址：<?php echo $this->_var['consignee']['address_short_name']; ?> </div>
      <div class="ub-pe" style="display:none">
        <div class="bc-head2 border-white"> 点此去完善收货地址吧 </div>
      </div>
    </div>
    <div class="ub ub-ac ub-pc">
      <div class="ub-img edit-blue h-w-6"> </div>
    </div>
  </div>
  <?php else: ?>
  <div id="edit_address_button"> 点此去完善收货地址吧 </div>
  <?php endif; ?> </div>
<?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'goodsinfo');$this->_foreach['glist'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['glist']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['goodsinfo']):
        $this->_foreach['glist']['iteration']++;
?>
<div class="bg-color-w supplier_box" suppid="<?php echo $this->_var['key']; ?>" seller="<?php echo $this->_var['goodsinfo']['goodlist']['0']['seller']; ?>" id="supplier_box_<?php echo $this->_var['key']; ?>">
  <div class="m-top3 p-all3 ub ub-ac ubb border-faxian _fold expand" fold_key="goods_list_<?php echo $this->_var['key']; ?>" style="padding-right:0px;">
    <div class="h-w-5 ub-img shop-icon"> </div>
    <div class="f-color-6 ulev-9 ub-f1 ut-m m-l2"> <?php echo $this->_var['goodsinfo']['goodlist']['0']['seller']; ?> </div>
	<div class="sc-text ulev-1-4 umar-r fold_indicator fa "> </div>
  </div>
  <div class="ub-ver" id="goods_list_<?php echo $this->_var['key']; ?>">
  <?php $_from = $this->_var['goodsinfo']['goodlist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['name']['iteration']++;
?>
  <div class="ub bc-grey p-all2 m-btm2 goods" goods_id="<?php echo $this->_var['goods']['goods_id']; ?>">
    <div class="h-w-7 mar-ar1 goods-img"> <img src="<?php echo $this->_var['url']; ?><?php echo $this->_var['goods']['goods_thumb']; ?>"> </div>
    <div class="ub-f1 ulev-1 mar-ar1 f-color-zi l-h-2">
      <div class="l-h-1"><?php echo $this->_var['goods']['goods_name']; ?></div>
      <div class="sc-text-hui ulev-1"> <?php echo nl2br($this->_var['goods']['goods_attr']); ?> </div>
    </div>
    <div class="ub ub-ver ub-ae">
      <div class="f-color-red ufm1 ulev-2"> <?php echo $this->_var['goods']['formated_goods_price']; ?> </div>
      <div class="sc-text-hui ufm1 ulev-2"> x<?php echo $this->_var['goods']['goods_number']; ?> </div>
    </div>
  </div>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
  </div>
   
  <?php echo $this->fetch('library/order_supplier_bonus.lib'); ?>
  <?php echo $this->fetch('library/order_supplier_shipping.lib'); ?> </div>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
<?php echo $this->fetch('library/order_delivery_time.lib'); ?> 
<?php echo $this->fetch('library/order_invoice.lib'); ?>
<?php echo $this->fetch('library/order_how_oos.lib'); ?>
<div class="m-top3 bg-color-w">
  <div class="uinn-eo5 ub ub-ac ubb border-hui _fold" fold_key="postscript_box">
    <div class="ub-f1 f-color-zi ulev-9 p-all5"> 订单附言 </div>
    <div class="sc-text ulev-1-4 umar-r fold_indicator fa "> </div>
  </div>
  <div class="ub uhide" id='postscript_box'>
    <textarea placeholder="订单附言" type="text" class="ulev-1 txtare-class ub-f1 m-all2" id='postscript'></textarea>
</div>
</div>
<?php if ($this->_var['allow_use_surplus']): ?>
<div class="m-top3 bg-color-w">
  <div class="uinn-eo5 ub ub-ac ubb border-hui">
    <div class="ub-f1 f-color-zi ulev-9 p-all5"> 使用余额 </div>
    <div id='surplus_switch' class="switch uba switch-mini ulev-1 mar-ar1 border-faxian m-top4 _switch" data-checked="false">
      <div class="switch-btn sc-bg-active"> </div>
    </div>
  </div>
  <div id='surplus_box' class='uhide'>
    <div class="p-all5 ulev-1 f-color-6 ub ub-ac">
      <input type='text' id='surplus' class="text-class ub-f1 ulev-1" placeholder="请输入余额" />
      <div class="ub-pe m-l1">您当前的可用余额为:<span class="your_surplus f-color-red"><?php echo empty($this->_var['your_surplus']) ? '0' : $this->_var['your_surplus']; ?> </span></div>
    </div>
  </div>
</div>
<?php endif; ?>
<div class="bg-color-w m-top3" id='paymen_container'>
  <div class="uinn-eo5 ub ub-ac ubb border-hui _fold expand" fold_key="payment_box" value_key='payment_item' id='fold_payment'>
    <div class="ub-f1 f-color-zi ulev-9 p-all5"> 支付方式 </div>
    <div class="ub-pe xuanzhong ulev-1 uhide selected_indicator" id='selected_payment'></div>
    <div class="sc-text ulev-1-4 umar-r fold_indicator fa"> </div>
  </div>
  <div id='payment_box' class="p-l-r6 f-color-6"> 
  <?php $_from = $this->_var['payment_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'payment');$this->_foreach['payment_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['payment_list']['total'] > 0):
    foreach ($_from AS $this->_var['payment']):
        $this->_foreach['payment_list']['iteration']++;
?>
    <div class="ub ulev-1 ub-ac lis-checkout _checkbox checkbox_radio payment <?php if ($this->_var['payment']['pay_code'] == 'alipay'): ?>checked<?php endif; ?>" is_cod="<?php echo $this->_var['payment']['is_cod']; ?>" is_pickup="<?php echo $this->_var['payment']['is_pickup']; ?>" pay_code="<?php echo $this->_var['payment']['pay_code']; ?>" name="payment_item|<?php if ($this->_var['payment']['pay_code'] != 'alipay_bank' && $this->_var['payment']['pay_code'] != 'cod' && $this->_var['payment']['pay_code'] != 'pup' && $this->_var['payment']['pay_code'] != 'balance'): ?>payment_other<?php else: ?>payment<?php endif; ?>" value="<?php echo $this->_var['payment']['pay_id']; ?>" <?php if ($this->_var['payment']['pay_code'] == 'alipay'): ?>checked="true"<?php endif; ?> radio="true" cancel="false" <?php if ($this->_var['cod_disabled'] && $this->_var['payment']['is_cod'] == "1"): ?>disabled="true"<?php endif; ?>><?php echo $this->_var['payment']['pay_name']; ?></div>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	</div>
</div>
<div class="bg-color-w ulev-1 tx-r p-all5 l-h-2 f-color-zi ubt border-hui m-top3" id='order_total'> <?php echo $this->fetch('library/order_total.lib'); ?> </div>
<div class="ub p-b3"> </div>
<div class="ub p-fixed-btm1 bg-color-w ubt border-hui yy-top" id='confirm_button'>
  <div class="ub-f1 ub ub-ac p-r1">
    <div class="ub-f1"> </div>
    <div class="ub-pe"> <font class="f-color-zi ulev-1">应付款金额：</font> <font class="f-color-red ulev0" id='order_total_label'> <?php echo $this->_var['total']['amount_formated']; ?> </font> </div>
  </div>
  <div class="btn-red1 ub-pe"> 确认订单 </div>
</div>
<script>
var surplus = '<?php echo empty($this->_var['your_surplus']) ? '0' : $this->_var['your_surplus']; ?>'
var pay_balance_id = '<?php echo $this->_var['pay_balance_id']; ?>'//保存余额支付的id做为js全局变量
</script> 
