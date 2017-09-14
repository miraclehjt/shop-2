<!-- $Id: language_list.htm 14216 2008-03-10 02:27:21Z testyang $ -->

<?php echo $this->fetch('pageheader.htm'); ?>

<div class="form-div">
  <form name="searchForm" action="edit_languages.php" method="post" onSubmit="return validate();">
    <select name="lang_file"><?php echo $this->html_options(array('options'=>$this->_var['lang_arr'],'selected'=>$this->_var['lang_file'])); ?></select>
    &nbsp;&nbsp;&nbsp;
    <?php echo $this->_var['lang']['enter_keywords']; ?>：<input type="text" name="keyword" size="30" />
    <input type="submit" value="<?php echo $this->_var['lang']['button_search']; ?>" class="button" /> <input type="hidden" name="act" value="list" />
  </form>
</div>
<div>
<ul style="padding:0; margin: 0; list-style-type:none; color: #CC0000;">
  <?php if ($this->_var['file_attr']): ?>
  <li style="border: 1px solid #CC0000; background: #FFFFCC; padding: 10px; margin-bottom: 5px;" ><?php echo $this->_var['file_attr']; ?></li>
  <?php endif; ?>
</ul>
</div>

<form method="post" action="edit_languages.php">
<div class="list-div" id="listDiv">
<table width="100%" cellspacing="1" cellpadding="2" id="list-table">
<?php if ($this->_var['language_arr']): ?>
  <tr>
    <th><?php echo $this->_var['lang']['item_name']; ?></th>
    <th><?php echo $this->_var['lang']['item_value']; ?></th>
  </tr>
 <?php $_from = $this->_var['language_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
  <tr>
    <td width="30%" align="left" class="first-cell">
    <?php echo $this->_var['list']['item_id']; ?><input type="hidden" name="item_id[]" value="<?php echo $this->_var['list']['item_id']; ?>" />
    </td>
    <td width="70%">
      <input type="text" name="item_content[]" value="<?php echo htmlspecialchars($this->_var['list']['item_content']); ?>" size="60" />
    </td>
  </tr>
  <tr style="display:none">
    <td width="30%" align="left" class="first-cell">&nbsp;</td>
    <td width="70%">
      <input type="hidden" name="item[]" value="<?php echo htmlspecialchars($this->_var['list']['item']); ?>" size="60"/>
    </td>
  </tr>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  <tr>
    <td colspan="2">
      <div align="center">
        <input type="hidden" name="act" value="edit" />
        <input type="hidden" name="file_path" value="<?php echo $this->_var['file_path']; ?>" />
        <input type="hidden" name="keyword" value="<?php echo $this->_var['keyword']; ?>" />
        <input type="submit" value="<?php echo $this->_var['lang']['edit_button']; ?>" class="button" />
&nbsp;&nbsp;&nbsp;
        <input type="reset" value="<?php echo $this->_var['lang']['reset_button']; ?>" class="button" />
      </div></td>
    </tr>
  <tr>
    <td colspan="2"><strong><?php echo $this->_var['lang']['notice_edit']; ?></strong></td>
    </tr>
  <?php endif; ?>

</table>
</div>
</form>


<script type="text/javascript" language="JavaScript">
<!--

onload = function()
{
    document.forms['searchForm'].elements['keyword'].focus();
}

function validate()
{
    var frm     = document.forms['searchForm'];
    var keyword = frm.elements['keyword'].value;
    if (keyword.length == 0)
    {
        alert(keyword_empty_error);

        return false;
    }
    return true;
}
//-->
</script>

<?php echo $this->fetch('pagefooter.htm'); ?>