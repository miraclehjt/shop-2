<?php if ($this->_var['full_page']): ?>
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>
<div class="list-div" id="listDiv">
<?php endif; ?>
<table cellspacing='1' cellpadding='3'>
<tr>
    <th><?php echo $this->_var['lang']['magazine_name']; ?></th>
    <th width="20%"><?php echo $this->_var['lang']['magazine_last_update']; ?></th>
    <th width="20%"><?php echo $this->_var['lang']['magazine_last_send']; ?></th>
    <th width="20%"><?php echo $this->_var['lang']['magazine_addtolist']; ?></th>
    <th width="12%"><?php echo $this->_var['lang']['handler']; ?></th>
</tr>
<?php $_from = $this->_var['magazinedb']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'val');if (count($_from)):
    foreach ($_from AS $this->_var['val']):
?>
<tr>
    <td><?php echo $this->_var['val']['template_subject']; ?></td>
    <td align="center"><?php echo $this->_var['val']['last_modify']; ?></td>
    <td align="center"><?php echo $this->_var['val']['last_send']; ?></td>
    <td align="center">
    <form action="magazine_list.php" method="post" name="hidform">
        <input type="hidden" name="id" value="<?php echo $this->_var['val']['template_id']; ?>" />
        <input type="hidden" name="act" value="addtolist" />
        <select name="pri"><option value='0'><?php echo $this->_var['lang']['pri']['0']; ?></option><option value='1'><?php echo $this->_var['lang']['pri']['1']; ?></option></select>
        <select name="send_rank">
          <?php echo $this->html_options(array('options'=>$this->_var['send_rank'])); ?>
        </select>
        <input type="submit" value="<?php echo $this->_var['lang']['button_submit']; ?>" class="button" />
    </form>
    </td>
    <td align="center"><a href="magazine_list.php?act=edit&id=<?php echo $this->_var['val']['template_id']; ?>"><?php echo $this->_var['lang']['magazine_edit']; ?></a> <a href="magazine_list.php?act=del&id=<?php echo $this->_var['val']['template_id']; ?>" onclick="return confirm('<?php echo $this->_var['lang']['ck_del']; ?>');"><?php echo $this->_var['lang']['magazine_del']; ?></a></td>
</tr>
    <?php endforeach; else: ?>
    <tr><td class="no-records" colspan="10"><?php echo $this->_var['lang']['no_records']; ?></td></tr>
<?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
</table>
<form method="post" action="" name="listForm">
<table cellpadding="4" cellspacing="0">
  <tr>
    <td align="right"><?php echo $this->fetch('page.htm'); ?></td>
  </tr>
</table>
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