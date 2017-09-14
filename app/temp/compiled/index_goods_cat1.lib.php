<?php if ($this->_var['goods_cat1']): ?>
<div class="uof p-t-b1">
  <div class="goods_list_title ub ub-ac ub-pc category" cat_id='<?php echo $this->_var['goods_cat1']['cat_id']; ?>'>
    <div class="bg-color-f2 ulev-9 f-color-6 p-l-r3"><?php echo $this->_var['goods_cat1']['cat_name']; ?></div>
    <div class="goods_more ub-img "></div>
  </div>
  <?php $_from = $this->_var['goods_cat1']['goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'row');if (count($_from)):
    foreach ($_from AS $this->_var['row']):
?>
  <div class='ub goods_list_b'> 
  <?php $_from = $this->_var['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
    <?php echo $this->fetch('/library/goods.lib'); ?>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> </div>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> </div>
<?php endif; ?>