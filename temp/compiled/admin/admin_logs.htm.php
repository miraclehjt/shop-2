<!-- $Id: admin_logs.htm 15477 2008-12-22 03:44:50Z Shadow & 鸿宇 -->

<?php if ($this->_var['full_page']): ?>
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>

<div class="form-div">
<table>
    <tr>
      <td width="50%">
      <form name="theForm" method="POST" action="admin_logs.php">
      <?php echo $this->_var['lang']['view_ip']; ?>
      <select name="ip">
      <option value='0'><?php echo $this->_var['lang']['select_ip']; ?></option>
      <?php echo $this->html_options(array('options'=>$this->_var['ip_list'],'selected'=>$this->_var['ip'])); ?>
      </select>
      <input type="submit" value="<?php echo $this->_var['lang']['comfrom']; ?>" class="button" />
      </form>
      </td>
      <td>
      <form name="Form2" action="admin_logs.php?act=batch_drop" method="POST">
      <?php echo $this->_var['lang']['drop_logs']; ?>
      <select name="log_date">
        <option value='0'><?php echo $this->_var['lang']['select_date']; ?></option>
        <option value='1'><?php echo $this->_var['lang']['week_date']; ?></option>
        <option value='2'><?php echo $this->_var['lang']['month_date']; ?></option>
        <option value='3'><?php echo $this->_var['lang']['three_month']; ?></option>
        <option value='4'><?php echo $this->_var['lang']['six_month']; ?></option>
        <option value='5'><?php echo $this->_var['lang']['a_yaer']; ?></option>
      </select>
      <input name="drop_type_date" type="submit" value="<?php echo $this->_var['lang']['comfrom']; ?>" class="button" />
      </form>
      </td>
    </tr>
</table>
</div>

<form method="POST" action="admin_logs.php?act=batch_drop" name="listForm">
<!-- start admin_logs list -->
<div class="list-div" id="listDiv">
<?php endif; ?>

<table cellpadding="3" cellspacing="1">
  <tr>
    <th><input onclick='listTable.selectAll(this, "checkboxes")' type="checkbox">
    <a href="javascript:listTable.sort('log_id'); "><?php echo $this->_var['lang']['log_id']; ?></a><?php echo $this->_var['sort_log_id']; ?></th>
    <th><a href="javascript:listTable.sort('user_id'); "><?php echo $this->_var['lang']['user_id']; ?></a><?php echo $this->_var['sort_user_id']; ?></th>
    <th><a href="javascript:listTable.sort('log_time'); "><?php echo $this->_var['lang']['log_time']; ?></a><?php echo $this->_var['sort_log_time']; ?></th>
    <th><a href="javascript:listTable.sort('ip_address'); "><?php echo $this->_var['lang']['ip_address']; ?></a><?php echo $this->_var['sort_ip_address']; ?></th>
    <th><?php echo $this->_var['lang']['log_info']; ?></th>
  </tr>
  <?php $_from = $this->_var['log_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
  <tr>
    <td width="10%"><span><input name="checkboxes[]" type="checkbox" value="<?php echo $this->_var['list']['log_id']; ?>" /><?php echo $this->_var['list']['log_id']; ?></span></td>
    <td width="15%" class="first-cell"><span><?php echo htmlspecialchars($this->_var['list']['user_name']); ?></span></td>
    <td width="20%" align="center"><span><?php echo $this->_var['list']['log_time']; ?></span></td>
    <td width="15%" align="left"><span><?php echo $this->_var['list']['ip_address']; ?></span></td>
    <td width="40%" align="left"><span><?php echo $this->_var['list']['log_info']; ?></span></td>
  </tr>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  <tr>
    <td colspan="2"><input name="drop_type_id" type="submit" id="btnSubmit" value="<?php echo $this->_var['lang']['drop_logs']; ?>" disabled="true" class="button" /></td>
    <td align="right" nowrap="true" colspan="10"><?php echo $this->fetch('page.htm'); ?></td>
  </tr>
</table>

<?php if ($this->_var['full_page']): ?>
</div>
<!-- end ad_position list -->

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
    // &#65533;&#65533;&#700;&#65533;&#65533;鹜&#65533;&#65533;
    startCheckOrder();
  }
  
</script>
<?php echo $this->fetch('pagefooter.htm'); ?>
<?php endif; ?>
