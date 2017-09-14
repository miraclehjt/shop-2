<div class="cover_div uhide" id="cover_div"></div>
<div class="uh ub bc-head-glist maxh head-h">
  <div class="nav-btn2 _back" id='back_button'>
    <div class="ub-img icon-back1"></div>
  </div>
  <div class="ub-f1 ub ub-ac uc-a1 bg-color uinn-ele2 m-t-b1">
    <div class="uwh-ele1 ub-img ele-search"></div>
    <div class="ub-f1 s-input1">
	<form action="" onsubmit="return false;">
      <input type="search" class="ulev-9" placeholder="搜索店铺内商品" id='search_input'/>
	  </form>
    </div>
  </div>
  <div class="nav-btn2" id='nav-right'>
    <div class="ub-img top-more"></div>
    <div class='uhide' id='pop_menu1'>
      <div id='small_angel1'></div>
      <ul>
        <li class='_to_index' id='select_index'>首页</li>
        <li class='_to_cat' id='select_cty'>分类</li>
        <li class='_to_cart' id='select_cart'>购物车</li>
        <li class='_to_user' id='select_user'>用户中心</li>
      </ul>
    </div>
  </div>
</div>
<div class="t-bla">
  <div class="shop-bg ub ub-ae">
    <div class="ub ub-f1 ub-ac">
      <div class="ub ub-f1 ub-ac">
        <div class="goods-img uba border-faxian"><img src="<?php echo $this->_var['url']; ?><?php echo $this->_var['shoplogo']; ?>" style=" width:6em; height:2.6em;"/></div>
        <div class="ulev0 bc-text-head m-l1"><?php echo $this->_var['shopname']; ?></div>
      </div>
      <div class="uwh-per3 ulev-1 ub-pe <?php if ($this->_var['is_followed'] > 0): ?>followed<?php endif; ?>" supplier_id="<?php echo $this->_var['suppinfo']['supplier_id']; ?>" id='follow_button'><?php if ($this->_var['is_followed'] > 0): ?>取消关注<?php else: ?>+加关注<?php endif; ?></div>
    </div>
  </div>
  <div class="ub bg-color-w p-t-b6 f-color-6 ubb border-hui">
    <div class="ub ub-ver ub-ac ub-f1 ubr border-faxian" id='all_goods_button'>
      <div class="ulev-9"> <?php echo $this->_var['goodsnum']; ?> </div>
      <div class="ulev-1 m-top1"> 全部宝贝 </div>
    </div>
    <div class="ub ub-ver ub-ac ub-f1 ubr border-faxian">
      <div class="ulev-9"> <?php if ($this->_var['c_rank'] > 0): ?><?php echo $this->_var['c_rank']; ?><?php else: ?>5<?php endif; ?> </div>
      <div class="ulev-1 m-top1"> 描述 </div>
    </div>
    <div class="ub ub-ver ub-ac ub-f1 ubr border-faxian">
      <div class="ulev-9"> <?php if ($this->_var['serv_rank'] > 0): ?><?php echo $this->_var['serv_rank']; ?><?php else: ?>5<?php endif; ?> </div>
      <div class="ulev-1 m-top1"> 服务 </div>
    </div>
    <div class="ub ub-ver ub-ac ub-f1 ubr border-faxian">
      <div class="ulev-9"> <?php if ($this->_var['shipp_rank'] > 0): ?><?php echo $this->_var['shipp_rank']; ?><?php else: ?>5<?php endif; ?> </div>
      <div class="ulev-1 m-top1"> 物流 </div>
    </div>
    <div class="ub ub-ver ub-ac ub-f1 _chat" chat_attr="supplier_id" supplier_id="<?php echo $this->_var['suppinfo']['supplier_id']; ?>">
      <div class="chat-btn1"></div>
      <div class="ulev-1 m-top1 f-blue"> 在线客服 </div>
    </div>
  </div>
  <?php if ($this->_var['shop_notice']): ?>
  <div class="p-all1 ulev-1 bg-color-w m-top3 f-color-zi ubb ubt border-hui"><?php echo $this->_var['shop_notice']; ?></div>
  <?php endif; ?>
  <?php if ($this->_var['flash_theme']): ?>
  <div class="p-all9 bg-color-w m-top3 ubb border-hui ub-f1" id='swiper_container'></div>
  <?php endif; ?>
  <?php if ($this->_var['new_goods']): ?> 
  <div class="bg-color-w m-top3 ubb border-hui">
    <div class="ub ubb border-hui p-all5">
      <div class="ub-f1 ulev-9 f-color-zi">今日新品</div>
    </div>
    <div class="m-top3"> 
	  <?php $_from = $this->_var['new_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
	  <?php echo $this->fetch('/library/goods.lib'); ?>
	  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
	  <div class="clear1"></div>
    </div>
  </div>
  <?php endif; ?> 
  <?php if ($this->_var['hot_goods']): ?> 
  <div class="bg-color-w m-top3 ubb border-hui">
    <div class="ub ubb border-hui p-all5">
      <div class="ub-f1 ulev-9 f-color-zi">销量排行榜</div>
    </div>
    <div class="m-top3"> 
	  <?php $_from = $this->_var['hot_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
	  <?php echo $this->fetch('/library/goods.lib'); ?>
	  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
	  <div class="clear1"></div>
    </div>
  </div>
  <?php endif; ?> 
  <?php if ($this->_var['best_goods']): ?> 
  <div class="bg-color-w m-top3 ubb border-hui">
    <div class="ub ubb border-hui p-all5">
      <div class="ub-f1 ulev-9 f-color-zi">精品推荐</div>
    </div>
    <div class="m-top3"> 
	  <?php $_from = $this->_var['best_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
	  <?php echo $this->fetch('/library/goods.lib'); ?>
	  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
	  <div class="clear1"></div>
    </div>
  </div>
  <?php endif; ?>
  <?php if ($this->_var['category_goods']): ?> 
  <?php $_from = $this->_var['category_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'ginfo');if (count($_from)):
    foreach ($_from AS $this->_var['ginfo']):
?>
  <div class="bg-color-w m-top3 ubb border-hui">
    <div class="ub ubb border-hui p-all5">
      <div class="ub-f1 ulev-9 f-color-zi"> <?php echo $this->_var['ginfo']['cat_name']; ?> </div>
	  <div class="tx-r sc-text ulev-1 umar-r category" cat_id="<?php echo $this->_var['ginfo']['cat_id']; ?>">更多 &gt;</div>
    </div>
    <div class="m-top3"> 
      <?php $_from = $this->_var['ginfo']['goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
      <?php echo $this->fetch('/library/goods.lib'); ?>
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      <div class="clear1"></div>
    </div>
  </div>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
  <?php endif; ?> 
</div>
<div class="p-fixed-btm1 bg-color-w ub ulev-9 f-color-5f ubt border-hui">
  <div class="w-min5 ubr border-hui ub ub-ac ub-pc p-t-b4" id="shop_msg">店铺信息</div>
  <div class="w-min5 ubr border-hui ub ub-ac ub-pc" id="shop_category">店铺分类</div>
  <div class="w-min5 ub-ac ub-pc ub _phone" phone='<?php echo $this->_var['contact_phone']; ?>'>
    <div class="ub-img shop-duihua h-w-6"></div>
    <div class="m-l3">联系卖家</div>
  </div>
</div>

<div class="into-cart  mfp-hide" style="position:fixed; width:100%; bottom:0" id='shop_msg_popup'>
  <div class="ub ubb border-hui ub-ac p-t-b4 bg-color-w">
    <div class="ub-f1 ulev-9 bc-text m-l1">店铺信息</div>
  </div>
  <div class="p-l bc-grey tx-l">
    <div class="ub ubb border-hui ulev-1 p-t-b4">
      <div class="w-min3 sc-text-hui">商店等级：</div>
      <div class="ub-f1 tx-l f-color-6"><?php echo $this->_var['userrank']; ?></div>
    </div>
    <div class="ub ubb border-hui ulev-1 p-t-b4">
      <div class="w-min3 sc-text-hui">好评率：</div>
      <div class="ub-f1 tx-l f-color-6"><?php if ($this->_var['haoping'] > 0): ?><?php echo $this->_var['haoping']; ?>%<?php else: ?>100%<?php endif; ?></div>
    </div>
    <div class="ub ubb border-hui ulev-1 p-t-b4">
      <div class="w-min3 sc-text-hui">所在地区：</div>
      <div class="ub-f1 tx-l f-color-6"><?php echo $this->_var['region']; ?></div>
    </div>
    <div class="ub ubb border-hui ulev-1 p-t-b4">
      <div class="w-min3 sc-text-hui">创店时间：</div>
      <div class="ub-f1 tx-l f-color-6"><?php echo $this->_var['createtime']; ?></div>
    </div>
    <div class="ub ubb border-hui ulev-1 p-t-b4">
      <div class="w-min3 sc-text-hui">详细地址：</div>
      <div class="ub-f1 tx-l f-color-6"><?php echo $this->_var['address']; ?></div>
    </div>
  </div>
  <div class="bg-color-w">
    <div class="p-all5 ulev-9">二维码</div>
    <div class="goods-img" style="width:50%; margin:0 auto"> <img src="<?php echo $this->_var['url']; ?>erweima_supplier.php?sid=<?php echo $this->_var['suppid']; ?>"/> </div>
    <div class="ub ub-ac ub-pc ulev-1 sc-text-hui p-all5"> 扫描二维码 关注有惊喜 </div>
  </div>
</div>
<script type="text/javascript">
<?php echo $this->_var['flash_theme']; ?>
</script> 
