<script>
;(function($){
	Zepto(function($)
	{
		init_swipe();
		$.zcontent.add_success(init_swipe);
	})
	
	function init_swipe()
	{
		<?php $_from = $this->_var['status_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('scr_key', 'screen');if (count($_from)):
    foreach ($_from AS $this->_var['scr_key'] => $this->_var['screen']):
?>
		$('#status_list_<?php echo $this->_var['scr_key']; ?>').swipeLeft(function()
		{
			$('#status_list_<?php echo $this->_var['scr_key']; ?>').slideLeftOut(200,function(){$('#status_list_<?php if ($this->_var['scr_key'] >= $this->_var['status_scr_count']): ?>1<?php else: ?><?php echo ($this->_var['scr_key']+1); ?><?php endif; ?>').slideLeftIn(200)});
		})
		$('#status_list_<?php echo $this->_var['scr_key']; ?>').swipeRight(function()
		{
			$('#status_list_<?php echo $this->_var['scr_key']; ?>').slideRightOut(200,function(){$('#status_list_<?php if ($this->_var['scr_key'] == 1): ?><?php echo $this->_var['status_scr_count']; ?><?php else: ?><?php echo ($this->_var['scr_key']-1); ?><?php endif; ?>').slideRightIn(200)});
		})
		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	}
})(Zepto)
function change_status(status)
{
	$.zcontent.set('composite_status',status);
	search();
}
</script>
<?php $_from = $this->_var['status_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('scr_key', 'screen');if (count($_from)):
    foreach ($_from AS $this->_var['scr_key'] => $this->_var['screen']):
?>
 <ul class="order_type_con" id='status_list_<?php echo $this->_var['scr_key']; ?>' <?php if ($this->_var['scr_key'] != $this->_var['sel_status_scr']): ?>style='display:none;'<?php endif; ?>>
 <?php $_from = $this->_var['screen']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('status_id', 'status_name');$this->_foreach['status_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['status_list']['total'] > 0):
    foreach ($_from AS $this->_var['status_id'] => $this->_var['status_name']):
        $this->_foreach['status_list']['iteration']++;
?>
 <li  <?php if ($this->_var['filter']['composite_status'] == $this->_var['status_id']): ?>class="curr"<?php endif; ?> id="type<?php echo $this->_foreach['status_list']['iteration']; ?>" onclick="change_status('<?php echo $this->_var['status_id']; ?>')"><a><?php echo $this->_var['status_name']; ?></a>
 <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 </ul>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>