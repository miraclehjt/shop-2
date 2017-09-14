<?php if ($this->_var['best']): ?> 
<?php if ($this->_var['is_full_page'] == 1): ?>
<div class="uof p-t-b1" id="best_goods_container">
  <div class="goods_list_title ub ub-ac ub-pc">
    <div class="bg-color-f2 ulev-9 f-color-6 p-l-r3">猜你喜欢</div>
  </div>
  <?php endif; ?>
  <?php $_from = $this->_var['best']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'row');if (count($_from)):
    foreach ($_from AS $this->_var['row']):
?>
  <div class='ub goods_list_b'> 
  <?php $_from = $this->_var['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
    <?php echo $this->fetch('/library/goods.lib'); ?>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
	</div>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
  <?php if ($this->_var['is_full_page'] == 1): ?>
  </div>
  <?php endif; ?>
  <?php endif; ?>