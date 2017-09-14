<!-- $Id: goods_trash.htm 14216 2008-03-10 02:27:21Z testyang $ -->
<?php if ($this->_var['full_page']): ?>
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,../js/transport.org.js,listtable.js')); ?>

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
    <th><?php echo $this->_var['lang']['handler']; ?></th>
  <tr>
  <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
  <tr>
    <td><input type="checkbox" name="checkboxes[]" value="<?php echo $this->_var['goods']['goods_id']; ?>" /><?php echo $this->_var['goods']['goods_id']; ?></td>
    <td><?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?></td>
    <td><?php echo $this->_var['goods']['goods_sn']; ?></td>
    <td align="right"><?php echo $this->_var['goods']['shop_price']; ?></td>
    <td align="center">
      <a href="javascript:;" onclick="listTable.remove(<?php echo $this->_var['goods']['goods_id']; ?>, '<?php echo $this->_var['lang']['restore_goods_confirm']; ?>', 'restore_goods')"><?php echo $this->_var['lang']['restore']; ?></a>
   	  <a href="javascript:;" onclick="listTable.remove(<?php echo $this->_var['goods']['goods_id']; ?>, '<?php echo $this->_var['lang']['drop_goods_confirm']; ?>', 'drop_goods')"><?php echo $this->_var['lang']['drop']; ?></a>
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
    <td>
      <input type="hidden" name="act" value="batch" />
      <select name="type" id="selAction" onchange="changeAction()">
        <option value=""><?php echo $this->_var['lang']['select_please']; ?></option>
        <option value="restore"><?php echo $this->_var['lang']['restore']; ?></option>
        <option value="drop"><?php echo $this->_var['lang']['remove']; ?></option>
      </select>
      <select name="target_cat" style="display:none" onchange="checkIsLeaf(this)"><option value="0"><?php echo $this->_var['lang']['select_please']; ?></caption><?php echo $this->_var['cat_list']; ?></select>
      <input type="submit" value="<?php echo $this->_var['lang']['button_submit']; ?>" id="btnSubmit" name="btnSubmit" class="button" disabled="true" />
    </td>
    <td align="right" nowrap="true">
    <?php echo $this->fetch('page.htm'); ?>
    </td>
  </tr>
</table>
</div>

<?php if ($this->_var['full_page']): ?>
</form>

<script language="JavaScript">
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

  function confirmSubmit(frm, ext)
  {
    if (frm.elements['type'].value == 'restore')
    {
      
      return confirm("<?php echo $this->_var['lang']['restore_goods_confirm']; ?>");
      
    }
    else if (frm.elements['type'].value == 'drop')
    {
      
      return confirm("<?php echo $this->_var['lang']['batch_drop_confirm']; ?>");
      
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

      if (!document.getElementById('btnSubmit').disabled &&
          confirmSubmit(frm, false))
      {
          frm.submit();
      }
  }
  
</script>
<?php echo $this->fetch('pagefooter.htm'); ?>
<?php endif; ?>