<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP Menu</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="styles/general.css" rel="stylesheet" type="text/css" />
<script language="JavaScript">
<!--
var noHelp   = "<p align='center' style='color: #666'><?php echo $this->_var['lang']['no_help']; ?></p>";
var helpLang = "<?php echo $this->_var['help_lang']; ?>";
//-->
</script>

<style type="text/css">
.article_menu {
	margin: 0;
	padding: 0;
}
.article_menu UL {
	WIDTH: 100%;
	margin: 0;
	padding: 0;
}
.article_menu LI {
	LIST-STYLE-TYPE: none;
	TEXT-ALIGN: left;
}
.article_menu LI.menu {
	PADDING-RIGHT: 0px;
	PADDING-LEFT: 0px;
	PADDING-BOTTOM: 0px;
	WIDTH: 100%;
	PADDING-TOP: 0px
}
.article_menu LI.button_wu A {
	DISPLAY: block;
	FONT-SIZE: 14px;
	BACKGROUND: url(images/menu_bottom.gif) no-repeat 0px 0px;
	OVERFLOW: hidden;
	WIDTH: 100%;
	TEXT-INDENT: 35px;
	LINE-HEIGHT: 35px;
	POSITION: relative;
	HEIGHT: 35px;
}
.article_menu LI.button_wu A SPAN {
	RIGHT: 5px;
	BACKGROUND: url(images/help_menu-b5.gif) no-repeat;
	WIDTH: 16px;
	float: right;
	TOP: 15px;
	HEIGHT: 16px
}
.article_menu LI.button {
}
.article_menu LI.button A {
	BACKGROUND: url(images/menu_bottom.gif) #e6e6e6 no-repeat center 44px;
	DISPLAY: block;
	FONT-SIZE: 14px;
	OVERFLOW: hidden;
	WIDTH: 100%;
	TEXT-INDENT: 45px;
	LINE-HEIGHT: 45px;
	POSITION: relative;
	HEIGHT: 45px;
}
.article_menu LI.button A em {
	background: url(images/allico.png) no-repeat;
	background-position: 18px -528px;
	POSITION: absolute;
	top: 5px;
	left: 0px;
	width: 45px;
	height: 45px
}
.article_menu LI.button a em#h1_02_cat_and_goods {
background-position:18px -3px;
}
.article_menu LI.button a em#h1_03_promotion {
background-position:18px -40px;
}
.article_menu LI.button a em#h1_04_order {
background-position:18px -82px;
}
.article_menu LI.button a em#h1_05_banner {
background-position:18px -120px;
}
.article_menu LI.button a em#h1_06_stats {
background-position:18px -160px;
}
.article_menu LI.button a em#h1_07_content {
background-position:18px -200px;
}
.article_menu LI.button a em#h1_08_members {
background-position:18px -242px;
}
.article_menu LI.button a em#h1_10_priv_admin {
background-position:18px -276px;
}
.article_menu LI.button a em#h1_11_system {
background-position:18px -313px;
}
.article_menu LI.button a em#h1_12_template {
background-position:18px -352px;
}
.article_menu LI.button a em#h1_13_backup {
background-position:18px -387px;
}
.article_menu LI.button a em#h1_14_sms {
background-position:18px -424px;
}
.article_menu LI.button a em#h1_15_rec {
background-position:18px -458px;
}

.article_menu LI.button a em#h1_16_email_manage {
background-position:18px -493px;
}
.article_menu LI.button A:hover {
	TEXT-DECORATION: none
}
.article_menu LI.button A SPAN {
	RIGHT: 5px;
	BACKGROUND: url(images/help_menu-plus.gif) no-repeat;
	WIDTH: 16px;
	POSITION: absolute;
	TOP: 20px;
	HEIGHT: 16px
}
.article_menu LI.button A SPAN.add {
	RIGHT: 5px;
	BACKGROUND: url(images/help_menu-b5.gif) no-repeat;
	WIDTH: 16px;
	POSITION: absolute;
	TOP: 20px;
	HEIGHT: 16px
}
#menu-ul-suo {
	BACKGROUND: url(images/show_right.gif) no-repeat left top;
	width: 37px;
	height: 490px;
	display: none;
	float: left;
}
.dropdown {
	DISPLAY: none;
	width: 100%;
}
.dropdown LI {
	DISPLAY: block;
	PADDING-LEFT: 55px;
	BACKGROUND: url(images/menu_arrow.gif) no-repeat 0px center;
	COLOR: #666;
	LINE-HEIGHT: 30px;
	BORDER-BOTTOM: #f2f2f2 1px solid;
	HEIGHT: 30px;
}
.article_menu P {
	PADDING-RIGHT: 10px;
	PADDING-LEFT: 10px;
	PADDING-BOTTOM: 10px;
	PADDING-TOP: 10px;
	TEXT-ALIGN: center
}
</style>

<?php echo $this->smarty_insert_scripts(array('files'=>'../js/jquery.min.js,../js/jquery.easing.1.3.js,../js/helpmenu.js')); ?>
<script>
function showmenu()
{
  frmBody = parent.document.getElementById('frame-body');
  imgArrow = parent.drag_frame.document.getElementById('img');
  
    frmBody.cols="195, 12, *";
    imgArrow.src = "images/arrow_left.gif";
	parent.menu_frame.document.getElementById('menu-ul').style.display="block";
	document.getElementById('menu-ul-suo').style.display="none";
}
</script>

</head>
<body><div id="menu-list" class="article_menu">
<ul id="menu-ul" class="container">
<li class=menu>
<ul>
<?php $_from = $this->_var['menus']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('k', 'menu');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['menu']):
?>
<?php if ($this->_var['menu']['action']): ?>
 <LI class=button_wu><A class=green  href="<?php echo $this->_var['menu']['action']; ?>"><?php echo $this->_var['menu']['label']; ?><SPAN></SPAN></A></LI>
<?php else: ?>
  <li class=button  key="<?php echo $this->_var['k']; ?>" name="menu">
  <A  href="javascript:void(0);"><em  id="h1_<?php echo $this->_var['k']; ?>"></em><?php echo $this->_var['menu']['label']; ?><SPAN id="fa_<?php echo $this->_var['k']; ?>"></SPAN></A></li>
  <li  class="dropdown" id="<?php echo $this->_var['k']; ?>">
     <?php if ($this->_var['menu']['children']): ?>
    <ul>
    <?php $_from = $this->_var['menu']['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'child');if (count($_from)):
    foreach ($_from AS $this->_var['child']):
?>
      <li><a href="<?php echo $this->_var['child']['action']; ?>" target="main_frame"><?php echo $this->_var['child']['label']; ?></a></li>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </ul>
    <?php endif; ?>
  </li>
<?php endif; ?>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</ul>
</li>
</ul>
<a href="javascript:void(0)" id="menu-ul-suo" onclick="showmenu()"></a>
</div>
</body>
</html>
