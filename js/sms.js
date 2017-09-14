function trim(str) {
	return str.replace(/^\s*(.*?)[\s\n]*$/g, '$1');
}


function getverifycode()
{
	var mobile = document.getElementById('username').value;
	if(mobile == '') {
		alert("手机号不能为空！");
	}else
	{
		Ajax.call('sms.php?step=getverifycode&r=' + Math.random(), 'mobile=' + mobile, getverifycodeResponse, 'POST', 'JSON');
	}
}

function getverifycode1()
{
	var mobile = document.getElementById('phone').value;
	if(mobile.length == 0) {
		alert("手机号不能为空！");
	}
	else if(mobile.length != 11)
	{
		alert("手机号不是11位！"); 
	}
	else
	{
		Ajax.call('sms.php?step=getverifycode&r=' + Math.random(), 'mobile=' + mobile, getverifycodeResponse, 'POST', 'JSON');
	}
}

function getverifycode2(phone)
{
		Ajax.call('sms.php?step=getverifycode2&r=' + Math.random(), 'mobile=' + phone, getverifycodeResponse2, 'POST', 'JSON');
}

function getverifycodeResponse2(result)
{
	alert(result.message);
	if(result.error)
	{
		document.getElementById('v_code_notice').innerHTML = ''; 
	}
	else
	{
		document.getElementById('v_code_btn').disabled = true; 
	}
}

function getverifycode3()
{
	var mobile = document.getElementById('mobile').value;
	var u_name = document.getElementById('u_name').value;
	if(u_name.length == 0)
	{
		alert("用户名不能为空！"); 
	}
	else
	{
		if(mobile.length == 0) {
			alert("手机号不能为空！");
		}
		else if(mobile.length != 11)
		{
			alert("手机号不是11位！"); 
		}
		else
		{
			Ajax.call('user.php?act=getverifycode&mobile=' + mobile,'u_name = ' + u_name, getverifycodeResponse3,'GET', 'TEXT', true, true);
		}
	}
}


function getverifycodeResponse3(result)
{
		 RemainTime();

}

		var iTime = 59;
		var Account;
		function RemainTime(){
			document.getElementById('fphone').disabled = true;
			var iSecond,sSecond="",sTime="";
			if (iTime >= 0){
				iSecond = parseInt(iTime%60);
				if (iSecond >= 0){
					sSecond = iSecond + "秒";
				}
				sTime=sSecond;
				if(iTime==0){
					clearTimeout(Account);
					sTime='获取手机验证码';
					iTime = 59;
					document.getElementById('fphone').disabled = false;
				}else{
					Account = setTimeout("RemainTime()",1000);
					iTime=iTime-1;
				}
			}else{
				sTime='没有倒计时';
			}
			document.getElementById('fphone').value = sTime;
		}		

function getverifycodeResponse(result)
{
	alert(result.message);
	if(result.error)
	{
		document.getElementById('code_notice').innerHTML = '';
	}
	else
	{
		document.getElementById('code_notice').innerHTML =120;
		document.getElementById('code_btn').disabled = true;
	}	
}

function run()
{
    var s = document.getElementById('code_notice');
    if(s.innerHTML == 0){
       document.getElementById('code_btn').disabled=0;
	   document.getElementById('code_notice').innerHTML = '';
       return false;
    }
    s.innerHTML = s.innerHTML * 1 - 1;
}

window.setInterval("run()",1000);
