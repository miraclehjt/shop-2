<?php if (( $this->_var['allow_use_bonus'] && $this->_var['goodsinfo']['goodlist'] )): ?>
<div class="uinn-eo5 ub ub-ac ubb border-faxian _fold" fold_key='coupon_integral_<?php echo $this->_var['key']; ?>'>
  <div class="ub-f1 f-color-zi ulev-9 p-all5">使用店铺优惠券</div>
  <div class="ub-pe ulev-1-4 sc-text umar-r fold_indicator fa"></div>
</div>
<div id="coupon_integral_<?php echo $this->_var['key']; ?>" class='uhide p-all1 sc-text-hui ubb border-hui'>
<div class="ub ub-ac p-t-b3">
  <div class="ub-f1 ulev-1 w-min4">使用店铺优惠券：</div>
  	<div class="styled-select sc-text-hui ub-ac ulev-1 ub-f1 styled-select">
	  <select class="bonus" key='<?php echo $this->_var['key']; ?>'>
		<option value="0" selected><?php echo $this->_var['lang']['please_select']; ?></option>
		<?php $_from = $this->_var['goodsinfo']['redbag']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'bonus');if (count($_from)):
    foreach ($_from AS $this->_var['bonus']):
?>
		<option value="<?php echo $this->_var['bonus']['bonus_id']; ?>"><?php echo $this->_var['bonus']['type_name']; ?>[<?php echo $this->_var['bonus']['bonus_money_formated']; ?>]</option>
		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	  </select>
	</div>
</div>
<div class="ub ub-ac p-t-b3">
<div class="ulev-1 w-min4">或输入优惠券号：</div>
<input id='bonus_sn_<?php echo $this->_var['key']; ?>' key='<?php echo $this->_var['key']; ?>' class='bonus_sn ub-f1 uinput1 p-all6 uba border-faxian ulev-1' type="text" size="15"
value="<?php if ($this->_var['order']['bonus_sn_info'] [ $this->_var['key'] ]): ?><?php echo $this->_var['order']['bonus_sn_info'][$this->_var['key']]; ?><?php endif; ?>" placeholder='输入优惠券'/>
<div class="uinput1 ulev-1"> 
<div class="validate_bonus btn-red-3" key="<?php echo $this->_var['key']; ?>" style="background:#dd2726; margin-left:0.5em; padding:0.3em 0.6em">使用</div>
</div>
</div>
</div>
<?php endif; ?>

