<div id='goods_attr_container_<?php echo $this->_var['goods_id']; ?>' class='index-attr' goods_id="<?php echo $this->_var['goods_id']; ?>" parent_id="<?php echo $this->_var['parent_id']; ?>">
<div class="into-cart p-all4">
<div style="height:10em; overflow-y:scroll">
<?php $_from = $this->_var['spe_array']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'level1');if (count($_from)):
    foreach ($_from AS $this->_var['level1']):
?>
<div attr_type="<?php echo $this->_var['level1']['attr_type']; ?>" attr_id="<?php echo $this->_var['level1']['attr_id']; ?>" class="ubb border-faxian p-t-b5 goods_attr_container" >
	<div class="ulev-1 f-color-6"><?php echo $this->_var['level1']['name']; ?></div>
	<div  class="shuxing spec_key m-top1">
		<?php $_from = $this->_var['level1']['values']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'level2');$this->_foreach['level2'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['level2']['total'] > 0):
    foreach ($_from AS $this->_var['level2']):
        $this->_foreach['level2']['iteration']++;
?>
		<div price="<?php echo $this->_var['level2']['price']; ?>" format_price="<?php echo $this->_var['level2']['format_price']; ?>" attr_id="<?php echo $this->_var['level2']['id']; ?>" class="goods_attr <?php if ($this->_foreach['level2']['iteration'] == 1): ?>selected<?php endif; ?>"><?php echo $this->_var['level2']['label']; ?>[<?php echo $this->_var['level2']['format_price']; ?>]</div>
		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		<ul class="clear1"></ul>
	</div>
</div>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</div>
<div class="btn-red1 ulev-1 umar-t1 tx-c confirm_attr_button">确定</div>
</div>
</div>