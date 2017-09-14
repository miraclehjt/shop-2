<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>
<div class="">
	   <!-- 检查是否有新的插件 -->
</div>

<ul id="lilist" style="padding:0; margin: 0; list-style-type:none; color: #CC0000;">
  <li style="border: 1px solid #CC0000; background: #FFFFCC; padding: 10px; margin-bottom: 5px;" ><?php echo $this->_var['lang']['warning']; ?></li>
</ul>


<form action="" method="post" name="listForm" onsubmit="return confirmSubmit(this)">
<div class="list-div" id="listDiv">
<table cellpadding="3" cellspacing="1">
	<tr>
    	<th><?php echo $this->_var['lang']['website_name']; ?> 
        	<input onclick='listTable.selectAll(this, "checkboxes")' type="checkbox">
        </th>
        <th><?php echo $this->_var['lang']['website_author']; ?></th>
        <th><?php echo $this->_var['lang']['website_qq']; ?></th>
        <th><?php echo $this->_var['lang']['website_email']; ?></th>
        <th><?php echo $this->_var['lang']['version']; ?></th>
        <th><?php echo $this->_var['lang']['update_time']; ?></th>
        <th><?php echo $this->_var['lang']['handler']; ?></th>
    </tr>
    <?php $_from = $this->_var['website']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'val');if (count($_from)):
    foreach ($_from AS $this->_var['val']):
?>
    <tr align="center">
    	<td align="left"><input type="checkbox" name="checkboxes[]" value="<?php echo $this->_var['val']['type']; ?>" />
        	<?php echo $this->_var['val']['name']; ?>
        </td>
        <td><?php echo $this->_var['val']['author']; ?></td>
        <td><?php echo $this->_var['val']['qq']; ?></td>
        <td><?php echo $this->_var['val']['email']; ?></td>
        <td><?php echo $this->_var['val']['version']; ?></td>
        <td><?php echo $this->_var['val']['date']; ?></td>
        <td><?php if (! $this->_var['val']['install']): ?><a href="website.php?act=install&type=<?php echo $this->_var['val']['type']; ?>"><?php echo $this->_var['lang']['install']; ?></a><?php else: ?>
        	<a href="website.php?act=view&type=<?php echo $this->_var['val']['type']; ?>"><?php echo $this->_var['lang']['view']; ?></a>
            <a href="website.php?act=uninstall&type=<?php echo $this->_var['val']['type']; ?>"><?php echo $this->_var['lang']['uninstall']; ?></a><?php endif; ?>
            
             <!-- 插件更新 -->
        </td>
    </tr>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    <tr>
      <td colspan="7">
      <input type="hidden" name="act" value="batch" />
      <select name="type" id="type" onchange="changeAction()">
      		<option value=""><?php echo $this->_var['lang']['select_please']; ?></option>
      		<option value="create"><?php echo $this->_var['lang']['batch_create']; ?></option>
            <option value="uninstall"><?php echo $this->_var['lang']['uninstall']; ?></option>
      </select>
      <span id="show_check" style="display:none">
      	<input id="is_show_name" name="is_show_name" value="1" type="checkbox" />
      	<label for="is_show_name"><?php echo $this->_var['lang']['is_show_name']; ?></label>
      	<input type="checkbox" name="is_show_title" value="1" id="is_show_title" />
      	<label for="is_show_title"><?php echo $this->_var['lang']['is_show_title']; ?></label>
        <input type="checkbox" name="is_show_help" id="is_show_help" value="1" />
        <label for="is_show_help"><?php echo $this->_var['lang']['is_show_help']; ?></label>
        <input type="checkbox" name="is_open" id="is_open" value="1" />
        <label for="is_is_open"><?php echo $this->_var['lang']['is_open']; ?></label>
      </span>
      <input type="submit" id="btnSubmit" value="<?php echo $this->_var['lang']['button_submit']; ?>" disabled="true" class="button" /></td>
  </tr>
</table>
</div>
</form>


<script language="javascript">

/**
   * @param: bool ext 其他条件：用于转移分类
   */
  function confirmSubmit(frm)
  {
      if (frm.elements['type'].value == 'uninstall')
      {
          return confirm(confrim_uninstall);
      }
      else if (frm.elements['type'].value == '')
      {
          return false;
      }
      else
      {
          return true;
      }
  }
  
  function changeAction()
  {
      var frm = document.forms['listForm'];
      // 切换分类列表的显示
	  document.getElementById('show_check').style.display = frm.elements['type'].value == 'create' ? '' : 'none';
	  
	  if(frm.elements['type'].value == 'create')
	  {
		  return;
	  }
	  
      if (!document.getElementById('btnSubmit').disabled &&
          confirmSubmit(frm, false))
      {
          frm.submit();
      }
  }

  

</script>
<?php echo $this->fetch('pagefooter.htm'); ?>