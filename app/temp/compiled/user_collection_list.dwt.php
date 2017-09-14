<?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
<div class="ub bg-color-w m-btm1 p-all3 ubb border-hui goods" goods_id='<?php echo $this->_var['goods']['goods_id']; ?>' rec_id="<?php echo $this->_var['goods']['rec_id']; ?>">
  <div class="h-w-9 goods-img"><img src="<?php echo $this->_var['url']; ?><?php echo $this->_var['goods']['thumb']; ?>"/></div>
  <div class="ub-ver ub-f1 m-l1">
    <div class="f-color-zi text-change"> 
      <?php if ($this->_var['goods']['is_pre_sale'] == 1): ?> 
      【<span style="color: red;"><?php echo $this->_var['lang']['label_pre_sale']; ?></span>】
      <?php endif; ?> 
      <font class="ulev-1 goods-img"><?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?></font></div>
    <div class="ub ub-ac ubb border-faxian p-t-b4">
      <div class="ulev-0 f-color-red ub-f1"> 
        <?php if ($this->_var['goods']['promote_price'] != ""): ?> 
        <?php echo $this->_var['goods']['promote_price']; ?> 
        <?php else: ?> 
        <?php echo $this->_var['goods']['shop_price']; ?> 
        <?php endif; ?> 
      </div>
      <div class="ub-pe ub ub-ac attention sc-text-hui" is_attention="<?php echo $this->_var['goods']['is_attention']; ?>">
        <div class="ub-img <?php if ($this->_var['goods']['is_attention']): ?>like-icon-on<?php else: ?>like-icon<?php endif; ?> h-w-1"></div>
        <div class="ulev-1 m-l3"> 
          <?php if ($this->_var['goods']['is_attention']): ?> 
          <?php echo $this->_var['lang']['no_attention']; ?> 
          <?php else: ?> 
          <?php echo $this->_var['lang']['attention']; ?> 
          <?php endif; ?>  
          </div>  
      </div>
    </div>
    <div class="ub m-top1 sc-text-hui ub-pj">
	<?php if ($this->_var['goods']['is_pre_sale'] != 1): ?>
      <div class="ub-f1 ub ub-ac add_to_cart">
        <div class="ub-img cart-add h-w-1"></div>
        <div class="ulev-1 m-l3"> 
          <?php echo $this->_var['lang']['add_to_cart']; ?> 
        </div>
      </div>
	  <?php endif; ?>
      
      <div class="ub-pe ub ub-ac delete">
        <div class="ub-img search-icon2 h-w-1"></div>
        <div class="ulev-1 m-l3"><?php echo $this->_var['lang']['drop']; ?></div>
      </div>
    </div>
  </div>
</div>
<?php endforeach; else: ?>
<div class="ub ub-pc umar-t1 f-color-6">没有收藏任何商品</div>
<?php endif; unset($_from); ?><?php $this->pop_vars();; ?>