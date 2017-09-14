<!-- $Id: pre_sale_list.htm 14216 2015-02-10 02:27:21Z derek $ -->

<?php if ($this->_var['full_page']): ?>
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>
<div class="form-div">
  <form action="javascript:searchPreSale()" name="searchForm" method="post">
    <img src="images/icon_search.gif" width="26" height="22" border="0" alt="SEARCH" />
    <?php echo $this->_var['lang']['goods_name']; ?> <input type="text" name="keyword" size="30" />
    <input type="submit" value="<?php echo $this->_var['lang']['button_search']; ?>" class="button" />
  </form>
</div>

<form method="post" action="pre_sale.php?act=batch_drop" name="listForm" onsubmit="return confirm(batch_drop_confirm);">
<!-- start pre_sale list -->
<div class="list-div" id="listDiv">
<?php endif; ?>

  <table cellpadding="3" cellspacing="1">
    <tr>
      <th>
        <input onclick='listTable.selectAll(this, "checkboxes")' type="checkbox" />
        <a href="javascript:listTable.sort('act_id'); "><?php echo $this->_var['lang']['record_id']; ?></a><?php echo $this->_var['sort_act_id']; ?>
      </th>
      <th><a href="javascript:listTable.sort('goods_name'); " ><?php echo $this->_var['lang']['goods_name']; ?></a><?php echo $this->_var['sort_goods_name']; ?></th>
      <th><?php echo $this->_var['lang']['current_status']; ?></a></th>
      <!-- <th><a href="javascript:listTable.sort('start_time'); "><?php echo $this->_var['lang']['start_date']; ?></a><?php echo $this->_var['sort_start_time']; ?></th> -->
      <th><a href="javascript:listTable.sort('end_time'); "><?php echo $this->_var['lang']['end_date']; ?></a><?php echo $this->_var['sort_end_time']; ?></th>
      <th><a href="javascript:listTable.sort('deposit'); "><?php echo $this->_var['lang']['deposit']; ?></a><?php echo $this->_var['sort_deposit']; ?></th>
      <th><a href="javascript:listTable.sort('restrict_amount'); "><?php echo $this->_var['lang']['restrict_amount']; ?></a><?php echo $this->_var['sort_restrict_amount']; ?></th>
      <!-- <th><a href="javascript:listTable.sort('gift_integral'); "><?php echo $this->_var['lang']['gift_integral']; ?></a><?php echo $this->_var['sort_gift_integral']; ?></th> -->
      <th><?php echo $this->_var['lang']['valid_goods']; ?></a></th>
      <th><?php echo $this->_var['lang']['valid_order']; ?></a></th>
      <th><?php echo $this->_var['lang']['current_price']; ?></a></th>
      <th><?php echo $this->_var['lang']['handler']; ?></th>
    </tr>

    <?php $_from = $this->_var['pre_sale_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'pre_sale');if (count($_from)):
    foreach ($_from AS $this->_var['pre_sale']):
?>
    <tr>
      <td><input value="<?php echo $this->_var['pre_sale']['act_id']; ?>" name="checkboxes[]" type="checkbox"><?php echo $this->_var['pre_sale']['act_id']; ?></td>
      <td><a href="../pre_sale.php?id=<?php echo $this->_var['pre_sale']['act_id']; ?>" target="_blank"><?php echo htmlspecialchars($this->_var['pre_sale']['goods_name']); ?></a></td>
      <td><?php echo $this->_var['pre_sale']['cur_status']; ?></td>
      <!-- <td align="right"><?php echo $this->_var['pre_sale']['start_time']; ?></td> -->
      <td align="right"><?php echo $this->_var['pre_sale']['end_time']; ?></td>
      <td align="right"><span onclick="listTable.edit(this, 'edit_deposit', <?php echo $this->_var['pre_sale']['act_id']; ?>)"><?php echo $this->_var['pre_sale']['deposit']; ?></span></td>
      <td align="right"><span onclick="listTable.edit(this, 'edit_restrict_amount', <?php echo $this->_var['pre_sale']['act_id']; ?>)"><?php echo $this->_var['pre_sale']['restrict_amount']; ?></span></td>
      <!-- <td align="right"><?php echo $this->_var['pre_sale']['gift_integral']; ?></td> -->
      <td align="right"><?php echo $this->_var['pre_sale']['valid_goods']; ?></td>
      <td align="right"><?php echo $this->_var['pre_sale']['valid_order']; ?></td>
      <td align="right"><?php echo $this->_var['pre_sale']['cur_price']; ?></td>
      <td align="center">
        <a href="order.php?act=list&amp;pre_sale_id=<?php echo $this->_var['pre_sale']['act_id']; ?>"><img src="images/icon_view.gif" title="<?php echo $this->_var['lang']['view_order']; ?>" border="0" height="16" width="16" /></a>
        <a href="pre_sale.php?act=edit&amp;id=<?php echo $this->_var['pre_sale']['act_id']; ?>" title="<?php echo $this->_var['lang']['edit']; ?>"><img src="images/icon_edit.gif" border="0" height="16" width="16" /></a>
        <a href="javascript:remove('<?php echo $this->_var['pre_sale']['act_id']; ?>');" title="<?php echo $this->_var['lang']['remove']; ?>"><img src="images/icon_drop.gif" border="0" height="16" width="16" /></a>
      </td>
    </tr>
    <?php endforeach; else: ?>
    <tr><td class="no-records" colspan="10"><?php echo $this->_var['lang']['no_records']; ?></td></tr>
    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
  </table>

  <table cellpadding="4" cellspacing="0">
    <tr>
    <!-- 
      <td><input type="submit" name="drop" id="btnSubmit" value="<?php echo $this->_var['lang']['drop']; ?>" class="button" disabled="true" /></td>
       -->
      <td align="right"><?php echo $this->fetch('page.htm'); ?></td>
    </tr>
  </table>

<?php if ($this->_var['full_page']): ?>
</div>
<!-- end pre_sale list -->
</form>

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
    document.forms['searchForm'].elements['keyword'].focus();

    startCheckOrder();
  }

  /**
   * 搜索团购活动
   */
  function searchPreSale()
  {

    var keyword = Utils.trim(document.forms['searchForm'].elements['keyword'].value);
    listTable.filter['keyword'] = keyword;
    listTable.filter['page'] = 1;
    listTable.loadList("pre_sale_list");
  }
  function remove(id){
	  if(confirm('您确定要删除此预售活动吗')){
	  	window.location.href = "pre_sale.php?act=remove&act_id="+id;
	  }
  }
  
</script>

<?php echo $this->fetch('pagefooter.htm'); ?>
<?php endif; ?>