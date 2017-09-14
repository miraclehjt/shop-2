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
<link rel="stylesheet" type="text/css" href="themesmobile/68ecshopcom_mobile/css/user.css"/> 
<link rel="stylesheet" type="text/css" href="themesmobile/68ecshopcom_mobile/css/public.css"/>
<script src="themesmobile/68ecshopcom_mobile/js/modernizr.js"></script>
<script type="text/javascript" src="themesmobile/68ecshopcom_mobile/js/jquery.js"></script>
<?php echo $this->smarty_insert_scripts(array('files'=>'jquery.json.js,transport.js')); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'common.js,utils.js')); ?>
</head>
<body>
      
      <?php if ($this->_var['action'] != 'default'): ?>
      <header>
      <div class="tab_nav">
        <div class="header">
          <div class="h-left"><a class="sb-back" href="javascript:history.back(-1)" title="返回"></a></div>
          <div class="h-mid"><?php if ($this->_var['action'] == 'default'): ?>用户中心 <?php elseif ($this->_var['action'] == 'affiliate'): ?>我的推荐<?php elseif ($this->_var['action'] == 'collection_list' || $this->_var['action'] == '' || $this->_var['action'] == 'booking_list'): ?>我的收藏<?php elseif ($this->_var['action'] == 'message_list'): ?>我的留言<?php elseif ($this->_var['action'] == 'my_comment'): ?>我的评价<?php endif; ?></div>
          <div class="h-right">
            <aside class="top_bar">
              <div onClick="show_menu();$('#close_btn').addClass('hid');" id="show_more"><a href="javascript:;"></a> </div>
            </aside>
          </div>
        </div>
      </div>
      </header>
       	<?php echo $this->fetch('library/up_menu.lbi'); ?> 
        <?php endif; ?>
<div id="tbh5v0">
<?php if ($this->_var['action'] == 'default'): ?>
<?php echo $this->fetch('library/user_nav.lbi'); ?>
<?php endif; ?>
<script type="text/javascript">
				/*第一种形式 第二种形式 更换显示样式*/
				function setGoodsTab(name,cursel,n){
					$('html,body').animate({'scrollTop':0},600);
				for(i=1;i<=n;i++){
				var menu=document.getElementById(name+i);
				var con=document.getElementById("user_"+name+"_"+i);
				menu.className=i==cursel?"on":"";
				con.style.display=i==cursel?"block":"none";
				}
				}
				</script>
<link href="themesmobile/68ecshopcom_mobile/css/photoswipe.css" rel="stylesheet" type="text/css">
<script src="themesmobile/68ecshopcom_mobile/js/klass.min.js"></script>
<script src="themesmobile/68ecshopcom_mobile/js/photoswipe.js"></script>
<script src="themesmobile/68ecshopcom_mobile/js/custom.js"></script>
<div class="order">
      
      <div class="Evaluation">
            <ul>
            <li><a href="javascript:;" class="tab_head on"   id="goods_ka1" onClick="setGoodsTab('goods_ka',1,3)">全部评价</a></li>
              <li><a href="javascript:;" class="tab_head" id="goods_ka2" onClick="setGoodsTab('goods_ka',2,3)">待评价</a></li>
              <li><a href="javascript:;" class="tab_head" id="goods_ka3" onClick="setGoodsTab('goods_ka',3,3)">已评价</a></li>
              
            </ul>
      </div>
      
      <div class="Emain" id="user_goods_ka_1" style="display:block;">
 <?php $_from = $this->_var['item_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'value');if (count($_from)):
    foreach ($_from AS $this->_var['value']):
?> 
    <div class="pingjia">
           <h2>成交时间：<?php echo $this->_var['value']['add_time_str']; ?></h2>
           <dl>
           <dt><img src="./../<?php echo $this->_var['value']['thumb']; ?>"></dt>
           <dd><span><?php echo $this->_var['value']['goods_name']; ?></span><strong>￥<?php echo $this->_var['value']['shop_price']; ?></strong></dd>
           </dl>
 <?php if ($this->_var['value']['comment_status']): ?>
 <div class="pj_main">
       <ul>
       <li><em>评价：</em><img src="themesmobile/68ecshopcom_mobile/images/stars<?php echo $this->_var['value']['comment']['comment_rank']; ?>.png"></li>
       <li class="pj_w"><?php echo $this->_var['value']['comment']['content']; ?></li>
       </ul>


<?php if ($this->_var['value']['shaidan_status']): ?>
       <ul>
       <li><em>晒单：<?php echo $this->_var['value']['comment']['shaidan']['title']; ?></em></li>
       <li class="pj_w"><?php echo $this->_var['value']['comment']['shaidan']['message']; ?></li>
       </ul>
       <div class="sd_img">
        <dl id="gallery">
            
<?php $_from = $this->_var['value']['comment']['shaidan_img']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'shaidan_img');if (count($_from)):
    foreach ($_from AS $this->_var['shaidan_img']):
?>
       <dd><a href="./../<?php echo $this->_var['shaidan_img']['image']; ?>">
               <img src="./../<?php echo $this->_var['shaidan_img']['thumb']; ?>" width="100px" heigth="100px">
            </a></dd>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 
        </dl>
       </div>
<?php endif; ?>

<?php if ($this->_var['value']['comment']['comment_reps']): ?>
<?php $_from = $this->_var['value']['comment']['comment_reps']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'val');if (count($_from)):
    foreach ($_from AS $this->_var['val']):
?>
       <ul style="border-top:1px dashed #e5e5e5; padding-top:8px; margin-top:10px">
       <li><em style=" color:#F60">管理员<?php echo $this->_var['val']['user_name']; ?>回复：</em></li>
       <li class="pj_w" style=" color:#F60; font-size:12px;"><?php echo $this->_var['val']['content']; ?></li>
       </ul>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
<?php endif; ?>
       </div>
 <?php endif; ?>
 <div class="pj_zhuangtai">
          <?php if ($this->_var['value']['comment_status'] == 0): ?><?php if ($this->_var['value']['comment']['comment_id']): ?>评价审核中<?php else: ?><?php if ($this->_var['value']['shipping_time_end'] > $this->_var['min_time']): ?> <a href="user.php?act=comment_order&rec_id=<?php echo $this->_var['value']['rec_id']; ?>&goods_id=<?php echo $this->_var['value']['goods_id']; ?>">评价订单</a><?php else: ?>超期不能评价<?php endif; ?><?php endif; ?><?php endif; ?>
          <?php if ($this->_var['value']['shaidan_status'] == 0): ?><?php if ($this->_var['value']['shaidan_id']): ?>晒单审核中<?php else: ?><?php if ($this->_var['value']['shipping_time_end'] > $this->_var['min_time']): ?> <a href="user.php?act=shaidan_send&id=<?php echo $this->_var['value']['rec_id']; ?>">发表晒单</a><?php else: ?>超期不能晒单<?php endif; ?><?php endif; ?><?php endif; ?>
           </div>

    </div>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>  
      </div>      
      
      <div class="Emain" id="user_goods_ka_2" style="display:none">
<?php $_from = $this->_var['item_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'value');if (count($_from)):
    foreach ($_from AS $this->_var['value']):
?> 
 <?php if ($this->_var['value']['comment_status'] == 0 || $this->_var['value']['shaidan_status'] == 0): ?>
<?php if ($this->_var['value']['shipping_time_end'] > $this->_var['min_time']): ?>
<div class="pingjia">
       <h2>成交时间：<?php echo $this->_var['value']['add_time_str']; ?></h2>
       <dl>
       <dt><img src="./../<?php echo $this->_var['value']['thumb']; ?>"></dt>
       <dd><span><?php echo $this->_var['value']['goods_name']; ?></span><strong>￥<?php echo $this->_var['value']['shop_price']; ?></strong></dd>
       </dl>
       <?php if ($this->_var['value']['comment_status']): ?>
       <div class="pj_main">

       <ul>
       <li><em>评价：</em><img src="themesmobile/68ecshopcom_mobile/images/stars<?php echo $this->_var['value']['comment']['comment_rank']; ?>.png"></li>
       <li class="pj_w"><?php echo $this->_var['value']['comment']['content']; ?></li>
       </ul>

<?php if ($this->_var['value']['shaidan_status']): ?>
       <ul>
       <li><em>晒单：<?php echo $this->_var['value']['comment']['shaidan']['title']; ?></em></li>
       <li class="pj_w"><?php echo $this->_var['value']['comment']['shaidan']['message']; ?></li>
       </ul>
       <div class="sd_img">
        <dl id="gallery">
            
<?php $_from = $this->_var['value']['comment']['shaidan_img']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'shaidan_img');if (count($_from)):
    foreach ($_from AS $this->_var['shaidan_img']):
?>
       <dd><a href="./../<?php echo $this->_var['shaidan_img']['image']; ?>">
               <img src="./../<?php echo $this->_var['shaidan_img']['thumb']; ?>" width="100px" heigth="100px">
            </a></dd>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 
        </dl>
       </div>
<?php endif; ?>
       </div>
       <?php endif; ?>
       <div class="pj_zhuangtai">
          <?php if ($this->_var['value']['comment_status'] == 0): ?><?php if ($this->_var['value']['comment']['comment_id']): ?>评价审核中<?php else: ?><?php if ($this->_var['value']['shipping_time_end'] > $this->_var['min_time']): ?> <a href="user.php?act=comment_order&rec_id=<?php echo $this->_var['value']['rec_id']; ?>&goods_id=<?php echo $this->_var['value']['goods_id']; ?>">评价订单</a><?php else: ?>超期不能评价<?php endif; ?><?php endif; ?><?php endif; ?>
          <?php if ($this->_var['value']['shaidan_status'] == 0): ?><?php if ($this->_var['value']['shaidan_id']): ?>晒单审核中<?php else: ?><?php if ($this->_var['value']['shipping_time_end'] > $this->_var['min_time']): ?> <a href="user.php?act=shaidan_send&id=<?php echo $this->_var['value']['rec_id']; ?>">发表晒单</a><?php else: ?>超期不能晒单<?php endif; ?><?php endif; ?><?php endif; ?>
       </div>
       </div>
<?php endif; ?><?php endif; ?>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      </div> 
      
      <div class="Emain" id="user_goods_ka_3" style="display:none;">
 <?php $_from = $this->_var['item_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'value');if (count($_from)):
    foreach ($_from AS $this->_var['value']):
?> 
 <?php if ($this->_var['value']['comment_state'] > 0): ?>
    <div class="pingjia">
           <h2>成交时间：<?php echo $this->_var['value']['add_time_str']; ?></h2>
           <dl>
           <dt><img src="./../<?php echo $this->_var['value']['thumb']; ?>"></dt>
           <dd><span><?php echo $this->_var['value']['goods_name']; ?></span><strong>￥<?php echo $this->_var['value']['shop_price']; ?></strong></dd>
           </dl>
<?php if ($this->_var['value']['comment']): ?>
       <div class="pj_main">
       <ul>
       <li><em>评价：</em><img src="themesmobile/68ecshopcom_mobile/images/stars<?php echo $this->_var['value']['comment']['comment_rank']; ?>.png"></li>
       <li class="pj_w"><?php echo $this->_var['value']['comment']['content']; ?></li>
       </ul>

<?php if ($this->_var['value']['shaidan_id']): ?>
       <ul>
       <li><em>晒单：<?php echo $this->_var['value']['comment']['shaidan']['title']; ?></em></li>
       <li class="pj_w"><?php echo $this->_var['value']['comment']['shaidan']['message']; ?></li>
       </ul>
       <div class="sd_img">
        <dl id="gallery">
            
<?php $_from = $this->_var['value']['comment']['shaidan_img']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'shaidan_img');if (count($_from)):
    foreach ($_from AS $this->_var['shaidan_img']):
?>
       <dd><a href="./../<?php echo $this->_var['shaidan_img']['image']; ?>">
               <img src="./../<?php echo $this->_var['shaidan_img']['thumb']; ?>" width="100px" heigth="100px">
            </a></dd>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
 
        </dl>
       </div>
<?php endif; ?>

<?php if ($this->_var['value']['comment']['comment_reps']): ?>
<?php $_from = $this->_var['value']['comment']['comment_reps']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'val');if (count($_from)):
    foreach ($_from AS $this->_var['val']):
?>
       <ul style="border-top:1px dashed #e5e5e5; padding-top:8px; margin-top:10px">
       <li><em style=" color:#F60">管理员<?php echo $this->_var['val']['user_name']; ?>回复：</em></li>
       <li class="pj_w" style=" color:#F60; font-size:12px;"><?php echo $this->_var['val']['content']; ?></li>
       </ul>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
<?php endif; ?>
       </div>
<?php endif; ?>
    </div>
<?php endif; ?>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      </div>
      
    </div>


<script>
function goTop(){
	$('html,body').animate({'scrollTop':0},600);
}
</script>
<a href="javascript:goTop();" class="gotop"><img src="themesmobile/68ecshopcom_mobile/images/topup.png"></a>














<!--原我的评价内容
<div class="has_tab_box">
<div class="tab_wrapper">
	<p class="tabs">
		<a href="user.php?act=message_list" id="tab_message_list"><span><?php echo $this->_var['lang']['label_message']; ?></span></a>
		<a href="user.php?act=comment_list" id="tab_comment_list" class="current"><span><?php echo $this->_var['lang']['label_comment']; ?></span></a>
</p>
<div class="extra"></div>
</div>
<div class="box">
	<div class="hd"><h3><?php echo $this->_var['lang']['label_comment']; ?></h3><div class="extra"></div></div>
	<div class="bd">
		<ul class="comment_list clearfix">
			<?php $_from = $this->_var['comment_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'comment');$this->_foreach['comment_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['comment_list']['total'] > 0):
    foreach ($_from AS $this->_var['comment']):
        $this->_foreach['comment_list']['iteration']++;
?>
			<li class="<?php echo $this->cycle(array('values'=>'odd,even')); ?><?php if (($this->_foreach['comment_list']['iteration'] <= 1)): ?> first<?php endif; ?>">
				<div class="info">
					<span class="name"><?php echo $this->_var['comment']['formated_add_time']; ?></span>
					<a href="user.php?act=del_cmt&amp;id=<?php echo $this->_var['comment']['comment_id']; ?>" title="<?php echo $this->_var['lang']['drop']; ?>" onclick="if (!confirm('<?php echo $this->_var['lang']['confirm_remove_msg']; ?>')) return false;" class="drop"><?php echo $this->_var['lang']['drop']; ?></a>
				</div>
				<div class="talk">
					<p class="title"><span class="type">[<?php if ($this->_var['comment']['comment_type'] == '0'): ?><?php echo $this->_var['lang']['goods_comment']; ?><?php else: ?><?php echo $this->_var['lang']['article_comment']; ?><?php endif; ?>]</span><?php echo $this->_var['comment']['cmt_name']; ?></p>
					<p class="text"><?php echo htmlspecialchars($this->_var['comment']['content']); ?></p>
					<?php if ($this->_var['comment']['reply_content']): ?>
					<blockquote class="reply"><span class="name"><?php echo $this->_var['lang']['re_name']; ?></span><span class="text"><?php echo $this->_var['comment']['reply_content']; ?></span><span class="time"><?php echo $this->_var['message']['re_msg_time']; ?></span></blockquote>
					<?php endif; ?>
				</div>
			</li>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		</ul>
		<?php if (! $this->_var['comment_list']): ?><p class="empty"><?php echo $this->_var['lang']['no_comments']; ?></p><?php endif; ?>
		<?php if ($this->_var['comment_list']): ?><?php echo $this->fetch('library/pages.lbi'); ?><?php endif; ?>
	</div>
</div>
</div>
-->
<?php echo $this->fetch('library/page_footer.lbi'); ?>
<?php echo $this->fetch('library/footer_nav.lbi'); ?>
</div>

<script language="javascript">
$(function(){ 
$('input[type=text],input[type=password]').bind({ 
focus:function(){ 
 $(".global-nav").css("display",'none'); 
}, 
blur:function(){ 
 $(".global-nav").css("display",'flex'); 
} 
}); 
}) 
</script>
</body>
</html>