<?php if ($this->_var['full_page']): ?>
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>
<div class="form-div">
  <input type="button" name="export" value="<?php echo $this->_var['lang']['export']; ?>" onclick="location.href='email_list.php?act=export';" class="button" />
</div>
<form method="post" action="email_list.php" name="listForm">
<div class="list-div" id="listDiv">
<?php endif; ?>
<table cellspacing='1' cellpadding='3'>
<tr>
<th width="5%"><input onclick='listTable.selectAll(this, "checkboxes")' type="checkbox"><a href="javascript:listTable.sort('id'); "><?php echo $this->_var['lang']['id']; ?></a><?php echo $this->_var['sort_id']; ?></th>
<th><a href="javascript:listTable.sort('email'); "><?php echo $this->_var['lang']['email_val']; ?></a><?php echo $this->_var['sort_email']; ?></th>
<th width="15%"><a href="javascript:listTable.sort('stat'); "><?php echo $this->_var['lang']['stat']['name']; ?></a><?php echo $this->_var['sort_stat']; ?></th>
</tr>
<?php $_from = $this->_var['emaildb']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'val');if (count($_from)):
    foreach ($_from AS $this->_var['val']):
?>
<tr>
  <td><input name="checkboxes[]" type="checkbox" value="<?php echo $this->_var['val']['id']; ?>" /><?php echo $this->_var['val']['id']; ?></td>
  <td><?php echo $this->_var['val']['email']; ?></td>
  <td align="center"><?php echo $this->_var['lang']['stat'][$this->_var['val']['stat']]; ?></td>
</tr>
<?php endforeach; else: ?>
    <tr><td class="no-records" colspan="10"><?php echo $this->_var['lang']['no_records']; ?></td></tr>
<?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
</table>
<table id="page-table" cellspacing="0">
  <tr>
    <td>
      <input type="hidden" name="act" value="" />
      <input type="button" id="btnSubmit1" value="<?php echo $this->_var['lang']['button_exit']; ?>" disabled="true" class="button" onClick="javascript:document.listForm.act.value='batch_exit';document.listForm.submit();" />
      <input type="button" id="btnSubmit2" value="<?php echo $this->_var['lang']['button_remove']; ?>" disabled="true" class="button" onClick="javascript:document.listForm.act.value='batch_remove';document.listForm.submit();" />
      <input type="button" id="btnSubmit3" value="<?php echo $this->_var['lang']['button_unremove']; ?>" disabled="true" class="button" onClick="javascript:document.listForm.act.value='batch_unremove';document.listForm.submit();" />
    </td>
    <td align="right" nowrap="true">
    <?php echo $this->fetch('page.htm'); ?>
    </td>
  </tr>
</table>
<?php if ($this->_var['full_page']): ?>
</div>
</form>
<script type="Text/Javascript" language="JavaScript">
listTable.recordCount = <?php echo $this->_var['record_count']; ?>;
listTable.pageCount = <?php echo $this->_var['page_count']; ?>;
<?php $_from = $this->_var['filter']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
listTable.filter.<?php echo $this->_var['key']; ?> = '<?php echo $this->_var['item']; ?>';
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
<!--
onload = function()
{
  // 开始检查订单
  startCheckOrder();
}
//-->
</script>
<?php echo $this->fetch('pagefooter.htm'); ?>
<?php endif; ?>