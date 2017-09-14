<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<title><?php echo $this->_var['app_name']; ?></title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="styles/general.css" rel="stylesheet" type="text/css" />



<style type="text/css">

#header-div {

  background:url(images/top_bg.gif) repeat-x;



}

a{font-family:"微软雅黑";}

#logo-div {

  height: 58px; width:195px;   float: left;

}



#admininfo-div{height:58px; line-height:58px; width:250px; float:left;}

#admininfo-div span.left{float:left;height:58px; line-height:58px;background:url(images/ui_04.png) no-repeat 10px 12px; text-indent:30px; color:#d2d4d1;}

#admininfo-div span.right{float:left;height:58px; line-height:58px;background:url(images/ui_17.png) no-repeat 5px 13px; text-indent:20px; color:#e9e9e9;}

#admininfo-div span.right a{color:#e9e9e9;}



#license-div {

  height: 58px;

  float: left;

  text-align:left;

  vertical-align:middle;

  line-height:58px;

}

#license1-div {

  height: 58px;

  float: left; text-align:left;

  vertical-align:middle;

  line-height:58px;

}



#license-div a:visited, #license-div a:link {

  color: #EB8A3D;

}



#license-div a:hover {

  text-decoration: none;

  color: #EB8A3D;

}



#submenu-div {

  height: 58px;

}



#submenu-div ul {

  margin: 0;

  padding: 0;

  list-style-type: none;

}



#submenu-div li {

float: right;

 width:77px;  text-align:center; height:58px; background:url(images/top_line.gif) no-repeat left top;

}

#submenu-div li a{

display:block; background:url(images/top_header.png) no-repeat left top; padding-top:30px; height:28px; line-height:28px;

}



#submenu-div li.show_1 a{

	background-position: 8px -3px;

}

#submenu-div li.show_2 a{

	background-position: -66px -3px;

}

#submenu-div li.show_3 a{

	background-position: -135px -3px;

}

#submenu-div li.show_4 a{

	background-position: -206px -3px;

}

#submenu-div li.show_5 a{

	background-position: -281px -3px;

}

#submenu-div li.show_6 a{

	background-position: -352px -3px;

}

#submenu-div li.show_7 a{

	background-position: -420px -3px;

}

#submenu-div li.show_8 a{

	background-position: -488px -3px;

}

#submenu-div li.show_9 a{

	background-position: -562px -3px;

}



#submenu-div a:visited, #submenu-div a:link {

  color: #ffffff;

  text-decoration: none;

}



#submenu-div li a:hover {

background:url(images/top_header_hover.png) no-repeat; 

}

#submenu-div li.show_1 a:hover{

	background-position: -2px -1px;

}

#submenu-div li.show_2 a:hover{

	background-position: -76px -1px;

}

#submenu-div li.show_3 a:hover{

	background-position: -145px -1px;

}

#submenu-div li.show_4 a:hover{

	background-position: -216px -1px;

}

#submenu-div li.show_5 a:hover{

	background-position: -291px -1px;

}

#submenu-div li.show_6 a:hover{

	background-position: -362px -1px;

}

#submenu-div li.show_7 a:hover{

	background-position: -430px -1px;

}

#submenu-div li.show_8 a:hover{

	background-position: -498px -1px;

}

#submenu-div li.show_9 a:hover{

	background-position: -572px -1px;

}



#loading-div {

  clear: right;

  text-align: right;

  display: block;

}



#menu-div {

  height: 40px;

  line-height:40px;

}



#menu-div ul {

  margin: 0;

  padding: 0;

  list-style-type: none; 

}



#menu-div li {

  float: left; 

}

#menu-div li.midd_21 {

	background:url(images/midd.png) no-repeat;background-position:10px 12px; border-left:4px #0e94d1 solid; text-indent:12px;



}

#menu-div li.midd_22 {

		background:url(images/midd.png) no-repeat;background-position:0px -21px;



}

#menu-div li.midd_23 {

	background:url(images/midd.png) no-repeat;background-position:0px -57px;



}

#menu-div li.midd_1 {

	background:url(images/midd.png) no-repeat;background-position:0px -96px;

}

#menu-div li.midd_2 {

	background:url(images/midd.png) no-repeat;background-position:0px -136px;

}

#menu-div li.midd_3 {

	background:url(images/midd.png) no-repeat;background-position:0px -175px;

}

#menu-div li.midd_4 {

	background:url(images/midd.png) no-repeat;background-position:0px -212px;

}

#menu-div li.midd_5 {

	background:url(images/midd.png) no-repeat;background-position:0px -250px;

}

#menu-div li#xinjian_div {

	background:url(images/midd.png) no-repeat;background-position:0px -278px;

}



#menu-div li span{

background:url(images/numberico.png) no-repeat right bottom; display:inline-block; color:#FFF; font-size:12px; height:18px; padding:0px; text-align:center; line-height:18px; padding-right:8px; margin-left:5px;}

#menu-div li span em{

background:url(images/numberico.png) no-repeat left top; width:8px;display:inline-block;font-size:12px;  height:18px; vertical-align:top;}

#menu-div a:visited, #menu-div a:link {

  display:block;

  padding: 0 20px;

  text-decoration: none;

  color: #5f5f5f;

}



#menu-div a:hover {

  color: #5f5f5f;

}



#submenu-div a.fix-submenu{clear:both; margin-left:5px; padding:1px 5px; *padding:3px 5px 5px; background:#DDEEF2; color:#FA841E;}

#submenu-div a.fix-submenu:hover{padding:1px 5px; *padding:3px 5px 5px; background:#FFF; color:#FA841E;}

#menu-div li.fix-spacel{background:none;}

#menu-div li.fix-spacer{background:none;}

#tabbar-div {

  background:#0e94d1; font-family:"微软雅黑";

width:196px; height:40px; float:left; line-height:40px; color:#ffffff; font-size:14px; font-weight:bold; text-indent:18px;

}



.top_mune{height:40px; line-height:40px; background:#e6e6e6;}





#mask {

	BACKGROUND: #000; WIDTH: 100%; POSITION: absolute; HEIGHT: 100%; opacity: .5

}

#popupmenu {

	DISPLAY: none; Z-INDEX: 900; WIDTH: 100%; POSITION: absolute; TOP: 50px; HEIGHT: 100%

}

.shwobox1 {

	BORDER-RIGHT: #c8d2d5 2px solid; Z-INDEX: 9; RIGHT: 3px; WIDTH: 485px; BORDER-BOTTOM: #c8d2d5 2px solid; ZOOM: 1; POSITION: absolute; TOP: 0px; BACKGROUND-COLOR: #f5fafe

}

.shwobox1 .box {

	BORDER-RIGHT: #4294ce 1px solid; PADDING-RIGHT: 20px; BORDER-TOP: #4294ce 1px solid; PADDING-LEFT: 20px; PADDING-BOTTOM: 58px; BORDER-LEFT: #4294ce 1px solid; PADDING-TOP: 10px; BORDER-BOTTOM: #4294ce 1px solid; ZOOM: 1

}

.shwobox1 .box DL {

	PADDING-LEFT: 10px; FLOAT: left; WIDTH: 100px; PADDING-TOP: 10px

}

.shwobox1 .box DL DT {

	FONT-WEIGHT: bold; FONT-SIZE: 16px; LINE-HEIGHT: 30px; HEIGHT: 30px

}

.shwobox1 .box DL DT A {

	COLOR: #069

}

.shwobox1 .box DD {





	FONT-SIZE: 14px; LINE-HEIGHT: 1.8

}

.shwobox1 .box DD A {

	COLOR: #333

}

.shwobox1 .box DD A:hover {

	COLOR: #f00

}

.shwobox1 .box EM {

	Z-INDEX: 99; RIGHT: 10px; WIDTH: 17px; CURSOR: pointer; BOTTOM: 10px; POSITION: absolute; HEIGHT: 17px

}

</style>

<?php echo $this->smarty_insert_scripts(array('files'=>'../js/transport.org.js')); ?>

<script type="text/javascript">

onload = function()

{

  Ajax.call('index.php?is_ajax=1&act=license','', start_sendmail_Response, 'GET', 'JSON');

}

/**

 * 帮助系统调用

 */

function web_address()

{

  var ne_add = parent.document.getElementById('main-frame');

  var ne_list = ne_add.contentWindow.document.getElementById('search_id').innerHTML;

  ne_list.replace('-', '');

  var arr = ne_list.split('-');

  window.open('help.php?al='+arr[arr.length - 1],'_blank');

}





/**

 * 授权检测回调处理

 */

function start_sendmail_Response(result)

{

  // 运行正常

  if (result.error == 0)

  {

    var str = '';

		if (result['content']['auth_str'])

		{

			str = '<a href="javascript:void(0);" target="_blank">' + result['content']['auth_str'];

			if (result['content']['auth_type'])

			{

				str += '[' + result['content']['auth_type'] + ']';

			}

			str += '</a> ';

		}



    document.getElementById('license-div').innerHTML = str;

  }

}



function modalDialog(url, name, width, height)

{

  if (width == undefined)

  {

    width = 400;

  }

  if (height == undefined)

  {

    height = 300;

  }



  if (window.showModalDialog)

  {

    window.showModalDialog(url, name, 'dialogWidth=' + (width) + 'px; dialogHeight=' + (height+5) + 'px; status=off');

  }

  else

  {

    x = (window.screen.width - width) / 2;

    y = (window.screen.height - height) / 2;



    window.open(url, name, 'height='+height+', width='+width+', left='+x+', top='+y+', toolbar=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, modal=yes');

  }

}



function ShowToDoList()

{

  try

  {

    var mainFrame = window.top.frames['main_frame'];

    mainFrame.window.showTodoList(adminId);

  }

  catch (ex)

  {

  }

}





var adminId = "<?php echo $this->_var['admin_id']; ?>"; 

</script>

<script>

function toggleMenu_top(){

frmBody1 = parent.document.getElementById('frame-all');

 if (frmBody1.rows == "98,*")

  {

frmBody1.rows="40,*";

	document.getElementById("header-div").style.display="none";

document.getElementById("midd_show").innerHTML="显示";

	}

  else

  {

frmBody1.rows="98,*";

		document.getElementById("header-div").style.display="block";

	document.getElementById("midd_show").innerHTML="隐藏";

}

}

</script>

</head>

<body>

<div id="header-div" style="display:block;">

<div id="logo-div"><img src="images/ecshop_logo.png" alt="68ECSHOP" /></div>



<div id="license-div" style="bgcolor:#000000;"></div>

  <div id="license1-div" style="bgcolor:#000000;">

    <?php if ($this->_var['send_mail_on'] == 'on'): ?>

      <span id="send_msg"><img src="images/top_loader.gif" width="16" height="16" alt="<?php echo $this->_var['lang']['loading']; ?>" style="vertical-align: middle" /> <?php echo $this->_var['lang']['email_sending']; ?></span>

      <a href="javascript:;" onClick="Javascript:switcher()" id="lnkSwitch" style="margin-right:0px;color: #FF9900;text-decoration: underline"><?php echo $this->_var['lang']['pause']; ?></a>

      <?php endif; ?>

     </div> 

<div id="submenu-div">

<ul>

<li class="show_9"><a href="privilege.php?act=logout" target="_top"><?php echo $this->_var['lang']['signout']; ?></a></li>

<li class="show_8"><a href="http://bbs.hongyuvip.com/" target="_blank"><?php echo $this->_var['lang']['help']; ?></a></li>

<li class="show_7"><a href="http://bbs.hongyuvip.com/"  target="_blank"><?php echo $this->_var['lang']['about']; ?></a></li>

<li class="show_6"><a href="privilege.php?act=modif" target="main_frame"><?php echo $this->_var['lang']['profile']; ?></a></li>

<li class="show_4"> <a href="index.php?act=clear_cache" class="qinghc" target="main_frame"><?php echo $this->_var['lang']['clear_cache']; ?></a></li>

<li class="show_1"><a href="../" target="_blank"><?php echo $this->_var['lang']['preview']; ?></a></li></ul>

   <?php if ($this->_var['send_mail_on'] == 'on'): ?>

    <script type="text/javascript" charset="gb2312">

    var sm = window.setInterval("start_sendmail()", 5000);

    var finished = 0;

    var error = 0;

    var conti = "<?php echo $this->_var['lang']['conti']; ?>";

    var pause = "<?php echo $this->_var['lang']['pause']; ?>";

    var counter = 0;

    var str = "<?php echo $this->_var['lang']['str']; ?>";

    

    function start_sendmail()

    {

      Ajax.call('index.php?is_ajax=1&act=send_mail','', start_sendmail_Response, 'GET', 'JSON');

    }

    function start_sendmail_Response(result)

    {

        if (typeof(result.count) == 'undefined')

        {

            result.count = 0;

            result.message = '';

        }

        if (typeof(result.count) != 'undefined' && result.count == 0)

        {

            counter --;

            document.getElementById('lnkSwitch').style.display = "none";

            window.clearInterval(sm);

        }



        if( typeof(result.goon) != 'undefined' )

        {

            start_sendmail();

        }



        counter ++ ;



        document.getElementById('send_msg').innerHTML = result.message;

    }

    function switcher()

    {

        if(document.getElementById('lnkSwitch').innerHTML == conti)

        {

            //do pause

            document.getElementById('lnkSwitch').innerHTML = pause;

            sm = window.setInterval("start_sendmail()", 5000);

        }

        else

        {

            //do continue

            document.getElementById('lnkSwitch').innerHTML = conti;

            document.getElementById('send_msg').innerHTML = sprintf(str, counter);

            window.clearInterval(sm);

        }

    }







    sprintfWrapper = {   

      

      init : function () {   

      

        if (typeof arguments == "undefined") {return null;}   

        if (arguments.length < 1) {return null;}   

        if (typeof arguments[0] != "string") {return null;}   

        if (typeof RegExp == "undefined") {return null;}   

      

        var string = arguments[0];   

        var exp = new RegExp(/(%([%]|(\-)?(\+|\x20)?(0)?(\d+)?(\.(\d)?)?([bcdfosxX])))/g);   

        var matches = new Array();   

        var strings = new Array();   

        var convCount = 0;   

        var stringPosStart = 0;   

        var stringPosEnd = 0;   

        var matchPosEnd = 0;   

        var newString = '';   

        var match = null;   

      

        while (match = exp.exec(string)) {   

          if (match[9]) {convCount += 1;}   

      

          stringPosStart = matchPosEnd;   

          stringPosEnd = exp.lastIndex - match[0].length;   

          strings[strings.length] = string.substring(stringPosStart, stringPosEnd);   

      

          matchPosEnd = exp.lastIndex;   

          matches[matches.length] = {   

            match: match[0],   

            left: match[3] ? true : false,   

            sign: match[4] || '',   

            pad: match[5] || ' ',   

            min: match[6] || 0,   

            precision: match[8],   

            code: match[9] || '%',   

            negative: parseInt(arguments[convCount]) < 0 ? true : false,   

            argument: String(arguments[convCount])   

          };   

        }   

        strings[strings.length] = string.substring(matchPosEnd);   

      

        if (matches.length == 0) {return string;}   

        if ((arguments.length - 1) < convCount) {return null;}   

      

        var code = null;   

        var match = null;   

        var i = null;   

      

        for (i=0; i<matches.length; i++) {   

      

          if (matches[i].code == '%') {substitution = '%'}   

          else if (matches[i].code == 'b') {   

            matches[i].argument = String(Math.abs(parseInt(matches[i].argument)).toString(2));   

            substitution = sprintfWrapper.convert(matches[i], true);   

          }   

          else if (matches[i].code == 'c') {   

            matches[i].argument = String(String.fromCharCode(parseInt(Math.abs(parseInt(matches[i].argument)))));   

            substitution = sprintfWrapper.convert(matches[i], true);   

          }   

          else if (matches[i].code == 'd') {   

            matches[i].argument = String(Math.abs(parseInt(matches[i].argument)));   

            substitution = sprintfWrapper.convert(matches[i]);   

          }   

          else if (matches[i].code == 'f') {   

            matches[i].argument = String(Math.abs(parseFloat(matches[i].argument)).toFixed(matches[i].precision ? matches[i].precision : 6));   

            substitution = sprintfWrapper.convert(matches[i]);   

          }   

          else if (matches[i].code == 'o') {   

            matches[i].argument = String(Math.abs(parseInt(matches[i].argument)).toString(8));   

            substitution = sprintfWrapper.convert(matches[i]);   

          }   

          else if (matches[i].code == 's') {   

            matches[i].argument = matches[i].argument.substring(0, matches[i].precision ? matches[i].precision : matches[i].argument.length)   

            substitution = sprintfWrapper.convert(matches[i], true);   

          }   

          else if (matches[i].code == 'x') {   

            matches[i].argument = String(Math.abs(parseInt(matches[i].argument)).toString(16));   

            substitution = sprintfWrapper.convert(matches[i]);   

          }   

          else if (matches[i].code == 'X') {   

            matches[i].argument = String(Math.abs(parseInt(matches[i].argument)).toString(16));   

            substitution = sprintfWrapper.convert(matches[i]).toUpperCase();   

          }   

          else {   

            substitution = matches[i].match;   

          }   

      

          newString += strings[i];   

          newString += substitution;   

      

        }   

        newString += strings[i];   

      

        return newString;   

      

      },   

      

      convert : function(match, nosign){   

        if (nosign) {   

          match.sign = '';   

        } else {   

          match.sign = match.negative ? '-' : match.sign;   

        }   

        var l = match.min - match.argument.length + 1 - match.sign.length;   

        var pad = new Array(l < 0 ? 0 : l).join(match.pad);   

        if (!match.left) {   

          if (match.pad == "0" || nosign) {   

            return match.sign + pad + match.argument;   

          } else {   

            return pad + match.sign + match.argument;   

          }   

        } else {   

          if (match.pad == "0" || nosign) {   

            return match.sign + match.argument + pad.replace(/0/g, ' ');   

          } else {   

            return match.sign + match.argument + pad;   

          }   

        }   

      }   

    }   

      

    sprintf = sprintfWrapper.init;  







    

    </script>

    <?php endif; ?>

    <div id="load-div" style="padding: 5px 0px 0 0; text-align: right; color: #FF9900; display: none;width:20%;float:right; height:58px; line-height:58px;"> <?php echo $this->_var['lang']['loading']; ?></div>

  </div>

</div>



</body>

</html>