<?php if ($this->_var['menu']): ?>
<div class="ub-f1 ub ub-ver p-t-b1 ubb bc-bt uof border-hui bg-color-w"> 
<?php $_from = $this->_var['menu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'row');$this->_foreach['menu_row'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['menu_row']['total'] > 0):
    foreach ($_from AS $this->_var['row']):
        $this->_foreach['menu_row']['iteration']++;
?>
  <div class="ub p-all1"> 
  <?php $_from = $this->_var['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'menu_item');$this->_foreach['menu_item'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['menu_item']['total'] > 0):
    foreach ($_from AS $this->_var['menu_item']):
        $this->_foreach['menu_item']['iteration']++;
?>
    <div class="ub-f1 ub ub-ver ub-ac ub-pc">
      <div class="ub-img uwh-acc2 menu_image _menu" style="background-image:url(<?php echo $this->_var['url']; ?><?php echo $this->_var['menu_item']['image']; ?>?<?php echo $this->_var['rand']; ?>)" menu_type="<?php echo $this->_var['menu_item']['type']; ?>" menu_link="<?php echo $this->_var['menu_item']['link']; ?>" menu_name="<?php echo $this->_var['menu_item']['name']; ?>"></div>
      <div class="ub ub-pc w-min1">
        <div class="ulev-1 f-color-6"> <?php echo $this->_var['menu_item']['name']; ?></div>
      </div>
    </div>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
	</div>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  </div>
  <?php endif; ?>