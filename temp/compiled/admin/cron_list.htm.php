<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>
<!-- start payment list -->
<div class="list-div" id="listDiv">
<table cellspacing='1' cellpadding='3'>
  <tr>
    <th width="13%"><?php echo $this->_var['lang']['cron_name']; ?></th>
    <th ><?php echo $this->_var['lang']['cron_desc']; ?></th>
    <th width="5%"><?php echo $this->_var['lang']['version']; ?></th>
    <th width="13%"><?php echo $this->_var['lang']['cron_author']; ?></th>
    <th width="16%"><?php echo $this->_var['lang']['cron_this']; ?></th>
    <th width="16%"><?php echo $this->_var['lang']['cron_next']; ?></th>
    <th width="3%"><?php echo $this->_var['lang']['if_open']; ?></th>
    <th width="12%"><?php echo $this->_var['lang']['handler']; ?></th>
  </tr>
  <?php $_from = $this->_var['modules']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'module');if (count($_from)):
    foreach ($_from AS $this->_var['module']):
?>
  <tr>
    <td class="first-cell" valign="top">
      <?php if ($this->_var['module']['install'] == 1): ?>
        <?php echo $this->_var['module']['name']; ?>
      <?php else: ?>
        <?php echo $this->_var['module']['name']; ?>
      <?php endif; ?>
    </td>
    <td><?php echo nl2br($this->_var['module']['desc']); ?></td>
    <td valign="top"><?php echo $this->_var['module']['version']; ?></td>
    <td valign="top"><a href="<?php echo $this->_var['module']['website']; ?>" target="_blank"><?php echo $this->_var['module']['author']; ?></a></td>
    <td align="center"><?php echo $this->_var['module']['thistime']; ?></td>
    <td align="center"><?php echo $this->_var['module']['nextime']; ?></td>

    <td align="center">
      <?php if ($this->_var['module']['install'] == "1"): ?>
        <img src="images/<?php if ($this->_var['module']['enable'] == 1): ?>yes<?php else: ?>no<?php endif; ?>.gif" onclick="listTable.toggle(this, 'toggle_show', '<?php echo $this->_var['module']['code']; ?>')" />
      <?php else: ?>－<?php endif; ?></td>
    <td align="center" valign="top">
      <?php if ($this->_var['module']['install'] == "1"): ?>
        <a href="javascript:confirm_redirect(lang_removeconfirm, 'cron.php?act=uninstall&code=<?php echo $this->_var['module']['code']; ?>')"><?php echo $this->_var['lang']['uninstall']; ?></a>|<a href="cron.php?act=edit&code=<?php echo $this->_var['module']['code']; ?>"><?php echo $this->_var['lang']['edit']; ?></a>|<a href="cron.php?act=do&code=<?php echo $this->_var['module']['code']; ?>"><?php echo $this->_var['lang']['cron_do']; ?></a>
      <?php else: ?>
        <a href="cron.php?act=install&code=<?php echo $this->_var['module']['code']; ?>"><?php echo $this->_var['lang']['install']; ?></a>
      <?php endif; ?>
    </td>
  </tr>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</table>
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