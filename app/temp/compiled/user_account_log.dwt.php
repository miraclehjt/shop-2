<?php if ($this->_var['is_full_page'] == 1): ?>
<div class="ub user_check bg-color-w">
  <div class="ub-f1 selected" id="account_log_button" >
	<font>查看申请记录</font>
	</div>
  <div class="ub-f1 " id="account_detail_button" >
	<font>查看账户明细</font>
  </div>
</div>
<div class="m-all2 bg-color-w p-all3 f-color-6">
  <div class="ulev-1 l-h-2"> 您当前消费金额为：<span class="f-color-red ulev-0"><?php echo $this->_var['surplus_amount']; ?></span> </div>
  <div class="ulev-1 l-h-2"> <?php echo $this->_var['lang']['current_surplus']; ?><span class="f-color-red ulev-0"><?php echo $this->_var['surplus_yue']; ?></span></div>
  <div class="ub ub-ac ub-pc ubt border-faxian uinn-p2 m-top1">
    <div class="btn-red-2 ulev-1" id="user_capital_recharge">充值</div>
    <div class="btn-red-2 ulev-1 m-l2" id="user_capital_withdrawals">提现</div>
  </div>
</div>

<div id="content_container"> 
<?php endif; ?>
  <?php $_from = $this->_var['account_log']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
  <div class="bg-color-w ubb border-hui m-btm1">
    <div class="ub p-all5 f-color-6">
      <div class="ub-f1 ub ub-ac">
        <div class="ulev-9"><?php echo $this->_var['item']['type']; ?>：<font class="f-color-red"><?php echo $this->_var['item']['amount']; ?></font></div>
      </div>
      <div class="ub-pe ulev-1"><?php echo $this->_var['item']['pay_status']; ?></div>
    </div>
    <div class="bc-grey p-all1 ubb ubt border-faxian">
      <div><font class="ulev-1 sc-text-hui"><?php echo $this->_var['lang']['process_notic']; ?>：</font><font class="ulev-1 f-color-zi"><?php echo $this->_var['item']['short_user_note']; ?></font></div>
      <div class="m-top2"><font class="ulev-1 sc-text-hui"><?php echo $this->_var['lang']['admin_notic']; ?>：</font><font class="ulev-1 f-color-zi"><?php echo $this->_var['item']['short_admin_note']; ?> </font></div>
    </div>
    <div class="ub ub-ac p-all1 sc-text-hui">
      <div class="ub-f1 ulev-1">
		<?php echo $this->_var['item']['add_time']; ?>
		</div>
		<?php if ($this->_var['item']['payment_not_support']): ?>
		<div class="ub-f1 ulev-1">
		APP不支持<?php echo $this->_var['item']['pay_name']; ?>，请使用PC支付
		</div>
		<?php endif; ?>
      <div class="ub-pe ub ulev-1"> 
	  <?php if ($this->_var['item']['pay_online']): ?>
        <div class="btn-w1 m-l3 payment" pay_online='<?php echo $this->_var['item']['pay_online']; ?>'>付款</div>
        <?php endif; ?>
		
        <?php if (( $this->_var['item']['is_paid'] == 0 && $this->_var['item']['process_type'] == 1 ) || $this->_var['item']['handle']): ?>
        <div class="btn-w1 m-l3 cancel" account_id='<?php echo $this->_var['item']['id']; ?>'>取消</div>
        <?php endif; ?> 
      </div>
    </div>
  </div>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
   
  <?php if ($this->_var['is_full_page'] == 1): ?>
 </div>
<?php endif; ?>