
<div class="ft-bands" data-spm="a22255a">
<?php $_from = $this->_var['tuijian']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'type');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['type']):
        $this->_foreach['name']['iteration']++;
?> 
	<div style="overflow:hidden" class="ft-col <?php echo $this->_var['type']['str_style']; ?> <?php if (($this->_foreach['name']['iteration'] <= 1)): ?>ft-col-cur<?php endif; ?>">
	<h3 class="ft-title"><?php echo $this->_var['type']['str_name']; ?></h3>
	<h4 class="ft-desc"><?php echo $this->_var['type']['str_desc']; ?></h4>
	<?php if ($this->_var['type']['shoplist']): ?>
	<?php $_from = $this->_var['type']['shoplist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('k', 'shop');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['shop']):
?> 
		<p class="ft-list"> 
		<a href="supplier.php?suppId=<?php echo $this->_var['shop']['supplier_id']; ?>" class="ft-item"><img width="90" height="45" alt="<?php echo $this->_var['shop']['supplier_name']; ?>" data-original="<?php echo $this->_var['logopath']; ?>logo_supplier<?php echo $this->_var['shop']['supplier_id']; ?>.jpg" src="themes/68ecshopcom_360buy/images/loading.gif"> <b class="ui-brand-btn ui-brand-btn-ex-s ui-brand-btn-ex-bubble j_CollectBrand" data-brandid="42638"><i></i><span>关注店铺</span><b></b></b> </a> 
		</p>
	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	<p class="ft-list"></p>
	<p class="ft-list"></p>
	<?php endif; ?>
	
	</div>
	
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</div>