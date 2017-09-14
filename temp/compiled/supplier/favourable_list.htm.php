<!-- $Id: favourable_list.htm 14216 2008-03-10 02:27:21Z testyang $ -->

<?php if ($this->_var['full_page']): ?>
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>

<div class="form-div">
  <form action="javascript:searchActivity()" name="searchForm">
    <img src="images/icon_search.gif" width="26" height="22" border="0" alt="SEARCH" />
    <?php echo $this->_var['lang']['goods_name']; ?> <input type="text" name="keyword" size="30" />
    <input name="is_going" type="checkbox" id="is_going" value="1" />
    <?php echo $this->_var['lang']['act_is_going']; ?>
    <input type="submit" value="<?php echo $this->_var['lang']['button_search']; ?>" class="button" />
  </form>
</div>

<form method="post" action="favourable.php" name="listForm" onsubmit="return confirm(batch_drop_confirm);">
<!-- start favourable list -->
<div class="list-div" id="listDiv">
<?php endif; ?>

  <table cellpadding="3" cellspacing="1">
    <tr>
      <th>
        <input onclick='listTable.selectAll(this, "checkboxes")' type="checkbox" />
        <a href="javascript:listTable.sort('act_id'); "><?php echo $this->_var['lang']['record_id']; ?></a><?php echo $this->_var['sort_act_id']; ?></th>
      <th><a href="javascript:listTable.sort('act_name'); "><?php echo $this->_var['lang']['act_name']; ?></a><?php echo $this->_var['sort_act_name']; ?></th>
      <th><a href="javascript:listTable.sort('start_time'); "><?php echo $this->_var['lang']['start_time']; ?></a><?php echo $this->_var['sort_start_time']; ?></th>
      <th><a href="javascript:listTable.sort('end_time'); "><?php echo $this->_var['lang']['end_time']; ?></a><?php echo $this->_var['sort_end_time']; ?></th>
      <th><?php echo $this->_var['lang']['min_amount']; ?></th>
      <th><?php echo $this->_var['lang']['max_amount']; ?></th>
      <th><a href="javascript:listTable.sort('sort_order'); "><?php echo $this->_var['lang']['sort_order']; ?></a><?php echo $this->_var['sort_sort_order']; ?></th>
      <th><?php echo $this->_var['lang']['handler']; ?></th>
    </tr>

    <?php $_from = $this->_var['favourable_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'favourable');if (count($_from)):
    foreach ($_from AS $this->_var['favourable']):
?>
    <tr>
      <td><input value="<?php echo $this->_var['favourable']['act_id']; ?>" name="checkboxes[]" type="checkbox"><?php echo $this->_var['favourable']['act_id']; ?></td>
      <td><?php echo htmlspecialchars($this->_var['favourable']['act_name']); ?></td>
      <td align="right"><?php echo $this->_var['favourable']['start_time']; ?></td>
      <td align="right"><?php echo $this->_var['favourable']['end_time']; ?></td>
      <td align="right"><?php echo $this->_var['favourable']['min_amount']; ?></td>
      <td align="right"><?php echo $this->_var['favourable']['max_amount']; ?></td>
      <td align="center"><span onclick="listTable.edit(this, 'edit_sort_order', <?php echo $this->_var['favourable']['act_id']; ?>)"><?php echo $this->_var['favourable']['sort_order']; ?></span></td>
      <td align="center">
        <a href="favourable.php?act=edit&amp;id=<?php echo $this->_var['favourable']['act_id']; ?>" title="<?php echo $this->_var['lang']['edit']; ?>"><img src="images/icon_edit.gif" border="0" height="16" width="16" /></a>
        <a href="javascript:;" onclick="listTable.remove(<?php echo $this->_var['favourable']['act_id']; ?>,'<?php echo $this->_var['lang']['drop_confirm']; ?>')" title="<?php echo $this->_var['lang']['remove']; ?>"><img src="images/icon_drop.gif" border="0" height="16" width="16" /></a>      </td>
    </tr>
    <?php endforeach; else: ?>
    <tr><td class="no-records" colspan="13"><?php echo $this->_var['lang']['no_records']; ?></td></tr>
    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
  </table>

  <table cellpadding="4" cellspacing="0">
    <tr>
      <td><input type="submit" name="drop" id="btnSubmit" value="<?php echo $this->_var['lang']['drop']; ?>" class="button" disabled="true" />
      <input type="hidden" name="act" value="batch" /></td>
      <td align="right"><?php echo $this->fetch('page.htm'); ?></td>
    </tr>
  </table>

<?php if ($this->_var['full_page']): ?>
</div>
<!-- end favourable list -->
</form>

<script type="text/javascript" language="JavaScript">
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
    document.forms['searchForm'].elements['keyword'].focus();

    startCheckOrder();
  }

  /**
   * 搜索团购活动
   */
  function searchActivity()
  {

    var keyword = Utils.trim(document.forms['searchForm'].elements['keyword'].value);
    listTable.filter['keyword'] = keyword;
    if (document.forms['searchForm'].elements['is_going'].checked)
    {
      listTable.filter['is_going'] = 1;
    }
    else
    {
      listTable.filter['is_going'] = 0;
    }
    listTable.filter['page'] = 1;
    listTable.loadList("favourable_list");
  }
  
//-->
</script>

<?php echo $this->fetch('pagefooter.htm'); ?>
<?php endif; ?>