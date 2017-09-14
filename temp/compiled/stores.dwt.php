<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="http://localhost/weishop/" />
<meta name="Generator" content="HongYuJD v7_2" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title><?php echo $this->_var['page_title']; ?></title>



<meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link rel="shortcut icon" href="favicon.ico" />
<link rel="icon" href="animated_favicon.gif" type="image/gif" />
<link rel="stylesheet" href="themes/68ecshopcom_360buy/css/store.css">
<link rel="stylesheet" href="themes/68ecshopcom_360buy/css/second.css">
<link rel="stylesheet" href="themes/68ecshopcom_360buy/css/brandbar.css">
<script type="text/javascript" src="themes/68ecshopcom_360buy/js/jquery-1.9.1.min.js"></script>
<?php echo $this->smarty_insert_scripts(array('files'=>'jquery-1.6.2.min.js')); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'jquery.json.js,transport.js')); ?>
<script type="text/javascript" src="themes/68ecshopcom_360buy/js/jquery-lazyload.js" ></script>

</head>
<body>
<div id="site-nav"> 
  <?php echo $this->fetch('library/page_header.lbi'); ?>
  <div id="content">
    <div class="flow">
      <div class="cate_attr">
      <div class="nav-tag clearfix"> 
      	<h5 class="filter-label-ab">分类</h5>
        <div class="cate_attr_con">
        	<div class="filter-all-ab">
      			<a <?php if (! $_REQUEST['id']): ?> class="selected" <?php endif; ?> target="_self" href="stores.php"><span>全部</span></a>
            </div>
            <div class="district-tab">
        		<?php $_from = $this->_var['all']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');if (count($_from)):
    foreach ($_from AS $this->_var['cat']):
?> 
        		<a <?php if ($_REQUEST['id'] == $this->_var['cat']['str_id']): ?> class="selected" <?php endif; ?> target="_self" href="<?php echo $this->_var['cat']['url']; ?>"><span><?php echo $this->_var['cat']['str_name']; ?></span></a>
        		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </div> 
        </div>
      </div>
    </div>
      <?php echo $this->fetch('library/stores_list.lbi'); ?> 
	  <?php echo $this->fetch('library/stores_pager.lbi'); ?> 
    </div>
    <?php echo $this->fetch('library/stores_tuijian.lbi'); ?>
    <div class="blank5"></div>
  </div>
  <?php echo $this->fetch('library/help.lbi'); ?> 
  <?php echo $this->fetch('library/page_footer.lbi'); ?> 
  <?php echo $this->fetch('library/site_bar.lbi'); ?> </div>
</body>
<script type="text/javascript">

function guanzhu(sid){
	Ajax.call('supplier.php', 'go=other&act=add_guanzhu&suppId=' + sid, selcartResponse, 'GET', 'JSON');
}

function selcartResponse(result){
	
	alert(result.info);
}

function store_focus(e){
	var logo="#j_logo_"+e;
	var clo="#j_brand_"+e;
	$(logo).hide(); 
	$(clo).show();
	}
function store_nofocus(e){
	var logo="#j_logo_"+e;
	var clo="#j_brand_"+e;
	$(logo).show(); 
	$(clo).hide(); 
	}
$(".ft-bands div").mouseover(function(){
$(this).addClass('ft-col-cur').siblings().removeClass('ft-col-cur'); //切换选项卡标签的class
})
</script>
<script type="text/javascript">
$(document).ready(function(){ 
var headHeight=200;  //这个高度其实有更好的办法的。使用者根据自己的需要可以手工调整。
 
var nav=$("#J_NavTag"); 
$(window).scroll(function(){ 
 
if($(this).scrollTop()>headHeight){ 
nav.addClass("nav-fixed"); 
} 
else{ 
nav.removeClass("nav-fixed"); 
} 
}) 
})
</script>

<script type="text/javascript">
$("img").lazyload({
    effect       : "fadeIn",
	 skip_invisible : true,
	 failure_limit : 20
});
</script>

</html>
