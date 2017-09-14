<!-- $Id: shipping_area_info.htm 16819 2009-11-25 06:21:17Z sxc_shop $ -->
<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'validator.js,../js/transport.org.js,../js/region.js')); ?>
<div class="main-div">
<form method="post" action="shipping_area.php" name="theForm" onsubmit="return validate()" style="background:#FFF">
<fieldset style="border:1px solid #DDEEF2">
  <table >
    <tr>
      <td class="label"><?php echo $this->_var['lang']['shipping_area_name']; ?>:</td>
<td><input type="text" name="shipping_area_name" maxlength="60" size="30" value="<?php echo $this->_var['shipping_area']['shipping_area_name']; ?>" /><?php echo $this->_var['lang']['require_field']; ?></td>
    </tr>
  <?php if ($this->_var['shipping_area']['shipping_code'] == 'ems' || $this->_var['shipping_area']['shipping_code'] == 'yto' || $this->_var['shipping_area']['shipping_code'] == 'zto' || $this->_var['shipping_area']['shipping_code'] == 'sto_express' || $this->_var['shipping_area']['shipping_code'] == 'post_mail' || $this->_var['shipping_area']['shipping_code'] == 'sf_express' || $this->_var['shipping_area']['shipping_code'] == 'post_express' || $this->_var['shipping_area']['shipping_code'] == 'yd_express' || $this->_var['shipping_area']['shipping_code'] == 'bestex' || $this->_var['shipping_area']['shipping_code'] == 'ttkd' || $this->_var['shipping_area']['shipping_code'] == 'zjs' || $this->_var['shipping_area']['shipping_code'] == 'qfkd' || $this->_var['shipping_area']['shipping_code'] == 'deppon' || $this->_var['shipping_area']['shipping_code'] == 'tc_express' || $this->_var['shipping_area']['shipping_code'] == 'pups'): ?>
    <tr>
    <td class="label"><?php echo $this->_var['lang']['fee_compute_mode']; ?>:</td>
    <td>
    <input type="radio"  <?php if ($this->_var['fee_compute_mode'] != 'by_number'): ?>checked="true"<?php endif; ?> onclick="compute_mode('<?php echo $this->_var['shipping_area']['shipping_code']; ?>','weight')" name="fee_compute_mode" value="by_weight" /><?php echo $this->_var['lang']['fee_by_weight']; ?>
    <input type="radio" <?php if ($this->_var['fee_compute_mode'] == 'by_number'): ?>checked="true"<?php endif; ?>  onclick="compute_mode('<?php echo $this->_var['shipping_area']['shipping_code']; ?>','number')" name="fee_compute_mode" value="by_number" /><?php echo $this->_var['lang']['fee_by_number']; ?>
    </td>
    </tr>
  <?php endif; ?>

<!--<?php if ($this->_var['shipping_area']['shipping_code'] != 'cac'): ?>-->
    <?php $_from = $this->_var['fields']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'field');if (count($_from)):
    foreach ($_from AS $this->_var['field']):
?>
    <!--<?php if ($this->_var['fee_compute_mode'] == 'by_number'): ?>-->
       <!--<?php if ($this->_var['field']['name'] == 'item_fee' || $this->_var['field']['name'] == 'free_money' || $this->_var['field']['name'] == 'pay_fee'): ?>-->
            <tr id="<?php echo $this->_var['field']['name']; ?>" >
              <td class="label"><?php echo $this->_var['field']['label']; ?></td>
              <td><input type="text" name="<?php echo $this->_var['field']['name']; ?>"  maxlength="60" size="20" value="<?php echo $this->_var['field']['value']; ?>" /><?php echo $this->_var['lang']['require_field']; ?></td>
            </tr>
            <!--<?php else: ?>-->
            <tr id="<?php echo $this->_var['field']['name']; ?>" style="display:none">
              <td class="label"><?php echo $this->_var['field']['label']; ?></td>
              <td><input type="text" name="<?php echo $this->_var['field']['name']; ?>"  maxlength="60" size="20" value="<?php echo $this->_var['field']['value']; ?>" /><?php echo $this->_var['lang']['require_field']; ?></td>
            </tr>
        <!--<?php endif; ?>-->
    <!--<?php else: ?>-->
        <!--<?php if ($this->_var['field']['name'] != 'item_fee'): ?>-->
            <tr id="<?php echo $this->_var['field']['name']; ?>" >		
              <td class="label"><?php echo $this->_var['field']['label']; ?></td>
              <td><input type="text" name="<?php echo $this->_var['field']['name']; ?>"  maxlength="60" size="20" value="<?php echo $this->_var['field']['value']; ?>" /><?php echo $this->_var['lang']['require_field']; ?></td>
            </tr>
        <!--<?php else: ?>-->
            <tr id="<?php echo $this->_var['field']['name']; ?>" style="display:none">
              <td class="label"><?php echo $this->_var['field']['label']; ?></td>
              <td><input type="text" name="<?php echo $this->_var['field']['name']; ?>"  maxlength="60" size="20" value="<?php echo $this->_var['field']['value']; ?>" /><?php echo $this->_var['lang']['require_field']; ?></td>
            </tr>
        <!--<?php endif; ?>-->
     <!--<?php endif; ?>-->
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
<!--<?php endif; ?>-->
  </table>
</fieldset>

<fieldset style="border:1px solid #DDEEF2">
  <legend style="background:#FFF"><?php echo $this->_var['lang']['shipping_area_regions']; ?>:</legend>
  <table style="width:600px" align="center">
  <tr>
    <td id="regionCell">
      <?php $_from = $this->_var['regions']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('id', 'region');if (count($_from)):
    foreach ($_from AS $this->_var['id'] => $this->_var['region']):
?>
      <input type="checkbox" name="regions[]" value="<?php echo $this->_var['id']; ?>" checked="true" /> <?php echo $this->_var['region']; ?>&nbsp;&nbsp;
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </td>
  </tr>
  <tr>
    <td>
        <span  style="vertical-align: top"><?php echo $this->_var['lang']['label_country']; ?> </span>
        <select name="country" id="selCountries" onchange="region.changed(this, 1, 'selProvinces')" size="10" style="width:80px">
          <?php $_from = $this->_var['countries']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'country');if (count($_from)):
    foreach ($_from AS $this->_var['country']):
?>
          <option value="<?php echo $this->_var['country']['region_id']; ?>"><?php echo htmlspecialchars($this->_var['country']['region_name']); ?></option>
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </select>
        <span  style="vertical-align: top"><?php echo $this->_var['lang']['label_province']; ?> </span>
        <select name="province" id="selProvinces" onchange="region.changed(this, 2, 'selCities')" size="10" style="width:80px">
          <option value=''><?php echo $this->_var['lang']['select_please']; ?></option>
        </select>
        <span  style="vertical-align: top"><?php echo $this->_var['lang']['label_city']; ?> </span>
        <select name="city" id="selCities" onchange="region.changed(this, 3, 'selDistricts')" size="10" style="width:80px">
          <option value=''><?php echo $this->_var['lang']['select_please']; ?></option>
        </select>
        <span  style="vertical-align: top"><?php echo $this->_var['lang']['label_district']; ?></span>
        <select name="district" id="selDistricts" size="10" style="width:130px">
          <option value=''><?php echo $this->_var['lang']['select_please']; ?></option>
        </select>
        <span  style="vertical-align: top"><input type="button" value="+" class="button" onclick="addRegion()" /></span>
    </td>
  </tr>
  </table >
</fieldset>

  <table >
  <tr>
    <td colspan="2" align="center">
      <input type="submit" value="<?php echo $this->_var['lang']['button_submit']; ?>" class="button" />
      <input type="reset" value="<?php echo $this->_var['lang']['button_reset']; ?>" class="button" />
      <input type="hidden" name="act" value="<?php echo $this->_var['form_action']; ?>" />
      <input type="hidden" name="id" value="<?php echo $this->_var['shipping_area']['shipping_area_id']; ?>" />
      <input type="hidden" name="shipping" value="<?php echo $this->_var['shipping_area']['shipping_id']; ?>" />
    </td>
  </tr>
</table>

</form>
</div>
<script language="JavaScript">
<!--

region.isAdmin = true;
onload = function()
{
    document.forms['theForm'].elements['shipping_area_name'].focus();

    var selCountry = document.forms['theForm'].elements['country'];
    if (selCountry.selectedIndex <= 0)
    {
      selCountry.selectedIndex = 0;
    }

    region.loadProvinces(selCountry.options[selCountry.selectedIndex].value);

    // 开始检查订单
    startCheckOrder();
}

/**
 * 检查表单输入的数据
 */
function validate()
{
    validator = new Validator("theForm");

    validator.required('shipping_area_name', no_area_name);
    if(document.forms['free_money']){
    	validator.isInt('free_money', invalid_free_mondy, true);
    }
    var regions_chk_cnt = 0;
    for (i=0; i<document.getElementsByName('regions[]').length; i++)
    {
      if (document.getElementsByName('regions[]')[i].checked == true)
      {
        regions_chk_cnt++;
      }
    }

    if (regions_chk_cnt == 0)
    {
      validator.addErrorMsg(blank_shipping_area);
    }
    
    return validator.passed();
}

/**
 * 添加一个区域
 */
function addRegion()
{
    var selCountry  = document.forms['theForm'].elements['country'];
    var selProvince = document.forms['theForm'].elements['province'];
    var selCity     = document.forms['theForm'].elements['city'];
    var selDistrict = document.forms['theForm'].elements['district'];
    var regionCell  = document.getElementById("regionCell");

    if (selDistrict.selectedIndex > 0)
    {
        regionId = selDistrict.options[selDistrict.selectedIndex].value;
        regionName = selDistrict.options[selDistrict.selectedIndex].text;
    }
    else
    {
        if (selCity.selectedIndex > 0)
        {
            regionId = selCity.options[selCity.selectedIndex].value;
            regionName = selCity.options[selCity.selectedIndex].text;
        }
        else
        {
            if (selProvince.selectedIndex > 0)
            {
                regionId = selProvince.options[selProvince.selectedIndex].value;
                regionName = selProvince.options[selProvince.selectedIndex].text;
            }
            else
            {
                if (selCountry.selectedIndex >= 0)
                {
                    regionId = selCountry.options[selCountry.selectedIndex].value;
                    regionName = selCountry.options[selCountry.selectedIndex].text;
                }
                else
                {
                    return;
                }
            }
        }
    }

    // 检查该地区是否已经存在
    exists = false;
    for (i = 0; i < document.forms['theForm'].elements.length; i++)
    {
      if (document.forms['theForm'].elements[i].type=="checkbox")
      {
        if (document.forms['theForm'].elements[i].value == regionId)
        {
          exists = true;
          alert(region_exists);
        }
      }
    }
    // 创建checkbox
    if (!exists)
    {
      regionCell.innerHTML += "<input type='checkbox' name='regions[]' value='" + regionId + "' checked='true' /> " + regionName + "&nbsp;&nbsp;";
    }
}

/**
 * 配送费用计算方式
 */
function compute_mode(shipping_code,mode)
{
    var base_fee  = document.getElementById("base_fee");
    var step_fee  = document.getElementById("step_fee");
    var item_fee  = document.getElementById("item_fee");
    if(shipping_code == 'post_mail' || shipping_code == 'post_express')
    {
     var step_fee1  = document.getElementById("step_fee1");
    }

    if(mode == 'number')
    {
      item_fee.style.display = '';
      base_fee.style.display = 'none';
      step_fee.style.display = 'none';
      if(shipping_code == 'post_mail' || shipping_code == 'post_express')
      {
       step_fee1.style.display = 'none';
      }
    }
    else
    {
      item_fee.style.display = 'none';
      base_fee.style.display = '';
      step_fee.style.display = '';
      if(shipping_code == 'post_mail' || shipping_code == 'post_express')
      {
       step_fee1.style.display = '';
      }
    }
}
//-->

</script>
<?php echo $this->fetch('pagefooter.htm'); ?>
