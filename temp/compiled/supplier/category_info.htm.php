<!-- $Id: category_info.htm 16752 2009-10-20 09:59:38Z wangleisvn $ -->
<?php echo $this->fetch('pageheader.htm'); ?>
<!-- start add new category form -->
<div class="main-div">
  <form action="category.php" method="post" name="theForm" enctype="multipart/form-data" onsubmit="return validate()">
  <table width="100%" id="general-table">
      <tr>
        <td class="label"><?php echo $this->_var['lang']['cat_name']; ?>:</td>
        <td>
          <input type='text' name='cat_name' maxlength="20" value='<?php echo htmlspecialchars($this->_var['cat_info']['cat_name']); ?>' size='27' /> <font color="red">*</font>
        </td>
      </tr>
      <tr>
        <td class="label"><?php echo $this->_var['lang']['parent_id']; ?>:</td>
        <td>
          <select name="parent_id">
            <option value="0"><?php echo $this->_var['lang']['cat_top']; ?></option>
            <?php echo $this->_var['cat_select']; ?>
          </select>
        </td>
      </tr>

      <tr id="measure_unit">
        <td class="label"><?php echo $this->_var['lang']['measure_unit']; ?>:</td>
        <td>
          <input type="text" name='measure_unit' value='<?php echo $this->_var['cat_info']['measure_unit']; ?>' size="12" />
        </td>
      </tr>
      <tr>
        <td class="label"><?php echo $this->_var['lang']['sort_order']; ?>:</td>
        <td>
          <input type="text" name='sort_order' <?php if ($this->_var['cat_info']['sort_order']): ?>value='<?php echo $this->_var['cat_info']['sort_order']; ?>'<?php else: ?> value="50"<?php endif; ?> size="15" />
        </td>
      </tr>

      <tr>
        <td class="label"><?php echo $this->_var['lang']['is_show']; ?>:</td>
        <td>
          <input type="radio" name="is_show" value="1" <?php if ($this->_var['cat_info']['is_show'] != 0): ?> checked="true"<?php endif; ?>/> <?php echo $this->_var['lang']['yes']; ?>
          <input type="radio" name="is_show" value="0" <?php if ($this->_var['cat_info']['is_show'] == 0): ?> checked="true"<?php endif; ?> /> <?php echo $this->_var['lang']['no']; ?>
        </td>
      </tr>
      <tr>
        <td class="label"><?php echo $this->_var['lang']['show_in_nav']; ?>:</td>
        <td>
          <input type="radio" name="show_in_nav" value="1" <?php if ($this->_var['cat_info']['show_in_nav'] != 0): ?> checked="true"<?php endif; ?>/> <?php echo $this->_var['lang']['yes']; ?>
          <input type="radio" name="show_in_nav" value="0" <?php if ($this->_var['cat_info']['show_in_nav'] == 0): ?> checked="true"<?php endif; ?> /> <?php echo $this->_var['lang']['no']; ?>
        </td>
      </tr>
      <tr>
        <td class="label"><?php echo $this->_var['lang']['show_in_index']; ?>:</td>
        <td>
          <input type="checkbox" name="cat_recommend[]" value="1" <?php if ($this->_var['cat_recommend'] [ 1 ] == 1): ?> checked="true"<?php endif; ?>/> <?php echo $this->_var['lang']['index_best']; ?>
          <input type="checkbox" name="cat_recommend[]" value="2" <?php if ($this->_var['cat_recommend'] [ 2 ] == 1): ?> checked="true"<?php endif; ?> /> <?php echo $this->_var['lang']['index_new']; ?>
          <input type="checkbox" name="cat_recommend[]" value="3" <?php if ($this->_var['cat_recommend'] [ 3 ] == 1): ?> checked="true"<?php endif; ?> /> <?php echo $this->_var['lang']['index_hot']; ?>
        </td>
      </tr>
	  <tr>
        <td class="label"><?php echo $this->_var['lang']['is_show_cat_pic']; ?>:</td>
        <td>
          <input type="radio" name="is_show_cat_pic" value="1" <?php if ($this->_var['cat_info']['is_show_cat_pic'] != 0): ?> checked="true"<?php endif; ?>/> <?php echo $this->_var['lang']['yes']; ?>
          <input type="radio" name="is_show_cat_pic" value="0" <?php if ($this->_var['cat_info']['is_show_cat_pic'] == 0): ?> checked="true"<?php endif; ?> /> <?php echo $this->_var['lang']['no']; ?>
        </td>
      </tr>
	  <tr>
        <td class="label"><?php echo $this->_var['lang']['cat_pic']; ?>:</td>
        <td>
		<input type="file" name="cat_pic" size="35" />
              <?php if ($this->_var['cat_info']['cat_pic']): ?>
                <a href="goods.php?act=show_image&img_url=<?php echo $this->_var['cat_info']['cat_pic']; ?>" target="_blank"><img src="images/yes.gif" border="0" /></a>
              <?php else: ?>
                <img src="images/no.gif" />
              <?php endif; ?>
        </td>
      </tr>
	  <tr>
        <td class="label"><?php echo $this->_var['lang']['cat_pic_url']; ?>:</td>
        <td>
		<input type="text" name='cat_pic_url' value='<?php echo $this->_var['cat_info']['cat_pic_url']; ?>' size="35" />
        </td>
      </tr>
	  <tr>
        <td class="label"><?php echo $this->_var['lang']['cat_goods_limit']; ?>:</td>
        <td>
		<input type="text" name='cat_goods_limit' <?php if ($this->_var['cat_info']['cat_goods_limit']): ?>value='<?php echo $this->_var['cat_info']['cat_goods_limit']; ?>'<?php else: ?> value="8"<?php endif; ?> size="15" />
        </td>
      </tr>
      <tr>
        <td class="label"><a href="javascript:showNotice('noticeFilterAttr');" title="<?php echo $this->_var['lang']['form_notice']; ?>"><img src="images/notice.gif" width="16" height="16" border="0" alt="<?php echo $this->_var['lang']['notice_style']; ?>"></a><?php echo $this->_var['lang']['filter_attr']; ?>:</td>
        <td>
          <script type="text/javascript">
          var arr = new Array();
          var sel_filter_attr = "<?php echo $this->_var['lang']['sel_filter_attr']; ?>";
          <?php $_from = $this->_var['attr_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('att_cat_id', 'val');if (count($_from)):
    foreach ($_from AS $this->_var['att_cat_id'] => $this->_var['val']):
?>
            arr[<?php echo $this->_var['att_cat_id']; ?>] = new Array();
            <?php $_from = $this->_var['val']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('i', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['i'] => $this->_var['item']):
?>
              <?php $_from = $this->_var['item']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('attr_id', 'attr_val');if (count($_from)):
    foreach ($_from AS $this->_var['attr_id'] => $this->_var['attr_val']):
?>
                arr[<?php echo $this->_var['att_cat_id']; ?>][<?php echo $this->_var['i']; ?>] = ["<?php echo $this->_var['attr_val']; ?>", <?php echo $this->_var['attr_id']; ?>];
              <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

          function changeCat(obj)
          {
            var key = obj.value;
            var sel = window.ActiveXObject ? obj.parentNode.childNodes[4] : obj.parentNode.childNodes[5];
            sel.length = 0;
            sel.options[0] = new Option(sel_filter_attr, 0);
            if (arr[key] == undefined)
            {
              return;
            }
            for (var i= 0; i < arr[key].length ;i++ )
            {
              sel.options[i+1] = new Option(arr[key][i][0], arr[key][i][1]);
            }

          }

          </script>

         
          <table width="100%" id="tbody-attr" align="center">
            <?php if ($this->_var['attr_cat_id'] == 0): ?>
            <tr>
              <td>   
                   <a href="javascript:;" onclick="addFilterAttr(this)">[+]</a> 
                   <select onChange="changeCat(this)"><option value="0"><?php echo $this->_var['lang']['sel_goods_type']; ?></option><?php echo $this->_var['goods_type_list']; ?></select>&nbsp;&nbsp;
                   <select name="filter_attr[]"><option value="0"><?php echo $this->_var['lang']['sel_filter_attr']; ?></option></select><br />                   
              </td>
            </tr> 
            <?php endif; ?>           
            <?php $_from = $this->_var['filter_attr_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'filter_attr');$this->_foreach['filter_attr_tab'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['filter_attr_tab']['total'] > 0):
    foreach ($_from AS $this->_var['filter_attr']):
        $this->_foreach['filter_attr_tab']['iteration']++;
?>
            <tr>
              <td>
                 <?php if ($this->_foreach['filter_attr_tab']['iteration'] == 1): ?>
                   <a href="javascript:;" onclick="addFilterAttr(this)">[+]</a>
                 <?php else: ?>
                   <a href="javascript:;" onclick="removeFilterAttr(this)">[-]&nbsp;</a>
                 <?php endif; ?>
                 <select onChange="changeCat(this)"><option value="0"><?php echo $this->_var['lang']['sel_goods_type']; ?></option><?php echo $this->_var['filter_attr']['goods_type_list']; ?></select>&nbsp;&nbsp;
                 <select name="filter_attr[]"><option value="0"><?php echo $this->_var['lang']['sel_filter_attr']; ?></option><?php echo $this->html_options(array('options'=>$this->_var['filter_attr']['option'],'selected'=>$this->_var['filter_attr']['filter_attr'])); ?></select><br />
              </td>
            </tr>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
          </table>

          <span class="notice-span" <?php if ($this->_var['help_open']): ?>style="display:block" <?php else: ?> style="display:none" <?php endif; ?> id="noticeFilterAttr"><?php echo $this->_var['lang']['filter_attr_notic']; ?></span>
        </td>
      </tr>
      <tr>
        <td class="label"><a href="javascript:showNotice('noticeGrade');" title="<?php echo $this->_var['lang']['form_notice']; ?>"><img src="images/notice.gif" width="16" height="16" border="0" alt="<?php echo $this->_var['lang']['notice_style']; ?>"></a><?php echo $this->_var['lang']['grade']; ?>:</td>
        <td>
          <input type="text" name="grade" value="<?php echo empty($this->_var['cat_info']['grade']) ? '0' : $this->_var['cat_info']['grade']; ?>" size="40" /> <br />
          <span class="notice-span" <?php if ($this->_var['help_open']): ?>style="display:block" <?php else: ?> style="display:none" <?php endif; ?> id="noticeGrade"><?php echo $this->_var['lang']['notice_grade']; ?></span>
        </td>
      </tr>
      <tr>
        <td class="label"><a href="javascript:showNotice('noticeGoodsSN');" title="<?php echo $this->_var['lang']['form_notice']; ?>"><img src="images/notice.gif" width="16" height="16" border="0" alt="<?php echo $this->_var['lang']['notice_style']; ?>"></a><?php echo $this->_var['lang']['cat_style']; ?>:</td>
        <td>
          <input type="text" name="style" value="<?php echo htmlspecialchars($this->_var['cat_info']['style']); ?>" size="40" /> <br />
          <span class="notice-span" <?php if ($this->_var['help_open']): ?>style="display:block" <?php else: ?> style="display:none" <?php endif; ?> id="noticeGoodsSN"><?php echo $this->_var['lang']['notice_style']; ?></span>
        </td>
      </tr>
      <tr>
        <td class="label"><?php echo $this->_var['lang']['keywords']; ?>:</td>
        <td><input type="text" name="keywords" value='<?php echo $this->_var['cat_info']['keywords']; ?>' size="50">
        </td>
      </tr>

      <tr>
        <td class="label"><?php echo $this->_var['lang']['cat_desc']; ?>:</td>
        <td>
          <textarea name='cat_desc' rows="6" cols="48"><?php echo $this->_var['cat_info']['cat_desc']; ?></textarea>
        </td>
      </tr>
      </table>
      <div class="button-div">
        <input type="submit" value="<?php echo $this->_var['lang']['button_submit']; ?>" />
        <input type="reset" value="<?php echo $this->_var['lang']['button_reset']; ?>" />
      </div>
    <input type="hidden" name="act" value="<?php echo $this->_var['form_act']; ?>" />
    <input type="hidden" name="old_cat_name" value="<?php echo $this->_var['cat_info']['cat_name']; ?>" />
    <input type="hidden" name="cat_id" value="<?php echo $this->_var['cat_info']['cat_id']; ?>" />
  </form>
</div>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,validator.js')); ?>

<script language="JavaScript">
<!--
document.forms['theForm'].elements['cat_name'].focus();
/**
 * 检查表单输入的数据
 */
function validate()
{
  validator = new Validator("theForm");
  validator.required("cat_name",      catname_empty);
  if (parseInt(document.forms['theForm'].elements['grade'].value) >10 || parseInt(document.forms['theForm'].elements['grade'].value) < 0)
  {
    validator.addErrorMsg('<?php echo $this->_var['lang']['grade_error']; ?>');
  }
  return validator.passed();
}
onload = function()
{
  // 开始检查订单
  startCheckOrder();
}

/**
 * 新增一个筛选属性
 */
function addFilterAttr(obj)
{
  var src = obj.parentNode.parentNode;
  var tbl = document.getElementById('tbody-attr');

  var validator  = new Validator('theForm');
  var filterAttr = document.getElementsByName("filter_attr[]");

  if (filterAttr[filterAttr.length-1].selectedIndex == 0)
  {
    validator.addErrorMsg(filter_attr_not_selected);
  }
  
  for (i = 0; i < filterAttr.length; i++)
  {
    for (j = i + 1; j <filterAttr.length; j++)
    {
      if (filterAttr.item(i).value == filterAttr.item(j).value)
      {
        validator.addErrorMsg(filter_attr_not_repeated);
      } 
    } 
  }

  if (!validator.passed())
  {
    return false;
  }

  var row  = tbl.insertRow(tbl.rows.length);
  var cell = row.insertCell(-1);
  cell.innerHTML = src.cells[0].innerHTML.replace(/(.*)(addFilterAttr)(.*)(\[)(\+)/i, "$1removeFilterAttr$3$4-");
  filterAttr[filterAttr.length-1].selectedIndex = 0;
}

/**
 * 删除一个筛选属性
 */
function removeFilterAttr(obj)
{
  var row = rowindex(obj.parentNode.parentNode);
  var tbl = document.getElementById('tbody-attr');

  tbl.deleteRow(row);
}
//-->
</script>

<?php echo $this->fetch('pagefooter.htm'); ?>