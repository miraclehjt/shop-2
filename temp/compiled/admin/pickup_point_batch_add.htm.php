<!-- $Id: goods_batch_add.htm 16544 2009-08-13 07:55:57Z liuhui $ -->
<?php echo $this->fetch('pageheader.htm'); ?>
<div class="main-div">
<form action="pickup_point.php?act=upload" method="post" enctype="multipart/form-data" name="theForm" onsubmit="return formValidate()">
<table cellspacing="1" cellpadding="3" width="100%">
  <tr>
    <td class="label"><?php echo $this->_var['lang']['file_charset']; ?></td>
    <td><select name="charset" id="charset">
      <?php echo $this->html_options(array('options'=>$this->_var['lang_list'])); ?>
    </select></td>
  </tr>
  <tr>
    <td class="label">
      <a href="javascript:showNotice('noticeFile');" title="<?php echo $this->_var['lang']['form_notice']; ?>"><img src="images/notice.gif" width="16" height="16" border="0" alt="<?php echo $this->_var['lang']['form_notice']; ?>"></a>
      <?php echo $this->_var['lang']['csv_file']; ?></td>
    <td><input name="file" type="file" size="40">
    <br />
      <span class="notice-span" <?php if ($this->_var['help_open']): ?>style="display:block" <?php else: ?> style="display:none" <?php endif; ?> id="noticeFile"><?php echo $this->_var['lang']['notice_file']; ?></span></td>
  </tr>
  <?php $_from = $this->_var['download_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('charset', 'download');if (count($_from)):
    foreach ($_from AS $this->_var['charset'] => $this->_var['download']):
?>
  <tr>
    <td>&nbsp;</td>
    <td><a href="pickup_point.php?act=download&charset=<?php echo $this->_var['charset']; ?>"><?php echo $this->_var['download']; ?></a></td>
  </tr>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  <tr align="center">
    <td colspan="2"><input name="submit" type="submit" id="submit" value="<?php echo $this->_var['lang']['button_submit']; ?>" class="button" /></td>
  </tr>
</table>
</form>
<table width="100%">
  <tr>
    <td>&nbsp;</td>
    <td width="80%"><?php echo $this->_var['lang']['use_help']; ?></td>
    <td>&nbsp;</td>
  </tr>
</table>
</div>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,validator.js')); ?>

<script language="JavaScript">
    var elements;
    onload = function()
    {
        // 文档元素对象
        elements = document.forms['theForm'].elements;

        // 开始检查订单
        startCheckOrder();
    }

    /**
     * 检查是否底级分类
     */
    function checkIsLeaf(selObj)
    {
        if (selObj.options[selObj.options.selectedIndex].className != 'leafCat')
        {
            alert(goods_cat_not_leaf);
            selObj.options.selectedIndex = 0;
        }
    }

    /**
     * 检查输入是否完整
     */
    function formValidate()
    {
        if (elements['cat'].value <= 0)
        {
            alert(please_select_cat);
            return false;
        }
        if (elements['file'].value == '')
        {
            alert(please_upload_file);
            return false;
        }
        return true;
    }
</script>

<?php echo $this->fetch('pagefooter.htm'); ?>