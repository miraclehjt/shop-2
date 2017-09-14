<?php echo $this->fetch('pageheader.htm'); ?>
<div class="tab-div">
  <!-- tab bar -->
  <?php echo $this->fetch('flashplay_tab.htm'); ?>
  <!-- body -->
  <div class="tab-body">
  <div class="list-div list-div-ad" id="listDiv">
  <table cellspacing='1' cellpadding='3' id='list-table' width="70%">
    <tr>
      <th width="400px"><?php echo $this->_var['lang']['schp_imgsrc']; ?></th>
    <th><?php echo $this->_var['lang']['schp_imgurl']; ?></th>
      <th><?php echo $this->_var['lang']['schp_imgdesc']; ?></th>
      <th><?php echo $this->_var['lang']['schp_sort']; ?></th>
    <th width="70px"><?php echo $this->_var['lang']['handler']; ?></th>
    </tr>
    <?php $_from = $this->_var['playerdb']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
    <tr>
      <td><a href="<?php echo $this->_var['item']['src']; ?>" target="_blank"><?php echo $this->_var['item']['src']; ?></a></td>
    <td align="left"><a href="<?php echo $this->_var['item']['url']; ?>" target="_blank"><?php echo $this->_var['item']['url']; ?></a></td>
      <td align="left"><?php echo $this->_var['item']['text']; ?></td>
      <td align="left"><?php echo $this->_var['item']['sort']; ?></td>
    <td align="center">
        <a href="flashplay.php?act=edit&id=<?php echo $this->_var['key']; ?>" title="<?php echo $this->_var['lang']['edit']; ?>"><img src="images/icon_edit.gif" width="16" height="16" border="0" /></a>
        <a href="flashplay.php?act=del&id=<?php echo $this->_var['key']; ?>" onclick="return check_del();" title="<?php echo $this->_var['lang']['trash_img']; ?>"><img src="images/icon_drop.gif" width="16" height="16" border="0" /></a>
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
  <!-- <div class="list-div list-div-ad" style="margin-top:15px;">
  <table>
  <tr><th><?php echo $this->_var['lang']['flash_template']; ?></th></tr>
  <tr>
      <td><?php $_from = $this->_var['flashtpls']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'flashtpl');if (count($_from)):
    foreach ($_from AS $this->_var['flashtpl']):
?>
  <table style="float:left;width: 220px;">
  <tr>
    <td><strong><center><?php echo $this->_var['flashtpl']['name']; ?>&nbsp;<?php if ($this->_var['flashtpl']['code'] == $this->_var['current_flashtpl']): ?><span style="color:red;" id="current_theme"><?php echo $this->_var['lang']['current_theme']; ?></span><?php endif; ?></center></strong></td>
  </tr>
  <tr>
    <td><?php if ($this->_var['flashtpl']['screenshot']): ?><img src="<?php echo $this->_var['flashtpl']['screenshot']; ?>" border="0" style="cursor:pointer" onclick="setupFlashTpl('<?php echo $this->_var['flashtpl']['code']; ?>', this)" /><?php endif; ?></td>
  </tr>
  <tr>
    <td valign="top"><?php echo $this->_var['flashtpl']['desc']; ?></td>
  </tr>
  </table>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?></td>
  </tr>
  </table>
  </div> -->
  </div>

</div>
<script language="JavaScript">
<!--
onload = function()
{
    // 开始检查订单
    startCheckOrder();
}
function check_del()
{
  if (confirm('<?php echo $this->_var['lang']['trash_img_confirm']; ?>'))
  {
    return true;
  }
  else
  {
    return false;
  }
}

/**
 * 安装Flash样式模板
 */
function setupFlashTpl(tpl, obj)
{
    window.current_tpl_obj = obj;
    if (confirm(setupConfirm))
    {
        Ajax.call('flashplay.php?is_ajax=1&act=install', 'flashtpl=' + tpl, setupFlashTplResponse, 'GET', 'JSON');
    }
}

function setupFlashTplResponse(result)
{
    if (result.message.length > 0)
    {
        alert(result.message);
    }

    if (result.error == 0)
    {
        var tmp_obj = window.current_tpl_obj.parentNode.parentNode.previousSibling;
        while (tmp_obj.nodeName.toLowerCase() != 'tr')
        {
            tmp_obj = tmp_obj.previousSibling;
        }
        tmp_obj = tmp_obj.getElementsByTagName('center');
        tmp_obj[0].appendChild(document.getElementById('current_theme'));
    }
    
}
//-->
</script>

<?php echo $this->fetch('pagefooter.htm'); ?>