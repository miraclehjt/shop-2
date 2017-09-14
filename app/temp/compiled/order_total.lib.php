	<?php if ($_SESSION['user_id'] > 0 && ( $this->_var['config']['use_integral'] || $this->_var['config']['use_bonus'] )): ?>
		<?php echo $this->_var['lang']['complete_acquisition']; ?>
		<?php if ($this->_var['config']['use_integral']): ?>
      <font class="f4_b"><?php echo $this->_var['total']['will_get_integral']; ?></font><?php echo $this->_var['points_name']; ?>
      <?php endif; ?>
      <?php if ($this->_var['config']['use_integral'] && $this->_var['config']['use_bonus']): ?>，<?php echo $this->_var['lang']['with_price']; ?>  <?php endif; ?>
      <?php if ($this->_var['config']['use_bonus']): ?>
       <font class="f4_b"><?php echo $this->_var['total']['will_get_bonus']; ?></font><?php echo $this->_var['lang']['de']; ?><?php echo $this->_var['lang']['bonus']; ?>。
      <?php endif; ?>  
	<?php endif; ?>
	<?php echo $this->_var['lang']['goods_all_price']; ?>: <font class="f4_b"><?php echo $this->_var['total']['goods_price_formated']; ?></font>
      <?php if ($this->_var['total']['discount'] > 0): ?>
      - <?php echo $this->_var['lang']['discount']; ?>: <font class="f4_b f-color-red"><?php echo $this->_var['total']['discount_formated']; ?></font>
      <?php endif; ?>
      <?php if ($this->_var['total']['tax'] > 0): ?>
      + <?php echo $this->_var['lang']['tax']; ?>: <font class="f4_b"><?php echo $this->_var['total']['tax_formated']; ?></font>
      <?php endif; ?>
      <?php if ($this->_var['total']['shipping_fee'] > 0): ?>
      + <?php echo $this->_var['lang']['shipping_fee']; ?>: <font class="f4_b"><?php echo $this->_var['total']['shipping_fee_formated']; ?></font>
      <?php endif; ?>
      <?php if ($this->_var['total']['shipping_insure'] > 0): ?>
      + <?php echo $this->_var['lang']['insure_fee']; ?>: <font class="f-color-red"><?php echo $this->_var['total']['shipping_insure_formated']; ?></font>
      <?php endif; ?>
      <?php if ($this->_var['total']['pay_fee'] > 0): ?>
      + <?php echo $this->_var['lang']['pay_fee']; ?>: <font class="f-color-red"><?php echo $this->_var['total']['pay_fee_formated']; ?></font>
      <?php endif; ?>
      <?php if ($this->_var['total']['pack_fee'] > 0): ?>
      + <?php echo $this->_var['lang']['pack_fee']; ?>: <font class="f-color-red"><?php echo $this->_var['total']['pack_fee_formated']; ?></font>
      <?php endif; ?>
      <?php if ($this->_var['total']['card_fee'] > 0): ?>
      + <?php echo $this->_var['lang']['card_fee']; ?>: <font class="f-color-red"><?php echo $this->_var['total']['card_fee_formated']; ?></font>
      <?php endif; ?> 
	  
	  <?php if ($this->_var['total']['surplus'] > 0 || $this->_var['total']['integral'] > 0 || $this->_var['total']['bonus'] > 0): ?>
	  <?php if ($this->_var['total']['surplus'] > 0): ?>
      - <?php echo $this->_var['lang']['use_surplus']; ?>: <font class="f-color-red"><?php echo $this->_var['total']['surplus_formated']; ?></font>
      <?php endif; ?>
      <?php if ($this->_var['total']['integral'] > 0): ?>
      - <?php echo $this->_var['lang']['use_integral']; ?>: <font class="f-color-red"><?php echo $this->_var['total']['integral_formated']; ?></font>
      <?php endif; ?>
      <?php if ($this->_var['total']['bonus'] > 0): ?>
      - <?php echo $this->_var['lang']['use_bonus']; ?>: <font class="f-color-red"><?php echo $this->_var['total']['bonus_formated']; ?></font>
      <?php endif; ?>
	  <?php endif; ?>
	  <input type='hidden' id='amount_formated' value='<?php echo $this->_var['total']['amount_formated']; ?>' />
  <?php if ($this->_var['is_group_buy']): ?><br />
  <?php echo $this->_var['lang']['notice_gb_order_amount']; ?><?php endif; ?>
  <?php if ($this->_var['total']['exchange_integral']): ?><br />
	<?php echo $this->_var['lang']['notice_eg_integral']; ?><font class="f-color-red"><?php echo $this->_var['total']['exchange_integral']; ?></font>
	<?php endif; ?>
    </div>