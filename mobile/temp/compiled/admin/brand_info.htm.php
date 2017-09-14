<!-- $Id: brand_info.htm 14216 2008-03-10 02:27:21Z testyang $ -->
<?php echo $this->fetch('pageheader.htm'); ?>
<div class="main-div">
<form method="post" action="brand.php" name="theForm" enctype="multipart/form-data" onsubmit="return validate()">
<table cellspacing="1" cellpadding="3" width="100%">
  <tr>
    <td class="label"><?php echo $this->_var['lang']['brand_name']; ?></td>
    <td><input type="text" name="brand_name" maxlength="60" value="<?php echo $this->_var['brand']['brand_name']; ?>" /><?php echo $this->_var['lang']['require_field']; ?></td>
  </tr>
  <tr>
    <td class="label"><?php echo $this->_var['lang']['site_url']; ?></td>
    <td><input type="text" name="site_url" maxlength="60" size="40" value="<?php echo $this->_var['brand']['site_url']; ?>" /></td>
  </tr>
  <tr>
    <td class="label"><a href="javascript:showNotice('warn_brandlogo');" title="<?php echo $this->_var['lang']['form_notice']; ?>">
        <img src="images/notice.gif" width="16" height="16" border="0" alt="<?php echo $this->_var['lang']['form_notice']; ?>"></a><?php echo $this->_var['lang']['brand_logo']; ?></td>
    <td><input type="file" name="brand_logo" id="logo" size="45"><?php if ($this->_var['brand']['brand_logo'] != ""): ?><input type="button" value="<?php echo $this->_var['lang']['drop_brand_logo']; ?>" onclick="if (confirm('<?php echo $this->_var['lang']['confirm_drop_logo']; ?>'))location.href='brand.php?act=drop_logo&id=<?php echo $this->_var['brand']['brand_id']; ?>'"><?php endif; ?>
    <br /><span class="notice-span" <?php if ($this->_var['help_open']): ?>style="display:block" <?php else: ?> style="display:none" <?php endif; ?> id="warn_brandlogo">
    <?php if ($this->_var['brand']['brand_logo'] == ''): ?>
    <?php echo $this->_var['lang']['up_brandlogo']; ?>
    <?php else: ?>
    <?php echo $this->_var['lang']['warn_brandlogo']; ?>
    <?php endif; ?>
    </span>
    </td>
  </tr>
  <tr>

    <td class="label"><?php echo $this->_var['lang']['brand_img']; ?></td>

    <td><input type="file" name="brand_img" id="img" size="45"><?php if ($this->_var['brand']['brand_img'] != ""): ?><input type="button" value="<?php echo $this->_var['lang']['drop_brand_logo']; ?>" onclick="if (confirm('<?php echo $this->_var['lang']['confirm_drop_logo']; ?>'))location.href='brand.php?act=drop_img&id=<?php echo $this->_var['brand']['brand_id']; ?>'"><?php endif; ?>


    </td>

  </tr>

  <tr>

    <td class="label"><?php echo $this->_var['lang']['brand_desc']; ?></td>

    <td><textarea  name="brand_desc" cols="60" rows="4"  ><?php echo $this->_var['brand']['wap_brand_desc']; ?></textarea></td>

  </tr>
  <tr>
    <td class="label"><?php echo $this->_var['lang']['sort_order']; ?></td>
    <td><input type="text" name="sort_order" maxlength="40" size="15" value="<?php echo $this->_var['brand']['sort_order']; ?>" /></td>
  </tr>
  <tr>
    <td class="label"><?php echo $this->_var['lang']['is_show']; ?></td>
    <td><input type="radio" name="is_show" value="1" <?php if ($this->_var['brand']['is_show'] == 1): ?>checked="checked"<?php endif; ?> /> <?php echo $this->_var['lang']['yes']; ?>
        <input type="radio" name="is_show" value="0" <?php if ($this->_var['brand']['is_show'] == 0): ?>checked="checked"<?php endif; ?> /> <?php echo $this->_var['lang']['no']; ?>
        (<?php echo $this->_var['lang']['visibility_notes']; ?>)
    </td>
  </tr>
  <tr>
    <td colspan="2" align="center"><br />
      <input type="submit" class="button" value="<?php echo $this->_var['lang']['button_submit']; ?>" />
      <input type="reset" class="button" value="<?php echo $this->_var['lang']['button_reset']; ?>" />
      <input type="hidden" name="act" value="<?php echo $this->_var['form_action']; ?>" />
      <input type="hidden" name="old_brandname" value="<?php echo $this->_var['brand']['brand_name']; ?>" />
      <input type="hidden" name="id" value="<?php echo $this->_var['brand']['brand_id']; ?>" />
      <input type="hidden" name="old_brandlogo" value="<?php echo $this->_var['brand']['brand_logo']; ?>">
    </td>
  </tr>
</table>
</form>
</div>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,validator.js')); ?>

<script language="JavaScript">
<!--
document.forms['theForm'].elements['brand_name'].focus();
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
    validator.required("brand_name",  no_brandname);
    validator.isNumber("sort_order", require_num, true);
    return validator.passed();
}
//-->
</script>

<?php echo $this->fetch('pagefooter.htm'); ?>