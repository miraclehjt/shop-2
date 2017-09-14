<?php if ($this->_var['full_page']): ?>
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>

<form method="post" action="" name="listForm">
<!-- start reg_fiedls list -->
<div class="list-div" id="listDiv">
<?php endif; ?>

<table cellspacing='1' id="list-table">
  <tr>
    <th><?php echo $this->_var['lang']['field_name']; ?></th>
    <th><?php echo $this->_var['lang']['field_order']; ?></th>
    <th><?php echo $this->_var['lang']['field_display']; ?></th>
    <th><?php echo $this->_var['lang']['field_need']; ?></th>
    <th><?php echo $this->_var['lang']['handler']; ?></th>
  </tr>
  <?php $_from = $this->_var['reg_fields']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'field');if (count($_from)):
    foreach ($_from AS $this->_var['field']):
?>
  <tr>
    <td class="first-cell" ><span onclick="listTable.edit(this,'edit_name', <?php echo $this->_var['field']['id']; ?>)"><?php echo $this->_var['field']['reg_field_name']; ?></span></td>
    <td align="center"><span onclick="listTable.edit(this,'edit_order', <?php echo $this->_var['field']['id']; ?>)"><?php echo $this->_var['field']['dis_order']; ?></span></td>
    <td align="center"><img src="images/<?php if ($this->_var['field']['display']): ?>yes<?php else: ?>no<?php endif; ?>.gif" onclick="listTable.toggle(this, 'toggle_dis', <?php echo $this->_var['field']['id']; ?>)" /></td>
    <td align="center"><img src="images/<?php if ($this->_var['field']['is_need']): ?>yes<?php else: ?>no<?php endif; ?>.gif" onclick="listTable.toggle(this, 'toggle_need', <?php echo $this->_var['field']['id']; ?>)" /></td>
    <td align="center"><a href="?act=edit&id=<?php echo $this->_var['field']['id']; ?>"><?php echo $this->_var['lang']['edit']; ?></a><?php if ($this->_var['field']['type'] == 0): ?> | <a href="javascript:;" onclick="listTable.remove(<?php echo $this->_var['field']['id']; ?>, '<?php echo $this->_var['lang']['drop_confirm']; ?>')" title="<?php echo $this->_var['lang']['remove']; ?>"><?php echo $this->_var['lang']['remove']; ?></a><?php endif; ?></td>
  </tr>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  </table>

<?php if ($this->_var['full_page']): ?>
</div>
<!-- end reg_fiedls list -->
</form>
<script type="Text/Javascript" language="JavaScript">
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
