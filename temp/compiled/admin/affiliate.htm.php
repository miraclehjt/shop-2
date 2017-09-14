<?php if ($this->_var['full_page']): ?>
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'validator.js')); ?>
<div class="affiliate-div">
<form method="post" action="affiliate.php" style="height:30px;line-height:30px; ">
<input type="radio" name="on" value="1" <?php if ($this->_var['config']['on'] == 1): ?> checked="true" <?php endif; ?> onClick="javascript:actDiv('separate','');actDiv('btnon','none');" ><?php echo $this->_var['lang']['on']; ?>
<input type="radio" name="on" value="0" <?php if (! $this->_var['config']['on'] || $this->_var['config']['on'] == 0): ?> checked="true" <?php endif; ?> onClick="javascript:actDiv('separate','none');actDiv('btnon','');" style="vertical-align:none"><?php echo $this->_var['lang']['off']; ?>
<input type="hidden" name="act" value="on" />
<input type="submit" value="<?php echo $this->_var['lang']['button_submit']; ?>" class="button" id="btnon"/>
</form>
</div>
<div id="separate">
<div class="affiliate-div">
<form method="post" action="affiliate.php">
            <table width="100%" border="0" cellspacing="0" cellpadding="4">
                <tr>
                    <td colspan="2" style="border-bottom:1px dashed #dadada;"><input type="radio" name="separate_by" value="0" <?php if (! $this->_var['config']['config']['separate_by'] || $this->_var['config']['config']['separate_by'] == 0): ?> checked="true" <?php endif; ?> onClick="actDiv('listDiv','');">
                    <?php echo $this->_var['lang']['separate_by']['0']; ?></td>
                </tr>
                <tr>
                    <td width="20%" align="right" class="label"><a href="javascript:showNotice('notice1');" title="<?php echo $this->_var['lang']['form_notice']; ?>"><img src="images/notice.gif" width="16" height="16" border="0" alt="<?php echo $this->_var['lang']['form_notice']; ?>" /></a><?php echo $this->_var['lang']['expire']; ?> </td>
                    <td><input type="text" name="expire" maxlength="150" size="10" value="<?php echo $this->_var['config']['config']['expire']; ?>" />
                        <select name="expire_unit">
                            <?php echo $this->html_options(array('options'=>$this->_var['lang']['unit'],'selected'=>$this->_var['config']['config']['expire_unit'])); ?>
                        </select>
                        <br />
                        <span class="notice-span" <?php if ($this->_var['help_open']): ?>style="display:block" <?php else: ?> style="display:none" <?php endif; ?> id="notice1"><?php echo nl2br($this->_var['lang']['help_expire']); ?></span>                        
                        </td>
                </tr>
                <tr>
                    <td align="right" class="label"><a href="javascript:showNotice('notice2');" title="<?php echo $this->_var['lang']['form_notice']; ?>"><img src="images/notice.gif" width="16" height="16" border="0" alt="<?php echo $this->_var['lang']['form_notice']; ?>" /></a><?php echo $this->_var['lang']['level_point_all']; ?> </td>
                    <td><input type="text" name="level_point_all" maxlength="150" size="10" value="<?php echo $this->_var['config']['config']['level_point_all']; ?>" />
                    <br />
                    <span class="notice-span" <?php if ($this->_var['help_open']): ?>style="display:block" <?php else: ?> style="display:none" <?php endif; ?> id="notice2"><?php echo nl2br($this->_var['lang']['help_lpa']); ?></span></td>
                </tr>
                <tr>
                    <td align="right" class="label"><a href="javascript:showNotice('notice3');" title="<?php echo $this->_var['lang']['form_notice']; ?>"><img src="images/notice.gif" width="16" height="16" border="0" alt="<?php echo $this->_var['lang']['form_notice']; ?>" /></a><?php echo $this->_var['lang']['level_money_all']; ?> </td>
                    <td><input type="text" name="level_money_all" maxlength="150" size="10" value="<?php echo $this->_var['config']['config']['level_money_all']; ?>" />
                    <br />
                    <span class="notice-span" <?php if ($this->_var['help_open']): ?>style="display:block" <?php else: ?> style="display:none" <?php endif; ?> id="notice3"><?php echo nl2br($this->_var['lang']['help_lma']); ?></span></td>
                </tr>
                <tr>
                    <td align="right" class="label"><a href="javascript:showNotice('notice4');" title="<?php echo $this->_var['lang']['form_notice']; ?>"><img src="images/notice.gif" width="16" height="16" border="0" alt="<?php echo $this->_var['lang']['form_notice']; ?>" /></a><?php echo $this->_var['lang']['level_register_all']; ?></td>
                    <td><input type="text" name="level_register_all" maxlength="150" size="10" value="<?php echo $this->_var['config']['config']['level_register_all']; ?>" />
                    <br />
                    <span class="notice-span" <?php if ($this->_var['help_open']): ?>style="display:block" <?php else: ?> style="display:none" <?php endif; ?> id="notice4"><?php echo nl2br($this->_var['lang']['help_lra']); ?></span></td>
                </tr>
                <tr>
                    <td align="right" class="label"><a href="javascript:showNotice('notice5');" title="<?php echo $this->_var['lang']['form_notice']; ?>"><img src="images/notice.gif" width="16" height="16" border="0" alt="<?php echo $this->_var['lang']['form_notice']; ?>" /></a><?php echo $this->_var['lang']['level_register_up']; ?></td>
                    <td><input type="text" name="level_register_up" maxlength="150" size="10" value="<?php echo $this->_var['config']['config']['level_register_up']; ?>" />
                    <br />
                    <span class="notice-span" <?php if ($this->_var['help_open']): ?>style="display:block" <?php else: ?> style="display:none" <?php endif; ?> id="notice5"><?php echo nl2br($this->_var['lang']['help_lru']); ?></span></td>
                <tr><td></td>
                    <td><input type="hidden" name="act" value="updata" /><input type="submit" value="<?php echo $this->_var['lang']['button_submit']; ?>" class="button" /></td>
                </tr>
                </tr>
            </table>
    </form>
</div>
<div class="list-div" id="listDiv">
<?php endif; ?>
<table cellspacing='1' cellpadding='3'>
	<tr>
		<th name="levels" ReadOnly="true" width="10%"><?php echo $this->_var['lang']['levels']; ?></th>
		<th name="level_point" Type="TextBox"><?php echo $this->_var['lang']['level_point']; ?></th>
		<th name="level_money" Type="TextBox"><?php echo $this->_var['lang']['level_money']; ?></th>
		<th Type="Button"><?php echo $this->_var['lang']['handler']; ?></th>
	</tr>
<?php $_from = $this->_var['config']['item']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'val');$this->_foreach['nav'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['nav']['total'] > 0):
    foreach ($_from AS $this->_var['val']):
        $this->_foreach['nav']['iteration']++;
?>
<tr align="center">
	<td><?php echo $this->_foreach['nav']['iteration']; ?></td>
	<td><span onclick="listTable.edit(this, 'edit_point', '<?php echo $this->_foreach['nav']['iteration']; ?>'); return false;"><?php echo $this->_var['val']['level_point']; ?></span></td>
	<td><span onclick="listTable.edit(this, 'edit_money', '<?php echo $this->_foreach['nav']['iteration']; ?>'); return false;"><?php echo $this->_var['val']['level_money']; ?></span></td>
	<td ><a href="javascript:confirm_redirect(lang_removeconfirm, 'affiliate.php?act=del&id=<?php echo $this->_foreach['nav']['iteration']; ?>')"><img style="border:0px;" src="images/no.gif" /></a></td>
</tr>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</table>
<?php if ($this->_var['full_page']): ?>
</div>
</div>
<script type="Text/Javascript" language="JavaScript">
<!--
<?php if (! $this->_var['config']['on'] || $this->_var['config']['on'] == 0): ?>
actDiv('separate','none');
<?php else: ?>
actDiv('btnon','none');
<?php endif; ?>
<?php if ($this->_var['config']['config']['separate_by'] == 1): ?>
actDiv('listDiv','none');
<?php endif; ?>

var all_null = '<?php echo $this->_var['lang']['all_null']; ?>';

onload = function()
{
  // 开始检查订单
  startCheckOrder();
  cleanWhitespace(document.getElementById("listDiv"));
  if (document.getElementById("listDiv").childNodes[0].rows.length<6)
  {
    listTable.addRow(check);
  }
  
}
function check(frm)
{
  if (frm['level_point'].value == "" && frm['level_money'].value == "")
  {
     frm['level_point'].focus();
     alert(all_null);
     return false;  
  }
  
  return true;
}
function actDiv(divname, flag)
{
    document.getElementById(divname).style.display = flag;
}

//-->
</script>
<?php echo $this->fetch('pagefooter.htm'); ?>
<?php endif; ?>