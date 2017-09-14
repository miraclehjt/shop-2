<?php $_from = $this->_var['item_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'value');if (count($_from)):
    foreach ($_from AS $this->_var['value']):
?>
<div class="sun-m1 ubb border-hui bg-color-w m-btm1 comment goods" goods_id="<?php echo $this->_var['value']['goods_id']; ?>" rec_id=<?php echo $this->_var['value']['rec_id']; ?> shaidan_id='<?php echo $this->_var['value']['shaidan_id']; ?>'>
  <div class="ub ubb border-faxian p-all5">
    <div class="mar-ar1 goods-img h-w-7"> 
      <?php if ($this->_var['value']['goods_id'] > 0 && $this->_var['value']['extension_code'] != 'package_buy'): ?> 
      <img src="<?php echo $this->_var['url']; ?><?php echo $this->_var['value']['thumb']; ?>"/> 
      <?php elseif ($this->_var['value']['goods_id'] > 0 && $this->_var['value']['extension_code'] == 'package_buy'): ?> 
      <img src="img/ico_cart_package.gif"/> 
      <?php endif; ?> 
    </div>
    <div class="ub ub-ver ub-f1">
      <div class="ulev-1 f-color-zi"> <?php echo $this->_var['value']['goods_name']; ?> </div>
      <div class="f-color-6 ulev-2 l-h-2 m-top2" supplier_id="<?php echo $this->_var['value']['supplier_id']; ?>}"> 商品来源：<?php echo $this->_var['value']['shopname']; ?> </div>
      <div class="ulev-2 sc-text-hui m-top2"> 购买时间：<?php echo $this->_var['value']['add_time_str']; ?></div>
    </div>
  </div>
  <div class="ub p-all1">
    <div class="ub-f1"></div>
    <div class="ub-pe ub ub-ac"> <?php if ($this->_var['value']['shaidan_points'] > 0): ?>
      <div class="ulev-1 f-color-6 mar-ar1">已获<?php echo $this->_var['value']['shaidan_points']; ?>积分</div>
      <?php endif; ?>
      <?php if ($this->_var['value']['comment_state'] == 0): ?>
      <?php if ($this->_var['value']['shipping_time_end'] > $this->_var['min_time']): ?>
      <div class="ulev-4 btn-red-2 add_comment_button" id="">发表评价</div>
      <?php else: ?>
      <div class="ulev-4 btn-gray-2 disabled">发表评价（已超期）</div>
      <?php endif; ?>
      <?php endif; ?>
      <?php if ($this->_var['value']['comment_state'] == 1): ?>
      <div class="ulev-4 btn-red-2 view_comment_button" id=''>已评价<?php if ($this->_var['value']['comment_status'] == 0): ?>（审核中）	<?php endif; ?></div>
      <?php endif; ?>
      
      <?php if ($this->_var['value']['shaidan_state'] == 0): ?>
      <?php if ($this->_var['value']['shipping_time_end'] > $this->_var['min_time']): ?>
      <div class="ulev-4 btn-red-2 m-l2 add_shaidan_button" id="">发表晒单</div>
      <?php else: ?>
      <div class="ulev-4 btn-gray-2 m-l2 disabled">发表晒单（已超期）</div>
      <?php endif; ?>
      <?php endif; ?>
      <?php if ($this->_var['value']['shaidan_state'] == 1): ?>
      <div class="ulev-4 btn-red-2 m-l2 view_shaidan_button" id=''>已晒单<?php if ($this->_var['value']['shaidan_status'] == 0): ?>（审核中）<?php endif; ?></div>
      <?php endif; ?> </div>
  </div>
</div>
<?php endforeach; else: ?>
<div class="ub ub-pc umar-t1 f-color-6">没有找到任何订单</div>
<?php endif; unset($_from); ?><?php $this->pop_vars();; ?>