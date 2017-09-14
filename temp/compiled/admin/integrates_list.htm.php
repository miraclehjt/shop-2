<!-- $Id: integrates_list.htm 15716 2009-03-06 03:22:25Z Shadow & 鸿宇 -->
<?php echo $this->fetch('pageheader.htm'); ?>
<!-- start integrate plugins list -->
<div class="form-div">
  <?php echo $this->_var['lang']['user_help']; ?>
</div>
<div class="list-div" id="listDiv">
<table cellspacing='1' cellpadding='3'>
  <tr>
    <th><?php echo $this->_var['lang']['integrate_name']; ?></th>
    <th><?php echo $this->_var['lang']['integrate_version']; ?></th>
    <th><?php echo $this->_var['lang']['integrate_author']; ?></th>
    <th><?php echo $this->_var['lang']['handler']; ?></th>
  </tr>
  <?php $_from = $this->_var['modules']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'module');if (count($_from)):
    foreach ($_from AS $this->_var['module']):
?>
  <tr>
    <td class="first-cell"><?php echo $this->_var['module']['name']; ?></td>
    <td><?php echo $this->_var['module']['version']; ?></td>
    <td><a href="<?php echo $this->_var['module']['website']; ?>"><?php echo $this->_var['module']['author']; ?></a></td>
    <td align="center">
      <?php if ($this->_var['module']['installed'] == 1): ?>
      <a href="integrate.php?act=setup&code=<?php echo $this->_var['module']['code']; ?>"><?php echo $this->_var['lang']['setup']; ?></a><?php if ($this->_var['allow_set_points']): ?>&nbsp;<a href="integrate.php?act=points_set&code=<?php echo $this->_var['module']['code']; ?>"><?php echo $this->_var['lang']['points_set']; ?></a><?php endif; ?>
      <?php else: ?>
      <a <?php if ($this->_var['module']['code'] != "ecshop"): ?>href="javascript:confirm_redirect('<?php echo $this->_var['lang']['install_confirm']; ?>', 'integrate.php?act=install&code=<?php echo $this->_var['module']['code']; ?>')"<?php else: ?>href="integrate.php?act=install&code=<?php echo $this->_var['module']['code']; ?>" <?php endif; ?>><?php echo $this->_var['lang']['install']; ?></a>
      <?php endif; ?>
    </td>
  </tr>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</table>
</div>
<!-- end integrate plugins list -->

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