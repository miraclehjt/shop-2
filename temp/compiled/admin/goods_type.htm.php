<!-- $Id: goods_type.htm 14216 2008-03-10 02:27:21Z testyang $ -->

<?php if ($this->_var['full_page']): ?>
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>

<form method="post" action="" name="listForm">
<!-- start goods type list -->
<div class="list-div" id="listDiv">
<?php endif; ?>

<table width="100%" cellpadding="3" cellspacing="1" id="listTable">
  <tr>
    <th><?php echo $this->_var['lang']['goods_type_name']; ?></th>
    <th><?php echo $this->_var['lang']['attr_groups']; ?></th>
    <th><?php echo $this->_var['lang']['attribute_number']; ?></th>
    <th><?php echo $this->_var['lang']['goods_type_status']; ?></th>
    <th><?php echo $this->_var['lang']['handler']; ?></th>
  </tr>
  <?php $_from = $this->_var['goods_type_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods_type');if (count($_from)):
    foreach ($_from AS $this->_var['goods_type']):
?>
  <tr>
    <td class="first-cell"><span onclick="javascript:listTable.edit(this, 'edit_type_name', <?php echo $this->_var['goods_type']['cat_id']; ?>)"><?php echo $this->_var['goods_type']['cat_name']; ?></span></td>
    <td><?php echo $this->_var['goods_type']['attr_group']; ?></td>
    <td align="right"><?php echo $this->_var['goods_type']['attr_count']; ?></td>
    <td align="center"><img src="images/<?php if ($this->_var['goods_type']['enabled']): ?>yes<?php else: ?>no<?php endif; ?>.gif" ></td>
    <td align="center">
      <a href="attribute.php?act=list&goods_type=<?php echo $this->_var['goods_type']['cat_id']; ?>" title="<?php echo $this->_var['lang']['attribute']; ?>"><?php echo $this->_var['lang']['attribute']; ?></a> |
      <a href="goods_type.php?act=edit&cat_id=<?php echo $this->_var['goods_type']['cat_id']; ?>" title="<?php echo $this->_var['lang']['edit']; ?>"><?php echo $this->_var['lang']['edit']; ?></a> |
      <a href="javascript:;" onclick="listTable.remove(<?php echo $this->_var['goods_type']['cat_id']; ?>, '<?php echo $this->_var['lang']['remove_confirm']; ?>')" title="<?php echo $this->_var['lang']['remove']; ?>"><?php echo $this->_var['lang']['remove']; ?></a>
    </td>
  </tr>
  <?php endforeach; else: ?>
    <tr><td class="no-records" colspan="10"><?php echo $this->_var['lang']['no_records']; ?></td></tr>
    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
    <tr>
      <td align="right" nowrap="true" colspan="6">
      <?php echo $this->fetch('page.htm'); ?>
      </td>
    </tr>
  </table>

<?php if ($this->_var['full_page']): ?>
</div>
<!-- end goods type list -->
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
    // 开始检查订单
    startCheckOrder();
  }

//-->
</script>


<?php echo $this->fetch('pagefooter.htm'); ?>
<?php endif; ?>
