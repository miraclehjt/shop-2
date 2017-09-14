<div class="ub ub-ver  m-btm1">
  <div class="ub-fh ub ub-ver"> <?php if ($this->_var['login'] == 1): ?> 
    
    <div id="user-login" class="user-bg ubb border-hui">
      <img class="user-logo-l" id='user_photo_button' src='<?php echo $this->_var['headimg']; ?>' />
      <div class="ub h-min2">
        <div class="ub-f1"></div>
        <div class="setup-meg ub-pe mar-ar1" id="setup-meg">
          <div class="ulev-1">修改信息</div>
        </div>
      </div>
      <div class="ub p-t-b1">
        <div class="w-min2"></div>
        <div class="ub-f1 ub ub-ac">
          <div class="bc-text-head"> <span class="ulev0"><?php echo $_SESSION['user_name']; ?></span> </div>
        </div>
        <div class="ub-pe mar-ar1"><span class="ulev-1 sc-text-hint"><?php echo $this->_var['rank_name']; ?></span></div>
      </div>
      <div class="ub bg-color-w p-t-b4">
        <div class="w-min1"></div>
        <div class="ub c-wh-per ub-ae ub-f1 f-color-zi">
          <div class="ub ub-ver ub-f1 ub-pc ubr border-hui" id="user_collection_goods">
            <div class="ub-ae ufm1 tx-c ulev-9"> <?php echo $this->_var['collection_count']; ?> </div>
            <div class="ulev-4 tx-c ub-f1 m-top1">商品收藏</div>
          </div>
          <div class="ub ub-ver ub-f1 ub-pc ubr border-hui" id="user_collection_shop">
            <div class="ub-ae ufm1 tx-c ulev-9"> <?php echo $this->_var['guanzhu_count']; ?> </div>
            <div class="ulev-4 tx-c ub-f1 m-top1">店铺收藏</div>
          </div>
          <div class="ub ub-ver ub-f1 ub-pc ub-ac" id='goods_history_button'>
            <div class="ub-img history-icon h-w-1"></div>
            <div class="ulev-4 tx-c ub-f1 m-top1">浏览历史</div>
          </div>
        </div>
      </div>
    </div>
     
    <?php elseif ($this->_var['login'] == 0): ?> 
    
    <div id="user-nlogin" class="user-bg">
      <div class="ub ub-pc ub-ac ub-ver p-t-b5 _login" id="login_button" style="padding:1.5em 0;">
        <div class="user-logo"></div>
        <div class="ub ub-ac ub-pc m-top1 login-btn"> <font class="ulev-1 bc-text-head">登录</font> </div>
      </div>
    </div>
     
    <?php endif; ?> </div>
  <div id="indexCon_2-listview1" class="bg-color-w ubb border-hui <?php if ($this->_var['login'] == 1): ?>umar-t1<?php endif; ?>">
    <ul>
      <li class="ubb border-hui ub ub-ac user-pad1 order_list" id='order_list' composite_status="-1">
        <div class="ulev-9 ub-f1 marg-l ut-m line1 f-color-zi">全部订单</div>
        <div class="ulev-1 umar-r sc-text-hui border-faxianitle">查看全部订单</div>
        <div class="jiantou-right h-w-1 ub-img"></div>
      </li>
    </ul>
    <div class="ub bg-color-w p-t-b9 ub-ae f-color-6">
      <div class="ub ub-ver ub-f1 ub-pc ub-ac order_list" composite_status="<?php echo $this->_var['status']['await_pay']; ?>">
        <div class="ub-img user_order user_order1">
          <div class="user_num ub ub-ac ub-pc">
            <div class="ulev-2 f-color-red"><?php echo empty($this->_var['info']['await_pay_order']) ? '0' : $this->_var['info']['await_pay_order']; ?></div>
          </div>
        </div>
        <div class="ulev-2 tx-c ub-f1 m-top2">待付款</div>
      </div>
      <div class="ub ub-ver ub-f1 ub-pc ub-ac order_list" composite_status='<?php echo $this->_var['status']['await_ship']; ?>'>
        <div class="ub-img user_order user_order2">
          <div class="user_num ub ub-ac ub-pc">
            <div class="ulev-2 f-color-red"><?php echo empty($this->_var['info']['await_ship_order']) ? '0' : $this->_var['info']['await_ship_order']; ?></div>
          </div>
        </div>
        <div class="ulev-2 tx-c ub-f1 m-top2">待发货</div>
      </div>
      <div class="ub ub-ver ub-f1 ub-pc ub-ac order_list" composite_status="<?php echo $this->_var['status']['shipped']; ?>">
        <div class="ub-img user_order user_order3">
          <div class="user_num ub ub-ac ub-pc">
            <div class="ulev-2 f-color-red"><?php echo empty($this->_var['info']['shipped_order']) ? '0' : $this->_var['info']['shipped_order']; ?></div>
          </div>
        </div>
        <div class="ulev-2 tx-c ub-f1 m-top2">待收货</div>
      </div>
      <div class="ub ub-ver ub-f1 ub-pc ub-ac my_comment" comment_status='0'>
        <div class="ub-img user_order user_order4">
          <div class="user_num ub ub-ac ub-pc">
            <div class="ulev-2 f-color-red"><?php echo empty($this->_var['num_comment']) ? '0' : $this->_var['num_comment']; ?></div>
          </div>
        </div>
        <div class="ulev-2 tx-c ub-f1 m-top2">待评价</div>
      </div>
    </div>
  </div>
  <div id="indexCon_2-listview1" class="bg-color-w ubb border-hui umar-t1">
    <ul>
      <li class="ubb border-hui ub ub-ac user-pad1 user_capital">
        <div class="ulev-9 ub-f1 marg-l ut-m line1 f-color-zi">我的资产</div>
        <div class="ulev-1 umar-r sc-text-hui border-faxianitle">查看全部资产</div>
        <div class="jiantou-right h-w-1 ub-img"></div>
      </li>
    </ul>
    <div class="ub bg-color-w p-t-b6 ub-ae f-color-6">
      <div class="ub ub-f1 ub-pc ub-ac ulev-1" id="user_red_package">
        <div class="user-zj-icon1 ub-img h-w-2"></div>
        <div class="m-l2">红包</div>
        <div class="m-l2 f-color-red"><?php if ($this->_var['login'] == 1): ?><?php echo empty($this->_var['info']['bonus']) ? '0' : $this->_var['info']['bonus']; ?><?php else: ?>0<?php endif; ?></div>
      </div>
      <div class="ub ub-f1 ub-pc ub-ac ulev-1">
        <div class="user-zj-icon2 ub-img h-w-2"></div>
        <div class="m-l2">积分</div>
        <div class="m-l2 f-color-red"><?php echo empty($this->_var['info']['integral']) ? '0' : $this->_var['info']['integral']; ?></div>
      </div>
      <div class="ub ub-f1 ub-pc ub-ac ulev-1 user_capital">
        <div class="user-zj-icon3 ub-img h-w-2"></div>
        <div class="m-l2">余额</div>
        <div class="m-l2 f-color-red"><?php echo empty($this->_var['info']['surplus']) ? '0' : $this->_var['info']['surplus']; ?></div>
      </div>
    </div>
  </div>
  <div class="umar-t1 ubb border-hui">
    <div class="ub bg-color-w ub ub-ac ub-pc" id="address-list">
      <div class="ub-img h-w-6 user-icon1 m-l-r1"></div>
      <div class="ub ub-ac ubb border-hui ub-f1 p-t-b6">
        <div class="ulev-9 f-color-zi ub-f1">收货地址</div>
        <div class="jiantou-right h-w-1 ub-img umar-ar6"></div>
      </div>
    </div>
    <div class="ub bg-color-w ub ub-ac ub-pc" id="user_store_card">
      <div class="ub-img h-w-6 user-icon2 m-l-r1"></div>
      <div class="ub ub-ac ub-f1 p-t-b6">
        <div class="ulev-9 f-color-zi ub-f1">储值卡充值</div>
        <div class="jiantou-right h-w-1 ub-img umar-ar6"></div>
      </div>
    </div>
  </div>
  <div class="umar-t1 ubb border-hui">
    <div class="ub bg-color-w ub ub-ac ub-pc my_comment" id="user_my_comment">
      <div class="ub-img h-w-6 user-icon6 m-l-r1"></div>
      <div class="ub ub-ac ubb border-hui ub-f1 p-t-b6">
        <div class="ulev-9 f-color-zi ub-f1">商品评价/晒单</div>
        <div class="jiantou-right h-w-1 ub-img umar-ar6"></div>
      </div>
    </div>
    <div class="ub bg-color-w ub ub-ac ub-pc" id="user_less_list">
      <div class="ub-img h-w-6 user-icon3 m-l-r1"></div>
      <div class="ub ub-ac ubb border-hui ub-f1 p-t-b6">
        <div class="ulev-9 f-color-zi ub-f1">缺货登记</div>
        <div class="jiantou-right h-w-1 ub-img umar-ar6"></div>
      </div>
    </div>
    <div class="ub bg-color-w ub ub-ac ub-pc" id="user_message">
      <div class="ub-img h-w-6 user-icon4 m-l-r1"></div>
      <div class="ub ub-ac ub-f1 p-t-b6">
        <div class="ulev-9 f-color-zi ub-f1">我的留言</div>
        <div class="jiantou-right h-w-1 ub-img umar-ar6"></div>
      </div>
    </div>
	<?php if ($this->_var['recomm'] == 1): ?>
	<?php if ($this->_var['affiliate']['on'] == 1): ?>
	<div class="ub bg-color-w ub ub-ac ub-pc _page" page_type="window" page_file="user_affiliate" page_name="user_affiliate">
      <div class="ub-img h-w-6 user-icon7 m-l-r1"></div>
      <div class="ub ub-ac ub-f1 p-t-b6 ubt border-hui">
        <div class="ulev-9 f-color-zi ub-f1">我的推荐</div>
        <div class="jiantou-right h-w-1 ub-img umar-ar6"></div>
      </div>
    </div>
	<?php endif; ?>
	<?php endif; ?>
  </div>
  <?php if ($this->_var['login'] == 1): ?>
  <div class="umar-t1 ubb border-hui">
    <div class="ub bg-color-w ub ub-ac ub-pc _logout" id='logout_button'>
      <div class="ub-img h-w-6 user-icon5 m-l-r1"></div>
      <div class="ub ub-ac ub-f1 p-t-b6">
        <div class="ulev-9 f-color-zi ub-f1">退出</div>
        <div class="jiantou-right h-w-1 ub-img umar-ar6"></div>
      </div>
    </div>
  </div>
  <?php endif; ?> </div>
