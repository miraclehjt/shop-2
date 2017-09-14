<!-- $Id: shop_config_mail_settings.htm 14216 2008-03-10 02:27:21Z testyang $ -->
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'validator.js')); ?>
<form method="POST" action="shop_config.php?act=post" name="theForm">
<div class="main-div"><p style="padding: 0 10px"><?php echo $this->_var['lang']['mail_settings_note']; ?></p></div>

<div class="main-div">
  <table width="100%" id="<?php echo $this->_var['group']['code']; ?>-table" >
    <?php $_from = $this->_var['cfg']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'var');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['var']):
?>
    <?php echo $this->fetch('shop_config_form.htm'); ?>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    <tr>
      <td class="label"><?php echo $this->_var['lang']['cfg_name']['test_mail_address']; ?>:</td>
      <td>
        <input type="text" name="test_mail_address" size="30" />
        <input type="button" value="<?php echo $this->_var['lang']['cfg_name']['send']; ?>" onclick="sendTestEmail();" class="button" />
      </td>
    </tr>
    <tr>
      <td align="center" colspan="2">
        <input name="submit" type="submit" value="<?php echo $this->_var['lang']['button_submit']; ?>" class="button" />
        <input name="reset" type="reset" value="<?php echo $this->_var['lang']['button_reset']; ?>" class="button" />
        <input name="type" type="hidden" value="mail_setting" class="button" />
      </td>
    </tr>
  </table>
</div>
</form>


<script type="text/javascript" language="JavaScript">
<!--
onload = function()
{
    // 开始检查订单
    startCheckOrder();
}

/**
 * 测试邮件的发送
 */
function sendTestEmail()
{
  var eles              = document.forms['theForm'].elements;
  var smtp_host         = eles['value[501]'].value;
  var smtp_port         = eles['value[502]'].value;
  var smtp_user         = eles['value[503]'].value;
  var smtp_pass         = eles['value[504]'].value;
  var reply_email       = eles['value[505]'].value;
  var test_mail_address = eles['test_mail_address'].value;

  var mail_charset = 0;

  for (i = 0; i < eles['value[506]'].length; i++)
  {
    if (eles['value[506]'][i].checked)
    {
      mail_charset = eles['value[506]'][i].value;
    }
  }

  var mail_service = 0;

  for (i = 0; i < eles['value[507]'].length; i++)
  {
    if (eles['value[507]'][i].checked)
    {
      mail_service = eles['value[507]'][i].value;
    }
  }

  Ajax.call('shop_config.php?is_ajax=1&act=send_test_email',
    'email=' + test_mail_address + '&mail_service=' + mail_service + '&smtp_host=' + smtp_host + '&smtp_port=' + smtp_port +
    '&smtp_user=' + smtp_user + '&smtp_pass=' + encodeURIComponent(smtp_pass) + '&reply_email=' + reply_email + '&mail_charset=' + mail_charset,
    emailResponse, 'POST', 'JSON');
}

/**
 * 邮件发送的反馈信息
 */
function emailResponse(result)
{
  alert(result.message);
}
//-->
</script>

<?php echo $this->fetch('pagefooter.htm'); ?>