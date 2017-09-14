<!-- $Id: captcha_manage.htm 14868 2008-09-11 09:51:13Z dolphin $ -->
<?php echo $this->fetch('pageheader.htm'); ?>

<div class="list-div">
<form method="post" action="captcha_manage.php" name="theForm" onsubmit="return validate()" >
<table cellpadding='3' cellspacing='1'>
<tr>
  <th colspan="2"><?php echo $this->_var['lang']['captcha_setting']; ?></th>
</tr>
<tr>
  <td width="60%" >
  <strong><?php echo $this->_var['lang']['captcha_turn_on']; ?></strong><br />
  <?php echo $this->_var['lang']['turn_on_note']; ?><br />
  <img src="../captcha.php?<?php echo $this->_var['rand']; ?>" alt="captcha" style="vertical-align: middle;cursor: pointer;" onClick="this.src='../captcha.php?'+Math.random()" />
  </td>
  <td>
  <input type="checkbox" name="captcha_register" value="1" <?php echo $this->_var['captcha']['register']; ?> /><?php echo $this->_var['lang']['captcha_register']; ?><br />
  <input type="checkbox" name="captcha_login" value="2" <?php echo $this->_var['captcha']['login']; ?> /><?php echo $this->_var['lang']['captcha_login']; ?><br />
  <input type="checkbox" name="captcha_comment" value="4"  <?php echo $this->_var['captcha']['comment']; ?> /><?php echo $this->_var['lang']['captcha_comment']; ?><br />
  <input type="checkbox" name="captcha_admin" value="8" <?php echo $this->_var['captcha']['admin']; ?> /><?php echo $this->_var['lang']['captcha_admin']; ?><br />
  <input type="checkbox" name="captcha_message" value="32" <?php echo $this->_var['captcha']['message']; ?> /><?php echo $this->_var['lang']['captcha_message']; ?><br />
  </td>
</tr>
<tr>
  <td>
  <strong><?php echo $this->_var['lang']['captcha_login_fail']; ?></strong><br />
  <?php echo $this->_var['lang']['login_fail_note']; ?>
  </td>
  <td><input type="radio" name="captcha_login_fail" value="32" <?php echo $this->_var['captcha']['login_fail_yes']; ?> /><?php echo $this->_var['lang']['yes']; ?><input type="radio"  name="captcha_login_fail" value="0" <?php echo $this->_var['captcha']['login_fail_no']; ?> /><?php echo $this->_var['lang']['no']; ?></td>
</tr>
<tr>
  <td>
  <strong><?php echo $this->_var['lang']['captcha_width']; ?></strong><br />
  <?php echo $this->_var['lang']['width_note']; ?>
  </td>
  <td><input type="text" name="captcha_width" value="<?php echo $this->_var['captcha_width']; ?>" /></td>
</tr>
<tr>
  <td>
  <strong><?php echo $this->_var['lang']['captcha_height']; ?></strong><br />
  <?php echo $this->_var['lang']['height_note']; ?>
  </td>
  <td><input type="text" name="captcha_height" value="<?php echo $this->_var['captcha_height']; ?>" /></td>
</tr>
<tr>
  <td colspan="2" align="center"><input type="hidden" name="act" value="save_config" /><input type="submit" value="保存设置" class="button" /></td>
</tr>
</table>
</form>
</div>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js')); ?>

<script type="text/javascript" language="JavaScript">
<!--
onload = function() {startCheckOrder();}

function validate()
{
  var width = document.forms["theForm"].elements["captcha_width"].value;
  var height = document.forms["theForm"].elements["captcha_height"].value;
  if(!Utils.isNumber(width))
  {
    alert(width_number);
    return false;
  }

  if(parseInt(width) > 145 || parseInt(width) < 40)
  {
    alert(proper_width);
    return false;
  }

  if(!Utils.isNumber(height))
  {
    alert(height_number);
    return false;
  }

  if(parseInt(height) > 50 || parseInt(height) < 15)
  {
    alert(proper_height);
    return false;
  }

  return true;
}
//-->
</script>

<?php echo $this->fetch('pagefooter.htm'); ?>
