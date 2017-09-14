<div class="order">

<div class="detail_top">
<div class="lan">
<dl>
<dt class="dingdan_1"></dt>
<dd><span><?php echo $this->_var['order']['pay_status']; ?>&nbsp;&nbsp;&nbsp;&nbsp;卖家<?php echo $this->_var['order']['shipping_status']; ?></span><br>
    <span class="dingdanhao"><?php echo $this->_var['lang']['detail_order_sn']; ?>&nbsp;:&nbsp;<?php echo $this->_var['lang']['colon']; ?><?php echo $this->_var['order']['order_sn']; ?></span><br>
    <span><?php if ($this->_var['order']['shipping_fee'] > 0): ?><?php echo $this->_var['lang']['shipping_fee']; ?><?php echo $this->_var['lang']['colon']; ?>&nbsp;:<?php echo $this->_var['order']['formated_shipping_fee']; ?><?php endif; ?></span>
</dd>
</dl>
</div>

<?php if ($this->_var['order']['order_amount'] > 0): ?>
<?php if ($this->_var['order']['order_status'] == '已取消'): ?>
<dl style="border-bottom:1px solid #eeeeee">
<dt style=" position:absolute;" class="dingdan_2"></dt>
<dd style=" margin-left:30px;"><span class="zhif">订单状态：已取消</span>
<span class="zhif">订单已取消，不能继续支付</span>
 </dd>
</dl>

<?php else: ?>
<dl style="border-bottom:1px solid #eeeeee">
<dt style=" position:absolute;" class="dingdan_2"></dt>
<dd style=" margin-left:30px;"><span class="zhif"><?php echo $this->_var['lang']['select_payment']; ?>&nbsp;:&nbsp;<?php echo $this->_var['lang']['colon']; ?><?php echo $this->_var['order']['pay_name']; ?></span>
	<span class="zhif"><?php echo $this->_var['lang']['order_amount']; ?>&nbsp;:&nbsp;<?php echo $this->_var['lang']['colon']; ?><?php echo $this->_var['order']['formated_order_amount']; ?></span>
	<span class="zhif"><?php echo $this->_var['order']['pay_desc']; ?></span>
    <!--
	<?php if ($this->_var['payment_list']): ?>
		<div class="other_payment">
        <?php echo $this->_var['lang']['change_payment']; ?><?php echo $this->_var['lang']['colon']; ?>
			<form name="payment" method="post" action="user.php">
			
				<select name="pay_id">
				<?php $_from = $this->_var['payment_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'payment');if (count($_from)):
    foreach ($_from AS $this->_var['payment']):
?>
				<option value="<?php echo $this->_var['payment']['pay_id']; ?>">
				<?php echo $this->_var['payment']['pay_name']; ?>(<?php echo $this->_var['lang']['pay_fee']; ?>:<?php echo $this->_var['payment']['format_pay_fee']; ?>)
				</option>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				</select>
				<input type="submit" value="<?php echo $this->_var['lang']['button_submit']; ?>" style="margin-top:30px;width:40%;"/>
				<input type="hidden" name="act" value="act_edit_payment">
				<input type="hidden" name="order_id" value="<?php echo $this->_var['order']['order_id']; ?>">
			</form>
		</div> 
		<?php endif; ?>
      -->

	<?php if ($this->_var['iswei']): ?>
		<?php if ($this->_var['order']['pay_name'] == "微信手机支付"): ?>
			<style>
				.pay-btn a {
					color: #FFF;
				}
				.sub-btn {
					display: block;
					width: 100%;
					display: block;
					border-radius: 5px;
					background-color: #f60;
					text-align: center;
					height: 40px;
					line-height: 40px;
					color: #FFF;
					font-size: 14px;
					border: none;
					font-family: '微软雅黑';
				}
			</style>
			<?php echo $this->_var['pay_online']; ?>
		<?php elseif ($this->_var['order']['pay_name'] == "支付宝"): ?>
			<a href="././pay/alipayapi.php?out_trade_no=<?php echo $this->_var['order']['order_sn']; ?>&total_fee=<?php echo $this->_var['order']['order_amount']; ?>" class="zhifu" style=" color:#fff; font-size:16px;">去支付宝支付</a>
		<?php endif; ?>
	<?php else: ?>
		<a href="././pay/alipayapi.php?out_trade_no=<?php echo $this->_var['order']['order_sn']; ?>&total_fee=<?php echo $this->_var['order']['order_amount']; ?>" class="zhifu" style=" color:#fff; font-size:16px;">去支付宝支付</a>
	<?php endif; ?>
     
</dd>
</dl>
<?php endif; ?>
<?php endif; ?>

<dl>
<dt class="dingdan_3"></dt>
<dd><h3><?php echo $this->_var['lang']['consignee_name']; ?>&nbsp;:<?php echo $this->_var['lang']['colon']; ?>&nbsp;<?php echo $this->_var['order']['consignee']; ?><em><?php echo $this->_var['order']['mobile']; ?></em></h3>
<?php if ($this->_var['order']['exist_real_goods']): ?>
<div class="adss">
<?php echo $this->_var['lang']['detailed_address']; ?><?php echo $this->_var['lang']['colon']; ?>&nbsp;:&nbsp;<?php echo $this->_var['order']['address']; ?><?php if ($this->_var['order']['zipcode']): ?>[<?php echo $this->_var['lang']['postalcode']; ?><?php echo $this->_var['lang']['colon']; ?><?php echo $this->_var['order']['zipcode']; ?>]<?php endif; ?>
</div>
<?php endif; ?>
		</dd>
</dl>

<?php if ($this->_var['order']['order_status'] != '已取消'): ?>
<dl style="border-top:1px solid #eeeeee; margin-top:10px; height:70px; padding-bottom:0px;">
<dt class="dingdan_4"><img src="themesmobile/68ecshopcom_mobile/images/wuliuimg.png" width="30" height="70"></dt>
<dd><h3>物流信息<?php echo $this->_var['order']['order_status']; ?></h3>
<?php if ($this->_var['kuaidi']): ?>
<p style=" overflow:hidden; display:block; width:100%; height:20px;"><?php echo $this->_var['kuaidi']['context']; ?></p>
<strong><?php if ($this->_var['kuaidi']['ftime']): ?><?php echo $this->_var['kuaidi']['ftime']; ?><?php else: ?><?php echo $this->_var['kuaidi']['time']; ?><?php endif; ?></strong>
<?php else: ?>
<p>没有数据</p>
<?php endif; ?>
</dd>
</dl>
<?php endif; ?>
</div>

<div class="ord_list1">
<h2><img src="themesmobile/68ecshopcom_mobile/images/dianpu.png"><?php echo $this->_var['order']['referer']; ?></h2>
<?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['goods_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods_list']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['goods_list']['iteration']++;
?>
<div class="order_list">
        <a href="goods.php?id=<?php echo $this->_var['goods']['goods_id']; ?>">
          <dl>
          <dt><img src="./../<?php echo $this->_var['goods']['goods_thumb']; ?>"></dt>
          <dd class="name" class="pice" style=" width:55%;"><strong><?php echo sub_str($this->_var['goods']['goods_name'],20); ?></strong><span><?php if ($this->_var['goods']['goods_attr']): ?><?php echo $this->_var['goods']['goods_attr']; ?><?php endif; ?>
								<?php if ($this->_var['goods']['is_shipping']): ?><em class="carriage_free"><?php echo $this->_var['lang']['carriage_free']; ?></em><?php endif; ?>
								<?php if ($this->_var['goods']['parent_id'] > 0): ?><em class="accessories"><?php echo $this->_var['lang']['accessories']; ?></em><?php endif; ?>
								<?php if ($this->_var['goods']['is_gift'] > 0): ?><em class="largess"><?php echo $this->_var['lang']['largess']; ?></em><?php endif; ?></span></dd>
          <dd class="pice" style=" font-size:13px; color:#F60; width:25%;"><?php echo $this->_var['goods']['goods_price']; ?><em>x<?php echo $this->_var['goods']['goods_number']; ?></em></dd>
          </dl>
          </a>
          <div class="pic" style=" border:0;"><span>小计：</span><strong><?php echo $this->_var['goods']['subtotal']; ?></strong></div>
          
         </div>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>


<div class="jiage">
						<p><?php echo $this->_var['lang']['goods_all_price']; ?>
						<?php if ($this->_var['order']['extension_code'] == "group_buy"): ?><?php echo $this->_var['lang']['gb_deposit']; ?><?php endif; ?><?php echo $this->_var['lang']['colon']; ?>&nbsp;:&nbsp;<span class="price"><?php echo $this->_var['order']['formated_goods_amount']; ?></span>
                        <?php if ($this->_var['order']['discount'] > 0): ?><br>
						- <?php echo $this->_var['lang']['discount']; ?><?php echo $this->_var['lang']['colon']; ?>&nbsp;:&nbsp;<span class="price"><?php echo $this->_var['order']['formated_discount']; ?></span>
						<?php endif; ?>
						<?php if ($this->_var['order']['tax'] > 0): ?><br>
						+ <?php echo $this->_var['lang']['tax']; ?><?php echo $this->_var['lang']['colon']; ?>&nbsp;:&nbsp;<span class="price"><?php echo $this->_var['order']['formated_tax']; ?></span>
						<?php endif; ?>
						<?php if ($this->_var['order']['shipping_fee'] > 0): ?><br>
						+ <?php echo $this->_var['lang']['shipping_fee']; ?><?php echo $this->_var['lang']['colon']; ?>&nbsp;:&nbsp;<span class="price"><?php echo $this->_var['order']['formated_shipping_fee']; ?></span>
						<?php endif; ?>
						<?php if ($this->_var['order']['insure_fee'] > 0): ?><br>
						+ <?php echo $this->_var['lang']['insure_fee']; ?><?php echo $this->_var['lang']['colon']; ?>&nbsp;:&nbsp;<span class="price"><?php echo $this->_var['order']['formated_insure_fee']; ?></span>
						<?php endif; ?>
						<?php if ($this->_var['order']['pay_fee'] > 0): ?><br>
						+ <?php echo $this->_var['lang']['pay_fee']; ?><?php echo $this->_var['lang']['colon']; ?>&nbsp;:&nbsp;<span class="price"><?php echo $this->_var['order']['formated_pay_fee']; ?></span>
						<?php endif; ?>
						<?php if ($this->_var['order']['pack_fee'] > 0): ?><br>
						+ <?php echo $this->_var['lang']['pack_fee']; ?><?php echo $this->_var['lang']['colon']; ?>&nbsp;:&nbsp;<span class="price"><?php echo $this->_var['order']['formated_pack_fee']; ?></span>
						<?php endif; ?>
						<?php if ($this->_var['order']['card_fee'] > 0): ?><br>
						+ <?php echo $this->_var['lang']['card_fee']; ?><?php echo $this->_var['lang']['colon']; ?>&nbsp;:&nbsp;<span class="price"><?php echo $this->_var['order']['formated_card_fee']; ?></span>
						<?php endif; ?>
						<?php if ($this->_var['order']['money_paid'] > 0): ?><br> - <?php echo $this->_var['lang']['order_money_paid']; ?><?php echo $this->_var['lang']['colon']; ?>&nbsp;:&nbsp;<span class="price"><?php echo $this->_var['order']['formated_money_paid']; ?></span><?php endif; ?>
						<?php if ($this->_var['order']['surplus'] > 0): ?><br> - <?php echo $this->_var['lang']['use_surplus']; ?><?php echo $this->_var['lang']['colon']; ?>&nbsp;:&nbsp;<span class="price"><?php echo $this->_var['order']['formated_surplus']; ?></span><?php endif; ?>
						<?php if ($this->_var['order']['integral_money'] > 0): ?><br> - <?php echo $this->_var['lang']['use_integral']; ?><?php echo $this->_var['lang']['colon']; ?>&nbsp;:&nbsp;<span class="price"><?php echo $this->_var['order']['formated_integral_money']; ?></span><?php endif; ?>
						<?php if ($this->_var['order']['bonus'] > 0): ?><br> - <?php echo $this->_var['lang']['use_bonus']; ?><?php echo $this->_var['lang']['colon']; ?>&nbsp;:&nbsp;<span class="price"><?php echo $this->_var['order']['formated_bonus']; ?></span><?php endif; ?></p>
						<p><?php echo $this->_var['lang']['order_amount']; ?><?php echo $this->_var['lang']['colon']; ?>&nbsp;:&nbsp;<span class="price1"><?php echo $this->_var['order']['formated_order_amount']; ?></span><?php if ($this->_var['order']['extension_code'] == "group_buy"): ?><?php echo $this->_var['lang']['notice_gb_order_amount']; ?><?php endif; ?></p>
						
					</div>
</div>
  
<section class="qita">
    <div class="navContent"> 
    <ul>
<?php if ($this->_var['order']['shipping_id'] > 0): ?><li class="first"><?php echo $this->_var['lang']['shipping']; ?><?php echo $this->_var['lang']['colon']; ?>&nbsp;:&nbsp;<?php echo $this->_var['order']['shipping_name']; ?></li><?php endif; ?>
			<?php if ($this->_var['order']['pay_name']): ?><li<?php if ($this->_var['order']['shipping_id'] <= 0): ?> class="first"<?php endif; ?>><?php echo $this->_var['lang']['payment']; ?><?php echo $this->_var['lang']['colon']; ?>&nbsp;:&nbsp;<?php echo $this->_var['order']['pay_name']; ?></li><?php endif; ?>
			<?php if ($this->_var['order']['pack_name']): ?><li><?php echo $this->_var['lang']['use_pack']; ?><?php echo $this->_var['lang']['colon']; ?>&nbsp;:&nbsp;<?php echo $this->_var['order']['pack_name']; ?></li><?php endif; ?>
			<?php if ($this->_var['order']['card_name']): ?><li><?php echo $this->_var['lang']['use_card']; ?><?php echo $this->_var['lang']['colon']; ?>&nbsp;:&nbsp;<?php echo $this->_var['order']['card_name']; ?></li><?php endif; ?>
			<?php if ($this->_var['order']['card_message']): ?><li><?php echo $this->_var['lang']['bless_note']; ?><?php echo $this->_var['lang']['colon']; ?>&nbsp;:&nbsp;<?php echo $this->_var['order']['card_message']; ?></li><?php endif; ?>
			<?php if ($this->_var['order']['integral'] > 0): ?><li><?php echo $this->_var['lang']['use_integral']; ?><?php echo $this->_var['lang']['colon']; ?>&nbsp;:&nbsp;<?php echo $this->_var['order']['integral']; ?></li><?php endif; ?>
			<?php if ($this->_var['order']['inv_payee'] && $this->_var['order']['inv_content']): ?>
				<li><?php echo $this->_var['lang']['invoice_title']; ?><?php echo $this->_var['lang']['colon']; ?>&nbsp;:&nbsp;<?php echo $this->_var['order']['inv_payee']; ?></li>
				<li><?php echo $this->_var['lang']['invoice_content']; ?><?php echo $this->_var['lang']['colon']; ?>&nbsp;:&nbsp;<?php echo $this->_var['order']['inv_content']; ?></li>
			<?php endif; ?>
			<?php if ($this->_var['order']['postscript']): ?><li><?php echo $this->_var['lang']['order_postscript']; ?><?php echo $this->_var['lang']['colon']; ?>&nbsp;:&nbsp;<?php echo $this->_var['order']['postscript']; ?></li><?php endif; ?>
			<?php if ($this->_var['order']['how_oos_name']): ?><li><?php echo $this->_var['lang']['booking_process']; ?><?php echo $this->_var['lang']['colon']; ?>&nbsp;:&nbsp;<?php echo $this->_var['order']['how_oos_name']; ?></li><?php endif; ?>
            </ul>
       </div>      
</section>

<div style=" height:50px;"></div> 

<?php if ($this->_var['order']['order_status'] != '已取消'): ?>
<div class="detail_dowm">
<div class="anniu1">
          <a href="kuaidi_list.php?order_id=<?php echo $this->_var['order']['order_id']; ?>" class="on_comment">查看物流</a>
                  <?php if ($this->_var['item']['shipping_status'] == 2): ?> 
                  <?php if ($this->_var['item']['comment_s'] == 0): ?> 
                  <?php else: ?> 
                  <a href="user.php?act=my_comment&s=<?php echo $this->_var['item']['comment_s']; ?>&order_id=<?php echo $this->_var['item']['order_id']; ?>#commtr_<?php echo $this->_var['item']['comment_s']; ?>" class="on_comment">评价订单</a> 
                  <?php endif; ?>
                  
                  <?php if ($this->_var['item']['shaidan_s'] == 0): ?> 
                  <?php else: ?> 
                  <a href="user.php?act=shaidan_send&id=<?php echo $this->_var['item']['shaidan_s']; ?>" class="on_comment">晒单</a> 
                  <?php endif; ?>
                  
                  <?php endif; ?><?php echo $this->_var['item']['handler']; ?>
          </div> 
 </div>
<?php endif; ?>

 
</div>