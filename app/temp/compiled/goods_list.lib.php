<div class="top-div"></div>
<div></div>
<?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
<div class="goodlist goods" goods_id="<?php echo $this->_var['goods']['goods_id']; ?>">
	<div class="goods-img">
	<img src="<?php echo $this->_var['url']; ?><?php echo $this->_var['goods']['goods_thumb']; ?>"/>
	<?php if ($this->_var['goods']['exclusive'] == $this->_var['goods']['goods_price']): ?>
	<div class="phone-exclusive-goodslist ub ub-ac ub-pc">手机</br>专享</div>
	<?php endif; ?>
	</div>
	<div class="goods-con">
		<div class="goods-name f-color-zi"><?php echo $this->_var['goods']['goods_name']; ?></div>
		<div class="goods-other">
			<div class="ub-f1">
				<span class="f-color-red ulev1"><?php echo $this->_var['goods']['formatted_goods_price']; ?></span>
				<span class="ulev-1 sc-text-hui sc-text-tab">销量：<?php echo $this->_var['goods']['salenum']; ?></span>
			 </div>
		</div>
		<div class="ub ub-ae ub-pj m-top4 goods-number"> 
            <div class="ub uba border-hui uc-t1 uc-b1 ub-ac f-color-6 uinput1">
              <div class="ubr border-hui uinn1 minus disabled" id='minus_<?php echo $this->_var['goods']['goods_id']; ?>'>-</div>
              <input type="text" class="text-b1 ulev-1" value="1" id='goods_number_<?php echo $this->_var['goods']['goods_id']; ?>'/>
              <div class="ubl border-hui uinn1 plus" id='plus_<?php echo $this->_var['goods']['goods_id']; ?>'>+</div>
            </div>
           	 <div class="ub-pe add_to_cart">
				<div class="into-flow ub-img"></div>
			 </div>
          </div>
	</div>
</div>
<?php endforeach; else: ?>
<div class="clear1"></div>
<?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
