/* $Id : shopping_flow.js 4865 2007-01-31 14:04:10Z paulgao $ */

var selectedShipping = null;
var selectedPayment  = null;
var selectedPack     = null;
var selectedCard     = null;
var selectedSurplus  = '';
var selectedBonus    = 0;
var selectedIntegral = 0;
var selectedOOS      = null;
var alertedSurplus   = false;

var groupBuyShipping = null;
var groupBuyPayment  = null;

var selected_pay_code = null;


function selectShipping(recid, suppid) {
	$('#desc_'+suppid).html($('#ship_'+suppid+'_'+recid).attr('title'));//显示配送描述的地方
	Ajax.call('flow.php?step=select_shipping', 'recid=' + recid + '&suppid=' + suppid, orderShipping, 'GET', 'JSON');

}
function orderShipping(result) {
	if (result.error) {
		alert(result.error);
	} else {
		
		orderSelectedResponse(result.content);
		if (document.getElementById('picktxt' + result.suppid)) {
			document.getElementById('picktxt' + result.suppid).innerHTML = result.picktxt;
		}

		//联运触发余额如果余额是选中状态
		if($('#issurplus').attr('checked') != 'undefined' && $('#issurplus').attr('checked')){
			$('#issurplus').attr('checked',false).trigger("click").attr('checked',false);
		}
	}
} 

/* *
 * 改变配送方式
 */
function selectShipping_old(obj)
{
  if (selectedShipping == obj)
  {
    return;
  }
  else
  {
    selectedShipping = obj;
  }

  var supportCod = obj.attributes['supportCod'].value*1;
  var supportPickup =0;
  if(obj.attributes['supoortPickup']){
	  supportPickup = obj.attributes['supoortPickup'].value * 1;
	  if (supportPickup == 0)
	  {
		  document.getElementById('pickup_point_box').style.display = 'none';
	  }else{
		  document.getElementById('pickup_point_box').style.display = '';
	  }
  }

  var theForm = obj.form;

  for (i = 0; i < theForm.elements.length; i ++ )
  {
    if (theForm.elements[i].name == 'payment' && theForm.elements[i].attributes['isCod'].value == '1')
    {
      if (supportCod == 0)
      {
        theForm.elements[i].checked = false;
        theForm.elements[i].disabled = true;
      }
      else
      {
        theForm.elements[i].disabled = false;
      }
    }
	
  }
  

  if (obj.attributes['insure'].value + 0 == 0)
  {
    document.getElementById('ECS_NEEDINSURE').checked = false;
    document.getElementById('ECS_NEEDINSURE').disabled = true;
  }
  else
  {
    document.getElementById('ECS_NEEDINSURE').checked = false;
    document.getElementById('ECS_NEEDINSURE').disabled = false;
  }

  var now = new Date();
  Ajax.call('flow.php?step=select_shipping', 'shipping=' + obj.value + '&pickup='+supportPickup, orderShippingSelectedResponse, 'GET', 'JSON');
}

/**
 *
 */
function orderShippingSelectedResponse(result)
{
  if (result.need_insure)
  {
    try
    {
      document.getElementById('ECS_NEEDINSURE').checked = true;
    }
    catch (ex)
    {
      alert(ex.message);
    }
  }

  try
  {
    if (document.getElementById('ECS_CODFEE') != undefined)
    {
      document.getElementById('ECS_CODFEE').innerHTML = result.cod_fee;
    }
  }
  catch (ex)
  {
    alert(ex.message);
  }
   
   if (document.getElementById('supplier_shipping') != undefined)
   {
		document.getElementById('supplier_shipping').innerHTML = result.supplier_shipping;
    }
	if(document.getElementById('pickup_point_box')){
		document.getElementById('pickup_point_box').innerHTML = result.pickup_content;
	}

  orderSelectedResponse(result);
}

/* *
 * 改变支付方式
 */
function selectPayment(obj)
{
  if (selectedPayment == obj)
  {
    return;
  }
  else
  {
	  selectedPayment = obj;	  
  }

  Ajax.call('flow.php?step=select_payment', 'payment=' + obj.value, orderSelectedResponse, 'GET', 'JSON');
}

/* *
 * 团购购物流程 --> 改变配送方式
 */
function handleGroupBuyShipping(obj)
{
  if (groupBuyShipping == obj)
  {
    return;
  }
  else
  {
    groupBuyShipping = obj;
  }

  var supportCod = obj.attributes['supportCod'].value + 0;
  var theForm = obj.form;

  for (i = 0; i < theForm.elements.length; i ++ )
  {
    if (theForm.elements[i].name == 'payment' && theForm.elements[i].attributes['isCod'].value == '1')
    {
      if (supportCod == 0)
      {
        theForm.elements[i].checked = false;
        theForm.elements[i].disabled = true;
      }
      else
      {
        theForm.elements[i].disabled = false;
      }
    }
  }

  var selected_pay_code = null;

  if (obj.attributes['insure'].value + 0 == 0)
  {
    document.getElementById('ECS_NEEDINSURE').checked = false;
    document.getElementById('ECS_NEEDINSURE').disabled = true;
  }
  else
  {
    document.getElementById('ECS_NEEDINSURE').checked = false;
    document.getElementById('ECS_NEEDINSURE').disabled = false;
  }
  Ajax.call('group_buy.php?act=select_shipping', 'shipping=' + obj.value, orderSelectedResponse, 'GET');
}

/* *
 * 团购购物流程 --> 改变支付方式
 */
function handleGroupBuyPayment(obj)
{
  if (groupBuyPayment == obj)
  {
    return;
  }
  else
  {
    groupBuyPayment = obj;
  }

  Ajax.call('group_buy.php?act=select_payment', 'payment=' + obj.value, orderSelectedResponse, 'GET');
}

/* *
 * 改变商品包装
 */
function selectPack(obj)
{
  var theForm = obj.form;
  var con_country = theForm.elements['have_consignee'].value;
  if ( con_country=='0' )
  {
	  alert('请先选择配送地址！');
	  obj.options[0].selected="selected";
	  return ;
  }
  var aaa=obj.options[obj.selectedIndex].value;
  document.getElementById('packimage').href=packimage[aaa];

  Ajax.call('flow.php?step=select_pack', 'pack=' + aaa, orderSelectedResponse, 'GET', 'JSON');
}

/* *
 * 改变祝福贺卡
 */
function selectCard(obj)
{
 

  var aaa=obj.options[obj.selectedIndex].value;
  document.getElementById('cardimage').href=cardimage[aaa]; 
  document.getElementById('card_message').disabled =  (aaa>0) ? false : true;
  Ajax.call('flow.php?step=select_card', 'card=' + aaa, orderSelectedResponse, 'GET', 'JSON');
}

/* *
 * 选定了配送保价
 */
function selectInsure(needInsure)
{
  needInsure = needInsure ? 1 : 0;

  Ajax.call('flow.php?step=select_insure', 'insure=' + needInsure, orderSelectedResponse, 'GET', 'JSON');
}

/* *
 * 团购购物流程 --> 选定了配送保价
 */
function handleGroupBuyInsure(needInsure)
{
  needInsure = needInsure ? 1 : 0;

  Ajax.call('group_buy.php?act=select_insure', 'insure=' + needInsure, orderSelectedResponse, 'GET', 'JSON');
}

/* *
 * 回调函数
 */
function orderSelectedResponse(result)
{
  if (result.error)
  {
    alert(result.error);
    location.href = './';
  }

  try
  {
  	selected_pay_code = result.pay_code;
	if( result.pay_name){
		 document.getElementById("emzhifu").innerHTML = result.pay_name;
	     document.getElementById("zhifu68").style.display = 'none';
		 document.getElementById('zhifuip').className = 'i-icon-arrow-down'; 
		 }
     if( result.shipping_name){
		 
		 document.getElementById("empeisong").innerHTML = result.shipping_name;
	     document.getElementById("peisong68").style.display = 'none';
		 document.getElementById('peisongip').className = 'i-icon-arrow-down'; 
	    }

    var layer = document.getElementById("ECS_ORDERTOTAL");

    layer.innerHTML = (typeof result == "object") ? result.content : result;

    if (result.payment != undefined)
    {
      var surplusObj = document.forms['theForm'].elements['surplus'];
      if (surplusObj != undefined)
      {
        surplusObj.disabled = result.pay_code == 'balance';
      }
	  
    }
  }
  catch (ex) { }
}

/* *
 * 改变余额
 */
function changeSurplus(val)
{
  if (selectedSurplus == val)
  {
    //return;
  }
  else
  {
    //selectedSurplus = val;
  }

  Ajax.call('flow.php?step=change_surplus', 'surplus=' + val,  changeSurplusResponse, 'GET', 'JSON');
}

/* *
 * 改变余额回调函数
 */
function changeSurplusResponse(obj)
{
	if (obj.error) {
		try {
			alert(obj.error);
			document.getElementById('ECS_SURPLUS').value = '0';
			document.getElementById('ECS_SURPLUS').focus();
		} catch (ex) {
		}
	} else {
		try {
			document.getElementById('ECS_SURPLUS').value = obj.surplus;
			if(obj.show){
				//如果余额完全支付订单金额
				$('#pay_div').hide();
				$('#payment_other_input').attr("checked", true).val(pay_balance_id);//默认选择余额支付方式
			}else{
				$('#pay_div').show();
				$("input[type='radio']").attr("checked", false);//将之前选择的支付方式去掉
				$('#payment_other_input').val('0');
			}
		} catch (ex) {
		}
		orderSelectedResponse(obj.content);
	}
}

/* *
 * 改变积分
 */
function changeIntegral(val,suppid)
{
  if (selectedIntegral == val)
  {
    return;
  }
  else
  {
    selectedIntegral = val;
  }

  Ajax.call('flow.php?step=change_integral', 'points=' + val + '&suppid=' + suppid, changeIntegralResponse, 'GET', 'JSON');
}

/* *
 * 改变积分回调函数
 */
function changeIntegralResponse(obj)
{
  if (obj.error)
  {
    try
    {
      document.getElementById('ECS_INTEGRAL_NOTICE_'+obj.suppid).innerHTML = obj.error;
      document.getElementById('ECS_INTEGRAL_'+obj.suppid).value = '0';
      document.getElementById('ECS_INTEGRAL_'+obj.suppid).focus();
    }
    catch (ex) { }
  }
  else
  {
    try
    {
      document.getElementById('ECS_INTEGRAL_NOTICE_'+obj.suppid).innerHTML = '';
    }
    catch (ex) { }
    orderSelectedResponse(obj.content);
  }
}

/* *
 * 改变红包
 */
function changeBonus(val,suppid)
{
  if (selectedBonus == val)
  {
    //return;
  }
  else
  {
    //selectedBonus = val;
  }

  Ajax.call('flow.php?step=change_bonus', 'bonus=' + val + '&suppid=' + suppid, changeBonusResponse, 'GET', 'JSON');
}

/* *
 * 改变红包的回调函数
 */
function changeBonusResponse(obj)
{
  if (obj.error)
  {
    alert(obj.error);

    try
    {
      document.getElementById('ECS_BONUS_'+obj.suppid).value = '0';
    }
    catch (ex) { }
  }
  else
  {
	  document.getElementById('bonus_sn_'+obj.suppid).value = '';
	orderSelectedResponse(obj.content);
  }
}

/**
 * 验证红包序列号
 * @param string bonusSn 红包序列号
 */
function validateBonus(val,suppid)
{
  if(val == '输入优惠券'){
	  val = 0;
  }

  Ajax.call('flow.php?step=validate_bonus', 'bonus_sn=' + val + '&suppid=' + suppid, validateBonusResponse, 'GET', 'JSON');
}

function validateBonusResponse(obj)
{

if (obj.error)
  {
    alert(obj.error);
    //orderSelectedResponse(obj.content);
    try
    {
      document.getElementById('bonus_sn_'+obj.suppid).value = '';
    }
    catch (ex) { }
  }
  else
  {
    orderSelectedResponse(obj.content);
  }
}

/* *
 * 改变发票的方式
 */
function changeNeedInv()
{
  var obj        = document.getElementById('ECS_NEEDINV');
  var objType    = document.getElementById('ECS_INVTYPE');
  var objPayee   = document.getElementById('ECS_INVPAYEE');
  var objContent = document.getElementById('ECS_INVCONTENT');
  var needInv    = obj.checked ? 1 : 0;
  var invType    = obj.checked ? (objType != undefined ? objType.value : '') : '';
  var invPayee   = obj.checked ? objPayee.value : '';
  var invContent = obj.checked ? objContent.value : '';
  objType.disabled = objPayee.disabled = objContent.disabled = ! obj.checked;
  if(objType != null)
  {
    objType.disabled = ! obj.checked;
  }

    var individual_inv = document.forms['theForm'].elements['inv_payee_type'].item(0);
    var unit_inv = document.forms['theForm'].elements['inv_payee_type'].item(1);
    var inv_payee_type = individual_inv.checked?individual_inv.value:'';
    if(!individual_inv.checked)
    {
        inv_payee_type = unit_inv.checked?unit_inv.value:'';
    }
    var normal_invoice_tbody = document.getElementById('normal_invoice_tbody');
    var vat_invoice_tbody = document.getElementById('vat_invoice_tbody');
    var b1 = false;
    var b2 = false;
    if(invType == 'normal_invoice')
    {
        b1 = true;
    }
    else if(invType == 'vat_invoice')
    {
        b2 = true;
    }
    if(normal_invoice_tbody != null)
    {
        normal_invoice_tbody.style.display = b1?'':'none';
    }
    if(vat_invoice_tbody != null)
    {
        vat_invoice_tbody.style.display = b2?'':'none';
    }
    if(inv_payee_type == 'unit')
    {
        objPayee.style.display='';
    }
    else
    {
        objPayee.style.display='none';
    }

  Ajax.call('flow.php?step=change_needinv', 'need_inv=' + needInv + '&inv_type=' + encodeURIComponent(invType) + '&inv_payee=' + encodeURIComponent(invPayee) + '&inv_content=' + encodeURIComponent(invContent), orderSelectedResponse, 'GET');
}

/* *
 * 改变发票的方式
 */
function groupBuyChangeNeedInv()
{
  var obj        = document.getElementById('ECS_NEEDINV');
  var objPayee   = document.getElementById('ECS_INVPAYEE');
  var objContent = document.getElementById('ECS_INVCONTENT');
  var needInv    = obj.checked ? 1 : 0;
  var invPayee   = obj.checked ? objPayee.value : '';
  var invContent = obj.checked ? objContent.value : '';
  objPayee.disabled = objContent.disabled = ! obj.checked;

  Ajax.call('group_buy.php?act=change_needinv', 'need_idv=' + needInv + '&amp;payee=' + invPayee + '&amp;content=' + invContent, null, 'GET');
}

/* *
 * 改变缺货处理时的处理方式
 */
function changeOOS(obj)
{
  if (selectedOOS == obj)
  {
    return;
  }
  else
  {
    selectedOOS = obj;
  }

  Ajax.call('flow.php?step=change_oos', 'oos=' + obj.value, null, 'GET');
}

function check_before_submit(){
    var the_form = document.getElementById("theForm");
    if(checkOrderForm(the_form)){
        Ajax.call('flow.php?step=check_surplus_open','',is_surplus_open,'GET','TEXT',true,true);
    }
    return false;
}

function is_surplus_open(result) {
    if(result == '1'){
        open_surplus_window();
    }
    else{
        submit_the_form();
    }
}

function open_surplus_window(){
    document.getElementById("popup_window").style.display="";
}

function end_input_surplus(){
    var surplus_password = document.getElementById("surplus_password_input").value;
    Ajax.call('flow.php?step=verify_surplus_password','surplus_password='+surplus_password,check_surplus_response,'GET','TEXT',true,true);
}

function check_surplus_response(result){
    if(result == '1'){
        submit_the_form();
    }
    else{
        alert('密码错误！');
    }
}

function cancel_input_surplus(){
    document.getElementById("surplus_password_input").value="";
    document.getElementById("popup_window").style.display="none";
}

function submit_the_form()
{
    var the_form = document.getElementById("theForm");
    the_form.submit();
}

/* *
 * 检查提交的订单表单
 */
function checkOrderForm(frm)
{
  var paymentSelected = false;
  var shippingSelected = false;

  have_other=false;
  if(frm.elements['payment_other']){
	  for(var iii=0;iii<frm.elements['payment_other'].length;iii++)
	  {    
			if(frm.elements['payment_other'][iii].checked)
			{
					have_other=true;
			}
	  }
  }
  have_alipay=false;
  if(frm.elements['www_68ecshop_com_bank']){
	  for(var iii=0;iii<frm.elements['www_68ecshop_com_bank'].length;iii++)
	  {    
			if(frm.elements['www_68ecshop_com_bank'][iii].checked)
			{
					have_alipay=true;
			}
	  }
  }

  // 检查是否选择了支付配送方式
  	for (i = 0; i < frm.elements.length; i++) {
		// if (frm.elements[i].name == 'shipping' && frm.elements[i].checked)
		// {
		// shippingSelected = true;
		// }

		if (frm.elements[i].name == 'payment' && frm.elements[i].checked) {
			/* 代码修改_start By bbs.hongyuvip.com */
			if (frm.elements[i].value == '0') {
				if (have_other == true) {
					paymentSelected = true;
				} else {
					paymentSelected = false;
				}
			} 
//                        else if (frm.elements[i].value == document.getElementById('alipay_bank_input').value) {
//				if (have_alipay == true) {
//					paymentSelected = true;
//				} else {
//					paymentSelected = false;
//				}
//			} 
                        else {
				paymentSelected = true;
			}
			/* 代码修改_end By bbs.hongyuvip.com */
		}
	}

	
	$('.shipping').each(function() {
		if (this.value <= 0) {
			shippingSelected = false;
		}else{
                    shippingSelected = true;
                }
	});
        
        
	if (!shippingSelected) {
		alert(flow_no_shipping);
		return false;
	}

	if (!paymentSelected) {
		alert(flow_no_payment);
		return false;
	}

  // 检查用户输入的余额
  if (document.getElementById("ECS_SURPLUS"))
  {
    var surplus = document.getElementById("ECS_SURPLUS").value;
    var error   = Utils.trim(Ajax.call('flow.php?step=check_surplus', 'surplus=' + surplus, null, 'GET', 'TEXT', false));

    if (error)
    {
      try
      {
        document.getElementById("ECS_SURPLUS_NOTICE").innerHTML = error;
      }
      catch (ex)
      {
      }
      return false;
    }
  }

  // 检查用户输入的积分
  if (document.getElementById("ECS_INTEGRAL"))
  {
    var integral = document.getElementById("ECS_INTEGRAL").value;
    var error    = Utils.trim(Ajax.call('flow.php?step=check_integral', 'integral=' + integral, null, 'GET', 'TEXT', false));

    if (error)
    {
      return false;
      try
      {
        document.getElementById("ECS_INTEGRAL_NOTICE").innerHTML = error;
      }
      catch (ex)
      {
      }
    }
  }

    /*检查发票*/
    if(document.getElementById('ECS_NEEDINV').checked)
    {
        if(frm.elements['inv_content'].value == '0' || frm.elements['inv_content'].value == '')
        {
            alert('请选择发票内容');
            return false;
        }
        if(frm.elements['inv_type'].value == 'vat_invoice')
        {
            var check_array = new Array('vat_inv_company_name','vat_inv_taxpayer_id','vat_inv_registration_address',
                'vat_inv_registration_phone','vat_inv_deposit_bank','vat_inv_bank_account',
                'inv_consignee_name','inv_consignee_phone','inv_consignee_province',
                'inv_consignee_city','inv_consignee_address');
            for (id in check_array)
            {
                if(frm.elements[check_array[id]].style.display != 'none' &&
                    (frm.elements[check_array[id]].value == '0' || frm.elements[check_array[id]].value == ''))
                {
                    alert('请输入增值税发票相关信息');
                    return false;
                }
            }
        }
        else if(frm.elements['inv_type'].value == 'normal_invoice')
        {
            if(document.getElementById('unit_inv').checked)
            {
                if(frm.elements['inv_payee'].value == '')
                {
                    alert('请输入单位名称');
                    return false;
                }
            }
            else if(!document.getElementById('unit_inv').checked && !document.getElementById('individual_inv').checked)
            {
                alert('请选择发票抬头');
                return false;
            }
        }
        else
        {
            alert('请选择发票类型');
            return false;
        }
    }

  frm.action = frm.action + '?step=done';
  return true;
}

/* *
 * 检查收货地址信息表单中填写的内容
 */
function checkConsignee(frm)
{
  var msg = new Array();
  var err = false;

  if (frm.elements['country'] && frm.elements['country'].value == 0)
  {
    msg.push(country_not_null);
    err = true;
  }

  if (frm.elements['province'] && frm.elements['province'].value == 0 && frm.elements['province'].length > 1)
  {
    err = true;
    msg.push(province_not_null);
  }

  if (frm.elements['city'] && frm.elements['city'].value == 0 && frm.elements['city'].length > 1)
  {
    err = true;
    msg.push(city_not_null);
  }

  if (frm.elements['district'] && frm.elements['district'].length > 1)
  {
    if (frm.elements['district'].value == 0)
    {
      err = true;
      msg.push(district_not_null);
    }
  }

  if (Utils.isEmpty(frm.elements['consignee'].value))
  {
    err = true;
    msg.push(consignee_not_null);
  }

	//邮箱如果不为空则验证邮箱是否合法
	if (frm.elements['email'].value.length > 0 &&!Utils.isEmail(frm.elements['email'].value)) {
		err = true;
		msg.push(invalid_email);
	}

  if (frm.elements['address'] && Utils.isEmpty(frm.elements['address'].value))
  {
    err = true;
    msg.push(address_not_null);
  }

  if (frm.elements['zipcode'] && frm.elements['zipcode'].value.length > 0 && (!Utils.isNumber(frm.elements['zipcode'].value)))
  {
    err = true;
    msg.push(zip_not_num);
  }

  if (frm.elements['mobile'] && (Utils.isEmpty(frm.elements['mobile'].value)))
  {
    err = true;
    msg.push(mobi_not_null);
   }
  else
  {
    if (frm.elements['mobile'] && !Utils.isMobile(frm.elements['mobile'].value))

    {
      err = true;

      msg.push(mobile_invaild);

    }

  }

  if (frm.elements['tel'] && frm.elements['tel'].value.length > 0 && (!Utils.isTel(frm.elements['tel'].value)))
  {

    err = true;

    msg.push(tele_invaild);

  }

  if (err)

  {

    message = msg.join("\n");

    alert(message);

  }

  return ! err;

}
//<!--增值税发票_添加_START_bbs.hongyuvip.com-->

function check_taxpayer_id(t,id)

{

    if(!check_preg_match(t.value,'taxpayer_id'))

    {

        document.getElementById(id).innerHTML='纳税人识别号错误，请检查！';

    }

    else

    {

        document.getElementById(id).innerHTML='';

    }

}



function check_bank_account(t,id)

{

    if(!check_preg_match(t.value,'back_account'))

    {

        document.getElementById(id).innerHTML='银行账户含有非法字符！';

    }

    else

    {

        document.getElementById(id).innerHTML='';

    }

}



function check_phone_number(t,id)

{

    if(!check_preg_match(t.value,'phone_number'))

    {

        document.getElementById(id).innerHTML='手机号码格式不正确！';

    }

    else

    {

        document.getElementById(id).innerHTML='';

    }

}



function check_preg_match(v,type)

{

    var pattern = '';

    switch(type)

    {

        case 'taxpayer_id':

            pattern = '^[0-9]{15,}$';

            break;

        case 'back_account':

            pattern = '^[0-9A-z]+ *[0-9A-z]+$';

            break;

        case 'phone_number':

            pattern = '^1[0-9]{10}$';

    }

    var preg = new RegExp(pattern);

    return preg.test(v);

}
//<!--增值税发票_添加_END_bbs.hongyuvip.com-->