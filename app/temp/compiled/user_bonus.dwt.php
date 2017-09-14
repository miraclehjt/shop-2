<?php if ($this->_var['is_full_page'] == 1): ?>
<div class="red-pag ub ub-pc ub-ac p-all5 ubb border-hui bg-color-w">
  <input id="bonus_sn" placeholder="请输入红包序列号" type="text" class="uba border-hui uc-a1 ulev-1 red-pag-text sc-text-hui">
  <div id='confirm_button' class="red-pag-btn bc-head1 ulev-1 bc-text-head uc-a1">添加红包</div>
</div>
<?php endif; ?>
<?php $_from = $this->_var['bonus']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'hong');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['hong']):
        $this->_foreach['name']['iteration']++;
?>
<div class="red-content ub ub-pc"> 
  <div class="red-con1"></div>
  <div class="ub ub-f1">
    <div class="ub-f1 f-color-zi p-all3 bg-color-w">
      <div class="ulev-1 m-btm2">红包序列号：<?php echo empty($this->_var['hong']['bonus_sn']) ? 'N/A' : $this->_var['hong']['bonus_sn']; ?></div>
      <div class="ulev-1">发行店铺：<?php if ($this->_var['hong']['supplier_id'] == "自营商"): ?><?php echo $this->_var['hong']['supplier_id']; ?><?php else: ?><?php echo $this->_var['hong']['supplier_id']; ?><?php endif; ?></div>
      <div class="m-btm3 ulev-1 sc-text-hui">使用条件：满<?php echo $this->_var['hong']['min_goods_amount']; ?></div>
      <div class="ulev-1 sc-text-hui">有效时间：截至<?php echo $this->_var['hong']['use_enddate']; ?></div>
    </div>
    <div class="ub ub-ac ub-pc red-con3 ub-ver">
      <div class="ulev2 <?php if ($this->_var['hong']['order_id'] || $this->_var['hong']['status'] == $this->_var['lang']['overdue']): ?> f-color-6 <?php else: ?> f-color-red <?php endif; ?>"><?php echo $this->_var['hong']['type_money']; ?></div>
       
      <?php if ($this->_var['hong']['order_id']): ?>
	  <div class="umar-t1 ulev-9 f-color-6 order" order_id="<?php echo $this->_var['hong']['order_id']; ?>"><?php echo $this->_var['lang']['had_use']; ?></div>
      <?php else: ?>
	  <div class="umar-t1 ulev-9 f-color-6"><?php echo $this->_var['hong']['status']; ?></div>
	  <?php endif; ?>
    </div>
  </div>
  <div class="red-con4"></div>
</div>
<?php endforeach; else: ?>
<div class="no-con"><?php echo $this->_var['lang']['user_bonus_empty']; ?></div>
<?php endif; unset($_from); ?><?php $this->pop_vars();; ?> 