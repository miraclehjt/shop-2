<!-- $Id: pre_sale_list.htm 14216 2015-02-10 02:27:21Z derek $ -->
<?php if ($this->_var['full_page']): ?> <?php echo $this->fetch('pageheader.htm'); ?> <?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>
<div class="form-div">
	<form action="javascript:searchGroupBuy()" name="searchForm">
		<img src="images/icon_search.gif" width="26" height="22" border="0" alt="SEARCH" />
		<?php echo $this->_var['lang']['cus_name']; ?>
		<input type="text" name="keyword" size="30" />
		<input type="submit" value="<?php echo $this->_var['lang']['button_search']; ?>" class="button" />
	</form>
</div>
<form method="post" action="customer.php?act=batch_drop" name="listForm" onsubmit="return confirm('<?php echo $this->_var['lang']['batch_drop_confirm']; ?>');">
	<!-- start pre_sale list -->
	<div class="list-div" id="listDiv">
		<?php endif; ?>
		<table cellpadding="3" cellspacing="1">
			<tr>
				<th>
					<input onclick='listTable.selectAll(this, "checkboxes")' type="checkbox" />
					<a href="javascript:listTable.sort('cus_id'); "><?php echo $this->_var['lang']['cus_id']; ?></a><?php echo $this->_var['sort_cus_id']; ?>
				</th>
				<th>
					<a href="javascript:listTable.sort('user_id'); "><?php echo $this->_var['lang']['user_id']; ?></a><?php echo $this->_var['sort_user_id']; ?>
				</th>
				<th>
					<a href="javascript:listTable.sort('of_username'); "><?php echo $this->_var['lang']['of_username']; ?></a><?php echo $this->_var['sort_of_username']; ?>
				</th>
				<th>
					<a href="javascript:listTable.sort('cus_name'); "><?php echo $this->_var['lang']['cus_name']; ?></a><?php echo $this->_var['sort_cus_name']; ?>
				</th>
				<th>
					<a href="javascript:listTable.sort('cus_type'); "><?php echo $this->_var['lang']['cus_type']; ?></a><?php echo $this->_var['sort_cus_type']; ?>
				</th>
				<th>
					<a href="javascript:listTable.sort('cus_enable'); "><?php echo $this->_var['lang']['cus_enable']; ?></a><?php echo $this->_var['sort_cus_enable']; ?>
				</th>
				<th>
					<a href="javascript:listTable.sort('add_time'); "><?php echo $this->_var['lang']['add_time']; ?></a><?php echo $this->_var['sort_add_time']; ?>
				</th>
				<th><?php echo $this->_var['lang']['handler']; ?></th>
			</tr>
			<?php $_from = $this->_var['customer_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
        $this->_foreach['name']['iteration']++;
?>
			<tr>
				<td>
					<input value="<?php echo $this->_var['item']['cus_id']; ?>" name="checkboxes[]" type="checkbox" value="<?php echo $this->_var['item']['cus_id']; ?>">
					<?php echo $this->_var['item']['cus_id']; ?>
				</td>
				<td align="center"><?php echo $this->_var['item']['user_name']; ?></td>
				<td align="center"><?php echo $this->_var['item']['of_username']; ?></td>
				<td align="center"><?php echo $this->_var['item']['cus_name']; ?></td>
				<td align="center"><?php echo $this->_var['lang']['CUS_TYPE'][$this->_var['item']['cus_type']]; ?></td>
				<td align="center"><?php echo $this->_var['lang']['CUS_ENABLE'][$this->_var['item']['cus_enable']]; ?></td>
				<td align="center"><?php echo $this->_var['item']['formated_add_time']; ?></td>
				<td align="center">
					<!-- 查看聊天记录 -->
					<a href="customer.php?act=edit&id=<?php echo $this->_var['item']['cus_id']; ?>" title="<?php echo $this->_var['lang']['edit']; ?>">
						<img src="images/icon_edit.gif" border="0" height="16" width="16" />
					</a>
					<a href="javascript:;" onclick="confirm_redirect('<?php echo $this->_var['lang']['drop_confirm']; ?>', 'customer.php?act=remove&id=<?php echo $this->_var['item']['cus_id']; ?>')" title="<?php echo $this->_var['lang']['remove']; ?>">
						<img src="images/icon_drop.gif" border="0" height="16" width="16" />
					</a>
				</td>
			</tr>
			<?php endforeach; else: ?>
			<tr>
				<td class="no-records" colspan="10"><?php echo $this->_var['lang']['no_records']; ?></td>
			</tr>
			<?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
		</table>
		<table cellpadding="4" cellspacing="0">
			<tr>
				<td>
					<input type="submit" name="drop" id="btnSubmit" value="<?php echo $this->_var['lang']['drop']; ?>" class="button" disabled="true" />
				</td>
				<td align="right"><?php echo $this->fetch('page.htm'); ?></td>
			</tr>
		</table>
		<?php if ($this->_var['full_page']): ?>
	</div>
	<!-- end pre_sale list -->
</form>
<script type="text/javascript" >

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

    //startCheckOrder();
  }

  /**
   * 搜索团购活动
   */
  function searchGroupBuy()
  {

    var keyword = Utils.trim(document.forms['searchForm'].elements['keyword'].value);
    listTable.filter['keyword'] = keyword;
    listTable.filter['page'] = 1;
    listTable.loadList("customer_list");
  }
  

</script>
<?php echo $this->fetch('pagefooter.htm'); ?> <?php endif; ?>
