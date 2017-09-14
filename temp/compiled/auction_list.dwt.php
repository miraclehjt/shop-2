<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="http://localhost/weishop/" />
<meta name="Generator" content="HongYuJD v7_2" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />

<title><?php echo $this->_var['page_title']; ?></title>



<link rel="shortcut icon" href="favicon.ico" />
<link rel="icon" href="animated_favicon.gif" type="image/gif" />
<link rel="stylesheet" href="themes/68ecshopcom_360buy/css/auction.css">
<script type="text/javascript" src="themes/68ecshopcom_360buy/js/jquery.pack.js"></script>
<script type="text/javascript" src="themes/68ecshopcom_360buy/js/slides.js"></script>
<script type="text/javascript" src="themes/68ecshopcom_360buy/js/slide.js"></script>

<?php echo $this->smarty_insert_scripts(array('files'=>'common.js,transport.js')); ?>
</head>
<body>
<div id="site-nav"> 
<?php echo $this->fetch('library/page_header.lbi'); ?> 
<div id="maincontent">
    <div class="element pict main">
    	
<?php $this->assign('ads_id','51'); ?><?php $this->assign('ads_num','1'); ?><?php echo $this->fetch('library/ad_position.lbi'); ?>

    </div>
    <div class="element pict">
    
<?php $this->assign('ads_id','52'); ?><?php $this->assign('ads_num','1'); ?><?php echo $this->fetch('library/ad_position.lbi'); ?>

    </div>
    <div class="element pict">
    	
<?php $this->assign('ads_id','53'); ?><?php $this->assign('ads_num','1'); ?><?php echo $this->fetch('library/ad_position.lbi'); ?>

    </div>
    <div class="element pict">
    
<?php $this->assign('ads_id','54'); ?><?php $this->assign('ads_num','1'); ?><?php echo $this->fetch('library/ad_position.lbi'); ?>

    </div>
    <div class="element navi left"><img src="themes/68ecshopcom_360buy/images/shengji_ad/left.gif" alt="left"></div>
    <div class="element navi right"><img src="themes/68ecshopcom_360buy/images/shengji_ad/right.gif" alt="right"></div>
</div>
<?php echo $this->fetch('library/ur_here.lbi'); ?>
  <div class="w main">
 <?php if ($this->_var['auction_list']): ?> 
  	<div class="layout_list">
    <h2>全部拍卖</h2>
      <ul class="clearfix">
      <?php $_from = $this->_var['auction_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'auction');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['auction']):
        $this->_foreach['name']['iteration']++;
?>
  		<li <?php if ($this->_foreach['name']['iteration'] % 5 == 1): ?>class="layout_list_1"<?php endif; ?>>
        	<a href="<?php echo $this->_var['auction']['url']; ?>" target="_blank" class="layout_pic"><img class="err-product" src="<?php echo $this->_var['auction']['goods_thumb']; ?>" width="220" height="220"></a>
          	<div class="layout_cont">
            	<a class="layout_name" target="_blank" href="<?php echo $this->_var['auction']['url']; ?>"><?php echo sub_str($this->_var['auction']['goods_name'],26); ?></a>
            	<div class="layout_price">当前价:<span><?php echo $this->_var['auction']['formated_current_price']; ?></span></div>
            	<a target="_blank" href="<?php echo $this->_var['auction']['url']; ?>" class="bid_btn bid_ing"></a>
          	</div>
        </li>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
  	  </ul>
    </div>
 <?php endif; ?> 
 <?php echo $this->fetch('library/pages.lbi'); ?> 
  </div>
  <div class="blank"></div>
  <?php echo $this->fetch('library/help.lbi'); ?> 
  <?php echo $this->fetch('library/page_footer.lbi'); ?> 
</div>
</body>
</html>
