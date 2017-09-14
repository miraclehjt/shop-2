<?php if ($this->_var['goods_list']): ?> 

<div class="ub ub-ver m-btm1 p-b3"> <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'cartgoods');$this->_foreach['shop_goods_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['shop_goods_list']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['cartgoods']):
        $this->_foreach['shop_goods_list']['iteration']++;
?>
  <div class="m-btm1">
    <div class="bg-color-w p-all3 ub bc-text ub-ac ubb border-faxian">
      <div class="ub ub-ac ub-f1">
          <div class="_checkbox checkbox_normal checked" id="checkbox_0_<?php echo $this->_var['key']; ?>" parent_id="checkbox_0" checked=true></div>
        <div class="h-w-1 ub-img m-l1" style="background-image:url(img/icons/store-enter.png)"></div>
        <div class="f-color-zi ulev-9 ub-f1 m-l2 ub ut-m"><?php echo $this->_var['cartgoods']['supplier_name']; ?></div>
      </div>
      <?php if ($this->_var['cartgoods']['favourable']): ?>
      <div class="ub-pe choose_gift" suppid="<?php echo $this->_var['key']; ?>"> <font class="ulev-1 sc-text-hui btn-w1">选择赠品</font> </div>
      <?php endif; ?> 
    </div>
    <div class="bg-color-w"> <?php $_from = $this->_var['cartgoods']['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['goods_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods_list']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['goods_list']['iteration']++;
?>
      <div class="p-all2 ub bc-grey cart-box" style="position:relative">
        <div class="ub ub-ac">
          <div value="<?php echo $this->_var['goods']['rec_id']; ?>" class="_checkbox checkbox_normal checked" name="goods" id="checkbox_0_<?php echo $this->_var['key']; ?>_<?php echo $this->_var['goods']['rec_id']; ?>" parent_id="checkbox_0_<?php echo $this->_var['key']; ?>" checked=true></div>
        </div>
        <div class="mar-ar1 ub-img h-w-4 m-l1 goods" goods_id="<?php echo $this->_var['goods']['goods_id']; ?>">
		<img class="goods-img" style="width:100%;height:100%;" src="<?php echo $this->_var['url']; ?><?php echo $this->_var['goods']['goods_thumb']; ?>" />
		</div>
        <div class="ub-f1 ub ub-ver">
          <div class="ub ub-f1">
            <div class="ub-f1 p-r1">
              <div class="bc-text ulev-1 f-color-zi l-h-1"><?php echo $this->_var['goods']['goods_name']; ?> </div>
              <div class="ulev-2 sc-text-hui"><?php echo nl2br($this->_var['goods']['goods_attr']); ?></div>
            </div>
            <div class="ub-pe tx-r ulev-1 f-color-red" id='goods_subtotal_<?php echo $this->_var['goods']['rec_id']; ?>'><?php echo $this->_var['goods']['subtotal']; ?> 
              <?php if ($this->_var['goods']['is_gift'] > 0): ?>
              <div class="ulev-9 f-color-red"><?php echo $this->_var['lang']['largess']; ?> </div>
              <?php endif; ?> 
            </div>
          </div>
          <div class="ub ub-ae m-top4"> 
            <?php if ($this->_var['goods']['goods_id'] > 0 && $this->_var['goods']['is_gift'] == 0 && $this->_var['goods']['parent_id'] == 0): ?>
            <div class="ub uba border-hui uc-t1 uc-b1 ub-ac f-color-6 uinput1">
              <div class="ubr border-hui uinn1 reduce_goods_button" rec_id='<?php echo $this->_var['goods']['rec_id']; ?>'>-</div>
              <input type="text" class="text-b1 ulev-1 input_number" value="<?php echo $this->_var['goods']['goods_number']; ?>" id='number_<?php echo $this->_var['goods']['rec_id']; ?>' rec_id='<?php echo $this->_var['goods']['rec_id']; ?>' supplier_id='<?php echo $this->_var['key']; ?>' package_buy="<?php if ($this->_var['goods']['extension_code'] == 'package_buy'): ?>1<?php else: ?>0<?php endif; ?>" goods_id='<?php echo $this->_var['goods']['goods_id']; ?>'/>
              <div class="ubl border-hui uinn1 increase_goods_button" rec_id='<?php echo $this->_var['goods']['rec_id']; ?>'>+</div>
            </div>
            <?php else: ?>
            <div class="ulev-1 f-color-6">数量：<?php echo $this->_var['goods']['goods_number']; ?> </div>
            <?php endif; ?>
            <div class="ub-pe ub-img h-w-5 search-icon2 cart-del cart_delete_button" rec_id='<?php echo $this->_var['goods']['rec_id']; ?>'></div>
          </div>
        </div>
      </div>
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> </div>
    
    <?php if ($this->_var['cartgoods']['favourable'] || $this->_var['cartgoods']['discount']): ?> 
    <?php if ($this->_var['cartgoods']['discount']): ?>
    <div class="ulev-1 bg-color-w sc-text-hui p-all1 tx-r activity" id="zk_<?php echo $this->_var['key']; ?>"><?php echo $this->_var['cartgoods']['discount']['your_discount']; ?></div>
    <?php endif; ?> 
    <?php endif; ?> 
  </div>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> </div>
<div class="ub ub-ac bg-color-w p-fixed-btm1 ubt border-hui yy-top">
  <div class="_checkbox checkbox_normal checked" id='checkbox_0' checked=true></div>
  <div class="ulev-1 f-color-6 m-l2">全选</div>
  <div class="ub-f1 ub-pe tx-r ub p-r1"> <span class="ulev-9 f-color-6">合计：</span><span class="ufm1 ulev-1 f-color-red" id='cart_amount_desc'><?php echo $this->_var['shopping_money']; ?></span></div>
  <div class="ub jiesuan bc-head1 ub-ac ub-pc" id='checkout_button'>
    <div>结算</div>
  </div>
</div>
<div class="btm-up mfp-hide" id="goods_gift_box"></div>
<?php else: ?>
	<?php if ($this->_var['login']): ?> 

<div class="m-top8">
  <div class="ub ub-ac ub-pc">
    <div class="cart-empty"></div>
  </div>
  <div class="ub ub-ac ub-pc f-color-6 ulev-9 umar-t1">购物车中暂无商品！</div>
</div>
<?php else: ?> 

<div class="m-top8">
  <div class="ub ub-ac ub-pc">
    <div class="cart-empty"></div>
  </div>
  <div class="ub ub-ac ub-pc f-color-6 ulev-9 umar-t1">您还没登录哦！请先登录</div>
  <div class="ub ub-ac ub-pc umar-t1 _login" id='login_button'>
    <div class="btn-red-1 ulev-9 w-min3"> 登录 </div>
  </div>
</div>
<?php endif; ?>
<?php endif; ?> 