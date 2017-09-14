<?php $_from = $this->_var['shipping_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'shipping');if (count($_from)):
    foreach ($_from AS $this->_var['shipping']):
?> 
  <div class="ub ulev-1 ub-ac lis-checkout shipping <?php if ($this->_var['shipping']['selected'] != ''): ?> checked<?php endif; ?> _checkbox checkbox_radio" radio="true" cancel="false" <?php if ($this->_var['shipping']['selected'] != ''): ?> checked="true"<?php endif; ?> name="shipping_<?php echo $this->_var['suppid']; ?>" value="<?php echo $this->_var['shipping']['shipping_id']; ?>" supplier_id="<?php echo $this->_var['suppid']; ?>">
	<?php if ($this->_var['shipping']['shipping_code'] != 'tc_express' && $this->_var['shipping']['shipping_code'] != 'pups'): ?>
		<?php echo $this->_var['lang']['common_express']; ?>
	<?php else: ?>
		<?php echo $this->_var['shipping']['shipping_name']; ?>
	<?php endif; ?>
  </div>
  <?php endforeach; else: ?>
  <div>暂不支持收货地址配送</div>
<?php endif; unset($_from); ?><?php $this->pop_vars();; ?> 
