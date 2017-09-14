<!-- $Id: goods_list.htm 17126 2010-04-23 10:30:26Z liuhui $ -->

<?php if ($this->_var['full_page']): ?>
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>

<!-- 商品搜索 -->
<?php echo $this->fetch('goods_search.htm'); ?>
<!-- 商品列表 -->
<form method="post" action="" name="listForm" onsubmit="return confirmSubmit(this)">
  <!-- start goods list -->
  <div class="list-div" id="listDiv">
<?php endif; ?>
<table cellpadding="3" cellspacing="1">
  <tr>
    <th>
      <input onclick='listTable.selectAll(this, "checkboxes")' type="checkbox" />
      <a href="javascript:listTable.sort('goods_id'); "><?php echo $this->_var['lang']['record_id']; ?></a><?php echo $this->_var['sort_goods_id']; ?>
    </th>
    <th><a href="javascript:listTable.sort('goods_name'); "><?php echo $this->_var['lang']['goods_name']; ?></a><?php echo $this->_var['sort_goods_name']; ?></th>
    <th><a href="javascript:listTable.sort('goods_sn'); "><?php echo $this->_var['lang']['goods_sn']; ?></a><?php echo $this->_var['sort_goods_sn']; ?></th>
    <th><a href="javascript:listTable.sort('shop_price'); "><?php echo $this->_var['lang']['shop_price']; ?></a><?php echo $this->_var['sort_shop_price']; ?></th>
    <th><a href="javascript:listTable.sort('is_on_sale'); "><?php echo $this->_var['lang']['is_on_sale']; ?></a><?php echo $this->_var['sort_is_on_sale']; ?></th>
    
    <?php if ($this->_var['use_storage']): ?>
    <th><a href="javascript:listTable.sort('goods_number'); "><?php echo $this->_var['lang']['goods_number']; ?></a><?php echo $this->_var['sort_goods_number']; ?></th>
    <?php endif; ?>
    <th>标签</th> <!-- 晒单插件 增加 by bbs.hongyuvip.com -->
    <th><?php echo $this->_var['lang']['handler']; ?></th>
  <tr>
  <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
  <tr>
    <td><input type="checkbox" name="checkboxes[]" value="<?php echo $this->_var['goods']['goods_id']; ?>" /><?php echo $this->_var['goods']['goods_id']; ?></td>
    <td class="first-cell" style="<?php if ($this->_var['goods']['is_promote']): ?>color:red;<?php endif; ?>"><span onclick="listTable.edit(this, 'edit_goods_name', <?php echo $this->_var['goods']['goods_id']; ?>)"><?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?></span></td>
    <td><span onclick="listTable.edit(this, 'edit_goods_sn', <?php echo $this->_var['goods']['goods_id']; ?>)"><?php echo $this->_var['goods']['goods_sn']; ?></span></td>
    <td align="right"><span onclick="listTable.edit(this, 'edit_goods_price', <?php echo $this->_var['goods']['goods_id']; ?>)"><?php echo $this->_var['goods']['shop_price']; ?>

    </span></td>
    <td align="center"><img src="images/<?php if ($this->_var['goods']['is_on_sale']): ?>yes<?php else: ?>no<?php endif; ?>.gif" onclick="listTable.toggle(this, 'toggle_on_sale', <?php echo $this->_var['goods']['goods_id']; ?>)" /></td>
    
    <?php if ($this->_var['use_storage']): ?>
    <td align="right"><span onclick="listTable.edit(this, 'edit_goods_number', <?php echo $this->_var['goods']['goods_id']; ?>)"><?php echo $this->_var['goods']['goods_number']; ?></span></td>
    <?php endif; ?>
    <td align="center"><a href="goods_tag.php?act=list&goods_id=<?php echo $this->_var['goods']['goods_id']; ?>" target="_blank">标签</a></td> <!-- 晒单插件 增加 by bbs.hongyuvip.com -->
    <td align="center">
      <a href="../goods.php?id=<?php echo $this->_var['goods']['goods_id']; ?>" target="_blank" title="<?php echo $this->_var['lang']['view']; ?>"><img src="images/icon_view.gif" width="16" height="16" border="0" /></a>
      <a href="goods.php?act=edit&goods_id=<?php echo $this->_var['goods']['goods_id']; ?><?php if ($this->_var['code'] != 'real_goods'): ?>&supplier_status=<?php echo $_REQUEST['supplier_status']; ?>&extension_code=<?php echo $this->_var['code']; ?><?php endif; ?>" title="<?php echo $this->_var['lang']['edit']; ?>"><img src="images/icon_edit.gif" width="16" height="16" border="0" /></a>
      <a href="goods.php?act=copy&goods_id=<?php echo $this->_var['goods']['goods_id']; ?><?php if ($this->_var['code'] != 'real_goods'): ?>&extension_code=<?php echo $this->_var['code']; ?><?php endif; ?>" title="<?php echo $this->_var['lang']['copy']; ?>"><img src="images/icon_copy.gif" width="16" height="16" border="0" /></a>
      <a href="javascript:;" onclick="listTable.remove(<?php echo $this->_var['goods']['goods_id']; ?>, '<?php echo $this->_var['lang']['trash_goods_confirm']; ?>')" title="<?php echo $this->_var['lang']['trash']; ?>"><img src="images/icon_trash.gif" width="16" height="16" border="0" /></a>
      <?php if ($this->_var['specifications'] [ $this->_var['goods']['goods_type'] ] != ''): ?><a href="goods.php?act=product_list&goods_id=<?php echo $this->_var['goods']['goods_id']; ?>&supplier_status=<?php echo $_REQUEST['supplier_status']; ?>" title="<?php echo $this->_var['lang']['item_list']; ?>"><img src="images/icon_docs.gif" width="16" height="16" border="0" /></a><?php else: ?><img src="images/empty.gif" width="16" height="16" border="0" /><?php endif; ?>
      <?php if ($this->_var['add_handler']): ?>
        |
        <?php $_from = $this->_var['add_handler']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'handler');if (count($_from)):
    foreach ($_from AS $this->_var['handler']):
?>
        <a href="<?php echo $this->_var['handler']['url']; ?>&goods_id=<?php echo $this->_var['goods']['goods_id']; ?>" title="<?php echo $this->_var['handler']['title']; ?>"><img src="images/<?php echo $this->_var['handler']['img']; ?>" width="16" height="16" border="0" /></a>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      <?php endif; ?>
      <a href="getTaoBaoGoods.php?gid=<?php echo $this->_var['goods']['goods_id']; ?>"><img src="images/comment_icon.png" border="0" width="21" height="18" /></a>
    </td>
  </tr>
  <?php endforeach; else: ?>
  <tr><td class="no-records" colspan="10"><?php echo $this->_var['lang']['no_records']; ?></td></tr>
  <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
</table>
<!-- end goods list -->

<!-- 分页 -->
<table id="page-table" cellspacing="0">
  <tr>
    <td align="right" nowrap="true">
    <?php echo $this->fetch('page.htm'); ?>
    </td>
  </tr>
</table>

<?php if ($this->_var['full_page']): ?>
</div>

<div>
  <input type="hidden" name="act" value="batch" />
  <input type="hidden" name="supplier_status" value="<?php echo $this->_var['supplier_status']; ?>" />
  <select name="type" id="selAction" onchange="changeAction()">
    <option value=""><?php echo $this->_var['lang']['select_please']; ?></option>
    <option value="trash"><?php echo $this->_var['lang']['trash']; ?></option>
    <?php if ($this->_var['supplier_status'] == '1'): ?>
    <option value="on_sale"><?php echo $this->_var['lang']['on_sale']; ?></option>
    <option value="not_on_sale"><?php echo $this->_var['lang']['not_on_sale']; ?></option>   
    <?php endif; ?>
	   
  </select>
  <select name="target_cat" style="display:none">
    <option value="0"><?php echo $this->_var['lang']['select_please']; ?></option><?php echo $this->_var['cat_list']; ?>
  </select>
	<?php if ($this->_var['suppliers_list'] > 0): ?>
  <!--二级主菜单：转移供货商-->
  <select name="suppliers_id" style="display:none">
    <option value="-1"><?php echo $this->_var['lang']['select_please']; ?></option>
    <option value="0"><?php echo $this->_var['lang']['lab_to_shopex']; ?></option>
    <?php $_from = $this->_var['suppliers_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'sl');$this->_foreach['sln'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['sln']['total'] > 0):
    foreach ($_from AS $this->_var['sl']):
        $this->_foreach['sln']['iteration']++;
?>
      <option value="<?php echo $this->_var['sl']['suppliers_id']; ?>"><?php echo $this->_var['sl']['suppliers_name']; ?></option>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  </select>
  <!--end!-->
	<?php endif; ?>  
  <?php if ($this->_var['code'] != 'real_goods'): ?>
  <input type="hidden" name="extension_code" value="<?php echo $this->_var['code']; ?>" />
  <?php endif; ?>
  <input type="submit" value="<?php echo $this->_var['lang']['button_submit']; ?>" id="btnSubmit" name="btnSubmit" class="button" disabled="true" />
</div>
</form>

<script type="text/javascript">
  listTable.recordCount = <?php echo $this->_var['record_count']; ?>;
  listTable.pageCount = <?php echo $this->_var['page_count']; ?>;

  <?php $_from = $this->_var['filter']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
  listTable.filter.<?php echo $this->_var['key']; ?> = '<?php echo $this->_var['item']; ?>';
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

  
  onload = function()
  {
    startCheckOrder(); // 开始检查订单
    document.forms['listForm'].reset();
  }

  /**
   * @param: bool ext 其他条件：用于转移分类
   */
  function confirmSubmit(frm, ext)
  {
      if (frm.elements['type'].value == 'trash')
      {
          return confirm(batch_trash_confirm);
      }
      else if (frm.elements['type'].value == 'not_on_sale')
      {
          return confirm(batch_no_on_sale);
      }
      else if (frm.elements['type'].value == 'move_to')
      {
          ext = (ext == undefined) ? true : ext;
          return ext && frm.elements['target_cat'].value != 0;
      }
      else if (frm.elements['type'].value == '')
      {
          return false;
      }
      else
      {
          return true;
      }
  }

  function changeAction()
  {
      var frm = document.forms['listForm'];

      // 切换分类列表的显示
      frm.elements['target_cat'].style.display = frm.elements['type'].value == 'move_to' ? '' : 'none';
			
			<?php if ($this->_var['suppliers_list'] > 0): ?>
      frm.elements['suppliers_id'].style.display = frm.elements['type'].value == 'suppliers_move_to' ? '' : 'none';
			<?php endif; ?>

      if (!document.getElementById('btnSubmit').disabled &&
          confirmSubmit(frm, false))
      {
          frm.submit();
      }
  }

</script>
<?php echo $this->fetch('pagefooter.htm'); ?>
<?php endif; ?>