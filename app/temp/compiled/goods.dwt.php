
<div class="cover_div uhide" id="cover_div"></div>
<div class="uh ub bg-color-w maxh ubb border-hui head-h p-fixed">
  <div class="nav-btn1 _back" id="nav-left">
    <div class="ub-img icon-back1"></div>
  </div>
  <div class="ub ub-pc ub-f1 ulev-9 f-color-6">
    <div class="goods-check ub ub-ac goods-check-on">
      <div>商品</div>
    </div>
    <div class="goods-check ub ub-ac">
      <div>详情</div>
    </div>
    <div class="goods-check ub ub-ac">
      <div>评论</div>
    </div>
  </div>
  <div class="nav-btn1" id="nav-right">
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

<div class='ub swiper-container ios-top' id='swiper_container_1' style='height:100%;'>
  <div class='ub swiper-wrapper' style='overflow-y:hidden;overflow-x:hidden;'> 
    
    <div class="ub-f1 goods-con-p swiper-slide" style='overflow-x:hidden;overflow-y: scroll;'>
      <div class="swiper-container ub-fh" id='swiper_container_2'>
        <div class="ub swiper-wrapper"> <?php if ($this->_var['pictures']): ?>
          <?php $_from = $this->_var['pictures']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'picture');if (count($_from)):
    foreach ($_from AS $this->_var['picture']):
?>
          <?php echo $this->fetch('library/goods_gallery.lib'); ?>
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
          <?php else: ?>
          <div class="swiper-slide ub-fh goods-img"> <img src='<?php echo $this->_var['url']; ?><?php echo $this->_var['goods']['goods_img']; ?>'/> </div>
          <?php endif; ?> </div>
        <div class="swiper-pagination" id='swiper_pagination_2' style='height:1em;'></div>
      </div>
      
      <div class="ub goods_title ub-ac p-t-b5">
        <div class="ub-f1 ulev-9 bc-text l-h-1 p-l-r3" id='goods_name_label'><?php echo $this->_var['goods']['goods_style_name']; ?></div>
        <div class="ub-ver ubl border-top ub ub-ac ub-pc p-l-r1" id='share_button'>
          <div class="to-share ub-img"></div>
          <div class="sc-text-hui ulev-2 tx-c m-top2">分享</div>
        </div>
      </div>
      <div class="bg-color-w goods-pad">
        <div class="ub ub-ac ub-var">          
          <div class="f-color-red ulev2 goods_price_label" id='goods_price_label'><?php echo $this->_var['goods']['goods_price']; ?>
          </div>
		  <?php if ($this->_var['goods']['goods_price'] == $this->_var['goods']['exclusive']): ?>
           <div class="goods-red bc-text-head ulev-2 m-l1">手机专享</div>
		  <?php endif; ?>
           <?php if ($this->_var['goods']['is_promote'] && $this->_var['goods']['gmt_end_time']): ?>
           <div class="goods-red bc-text-head ulev-2 m-l1">促销</div>
           <?php endif; ?>
           
        </div>
		<div class="ub ub-ac ub-var">
		</div>
        <?php if ($this->_var['goods']['is_promote'] && $this->_var['goods']['gmt_end_time']): ?>
        <div class="ub ub-ac p-t-b3 m-top1">
          <div class="ulev-1 f-color-red">促销倒计时</div>
          <div class="pro_time ub-img m-l1"></div>
          <div id="leftTime" class="ulev-1 f-color-red settime" endTime="<?php echo $this->_var['goods']['promote_end_date']; ?>"><?php echo $this->_var['lang']['please_waiting']; ?></div>
        </div>
        <?php endif; ?>
        <?php if ($this->_var['goods']['goods_brief']): ?>
        <div class="ulev-1 sc-text-hui m-top1"><?php echo $this->_var['goods']['goods_brief']; ?></div>
        <?php endif; ?>
        <div class="f-color-6 ulev-1 m-top1">
          <div class="goods-u-m">商品货号：<?php echo $this->_var['goods']['goods_sn']; ?></div>
          <div class="clear1"></div>
        </div>
      </div>
      <div class="ubt ubb border-faxian ub bc-grey goods-pad ulev-1 f-color-6">
        <div class="ub-f1">累计评价 <font class="f-color-red"><?php echo $this->_var['review_count']; ?></font> 人评价</div>
        <div class="ub-f1">累计销量 <font class="f-color-red"><?php echo $this->_var['goods']['salenum']; ?></font></div>
        <div class="ub-f1">赠送积分 <font class="f-color-red"> <?php if ($this->_var['goods']['give_integral_2'] == '-1'): ?>
          <?php echo $this->_var['goods']['give_integral']; ?>
          <?php elseif ($this->_var['goods']['give_integral_2'] > 0): ?>
          <?php echo $this->_var['goods']['give_integral']; ?>
          <?php else: ?>
          0
          <?php endif; ?> </font> </div>
      </div>
      <div class="goods-level bg-color-w m-btm1 ubb border-hui">
        <?php if ($this->_var['rank_prices']): ?>
		<?php $_from = $this->_var['rank_prices']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'rank_price');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['rank_price']):
?> 
		<div class="rmbPrice goods-u-m ulev-1 sc-text-hui"> <?php echo $this->_var['rank_price']['rank_name']; ?>：<?php echo $this->_var['rank_price']['price']; ?></div> 
		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
		<?php endif; ?>
       <div class="clear1"></div> 
        </div>
      <?php if ($this->_var['volume_price_list']): ?>
      <li class="padd goods-pad bg-color-w">
        <div class="ulev-1 f-color-red m-btm1"><?php echo $this->_var['lang']['volume_price']; ?></div>
        <table class="tbady-style" style="text-align:center">
          <tr class="ulev-1 f-color-6">
            <th><?php echo $this->_var['lang']['number_to']; ?></th>
            <th><?php echo $this->_var['lang']['preferences_price']; ?></th>
          </tr>
          <?php $_from = $this->_var['volume_price_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('price_key', 'price_list');if (count($_from)):
    foreach ($_from AS $this->_var['price_key'] => $this->_var['price_list']):
?>
          <tr class="ulev-1 f-color-6">
            <th class="shop"><?php echo $this->_var['price_list']['number']; ?></th>
            <th class="shop"><?php echo $this->_var['price_list']['format_price']; ?></th>
          </tr>
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </table>
      </li>
      <?php endif; ?> 
      <?php if ($this->_var['promotion']): ?>
      <div class="ubb border-hui bg-color-w p-l-r3 p-t-b3 ulev-1"> <?php $_from = $this->_var['promotion']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
        $this->_foreach['name']['iteration']++;
?>
        <?php if ($this->_var['item']['type'] == "snatch"): ?>
        <div class="ub ub-ac p-t-b5">
          <div class="goods-red1 ulev-1"><?php echo $this->_var['lang']['snatch']; ?></div>
          <div class="ub-f1 sc-text-hui"><?php echo $this->_var['item']['act_name']; ?></div>
        </div>
        <?php elseif ($this->_var['item']['type'] == "group_buy"): ?>
        <div class="ub ub-ac p-t-b5">
          <div class="goods-red1 ulev-1"><?php echo $this->_var['lang']['group_buy']; ?></div>
          <div class="ub-f1 sc-text-hui"><?php echo $this->_var['item']['act_name']; ?></div>
        </div>
        <?php elseif ($this->_var['item']['type'] == "auction"): ?>
        <div class="ub ub-ac p-t-b5">
          <div class="goods-red1 ulev-1"><?php echo $this->_var['lang']['auction']; ?></div>
          <div class="ub-f1 sc-text-hui"><?php echo $this->_var['item']['act_name']; ?></div>
        </div>
        <?php elseif ($this->_var['item']['type'] == "favourable"): ?>
        <div 
        <?php if ($this->_var['item']['gift'] !== array ( )): ?> 
        class="ub ub-ac p-t-b5 has_gift_popup" 
        gift-popup-id='<?php echo $this->_foreach['name']['iteration']; ?>' 
        <?php else: ?>
        class="ub ub-ac p-t-b5" 
        <?php endif; ?>>
        <div class="ub ub-f1 ub-ac">
          <div class="goods-red1 ulev-1"><?php echo $this->_var['item']['act_type']; ?></div>
          <div class="sc-text-hui ub-f1"><?php echo $this->_var['item']['act_name']; ?></div>
        </div>
        <?php if ($this->_var['item']['gift'] !== array ( )): ?>
        <div class="ub-pe top-more ub-img"></div>
        <?php endif; ?> </div>
      <?php if ($this->_var['item']['gift'] !== array ( )): ?> 
      
      <div class=" mfp-hide" style="position:fixed; width:100%; bottom:0" id='goods_gift_<?php echo $this->_foreach['name']['iteration']; ?>'>
        <div class="ub ubb border-hui ub-ac p-t-b4 bg-color-w">
          <div class="ub-f1 ulev-9 bc-text m-l1"> <?php if ($this->_var['item']['act_range'] == 0): ?>
            优惠范围：全部商品
            <?php elseif ($this->_var['item']['act_range'] == 1): ?>
            优惠范围：全部分类
            <?php elseif ($this->_var['item']['act_range'] == 2): ?>
            优惠范围：品牌
            <?php elseif ($this->_var['item']['act_range'] == 3): ?>
            优惠范围：商品
            <?php endif; ?> </div>
        </div>
        <div class="uinn-a1 bc-grey tx-l" style="overflow-x:scroll"> <?php $_from = $this->_var['item']['gift']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'gift');if (count($_from)):
    foreach ($_from AS $this->_var['gift']):
?>
          <div class="ub-ver float-l mar-ar1">
            <div class="ub-img goods h-w-7" style="background-image:url(<?php echo $this->_var['url']; ?><?php echo $this->_var['gift']['thumb']; ?>);" goods_id="<?php echo $this->_var['gift']['id']; ?>"></div>
            <div class="ulev-1 tx-c f-color-red p-t-b6"><?php echo $this->_var['gift']['price']; ?>元</div>
          </div>
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
          <div class="clear1"></div>
        </div>
      </div>
      <?php endif; ?>
      <?php endif; ?>
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> </div>
    <?php endif; ?> 
    <div class="ubb border-hui bg-color-w goods-pad ulev-1 ub ub-ac umar-t1 f-color-6" id='pickup_button'>
      <div class="ub-f1">查看店铺自提点</div>
      <div class="ub-pe top-more ub-img"></div>
    </div>
    <?php if ($this->_var['specification']): ?>
    <div class="ubb border-hui bg-color-w goods-pad ulev-1 ub ub-ac umar-t1 f-color-6" id='goods_attr_button'>
      <div class="ub-f1">选择商品属性</div>
      <div class="ub-pe top-more ub-img"></div>
    </div>
    <?php endif; ?>
    <div class="ubb border-hui bg-color-w goods-pad ulev-1 ub ub-ac umar-t1 f-color-6" id='goods_desc_button'>
      <div class="ub-f1">规格参数</div>
      <div class="ub-pe top-more ub-img"></div>
    </div>
     
    <?php if ($this->_var['goods']['supplier_id'] > 0): ?>
    <div class="ubb border-hui bg-color-w goods-pad umar-t1">
      <div class="ub"> <?php if ($this->_var['shoplogo']): ?>
        <div class="shop-logo"><img src="<?php echo $this->_var['url']; ?><?php echo $this->_var['shoplogo']; ?>"/></div>
        <?php endif; ?>
        <div class="ub-ver m-l1"> <?php if ($this->_var['suppliername']): ?>
          <div class="ulev-9 f-color-zi"><?php echo $this->_var['suppliername']; ?></div>
          <?php endif; ?>
          <?php if ($this->_var['shopname']): ?>
          <div class="ulev-1 sc-text-hui m-top3">卖家：<?php echo $this->_var['shopname']; ?></div>
          <?php endif; ?> </div>
      </div>
      <div class="ub umar-t1 sc-text-hui">
        <div class="shop-btn ub-f1 ub-ac ub-pc ub" id='enter_supplier_button' supplier_id="<?php echo $this->_var['goods']['supplier_id']; ?>">
              <div class="shop_icon ub-img h-w-1"></div>
              <div class="m-l2 ulev-9">进入店铺</div>
        </div>
        <div class="shop-btn ub-f1 ub-ac ub-pc ub m-l2 <?php if ($this->_var['goods']['followed']): ?>followed<?php endif; ?>" id='follow_supplier_button' supplier_id="<?php echo $this->_var['goods']['supplier_id']; ?>">
        	<div id="follow_s_zi" class="focus ub-img h-w-1"></div>
        	<div class="m-l2 ulev-9" id="shop_focus"><?php if ($this->_var['goods']['followed']): ?>已关注<?php else: ?>关注店铺<?php endif; ?></div>
        </div>
      </div>
    </div>
    <?php endif; ?> </div>
  
  <style>
  .goos-con {font-size:0.825em; color:#666666}
  .goods-con img {width:100%; height:auto}
  </style>

  <div class="ub-f1 tx-l goos-con goods-con-p swiper-slide bg-color-w " style='overflow-x:hidden;overflow-y: scroll; padding-top:4em' id="goods_desc_container"> <?php echo $this->_var['goods']['goods_desc']; ?> </div>
  
  <div class="ub-f1 tx-l goods-con-p swiper-slide" style='overflow-x:hidden;overflow-y: scroll;' id='goods_comments_tab'> <?php echo $this->fetch('library/my_comments.lib'); ?> </div>
</div>
</div>

<div class="uf t-bla ub ubt border-hui p-fixed-btm1 bc-grey h-min1" id='footer_1'>
  <div class="ub-ver ub ub-pc ub-ac p-l-r2 ubr border-hui" id='go_to_cart'>
    <div class="ub-img gouwuche h-w-6">     
        <div class="ub ub-ac ub-pc ulev-2"><div id='cart_num_label'><?php echo empty($this->_var['cart_num']) ? '0' : $this->_var['cart_num']; ?></div></div>      
    </div>
    <div class="ulev-2 sc-text-hui m-top4">购物车</div>
  </div>
  <div class="ub-ver ub ub-pc ub-ac p-l-r2 p-t-b3 ubr border-hui" id='collect_button' is_collect='<?php echo $this->_var['goods']['is_collet']; ?>' collect_id='<?php echo $this->_var['goods']['collect_id']; ?>'> <?php if ($this->_var['goods']['is_collet'] == 1): ?>
    <div class="shoucang-on h-w-6 ub-img"></div>
    <div class="ulev-2 sc-text-hui m-top4">已收藏</div>
    <?php else: ?>
    <div class="shoucang-off h-w-6 ub-img"></div>
    <div class="ulev-2 sc-text-hui m-top4">收藏</div>
    <?php endif; ?> </div>
    <div class="ub-ver ub ub-pc ub-ac p-l-r2 p-t-b3 _chat" chat_attr="goods_id" goods_id="<?php echo $this->_var['goods']['goods_id']; ?>"> 
    <div class="chat_logo h-w-6 ub-img"></div>
    <div class="ulev-2 sc-text-hui m-top4">客服</div>
    </div>
  <div class="ub ub-pc ub-ac ub-f1 bc-yellow <?php if ($this->_var['goods_n'] > 0): ?>uhide <?php endif; ?> out_of_stock goods_booking">
    <div class="bc-text-head ulev0">到货通知</div>
  </div>
  <div class='ub ub-f1 <?php if ($this->_var['goods_n'] == 0): ?>uhide<?php endif; ?> has_stock'>
    <div class="ub ub-pc ub-ac ub-f1 bc-yellow buy_now">
      <div class="bc-text-head ulev0">立即购买</div>
    </div>
    <div class="ub ub-pc ub-ac ub-f1 bc-head1 add_to_cart">
      <div class="bc-text-head ulev0">加入购物车</div>
    </div>
  </div>
</div>
 

<div class="into-cart bg-color-w  mfp-hide" id='popup' style="position: fixed;bottom: 0;width:100%" id='footer_2'>
<div class="goods-pad">
  <div class="ub ubb border-hui" style="height:5em;">
    <div class="into-cart-img bg-color-w ub-f1 goods-img"> <img src="<?php echo $this->_var['url']; ?><?php echo $this->_var['goods']['goods_thumb']; ?>"/> </div>
    <div class="ub-f2 ub-ver p-l" style="width:40%">
      <div class="f-color-red ulev0 goods_price_label" id='ECS_GOODS_AMOUNT'><?php if ($this->_var['goods']['is_promote'] && $this->_var['goods']['gmt_end_time']): ?><?php echo $this->_var['goods']['promote_price']; ?><?php else: ?><?php echo $this->_var['goods']['shop_price']; ?><?php endif; ?></div>
      <div class="ulev-1 f-color-6 m-top3">库存： <span id='goods_number'><?php echo $this->_var['goods']['goods_number']; ?></span> 件</div>
    </div>
  </div>
   
  <?php $_from = $this->_var['specification']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('spec_key', 'spec');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['spec_key'] => $this->_var['spec']):
        $this->_foreach['name']['iteration']++;
?> 
   
  <?php if ($this->_var['spec']['attr_type'] == 1): ?> 
  <?php if ($this->_var['cfg']['goodsattr_style'] == 1): ?>
  <div class="ubb border-hui p-t-b5">
    <div class="ulev-1 f-color-6 ub-f1"><?php echo $this->_var['spec']['name']; ?>：</div>
    <div class="shuxing spec_key m-top1" id='spec_key_<?php echo $this->_var['spec_key']; ?>' spec_key='<?php echo $this->_var['spec_key']; ?>'> 
      <?php $_from = $this->_var['spec']['values']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'value');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['value']):
?> 
      <?php if ($this->_var['value']['goods_attr_thumb']): ?> 
      <img src="<?php echo $this->_var['url']; ?><?php echo $this->_var['value']['goods_attr_thumb']; ?>" class="img-xc"/> 
      <?php endif; ?>
      <div class='goods_attr <?php if ($this->_var['spec_key'] == $this->_var['attr_id']): ?>gallery_attr<?php endif; ?>' id='spec_key_<?php echo $this->_var['spec_key']; ?>_attr_id_<?php echo $this->_var['value']['id']; ?>' attr_id='<?php echo $this->_var['value']['id']; ?>' spec_key='<?php echo $this->_var['spec_key']; ?>'><?php echo $this->_var['value']['label']; ?></div>
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      <ul class="clear1">
      </ul>
    </div>
  </div>
  <?php else: ?> 
  <?php $_from = $this->_var['spec']['values']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'value');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['value']):
?> 
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
  <?php endif; ?> 
  <?php else: ?> 
  <?php $_from = $this->_var['spec']['values']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'value');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['value']):
?> 
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
  <?php endif; ?> 
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  <div class="ub p-t-b4 ub-ac">
    <div class="ub-f1 ulev-1 f-color-6">购买数量：</div>
    <div class="ub-pe ub-ac ub uba border-top uc-t1 uc-b1 uinput1">
      <div class="ubr border-top uinn1" id='reduce_goods_button'>-</div>
      <input name='number' id='number' type="text" class="text-b1" value="1"/>
      <div class="ubl border-top uinn1" id='increase_goods_button'>+</div>
    </div>
  </div>
  <?php if ($this->_var['tag'] == 1): ?>
  <div class="ub p-t-b4 ub-ac">
    <div class="ub-f1 ulev-1 f-color-6">限购数量：<?php echo $this->_var['goods']['buymax']; ?></div>
  </div>
  <?php endif; ?> 
</div>
<div class='out_of_stock <?php if ($this->_var['goods_n'] > 0): ?>uhide<?php endif; ?>'>
  <div class="ub ub-ac ub-pc ub-f1 bc-yellow p-t-b4 goods_booking">
    <div class="ulev-9 bc-text-head">缺货登记</div>
  </div>
</div>
<div class='has_stock <?php if ($this->_var['goods_n'] == 0): ?>uhide<?php endif; ?>'>
  <div class="ub" id='popup_footer_1'>
    <div class="ub ub-ac ub-pc ub-f1 bc-yellow p-t-b4 buy_now">
      <div class="ulev-9 bc-text-head">立即购买</div>
    </div>
    <div class="ub ub-pc ub-ac ub-f1 bc-head1 p-t-b4 add_to_cart">
      <div class="bc-text-head ulev-9">加入购物车</div>
    </div>
  </div>
  <div class="bc-head1 p-t-b4 ub ub-pc" id='popup_footer_2'>
    <div class="bc-text-head ulev-9">确定</div>
  </div>
</div>
</div>

<div class="into-cart  mfp-hide" style="position:fixed; width:100%; bottom:0;" id='goods_desc_popup'>
  <div class="ub ubb border-hui ub-ac p-t-b4 bg-color-w">
    <div class="ub-f1 ulev-9 bc-text m-l1">规格参数</div>
  </div>
  <div class="p-l bc-grey tx-l" style="max-height:20em; overflow-y:scroll">
    <div class="ub ubb border-hui ulev-1 p-t-b4">
      <div class="w-min3 sc-text-hui">商品名称：</div>
      <div class="ub-f1 tx-l f-color-6"><?php echo $this->_var['goods']['goods_style_name']; ?></div>
    </div>
    <div class="ub ubb border-hui ulev-1 p-t-b4">
      <div class="w-min3 sc-text-hui">商品编号：</div>
      <div class="ub-f1 tx-l f-color-6"><?php echo $this->_var['goods']['goods_sn']; ?></div>
    </div>
    <div class="ub ubb border-hui ulev-1 p-t-b4">
      <div class="w-min3 sc-text-hui">品牌：</div>
      <div class="ub-f1 tx-l f-color-6"><?php echo $this->_var['goods']['goods_brand']; ?></div>
    </div>
    <div class="ub ubb border-hui ulev-1 p-t-b4">
      <div class="w-min3 sc-text-hui">上架时间：</div>
      <div class="ub-f1 tx-l f-color-6"><?php echo $this->_var['goods']['add_time']; ?></div>
    </div>
    <div class="ub ubb border-hui ulev-1 p-t-b4">
      <div class="w-min3 sc-text-hui">商品毛重：</div>
      <div class="ub-f1 tx-l f-color-6"><?php echo $this->_var['goods']['goods_weight']; ?></div>
    </div>
    <div class="ub ubb border-hui ulev-1 p-t-b4">
      <div class="w-min3 sc-text-hui">库存：</div>
      <div class="ub-f1 tx-l f-color-6"> 
        <?php if ($this->_var['goods']['goods_number'] == 0): ?> 
        <?php echo $this->_var['lang']['stock_up']; ?> 
        <?php else: ?> 
        <?php echo $this->_var['goods']['goods_number']; ?> <?php echo $this->_var['goods']['measure_unit']; ?> 
        <?php endif; ?> 
      </div>
    </div>
    <?php if ($this->_var['properties']): ?> 
    <?php $_from = $this->_var['properties']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'property_group');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['property_group']):
?> 
    <?php $_from = $this->_var['property_group']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'property');if (count($_from)):
    foreach ($_from AS $this->_var['property']):
?>
    <div class="ub ubb border-hui ulev-1 p-t-b4">
      <div class="w-min3 sc-text-hui"><?php echo htmlspecialchars($this->_var['property']['name']); ?>：</div>
      <div class="ub-f1 tx-l f-color-6"><?php echo $this->_var['property']['value']; ?></div>
    </div>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
    <?php endif; ?> 
  </div>
</div>

<div class="bc-grey  mfp-hide uinn-p2 p-b2" style="position:fixed; width:100%; bottom:0" id='share_popup'>
  <div class="line-th ub ub-ac ub-pc m-all1">
    <div class="ub ulev-9 f-color-6 bc-grey p-l-r3">分享到</div>
  </div>
  <div class="ub p-all1 ulev-9" style="overflow-x:scroll">
    <div class="ub-ver ub ub-ac ub-pc share uhide weixin_share" share_type='weixin2'>
      <div class="ub-img h-w-10" style="background-image:url(img/share/social_wx_circle_press.png)"></div>
      <div class="p-t-b6 ulev-1 f-color-6 tx-c">朋友圈</div>
    </div>
    <div class="ub-ver ub ub-ac ub-pc share m-l1" share_type='tsina'>
      <div class="ub-img h-w-10" style="background-image:url(img/share/social_sina_weibo_press.png)"></div>
      <div class="p-t-b6 ulev-1 f-color-6 tx-c">新浪微博</div>
    </div>
    <div class="ub-ver ub ub-ac ub-pc share m-l1 weixin_share uhide" share_type='weixin1'>
      <div class="ub-img h-w-10" style="background-image:url(img/share/social_wx_press.png)"></div>
      <div class="p-t-b6 ulev-1 f-color-6 tx-c">微信好友</div>
    </div>
	<div class="ub-ver ub ub-ac ub-pc share m-l1 qq_share uhide" share_type='qq'>
      <div class="ub-img h-w-10" style="background-image:url(img/share/social_qq_press.png)"></div>
      <div class="p-t-b6 ulev-1 f-color-6 tx-c">QQ好友</div>
    </div>
    <div class="ub-ver ub ub-ac ub-pc share m-l1" share_type='qzone'>
      <div class="ub-img h-w-10" style="background-image:url(img/share/social_qzone_press.png)"></div>
      <div class="p-t-b6 ulev-1 f-color-6 tx-c">QQ空间</div>
    </div>
    <div class="ub-ver ub ub-ac ub-pc share m-l1" share_type='tqq'>
      <div class="ub-img h-w-10" style="background-image:url(img/share/social_tencent_weibo_press.png)"></div>
      <div class="p-t-b6 ulev-1 f-color-6 tx-c">腾讯微博</div>
    </div>
    <div class="ub-ver ub ub-ac ub-pc share m-l1" share_type='sms'>
      <div class="ub-img h-w-10" style="background-image:url(img/share/social_message_press.png)"></div>
      <div class="p-t-b6 ulev-1 f-color-6 tx-c">短信</div>
    </div>
  </div>
</div>
<div id='scroll_to_top' class="ub-img" style='position:absolute;bottom:45px;'></div>
<script type="text/javascript">
var now_time = "<?php echo $this->_var['now_time']; ?>"
<?php $_from = $this->_var['lang']['goods_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
var suppid = <?php echo $this->_var['goods']['supplier_id']; ?>;
var prod_exist_arr=new Array();

<?php $_from = $this->_var['prod_exist_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('pkey', 'prod');if (count($_from)):
    foreach ($_from AS $this->_var['pkey'] => $this->_var['prod']):
?>
prod_exist_arr[<?php echo $this->_var['pkey']; ?>]="<?php echo $this->_var['prod']; ?>";
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
var share_content = {
goods_id:'<?php echo $this->_var['goods_id']; ?>',
goods_url:'<?php echo $this->_var['url']; ?><?php echo $this->_var['goods_url']; ?>',
goods_name:'<?php echo $this->_var['goods']['goods_style_name']; ?>',
goods_thumb:'<?php echo $this->_var['url']; ?><?php echo $this->_var['goods']['goods_thumb']; ?>',
goods_brief:'<?php echo $this->_var['goods']['goods_name']; ?>'};
</script> 