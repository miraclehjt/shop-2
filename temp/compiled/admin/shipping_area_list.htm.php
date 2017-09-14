<!-- $Id: shipping_area_list.htm 14216 2008-03-10 02:27:21Z testyang $ -->
<?php if ($this->_var['full_page']): ?>
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>
<!-- start shipping area list -->
<form method="post" action="shipping_area.php" name="listForm" onsubmit="return confirm('<?php echo $this->_var['lang']['remove_confirm']; ?>')">
<div class="list-div" id="listDiv">
<?php endif; ?>

<table cellspacing='1' cellpadding='3' id='listTable'>
  <tr>
    <th><input type="checkbox" onclick="listTable.selectAll(this, 'areas')" /><?php echo $this->_var['lang']['record_id']; ?></th>
    <th><?php echo $this->_var['lang']['shipping_area_name']; ?></th>
    <th><?php echo $this->_var['lang']['shipping_area_regions']; ?></th>
    <th><?php echo $this->_var['lang']['handler']; ?></th>
  </tr>

  <?php $_from = $this->_var['areas']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'area');if (count($_from)):
    foreach ($_from AS $this->_var['area']):
?>
  <tr>
    <td>
      <input type="checkbox" name="areas[]" value="<?php echo $this->_var['area']['shipping_area_id']; ?>" /><?php echo $this->_var['area']['shipping_area_id']; ?>
    </td>
    <td class="first-cell">
      <span onclick="listTable.edit(this, 'edit_area', '<?php echo $this->_var['area']['shipping_area_id']; ?>'); return false;"><?php echo htmlspecialchars($this->_var['area']['shipping_area_name']); ?></a>
    </td>
    <td><?php echo $this->_var['area']['shipping_area_regions']; ?></td>
    <td align="center">
      <a href="shipping_area.php?act=edit&id=<?php echo $this->_var['area']['shipping_area_id']; ?>"><?php echo $this->_var['lang']['edit']; ?></a> | <a href="javascript:;" onclick="listTable.remove(<?php echo $this->_var['area']['shipping_area_id']; ?>, '<?php echo $this->_var['lang']['remove_confirm']; ?>', 'remove_area')"><?php echo $this->_var['lang']['remove']; ?></a>
    </td>
  </tr>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

  <tr>
    <td colspan="4" align="center">
      <input type="hidden" name="act" value="multi_remove" />
      <input type="hidden" name="shipping" value="<?php echo $_GET['shipping']; ?>" />
      <input type="submit" value="<?php echo $this->_var['lang']['delete_selected']; ?>" disabled="true" id="btnSubmit" class="button" />
    </td>
  </tr>
</table>

<?php if ($this->_var['full_page']): ?>
</div>
</form>
<!-- end shipping area list -->

<script language="JavaScript">
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