<?php if ($this->_var['pager']): ?>
<section class="list-pagination">
    <div style="" class="pagenav-wrapper" id="J_PageNavWrap">
      <div class="pagenav-content">
        <div class="pagenav" id="J_PageNav">

          <div class="p-prev p-gray" > <a href="<?php echo $this->_var['pager']['page_prev']; ?>"><?php echo $this->_var['lang']['page_prev']; ?></a> </div>
          <div class="pagenav-cur" style="vertical-align:bottom">
            <div class="pagenav-text" > <span><?php $_from = $this->_var['pager']['page_number']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item_0_83746400_1505210442');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item_0_83746400_1505210442']):
?>
      <?php if ($this->_var['pager']['page'] == $this->_var['key']): ?><?php echo $this->_var['key']; ?><?php endif; ?><?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>/<?php echo $this->_var['pager']['page_count']; ?></span> <i></i> </div>
      <select class="pagenav-select"  onchange="location.href=this.options[this.selectedIndex].value;">
<?php $_from = $this->_var['pager']['page_number']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item_0_05847600_1505210443');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item_0_05847600_1505210443']):
?>
  <option <?php if ($this->_var['pager']['page'] == $this->_var['key']): ?>selected="selected"<?php endif; ?> value="<?php echo $this->_var['item_0_05847600_1505210443']; ?>">第<?php echo $this->_var['key']; ?>页</option>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</select>
            
          </div>
       <div class="p-next" > <a href="<?php echo $this->_var['pager']['page_next']; ?>"><?php echo $this->_var['lang']['page_next']; ?></a> </div>
		</div>
      </div>
    </div>
  </section>
<?php endif; ?>