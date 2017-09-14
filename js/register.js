//检查结果
var _CHECK_RESULT = {
	// 邮箱检查结果是否可以注册
	email: false,
	// 手机检查结果是否可以注册
	mobile_phone: false
};

function chkstr(str) {
	for (var i = 0; i < str.length; i++) {
		if (str.charCodeAt(i) < 127 && !str.substr(i, 1).match(/^\w+$/ig)) {
			return false;
		}
	}
	return true;
}

/**
 * 检查密码
 * @param password
 * @returns {Boolean}
 */
function check_password(password) {
	conform_password = document.getElementById('conform_password').value;
	if(password.indexOf(" ") != -1){
		document.getElementById('password_notice').innerHTML = "登录密码不能包含空格";
		document.getElementById('password_notice').style.color = "#900";
		$("#pwd_notice").show();
		$("#pwd_intensity").hide();
		return false;
	}else if (password.length < 6) {
		document.getElementById('password_notice').innerHTML = password_shorter;
		document.getElementById('password_notice').style.color = "#900";
		$("#pwd_notice").show();
		$("#pwd_intensity").hide();
		return false;
	} else if (conform_password.length > 0) {
		if (password != conform_password) {
			document.getElementById('password_notice').innerHTML = confirm_password_invalid;
			document.getElementById('password_notice').style.color = "#900";
			$("#pwd_notice").show();
			$("#pwd_intensity").hide();
			return false;
		} else {
			document.getElementById('password_notice').innerHTML = msg_can_rg;
			document.getElementById('password_notice').style.color = "#093";
			document.getElementById('conform_password_notice').innerHTML = msg_can_rg;
			document.getElementById('conform_password_notice').style.color = "#093";
			$("#pwd_notice").hide();
			$("#pwd_intensity").show();
		}
	} else {
		document.getElementById('password_notice').innerHTML = msg_can_rg;
		document.getElementById('password_notice').style.color = "#093";
		$("#pwd_notice").hide();
		$("#pwd_intensity").show();
	}
	return true;
}

/**
 * 检查确认密码
 * @param conform_password
 * @returns {Boolean}
 */
function check_conform_password(conform_password) {
	var password = document.getElementById('password').value;

	if(conform_password.indexOf(" ") != -1){
		document.getElementById('conform_password_notice').innerHTML = "登录密码不能包含空格";
		document.getElementById('conform_password_notice').style.color = "#900";
		$("#conform_password_notice").show();
		return false;
	}else if (conform_password.length < 6) {
		document.getElementById('conform_password_notice').innerHTML = password_shorter;
		document.getElementById('conform_password_notice').style.color = "#900";
		return false;
	}
	if (conform_password != password) {
		document.getElementById('conform_password_notice').innerHTML = confirm_password_invalid;
		document.getElementById('conform_password_notice').style.color = "#900";
		return false;
	} else {
		document.getElementById('conform_password_notice').innerHTML = msg_can_rg;
		document.getElementById('conform_password_notice').style.color = "#093";
		return false;
	}
	return true;
}

/**
 * 验证邮箱,第一步合法性验证， 第二步是否存在验证
 * 
 * @param email
 *            验证邮箱：支持邮箱和邮箱对象
 * @param callback
 *            回调函数：true-可以注册 false-不可以注册
 */
function checkEmail(email, callback) {
	var submit_disabled = false;

	var emailObj = null;

	if (typeof (email) == 'object') {
		emailObj = $(email);
		email = emailObj.val();
	}

	if (email == '') {
		document.getElementById('email_notice').innerHTML = msg_email_blank;
		document.getElementById('email_notice').style.color = '#900';
		submit_disabled = true;

		if (emailObj != null) {
			emailObj.focus();
		}

	} else if (!Utils.isEmail(email)) {
		document.getElementById('email_notice').innerHTML = msg_email_format;
		document.getElementById('email_notice').style.color = '#900';
		submit_disabled = true;

		if (emailObj != null) {
			emailObj.focus();
		}

	}

	if (submit_disabled) {
		document.forms['formUser'].elements['Submit'].disabled = 'disabled';
		return false;
	}

	if (emailObj == null) {
		checkEmailExist(email, callback);
	} else {
		checkEmailExist(emailObj, callback);
	}
}

/**
 * 检查邮箱是否已经绑定过用户
 * 
 * @param email
 *            验证邮件:支持邮箱和邮箱对象
 * @param callback
 *            回调函数：true-可以注册 false-不可以注册
 */
function checkEmailExist(email, callback) {

	var emailObj = null;

	if (typeof (email) == 'object') {
		emailObj = $(email);
		email = emailObj.val();
	}

	$.post('register.php?act=check_email_exist', {
		email: email
	}, function(result) {
		if (result == 'false') {
			document.getElementById('email_notice').innerHTML = msg_can_rg;
			document.getElementById('email_notice').style.color = '#093';
			document.forms['formUser'].elements['Submit'].disabled = '';

			if ($.isFunction(callback)) {
				callback(true);
			}
		} else {
			document.getElementById('email_notice').innerHTML = msg_email_registered;
			document.getElementById('email_notice').style.color = '#900';
			document.forms['formUser'].elements['Submit'].disabled = 'disabled';
			
			if (emailObj != null) {
				emailObj.focus();
			}
			
			if ($.isFunction(callback)) {
				callback(false);
			}

		}
	}, 'text');
}

function checkMobilePhone(mobile, callback) {
	var submit_disabled = false;

	var mobileObj = null;

	if (typeof (mobile) == 'object') {
		mobileObj = $(mobile);
		mobile = mobileObj.val();
	}

	if (mobile == '') {
		document.getElementById('mobile_phone_notice').innerHTML = msg_mobile_phone_blank;
		document.getElementById('mobile_phone_notice').style.color = '#900';
		submit_disabled = true;

		if (mobileObj != null) {
			mobileObj.focus();
		}

	} else if (!Utils.isMobile(mobile)) {
		document.getElementById('mobile_phone_notice').innerHTML = msg_mobile_phone_format;
		document.getElementById('mobile_phone_notice').style.color = '#900';
		submit_disabled = true;

		if (mobileObj != null) {
			mobileObj.focus();
		}
	}

	if (submit_disabled) {
		document.forms['formUser'].elements['Submit'].disabled = 'disabled';
		return false;
	}

	if (mobileObj == null) {
		checkMobilePhoneExist(mobile, callback);
	} else {
		checkMobilePhoneExist(mobileObj, callback);
	}
}

var cur_mobile_phone = null;
function checkMobilePhoneExist(mobile, callback) {
	var mobileObj = null;

	if (typeof (mobile) == 'object') {
		mobileObj = $(mobile);
		mobile = mobileObj.val();
	}

	if (mobile == cur_mobile_phone && !$.isFunction(callback)) {
		return;
	}

	$.post('register.php?act=check_mobile_exist', {
		mobile: mobile
	}, function(result) {
		if (result == 'false') {
			document.getElementById('mobile_phone_notice').innerHTML = msg_can_rg;
			document.getElementById('mobile_phone_notice').style.color = '#093';
			document.forms['formUser'].elements['Submit'].disabled = '';

			if ($.isFunction(callback)) {
				callback(true);
			}
		} else {
			document.getElementById('mobile_phone_notice').innerHTML = msg_mobile_phone_registered;
			document.getElementById('mobile_phone_notice').style.color = '#900';
			document.forms['formUser'].elements['Submit'].disabled = 'disabled';

			if (mobileObj != null) {
				mobileObj.focus();
			}

			if ($.isFunction(callback)) {
				callback(false);
			}
		}

		cur_mobile_phone = mobile;

	}, 'text');
}

/**
 * 用户注册
 * 
 * @param register_type
 *            注册类型：email、mobile
 */
function register(register_type) {
	if (register_type == "email") {
		return reg_by_email();
	} else {
		return reg_by_mobile();
	}
}

/**
 * 通过邮箱注册
 * 
 * @returns {Boolean}
 */
function reg_by_email() {
	var frm = document.forms['formUser'];
	// 邮箱注册时不支持用户名注册
	// var username = Utils.trim(frm.elements['username'].value);
	var email = frm.elements['email'].value;
	var password = Utils.trim(frm.elements['password'].value);
	var confirm_password = Utils.trim(frm.elements['confirm_password'].value);
	var checked_agreement = frm.elements['agreement'].checked;
	var msn = frm.elements['extend_field1'] ? Utils.trim(frm.elements['extend_field1'].value) : '';
	var qq = frm.elements['extend_field2'] ? Utils.trim(frm.elements['extend_field2'].value) : '';
	var home_phone = frm.elements['extend_field4'] ? Utils.trim(frm.elements['extend_field4'].value) : '';
	var office_phone = frm.elements['extend_field3'] ? Utils.trim(frm.elements['extend_field3'].value) : '';
	// 邮箱注册不能绑定手机，许多注册成功后再绑定
	// var mobile_phone = frm.elements['extend_field5'] ?
	// Utils.trim(frm.elements['extend_field5'].value) : '';
	var passwd_answer = frm.elements['passwd_answer'] ? Utils.trim(frm.elements['passwd_answer'].value) : '';
	var sel_question = frm.elements['sel_question'] ? Utils.trim(frm.elements['sel_question'].value) : '';
	// 邮箱验证码
	var email_code = frm.elements['email_code'] ? Utils.trim(frm.elements['email_code'].value) : '';
	// 验证码
	var captcha = frm.elements['captcha'] ? Utils.trim(frm.elements['captcha'].value) : '';

	var msg = "";
	// 检查输入
	var msg = '';

	if (email.length == 0) {
		msg += email_empty + '\n';
	} else {
		if (!(Utils.isEmail(email))) {
			msg += email_invalid + '\n';
		}
	}
	if (password.length == 0) {
		msg += password_empty + '\n';
	} else if (password.length < 6) {
		msg += password_shorter + '\n';
	}
	if (/ /.test(password) == true) {
		msg += passwd_balnk + '\n';
	}
	if (confirm_password != password) {
		msg += confirm_password_invalid + '\n';
	}
	if (checked_agreement != true) {
		msg += agreement + '\n';
	}

	if (msn.length > 0 && (!Utils.isEmail(msn))) {
		msg += msn_invalid + '\n';
	}

	if (qq.length > 0 && (!Utils.isNumber(qq))) {
		msg += qq_invalid + '\n';
	}

	if (office_phone.length > 0) {
		var reg = /^[\d|\-|\s]+$/;
		if (!reg.test(office_phone)) {
			msg += office_phone_invalid + '\n';
		}
	}
	if (home_phone.length > 0) {
		var reg = /^[\d|\-|\s]+$/;

		if (!reg.test(home_phone)) {
			msg += msg_email_code_blank + '\n';
		}
	}

	if ($("#email_code").size() > 0 && email_code.length == 0) {
		msg += msg_email_code_blank + '\n';
	}

	if ($("#captcha").size() > 0 && captcha.length == 0) {
		msg += msg_captcha_blank + '\n';
	}

	// if (mobile_phone.length > 0) {
	// var reg = /^[\d|\-|\s]+$/;
	// if (!reg.test(mobile_phone)) {
	// msg += mobile_phone_invalid + '\n';
	// }
	// }
	if (passwd_answer.length > 0 && sel_question == 0 || document.getElementById('passwd_quesetion') && passwd_answer.length == 0) {
		msg += no_select_question + '\n';
	}

	for (var i = 4; i < frm.elements.length - 4; i++) // 从第五项开始循环检查是否为必填项
	{
		var needinput = document.getElementById(frm.elements[i].name + 'i') ? document.getElementById(frm.elements[i].name + 'i') : '';

		if (needinput != '' && frm.elements[i].value.length == 0) {
			msg += '- ' + needinput.innerHTML + msg_blank + '\n';
		}
	}

	if (msg.length > 0) {
		alert(msg);
		return false;
	} else {
		return true;
	}
}

function reg_by_mobile() {
	var frm = document.forms['formUser'];
	// 手机时不支持用户名注册
	// var username = Utils.trim(frm.elements['username'].value);
	var mobile_phone = frm.elements['mobile_phone'].value;
	var password = Utils.trim(frm.elements['password'].value);
	var confirm_password = Utils.trim(frm.elements['confirm_password'].value);
	var checked_agreement = frm.elements['agreement'].checked;
	var msn = frm.elements['extend_field1'] ? Utils.trim(frm.elements['extend_field1'].value) : '';
	var qq = frm.elements['extend_field2'] ? Utils.trim(frm.elements['extend_field2'].value) : '';
	var home_phone = frm.elements['extend_field4'] ? Utils.trim(frm.elements['extend_field4'].value) : '';
	var office_phone = frm.elements['extend_field3'] ? Utils.trim(frm.elements['extend_field3'].value) : '';
	// 邮箱注册不能绑定手机，许多注册成功后再绑定
	// var mobile_phone = frm.elements['extend_field5'] ?
	// Utils.trim(frm.elements['extend_field5'].value) : '';
	var passwd_answer = frm.elements['passwd_answer'] ? Utils.trim(frm.elements['passwd_answer'].value) : '';
	var sel_question = frm.elements['sel_question'] ? Utils.trim(frm.elements['sel_question'].value) : '';
	// 手机验证码
	var mobile_code = frm.elements['mobile_code'] ? Utils.trim(frm.elements['mobile_code'].value) : '';
	// 验证码
	var captcha = frm.elements['captcha'] ? Utils.trim(frm.elements['captcha'].value) : '';

	var msg = "";
	// 检查输入
	var msg = '';

	if (mobile_phone.length == 0) {
		msg += msg_mobile_phone_blank + '\n';
	} else {
		if (!(Utils.isMobile(mobile_phone))) {
			msg += mobile_phone_invalid + '\n';
		}
	}
	if (password.length == 0) {
		msg += password_empty + '\n';
	} else if (password.length < 6) {
		msg += password_shorter + '\n';
	}
	if (/ /.test(password) == true) {
		msg += passwd_balnk + '\n';
	}
	if (confirm_password != password) {
		msg += confirm_password_invalid + '\n';
	}
	if (checked_agreement != true) {
		msg += agreement + '\n';
	}

	if (msn.length > 0 && (!Utils.isEmail(msn))) {
		msg += msn_invalid + '\n';
	}

	if (qq.length > 0 && (!Utils.isNumber(qq))) {
		msg += qq_invalid + '\n';
	}

	if (office_phone.length > 0) {
		var reg = /^[\d|\-|\s]+$/;
		if (!reg.test(office_phone)) {
			msg += office_phone_invalid + '\n';
		}
	}
	if (home_phone.length > 0) {
		var reg = /^[\d|\-|\s]+$/;

		if (!reg.test(home_phone)) {
			msg += home_phone_invalid + '\n';
		}
	}

	if ($("#mobile_code").size() > 0 && mobile_code.length == 0) {
		msg += msg_mobile_phone_code_blank + '\n';
	}

	if ($("#captcha").size() > 0 && captcha.length == 0) {
		msg += msg_captcha_blank + '\n';
	}

	// if (mobile_phone.length > 0) {
	// var reg = /^[\d|\-|\s]+$/;
	// if (!reg.test(mobile_phone)) {
	// msg += mobile_phone_invalid + '\n';
	// }
	// }
	if (passwd_answer.length > 0 && sel_question == 0 || document.getElementById('passwd_quesetion') && passwd_answer.length == 0) {
		msg += no_select_question + '\n';
	}

	for (var i = 4; i < frm.elements.length - 4; i++) // 从第五项开始循环检查是否为必填项
	{
		var needinput = document.getElementById(frm.elements[i].name + 'i') ? document.getElementById(frm.elements[i].name + 'i') : '';

		if (needinput != '' && frm.elements[i].value.length == 0) {
			msg += '- ' + needinput.innerHTML + msg_blank + '\n';
		}
	}

	if (msg.length > 0) {
		alert(msg);
		return false;
	} else {
		return true;
	}
}

/**
 * 发送邮箱验证码
 * 
 * @param emailObj
 *            邮箱对象
 * @param emailCodeObj
 *            邮箱验证码对象
 * @param sendButton
 *            点击发送邮箱验证码的按钮对象，用于显示倒计时信息
 */
function sendEmailCode(emailObj, emailCodeObj, sendButton) {
	checkEmail(emailObj, function(result) {
		if (result) {
			// 发送邮件
			// &XDEBUG_SESSION_START=ECLIPSE_DBGP
			var url = 'register.php?act=send_email_code';
			$.post(url, {
				email: emailObj.val()
			}, function(result) {
				if (result == 'ok') {
					// 倒计时
					countdown(sendButton);
				} else {
					alert(result);
				}
			}, 'text');
		}
	});
}

/**
 * 发送邮箱验证码
 * 
 * @param mobileObj
 *            手机号对象
 * @param mobileCodeObj
 *            短信验证码对象
 * @param sendButton
 *            点击发送短信证码的按钮对象，用于显示倒计时信息
 */
function sendMobileCode(mobileObj, mobileCodeObj, sendButton) {
	checkMobilePhone(mobileObj, function(result) {
		if (result) {
			// 发送邮件
			var url = 'register.php?act=send_mobile_code';
			$.post(url, {
				XDEBUG_SESSION_START: 'ECLIPSE_DBGP',
				mobile_phone: mobileObj.val()
			}, function(result) {
				if (result == 'ok') {
					// 倒计时
					countdown(sendButton);
				} else {
					alert(result);
				}
			}, 'text');
		}
	});
}

/*******************************************************************************
 * 检测密码强度
 * 
 * @param string
 *            pwd 密码
 */
function checkIntensity(pwd) {

	$("#pwd_notice").hide();
	$("#pwd_intensity").show();

	var Mcolor = "#FFF", Lcolor = "#FFF", Hcolor = "#FFF";
	var m = 0;

	var Modes = 0;
	for (var i = 0; i < pwd.length; i++) {
		var charType = 0;
		var t = pwd.charCodeAt(i);
		if (t >= 48 && t <= 57) {
			charType = 1;
		} else if (t >= 65 && t <= 90) {
			charType = 2;
		} else if (t >= 97 && t <= 122)
			charType = 4;
		else
			charType = 4;
		Modes |= charType;
	}

	for (i = 0; i < 4; i++) {
		if (Modes & 1)
			m++;
		Modes >>>= 1;
	}

	if (pwd.length <= 4) {
		m = 1;
	}

	switch (m) {
	case 1:
		Lcolor = "2px solid red";
		Mcolor = Hcolor = "2px solid #DADADA";
		break;
	case 2:
		Mcolor = "2px solid #f90";
		Lcolor = Hcolor = "2px solid #DADADA";
		break;
	case 3:
		Hcolor = "2px solid #3c0";
		Lcolor = Mcolor = "2px solid #DADADA";
		break;
	case 4:
		Hcolor = "2px solid #3c0";
		Lcolor = Mcolor = "2px solid #DADADA";
		break;
	default:
		Hcolor = Mcolor = Lcolor = "";
		break;
	}
	if (document.getElementById("pwd_lower")) {
		document.getElementById("pwd_lower").style.borderBottom = Lcolor;
		document.getElementById("pwd_middle").style.borderBottom = Mcolor;
		document.getElementById("pwd_high").style.borderBottom = Hcolor;
	}

}

var wait = 60;
function countdown(obj, msg) {
	obj = $(obj);

	if (wait == 0) {
		obj.removeAttr("disabled");
		obj.val(msg);
		wait = 60;
	} else {
		if (msg == undefined || msg == null) {
			msg = obj.val();
		}
		obj.attr("disabled", "disabled");
		obj.val(wait + "秒后重新获取");
		wait--;
		setTimeout(function() {
			countdown(obj, msg)
		}, 1000)
	}
}
/* 代码增加2014-12-23 by bbs.hongyuvip.com _end */