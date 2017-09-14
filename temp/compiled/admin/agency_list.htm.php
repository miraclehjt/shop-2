<!-- $Id: agency_list.htm 14216 2008-03-10 02:27:21Z testyang $ -->

<?php if ($this->_var['full_page']): ?>
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>

<form method="post" action="" name="listForm" onsubmit="return confirm(batch_drop_confirm);">
<div class="list-div" id="listDiv">
<?php endif; ?>

  <table cellpadding="3" cellspacing="1">
    <tr>
      <th> <input onclick='listTable.selectAll(this, "checkboxes")' type="checkbox" />
          <a href="javascript:listTable.sort('agency_id'); "><?php echo $this->_var['lang']['record_id']; ?></a><?php echo $this->_var['sort_agency_id']; ?> </th>
      <th><a href="javascript:listTable.sort('agency_name'); "><?php echo $this->_var['lang']['agency_name']; ?></a><?php echo $this->_var['sort_agency_name']; ?></th>
      <th><?php echo $this->_var['lang']['agency_desc']; ?></th>
      <th><?php echo $this->_var['lang']['handler']; ?></th>
    </tr>
    <?php $_from = $this->_var['agency_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'agency');if (count($_from)):
    foreach ($_from AS $this->_var['agency']):
?>
    <tr>
      <td><input type="checkbox" name="checkboxes[]" value="<?php echo $this->_var['agency']['agency_id']; ?>" />
        <?php echo $this->_var['agency']['agency_id']; ?></td>
      <td class="first-cell">
        <span onclick="javascript:listTable.edit(this, 'edit_agency_name', <?php echo $this->_var['agency']['agency_id']; ?>)"><?php echo htmlspecialchars($this->_var['agency']['agency_name']); ?>      </span></td>
      <td><?php echo nl2br($this->_var['agency']['agency_desc']); ?></td>
      <td align="center">
        <a href="agency.php?act=edit&id=<?php echo $this->_var['agency']['agency_id']; ?>" title="<?php echo $this->_var['lang']['edit']; ?>"><?php echo $this->_var['lang']['edit']; ?></a> |
        <a href="javascript:;" onclick="listTable.remove(<?php echo $this->_var['agency']['agency_id']; ?>, '<?php echo $this->_var['lang']['drop_confirm']; ?>')" title="<?php echo $this->_var['lang']['remove']; ?>"><?php echo $this->_var['lang']['remove']; ?></a>      </td>
    </tr>
    <?php endforeach; else: ?>
    <tr><td class="no-records" colspan="4"><?php echo $this->_var['lang']['no_records']; ?></td></tr>
    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
  </table>
<table id="page-table" cellspacing="0">
  <tr>
    <td>
      <input name="remove" type="submit" id="btnSubmit" value="<?php echo $this->_var['lang']['drop']; ?>" class="button" disabled="true" />
      <input name="act" type="hidden" value="batch" />
    </td>
    <td align="right" nowrap="true">
    <?php echo $this->fetch('page.htm'); ?>
    </td>
  </tr>
</table>

<?php if ($this->_var['full_page']): ?>
</div>
</form>

<script type="text/javascript" language="javascript">
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