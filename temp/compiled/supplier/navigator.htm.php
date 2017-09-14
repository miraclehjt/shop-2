<?php if ($this->_var['full_page']): ?>
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>
<form method="post" action="" name="listForm">
<div class="list-div" id="listDiv">
<?php endif; ?>
<table cellspacing='1' cellpadding='3' id='list-table'>
<tr>
	<th><?php echo $this->_var['lang']['item_name']; ?></th><th><?php echo $this->_var['lang']['item_ifshow']; ?></th><th><?php echo $this->_var['lang']['item_opennew']; ?></th><th><?php echo $this->_var['lang']['item_vieworder']; ?></th>
	<!-- <th><?php echo $this->_var['lang']['item_type']; ?></th> --><th width="60px"><?php echo $this->_var['lang']['handler']; ?></th>
</tr>
<?php $_from = $this->_var['navdb']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'val');if (count($_from)):
    foreach ($_from AS $this->_var['val']):
?>
<tr>
	<td align="center"><!-- <?php if ($this->_var['val']['id']): ?> --><?php echo $this->_var['val']['name']; ?><!-- <?php else: ?> -->&nbsp;<!-- <?php endif; ?> --></td>
  <td align="center">
   <!-- <?php if ($this->_var['val']['id']): ?> -->
   <img src="images/<?php if ($this->_var['val']['ifshow'] == '1'): ?>yes<?php else: ?>no<?php endif; ?>.gif" onclick="listTable.toggle(this, 'toggle_ifshow', <?php echo $this->_var['val']['id']; ?>)" />
   <!-- <?php endif; ?> --></td>
  <td align="center">
   <!-- <?php if ($this->_var['val']['id']): ?> -->
    <img src="images/<?php if ($this->_var['val']['opennew'] == '1'): ?>yes<?php else: ?>no<?php endif; ?>.gif" onclick="listTable.toggle(this, 'toggle_opennew', <?php echo $this->_var['val']['id']; ?>)" />
   <!-- <?php endif; ?> --></td>
  <td align="center"><!-- <?php if ($this->_var['val']['id']): ?> --><span onclick="listTable.edit(this, 'edit_sort_order', <?php echo $this->_var['val']['id']; ?>)"><?php echo $this->_var['val']['vieworder']; ?></span><!-- <?php endif; ?> --></td>
  <!-- <td align="center"><!-- <?php if ($this->_var['val']['id']): ?> <?php echo $this->_var['lang'][$this->_var['val']['type']]; ?><!-- <?php endif; ?> </td> -->
  <td align="center"><!-- <?php if ($this->_var['val']['id']): ?> --><a href="navigator.php?act=edit&id=<?php echo $this->_var['val']['id']; ?>" title="<?php echo $this->_var['lang']['edit']; ?>"><img src="images/icon_edit.gif" width="16" height="16" border="0" /></a>
  <a href="navigator.php?act=del&id=<?php echo $this->_var['val']['id']; ?>" onclick="return confirm('<?php echo $this->_var['lang']['ckdel']; ?>');" title="<?php echo $this->_var['lang']['ckdel']; ?>"><img src="images/no.gif" width="16" height="16" border="0" /><!-- <?php endif; ?> --></a>
  </td>
</tr>
<?php endforeach; else: ?>
<tr><td class="no-records" colspan="10"><?php echo $this->_var['lang']['no_records']; ?></td></tr>
<?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
</table>

  <table cellpadding="4" cellspacing="0">
    <tr>
      <td align="right"><?php echo $this->fetch('page.htm'); ?></td>
    </tr>
  </table>
<?php if ($this->_var['full_page']): ?>
</div>
</form>
<script type="Text/Javascript" language="JavaScript">
<!--
listTable.recordCount = <?php echo $this->_var['record_count']; ?>;
listTable.pageCount = <?php echo $this->_var['page_count']; ?>;
<?php $_from = $this->_var['filter']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
listTable.filter.<?php echo $this->_var['key']; ?> = '<?php echo $this->_var['item']; ?>';
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

onload = function()
{
  // 开始检查订单
  startCheckOrder();
}

//-->
</script>
<?php echo $this->fetch('pagefooter.htm'); ?>
<?php endif; ?>