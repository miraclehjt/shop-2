<!-- $Id: privilege_list.htm 14216 2008-03-10 02:27:21Z testyang $ -->

<?php if ($this->_var['full_page']): ?>
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>

<div class="list-div" id="listDiv">
<?php endif; ?>

<table cellspacing='1' cellpadding='3' id='list-table'>
  <tr>
    <th><?php echo $this->_var['lang']['user_name']; ?></th>
    <th><?php echo $this->_var['lang']['email']; ?></th>
    <th><?php echo $this->_var['lang']['join_time']; ?></th>
    <th><?php echo $this->_var['lang']['last_time']; ?></th>
    <th><?php echo $this->_var['lang']['handler']; ?></th>
  </tr>
  <?php $_from = $this->_var['admin_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
  <tr>
    <td class="first-cell" ><?php echo $this->_var['list']['user_name']; ?></td>
    <td align="left"><?php echo $this->_var['list']['email']; ?></td>
    <td align="center"><?php echo $this->_var['list']['add_time']; ?></td>
    <td align="center"><?php echo empty($this->_var['list']['last_login']) ? 'N/A' : $this->_var['list']['last_login']; ?></td>
    <td align="center">
      <a href="privilege.php?act=allot&id=<?php echo $this->_var['list']['user_id']; ?>&user=<?php echo $this->_var['list']['user_name']; ?>" title="<?php echo $this->_var['lang']['allot_priv']; ?>"><img src="images/icon_priv.gif" border="0" height="16" width="16"></a>&nbsp;&nbsp;
      <!--a href="admin_logs.php?act=list&id=<?php echo $this->_var['list']['user_id']; ?>" title="<?php echo $this->_var['lang']['view_log']; ?>"><img src="images/icon_view.gif" border="0" height="16" width="16"></a>&nbsp;&nbsp;-->
      <a href="privilege.php?act=edit&id=<?php echo $this->_var['list']['user_id']; ?>" title="<?php echo $this->_var['lang']['edit']; ?>"><img src="images/icon_edit.gif" border="0" height="16" width="16"></a>&nbsp;&nbsp;
      <a href="javascript:;" onclick="listTable.remove(<?php echo $this->_var['list']['user_id']; ?>, '<?php echo $this->_var['lang']['drop_confirm']; ?>')" title="<?php echo $this->_var['lang']['remove']; ?>"><img src="images/icon_drop.gif" border="0" height="16" width="16"></a></td>
  </tr>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</table>

<?php if ($this->_var['full_page']): ?>
</div>
<script type="text/javascript" language="JavaScript">
  
  onload = function()
  {
    // 开始检查订单
    startCheckOrder();
  }
  
</script>
<?php echo $this->fetch('pagefooter.htm'); ?>
<?php endif; ?>
