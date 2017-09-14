<!-- $Id: category_info.htm 16752 2009-10-20 09:59:38Z wangleisvn $ -->
<?php echo $this->fetch('pageheader.htm'); ?>
<!-- start add new category form -->
<div class="main-div">
  <form action="pickup_point.php" method="post" name="theForm" onsubmit="return validate()">
  <table width="100%" id="general-table">
      <tr>
        <td class="label"><?php echo $this->_var['lang']['shop_name']; ?>:</td>
        <td>
          <input type='text' name='shop_name' maxlength="20" value='<?php echo $this->_var['pickup_point']['shop_name']; ?>' size='27' /> <font color="red">*</font>
        </td>
      </tr>
      <tr>
        <td class="label"><?php echo $this->_var['lang']['address']; ?>:</td>
        <td>
          <input type='text' name='address' maxlength="20" value='<?php echo $this->_var['pickup_point']['address']; ?>' size='27' /> <font color="red">*</font>
        </td>
      </tr>
      <tr>
        <td class="label"><?php echo $this->_var['lang']['contact']; ?>:</td>
        <td>
          <input type='text' name='contact' maxlength="20" value='<?php echo $this->_var['pickup_point']['contact']; ?>' size='27' /> <font color="red">*</font>
        </td>
      </tr>
      <tr>
        <td class="label"><?php echo $this->_var['lang']['phone']; ?>:</td>
        <td>
          <input type='text' name='phone' maxlength="20" value='<?php echo $this->_var['pickup_point']['phone']; ?>' size='27' /> <font color="red">*</font>
        </td>
      </tr>
      <tr>
        <td class="label"><?php echo $this->_var['lang']['belong_city']; ?>:</td>
        <td>
            <select name="province" id="selProvinces" onchange="region.changed(this, 2, 'selCities')">
              <option value="0"><?php echo $this->_var['lang']['select_please']; ?></option>
              <?php $_from = $this->_var['province_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'province');if (count($_from)):
    foreach ($_from AS $this->_var['province']):
?>
              <option value="<?php echo $this->_var['province']['region_id']; ?>"<?php if ($this->_var['pickup_point']['province_id'] == $this->_var['province']['region_id']): ?>selected="selected"<?php endif; ?>><?php echo $this->_var['province']['region_name']; ?></option>
              <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </select>
            <select name="city" id="selCities" onchange="region.changed(this, 3, 'selDistricts')">
              <option value="0"><?php echo $this->_var['lang']['select_please']; ?></option>
              <?php $_from = $this->_var['city_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'city');if (count($_from)):
    foreach ($_from AS $this->_var['city']):
?>
              <option value="<?php echo $this->_var['city']['region_id']; ?>"<?php if ($this->_var['pickup_point']['city_id'] == $this->_var['city']['region_id']): ?>selected="selected"<?php endif; ?>><?php echo $this->_var['city']['region_name']; ?></option>
              <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </select>
            <select name="district" id="selDistricts">
              <option value="0"><?php echo $this->_var['lang']['select_please']; ?></option>
              <?php $_from = $this->_var['district_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'district');if (count($_from)):
    foreach ($_from AS $this->_var['district']):
?>
              <option value="<?php echo $this->_var['district']['region_id']; ?>"<?php if ($this->_var['pickup_point']['district_id'] == $this->_var['district']['region_id']): ?>selected="selected"<?php endif; ?>><?php echo $this->_var['district']['region_name']; ?></option>
              <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </select>
        </td>
      </tr>
      </table>
      <div class="button-div">
        <input type="submit" value="<?php echo $this->_var['lang']['button_submit']; ?>" />
        <input type="reset" value="<?php echo $this->_var['lang']['button_reset']; ?>" />
      </div>
    <input type="hidden" name="act" value="<?php echo $this->_var['form_action']; ?>" />
    <input type="hidden" name="id" value="<?php echo $this->_var['pickup_point']['id']; ?>" />
  </form>
</div>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,validator.js')); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/transport.org.js,../js/region.js')); ?>

<script language="JavaScript">
region.isAdmin = true;
<!--
document.forms['theForm'].elements['cat_name'].focus();
/**
 * 检查表单输入的数据
 */
function validate()
{
  validator = new Validator("theForm");
  validator.required("shop_name",      '<?php echo $this->_var['lang']['shop_name_empty']; ?>');
  validator.required("address",      '<?php echo $this->_var['lang']['address_empty']; ?>');
  validator.required("contact",      '<?php echo $this->_var['lang']['contact_empty']; ?>');
  validator.required("phone",      '<?php echo $this->_var['lang']['phone_empty']; ?>');
  if (parseInt(document.forms['theForm'].elements['province'].value) == 0 || parseInt(document.forms['theForm'].elements['city'].value) == 0)
  {
    validator.addErrorMsg('<?php echo $this->_var['lang']['select_province']; ?>');
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