<?php if ($this->_var['how_oos_list']): ?>
<div class="checkBox_jm m-top3 bg-color-w">
  <div class="uinn-eo5 ub ub-ac ubb border-hui _fold" fold_key='how_oos_box' value_key="how_oos">
    <div class="ub-f1 f-color-zi ulev-9 p-all5">
      缺货处理
    </div>
	<div class='ub-pe xuanzhong ulev-1 selected_indicator' id='selected_how_oos'>
	<?php $_from = $this->_var['how_oos_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('how_oos_id', 'how_oos_name');if (count($_from)):
    foreach ($_from AS $this->_var['how_oos_id'] => $this->_var['how_oos_name']):
?>
	<?php if ($this->_var['order']['how_oos'] == $this->_var['how_oos_id']): ?>
	<?php echo $this->_var['how_oos_name']; ?>
	<?php endif; ?>
	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	</div>
    <div class="sc-text ulev-1-4 umar-r fold_indicator fa ">
    </div>
  </div>
  <div id="how_oos_box" class='uhide p-all1 f-color-6 ulev-1'>
    <?php $_from = $this->_var['how_oos_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('how_oos_id', 'how_oos_name');if (count($_from)):
    foreach ($_from AS $this->_var['how_oos_id'] => $this->_var['how_oos_name']):
?>
    <div class="how_oos <?php if ($this->_var['order']['how_oos'] == $this->_var['how_oos_id']): ?> checked<?php endif; ?> _checkbox checkbox_radio" <?php if ($this->_var['order']['how_oos'] == $this->_var['how_oos_id']): ?>checked="true"<?php endif; ?> radio="true" name="how_oos" value="<?php echo $this->_var['how_oos_id']; ?>" cancel="false">
      <?php echo $this->_var['how_oos_name']; ?>
    </div>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  </div>
 </div>

<?php endif; ?>