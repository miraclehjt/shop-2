<!-- $Id: template_library.htm 14216 2008-03-10 02:27:21Z testyang $ -->
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>
<form method="post" onsubmit="return false">
<div class="form-div">
  <?php echo $this->_var['lang']['select_library']; ?>
  <select id="selLib" onchange="loadLibrary()"><?php echo $this->_var['curr_template']; ?>
    <?php echo $this->html_options(array('options'=>$this->_var['libraries'],'selected'=>$this->_var['curr_library'])); ?>
  </select>
</div>

<div class="main-div">
  <div class="button-div ">
  <textarea id="libContent" rows="20" style="font-family: Courier New; width:95%"><?php echo htmlspecialchars($this->_var['library_html']); ?></textarea>
    <input type="button" value="<?php echo $this->_var['lang']['button_submit']; ?>" class="button" onclick="updateLibrary()" />
    <input type="button" value="<?php echo $this->_var['lang']['button_restore']; ?>" class="button" onclick="restoreLibrary()" />
  </div>
</div>
</form>
<script language="JavaScript">
<!--


var currLibrary = "<?php echo $this->_var['curr_library']; ?>";
var content = '';
onload = function()
{
    document.getElementById('libContent').focus();
    // 开始检查订单
    startCheckOrder();
}

/**
 * 载入库项目内容
 */
function loadLibrary()
{
    curContent = document.getElementById('libContent').value;

    if (content != curContent && content != '')
    {
        if (!confirm(save_confirm))
        {
            return;
        }
    }

    selLib  = document.getElementById('selLib');
    currLib = selLib.options[selLib.selectedIndex].value;

    Ajax.call('template.php?is_ajax=1&act=load_library', 'lib='+ currLib, loadLibraryResponse, "GET", "JSON");
}

/**
 * 还原库项目内容
 */
function restoreLibrary()
{
    selLib  = document.getElementById('selLib');
    currLib = selLib.options[selLib.selectedIndex].value;

    Ajax.call('template.php?is_ajax=1&act=restore_library', "lib="+currLib, loadLibraryResponse, "GET", "JSON");
}

/**
 * 处理载入的反馈信息
 */
function loadLibraryResponse(result)
{
    if (result.error == 0)
    {
        document.getElementById('libContent').value=result.content;
    }

    if (result.message.length > 0)
    {
      alert(result.message);
    }
}

/**
 * 更新库项目内容
 */
function updateLibrary()
{
    selLib  = document.getElementById('selLib');
    currLib = selLib.options[selLib.selectedIndex].value;
    content = document.getElementById('libContent').value;

    if (Utils.trim(content) == "")
    {
        alert(empty_content);
        return;
    }
    Ajax.call('template.php?act=update_library&is_ajax=1', 'lib=' + currLib + "&html=" + encodeURIComponent(content), updateLibraryResponse, "POST", "JSON");
}

/**
 * 处理更新的反馈信息
 */
function updateLibraryResponse(result)
{
  if (result.message.length > 0)
  {
    alert(result.message);
  }
}

//-->
</script>
<?php echo $this->fetch('pagefooter.htm'); ?>