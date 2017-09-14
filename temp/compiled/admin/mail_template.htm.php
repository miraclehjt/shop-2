<!-- $Id: mail_template.htm 17002 2010-01-20 07:32:50Z wangleisvn $ -->
<?php if ($this->_var['full_page']): ?> <?php echo $this->fetch('pageheader.htm'); ?> <?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>
<div class="form-div" id="conent_area">
	<?php endif; ?>
	<form method="post" name="theForm" action="mail_template.php?act=save_template">
		<table id="general-table" align="center">
			<tr>
				<td style="font-weight: bold;" width="15%"><?php echo $this->_var['lang']['select_template']; ?></td>
				<td>
					<select id="selTemplate" onchange="loadTemplate()"> <?php echo $this->html_options(array('options'=>$this->_var['templates'],'selected'=>$this->_var['cur'])); ?>
					</select>
				</td>
			</tr>
			<tr>
				<td style="font-weight: bold;" width="15%"><?php echo $this->_var['lang']['mail_subject']; ?>:</td>
				<td>
					<input type="text" name="subject" id="subject" style="width: 300px" value="<?php echo $this->_var['template']['template_subject']; ?>" />
				</td>
			</tr>
			<tr>
				<td style="font-weight: bold"><?php echo $this->_var['lang']['mail_type']; ?>:</td>
				<td>
					<input type="radio" name="is_html" value="0" <?php if ($this->_var['template']['is_html'] == '0'): ?>checked="true" <?php endif; ?> onclick="javascript:change_editor();" />
					<?php echo $this->_var['lang']['mail_plain_text']; ?>
					<input type="radio" name="is_html" value="1" <?php if ($this->_var['template']['is_html'] == '1'): ?>checked="true" <?php endif; ?> onclick="javascript:change_editor();" />
					<?php echo $this->_var['lang']['mail_html']; ?>
					<input type="hidden" name="tpl" value="<?php echo $this->_var['tpl']; ?>" />
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<?php if ($this->_var['template']['is_html'] == '1'): ?> <?php echo $this->_var['FCKeditor']; ?> <?php else: ?>
					<textarea name="content" id="content" style="width: 90%" rows="16"><?php echo $this->_var['template']['template_content']; ?></textarea>
					<?php endif; ?>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<input type="submit" value="<?php echo $this->_var['lang']['button_submit']; ?>" class="button" />
				</td>
			</tr>
		</table>
	</form>
	<?php if ($this->_var['full_page']): ?>
</div>
<script language="JavaScript">


var orgContent = '';

/* 定义页面状态变量 */
var STATUS_is_html = <?php echo $this->_var['template']['is_html']; ?>; //文本邮件|HTML邮件

/**
 * 修改页面状态变量
 */
function update_page_status_variables()
{
  var em = document.forms['theForm'].elements;

  /* STATUS_is_html */
  var em_radio = em['mail_type'];

  for (i = 0; i < em_radio.length; i++)
  {
    if (em_radio[i].checked)
    {
      STATUS_is_html = em_radio[i].value;

      break;
    }
  }
}

onload = function()
{
    document.getElementById('selTemplate').focus();
    document.forms['theForm'].reset();
    // 开始检查订单
    startCheckOrder();
}

/**
 * 载入模板
 */
function loadTemplate()
{
  curContent = document.getElementById('content').value;

  if (orgContent != curContent && orgContent != '')
  {
    if (!confirm(save_confirm))
    {
      return;
    }
  }

  var tpl = document.getElementById('selTemplate').value;

  Ajax.call('mail_template.php?is_ajax=1&act=loat_template', 'tpl=' + tpl, loadTemplateResponse, "GET", "JSON");
}

/**
 * 更改邮件类型
 */
function change_editor()
{
  var em = document.forms['theForm'].elements;

  //取单选框 mail_type 的当前选中值
  var em_radio = em['mail_type'];

  for (i = 0; i < em_radio.length; i++)
  {
    if (em_radio[i].checked)
    {
      type = em_radio[i].value;

      break;
    }
  }

  //如果 onclick 是当前选中的单选框
  if (STATUS_is_html == type)
  {
    return; //返回空值
  }

  var tpl = document.getElementById('selTemplate').value;

  Ajax.call('mail_template.php?is_ajax=1&act=loat_template&mail_type=' + type, 'tpl=' + tpl, loadTemplateResponse, "GET", "JSON");
}

/**
 * 将模板的内容载入到文本框中
 */
function loadTemplateResponse(result, textResult)
{
  if (result.error == 0)
  {
    document.getElementById('conent_area').innerHTML = result.content;

    orgContent = '';
  }

  update_page_status_variables();

  if (result.message.length > 0)
  {
    alert(result.message);
  }
}

/**
 * 保存模板内容
 */
function saveTemplate()
{
    var selTemp = document.getElementById('selTemplate').value;
    var subject = document.getElementById('subject').value;
    var content = document.getElementById('content').value;
    var type    = 0;
    var em      = document.forms['theForm'].elements;

    for (i = 0; i < em.length; i++)
    {
        if (em[i].type == 'radio' && em[i].name == 'mail_type' && em[i].checked)
        {
            type = em[i].value;
        }
    }

    Ajax.call('mail_template.php?is_ajax=1&act=save_template', 'tpl=' + selTemp + "&subject=" + subject + "&content=" + content + "&is_html=" + type, saveTemplateResponse, "POST", "JSON");
}

/**
 * 提示用户保存成功或失败
 */
function saveTemplateResponse(result)
{
  if (result.error == 0)
  {
    orgContent = document.getElementById('content').value;
  }
  else
  {
    document.getElementById('content').value = orgContent;
  }

  if (result.message.length > 0)
  {
    alert(result.message);
  }
}

</script>
<?php echo $this->fetch('pagefooter.htm'); ?> <?php endif; ?>
