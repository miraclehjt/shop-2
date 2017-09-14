<?php if ($this->_var['full_page']): ?>
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'validator.js')); ?>
<div class="tab-div" id="listDiv">
<?php endif; ?>
  <!-- tab bar -->
  <?php echo $this->fetch('flashplay_tab.htm'); ?>
  <!-- body -->
  <div class="tab-body">
  <div class="list-div list-div-ad" id="listDiv">
  <table cellspacing='1' cellpadding='3' id='list-table' width="70%">
    <tr>
      <th width="400px"><?php echo $this->_var['lang']['title_flash_name']; ?></th>
      <th><?php echo $this->_var['lang']['title_flash_type']; ?></th>
      <th><?php echo $this->_var['lang']['title_flash_time']; ?></th>
      <th><?php echo $this->_var['lang']['title_flash_status']; ?></th>
    <th width="70px"><?php echo $this->_var['lang']['handler']; ?></th>
    </tr>
    <?php $_from = $this->_var['ad_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
    <tr>
      <td><?php echo $this->_var['item']['ad_name']; ?></td>
      <td align="left"><?php echo $this->_var['item']['type_name']; ?></td>
      <td align="left"><?php echo $this->_var['item']['add_time']; ?></td>
      <td align="center"><a href="javascript:custom_status(<?php echo $this->_var['item']['ad_id']; ?>, <?php echo $this->_var['item']['ad_status']; ?>);void(0);" title="<?php echo $this->_var['lang']['custom_change_img']; ?>"><img src="images/<?php if ($this->_var['item']['ad_status'] == 0): ?>no.gif<?php else: ?>yes.gif<?php endif; ?>" width="16" height="16" border="0" /></a></td>
      <td align="center">
        <a href="flashplay.php?act=custom_edit&id=<?php echo $this->_var['item']['ad_id']; ?>" title="<?php echo $this->_var['lang']['edit']; ?>"><img src="images/icon_edit.gif" width="16" height="16" border="0" /></a>
        <a href="flashplay.php?act=custom_del&id=<?php echo $this->_var['item']['ad_id']; ?>" onclick="return check_del();" title="<?php echo $this->_var['lang']['custom_drop_img']; ?>"><img src="images/icon_drop.gif" width="16" height="16" border="0" /></a>
      </td>
    </tr>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  </table>
      <table cellspacing="0">
    <tr>
      <td>
        <input name="add" type="submit" id="btnSubmit" value="<?php echo $this->_var['action_link_special']['text']; ?>" onclick="location.href='<?php echo $this->_var['action_link_special']['href']; ?>';" class="button"/>
      </td>
    </tr>
  </table>
  </div>

 
  </div>

<?php if ($this->_var['full_page']): ?>
</div>
<script language="JavaScript">
<!--
// 初始页面参数
var status_code = 0; //<?php echo $this->_var['ad']['ad_type']; ?>;


onload = function()
{
  // 开始检查订单
  startCheckOrder();

  // 初始化表单项
  //initialize_form(status_code);
}

/**
 * 广告状态修改
 */
function custom_status(ad_id, ad_status)
{
  if (ad_id)
  {
    Ajax.call('flashplay.php?is_ajax=1&act=custom_status&ad_status=' + ad_status, 'id=' + ad_id, custom_status_edit, 'GET', 'JSON');
  }
}
function custom_status_edit(result)
{
  if (result.error == 0)
  {
    document.getElementById('listDiv').innerHTML = result.content;

    // 初始化表单项
    initialize_form(status_code);
  }
}

function check_del()
{
  if (confirm('<?php echo $this->_var['lang']['custom_del_confirm']; ?>'))
  {
    return true;
  }
  else
  {
    return false;
  }
}

/**
 * 系统设置提示
 */
function system_set()
{
  alert('<?php echo $this->_var['lang']['tab_change_alert']; ?>');
}

/**
 * 判断当前浏览器类型
 */
function navigator_type()
{
  var type_name = '';

  if (navigator.userAgent.indexOf('MSIE') != -1)
  {
    type_name = 'IE'; // IE
  }
  else if(navigator.userAgent.indexOf('Firefox') != -1)
  {
    type_name = 'FF'; // FF
  }
  else if(navigator.userAgent.indexOf('Opera') != -1)
  {
    type_name = 'Opera'; // Opera
  }
  else if(navigator.userAgent.indexOf('Safari') != -1)
  {
    type_name = 'Safari'; // Safari
  }
  else if(navigator.userAgent.indexOf('Chrome') != -1)
  {
    type_name = 'Chrome'; // Chrome
  }

  return type_name;
}
//-->
</script>

<?php echo $this->fetch('pagefooter.htm'); ?>
<?php endif; ?>