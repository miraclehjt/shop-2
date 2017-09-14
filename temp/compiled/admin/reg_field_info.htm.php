<?php echo $this->fetch('pageheader.htm'); ?>

<div class="main-div">
<form action="reg_fields.php" method="post" name="theForm" onsubmit="return validate()">
<table width="100%">
  <tr >
    <td class="label"><?php echo $this->_var['lang']['reg_field_name']; ?>: </td>
    <td><input type="text" name="reg_field_name" value="<?php echo $this->_var['reg_field']['reg_field_name']; ?>" maxlength="20" /><?php echo $this->_var['lang']['require_field']; ?></td>
  </tr>
  <tr >
    <td class="label"><?php echo $this->_var['lang']['field_order']; ?>: </td>
    <td><input type="text" name="reg_field_order" value="<?php echo $this->_var['reg_field']['reg_field_order']; ?>" maxlength="3" size="5"/></td>
  </tr>
  <tr >
    <td class="label"><?php echo $this->_var['lang']['field_display']; ?>: </td>
    <td><input type="radio" name="reg_field_display" value="1" <?php if ($this->_var['reg_field']['reg_field_display'] == 1): ?>checked='checked'<?php endif; ?>/><?php echo $this->_var['lang']['yes']; ?>&nbsp;&nbsp;&nbsp;<input type="radio" name="reg_field_display" value="0" <?php if ($this->_var['reg_field']['reg_field_display'] == 0): ?>checked='checked'<?php endif; ?>/><?php echo $this->_var['lang']['no']; ?></td>
  </tr>
  <tr >
    <td class="label"><?php echo $this->_var['lang']['field_need']; ?>: </td>
    <td><input type="radio" name="reg_field_need" value="1" <?php if ($this->_var['reg_field']['reg_field_need'] == 1): ?>checked='checked'<?php endif; ?>/><?php echo $this->_var['lang']['yes']; ?>&nbsp;&nbsp;&nbsp;<input type="radio" name="reg_field_need" value="0" <?php if ($this->_var['reg_field']['reg_field_need'] == 0): ?>checked='checked'<?php endif; ?>/><?php echo $this->_var['lang']['no']; ?></td>
  </tr>
  <tr>
    <td></td>    
    <td align="left">
      <input type="hidden" name="act" value="<?php echo $this->_var['form_action']; ?>" />
      <input type="hidden" name="id" value="<?php echo $this->_var['reg_field']['reg_field_id']; ?>" />
      <input type="hidden" name="old_field_name" value="<?php echo $this->_var['reg_field']['reg_field_name']; ?>" />
      <input type="submit" value="<?php echo $this->_var['lang']['button_submit']; ?>" class="button" />
      <input type="reset" value="<?php echo $this->_var['lang']['button_reset']; ?>" class="button" />
    </td>

  </tr>
</table>
</form>
</div>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,validator.js')); ?>

<script language="JavaScript">
<!--
document.forms['theForm'].elements['reg_field_name'].focus();

onload = function()
{
  // 开始检查订单
  startCheckOrder();
}

/**
 * 检查表单输入的数据
 */
function validate()
{
  validator = new Validator("theForm");
  validator.required('reg_field_name', field_name_empty);
  return validator.passed();
}
//-->
</script>

<?php echo $this->fetch('pagefooter.htm'); ?>