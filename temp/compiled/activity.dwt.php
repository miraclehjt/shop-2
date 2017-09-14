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
<link href="<?php echo $this->_var['ecs_css_path']; ?>" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="themes/68ecshopcom_360buy/css/activity.css">
<script type="text/javascript" src="themes/68ecshopcom_360buy/js/jquery-1.9.1.min.js" ></script>
<script type="text/javascript" src="themes/68ecshopcom_360buy/js/jquery-lazyload.js" ></script>
<?php echo $this->smarty_insert_scripts(array('files'=>'jquery.json.js,transport.js')); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'common.js')); ?>
</head>
<body>
<div id="site-nav"> 
<?php echo $this->fetch('library/page_header.lbi'); ?> 
<div class="blank"></div>
<?php echo $this->fetch('library/ur_here.lbi'); ?>
  <div class="w">
    <div class="tgoulist">
      <div class="left tupian">
        <ul class="hdleft">
          <li class="hdl"><span><a href="activity.php#0" title="享受赠品">享受赠品</a></span></li>
          <li class="hdl"><span><a href="activity.php#1" title="现金减免">现金减免</a></span></li>
          <li class="hdl"><span><a href="activity.php#2" title="价格折扣">满减活动</a></span></li>
          <li class="hdl gotop"><span class="top"><a href="javascript:;">点击回到顶部</a></span></li>
        </ul>
      </div>
      <div id="slider" class="right" style="width:1020px;">
        <?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'val');$this->_foreach['val'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['val']['total'] > 0):
    foreach ($_from AS $this->_var['val']):
        $this->_foreach['val']['iteration']++;
?>
        <div class="list_biaoti" id="tg<?php echo $this->_foreach['name']['iteration']; ?>">
          <h3><i id="<?php echo $this->_var['val']['act_type_num']; ?>"></i>活动<?php echo $this->_foreach['val']['iteration']; ?>&nbsp;•&nbsp;&nbsp;<?php echo $this->_var['val']['act_name']; ?>
          	  <?php if ($this->_var['val']['shop_logo']): ?>
		   <a href="<?php if ($this->_var['val']['supplier_id'] == 0): ?>#<?php else: ?>supplier.php?suppId=<?php echo $this->_var['val']['supplier_id']; ?><?php endif; ?>" target="_blank"><img src="<?php echo $this->_var['val']['shop_logo']; ?>"></a>
		  <?php else: ?>
		   <a href="" target="_blank"><?php echo $this->_var['val']['shop_name']; ?></a>
		  <?php endif; ?>
          </h3>
        </div>
        <div class="list_tuangou">
          <div class="list_tt">
            <div class="left"><img data-original="<?php echo empty($this->_var['val']['logo']) ? 'images/ceshi.jpg' : $this->_var['val']['logo']; ?>" src="themes/68ecshopcom_360buy/images/loading.gif" height="260" width="580"></div>
            <div class="right">
              <h3><i></i><?php echo $this->_var['lang']['label_end_time']; ?><span><?php echo $this->_var['val']['end_time']; ?></span></h3>
              <p><?php echo $this->_var['lang']['label_max_amount']; ?> 
                <?php if ($this->_var['val']['max_amount'] > 0): ?> 
                <?php echo $this->_var['val']['max_amount']; ?> 
                <?php else: ?> 
                无 
                <?php endif; ?> 
                &nbsp; &nbsp; &nbsp; &nbsp;
                <?php echo $this->_var['lang']['label_min_amount']; ?>
                <?php echo $this->_var['val']['min_amount']; ?> </p>
              <p> <?php echo $this->_var['lang']['label_user_rank']; ?> 
                <?php $_from = $this->_var['val']['user_rank']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'user');if (count($_from)):
    foreach ($_from AS $this->_var['user']):
?> 
                <?php echo $this->_var['user']; ?>&nbsp;&nbsp; 
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
              </p>
              <p> <?php echo $this->_var['lang']['label_act_range']; ?><?php echo $this->_var['val']['act_range']; ?><?php if ($this->_var['val']['act_range'] != $this->_var['lang']['far_all']): ?> 
                : 
                <?php $_from = $this->_var['val']['act_range_ext']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'ext');if (count($_from)):
    foreach ($_from AS $this->_var['ext']):
?> 
                <a href="<?php echo $this->_var['val']['program']; ?><?php echo $this->_var['ext']['id']; ?>" taget="_blank"><span class="f_user_info" style="color:#E31939;"><u><?php echo $this->_var['ext']['name']; ?></u></span></a> 
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
                <?php endif; ?></p>
              <p><?php echo $this->_var['lang']['label_act_type']; ?><?php echo $this->_var['val']['act_type']; ?><?php if ($this->_var['val']['act_type'] != $this->_var['lang']['fat_goods']): ?><?php echo $this->_var['val']['act_type_ext']; ?><?php endif; ?> 
              </p>
              <div> 
                
                <!-- <span><a href="goods.php?id=<?php echo $this->_var['goods']['id']; ?>"><button>去看看</button></a></span>--> </div>
            </div>
            <div class="clear"></div>
          </div>
          
          <?php if ($this->_var['val']['gift']): ?>
          <div class="gift"> 
            <?php $_from = $this->_var['val']['gift']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['name1'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name1']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['name1']['iteration']++;
?>
            <table border="0" <?php if (($this->_foreach['name1']['iteration'] <= 1)): ?>style="margin-left:30px;"<?php endif; ?>>
              <tr>
                <td align="center"><a href="goods.php?id=<?php echo $this->_var['goods']['id']; ?>" class="thumb"><img data-original="<?php echo $this->_var['goods']['thumb']; ?>" src="themes/68ecshopcom_360buy/images/loading.gif" alt="<?php echo $this->_var['goods']['name']; ?>" width="160" height="160" /></a></td>
              </tr>
              <tr>
                <td align="center"><a href="goods.php?id=<?php echo $this->_var['goods']['id']; ?>" class="f6" title="<?php echo $this->_var['goods']['name']; ?>"><?php echo sub_str($this->_var['goods']['name'],16); ?></a></td>
              </tr>
              <tr>
                <td align="center" style="color:#E31939"><?php if ($this->_var['goods']['price'] > 0): ?> 
                  <?php echo $this->_var['goods']['price']; ?><?php echo $this->_var['lang']['unit_yuan']; ?> 
                  <?php else: ?> 
                  <?php echo $this->_var['lang']['for_free']; ?> 
                  <?php endif; ?></td>
              </tr>
            </table>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
          </div>
          <?php endif; ?> 
          
        </div>
        
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
      </div>
    </div>
  </div>
  <div class="blank"></div>
  <?php echo $this->fetch('library/help.lbi'); ?> 
  <?php echo $this->fetch('library/page_footer.lbi'); ?> 
</div>
<script type="text/javascript">
$("img").lazyload({
    effect       : "fadeIn",
	 skip_invisible : true,
	 failure_limit : 20
});

$(".top").click(function(){
$('body,html').animate({scrollTop:0},800);
return false;
});
</script>
</body>
</html>
