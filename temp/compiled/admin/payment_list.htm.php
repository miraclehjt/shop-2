<!-- $Id: payment_list.htm 15541 2009-01-08 10:29:01Z testyang $ -->
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>
<!-- start payment list -->
<div class="list-div" id="listDiv">
<table cellspacing='1' cellpadding='3'>
  <tr>
    <th><?php echo $this->_var['lang']['payment_name']; ?></th>
    <th width="40%"><?php echo $this->_var['lang']['payment_desc']; ?></th>
    <th><?php echo $this->_var['lang']['version']; ?></th>
    <th><?php echo $this->_var['lang']['payment_author']; ?></th>
    <th><?php echo $this->_var['lang']['short_pay_fee']; ?></th>
    <th><?php echo $this->_var['lang']['sort_order']; ?></th>
    <th><?php echo $this->_var['lang']['handler']; ?></th>
  </tr>
  <?php $_from = $this->_var['modules']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'module');if (count($_from)):
    foreach ($_from AS $this->_var['module']):
?>
  <?php if ($this->_var['module']['code'] != "tenpayc2c"): ?>
  <tr>
    <td class="first-cell" valign="top">
      <?php if ($this->_var['module']['install'] == 1): ?>
        <span onclick="listTable.edit(this, 'edit_name', '<?php echo $this->_var['module']['code']; ?>'); return false;"><?php echo $this->_var['module']['name']; ?></span>
      <?php else: ?>
        <?php echo $this->_var['module']['name']; ?>
      <?php endif; ?>
    </td>
    <td><?php echo nl2br($this->_var['module']['desc']); ?></td>
    <td valign="top"><?php echo $this->_var['module']['version']; ?></td>
    <td valign="top"><a href="<?php echo $this->_var['module']['website']; ?>"><?php echo $this->_var['module']['author']; ?></a></td>
    <td valign="top" align="right">
      <?php if ($this->_var['module']['is_cod']): ?><?php echo $this->_var['lang']['decide_by_ship']; ?>
      <?php else: ?>
        <?php if ($this->_var['module']['install'] == 1): ?>
          <span onclick="listTable.edit(this, 'edit_pay_fee', '<?php echo $this->_var['module']['code']; ?>'); return false;"><?php echo $this->_var['module']['pay_fee']; ?></span>
        <?php else: ?>
          <?php echo $this->_var['module']['pay_fee']; ?>
        <?php endif; ?>
      <?php endif; ?>
    </td>
    <td align="right" valign="top"> <?php if ($this->_var['module']['install'] == 1): ?> <span onclick="listTable.edit(this, 'edit_order', '<?php echo $this->_var['module']['code']; ?>'); return false;"><?php echo $this->_var['module']['pay_order']; ?></span> <?php else: ?> &nbsp; <?php endif; ?> </td>
    <td align="center" valign="top">
      <?php if ($this->_var['module']['install'] == "1"): ?>
      <?php if ($this->_var['module']['code'] == "tenpay"): ?>
        <a href="javascript:confirm_redirect(lang_removeconfirm, 'payment.php?act=uninstall&code=<?php echo $this->_var['module']['code']; ?>')"><?php echo $this->_var['lang']['uninstall']; ?><?php echo $this->_var['lang']['tenpay']; ?></a>
        <a href="payment.php?act=edit&code=<?php echo $this->_var['module']['code']; ?>"><?php echo $this->_var['lang']['edit']; ?></a><br />
          <?php if ($this->_var['tenpayc2c']['install'] == "1"): ?><a href="javascript:confirm_redirect(lang_removeconfirm, 'payment.php?act=uninstall&code=tenpayc2c')"><?php echo $this->_var['lang']['uninstall']; ?><?php echo $this->_var['lang']['tenpayc2c']; ?></a>
          <a href="payment.php?act=edit&code=tenpayc2c"><?php echo $this->_var['lang']['edit']; ?></a>
          <?php else: ?>
          <a href="payment.php?act=install&code=tenpayc2c"><?php echo $this->_var['lang']['install']; ?><?php echo $this->_var['lang']['tenpayc2c']; ?></a>
          <?php endif; ?>
        <?php else: ?>
          <a href="javascript:confirm_redirect(lang_removeconfirm, 'payment.php?act=uninstall&code=<?php echo $this->_var['module']['code']; ?>')"><?php echo $this->_var['lang']['uninstall']; ?></a>
          <a href="payment.php?act=edit&code=<?php echo $this->_var['module']['code']; ?>"><?php echo $this->_var['lang']['edit']; ?></a>
        <?php endif; ?>

      <?php else: ?>
          <?php if ($this->_var['module']['code'] == "tenpay"): ?>
          <a href="payment.php?act=install&code=<?php echo $this->_var['module']['code']; ?>"><?php echo $this->_var['lang']['install']; ?><?php echo $this->_var['lang']['tenpay']; ?> </a><br />
               <?php if ($this->_var['tenpayc2c']['install'] == "1"): ?>
            <a href="javascript:confirm_redirect(lang_removeconfirm, 'payment.php?act=uninstall&code=tenpayc2c')"><?php echo $this->_var['lang']['uninstall']; ?><?php echo $this->_var['lang']['tenpayc2c']; ?></a>
        <a href="payment.php?act=edit&code=tenpayc2c"><?php echo $this->_var['lang']['edit']; ?></a>

              <?php else: ?>
              <a href="payment.php?act=install&code=tenpayc2c"><?php echo $this->_var['lang']['install']; ?><?php echo $this->_var['lang']['tenpayc2c']; ?></a>
              <?php endif; ?>

           <?php else: ?>
           <a href="payment.php?act=install&code=<?php echo $this->_var['module']['code']; ?>"><?php echo $this->_var['lang']['install']; ?></a>
           <?php endif; ?>

      <?php endif; ?>
    </td>
  </tr><?php endif; ?>
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