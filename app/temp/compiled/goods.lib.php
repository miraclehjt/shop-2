<?php if ($this->_var['goods']['goods_id'] > 0): ?>
  <div class="ub ub-f1 ub-ver p-w0 goods bg-color-w shop-goods goods_radius" goods_id="<?php echo $this->_var['goods']['goods_id']; ?>">
	<div class="ub-f1 mar-ar1 ub-fh goods-img pos_re">
		<img src="<?php echo $this->_var['url']; ?><?php echo $this->_var['goods']['goods_thumb']; ?>"/>
		<?php if ($this->_var['goods']['exclusive'] == $this->_var['goods']['goods_price']): ?>
		<div class="phone-exclusive ub ub-ac ub-pc">手机专享</div>
		<?php endif; ?>
		<?php if ($this->_var['goods']['promote_end_date'] > 0): ?>
		<div class="pro-time ulev-2 settime" endTime='<?php echo $this->_var['goods']['promote_end_date']; ?>'></div>
		<?php endif; ?>
	</div>
	<div class="ut-m bc-text ulev-4 l-h-pic tx-l f-color-6 p-b1 m-top3 i-p-lr goods-name"><?php echo $this->_var['goods']['goods_name']; ?></div>
	<div class="ub ub-ac ut-s sc-text umar-t p-t1 ubt border-hui i-p-lr">
	  <div class="ub-f1 f-color-red ulev-9"><?php echo $this->_var['goods']['formatted_goods_price']; ?></div>
	  <div class="ub-pe into-flow ub-img add_to_cart"></div>
	</div>
  </div>
<?php else: ?>
  <div class="ub ub-f1 ub-ver mar-ar1 p-w0">&nbsp
  </div>
<?php endif; ?>