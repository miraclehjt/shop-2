<!-- $Id: shipping_list.htm 17043 2010-02-26 10:40:02Z sxc_shop $ -->
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>
<!-- start payment list -->
<div class="list-div" id="listDiv">
<?php $_from = $this->_var['modules']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'value');if (count($_from)):
    foreach ($_from AS $this->_var['value']):
?>
<?php if ($this->_var['value']['shiplist']): ?>
<div class="shipping_list">
<h3><?php echo $this->_var['value']['name']; ?><span><?php echo $this->_var['value']['desc']; ?></span></h3>
<table cellspacing='0' cellpadding='3' class="shipping_list_th">
  <tr>
    <th width="15%"><?php echo $this->_var['lang']['shipping_name']; ?></th>
    <th width="35%"><?php echo $this->_var['lang']['shipping_desc']; ?></th>
    <!-- <th nowrap="true"><?php echo $this->_var['lang']['insure']; ?></th> -->
    <th width="10%"><?php echo $this->_var['lang']['support_cod']; ?></th>
    <!-- <th nowrap="true"><?php echo $this->_var['lang']['support_pickup']; ?></th>
    <th nowrap="true"><?php echo $this->_var['lang']['shipping_version']; ?></th>
    <th><?php echo $this->_var['lang']['shipping_author']; ?></th> -->
    <th width="5%"><?php echo $this->_var['lang']['sort_order']; ?></th>
    <th width="25%"><?php echo $this->_var['lang']['handler']; ?></th>
  </tr>
</table>
<table cellspacing='0' cellpadding='3' class="module">
  <?php $_from = $this->_var['value']['shiplist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'module');if (count($_from)):
    foreach ($_from AS $this->_var['module']):
?>
  <tr>
    <td class="first-cell"  width="15%" align="center">
      <?php if ($this->_var['module']['install'] == 1): ?>
      <span onclick="listTable.edit(this, 'edit_name', '<?php echo $this->_var['module']['code']; ?>'); return false;"><?php echo $this->_var['module']['name']; ?></span>
      <?php else: ?>
      <?php echo $this->_var['module']['name']; ?>
      <?php endif; ?>
    </td>
    <td width="35%">
      <?php if ($this->_var['module']['install'] == 1): ?>
      <span onclick="listTable.edit(this, 'edit_desc', '<?php echo $this->_var['module']['code']; ?>'); return false;"><?php echo $this->_var['module']['desc']; ?></span>
      <?php else: ?>
      <?php echo $this->_var['module']['desc']; ?>
      <?php endif; ?>
    </td>
    <!-- <td align="right">
      <?php if ($this->_var['module']['install'] == 1 && $this->_var['module']['is_insure'] != 0): ?>
      <span onclick="listTable.edit(this, 'edit_insure', '<?php echo $this->_var['module']['code']; ?>'); return false;"><?php echo $this->_var['module']['insure_fee']; ?></span>
      <?php else: ?>
      <?php echo $this->_var['module']['insure_fee']; ?>
      <?php endif; ?>
    </td> -->
    <td align='center' width="10%"><?php if ($this->_var['module']['cod'] == 1): ?><?php echo $this->_var['lang']['yes']; ?><?php else: ?><?php echo $this->_var['lang']['no']; ?><?php endif; ?></td>
    <!-- <td align='center'><?php if ($this->_var['module']['pickup'] == 1): ?><?php echo $this->_var['lang']['yes']; ?><?php else: ?><?php echo $this->_var['lang']['no']; ?><?php endif; ?></td>
    <td nowrap="true"><?php echo $this->_var['module']['version']; ?></td>
    <td nowrap="true"><a href="<?php echo $this->_var['module']['website']; ?>" target="_blank"><?php echo $this->_var['module']['author']; ?></a></td> -->
    <td align="center" width="5%"> <?php if ($this->_var['module']['install'] == 1): ?> <span onclick="listTable.edit(this, 'edit_order', '<?php echo $this->_var['module']['code']; ?>'); return false;"><?php echo $this->_var['module']['shipping_order']; ?></span> <?php else: ?> &nbsp; <?php endif; ?> </td>
    <td align="center" width="25%">
      <?php if ($this->_var['module']['install'] == 1): ?>

	  <a href="javascript:confirm_redirect(lang_removeconfirm,'shipping.php?act=uninstall&code=<?php echo $this->_var['module']['code']; ?>')"><?php echo $this->_var['lang']['uninstall']; ?></a>
	  <?php if ($this->_var['module']['is_default_show']): ?>
      <span style="color:red"><?php echo $this->_var['lang']['defaultshow']; ?></span>
      <a href="shipping_area.php?act=list&shipping=<?php echo $this->_var['module']['id']; ?>"><?php echo $this->_var['lang']['shipping_area']; ?></a>
      <?php if ($this->_var['module']['code'] == 'pups'): ?>
      <a href="pickup_point.php?act=list"><?php echo $this->_var['lang']['shipping_pups']; ?></a>
      <?php endif; ?>
      <a href="shipping.php?act=edit_print_template&shipping=<?php echo $this->_var['module']['id']; ?>"><?php echo $this->_var['lang']['shipping_print_edit']; ?></a>
	  <?php else: ?>
	  
	  <a href="javascript:confirm_redirect(lang_isdefaultshowconfirm,'shipping.php?act=is_default_show&code=<?php echo $this->_var['module']['code']; ?>');"><?php echo $this->_var['lang']['isdefaultshow']; ?></a>
	  
	  <?php endif; ?>
      <?php else: ?>
      <a href="shipping.php?act=install&code=<?php echo $this->_var['module']['code']; ?>"><?php echo $this->_var['lang']['install']; ?></a>
      <?php endif; ?>
    </td>
  </tr>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</table>
</div>
<?php endif; ?>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</div>
<!-- end payment list -->
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