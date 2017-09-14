<!DOCTYPE html >
<html>
<head>
<meta name="Generator" content="ECSHOP v2.7.3" />
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width">
<title><?php echo $this->_var['page_title']; ?></title>
<meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
<link rel="shortcut icon" href="favicon.ico" />
<link rel="icon" href="animated_favicon.gif" type="image/gif" />
<link href="<?php echo $this->_var['ecs_css_path']; ?>" rel="stylesheet" type="text/css" />

<link rel="stylesheet" type="text/css" href="themesmobile/68ecshopcom_mobile/css/public.css"/>
<link rel="stylesheet" type="text/css" href="themesmobile/68ecshopcom_mobile/css/activity.css"/>   
<script type="text/javascript" src="themesmobile/68ecshopcom_mobile/js/jquery.js"></script>
<?php echo $this->smarty_insert_scripts(array('files'=>'common.js,')); ?>
</head>
<body style="background:#f4f2f3">
      
      <div class="tab_nav">
        <div class="header">
          <div class="h-left"><a class="sb-back" href="javascript:history.back(-1)" title="返回"></a></div>
          <div class="h-mid">优惠活动</div>
          <div class="h-right">
            <aside class="top_bar">
              <div onClick="show_menu();$('#close_btn').addClass('hid');" id="show_more"><a href="javascript:;"></a> </div>
            </aside>
          </div>
        </div>
      </div>
       	<?php echo $this->fetch('library/up_menu.lbi'); ?> 
        

<div style=" width:100%; height:30px;"></div>
   <?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'val');if (count($_from)):
    foreach ($_from AS $this->_var['val']):
?>
   <div class="huodong">
  <div class="huodong_mid">
  <div class="h_left">惠</div>
  <div class="h_right">
  <p><img src="themesmobile/68ecshopcom_mobile/images/youhui.png"><?php echo sub_str($this->_var['val']['act_name'],14); ?></p>
   <div class="img"><img src="<?php if ($this->_var['val']['supplier_id'] > 0): ?>../<?php else: ?>..<?php endif; ?><?php echo empty($this->_var['val']['logo']) ? 'images/ceshi.jpg' : $this->_var['val']['logo']; ?>" width="100%" />
   <span><?php echo $this->_var['val']['start_time']; ?>~<?php echo $this->_var['val']['end_time']; ?></span>
   </div>
   
   <ul>
   <li><strong><?php echo $this->_var['lang']['label_act_type']; ?></strong><?php echo $this->_var['val']['act_type']; ?><?php if ($this->_var['val']['act_type'] != $this->_var['lang']['fat_goods']): ?><?php echo $this->_var['val']['act_type_ext']; ?><?php endif; ?></li>
   
   <li><strong><?php echo $this->_var['lang']['label_max_amount']; ?></strong><?php if ($this->_var['val']['max_amount'] > 0): ?><?php echo $this->_var['val']['max_amount']; ?><?php else: ?><?php echo $this->_var['lang']['nolimit']; ?><?php endif; ?><strong style=" padding-left:8px;"><?php echo $this->_var['lang']['label_min_amount']; ?></strong><?php echo $this->_var['val']['min_amount']; ?></li> 
    </ul>
       
     <dl class="fanwei"><dt><?php echo $this->_var['lang']['label_act_range']; ?></dt><dd><?php echo $this->_var['val']['act_range']; ?><?php if ($this->_var['val']['act_range'] != $this->_var['lang']['far_all']): ?>:
        <?php $_from = $this->_var['val']['act_range_ext']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'ext');if (count($_from)):
    foreach ($_from AS $this->_var['ext']):
?>
        &nbsp;&nbsp;<a href="<?php echo $this->_var['val']['program']; ?><?php echo $this->_var['ext']['id']; ?>" taget="_blank"><?php echo $this->_var['ext']['name']; ?></a>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        <?php endif; ?></dd></dl>
        
     <dl class="dengji"><dt><?php echo $this->_var['lang']['label_user_rank']; ?></dt>
     <dd>
     <?php $_from = $this->_var['val']['user_rank']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'user');if (count($_from)):
    foreach ($_from AS $this->_var['user']):
?>
       <span><?php echo $this->_var['user']; ?></span>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </dd>
        </dl>   
        
      
    <?php if ($this->_var['val']['gift']): ?>
    <div class="xin">
     <h4><em>|</em>&nbsp;特惠品信息</h4>
      <?php $_from = $this->_var['val']['gift']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
      <dl>
      <dt><a href="goods.php?id=<?php echo $this->_var['goods']['id']; ?>"><img src="../<?php echo $this->_var['goods']['thumb']; ?>" alt="<?php echo $this->_var['goods']['name']; ?>" /></a></dt>
      <dd><a href="goods.php?id=<?php echo $this->_var['goods']['id']; ?>" class="f6"><?php echo sub_str($this->_var['goods']['name'],30); ?></a>
           <strong> <?php if ($this->_var['goods']['price'] > 0): ?>
            加价：<?php echo $this->_var['goods']['price']; ?><?php echo $this->_var['lang']['unit_yuan']; ?>
            <?php else: ?>
            <?php echo $this->_var['lang']['for_free']; ?>
            <?php endif; ?></strong>
            </dd>
      </dl>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      </div>
    <?php endif; ?>
    
    
    </div>
  </div>
  </div>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

<script>
function goTop(){
	$('html,body').animate({'scrollTop':0},600);
}
</script>
<a href="javascript:goTop();" class="gotop"><img src="themesmobile/68ecshopcom_mobile/images/topup.png"></a> 
<?php echo $this->fetch('library/page_footer.lbi'); ?>
<?php echo $this->fetch('library/footer_nav.lbi'); ?>

</body>
</html>