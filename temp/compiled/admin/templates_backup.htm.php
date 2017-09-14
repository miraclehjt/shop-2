<!-- $Id: templates_backup.htm 14216 2008-03-10 02:27:21Z testyang $ -->
<?php echo $this->fetch('pageheader.htm'); ?>
<!-- start templates list -->
<div class="list-div">
  <table width="100%" cellpadding="3" cellspacing="1">
  <tr><th><?php echo $this->_var['lang']['cur_setting_template']; ?></th></tr>
  <?php if ($this->_var['files']): ?>
  <tr><td>
    <form action="template.php" method="post" >
    <table style="background:none">
      <tr>
        <td colspan="2"><input type="checkbox" name="chkall" onclick="checkall(this.form, 'files[]')"><strong><?php echo $this->_var['lang']['select_all']; ?><strong></td>
      </tr>
      <tr>
      <?php $_from = $this->_var['files']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'file');$this->_foreach['template'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['template']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['file']):
        $this->_foreach['template']['iteration']++;
?>
      <?php if ($this->_foreach['template']['iteration'] > 1 && ( $this->_foreach['template']['iteration'] - 1 ) % 3 == 0): ?>
        </tr><tr>
      <?php endif; ?>
      <td><input type="checkbox" name="files[]" value="<?php echo $this->_var['key']; ?>" ><?php echo $this->_var['file']; ?></td>
      <?php if (($this->_foreach['template']['iteration'] == $this->_foreach['template']['total'])): ?>
        <?php if ($this->_foreach['template']['iteration'] % 3 == 0): ?>
          </tr>
        <?php elseif ($this->_foreach['template']['iteration'] % 3 == 1): ?>
          <td>&nbsp;</td><td>&nbsp;</td></tr>
        <?php else: ?>
           <td>&nbsp;</td></tr>
        <?php endif; ?>
      <?php endif; ?>
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      <tr>
        <td colspan="3" ><?php echo $this->_var['lang']['remarks']; ?>:&nbsp;&nbsp;<input type="text" name="remarks" size="40" /></td>
      </tr>
      <tr>
      <td colspan="3" /><input type="hidden" name="act" value="act_backup_setting" /><input type="submit" value="<?php echo $this->_var['lang']['backup_setting']; ?>" class="button" /><td>
      </tr>
    </table>
    </form>
  </td></tr>
  <?php else: ?>
  <tr><td colspan="2" align="center"><?php echo $this->_var['lang']['no_setting_template']; ?></td></tr>
  <?php endif; ?>
  <tr><th><?php echo $this->_var['lang']['cur_backup']; ?></th></tr>
  <?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'remarks');if (count($_from)):
    foreach ($_from AS $this->_var['remarks']):
?>
  <tr><td><span style="float:right"><a href="template.php?act=restore_backup&remarks=<?php echo $this->_var['remarks']['url']; ?>"><?php echo $this->_var['lang']['restore']; ?></a>&nbsp;&nbsp;<a href="template.php?act=del_backup&remarks=<?php echo $this->_var['remarks']['url']; ?>"><?php echo $this->_var['lang']['remove']; ?></a></span><?php echo $this->_var['remarks']['content']; ?></td></tr>
  <?php endforeach; else: ?>
  <tr><td colspan="2" align="center"><?php echo $this->_var['lang']['no_backup']; ?></td></tr>
  <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
  </table>
</div>
<!-- end templates list -->

<script language="JavaScript">
<!--


onload = function()
{
  // 开始检查订单
  startCheckOrder();
}

function checkall(frm, chk)
{
    for (i = 0; i < frm.elements.length; i++)
    {
        if (frm.elements[i].name == chk)
        {
            frm.elements[i].checked = frm.elements['chkall'].checked;
        }
    }
}

//-->

</script>
<?php echo $this->fetch('pagefooter.htm'); ?>