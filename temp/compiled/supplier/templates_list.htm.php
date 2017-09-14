<!-- $Id: templates_list.htm 16480 2009-07-21 13:33:40Z Shadow & 鸿宇 -->
<?php echo $this->fetch('pageheader.htm'); ?>
<!-- start templates list -->
<div class="list-div">
  <table width="100%" cellpadding="3" cellspacing="1">
  <tr><th><?php echo $this->_var['lang']['current_template']; ?></th></tr>
  <tr><td>
    <table style=" background:none">
      <tr>
        <td width="250" align="center"><img id="screenshot" src="<?php echo $this->_var['curr_template']['screenshot']; ?>"/></td>
        <td valign="top"><strong><span id="templateName"><?php echo $this->_var['curr_template']['name']; ?></span></strong> v<span id="templateVersion"><?php echo $this->_var['curr_template']['version']; ?></span><br />
          <span id="templateAuthor"><a href="<?php echo $this->_var['curr_template']['uri']; ?>" target="_blank"><?php echo $this->_var['curr_template']['author']; ?></a></span><br />
          <span id="templateDesc"><?php echo $this->_var['curr_template']['desc']; ?></span><br />
          <span style="display:none"><input class="button" onclick="backupTemplate('<?php echo $this->_var['curr_template']['code']; ?>')" value="<?php echo $this->_var['lang']['backup']; ?>" type="button" id="backup" /></span>
          <div id="CurrTplStyleList">
      <?php $_from = $this->_var['template_style'][$this->_var['curr_template']['code']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'curr_style');$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from AS $this->_var['curr_style']):
        $this->_foreach['foo']['iteration']++;
?>
        <?php if ($this->_foreach['foo']['total'] > 1): ?>
          <span style="cursor:pointer;" onMouseOver="javascript:onSOver('screenshot', '<?php echo $this->_var['curr_style']; ?>', this);" onMouseOut="onSOut('screenshot', this, '<?php echo $this->_var['curr_template']['screenshot']; ?>');" onclick="javascript:setupTemplateFG('<?php echo $this->_var['curr_template']['code']; ?>', '<?php echo $this->_var['curr_style']; ?>', '');" id="templateType_<?php echo $this->_var['curr_style']; ?>"><img src="../themes/<?php echo $this->_var['curr_template']['code']; ?>/images/type<?php echo $this->_var['curr_style']; ?>_<?php if ($this->_var['curr_style'] == $this->_var['curr_tpl_style']): ?>1<?php else: ?>0<?php endif; ?>.gif" border="0"></span>
        <?php endif; ?>
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
          </div>
        </td></tr>
    </table>
  </td></tr>
  <tr><th><?php echo $this->_var['lang']['available_templates']; ?></th></tr>
  <tr><td>
  <?php $_from = $this->_var['available_templates']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'template');if (count($_from)):
    foreach ($_from AS $this->_var['template']):
?>
  <?php if ($this->_var['template']['sign'] == 'supplier'): ?>
  <div style="display:-moz-inline-stack;display:inline-block;vertical-align:top;zoom:1;*display:inline;">
    <table style="width: 220px;background:none;margin-right:40px">
      <tr>
        <td><strong><a href="<?php echo $this->_var['template']['uri']; ?>" target="_blank"><?php echo $this->_var['template']['name']; ?></a></strong></td>
      </tr>
      <tr>
        <td><?php if ($this->_var['template']['screenshot']): ?><img src="<?php echo $this->_var['template']['screenshot']; ?>" border="0" style="cursor:pointer; float:left; margin:0 2px;display:block;" id="<?php echo $this->_var['template']['code']; ?>" onclick="javascript:setupTemplate('<?php echo $this->_var['template']['code']; ?>')"/><?php endif; ?></td>
      </tr>
      <tr>
        <td valign="top">
        <?php $_from = $this->_var['template_style'][$this->_var['template']['code']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'style');$this->_foreach['foo1'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo1']['total'] > 0):
    foreach ($_from AS $this->_var['style']):
        $this->_foreach['foo1']['iteration']++;
?>
        <?php if ($this->_foreach['foo1']['total'] > 1): ?>
         <img src="../themes/<?php echo $this->_var['template']['code']; ?>/images/type<?php echo $this->_var['style']; ?>_0.gif" border="0" style="cursor:pointer; float:left; margin:0 2px;" onMouseOver="javascript:onSOver('<?php echo $this->_var['template']['code']; ?>', '<?php echo $this->_var['style']; ?>', this);" onMouseOut="onSOut('<?php echo $this->_var['template']['code']; ?>', this, '');" onclick="javascript:setupTemplateFG('<?php echo $this->_var['template']['code']; ?>', '<?php echo $this->_var['style']; ?>', this);">
        <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </td>
      </tr>
      <tr>
        <td valign="top"><?php echo $this->_var['template']['desc']; ?></td>
      </tr>
    </table>
    </div>
	<?php endif; ?>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  </td></tr>
  </table>
</div>
<!-- end templates list -->

<script language="JavaScript">
<!--


/**
 * 模板风格 全局变量
 */
var T = 0;
var StyleSelected = '<?php echo $this->_var['curr_tpl_style']; ?>';
var StyleCode = '';
var StyleTem = '';
/**
 * 载入页面 初始化
 */
onload = function()
{
  // 开始检查订单
  startCheckOrder();
}

/**
 * 安装模版
 */
function setupTemplate(tpl)
{
  if (tpl != StyleTem)
  {
    StyleCode = '';
  }
  if (confirm(setupConfirm))
  {
    Ajax.call('template.php?is_ajax=1&act=install', 'tpl_name=' + tpl + '&tpl_fg='+ StyleCode, setupTemplateResponse, 'GET', 'JSON');
  }
}

/**
 * 处理安装模版的反馈信息
 */
function setupTemplateResponse(result)
{
    StyleCode = '';
  if (result.message.length > 0)
  {
    alert(result.message);
  }
  if (result.error == 0)
  {
    showTemplateInfo(result.content);
  }
}

/**
 * 备份当前模板
 */
function backupTemplate(tpl)
{
  Ajax.call('template.php?is_ajax=1&act=backup', 'tpl_name=' + tpl, backupTemplateResponse, "GET", "JSON");
}

function backupTemplateResponse(result)
{
  if (result.message.length>0)
  {
    alert(result.message);
  }

  if (result.error == 0)
  {
    location.href = result.content;
  }
}

/**
 * 显示模板信息
 */
function showTemplateInfo(res)
{
  document.getElementById("CurrTplStyleList").innerHTML = res.tpl_style;

  StyleSelected = res.stylename;

  document.getElementById("screenshot").src = res.screenshot;
  document.getElementById("templateName").innerHTML    = res.name;
  document.getElementById("templateDesc").innerHTML    = res.desc;
  document.getElementById("templateVersion").innerHTML = res.version;
  document.getElementById("templateAuthor").innerHTML  = '<a href="' + res.uri + '" target="_blank">' + res.author + '</a>';
  document.getElementById("backup").onclick = function () {backupTemplate(res.code);};
}

/**
 * 模板风格 切换
 */
function onSOver(tplid, fgid, _self)
{
  var re = /(\/|\\)([^\/\\])+\.png$/;
  var img_url = document.getElementById(tplid).src;
  StyleCode = fgid;
  StyleTem = tplid;
    
  T = 0;

  // 模板切换
  if ( tplid != '' && fgid != '')
  {
    document.getElementById(tplid).src = img_url.replace(re, '/screenshot_' + fgid + '.png');
  }
  else 
  {
    document.getElementById(tplid).src = img_url.replace(re, '/screenshot.png');
  }

  return true;
}
//
function onSOut(tplid, _self, def)
{
  if (T == 1)
  {
    return true;
  }

  var re = /(\/|\\)([^\/\\])+\.png$/;
  var img_url = document.getElementById(tplid).src;

  // 模板切换为默认风格
  if ( def != '' )
 {
    document.getElementById(tplid).src = def; 
  }
  else
  {
 //  document.getElementById(tplid).src = img_url.replace(re, '/screenshot.png');
  }

  return true;
}
//
function onTempSelectClear(tplid, _self)
{
  var re = /(\/|\\)([^\/\\])+\.png$/;
  var img_url = document.getElementById(tplid).src;

  // 模板切换为默认风格
  document.getElementById(tplid).src = img_url.replace(re, '/screenshot.png');
    
  T = 0;

  return true;
}

/**
 * 模板风格 AJAX安装
 */
function setupTemplateFG(tplNO, TplFG, _self)
{
  T = 1;

  if ( confirm(setupConfirm) )
  {
    Ajax.call('template.php?is_ajax=1&act=install', 'tpl_name=' + tplNO + '&tpl_fg=' + TplFG, setupTemplateResponse, 'GET', 'JSON');
  }

  if (_self)
  {
    onTempSelectClear(tplNO, _self);
  }

  return true;
}
//-->

</script>
<?php echo $this->fetch('pagefooter.htm'); ?>