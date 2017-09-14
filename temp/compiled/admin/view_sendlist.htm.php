<?php if ($this->_var['full_page']): ?>
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>

<form method="post" action="" name="listForm">
<div class="list-div" id="listDiv">
<?php endif; ?>
<table cellspacing='1' cellpadding='3'>
<tr>
  <th>
    <input onclick='listTable.selectAll(this, "checkboxes")' type="checkbox">
    <?php echo $this->_var['lang']['record_id']; ?>
  </th>
  <th><a href="javascript:listTable.sort('template_subject'); "><?php echo $this->_var['lang']['email_subject']; ?></a><?php echo $this->_var['sort_template_subject']; ?></th>
  <th><a href="javascript:listTable.sort('email'); "><?php echo $this->_var['lang']['email_val']; ?></a><?php echo $this->_var['sort_email']; ?></th>
  <th width="8%"><a href="javascript:listTable.sort('pri'); "><?php echo $this->_var['lang']['pri']['name']; ?></a><?php echo $this->_var['sort_pri']; ?></th>
  <th width="8%"><?php echo $this->_var['lang']['type']['name']; ?></th>
  <th width="8%"><a href="javascript:listTable.sort('error'); "><?php echo $this->_var['lang']['email_error']; ?></a><?php echo $this->_var['sort_error']; ?></th>
  <th width="20%"><a href="javascript:listTable.sort('last_send'); "><?php echo $this->_var['lang']['last_send']; ?></a><?php echo $this->_var['sort_last_send']; ?></th>
  <th width="5%"><?php echo $this->_var['lang']['handler']; ?></th>
</tr>
<?php $_from = $this->_var['listdb']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'val');if (count($_from)):
    foreach ($_from AS $this->_var['val']):
?>
<tr>
  <td><input type="checkbox" name="checkboxes[]" value="<?php echo $this->_var['val']['id']; ?>" /><?php echo $this->_var['val']['id']; ?></td>
  <td><?php echo $this->_var['val']['template_subject']; ?></td>
  <td><?php echo $this->_var['val']['email']; ?></td>
  <td align="center"><?php echo $this->_var['lang']['pri'][$this->_var['val']['pri']]; ?></td>
  <td align="center"><?php echo $this->_var['lang']['type'][$this->_var['val']['type']]; ?></td>
  <td align="center"><?php echo $this->_var['val']['error']; ?></td>
  <td align="center"><?php echo $this->_var['val']['last_send']; ?></td>
  <td align="center"><a href="view_sendlist.php?act=del&id=<?php echo $this->_var['val']['id']; ?>" onclick="return confirm('<?php echo $this->_var['lang']['ckdelete']; ?>');"><?php echo $this->_var['lang']['delete']; ?></a></td>
</tr>
<?php endforeach; else: ?>
  <tr><td class="no-records" colspan="10"><?php echo $this->_var['lang']['no_records']; ?></td></tr>
<?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
</table>
<!-- 分页 -->
<table id="page-table" cellspacing="0">
  <tr>
    <td>
    <input type="hidden" name="act" value=""/>
    <input type="button" id="btnSubmit1" value="<?php echo $this->_var['lang']['button_remove']; ?>" disabled="true" class="button" onclick="subFunction('batch_remove')"/>
    <input type="button" id="btnSubmit2" value="<?php echo $this->_var['lang']['batch_send']; ?>" disabled="true" class="button" onclick="subFunction('batch_send')"/>
    <input type="button" value="<?php echo $this->_var['lang']['all_send']; ?>" class="button" onclick="subFunction('all_send')"/>
    </td>
    <td align="right" nowrap="true">
    <?php echo $this->fetch('page.htm'); ?>
    </td>
  </tr>
</table>
<script type="text/javascript" language="JavaScript">
function subFunction(act)
{
  var frm = document.forms['listForm'];
  frm.elements['act'].value = act;
  frm.submit();
}
</script>
<?php if ($this->_var['full_page']): ?>
</div>
</form>

<script type="text/javascript" language="JavaScript">
listTable.recordCount = <?php echo $this->_var['record_count']; ?>;
listTable.pageCount = <?php echo $this->_var['page_count']; ?>;
<?php $_from = $this->_var['filter']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
listTable.filter.<?php echo $this->_var['key']; ?> = '<?php echo $this->_var['item']; ?>';
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</script>


<?php echo $this->fetch('pagefooter.htm'); ?>
<?php endif; ?>