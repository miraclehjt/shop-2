<!-- $Id: bonus_type_info.htm 14216 2008-03-10 02:27:21Z testyang $ -->

<script type="text/javascript" src="../js/calendar.php?lang=<?php echo $this->_var['cfg_lang']; ?>"></script>
<link href="../js/calendar/calendar.css" rel="stylesheet" type="text/css" />

<?php echo $this->fetch('pageheader.htm'); ?>
<div class="main-div">
<form action="bonus.php" method="post" name="theForm" enctype="multipart/form-data" onsubmit="return validate()">
<table width="100%">
  <tr>
    <td class="label"><?php echo $this->_var['lang']['type_name']; ?></td>
    <td>
      <input type='text' name='type_name' maxlength="30" value="<?php echo $this->_var['bonus_arr']['type_name']; ?>" size='20' />    </td>
  </tr>
  <tr>
    <td class="label">
      <a href="javascript:showNotice('Type_money_a');" title="<?php echo $this->_var['lang']['form_notice']; ?>">
      <img src="images/notice.gif" width="16" height="16" border="0" alt="<?php echo $this->_var['lang']['form_notice']; ?>"></a><?php echo $this->_var['lang']['type_money']; ?></td>
    <td>
    <input type="text" name="type_money" value="<?php echo $this->_var['bonus_arr']['type_money']; ?>" size="20" />
    <br /><span class="notice-span" <?php if ($this->_var['help_open']): ?>style="display:block" <?php else: ?> style="display:none" <?php endif; ?> id="Type_money_a"><?php echo $this->_var['lang']['type_money_notic']; ?></span>    </td>
  </tr>
  <tr>
    <td class="label"><a href="javascript:showNotice('NoticeMinGoodsAmount');" title="<?php echo $this->_var['lang']['form_notice']; ?>"> <img src="images/notice.gif" width="16" height="16" border="0" alt="<?php echo $this->_var['lang']['form_notice']; ?>" /></a><?php echo $this->_var['lang']['min_goods_amount']; ?></td>
    <td><input name="min_goods_amount" type="text" id="min_goods_amount" value="<?php echo $this->_var['bonus_arr']['min_goods_amount']; ?>" size="20" />
    <br /><span class="notice-span" <?php if ($this->_var['help_open']): ?>style="display:block" <?php else: ?> style="display:none" <?php endif; ?> id="NoticeMinGoodsAmount"><?php echo $this->_var['lang']['notice_min_goods_amount']; ?></span> </td>
  </tr>
  <tr>
    <td class="label"><?php echo $this->_var['lang']['send_method']; ?></td>
    <td>
      <input type="radio" name="send_type" value="0" <?php if ($this->_var['bonus_arr']['send_type'] == 0): ?> checked="true" <?php endif; ?> onClick="showunit(0)"  /><?php echo $this->_var['lang']['send_by']['0']; ?>
      <input type="radio" name="send_type" value="1" <?php if ($this->_var['bonus_arr']['send_type'] == 1): ?> checked="true" <?php endif; ?> onClick="showunit(1)"  /><?php echo $this->_var['lang']['send_by']['1']; ?>
      <input type="radio" name="send_type" value="2" <?php if ($this->_var['bonus_arr']['send_type'] == 2): ?> checked="true" <?php endif; ?> onClick="showunit(2)"  /><?php echo $this->_var['lang']['send_by']['2']; ?>
      <input type="radio" name="send_type" value="3" <?php if ($this->_var['bonus_arr']['send_type'] == 3): ?> checked="true" <?php endif; ?> onClick="showunit(3)"  /><?php echo $this->_var['lang']['send_by']['3']; ?>    </td>
  </tr>
  <tr id="1" style="display:none">
    <td class="label">
      <a href="javascript:showNotice('Order_money_a');" title="<?php echo $this->_var['lang']['form_notice']; ?>">
      <img src="images/notice.gif" width="16" height="16" border="0" alt="<?php echo $this->_var['lang']['form_notice']; ?>"></a><?php echo $this->_var['lang']['min_amount']; ?></td>
    <td>
      <input name="min_amount" type="text" id="min_amount" value="<?php echo $this->_var['bonus_arr']['min_amount']; ?>" size="20" />
      <br /><span class="notice-span" <?php if ($this->_var['help_open']): ?>style="display:block" <?php else: ?> style="display:none" <?php endif; ?> id="Order_money_a"><?php echo $this->_var['lang']['order_money_notic']; ?></span>    </td>
  </tr>
  <tr>
    <td class="label">
      <a href="javascript:showNotice('Send_start_a');" title="<?php echo $this->_var['lang']['form_notice']; ?>">
      <img src="images/notice.gif" width="16" height="16" border="0" alt="<?php echo $this->_var['lang']['form_notice']; ?>"></a><?php echo $this->_var['lang']['send_startdate']; ?></td>
    <td>
      <input name="send_start_date" type="text" id="send_start_date" size="22" value='<?php echo $this->_var['bonus_arr']['send_start_date']; ?>' readonly="readonly" /><input name="selbtn1" type="button" id="selbtn1" onclick="return showCalendar('send_start_date', '%Y-%m-%d', false, false, 'selbtn1');" value="<?php echo $this->_var['lang']['btn_select']; ?>" class="button"/>
      <br /><span class="notice-span" <?php if ($this->_var['help_open']): ?>style="display:block" <?php else: ?> style="display:none" <?php endif; ?> id="Send_start_a"><?php echo $this->_var['lang']['send_startdate_notic']; ?></span>    </td>
  </tr>
  <tr>
    <td class="label"><?php echo $this->_var['lang']['send_enddate']; ?></td>
    <td>
      <input name="send_end_date" type="text" id="send_end_date" size="22" value='<?php echo $this->_var['bonus_arr']['send_end_date']; ?>' readonly="readonly" /><input name="selbtn2" type="button" id="selbtn2" onclick="return showCalendar('send_end_date', '%Y-%m-%d', false, false, 'selbtn2');" value="<?php echo $this->_var['lang']['btn_select']; ?>" class="button"/>    </td>
  </tr>
  <tr>
    <td class="label">
	  <a href="javascript:showNotice('Use_start_a');" title="<?php echo $this->_var['lang']['form_notice']; ?>">
      <img src="images/notice.gif" width="16" height="16" border="0" alt="<?php echo $this->_var['lang']['form_notice']; ?>"></a>
	<?php echo $this->_var['lang']['use_startdate']; ?></td>
    <td>
      <input name="use_start_date" type="text" id="use_start_date" size="22" value='<?php echo $this->_var['bonus_arr']['use_start_date']; ?>' readonly="readonly" /><input name="selbtn3" type="button" id="selbtn3" onclick="return showCalendar('use_start_date', '%Y-%m-%d', false, false, 'selbtn3');" value="<?php echo $this->_var['lang']['btn_select']; ?>" class="button"/>
	  <br /><span class="notice-span" <?php if ($this->_var['help_open']): ?>style="display:block" <?php else: ?> style="display:none" <?php endif; ?> id="Use_start_a"><?php echo $this->_var['lang']['use_startdate_notic']; ?></span>    </td>
  </tr>
  <tr>
    <td class="label"><?php echo $this->_var['lang']['use_enddate']; ?></td>
    <td>
      <input name="use_end_date" type="text" id="use_end_date" size="22" value='<?php echo $this->_var['bonus_arr']['use_end_date']; ?>' readonly="readonly" /><input name="selbtn4" type="button" id="selbtn4" onclick="return showCalendar('use_end_date', '%Y-%m-%d', false, false, 'selbtn4');" value="<?php echo $this->_var['lang']['btn_select']; ?>" class="button"/>    </td>
  </tr>
  <tr>
    <td class="label">&nbsp;</td>
    <td>
      <input type="submit" value="<?php echo $this->_var['lang']['button_submit']; ?>" class="button" />
      <input type="reset" value="<?php echo $this->_var['lang']['button_reset']; ?>" class="button" />
      <input type="hidden" name="act" value="<?php echo $this->_var['form_act']; ?>" />
      <input type="hidden" name="type_id" value="<?php echo $this->_var['bonus_arr']['type_id']; ?>" />    </td>
  </tr>
</table>
</form>
</div>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,validator.js')); ?>

<script language="javascript">
<!--
document.forms['theForm'].elements['type_name'].focus();
/**
 * 检查表单输入的数据
 */
function validate()
{
  validator = new Validator("theForm");
  validator.required("type_name",      type_name_empty);
  validator.required("type_money",     type_money_empty);
  validator.isNumber("type_money",     type_money_isnumber, true);
  validator.islt('send_start_date', 'send_end_date', send_start_lt_end);
  validator.islt('use_start_date', 'use_end_date', use_start_lt_end);
  if (document.getElementById(1).style.display == "")
  {
    var minAmount = parseFloat(document.forms['theForm'].elements['min_amount'].value);
    if (isNaN(minAmount) || minAmount <= 0)
    {
	  validator.addErrorMsg(invalid_min_amount);
    }	
  }
  return validator.passed();
}
onload = function()
{
  
  get_value = '<?php echo $this->_var['bonus_arr']['send_type']; ?>';
  

  showunit(get_value)
  // 开始检查订单
  startCheckOrder();
}
/* 红包类型按订单金额发放时才填写 */
function gObj(obj)
{
  var theObj;
  if (document.getElementById)
  {
    if (typeof obj=="string") {
      return document.getElementById(obj);
    } else {
      return obj.style;
    }
  }
  return null;
}

function showunit(get_value)
{
  gObj("1").style.display =  (get_value == 2) ? "" : "none";
  document.forms['theForm'].elements['selbtn1'].disabled  = (get_value != 1 && get_value != 2);
  document.forms['theForm'].elements['selbtn2'].disabled  = (get_value != 1 && get_value != 2);

  return;
}
//-->
</script>

<?php echo $this->fetch('pagefooter.htm'); ?>
