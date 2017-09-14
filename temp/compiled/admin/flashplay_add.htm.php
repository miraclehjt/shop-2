<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'validator.js')); ?>
<form action="flashplay.php" method="post" enctype="multipart/form-data">
<div class="main-div">
<table cellspacing="1" cellpadding="3" width="100%">
  <tr>
    <td class="label"><a href="javascript:showNotice('width_height');" title="<?php echo $this->_var['lang']['form_notice']; ?>"><img src="images/notice.gif" width="16" height="16" border="0" alt="<?php echo $this->_var['lang']['form_notice']; ?>"></a><?php echo $this->_var['lang']['img_src']; ?></td>
    <td><input type="file" name="img_file_src" value="" id="some_name" size="40" />
    <br /><input name="img_src" type="text" value="<?php echo $this->_var['rt']['img_src']; ?>" size="40" />
    <br /><span class="notice-span" <?php if ($this->_var['help_open']): ?>style="display:block" <?php else: ?> style="display:none" <?php endif; ?> id="width_height"><?php echo $this->_var['width_height']; ?></span>
    </td>
  </tr>
  <tr>
    <td class="label"><?php echo $this->_var['lang']['img_url']; ?></td>
    <td><input name="img_url" type="text" value="<?php if ($_GET['ad_link']): ?><?php echo $_GET['ad_link']; ?><?php else: ?><?php echo $this->_var['rt']['img_url']; ?><?php endif; ?>" size="40" /></td>
  </tr>
  <tr>
    <td class="label"><?php echo $this->_var['lang']['schp_imgdesc']; ?></td>
    <td><input name="img_text" type="text" value="<?php echo $this->_var['rt']['img_txt']; ?>" size="40" /></td>
  </tr>
  <tr>
    <td class="label"><?php echo $this->_var['lang']['schp_sort']; ?></td>
    <td><input name="img_sort" type="text" value="<?php echo $this->_var['rt']['img_sort']; ?>" size="4" maxlength="3"/></td>
  </tr>
  <tr align="center">
    <td colspan="2">
      <input type="hidden"  name="id"       value="<?php echo $this->_var['rt']['id']; ?>" />
      <input type="hidden"  name="step"       value="2" />
      <input type="hidden"  name="act"       value="<?php echo $this->_var['rt']['act']; ?>" />
      <input type="submit" class="button" name="Submit"       value="<?php echo $this->_var['lang']['button_submit']; ?>" />
      <input type="reset" class="button"  name="Reset"        value="<?php echo $this->_var['lang']['button_reset']; ?>" />
    </td>
  </tr>
</table>
</div>
</form>
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