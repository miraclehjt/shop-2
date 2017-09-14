<?php if ($this->_var['hot']): ?> 
<div class="uof bg-color-w ubt ubb border-hui  swiper-container index-goods">
  <div class="ub bc-text ub-ac" data-index="0">
    <div class="title-left bc-grey1"></div>
    <div class="ub-f1 ub ub-ver ut-m line1 umar-l bc-text ulev0">热卖商品</div>
    <div class="tx-r sc-text ulev-1 umar-r goods_list" goods_type='is_hot'>更多 &gt;</div>
  </div>
  <div class="ub umar-t swiper-wrapper goods-padding"> <?php $_from = $this->_var['hot']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'row');if (count($_from)):
    foreach ($_from AS $this->_var['row']):
?>
    <div class='swiper-slide ub'> <?php $_from = $this->_var['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
	<?php echo $this->fetch('/library/goods.lib'); ?>
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> </div>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> </div>
  <div class="swiper-pagination"></div>
</div>
<?php endif; ?>