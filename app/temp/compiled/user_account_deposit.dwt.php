

<div class="m-all2 bg-color-w ulev-9">
  <div class="ubb ub border-f2 ub-ac h-min1">
    <div class="f-color-6 uw-reg"> <?php echo $this->_var['lang']['deposit_money']; ?>: </div>
    <div class="uinput sc-text-hui">
      <input type="text" id="amount" placeholder="请输入金额" value=""/>
    </div>
  </div>
  <div class="ubb ub border-f2 ub-ac h-min1">
    <div class="f-color-6 uw-reg"> <?php echo $this->_var['lang']['process_notic']; ?>: </div>
    <div class="uinput ub-f1 m-btm3 uba border-faxian">
      <textarea id="user_note" placeholder="请输入内容" value=""></textarea>
    </div>
  </div>
  <div class="ubb ub border-f2 ub-ac h-min1">
    <div class="f-color-6 uw-reg"> <?php echo $this->_var['lang']['payment']; ?>：</div>
    <div class="uinput ub-f1 m-btm3 uba border-faxian ub-ver"> 
      <?php $_from = $this->_var['payment']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['payment'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['payment']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['payment']['iteration']++;
?>
      <div class="_checkbox checkbox_radio <?php if ($this->_var['list']['pay_code'] == 'alipay'): ?>checked<?php endif; ?>" name='payment' id="payment_<?php echo $this->_var['list']['pay_id']; ?>" value="<?php echo $this->_var['list']['pay_id']; ?>" radio="true" cancel="false"><?php echo $this->_var['list']['pay_name']; ?></div>
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
    </div>
  </div>
</div>
<div class="m-all2 ub ub-pc bc-text-head" >
  <input type="hidden" id="rec_id" value="<?php echo $this->_var['order']['id']; ?>" />
  <div class="uinn-a1 user-btn1 mar-ar1" id='confirm_button'> <?php echo $this->_var['lang']['submit_request']; ?> </div>
  <!-- <div class="uinn-a1 user-btn1" id='reset_button'> <?php echo $this->_var['lang']['button_reset']; ?> </div> --> 
</div>
