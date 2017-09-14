<div class="navList">
      <div class="func func1 clearfix">
        <p class="title"><i></i><span>会员中心</span></p>
        <a href="user.php" class="item <?php if ($this->_var['action'] == 'default'): ?>curs<?php endif; ?>"><span><?php echo $this->_var['lang']['label_welcome']; ?></span><i></i></a> 
        <a href="user.php?act=profile" class="item <?php if ($this->_var['action'] == 'profile'): ?>curs<?php endif; ?>"><span><?php echo $this->_var['lang']['label_profile']; ?></span><i></i></a>
        <!-- 
        <a href="user.php?act=account_security" class="item <?php if ($this->_var['action'] == 'account_security'): ?>curs<?php endif; ?>"><span>账户安全</span><i></i></a>    
         -->
        <a href="security.php" class="item <?php if ($this->_var['is_security'] == 'true'): ?>curs<?php endif; ?>"><span>账户安全</span><i></i></a>    
        <a href="user.php?act=address_list" class="item <?php if ($this->_var['action'] == 'address_list'): ?>curs<?php endif; ?>"><span><?php echo $this->_var['lang']['label_address']; ?></span><i></i></a>
        <a href="user.php?act=account_log" class="item <?php if ($this->_var['action'] == 'account_log'): ?>curs<?php endif; ?>"><span><?php echo $this->_var['lang']['label_user_surplus']; ?></span><i></i></a>
        <a href="user.php?act=bonus" class="item <?php if ($this->_var['action'] == 'bonus'): ?>curs<?php endif; ?>"><span><?php echo $this->_var['lang']['label_bonus']; ?></span><i></i></a>
        <?php if ($this->_var['show_transform_points']): ?> 
        <a href="user.php?act=transform_points" class="item <?php if ($this->_var['action'] == 'transform_points'): ?>curs<?php endif; ?>"><span><?php echo $this->_var['lang']['label_transform_points']; ?></span><i></i></a>
        <?php endif; ?> 
	
	<a href="user.php?act=vc_login" class="item <?php if ($this->_var['action'] == 'vc_login'): ?>curs<?php endif; ?>">储值卡充值</a>
	
      </div>
      <div class="func func2 clearfix">
        <p class="title"><i></i><span>交易中心</span></p>
        <a href="user.php?act=order_list" class="item <?php if ($this->_var['action'] == 'order_list' || $this->_var['action'] == 'order_detail'): ?>curs<?php endif; ?>" ><span><?php echo $this->_var['lang']['label_order']; ?></span><i></i></a> 
        <a href="user.php?act=back_list" class="item <?php if ($this->_var['action'] == 'back_list' || $this->_var['action'] == 'back_order_detail'): ?>curs<?php endif; ?>"><span>退款/退货及维修</span><i></i></a> 
        <a href="user.php?act=my_comment" class="item <?php if ($this->_var['action'] == 'my_comment'): ?>curs<?php endif; ?>"><span>商品评价/晒单</span><i></i></a> 
        <a href="user.php?act=collection_list" class="item <?php if ($this->_var['action'] == 'collection_list'): ?>curs<?php endif; ?>"><span>商品收藏</span><i></i></a> 
        <a href="user.php?act=follow_shop" class="item <?php if ($this->_var['action'] == 'follow_shop'): ?>curs<?php endif; ?>" title="关注的店铺"><span>店铺关注</span><i></i></a> 
        <a href="user.php?act=auction_list" class="item <?php if ($this->_var['action'] == 'auction_list'): ?>curs<?php endif; ?>"><span>我的竞拍</span><i></i></a> 
        <a href="user.php?act=tg_login" class="item <?php if ($this->_var['action'] == 'tg_login'): ?>curs<?php endif; ?>"><span><?php echo $this->_var['lang']['takegoods']; ?></span><i></i></a> 
        <a href="user.php?act=tg_order" class="item <?php if ($this->_var['action'] == 'tg_order'): ?>curs<?php endif; ?>"><span><?php echo $this->_var['lang']['takegoods_order']; ?></span><i></i></a>
      </div>
      <div class="func func3 clearfix">
        <p class="title"><i></i><span>服务中心</span></p>
        <a href="user.php?act=booking_list" class="item <?php if ($this->_var['action'] == 'booking_list'): ?>curs<?php endif; ?>"><span><?php echo $this->_var['lang']['label_booking']; ?></span><i></i></a> 
        <a href="user.php?act=message_list" class="item <?php if ($this->_var['action'] == 'message_list'): ?>curs<?php endif; ?>"><span><?php echo $this->_var['lang']['label_message']; ?></span><i></i></a> 
        <a href="user.php?act=tag_list" class="item <?php if ($this->_var['action'] == 'tag_list'): ?>curs<?php endif; ?>" style="display:none"><span><?php echo $this->_var['lang']['label_tag']; ?></span><i></i></a>
       	
      	<?php if ($this->_var['recomm'] == 1): ?>
        <?php if ($this->_var['affiliate']['on'] == 1): ?>
        <a href="user.php?act=affiliate" class="item <?php if ($this->_var['action'] == 'affiliate'): ?>curs<?php endif; ?>"><span><?php echo $this->_var['lang']['label_affiliate']; ?></span><i></i></a>
        <?php endif; ?> 
       	<?php endif; ?> 
	
        <a href="apply_index.php" class="item"><span>我要开店</span><i></i></a>
    </div>
</div>