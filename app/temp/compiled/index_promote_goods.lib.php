<?php if ($this->_var['promote']): ?>
<div class="uof bg-color-w ubt ubb border-hui swiper-container index-goods">
  <div class="ub bc-text ub-ac" data-index="0">
    <div class="title-left bc-head1"></div>
    <div class="ub-f1 ub ub-ver ut-m line1 umar-l f-color-red ulev0">今日秒杀</div>
    <div class="tx-r sc-text ulev-1 umar-r " id='more_promotion'>更多 &gt;</div>
  </div>
  <div class="ub umar-t swiper-wrapper">
  <?php $_from = $this->_var['promote']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'row');$this->_foreach['promote_row'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['promote_row']['total'] > 0):
    foreach ($_from AS $this->_var['row']):
        $this->_foreach['promote_row']['iteration']++;
?>
    <div class='swiper-slide ub'>
	<?php $_from = $this->_var['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['promote_goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['promote_goods']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['promote_goods']['iteration']++;
?>
	<?php echo $this->fetch('/library/goods.lib'); ?>
	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	  </div>
	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	</div>
  <div class="swiper-pagination"></div>
</div>
<?php endif; ?>