<?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('supplier_id', 'supplier');if (count($_from)):
    foreach ($_from AS $this->_var['supplier_id'] => $this->_var['supplier']):
?>
<?php if ($this->_var['supplier']['goods_list']): ?>
<div class="m-btm1">
  <div class="bg-color-w ub lis ub-ac ubb border-hui <?php if ($this->_var['supplier_id'] > 0): ?>supplier<?php endif; ?>" <?php if ($this->_var['supplier_id'] > 0): ?>supplier_id='<?php echo $this->_var['supplier_id']; ?>'<?php endif; ?>>
    <div class="ub-img" style="background-image:url(img/icons/store-enter.png); width:1.1em; height:1.1em;"></div>
    <div class="f-color-zi ub-f1 ub ut-m ulev-9 p-l-r5"><?php echo $this->_var['supplier']['shop_name']; ?></div>
    <?php if ($this->_var['supplier_id'] > 0): ?>
    <div class='fa fa-angle-right'></div>
    <?php endif; ?> </div>
  <?php $_from = $this->_var['supplier']['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('goods_id', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods_id'] => $this->_var['goods']):
?>
  <div class="ub bg-color-w p-t-b7 ubb border-faxian goods" goods_id='<?php echo $this->_var['goods_id']; ?>'>
    <div class="goods-img"><img src="<?php echo $this->_var['url']; ?><?php echo $this->_var['goods']['goods_thumb']; ?>" style="width:4.5em; height:auto"/> </div>
    <div class="ub-ver ub-f1 m-l1">
      <div class="f-color-6 text-change"> <font class="ulev-1"><?php echo $this->_var['goods']['goods_name']; ?></font> </div>
      <div class="ulev0 p-t-b4 f-color-red"><?php echo $this->_var['goods']['goods_price']; ?></div>
    </div>
  </div>
</div>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
<?php endif; ?>
<?php endforeach; else: ?>
<div class="ub ub-pc umar-t1 f-color-6">找不到任何商品</div>
<?php endif; unset($_from); ?><?php $this->pop_vars();; ?> 