<!-- $Id: order_query.htm 14216 2008-03-10 02:27:21Z testyang $ -->
<?php echo $this->fetch('pageheader.htm'); ?>
<script type="text/javascript" src="../js/calendar.php"></script>
<link href="../js/calendar/calendar.css" rel="stylesheet" type="text/css" />
<div class="main-div">
<form action="order.php?act=list" method="post" enctype="multipart/form-data" name="searchForm">
  <table cellspacing="1" cellpadding="3" width="100%">
    <tr>
      <td><div align="right"><strong><?php echo $this->_var['lang']['label_order_sn']; ?></strong></div></td>
      <td colspan="3"><input name="order_sn" type="text" id="order_sn" size="30"></td>
    </tr>
    <tr>
      <td><div align="right"><strong><?php echo $this->_var['lang']['label_email']; ?></strong></div></td>
      <td colspan="3"><input name="email" type="text" id="email" size="40"></td>
    </tr>
    <tr>
      <td><div align="right"><strong><?php echo $this->_var['lang']['label_user_name']; ?></strong></div></td>
      <td><input name="user_name" type="text" id="user_name" size="20"></td>
      <td><div align="right"><strong><?php echo $this->_var['lang']['label_consignee']; ?></strong></div></td>
      <td><input name="consignee" type="text" id="consignee" size="20"></td>
    </tr>
    <tr>
      <td><div align="right"><strong><?php echo $this->_var['lang']['label_address']; ?></strong></div></td>
      <td><input name="address" type="text" id="address" size="20"></td>
      <td><div align="right"><strong><?php echo $this->_var['lang']['label_zipcode']; ?></strong></div></td>
      <td><input name="zipcode" type="text" id="zipcode" size="20"></td>
    </tr>
    <tr>
      <td><div align="right"><strong><?php echo $this->_var['lang']['label_tel']; ?></strong></div></td>
      <td><input name="tel" type="text" id="tel" size="20"></td>
      <td><div align="right"><strong><?php echo $this->_var['lang']['label_mobile']; ?></strong></div></td>
      <td><input name="mobile" type="text" id="mobile" size="20"></td>
    </tr>
    <tr>
      <td><div align="right"><strong><?php echo $this->_var['lang']['label_area']; ?></strong></div></td>
      <td colspan="3"><select name="country" id="selCountries" onchange="region.changed(this, 1, 'selProvinces')">
          <option value="0"><?php echo $this->_var['lang']['select_please']; ?></option>
          <?php $_from = $this->_var['country_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'country');if (count($_from)):
    foreach ($_from AS $this->_var['country']):
?>
          <option value="<?php echo $this->_var['country']['region_id']; ?>"><?php echo $this->_var['country']['region_name']; ?></option>
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      </select>
        <select name="province" id="selProvinces" onchange="region.changed(this, 2, 'selCities')">
          <option value="0"><?php echo $this->_var['lang']['select_please']; ?></option>
        </select>
        <select name="city" id="selCities" onchange="region.changed(this, 3, 'selDistricts')">
          <option value="0"><?php echo $this->_var['lang']['select_please']; ?></option>
        </select>
        <select name="district" id="selDistricts">
          <option value="0"><?php echo $this->_var['lang']['select_please']; ?></option>
        </select></td>
      </tr>
    <tr>
      <td><div align="right"><strong><?php echo $this->_var['lang']['label_shipping']; ?></strong></div></td>
      <td><select name="shipping_id" id="select4">
        <option value="0"><?php echo $this->_var['lang']['select_please']; ?></option>
        <?php $_from = $this->_var['shipping_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'shipping');if (count($_from)):
    foreach ($_from AS $this->_var['shipping']):
?>
        <option value="<?php echo $this->_var['shipping']['shipping_id']; ?>"><?php echo $this->_var['shipping']['shipping_name']; ?></option>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </select></td>
      <td><div align="right"><strong><?php echo $this->_var['lang']['label_payment']; ?></strong></div></td>
      <td><select name="pay_id" id="select5">
        <option value="0"><?php echo $this->_var['lang']['select_please']; ?></option>
        <?php $_from = $this->_var['pay_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'pay');if (count($_from)):
    foreach ($_from AS $this->_var['pay']):
?>
        <option value="<?php echo $this->_var['pay']['pay_id']; ?>"><?php echo $this->_var['pay']['pay_name']; ?></option>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </select></td>
    </tr>
    <tr>
      <td><div align="right"><strong><?php echo $this->_var['lang']['label_time']; ?></strong></div></td>
      <td>
      <input type="text" name="start_time" maxlength="60" size="20" readonly="readonly" id="start_time_id" />
      <input name="start_time_btn" type="button" id="start_time_btn" onclick="return showCalendar('start_time_id', '%Y-%m-%d %H:%M', '24', false, 'start_time_btn');" value="<?php echo $this->_var['lang']['btn_select']; ?>" class="button"/>
      ~      
      <input type="text" name="end_time" maxlength="60" size="20" readonly="readonly" id="end_time_id" />
      <input name="end_time_btn" type="button" id="end_time_btn" onclick="return showCalendar('end_time_id', '%Y-%m-%d %H:%M', '24', false, 'end_time_btn');" value="<?php echo $this->_var['lang']['btn_select']; ?>" class="button"/>  
      </td>
    </tr>
    <tr>
      <td><div align="right"><strong><?php echo $this->_var['lang']['label_order_status']; ?></strong></div></td>
      <td colspan="3">
        <select name="order_status" id="select9">
          <option value="-1"><?php echo $this->_var['lang']['select_please']; ?></option>
          <?php echo $this->html_options(array('options'=>$this->_var['os_list'],'selected'=>'-1')); ?>
        </select>
        <strong><?php echo $this->_var['lang']['label_pay_status']; ?></strong>        <select name="pay_status" id="select11">
          <option value="-1"><?php echo $this->_var['lang']['select_please']; ?></option>
          <?php echo $this->html_options(array('options'=>$this->_var['ps_list'],'selected'=>'-1')); ?>
        </select>
        <strong><?php echo $this->_var['lang']['label_shipping_status']; ?></strong>        <select name="shipping_status" id="select10">
          <option value="-1"><?php echo $this->_var['lang']['select_please']; ?></option>
          <?php echo $this->html_options(array('options'=>$this->_var['ss_list'],'selected'=>'-1')); ?>
        </select></td>
    </tr>
    <tr>
      <td colspan="4"><div align="center">
        <input name="query" type="submit" class="button" id="query" value="<?php echo $this->_var['lang']['button_search']; ?>" />
        <input name="reset" type="reset" class='button' value='<?php echo $this->_var['lang']['button_reset']; ?>' />
      </div></td>
      </tr>
  </table>
</form>
</div>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/transport.org.js,../js/region.js')); ?>

<script language="JavaScript">
region.isAdmin = true;
onload = function()
{
  // 开始检查订单
  startCheckOrder();
}
</script>

<?php echo $this->fetch('pagefooter.htm'); ?>
