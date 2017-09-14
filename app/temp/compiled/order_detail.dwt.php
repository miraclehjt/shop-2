  
  <div class="ub bc-blue bc-text-head uinn-a1">
    <div class="ub-img address-icon h-w-5"></div>
    <div class="ub ub-f1 ub-ver t-wh m-l3 ulev-1">
      <div class="ub">
        <div class="ub-f1">收货人：<?php echo htmlspecialchars($this->_var['order']['consignee']); ?></div>
		<?php if ($this->_var['order']['mobile']): ?>
        <div class="ub-pe"><?php echo $this->_var['lang']['backup_phone']; ?>：<?php echo htmlspecialchars($this->_var['order']['mobile']); ?></div>
		<?php endif; ?>
      </div>
      <?php if ($this->_var['order']['exist_real_goods']): ?>
      <div class="uinn-p2"><?php echo $this->_var['lang']['detailed_address']; ?>：<?php echo htmlspecialchars($this->_var['order']['address']); ?></div>
      <?php endif; ?>
	  <?php if ($this->_var['order']['email']): ?>
        <div class="uinn-p2">电子邮件：<?php echo htmlspecialchars($this->_var['order']['email']); ?></div>
		<?php endif; ?>
        <div class="ub ub-pj uinn-p2">
		<?php if ($this->_var['order']['zipcode']): ?>
        <div class=""><?php echo $this->_var['lang']['postalcode']; ?>：<?php echo htmlspecialchars($this->_var['order']['zipcode']); ?></div>
		<?php endif; ?>
	  <?php if ($this->_var['order']['tel']): ?>
      <div class=""> <?php echo $this->_var['lang']['phone']; ?>：<?php echo htmlspecialchars($this->_var['order']['tel']); ?> </div>
	  <?php endif; ?>
            </div>
      <?php if ($this->_var['order']['exist_real_goods']): ?>
      <div class="p-t1"><?php echo $this->_var['lang']['deliver_goods_time']; ?>：<?php echo htmlspecialchars($this->_var['order']['best_time']); ?> </div>
      <?php endif; ?> 
      <?php if ($this->_var['order']['allow_update_address'] > 0): ?>
      <div class="ub ub-pe ubt border-top uinn-p2 m-top3" id='edit_address_button'>
        <div class="btn-fff">修改收货地址</div>
      </div>
      <?php endif; ?> 
    </div>
  </div>


<div class="bg-color-w m-btm1 ubb border-hui">
  <div class="ub uinn-a1 ubb border-hui ub-ac">
    <div class="ub-img order-list h-w-1"></div>
    <div class="ub-f1 ub bc-text ulev-9 p-l-r5"><?php echo $this->_var['lang']['detail_order_sn']; ?>：<span class="f-color-red"><?php echo $this->_var['order']['order_sn']; ?></span></div>
  </div>
  <div class="ulev-1 f-color-6 p-t-b5">
    <div class="m-btm5"><?php echo $this->_var['lang']['detail_order_status']; ?>： <?php echo $this->_var['order']['order_status']; ?> <span class="sc-text-hui">- <?php echo $this->_var['order']['confirm_time']; ?></span></div>
    <div class="m-btm5"><?php echo $this->_var['lang']['detail_shipping_status']; ?>： <?php echo $this->_var['order']['shipping_status']; ?> <span class="sc-text-hui">- <?php echo $this->_var['order']['shipping_time']; ?></span></div>
    <div class="m-btm5"><?php echo $this->_var['lang']['detail_pay_status']; ?>： <?php echo $this->_var['order']['pay_status']; ?> <span class="sc-text-hui">- <?php echo $this->_var['order']['pay_time']; ?></span></div>
     </div>
     
     <?php if ($this->_var['order']['invoice_no'] && $this->_var['order']['shipping_name'] != '门店自提'): ?>
	 <?php if ($this->_var['order']['tc_express']): ?>
	 <?php echo $this->_var['result_content']; ?>
	 <?php else: ?>
    <?php $_from = $this->_var['order']['invoices']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'invoice_info');$this->_foreach['name_i'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name_i']['total'] > 0):
    foreach ($_from AS $this->_var['invoice_info']):
        $this->_foreach['name_i']['iteration']++;
?>
	<div class="express_info ub uinn-a1 ub-ac ubt border-faxian"  express_number="<?php echo $this->_var['invoice_info']['invoice_no']; ?>" express_name="<?php echo $this->_var['invoice_info']['shipping_name']; ?>" order_id="<?php echo $this->_var['order']['order_id']; ?>">
    	<div class="ub-img logistics h-w-1"></div>
    	<div class="ulev-1 f-color-screen p-l-r5 ub-f1"><?php echo $this->_var['lang']['consignment']; ?><?php echo $this->_foreach['name_i']['iteration']; ?>：<?php echo $this->_var['invoice_info']['invoice_no']; ?></div>
        <div class="btn-screen-1 ulev-1 m-l1 ub-pe">查看物流详情</div>
    </div>
	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	<?php endif; ?>
    <?php endif; ?>
</div>


<div class="bg-color-w m-btm1 ubb border-hui">
  <div class="ub uinn-a1 ubb border-hui ub-ac">
    <div class="ub-img user_order1 h-w-1"></div>
    <div class="ub-f1 ub bc-text ulev-9 p-l-r5"><?php echo $this->_var['lang']['payment']; ?></div>
  </div>
  <div class="ulev-1 p-t-b2 f-color-6">
    <div class="m-btm5"><?php echo $this->_var['lang']['select_payment']; ?>： <?php echo $this->_var['order']['pay_name']; ?></div>
    <div class="m-btm5"><?php echo $this->_var['lang']['order_amount']; ?>： <span class="f-color-red ulev0"><?php echo $this->_var['order']['formated_order_amount']; ?></span> </div>
    <?php if ($this->_var['payment_list']): ?>
    <div class="m-btm5 ub ub-ac ulev-1 ub-f1 styled-select">
      <select name="pay_code" id='pay_code'>
        <?php $_from = $this->_var['payment_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'payment');if (count($_from)):
    foreach ($_from AS $this->_var['payment']):
?>
        <option <?php if ($this->_var['order']['pay_name'] == $this->_var['payment']['pay_name']): ?>selected='selected'<?php endif; ?> value="<?php echo $this->_var['payment']['pay_code']; ?>"> <?php echo $this->_var['payment']['pay_name']; ?> </option>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      </select>
      <div id='edit_payment_button' class='btn-red-3'>确认</div>
    </div>
    <?php endif; ?> 
    
      <?php if ($this->_var['allow_edit_surplus']): ?>
      <div class="ub ub-ac ulev-1 ubt border-faxian p-r1 p-t2 m-btm5">
            <label for='surplus' class="f-color-6"><?php echo $this->_var['lang']['use_more_surplus']; ?>：</label>
            <div class="uinput1 uba border-hui m-l-r2">
            <input class="ulev0" type='text' id='surplus' placeholder='请输入余额' style="width:7em;" />
            </div>
            <div class='btn-red-3' id='confirm_surplus_button'>确定</div>
      </div>
      <div class="ub m-btm5 ulev-1 m-top1"> <?php echo $this->_var['max_surplus']; ?> </div>
      <?php endif; ?> 
  </div>
  
</div>


<div class="bg-color-w ubb border-hui">
  <div class="m-top3 ub bc-text ub-ac uinn-a1 ubb border-hui">
    <div class="ub-img shop-icon h-w-1"></div>
    <div class="ub-f1 ub ut-m ulev-9 p-l-r5"><?php echo $this->_var['order']['referer']; ?></div>
  </div>
  <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
  <?php if ($this->_var['goods']['goods_id'] > 0 && $this->_var['goods']['extension_code'] != 'package_buy'): ?>
  <div class="ub p-all2 bc-grey goods cart-box" goods_id='<?php echo $this->_var['goods']['goods_id']; ?>'>
    <div class="h-w-7 mar-ar1 goods-img" > <img src="<?php echo $this->_var['url']; ?><?php echo $this->_var['goods']['goods_thumb']; ?>"/></div>
    <div class="ub-f1 ulev-1 mar-ar1 f-color-zi l-h-1 goods-img"> <?php echo $this->_var['goods']['goods_name']; ?>
      <?php if ($this->_var['goods']['parent_id'] > 0): ?> <span>（<?php echo $this->_var['lang']['accessories']; ?>）</span> <?php elseif ($this->_var['goods']['is_gift']): ?> <span>（<?php echo $this->_var['lang']['largess']; ?>）</span> <?php endif; ?> </div>
    <div class="ub ub-ver ub-ae goods-img">
      <div class="f-color-red ulev-4"> <span class="ulev-2"></span><?php echo $this->_var['goods']['goods_price']; ?> </div>
      <div class="sc-text-hui ulev-4"> x<?php echo $this->_var['goods']['goods_number']; ?> </div>
    </div>
  </div>
  <?php elseif ($this->_var['goods']['goods_id'] > 0 && $this->_var['goods']['extension_code'] == 'package_buy'): ?>
  <?php endif; ?>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
<div class="uinn-a1 lis f-color-6 ubt border-faxian">
    <div class="ub ulev-1"> 
    商品总价：
    <?php if ($this->_var['order']['extension_code'] == "group_buy"): ?><?php echo $this->_var['lang']['gb_deposit']; ?><?php endif; ?><?php echo $this->_var['order']['formated_goods_amount']; ?> 
      <?php if ($this->_var['order']['discount'] > 0): ?> 
      - <?php echo $this->_var['lang']['discount']; ?>：<?php echo $this->_var['order']['formated_discount']; ?> 
      <?php endif; ?> 
      <?php if ($this->_var['order']['tax'] > 0): ?> 
      + <?php echo $this->_var['lang']['tax']; ?>：<?php echo $this->_var['order']['formated_tax']; ?> 
      <?php endif; ?> 
      <?php if ($this->_var['order']['shipping_fee'] > 0): ?> 
      + <?php echo $this->_var['lang']['shipping_fee']; ?>：<?php echo $this->_var['order']['formated_shipping_fee']; ?> 
      <?php endif; ?> 
      <?php if ($this->_var['order']['insure_fee'] > 0): ?> 
      + <?php echo $this->_var['lang']['insure_fee']; ?>：<?php echo $this->_var['order']['formated_insure_fee']; ?> 
      <?php endif; ?> 
      <?php if ($this->_var['order']['pay_fee'] > 0): ?> 
      + <?php echo $this->_var['lang']['pay_fee']; ?>：<?php echo $this->_var['order']['formated_pay_fee']; ?> 
      <?php endif; ?> 
      <?php if ($this->_var['order']['pack_fee'] > 0): ?> 
      + <?php echo $this->_var['lang']['pack_fee']; ?>：<?php echo $this->_var['order']['formated_pack_fee']; ?> 
      <?php endif; ?> 
      <?php if ($this->_var['order']['card_fee'] > 0): ?> 
      + <?php echo $this->_var['lang']['card_fee']; ?>：<?php echo $this->_var['order']['formated_card_fee']; ?> 
      <?php endif; ?> 
    </div>
  <div class="ub ulev-1 m-top1"> 
    <?php if ($this->_var['order']['money_paid'] > 0): ?> 
    - <?php echo $this->_var['lang']['order_money_paid']; ?>：<font class="f-color-red"><?php echo $this->_var['order']['formated_money_paid']; ?></font> 
    <?php endif; ?> 
    <?php if ($this->_var['order']['surplus'] > 0): ?> 
    - <?php echo $this->_var['lang']['use_surplus']; ?>：<?php echo $this->_var['order']['formated_surplus']; ?> 
    <?php endif; ?> 
    <?php if ($this->_var['order']['integral_money'] > 0): ?> 
    - <?php echo $this->_var['lang']['use_integral']; ?>：<?php echo $this->_var['order']['formated_integral_money']; ?> 
    <?php endif; ?> 
    <?php if ($this->_var['order']['bonus'] > 0): ?> 
    - <?php echo $this->_var['lang']['use_bonus']; ?>：<?php echo $this->_var['order']['formated_bonus']; ?> 
    <?php endif; ?> 
  </div>
    <div class="ub f-color-red ulev-1 ub-pe">
      <?php if ($this->_var['order']['extension_code'] == "group_buy"): ?>
      <?php echo $this->_var['lang']['notice_gb_order_amount']; ?> 
      <?php elseif ($this->_var['order']['extension_code'] == "pre_sale"): ?> 
      <?php echo $this->_var['lang']['notice_ps_order_amount']; ?> 
      <?php endif; ?> 
    </div>
</div>
</div>
</div>
<div class="bg-color-w">
  <div class="m-top3 ub bc-text ub-ac ubb border-faxian uinn-a1">
    <div class="ub-img" style="background-image:url(img/icons/icon-more-act.png);width:1.1em; height:1.1em;"></div>
    <div class="ub-f1 ub ut-m ulev-9 p-l-r5">其他信息</div>
  </div>
  <div class="m-btm5 ulev-1 f-color-6 p-b2"> 
    <?php if ($this->_var['order']['shipping_id'] > 0): ?>
    <div class="p-t1">配送方式：<?php echo $this->_var['order']['shipping_name']; ?></div>
    <?php endif; ?> 
    <?php if ($this->_var['order']['pay_id'] > 0): ?>
    <div class="p-t1">支付方式：<?php echo $this->_var['order']['pay_name']; ?></div>
    <?php endif; ?> 
    <?php if ($this->_var['order']['insure_fee'] > 0): ?>
    <div class="p-t1"><?php echo $this->_var['lang']['insure_fee']; ?>：<?php echo $this->_var['order']['insure_fee']; ?></div>
    <?php endif; ?> 
    <?php if ($this->_var['order']['pack_name']): ?>
    <div class="p-t1"><?php echo $this->_var['lang']['use_pack']; ?>：<?php echo $this->_var['order']['pack_name']; ?></div>
    <?php endif; ?> 
    <?php if ($this->_var['order']['card_name']): ?>
    <div class="p-t1"><?php echo $this->_var['lang']['use_card']; ?>：<?php echo $this->_var['order']['card_name']; ?></div>
    <?php endif; ?> 
    <?php if ($this->_var['order']['card_message']): ?>
    <div class="p-t1"><?php echo $this->_var['lang']['bless_note']; ?>：<?php echo $this->_var['order']['card_message']; ?></div>
    <?php endif; ?> 
    <?php if ($this->_var['order']['surplus'] > 0): ?>
    <div class="p-t1"><?php echo $this->_var['lang']['use_surplus']; ?>：<?php echo $this->_var['order']['surplus']; ?></div>
    <?php endif; ?> 
    <?php if ($this->_var['order']['integral'] > 0): ?>
    <div class="p-t1"><?php echo $this->_var['lang']['use_integral']; ?>：<?php echo $this->_var['order']['integral']; ?></div>
    <?php endif; ?> 
    <?php if ($this->_var['order']['bonus'] > 0): ?>
    <div class="p-t1"><?php echo $this->_var['lang']['bonus']; ?>：<?php echo $this->_var['order']['bonus']; ?></div>
    <?php endif; ?> 
    <?php if ($this->_var['order']['inv_type'] == 'vat_invoice'): ?>
    <div class="p-t1">发票类型：<?php echo $this->_var['lang'][$this->_var['order']['inv_type']]; ?></div>
    <div class="p-t1">发票内容：<?php echo $this->_var['order']['inv_content']; ?></div>
    <div class="p-t1">单位名称：<?php echo $this->_var['order']['vat_inv_company_name']; ?></div>
    <div class="p-t1">纳税人识别号：<?php echo $this->_var['order']['vat_inv_taxpayer_id']; ?></div>
    <div class="p-t1">注册地址：<?php echo $this->_var['order']['vat_inv_registration_address']; ?></div>
    <div class="p-t1">注册电话：<?php echo $this->_var['order']['vat_inv_registration_phone']; ?></div>
    <div class="p-t1">开户银行：<?php echo $this->_var['order']['vat_inv_deposit_bank']; ?></div>
    <div class="p-t1">银行账户：<?php echo $this->_var['order']['vat_inv_bank_account']; ?></div>
    <div class="p-t1">收票人姓名：<?php echo $this->_var['order']['inv_consignee_name']; ?></div>
    <div class="p-t1">收票人手机：<?php echo $this->_var['order']['inv_consignee_phone']; ?></div>
    <div class="p-t1">收票人地址：<?php echo $this->_var['order']['inv_complete_address']; ?></div>
    <?php endif; ?> 
    <?php if ($this->_var['order']['inv_type'] == 'normal_invoice'): ?>
    <div class="p-t1">发票类型：<?php echo $this->_var['lang'][$this->_var['order']['inv_type']]; ?></div>
    <div class="p-t1">发票抬头：<?php echo $this->_var['order']['inv_payee']; ?></div>
    <div class="p-t1">发票内容：<?php echo $this->_var['order']['inv_content']; ?></div>
    <?php endif; ?> 
    <?php if ($this->_var['order']['postscript']): ?>
    <div class="p-t1">订单附言：<?php echo $this->_var['order']['postscript']; ?></div>
    <?php endif; ?> 
    <?php if ($this->_var['order']['how_oos_name']): ?>
    <div class="p-t1">缺货处理：<?php echo $this->_var['order']['how_oos_name']; ?></div>
    <?php endif; ?> 
  </div>
</div>
<?php if ($this->_var['order']['order_amount'] > 0): ?> 
<div class="p-fixed-btm1 ubt border-hui bg-color-w yy-top">
	<div class="p-all2 ub ub-ac ub-pe">
        <font class="ulev-1 f-color-6">应付款金额：</font><font class="ulev-1-4 f-color-red"><?php echo $this->_var['order']['formated_order_amount']; ?></font>
        <?php if ($this->_var['order']['pay_online']): ?>
          <div pay_online='<?php echo $this->_var['order']['pay_online']; ?>'  class="btn-w2-red m-l2 payment" style="display:block; width:5em" >立即支付</div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>
<div class="ub" style="height:3em;"></div>