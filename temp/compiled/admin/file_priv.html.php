<!-- $Id: file_priv.html 14216 2008-03-10 02:27:21Z testyang $ -->
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'validator.js')); ?>
<!-- start shipping area list -->
<div class="list-div" id="listDiv">

<table cellspacing='1' cellpadding='3' id='list-table'>
  <tr>
    <th><?php echo $this->_var['lang']['item']; ?></th>
    <th><?php echo $this->_var['lang']['read']; ?></th>
    <th><?php echo $this->_var['lang']['write']; ?></th>
    <th><?php echo $this->_var['lang']['modify']; ?></th>
  </tr>
  <?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
  <tr>
    <td width="250px"><?php echo $this->_var['item']['item']; ?></td>
    <td align="center"><?php if ($this->_var['item']['r'] > 0): ?><img src="images/yes.gif" width="14" height="14" alt="YES" /><?php else: ?><img src="images/no.gif" width="14" height="14" alt="NO" /><?php if ($this->_var['item']['err_msg']['w']): ?>&nbsp;<a href="javascript:showNotice('r_<?php echo $this->_var['key']; ?>');" title="<?php echo $this->_var['lang']['detail']; ?>">[<?php echo $this->_var['lang']['detail']; ?>]</a><br /><span class="notice-span" <?php if ($this->_var['help_open']): ?>style="display:block" <?php else: ?> style="display:none" <?php endif; ?> id="r_<?php echo $this->_var['key']; ?>"><?php $_from = $this->_var['item']['err_msg']['r']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'msg');if (count($_from)):
    foreach ($_from AS $this->_var['msg']):
?><?php echo $this->_var['msg']; ?><?php echo $this->_var['lang']['unread']; ?><br /><?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?></span><?php endif; ?><?php endif; ?></td>
    <td align="center"><?php if ($this->_var['item']['w'] > 0): ?><img src="images/yes.gif" width="14" height="14" alt="YES" /><?php else: ?><img src="images/no.gif" width="14" height="14" alt="NO" /><?php if ($this->_var['item']['err_msg']['w']): ?>&nbsp;<a href="javascript:showNotice('w_<?php echo $this->_var['key']; ?>');" title="<?php echo $this->_var['lang']['detail']; ?>">[<?php echo $this->_var['lang']['detail']; ?>]</a><br /><span class="notice-span" <?php if ($this->_var['help_open']): ?>style="display:block" <?php else: ?> style="display:none" <?php endif; ?> id="w_<?php echo $this->_var['key']; ?>"><?php $_from = $this->_var['item']['err_msg']['w']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'msg');if (count($_from)):
    foreach ($_from AS $this->_var['msg']):
?><?php echo $this->_var['msg']; ?><?php echo $this->_var['lang']['unwrite']; ?><br /><?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?></span><?php endif; ?><?php endif; ?></td>
    <td align="center"><?php if ($this->_var['item']['m'] > 0): ?><img src="images/yes.gif" width="14" height="14" alt="YES" /><?php else: ?><img src="images/no.gif" width="14" height="14" alt="NO" /><?php if ($this->_var['item']['err_msg']['m']): ?>&nbsp;<a href="javascript:showNotice('m_<?php echo $this->_var['key']; ?>');" title="<?php echo $this->_var['lang']['detail']; ?>">[<?php echo $this->_var['lang']['detail']; ?>]</a><br /><span class="notice-span" <?php if ($this->_var['help_open']): ?>style="display:block" <?php else: ?> style="display:none" <?php endif; ?> id="m_<?php echo $this->_var['key']; ?>"><?php $_from = $this->_var['item']['err_msg']['m']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'msg');if (count($_from)):
    foreach ($_from AS $this->_var['msg']):
?><?php echo $this->_var['msg']; ?><?php echo $this->_var['lang']['unmodify']; ?><br /><?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?></span><?php endif; ?><?php endif; ?></td>
  </tr>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  <?php if ($this->_var['tpl_msg']): ?>
  <tr>
    <td colspan="4"><img src="images/no.gif" width="14" height="14" alt="NO" /><span style="color:red"><?php echo $this->_var['tpl_msg']; ?></span><?php echo $this->_var['lang']['unrename']; ?></td>
  </tr>
  <?php endif; ?>
</table>

</div>


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
