<?php $_from = $this->_var['consignee_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'consignee');if (count($_from)):
    foreach ($_from AS $this->_var['consignee']):
?>
<div class='address_box cons-list <?php if ($this->_var['consignee']['def_addr'] == 1): ?>on<?php endif; ?> p-b1 ubb border-top' id='address_<?php echo $this->_var['consignee']['address_id']; ?>' address_id='<?php echo $this->_var['consignee']['address_id']; ?>'>
  <div class="ubb ub cons-line ub-ac p-all2">
    <div class="ub-f1 ub ub-ac set_default_button">
      <div class="<?php if ($this->_var['consignee']['def_addr'] == 1): ?>redio-on-ff<?php else: ?>redio-off<?php endif; ?> ub-img h-w-1 umar-ar6"></div>
      <div class="ulev-9"> <?php if ($this->_var['consignee']['def_addr'] == 1): ?>默认地址<?php else: ?>设置默认<?php endif; ?> </div>
    </div>
    <div class="ub-pe ub ub-ac delete_button">
      <div class="search-icon2 ub-img h-w-5"></div>
    </div>
  </div>
  <div class="ub p-t-b5 t-wh ub-ac edit_address_button">
    <div class="ub ub-ver ub-f1 p-r1 m-l4 ulev-1">
      <div class="ub">
        <div class="ub-f1"><?php echo $this->_var['consignee']['consignee']; ?></div>
        <div class="ub-pe ufm1"> <?php echo $this->_var['consignee']['mobile']; ?> </div>
      </div>
      <div class="umar-t m-top3"><?php echo $this->_var['consignee']['province']; ?>&nbsp;<?php echo $this->_var['consignee']['city']; ?>&nbsp;<?php echo $this->_var['consignee']['district']; ?>&nbsp;<?php echo $this->_var['consignee']['address']; ?> </div>
    </div>
    <div class="edit-blue ub-img h-w-1 ub-pe umar-ar6"></div>
  </div>
</div>
<?php endforeach; else: ?>
<div class="ub ub-pc umar-t1 f-color-6">您还没有添加地址信息哦！</div>
<?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
<div class="p-fixed-btm1 ub ub-pc p-t-b5 bg-color-w ubt border-hui">
  <div class="btn-red-4" id="add_address_button">+ 添加新地址</div>
</div>
