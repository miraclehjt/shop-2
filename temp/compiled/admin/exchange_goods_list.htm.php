<!-- $Id: exchange_goods_list.htm 15544 2009-01-09 01:54:28Z zblikai $ -->
<?php if ($this->_var['full_page']): ?>
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>
<div class="form-div">
  <form action="javascript:searchArticle()" name="searchForm">
    <img src="images/icon_search.gif" width="26" height="22" border="0" alt="SEARCH" />
    <?php echo $this->_var['lang']['title']; ?> <input type="text" name="keyword" id="keyword" />
    <input type="submit" value="<?php echo $this->_var['lang']['button_search']; ?>" class="button" />
  </form>
</div>

<form method="POST" action="exchange_goods.php?act=batch_remove" name="listForm">
<!-- start cat list -->
<div class="list-div" id="listDiv">
<?php endif; ?>

<table cellspacing='1' cellpadding='3' id='list-table'>
  <tr>
    <th><input onclick='listTable.selectAll(this, "checkboxes")' type="checkbox">
      <a href="javascript:listTable.sort('goods_id'); "><?php echo $this->_var['lang']['goods_id']; ?></a><?php echo $this->_var['sort_goods_id']; ?></th>
    <th><a href="javascript:listTable.sort('goods_name'); "><?php echo $this->_var['lang']['goods_name']; ?></a><?php echo $this->_var['sort_goods_name']; ?></th>
    <th><a href="javascript:listTable.sort('exchange_integral'); "><?php echo $this->_var['lang']['exchange_integral']; ?></a><?php echo $this->_var['sort_exchange_integral']; ?></th>
    <th><a href="javascript:listTable.sort('is_exchange'); "><?php echo $this->_var['lang']['is_exchange']; ?></a><?php echo $this->_var['sort_is_exchange']; ?></th>
    <th><a href="javascript:listTable.sort('is_hot'); "><?php echo $this->_var['lang']['is_hot']; ?></a><?php echo $this->_var['sort_is_hot']; ?></th>
    <th><?php echo $this->_var['lang']['handler']; ?></th>
  </tr>
  <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
  <tr>
    <td><span><input name="checkboxes[]" type="checkbox" value="<?php echo $this->_var['list']['goods_id']; ?>"/><?php echo $this->_var['list']['goods_id']; ?></span></td>
    <td class="first-cell"><span><?php echo htmlspecialchars($this->_var['list']['goods_name']); ?></span></td>
    <td align="center"><span onclick="listTable.edit(this, 'edit_exchange_integral', <?php echo $this->_var['list']['goods_id']; ?>)"><?php echo $this->_var['list']['exchange_integral']; ?></span></td>
    <td align="center"><img src="images/<?php if ($this->_var['list']['is_exchange'] == 1): ?>yes<?php else: ?>no<?php endif; ?>.gif" onclick="listTable.toggle(this, 'toggle_exchange', <?php echo $this->_var['list']['goods_id']; ?>)" /></td>
    <td align="center"><img src="images/<?php if ($this->_var['list']['is_hot'] == 1): ?>yes<?php else: ?>no<?php endif; ?>.gif" onclick="listTable.toggle(this, 'toggle_hot', <?php echo $this->_var['list']['goods_id']; ?>)" /></td>
    <td align="center" nowrap="true"><span>
      <a href="../exchange.php?id=<?php echo $this->_var['list']['goods_id']; ?>&act=view" target="_blank" title="<?php echo $this->_var['lang']['view']; ?>"><img src="images/icon_view.gif" border="0" height="16" width="16" /></a>&nbsp;
      <a href="exchange_goods.php?act=edit&id=<?php echo $this->_var['list']['goods_id']; ?>" title="<?php echo $this->_var['lang']['edit']; ?>"><img src="images/icon_edit.gif" border="0" height="16" width="16" /></a>&nbsp;
      <a href="javascript:;" onclick="listTable.remove(<?php echo $this->_var['list']['goods_id']; ?>, '<?php echo $this->_var['lang']['drop_confirm']; ?>')" title="<?php echo $this->_var['lang']['remove']; ?>"><img src="images/icon_drop.gif" border="0" height="16" width="16"></a></span>
    </td>
   </tr>
   <?php endforeach; else: ?>
    <tr><td class="no-records" colspan="5"><?php echo $this->_var['lang']['no_records']; ?></td></tr>
  <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
  <tr>
    <td colspan="2"><input type="submit" class="button" id="btnSubmit" value="<?php echo $this->_var['lang']['button_remove']; ?>" disabled="true" /></td>
    <td align="right" nowrap="true" colspan="8"><?php echo $this->fetch('page.htm'); ?></td>
  </tr>
</table>

<?php if ($this->_var['full_page']): ?>
</div>
<!-- end cat list -->
<script type="text/javascript" language="JavaScript">
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

 /* 搜索文章 */
 function searchArticle()
 {
    listTable.filter.keyword = Utils.trim(document.forms['searchForm'].elements['keyword'].value);
    listTable.filter.page = 1;
    listTable.loadList();
 }
 
</script>
<?php echo $this->fetch('pagefooter.htm'); ?>
<?php endif; ?>
