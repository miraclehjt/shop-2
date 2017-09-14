<ul class="bg-color-w lis m-btm1">
  <li class="ub ub-ac">
    <div class="ub-img" style="background-image:url(img/icons/order-list.png);width:1em; height:1em;"></div>
    <div class="ub-f1 ub f-color-zi ulev-9 p-l-r5">物流信息</div>
  </li>
  <div class="ulev-1 sc-text-hui">
    <div class="m-btm5">运单号：<?php echo $this->_var['invoice_no']; ?></div>
    <div class="m-btm5">信息来源：<?php echo $this->_var['shipping_name']; ?></div>
  </div>
</ul>
<div class="bg-color-w logistics" style="background-image:none"> <?php $_from = $this->_var['express_info']['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');$this->_foreach['express_data'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['express_data']['total'] > 0):
    foreach ($_from AS $this->_var['item']):
        $this->_foreach['express_data']['iteration']++;
?>
  <div class="ub ub-ver ubl border-hui m-l-r1" style="position:relative; padding-bottom:1em; width:100%;">
    <div class="photo-wh1 <?php if (($this->_foreach['express_data']['iteration'] <= 1)): ?>photo<?php else: ?>photo1<?php endif; ?> ub-img"></div>
    <div class="ulev-9 <?php if (($this->_foreach['express_data']['iteration'] <= 1)): ?>express-color<?php else: ?>f-color-6<?php endif; ?>" style="margin-left:1em; margin-right:1em;"><?php echo $this->_var['item']['context']; ?></div>
    <div class="ulev-1 ubb border-hui m-all3 <?php if (($this->_foreach['express_data']['iteration'] <= 1)): ?>express-color<?php else: ?>f-color-6<?php endif; ?>"" style="padding-bottom:1em"><?php echo $this->_var['item']['ftime']; ?></div>
  </div>
  <?php endforeach; else: ?>
  <div class="ub ub-pc umar-t1 f-color-6 p-t-b6">找不到物流信息</div>
  <?php endif; unset($_from); ?><?php $this->pop_vars();; ?> </div>
