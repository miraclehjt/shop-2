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
<script type="text/javascript" src="themes/68ecshopcom_360buy/js/jquery-1.9.1.min.js"></script>
<?php echo $this->smarty_insert_scripts(array('files'=>'jquery.json.js,transport.js,json2.js')); ?>

<?php echo $this->smarty_insert_scripts(array('files'=>'common.js,user.js')); ?>
</head>
<body>
<div id="site-nav" > 
  <?php echo $this->fetch('library/page_header.lbi'); ?>
  <div class="blank"></div>
  <?php echo $this->fetch('library/ur_here.lbi'); ?>
  <div class="block clearfix"> 
    
    <div class="AreaL">
      <div class="box"> 
	  	<?php echo $this->fetch('library/user_info.lbi'); ?> 
		<?php echo $this->fetch('library/user_menu.lbi'); ?> 
      </div>
    </div>
     
    
    <div class="AreaR">
      <div class="clearfix usBox_y"> 
         
        <?php if ($this->_var['action'] == 'default'): ?>
        <div class="account">
          <div class="money">
            <ul class="clearfix">
              <li class="first">
                <div class="title"><span>账号余额</span></div>
                <div class="pic"><a href="user.php?act=account_log"><i class="user_bg"></i></a></div>
                <p><a href="user.php?act=account_log" class="_capitalAccount"><?php echo $this->_var['info']['surplus']; ?></a></p>
              </li>
              <li class="second">
                <div class="title"><span>红包</span></div>
                <div class="pic"><a href="user.php?act=bonus"><i class="user_bg"></i></a></div>
                <p><a href="user.php?act=bonus" class="_backAccount"><?php echo $this->_var['info']['bonus']; ?></a>张</p>
              </li>
              <li class="third">
                <div class="title"><span>可用积分</span></div>
                <div class="pic"><i class="user_bg"></i></div>
                <p><span class="_goldAccount"><?php echo $this->_var['info']['integral']; ?></span></p>
              </li>
            </ul>
          </div>
          <div class="security">
            <div class="improve">
              <p>账户安全</p>
              <strong class="low"> <?php if ($this->_var['info']['is_validated'] == 0 && $this->_var['info']['validated'] == 0 && $this->_var['info']['is_surplus_open'] == 0): ?>危险<?php endif; ?>
              <?php if ($this->_var['info']['is_validated'] == 1 && $this->_var['info']['validated'] == 0 && $this->_var['info']['is_surplus_open'] == 0): ?>一般<?php endif; ?>
              <?php if ($this->_var['info']['is_validated'] == 0 && $this->_var['info']['validated'] == 1 && $this->_var['info']['is_surplus_open'] == 0): ?>一般<?php endif; ?>
              <?php if ($this->_var['info']['is_validated'] == 0 && $this->_var['info']['validated'] == 0 && $this->_var['info']['is_surplus_open'] == 1): ?>一般<?php endif; ?>
              <?php if ($this->_var['info']['is_validated'] == 1 && $this->_var['info']['validated'] == 1 && $this->_var['info']['is_surplus_open'] == 0): ?>较高<?php endif; ?>
              <?php if ($this->_var['info']['is_validated'] == 0 && $this->_var['info']['validated'] == 1 && $this->_var['info']['is_surplus_open'] == 1): ?>较高<?php endif; ?>
              <?php if ($this->_var['info']['is_validated'] == 1 && $this->_var['info']['validated'] == 0 && $this->_var['info']['is_surplus_open'] == 1): ?>较高<?php endif; ?>
              <?php if ($this->_var['info']['is_validated'] == 1 && $this->_var['info']['validated'] == 1 && $this->_var['info']['is_surplus_open'] == 1): ?>高<?php endif; ?> </strong>
              <?php if ($this->_var['info']['is_validated'] == 0 && $this->_var['info']['validated'] == 0 && $this->_var['info']['is_surplus_open'] == 0): ?><i class="user_bg danger"><em></em></i><?php endif; ?>
              <?php if ($this->_var['info']['is_validated'] == 1 && $this->_var['info']['validated'] == 0 && $this->_var['info']['is_surplus_open'] == 0): ?><i class="user_bg low"><em></em></i><?php endif; ?>
              <?php if ($this->_var['info']['is_validated'] == 0 && $this->_var['info']['validated'] == 1 && $this->_var['info']['is_surplus_open'] == 0): ?><i class="user_bg low"><em></em></i><?php endif; ?>
              <?php if ($this->_var['info']['is_validated'] == 0 && $this->_var['info']['validated'] == 0 && $this->_var['info']['is_surplus_open'] == 1): ?><i class="user_bg low"><em></em></i><?php endif; ?>
              <?php if ($this->_var['info']['is_validated'] == 1 && $this->_var['info']['validated'] == 1 && $this->_var['info']['is_surplus_open'] == 0): ?><i class="user_bg middle"><em></em></i><?php endif; ?>
              <?php if ($this->_var['info']['is_validated'] == 1 && $this->_var['info']['validated'] == 0 && $this->_var['info']['is_surplus_open'] == 1): ?><i class="user_bg middle"><em></em></i><?php endif; ?>
              <?php if ($this->_var['info']['is_validated'] == 0 && $this->_var['info']['validated'] == 1 && $this->_var['info']['is_surplus_open'] == 1): ?><i class="user_bg middle"><em></em></i><?php endif; ?>
              <?php if ($this->_var['info']['is_validated'] == 1 && $this->_var['info']['validated'] == 1 && $this->_var['info']['is_surplus_open'] == 1): ?><i class="user_bg high"><em></em></i><?php endif; ?>
              <a href="security.php" title="提升账户安全等级">提升 &gt;</a> </div>
            <div class="yzHome clearfix">
              <div class="phone yzType"> <i class="user_bg titIcon"></i> 
              <span class="yzTit">手机：</span> 
              <?php if ($this->_var['info']['mobile_phone'] == ''): ?>
              <a class="res" href="security.php?act=mobile_binding">未绑定
              <?php elseif ($this->_var['info']['validated'] == 0): ?>
              <a class="res" href="security.php?act=mobile_validate">未验证
              <?php else: ?>已验证<?php endif; ?></a> </div>
              <div class="mail yzType"><i class="user_bg titIcon"></i>
              <span class="yzTit">邮箱：</span>
              <?php if ($this->_var['info']['email'] == ''): ?>
              <a class="res" href="security.php?act=email_binding">未绑定
              <?php elseif ($this->_var['info']['is_validated'] == 0): ?>
              <a class="res" href="security.php?act=email_validate">未验证
              <?php else: ?>已验证<?php endif; ?></a> </div>
            </div>
          </div>
          <div class="middle order">
            <div class="line1 clearfix">
              <div class="title"><i></i><span>交易提醒</span></div>
              <div class="status">
                <ul>
                  <li><a href="user.php?act=order_list&composite_status=0" title="未确认订单">未确认<span id="uc_dfkdd"><?php echo $this->_var['shu']['daif']; ?></span></a><i></i></li>
                  <li><a href="user.php?act=order_list&composite_status=100" title="待付款订单">待付款<span id="uc_dshdd"><?php echo $this->_var['shu']['dais']; ?></span></a><i></i></li>
                  <li><a href="user.php?act=my_comment" title="待评价商品">待评价<span id="uc_dpjsp"><?php echo $this->_var['num_comment']; ?></span></a></li>
                </ul>
              </div>
              <a class="more" href="user.php?act=order_list" title="查看全部订单">查看全部订单 &gt;</a></div>
             
            <?php if ($this->_var['reminding'] == array ( )): ?>
            <div class="emptyFrame clearfix" > <i class="user_bg"></i><span>您好久没在商城购物了，这里空空的，赶快去购物吧！</span> </div>
             
             
            <?php else: ?>
            <div class="proListUc"  > <?php $_from = $this->_var['reminding']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'jiao');if (count($_from)):
    foreach ($_from AS $this->_var['jiao']):
?>
              <ul class="listLine clearfix">
                <li>
                  <ul class="img clearfix">
                    <li style="position:relative"> <a href="user.php?act=order_detail&order_id=<?php echo $this->_var['jiao']['order_id']; ?>" title="<?php echo $this->_var['jiao']['goods_name']; ?>" target="_blank"> 
                      <?php if ($this->_var['jiao']['goods_id'] > 0 && $this->_var['jiao']['extension_code'] != 'package_buy'): ?> 
                      <img src="<?php echo $this->_var['jiao']['goods_thumb']; ?>" alt="<?php echo $this->_var['jiao']['goods_name']; ?>" /> 
                      <?php elseif ($this->_var['jiao']['goods_id'] > 0 && $this->_var['jiao']['extension_code'] == 'package_buy'): ?> 
                      <img src="themes/68ecshopcom_360buy/images/jmpic/ico_cart_package.gif" border="0" title="<?php echo htmlspecialchars($this->_var['jiao']['goods_name']); ?>" /> 
                      <?php endif; ?> 
                      </a> <span style="height:15px;line-height:15px;position:absolute;top:0px;right:0px;z-index:10;background:#ED5854;color:#fff;padding:0px 3px;"><?php echo $this->_var['jiao']['shu']; ?></span> </li>
                  </ul>
                </li>
                <li class="name"><a href="user.php?act=order_detail&order_id=<?php echo $this->_var['jiao']['order_id']; ?>" title="<?php echo $this->_var['jiao']['goods_name']; ?>" target="_blank"><?php echo $this->_var['jiao']['goods_name']; ?></a></li>
                <li class="attr"><?php echo $this->_var['jiao']['goods_attr']; ?></li>
                <li class="type"><?php echo $this->_var['jiao']['handler']; ?></li>
                <li class="check"> <a href="user.php?act=order_detail&order_id=<?php echo $this->_var['jiao']['order_id']; ?>" title="查看订单" target="_blank">查看</a> </li>
              </ul>
              <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> </div>
            <?php endif; ?> 
             
          </div>
          <div class="middle cart">
            <div class="line1 clearfix">
              <div class="title"><i></i><span>我的购物车</span></div>
            </div>
            <?php if ($this->_var['gouwuche'] == array ( )): ?> 
            
            <div class="emptyFrame_cart" > <i class="user_bg"></i><span>您的购物车里空空的，赶快去购物吧！</span> </div>
            <?php else: ?> 
             
             
            <script type="text/javascript" charset="utf-8" src="themes/68ecshopcom_360buy/js/easyscroll.js"></script>
            <div class="proListUc_cart">
              <div class="div_scroll">
                <div style="float:left; height:auto; width:auto">
                  <ul class="listLine_cart clearfix">
                    <?php $_from = $this->_var['gouwuche']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'che');if (count($_from)):
    foreach ($_from AS $this->_var['che']):
?>
                    <li> <a href="goods.php?id=<?php echo $this->_var['che']['goods_id']; ?>" target="_blank" title="<?php echo $this->_var['che']['goods_name']; ?>" class="pic"> <img src="<?php echo $this->_var['che']['goods_thumb']; ?>" alt="" /> </a> <a href="goods.php?id=<?php echo $this->_var['che']['goods_id']; ?>" target="_blank" title="<?php echo $this->_var['che']['goods_name']; ?>" class="name"><?php echo $this->_var['che']['goods_name']; ?></a>
                      <p> 本店价：<font style="color:#FF966E">￥<?php echo $this->_var['che']['goods_price']; ?></font> </p>
                    </li>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                  </ul>
                </div>
              </div>
              <p class="more"> <a href="flow.php" target="_blank" title="查看购物车所有商品">查看购物车所有商品</a> </p>
            </div>
            <?php endif; ?> 
             
          </div>
          <div class="middle exchange">
            <div class="line1 clearfix">
              <div class="title"><i></i><span>积分兑换</span></div>
              <a class="more" href="exchange.php" title="进入积分商城">进入积分商城 &gt;</a> </div>
            <?php if ($this->_var['jifen'] == array ( )): ?> 
            
            <div class="emptyFrame_exchange clearfix" > <i class="user_bg"></i><span>没有可兑换的商品呦！随便去逛逛吧！</span> </div>
             
            <?php else: ?> 
            
            <div class="exchangeList">
              <div class="colFrame">
                <ul style="left: 26px;" class="clearfix">
                  <?php $_from = $this->_var['jifen']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'ji');if (count($_from)):
    foreach ($_from AS $this->_var['ji']):
?>
                  <li class="first"> <a href="exchange.php?id=<?php echo $this->_var['ji']['goods_id']; ?>&act=view" title="<?php echo $this->_var['ji']['goods_name']; ?>" target="_blank" class="img"> <img src="<?php echo $this->_var['ji']['goods_thumb']; ?>" alt="<?php echo $this->_var['ji']['goods_name']; ?>"> <span><?php echo $this->_var['ji']['exchange_integral']; ?>积分</span> </a> <a href="exchange.php?id=<?php echo $this->_var['ji']['goods_id']; ?>&act=view" title="<?php echo $this->_var['ji']['goods_name']; ?>" target="_blank" class="name"><?php echo $this->_var['ji']['goods_name']; ?></a> </li>
                  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </ul>
              </div>
            </div>
             
            <?php endif; ?> </div>
          <div class="middle history">
            <div class="line1 clearfix">
              <div class="title"><i></i><span>我的足迹</span></div>
            </div>
            <?php if ($this->_var['mai'] == array ( )): ?> 
            
            <div class="emptyFrame_history" > <i class="user_bg"></i><span>您还没有留下任何足迹！</span> </div>
             
             
            <?php else: ?>
            <div class="proListUc_history">
              <div class="colFrame">
                <ul style="left: 0px;" class="clearfix">
                  <?php $_from = $this->_var['mai']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'li');if (count($_from)):
    foreach ($_from AS $this->_var['li']):
?>
                  <li class="first"> <a href="#" title="<?php echo $this->_var['li']['goods_name']; ?>" target="_blank" class="img">
                    <div class="mask"></div>
                    <img src="<?php echo $this->_var['li']['goods_thumb']; ?>" alt="<?php echo $this->_var['li']['goods_name']; ?>"> </a> <a href="#" title="<?php echo $this->_var['li']['goods_name']; ?>" target="_blank" class="name"><?php echo $this->_var['li']['goods_name']; ?></a>
                    <p class="pri">￥<?php echo $this->_var['li']['goods_price']; ?></p>
                  </li>
                  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </ul>
              </div>
              <p class="more"> <a href="index.php" target="_blank" title="继续购物">继续购物 &gt;</a> </p>
            </div>
            <?php endif; ?> 
             
          </div>
          <script>
/*第一种形式 第二种形式 更换显示样式*/
function setTabCatGoods(name,cursel,n){
for(i=1;i<=n;i++){
var menu=document.getElementById(name+i);
var con=document.getElementById("con_"+name+"_"+i);
con.style.display=i==cursel?"block":"none";
menu.className=i==cursel?"line1":"line2";
}
}
</script>
          <div class="middle collect">
            <div class="line1" id="tab1" onmouseover="setTabCatGoods('tab',1,2)">
              <div class="title"><i></i><span>商品收藏</span></div>
            </div>
            <div class="line2" id="tab2" onmouseover="setTabCatGoods('tab',2,2)">
              <div class="title"><i></i><span>店铺关注</span></div>
            </div>
            <div style="height:0px;line-height:0px;clear:both"></div>
            <div class="tab_con" style="width:100%">
              <div class=""  id="con_tab_1"> <?php if ($this->_var['collection'] == array ( )): ?> 
                
                <div class="emptyFrame_collect"> <i class="user_bg"></i><span>您的收藏空空的，赶快去购物吧！</span> </div>
                 
                 
                <?php else: ?>
                <div class="colList clearfix">
                  <div class="colFrame">
                    <ul style="left: 0px;" class="clearfix">
                      <?php $_from = $this->_var['collection']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'coll');$this->_foreach['coll'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['coll']['total'] > 0):
    foreach ($_from AS $this->_var['coll']):
        $this->_foreach['coll']['iteration']++;
?>
                      <?php if ($this->_foreach['coll']['iteration'] < 7): ?>
                      <li class="first"> <a href="goods.php?id=<?php echo $this->_var['coll']['goods_id']; ?>" title="<?php echo $this->_var['coll']['goods_name']; ?>" target="_blank" class="img"> <img src="<?php echo $this->_var['coll']['goods_thumb']; ?>"> <span>￥<?php echo $this->_var['coll']['shop_price']; ?></span> </a> <a href="goods.php?id=<?php echo $this->_var['coll']['goods_id']; ?>" title="<?php echo $this->_var['coll']['goods_name']; ?>" target="_blank" class="name"><?php echo $this->_var['coll']['goods_name']; ?></a> </li>
                      <?php endif; ?>
                      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </ul>
                  </div>
                  <p class="more"> <a href="user.php?act=collection_list" title="查看收藏的所有商品">查看收藏的所有商品 &gt;</a> </p>
                </div>
                <?php endif; ?> 
                 
              </div>
              <div id="con_tab_2" style="display:none"> <?php if ($this->_var['guanzhu'] == array ( )): ?> 
                
                <div class="emptyFrame_shop"  > <i class="user_bg"></i><span>您的店铺收藏空空的，赶快去收藏店铺吧！</span> </div>
                 
                 
                <?php else: ?>
                <div class="shopList clearfix">
                  <div class="colFrame">
                    <ul style="left: 0px;" class="clearfix">
                      <?php $_from = $this->_var['guanzhu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'guan');$this->_foreach['guan'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['guan']['total'] > 0):
    foreach ($_from AS $this->_var['guan']):
        $this->_foreach['guan']['iteration']++;
?>
                      <?php if ($this->_foreach['guan']['iteration'] < 7): ?>
                      <li class="first"> <a href="supplier.php?go=index&suppId=<?php echo $this->_var['guan']['supplier_id']; ?>&id=0" title="<?php echo $this->_var['guan']['supplier_name']; ?>" target="_blank" class="img">
                        <div class="mask"></div>
                        <img src="<?php echo $this->_var['guan']['logo']; ?>" alt="<?php echo $this->_var['guan']['supplier_name']; ?>"> </a> <a href="supplier.php?go=index&suppId=<?php echo $this->_var['guan']['supplier_id']; ?>&id=0" title="<?php echo $this->_var['guan']['supplier_name']; ?>" target="_blank" class="name"><?php echo $this->_var['guan']['supplier_name']; ?></a> </li>
                        <?php endif; ?>
                      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </ul>
                  </div>
                  <p class="more"> <a href="user.php?act=follow_shop" title="查看收藏的所有店铺">查看收藏的所有店铺 &gt;</a> </p>
                </div>
                 
                 
                <?php endif; ?> </div>
            </div>
          </div>
        </div>
        <?php endif; ?>
        <div class="box">
          <div class="box_1">
            <div class="userCenterBox boxCenterList clearfix"> 
               
               
              <?php if ($this->_var['action'] == 'message_list'): ?>
              <div class="tabmenu">
                <ul class="tab pngFix">
                  <li class="first active"><a><?php echo $this->_var['lang']['label_message']; ?></a></li>
                </ul>
              </div>
              <div class="mar_top">
                <div class="box"> 
                  <?php $_from = $this->_var['message_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'message');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['message']):
?>
                  <div class="f_l"> <b><?php echo $this->_var['message']['msg_type']; ?>:</b>&nbsp;&nbsp;<font class="f4"><?php echo $this->_var['message']['msg_title']; ?></font> (<?php echo $this->_var['message']['msg_time']; ?>) </div>
                  <div class="f_r"> <a href="user.php?act=del_msg&amp;id=<?php echo $this->_var['key']; ?>&amp;order_id=<?php echo $this->_var['message']['order_id']; ?>" title="<?php echo $this->_var['lang']['drop']; ?>" onclick="if (!confirm('<?php echo $this->_var['lang']['confirm_remove_msg']; ?>')) return false;" class="f6"><?php echo $this->_var['lang']['drop']; ?></a> </div>
                  <div class="msgBottomBorder"> <?php echo $this->_var['message']['msg_content']; ?> 
                    <?php if ($this->_var['message']['message_img']): ?>
                    <div align="right"> <a href="data/feedbackimg/<?php echo $this->_var['message']['message_img']; ?>" target="_bank" class="f6"><?php echo $this->_var['lang']['view_upload_file']; ?></a> </div>
                    <?php endif; ?> 
                    <br />
                    <?php if ($this->_var['message']['re_msg_content']): ?> 
                    <a href="mailto:<?php echo $this->_var['message']['re_user_email']; ?>" class="f6"><?php echo $this->_var['lang']['shopman_reply']; ?></a> (<?php echo $this->_var['message']['re_msg_time']; ?>)<br />
                    <?php echo $this->_var['message']['re_msg_content']; ?> 
                    <?php endif; ?> 
                  </div>
                  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
                  <?php if ($this->_var['message_list']): ?>
                  <div class="f_r"> <?php echo $this->fetch('library/pages.lbi'); ?> </div>
                  <?php endif; ?>
                  <div class="blank"></div>
                  <form action="user.php" method="post" enctype="multipart/form-data" name="formMsg" onSubmit="return submitMsg()">
                    <table width="100%" border="0" cellpadding="3">
                      <?php if ($this->_var['order_info']): ?>
                      <tr>
                        <td align="right"><?php echo $this->_var['lang']['order_number']; ?></td>
                        <td><a href ="<?php echo $this->_var['order_info']['url']; ?>"><img src="themes/68ecshopcom_360buy/images/note.gif" /><?php echo $this->_var['order_info']['order_sn']; ?></a>
                          <input name="msg_type" type="hidden" value="5" />
                          <input name="order_id" type="hidden" value="<?php echo $this->_var['order_info']['order_id']; ?>" class="inputBg" /></td>
                      </tr>
                      <?php else: ?>
                      <tr>
                        <td align="right"><?php echo $this->_var['lang']['message_type']; ?>：</td>
                        <td><input name="msg_type" type="radio" value="0" checked="checked" />
                          <?php echo $this->_var['lang']['type']['0']; ?>
                          <input type="radio" name="msg_type" value="1" />
                          <?php echo $this->_var['lang']['type']['1']; ?>
                          <input type="radio" name="msg_type" value="2" />
                          <?php echo $this->_var['lang']['type']['2']; ?>
                          <input type="radio" name="msg_type" value="3" />
                          <?php echo $this->_var['lang']['type']['3']; ?>
                          <input type="radio" name="msg_type" value="4" />
                          <?php echo $this->_var['lang']['type']['4']; ?> </td>
                      </tr>
                      <?php endif; ?>
                      <tr>
                        <td align="right"><?php echo $this->_var['lang']['message_title']; ?>：</td>
                        <td><input name="msg_title" type="text" size="30" class="inputBg" /></td>
                      </tr>
                      <tr>
                        <td align="right" valign="top"><?php echo $this->_var['lang']['message_content']; ?>：</td>
                        <td><textarea name="msg_content" cols="50" rows="4" wrap="virtual" class="B_blue"></textarea></td>
                      </tr>
                      <tr>
                        <td align="right"><?php echo $this->_var['lang']['upload_img']; ?>：</td>
                        <td><input type="file" name="message_img"  size="45"  class="inputBg" /></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td><input type="hidden" name="act" value="act_add_message" />
                          <input type="submit" value="<?php echo $this->_var['lang']['submit']; ?>" class="bnt_bonus white" /></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td> <?php echo $this->_var['lang']['img_type_tips']; ?><br />
                          <?php echo $this->_var['lang']['img_type_list']; ?> </td>
                      </tr>
                    </table>
                  </form>
                </div>
              </div>
              <?php endif; ?> 
               
               
              <?php if ($this->_var['action'] == 'comment_list'): ?>
              <h5><span><?php echo $this->_var['lang']['label_comment']; ?></span></h5>
              <div class="box"> 
                <?php $_from = $this->_var['comment_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'comment');if (count($_from)):
    foreach ($_from AS $this->_var['comment']):
?>
                <div class="f_l"> <b><?php if ($this->_var['comment']['comment_type'] == '0'): ?><?php echo $this->_var['lang']['goods_comment']; ?><?php else: ?><?php echo $this->_var['lang']['article_comment']; ?><?php endif; ?>: </b><font class="f4"><?php echo $this->_var['comment']['cmt_name']; ?></font>&nbsp;&nbsp;(<?php echo $this->_var['comment']['formated_add_time']; ?>) </div>
                <div class="f_r"> <a href="user.php?act=del_cmt&amp;id=<?php echo $this->_var['comment']['comment_id']; ?>" title="<?php echo $this->_var['lang']['drop']; ?>" onclick="if (!confirm('<?php echo $this->_var['lang']['confirm_remove_msg']; ?>')) return false;" class="f6"><?php echo $this->_var['lang']['drop']; ?></a> </div>
                <div class="msgBottomBorder"> <?php echo htmlspecialchars($this->_var['comment']['content']); ?><br />
                  <?php if ($this->_var['comment']['reply_content']): ?> 
                  <b><?php echo $this->_var['lang']['reply_comment']; ?>：</b><br />
                  <?php echo $this->_var['comment']['reply_content']; ?> 
                  <?php endif; ?> 
                </div>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
                <?php if ($this->_var['comment_list']): ?> 
                <?php echo $this->fetch('library/pages.lbi'); ?> 
                <?php else: ?> 
                <?php echo $this->_var['lang']['no_comments']; ?> 
                <?php endif; ?> 
              </div>
              <?php endif; ?> 
               
               
              <?php if ($this->_var['action'] == 'tag_list'): ?>
              <div class="tabmenu">
                <ul class="tab pngFix">
                  <li class="first active"><a><?php echo $this->_var['lang']['label_tag']; ?></a></li>
                </ul>
              </div>
              <div class="mar_top">
                <div class="box"> 
                  <?php if ($this->_var['tags']): ?> 
                  <?php $_from = $this->_var['tags']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'tag');if (count($_from)):
    foreach ($_from AS $this->_var['tag']):
?> 
                  <a href="search.php?keywords=<?php echo urlencode($this->_var['tag']['tag_words']); ?>" class="f6"><?php echo htmlspecialchars($this->_var['tag']['tag_words']); ?></a> <a href="user.php?act=act_del_tag&amp;tag_words=<?php echo urlencode($this->_var['tag']['tag_words']); ?>" onclick="if (!confirm('<?php echo $this->_var['lang']['confirm_drop_tag']; ?>')) return false;" title="<?php echo $this->_var['lang']['drop']; ?>"><img src="themes/68ecshopcom_360buy/images/drop.gif" alt="<?php echo $this->_var['lang']['drop']; ?>" /></a>&nbsp;&nbsp; 
                  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
                  <?php else: ?> 
                  <span style="margin:2px 10px; font-size:14px; line-height:36px;"><?php echo $this->_var['lang']['no_tag']; ?></span> 
                  <?php endif; ?> 
                </div>
              </div>
              <?php endif; ?> 
               
               
              <?php if ($this->_var['action'] == 'follow_shop'): ?> 
              <?php echo $this->smarty_insert_scripts(array('files'=>'transport.js,utils.js')); ?>
              <div class="tabmenu">
                <ul class="tab pngFix">
                  <li class="active"><a>我关注的店铺</a></li>
                </ul>
              </div>
              <div class="mar_top">
                <table class="ncm-default-table">
                  <thead>
                    <tr>
                      <th colspan="2">店铺</th>
                      <th class="w150">商家名称</th>
                      <th class="w150">联系QQ</th>
                      <th class="w100">联系旺旺</th>
                      <th class="w110">操作</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $_from = $this->_var['shop_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'shop');if (count($_from)):
    foreach ($_from AS $this->_var['shop']):
?>
                    <tr class="bd-line">
                      <td class="w70"><div class="ncm-goods-thumb" style="padding:10px;"><a href="<?php echo $this->_var['shop']['url']; ?>" title="<?php echo $this->_var['shop']['shop_name']; ?>"><img src="<?php echo $this->_var['shop']['shop_logo']; ?>"  style="border:1px #E4E4E4 solid"/></a></div></td>
                      <td><dl class="goods-name">
                          <dt><a href="<?php echo $this->_var['shop']['url']; ?>" title="<?php echo $this->_var['shop']['shop_name']; ?>"><?php echo $this->_var['shop']['shop_name']; ?></a> </dt>
                        </dl></td>
                      <td><a href="<?php echo $this->_var['shop']['url']; ?>" class="f6"><?php echo htmlspecialchars($this->_var['shop']['supplier_name']); ?></a></td>
                      <td><?php echo $this->_var['shop']['qq']; ?></td>
                      <td><?php echo $this->_var['shop']['ww']; ?></td>
                      <td class="ncm-table-handle"><span><a href="javascript:if (confirm('确定取消关注？')) location.href='user.php?act=del_follow&rec_id=<?php echo $this->_var['shop']['id']; ?>'" class="f6">取消关注</a></span></td>
                    </tr>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                  </tbody>
                </table>
                <?php echo $this->fetch('library/pages.lbi'); ?> </div>
              
              <?php endif; ?> 
               
               
              <?php if ($this->_var['action'] == 'collection_list'): ?> 
              <?php echo $this->smarty_insert_scripts(array('files'=>'transport.js,utils.js')); ?>
              <div class="tabmenu">
                <ul class="tab pngFix">
                  <li class="first active"><a><?php echo $this->_var['lang']['label_collection']; ?></a><span style="font-size:12px;margin-left:15px">(关注以下的商品后，您绑定的邮箱可随时接受到关注商品的最新动态)</span></li>
                </ul>
              </div>
              <div class="mar_top">
                <table class="ncm-default-table">
                  <tbody>
                    <tr>
                      <td colspan="2" class="pic-model"><ul>
                          <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
                          <li class="favorite-pic-list">
                            <div class="favorite-goods-thumb"><a href="<?php echo $this->_var['goods']['url']; ?>" target="_blank" title="<?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?>"><img src="<?php echo $this->_var['goods']['thumb']; ?>" alt="<?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?>" width="220" height="220"></a></div>
                            <div style="top: -30px;" class="favorite-goods-info">
                              <dl>
                                <dt>
                                <?php if ($this->_var['goods']['is_pre_sale'] == 1): ?>
                                <a href="<?php echo $this->_var['goods']['url']; ?>" target="_blank" title="<?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?>">【<span style="color: red;"><?php echo $this->_var['lang']['label_pre_sale']; ?></span>】<?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?></a>
                                <?php else: ?>
                                <a href="<?php echo $this->_var['goods']['url']; ?>" target="_blank" title="<?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?>"><?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?></a>
                                <?php endif; ?>
                                </dt>
                                <dd> <span> <strong> 
                                  <?php if ($this->_var['goods']['promote_price'] != ""): ?> 
                                  <?php echo $this->_var['goods']['promote_price']; ?> 
                                  <?php else: ?> 
                                  <?php echo $this->_var['goods']['shop_price']; ?> 
                                  <?php endif; ?> 
                                  </strong> </span> </dd>
                                <dd class="hover_tan"> 
                                  <?php if ($this->_var['goods']['is_attention']): ?> 
                                  <i class="guanzhu1"></i><a href="javascript:if (confirm('<?php echo $this->_var['lang']['del_attention']; ?>')) location.href='user.php?act=del_attention&rec_id=<?php echo $this->_var['goods']['rec_id']; ?>'" class="ncm-btn-mini"><?php echo $this->_var['lang']['no_attention']; ?></a> 
                                  <?php else: ?> 
                                  <i class="guanzhu2"></i><a href="javascript:if (confirm('<?php echo $this->_var['lang']['add_to_attention']; ?>')) location.href='user.php?act=add_to_attention&rec_id=<?php echo $this->_var['goods']['rec_id']; ?>'" class="ncm-btn-mini"><?php echo $this->_var['lang']['attention']; ?></a> 
                                  <?php endif; ?> 
                                  <?php if ($this->_var['goods']['is_pre_sale'] == 1): ?>
                                  <i class="cart"></i><a href="pre_sale.php?id=<?php echo $this->_var['goods']['pre_sale_id']; ?>" target="_blank" class="ncm-btn-mini"><?php echo $this->_var['lang']['button_buy']; ?></a> <i class="del"></i><a href="javascript:if (confirm('<?php echo $this->_var['lang']['remove_collection_confirm']; ?>')) location.href='user.php?act=delete_collection&collection_id=<?php echo $this->_var['goods']['rec_id']; ?>'" class="ncm-btn-mini ncm-btn-mini1"><?php echo $this->_var['lang']['drop']; ?></a> </dd>
                                  <?php else: ?>
                                  <i class="cart"></i><a href="javascript:addToCart(<?php echo $this->_var['goods']['goods_id']; ?>)" class="ncm-btn-mini"><?php echo $this->_var['lang']['add_to_cart']; ?></a> <i class="del"></i><a href="javascript:if (confirm('<?php echo $this->_var['lang']['remove_collection_confirm']; ?>')) location.href='user.php?act=delete_collection&collection_id=<?php echo $this->_var['goods']['rec_id']; ?>'" class="ncm-btn-mini ncm-btn-mini1"><?php echo $this->_var['lang']['drop']; ?></a> </dd>
                                  <?php endif; ?>
                              </dl>
                            </div>
                          </li>
                          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        </ul>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <?php echo $this->fetch('library/pages.lbi'); ?> </div>
         
              <div class="mar_top">
            
                <script type="text/javascript">
					var url = '<?php echo $this->_var['url']; ?>';
					var u   = '<?php echo $this->_var['user_id']; ?>';
			      
					var compare_no_goods = "<?php echo $this->_var['lang']['compare_no_goods']; ?>";
					var btn_buy = "<?php echo $this->_var['lang']['btn_buy']; ?>";
					var is_cancel = "<?php echo $this->_var['lang']['is_cancel']; ?>";
					var select_spe = "<?php echo $this->_var['lang']['select_spe']; ?>";
			  	</script> 
              </div>
              <?php endif; ?> 
               
               
            <?php if ($this->_var['action'] == 'auction_list'): ?> 
            <?php echo $this->smarty_insert_scripts(array('files'=>'transport.js,utils.js')); ?>
            <div class="tabmenu">
              <ul class="tab pngFix">
                <li class="first active"><a>我的竞拍</a></li>
              </ul>
            </div>
            <div class="mar_top">
             <table width="100%" border="0" cellpadding="10" cellspacing="1" bgcolor="#E7E7E7">
             <?php if ($this->_var['prompt']): ?>
              <?php $_from = $this->_var['prompt']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
                  <tr>
                    <td align="left" bgcolor="#ffffff"><?php echo $this->_var['item']['text']; ?></td>
                  </tr>
                   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                   <?php else: ?>
                   <tr>
                    <td align="left" bgcolor="#ffffff">你还没有竞拍到任何商品！</td>
                  </tr> 
             <?php endif; ?>
             </table>
            </div>
            <?php endif; ?> 
             
               
              <?php if ($this->_var['action'] == 'booking_list'): ?>
              <div class="tabmenu">
                <ul class="tab pngFix">
                  <li class="first active"><a><?php echo $this->_var['lang']['label_booking']; ?></a></li>
                </ul>
              </div>
              <div class="mar_top">
                <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#E7E7E7">
                  <tr align="center">
                    <td width="25%" bgcolor="#ffffff"><?php echo $this->_var['lang']['booking_goods_name']; ?></td>
                    <td width="20%" bgcolor="#ffffff"><?php echo $this->_var['lang']['booking_store_name']; ?></td>
                    <td width="10%" bgcolor="#ffffff"><?php echo $this->_var['lang']['booking_amount']; ?></td>
                    <td width="15%" bgcolor="#ffffff"><?php echo $this->_var['lang']['booking_time']; ?></td>
                    <td width="20%" bgcolor="#ffffff"><?php echo $this->_var['lang']['process_desc']; ?></td>
                    <td width="10%" bgcolor="#ffffff"><?php echo $this->_var['lang']['handle']; ?></td>
                  </tr>
                  <?php $_from = $this->_var['booking_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
                  <tr>
                    <td align="left" bgcolor="#ffffff"><a href="<?php echo $this->_var['item']['url']; ?>" target="_blank" style="width:40px;height:40px;display:inline-block;float:left;padding:2px;border:1px #e4e4e4 solid"><img src="<?php echo $this->_var['item']['goods_thumb']; ?>" alt="" width="40" height="40" /></a> <a href="<?php echo $this->_var['item']['url']; ?>" target="_blank" class="f6" style="width:180px;height:40px;display:inline-block;float:left;margin-left:5px"><?php echo $this->_var['item']['goods_name']; ?></a></td>
                    <td align="center" bgcolor="#ffffff"><a href="<?php if ($this->_var['item']['supplier_id'] == 0): ?>index.php<?php else: ?>supplier.php?suppId=<?php echo $this->_var['item']['supplier_id']; ?><?php endif; ?>" target="_blank"><?php echo $this->_var['item']['supplier_name']; ?></a></td>
                    <td align="center" bgcolor="#ffffff"><?php echo $this->_var['item']['goods_number']; ?></td>
                    <td align="center" bgcolor="#ffffff"><?php echo $this->_var['item']['booking_time']; ?></td>
                    <td align="left" bgcolor="#ffffff"><?php echo $this->_var['item']['dispose_note']; ?></td>
                    <td align="center" bgcolor="#ffffff"><a href="javascript:if (confirm('<?php echo $this->_var['lang']['confirm_remove_account']; ?>')) location.href='user.php?act=act_del_booking&id=<?php echo $this->_var['item']['rec_id']; ?>'" class="f6"><?php echo $this->_var['lang']['drop']; ?></a></td>
                  </tr>
                  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </table>
              </div>
              <?php endif; ?> 
               
              <?php if ($this->_var['action'] == 'add_booking'): ?> 
              <?php echo $this->smarty_insert_scripts(array('files'=>'utils.js')); ?> 
              <script type="text/javascript">
    <?php $_from = $this->_var['lang']['booking_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
    var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </script>
              <div class="tabmenu">
                <ul class="tab pngFix">
                  <li class="first active"><a><?php echo $this->_var['lang']['add']; ?><?php echo $this->_var['lang']['label_booking']; ?></a></li>
                </ul>
              </div>
              <form action="user.php" method="post" name="formBooking" onsubmit="return addBooking();">
                <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#E7E7E7">
                  <tr>
                    <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['booking_goods_name']; ?></td>
                    <td bgcolor="#ffffff"><?php echo $this->_var['info']['goods_name']; ?></td>
                  </tr>
                  <tr>
                    <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['booking_amount']; ?>:</td>
                    <td bgcolor="#ffffff"><input name="number" type="text" value="<?php echo $this->_var['info']['goods_number']; ?>" class="inputBg" /></td>
                  </tr>
                  <tr>
                    <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['describe']; ?>:</td>
                    <td bgcolor="#ffffff"><textarea name="desc" cols="50" rows="5" wrap="virtual" class="B_blue"><?php echo htmlspecialchars($this->_var['info']['goods_desc']); ?></textarea></td>
                  </tr>
                  <tr>
                    <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['contact_username']; ?>:</td>
                    <td bgcolor="#ffffff"><input name="linkman" type="text" value="<?php echo htmlspecialchars($this->_var['info']['consignee']); ?>" size="25"  class="inputBg"/></td>
                  </tr>
                  <tr>
                    <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['email_address']; ?>:</td>
                    <td bgcolor="#ffffff"><input name="email" type="text" value="<?php echo htmlspecialchars($this->_var['info']['email']); ?>" size="25" class="inputBg" /></td>
                  </tr>
                  <tr>
                    <td align="right" bgcolor="#ffffff"><?php echo $this->_var['lang']['contact_phone']; ?>:</td>
                    <td bgcolor="#ffffff"><input name="tel" type="text" value="<?php echo htmlspecialchars($this->_var['info']['tel']); ?>" size="25" class="inputBg" /></td>
                  </tr>
                  <tr>
                    <td align="right" bgcolor="#ffffff">&nbsp;</td>
                    <td bgcolor="#ffffff"><input name="act" type="hidden" value="act_add_booking" />
                      <input name="id" type="hidden" value="<?php echo $this->_var['info']['id']; ?>" />
                      <input name="rec_id" type="hidden" value="<?php echo $this->_var['info']['rec_id']; ?>" />
                      <input type="submit" name="submit" class="submit" value="<?php echo $this->_var['lang']['submit_booking_goods']; ?>" />
                      <input type="reset" name="reset" class="reset" value="<?php echo $this->_var['lang']['button_reset']; ?>" /></td>
                  </tr>
                </table>
              </form>
              <?php endif; ?> 
               
              <?php if ($this->_var['affiliate']['on'] == 1): ?> 
              <?php if ($this->_var['action'] == 'affiliate'): ?> 
              <?php if (! $this->_var['goodsid'] || $this->_var['goodsid'] == 0): ?>
              <div class="tabmenu">
                <ul class="tab pngFix">
                  <li class="first active"><a>分成规则</a></li>
                </ul>
              </div>
              <div class="mar_top">
                <div class="box" style="border:solid 1px #E7E7E7;padding:10px"> <?php echo $this->_var['affiliate_intro']; ?> </div>
              </div>
              <?php if ($this->_var['affiliate']['config']['separate_by'] == 0): ?> 
              
              <div class="tabmenu">
                <ul class="tab pngFix">
                  <li class="first active"><a name="myrecommend"><?php echo $this->_var['lang']['affiliate_member']; ?></a></li>
                </ul>
              </div>
              <div class="mar_top">
                <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#E7E7E7">
                  <tr align="center">
                    <td bgcolor="#ffffff"><?php echo $this->_var['lang']['affiliate_lever']; ?></td>
                    <td bgcolor="#ffffff"><?php echo $this->_var['lang']['affiliate_num']; ?></td>
                    <td bgcolor="#ffffff"><?php echo $this->_var['lang']['level_point']; ?></td>
                    <td bgcolor="#ffffff"><?php echo $this->_var['lang']['level_money']; ?></td>
                  </tr>
                  <?php $_from = $this->_var['affdb']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('level', 'val');$this->_foreach['affdb'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['affdb']['total'] > 0):
    foreach ($_from AS $this->_var['level'] => $this->_var['val']):
        $this->_foreach['affdb']['iteration']++;
?>
                  <tr align="center">
                    <td bgcolor="#ffffff"><?php echo $this->_var['level']; ?></td>
                    <td bgcolor="#ffffff"><?php echo $this->_var['val']['num']; ?></td>
                    <td bgcolor="#ffffff"><?php echo $this->_var['val']['point']; ?></td>
                    <td bgcolor="#ffffff"><?php echo $this->_var['val']['money']; ?></td>
                  </tr>
                  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </table>
              </div>
               
              <?php else: ?> 
               
               
              <?php endif; ?> 
              
              <div class="tabmenu">
                <ul class="tab pngFix">
                  <li class="first active"><a>分成明细</a></li>
                </ul>
              </div>
              <div class="mar_top">
                <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#E7E7E7">
                  <tr align="center">
                    <td bgcolor="#ffffff"><?php echo $this->_var['lang']['order_number']; ?></td>
                    <td bgcolor="#ffffff"><?php echo $this->_var['lang']['affiliate_money']; ?></td>
                    <td bgcolor="#ffffff"><?php echo $this->_var['lang']['affiliate_point']; ?></td>
                    <td bgcolor="#ffffff"><?php echo $this->_var['lang']['affiliate_mode']; ?></td>
                    <td bgcolor="#ffffff"><?php echo $this->_var['lang']['affiliate_status']; ?></td>
                  </tr>
                  <?php $_from = $this->_var['logdb']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'val');$this->_foreach['logdb'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['logdb']['total'] > 0):
    foreach ($_from AS $this->_var['val']):
        $this->_foreach['logdb']['iteration']++;
?>
                  <tr align="center">
                    <td bgcolor="#ffffff"><?php echo $this->_var['val']['order_sn']; ?></td>
                    <td bgcolor="#ffffff"><?php echo $this->_var['val']['money']; ?></td>
                    <td bgcolor="#ffffff"><?php echo $this->_var['val']['point']; ?></td>
                    <td bgcolor="#ffffff"><?php if ($this->_var['val']['separate_type'] == 1 || $this->_var['val']['separate_type'] === 0): ?> 
                      <?php echo $this->_var['lang']['affiliate_type'][$this->_var['val']['separate_type']]; ?> 
                      <?php else: ?> 
                      <?php echo $this->_var['lang']['affiliate_type'][$this->_var['affiliate_type']]; ?> 
                      <?php endif; ?></td>
                    <td bgcolor="#ffffff"><?php echo $this->_var['lang']['affiliate_stats'][$this->_var['val']['is_separate']]; ?></td>
                  </tr>
                  <?php endforeach; else: ?>
                  <tr>
                    <td colspan="5" align="center" bgcolor="#ffffff"><?php echo $this->_var['lang']['no_records']; ?></td>
                  </tr>
                  <?php endif; unset($_from); ?><?php $this->pop_vars();; ?> 
                  <?php if ($this->_var['logdb']): ?>
                  <tr>
                    <td colspan="5" bgcolor="#ffffff"><form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
                        <div id="pager"> <?php echo $this->_var['lang']['pager_1']; ?><?php echo $this->_var['pager']['record_count']; ?><?php echo $this->_var['lang']['pager_2']; ?><?php echo $this->_var['lang']['pager_3']; ?><?php echo $this->_var['pager']['page_count']; ?><?php echo $this->_var['lang']['pager_4']; ?> <span> <a href="<?php echo $this->_var['pager']['page_first']; ?>"><?php echo $this->_var['lang']['page_first']; ?></a> <a href="<?php echo $this->_var['pager']['page_prev']; ?>"><?php echo $this->_var['lang']['page_prev']; ?></a> <a href="<?php echo $this->_var['pager']['page_next']; ?>"><?php echo $this->_var['lang']['page_next']; ?></a> <a href="<?php echo $this->_var['pager']['page_last']; ?>"><?php echo $this->_var['lang']['page_last']; ?></a> </span>
                          <select name="page" id="page" onchange="selectPage(this)">
                            
                  
    <?php echo $this->html_options(array('options'=>$this->_var['pager']['array'],'selected'=>$this->_var['pager']['page'])); ?>
    
                
                          </select>
                          <input type="hidden" name="act" value="affiliate" />
                        </div>
                      </form></td>
                  </tr>
                  <?php endif; ?>
                </table>
                <script type="text/javascript" language="JavaScript">
<!--

function selectPage(sel)
{
  sel.form.submit();
}

//-->
</script> 
              </div>
              
              <div class="tabmenu">
                <ul class="tab pngFix">
                  <li class="first active"><a><?php echo $this->_var['lang']['affiliate_code']; ?></a></li>
                </ul>
              </div>
              <div class="mar_top">
                <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#E7E7E7">
                  <tr>
                    <td width="30%" bgcolor="#ffffff"><a href="<?php echo $this->_var['shopurl']; ?>?u=<?php echo $this->_var['userid']; ?>" target="_blank" class="f6"><?php echo $this->_var['shopname']; ?></a></td>
                    <td bgcolor="#ffffff"><input size="40" onclick="this.select();" type="text" value="&lt;a href=&quot;<?php echo $this->_var['shopurl']; ?>?u=<?php echo $this->_var['userid']; ?>&quot; target=&quot;_blank&quot;&gt;<?php echo $this->_var['shopname']; ?>&lt;/a&gt;" style="border:1px solid #ccc;" />
                      <?php echo $this->_var['lang']['recommend_webcode']; ?></td>
                  </tr>
                  <tr>
                    <td bgcolor="#ffffff"><a href="<?php echo $this->_var['shopurl']; ?>?u=<?php echo $this->_var['userid']; ?>" target="_blank" title="<?php echo $this->_var['shopname']; ?>"  class="f6"><img src="<?php echo $this->_var['shopurl']; ?><?php echo $this->_var['logosrc']; ?>" /></a></td>
                    <td bgcolor="#ffffff"><input size="40" onclick="this.select();" type="text" value="&lt;a href=&quot;<?php echo $this->_var['shopurl']; ?>?u=<?php echo $this->_var['userid']; ?>&quot; target=&quot;_blank&quot; title=&quot;<?php echo $this->_var['shopname']; ?>&quot;&gt;&lt;img src=&quot;<?php echo $this->_var['shopurl']; ?><?php echo $this->_var['logosrc']; ?>&quot; /&gt;&lt;/a&gt;" style="border:1px solid #ccc;" />
                      <?php echo $this->_var['lang']['recommend_webcode']; ?></td>
                  </tr>
                  <tr>
                    <td bgcolor="#ffffff"><a href="<?php echo $this->_var['shopurl']; ?>?u=<?php echo $this->_var['userid']; ?>" target="_blank" class="f6"><?php echo $this->_var['shopname']; ?></a></td>
                    <td bgcolor="#ffffff"><input size="40" onclick="this.select();" type="text" value="[url=<?php echo $this->_var['shopurl']; ?>?u=<?php echo $this->_var['userid']; ?>]<?php echo $this->_var['shopname']; ?>[/url]" style="border:1px solid #ccc;" />
                      <?php echo $this->_var['lang']['recommend_bbscode']; ?></td>
                  </tr>
                  <tr>
                    <td bgcolor="#ffffff"><a href="<?php echo $this->_var['shopurl']; ?>?u=<?php echo $this->_var['userid']; ?>" target="_blank" title="<?php echo $this->_var['shopname']; ?>" class="f6"><img src="<?php echo $this->_var['shopurl']; ?><?php echo $this->_var['logosrc']; ?>" /></a></td>
                    <td bgcolor="#ffffff"><input size="40" onclick="this.select();" type="text" value="[url=<?php echo $this->_var['shopurl']; ?>?u=<?php echo $this->_var['userid']; ?>][img]<?php echo $this->_var['shopurl']; ?><?php echo $this->_var['logosrc']; ?>[/img][/url]" style="border:1px solid #ccc;" />
                      <?php echo $this->_var['lang']['recommend_bbscode']; ?></td>
                  </tr>
                  
                  <tr>
                    <td  bgcolor="#ffffff">分享到</td>
                    <td  bgcolor="#ffffff"><img src="erweima_png.php?data=<?php echo $this->_var['shopurl']; ?>mobile/?u=<?php echo $this->_var['userid']; ?>" width=150 height=150>
                      <div class="bdsharebuttonbox" data-tag="share_1"> <a class="bds_mshare" data-cmd="mshare"></a> <a class="bds_qzone" data-cmd="qzone" href="#"></a> <a class="bds_tsina" data-cmd="tsina"></a> <a class="bds_baidu" data-cmd="baidu"></a> <a class="bds_renren" data-cmd="renren"></a> <a class="bds_tqq" data-cmd="tqq"></a> <a class="bds_more" data-cmd="more">更多</a> <a class="bds_count" data-cmd="count"></a> </div>
                      <script>
	window._bd_share_config = {
		common : {
			bdText : '<?php echo $this->_var['page_title']; ?>',	
			bdDesc : '<?php echo $this->_var['page_title']; ?>',	
			bdUrl : '<?php echo $this->_var['shopurl']; ?>?u=<?php echo $this->_var['userid']; ?>', 	
			bdPic : '<?php echo $this->_var['shopurl']; ?>erweima_png.php?data=<?php echo $this->_var['shopurl']; ?>mobile/?u=<?php echo $this->_var['userid']; ?>'
		},
		share : [{
			"bdSize" : 16
		}],
		slide : [{	   
			bdImg : 0,
			bdPos : "right",
			bdTop : 100
		}],
		image : [{
			viewType : 'list',
			viewPos : 'top',
			viewColor : 'black',
			viewSize : '16',
			viewList : ['qzone','tsina','huaban','tqq','renren']
		}],
		selectShare : [{
			"bdselectMiniList" : ['qzone','tqq','kaixin001','bdxc','tqf']
		}]
	}
	with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?cdnversion='+~(-new Date()/36e5)];
</script></td>
                  </tr>
                  
                  
                </table>
              </div>
              <?php else: ?> 
              
              <style type="text/css">
        .types a{text-decoration:none; color:#006bd0;}
      </style>
              <div class="tabmenu">
                <ul class="tab pngFix">
                  <li class="first active"><a><?php echo $this->_var['lang']['affiliate_code']; ?></a></li>
                </ul>
              </div>
              <div class="mar_top">
                <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#E7E7E7">
                  <tr align="center">
                    <td bgcolor="#ffffff"><?php echo $this->_var['lang']['affiliate_view']; ?></td>
                    <td bgcolor="#ffffff"><?php echo $this->_var['lang']['affiliate_code']; ?></td>
                  </tr>
                  <?php $_from = $this->_var['types']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'val');$this->_foreach['types'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['types']['total'] > 0):
    foreach ($_from AS $this->_var['val']):
        $this->_foreach['types']['iteration']++;
?>
                  <tr align="center">
                    <td bgcolor="#ffffff" class="types"><script src="<?php echo $this->_var['shopurl']; ?>affiliate.php?charset=<?php echo $this->_var['ecs_charset']; ?>&gid=<?php echo $this->_var['goodsid']; ?>&u=<?php echo $this->_var['userid']; ?>&type=<?php echo $this->_var['val']; ?>"></script></td>
                    <td bgcolor="#ffffff">javascript <?php echo $this->_var['lang']['affiliate_codetype']; ?><br>
                      <textarea cols=30 rows=2 id="txt<?php echo $this->_foreach['types']['iteration']; ?>" style="border:1px solid #ccc;"><script src="<?php echo $this->_var['shopurl']; ?>affiliate.php?charset=<?php echo $this->_var['ecs_charset']; ?>&gid=<?php echo $this->_var['goodsid']; ?>&u=<?php echo $this->_var['userid']; ?>&type=<?php echo $this->_var['val']; ?>"></script>
</textarea>
                      [<a href="#" title="Copy To Clipboard" onClick="Javascript:copyToClipboard(document.getElementById('txt<?php echo $this->_foreach['types']['iteration']; ?>').value);alert('<?php echo $this->_var['lang']['copy_to_clipboard']; ?>');"  class="f6"><?php echo $this->_var['lang']['code_copy']; ?></a>] <br>
                      iframe <?php echo $this->_var['lang']['affiliate_codetype']; ?><br>
                      <textarea cols=30 rows=2 id="txt<?php echo $this->_foreach['types']['iteration']; ?>_iframe"  style="border:1px solid #ccc;"><iframe width="250" height="270" src="<?php echo $this->_var['shopurl']; ?>affiliate.php?charset=<?php echo $this->_var['ecs_charset']; ?>&gid=<?php echo $this->_var['goodsid']; ?>&u=<?php echo $this->_var['userid']; ?>&type=<?php echo $this->_var['val']; ?>&display_mode=iframe" frameborder="0" scrolling="no"></iframe>
</textarea>
                      [<a href="#" title="Copy To Clipboard" onClick="Javascript:copyToClipboard(document.getElementById('txt<?php echo $this->_foreach['types']['iteration']; ?>_iframe').value);alert('<?php echo $this->_var['lang']['copy_to_clipboard']; ?>');" class="f6"><?php echo $this->_var['lang']['code_copy']; ?></a>] <br />
                      <?php echo $this->_var['lang']['bbs']; ?>UBB <?php echo $this->_var['lang']['affiliate_codetype']; ?><br />
                      <textarea cols=30 rows=2 id="txt<?php echo $this->_foreach['types']['iteration']; ?>_ubb"  style="border:1px solid #ccc;"><?php if ($this->_var['val'] != 5): ?>[url=<?php echo $this->_var['shopurl']; ?>goods.php?id=<?php echo $this->_var['goodsid']; ?>&u=<?php echo $this->_var['userid']; ?>][img]<?php if ($this->_var['val'] < 3): ?><?php echo $this->_var['goods']['goods_thumb']; ?><?php else: ?><?php echo $this->_var['goods']['goods_img']; ?><?php endif; ?>[/img][/url]<?php endif; ?>

[url=<?php echo $this->_var['shopurl']; ?>goods.php?id=<?php echo $this->_var['goodsid']; ?>&u=<?php echo $this->_var['userid']; ?>][b]<?php echo $this->_var['goods']['goods_name']; ?>[/b][/url]
<?php if ($this->_var['val'] != 1 && $this->_var['val'] != 3): ?>[s]<?php echo $this->_var['goods']['market_price']; ?>[/s]<?php endif; ?> [color=red]<?php echo $this->_var['goods']['shop_price']; ?>[/color]</textarea>
                      [<a href="#" title="Copy To Clipboard" onClick="Javascript:copyToClipboard(document.getElementById('txt<?php echo $this->_foreach['types']['iteration']; ?>_ubb').value);alert('<?php echo $this->_var['lang']['copy_to_clipboard']; ?>');"  class="f6"><?php echo $this->_var['lang']['code_copy']; ?></a>]
                      <?php if ($this->_var['val'] == 5): ?><br />
                      <?php echo $this->_var['lang']['im_code']; ?> <?php echo $this->_var['lang']['affiliate_codetype']; ?><br />
                      <textarea cols=30 rows=2 id="txt<?php echo $this->_foreach['types']['iteration']; ?>_txt"  style="border:1px solid #ccc;"><?php echo $this->_var['lang']['show_good_to_you']; ?> <?php echo $this->_var['goods']['goods_name']; ?>

<?php echo $this->_var['shopurl']; ?>goods.php?id=<?php echo $this->_var['goodsid']; ?>&u=<?php echo $this->_var['userid']; ?> </textarea>
                      [<a href="#" title="Copy To Clipboard" onClick="Javascript:copyToClipboard(document.getElementById('txt<?php echo $this->_foreach['types']['iteration']; ?>_txt').value);alert('<?php echo $this->_var['lang']['copy_to_clipboard']; ?>');"  class="f6"><?php echo $this->_var['lang']['code_copy']; ?></a>]<?php endif; ?></td>
                  </tr>
                  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </table>
                <script language="Javascript">
copyToClipboard = function(txt)
{
 if(window.clipboardData)
 {
    window.clipboardData.clearData();
    window.clipboardData.setData("Text", txt);
 }
 else if(navigator.userAgent.indexOf("Opera") != -1)
 {
   //暂时无方法:-(
 }
 else if (window.netscape)
 {
  try
  {
    netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
  }
  catch (e)
  {
    alert("<?php echo $this->_var['lang']['firefox_copy_alert']; ?>");
    return false;
  }
  var clip = Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard);
  if (!clip)
    return;
  var trans = Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable);
  if (!trans)
    return;
  trans.addDataFlavor('text/unicode');
  var str = new Object();
  var len = new Object();
  var str = Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString);
  var copytext = txt;
  str.data = copytext;
  trans.setTransferData("text/unicode",str,copytext.length*2);
  var clipid = Components.interfaces.nsIClipboard;
  if (!clip)
  return false;
  clip.setData(trans,null,clipid.kGlobalClipboard);
 }
}
                </script> 
              </div>
               
            </div>
            <?php endif; ?> 
            <?php endif; ?> 
            <?php endif; ?> 
             
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div style="height:10px; line-height:10px; clear:both;"></div>
<div class="blank"></div>
</div>
  <?php echo $this->fetch('library/arrive_notice_list.lbi'); ?>
<?php echo $this->fetch('library/help.lbi'); ?> 
<?php echo $this->fetch('library/page_footer.lbi'); ?>
<?php echo $this->fetch('library/site_bar.lbi'); ?>
</body>
<script type="text/javascript">
<?php $_from = $this->_var['lang']['clips_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</script>
</html>
