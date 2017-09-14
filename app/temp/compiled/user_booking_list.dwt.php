<?php $_from = $this->_var['booking_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
<div class="bg-color-w m-btm1">
  <div class="ubb ub border-faxian bc-text ub-ac p-all5">
    <div class="f-color-6 ulev-1 ub-f1"><?php echo $this->_var['lang']['booking_time']; ?>：<?php echo $this->_var['item']['booking_time']; ?></div>
    <div class="ub ub-pe ub-ac delete" rec_id='<?php echo $this->_var['item']['rec_id']; ?>'>
      <div class="ub-img search-icon2 h-w-5"></div>
    </div>
  </div>
  <div class="ub p-all5 bc-grey goods" goods_id="<?php echo $this->_var['item']['goods_id']; ?>">
    <div class="goods-img h-w-7"><img src="<?php echo $this->_var['url']; ?><?php echo $this->_var['item']['goods_thumb']; ?>"/></div>
    <div class="ub-f1 ub ub-ver m-l1 goods-img">
      <div class="f-color-zi ulev-1"><?php echo $this->_var['item']['goods_name']; ?></div>
      <div class="ulev-2 uinn3 sc-text-hui m-top2"><?php echo $this->_var['lang']['booking_store_name']; ?>：<?php echo $this->_var['item']['supplier_name']; ?></div>
      <div class="ulev-2 uinn3 sc-text-hui"><?php echo $this->_var['lang']['process_desc']; ?>：<?php echo $this->_var['item']['dispose_note']; ?></div>
    </div>
  </div>
  <div class="p-all1 tx-r ubt border-faxian"> <span class="ulev-1 f-color-6">订购数量：</span><span class="ulev-1 f-color-red"><?php echo $this->_var['item']['goods_number']; ?></span> </div>
</div>
<?php endforeach; else: ?>
<div class="ub ub-pc umar-t1 f-color-6">没有登记任何商品</div>
<?php endif; unset($_from); ?><?php $this->pop_vars();; ?>