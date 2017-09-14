<!-- $Id: order_query.htm 14216 2008-03-10 02:27:21Z testyang $ -->
<?php echo $this->fetch('pageheader.htm'); ?>
<script type="text/javascript" src="../js/calendar.php"></script>
<link href="../js/calendar/calendar.css" rel="stylesheet" type="text/css" />
<div class="main-div">
<form action="order.php?act=list" method="post" enctype="multipart/form-data" name="searchForm">
  <table cellspacing="1" cellpadding="3" width="100%">
    <tr>
      <td align="right"><?php echo $this->_var['lang']['label_order_sn']; ?></td>
      <td><input name="order_sn" type="text" id="order_sn" size="30"></td>
      <td align="right"><?php echo $this->_var['lang']['label_email']; ?></td>
      <td><input name="email" type="text" id="email" size="30"></td>
    </tr>
    <tr>
      <td align="right"><?php echo $this->_var['lang']['label_user_name']; ?></td>
      <td><input name="user_name" type="text" id="user_name" size="30"></td>
      <td align="right"><?php echo $this->_var['lang']['label_consignee']; ?></td>
      <td><input name="consignee" type="text" id="consignee" size="30"></td>
    </tr>
    <tr>
      <td align="right"><?php echo $this->_var['lang']['label_address']; ?></td>
      <td><input name="address" type="text" id="address" size="30"></td>
      <td align="right"><?php echo $this->_var['lang']['label_zipcode']; ?></td>
      <td><input name="zipcode" type="text" id="zipcode" size="30"></td>
    </tr>
    <tr>
      <td align="right"><?php echo $this->_var['lang']['label_tel']; ?></td>
      <td><input name="tel" type="text" id="tel" size="30"></td>
      <td align="right"><?php echo $this->_var['lang']['label_mobile']; ?></td>
      <td><input name="mobile" type="text" id="mobile" size="30"></td>
    </tr>
    <tr>
      <td align="right"><?php echo $this->_var['lang']['label_area']; ?></td>
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
      <td align="right"><?php echo $this->_var['lang']['label_shipping']; ?></td>
      <td><select name="shipping_id" id="select4">
        <option value="0"><?php echo $this->_var['lang']['select_please']; ?></option>
        <?php $_from = $this->_var['shipping_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'shipping');if (count($_from)):
    foreach ($_from AS $this->_var['shipping']):
?>
        <option value="<?php echo $this->_var['shipping']['shipping_id']; ?>"><?php echo $this->_var['shipping']['shipping_name']; ?></option>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </select></td>
      <td align="right"><?php echo $this->_var['lang']['label_payment']; ?></td>
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
      <td align="right"><?php echo $this->_var['lang']['label_time']; ?></td>
      <td colspan="3">
      <input type="text" name="start_time" maxlength="60" size="30" readonly="readonly" id="start_time_id" />
      <input name="start_time_btn" type="button" id="start_time_btn" onclick="return showCalendar('start_time_id', '%Y-%m-%d %H:%M', '24', false, 'start_time_btn');" value="<?php echo $this->_var['lang']['btn_select']; ?>" class="button"/>
      ~      
      <input type="text" name="end_time" maxlength="60" size="30" readonly="readonly" id="end_time_id" />
      <input name="end_time_btn" type="button" id="end_time_btn" onclick="return showCalendar('end_time_id', '%Y-%m-%d %H:%M', '24', false, 'end_time_btn');" value="<?php echo $this->_var['lang']['btn_select']; ?>" class="button"/>  
      </td>
    </tr>
    <tr>
      <td align="right"><?php echo $this->_var['lang']['label_order_status']; ?></td>
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
