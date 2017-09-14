<?php if ($this->_var['is_full_page'] == 1): ?>
<div class="cover_div uhide" id="cover_div"></div>
<div class="p-fixed" style="height:105px" id='header'>
  <div class="uh ub bc-head-glist maxh head-h">
    <div class="nav-btn1 _back" id='back_button'>
      <div class="ub-img icon-back1"></div>
    </div>
    <div class="ub-f1 ub ub-ac uc-a1 bg-color uinn-ele2 m-t-b1">
      <div class="uwh-ele1 ub-img ele-search"></div>
      <div class="ub-f1 s-input1">
	  <form action="" onsubmit="return false;">
        <input type="search" class="ulev-9" id='search_input' value='<?php echo $this->_var['keywords']; ?>' placeholder="<?php if ($this->_var['input_place_holder']): ?><?php echo $this->_var['input_place_holder']; ?><?php else: ?>搜索店铺内商品<?php endif; ?>"/>
		</form>
      </div>
    </div>
    <div class="nav-btn1 ub-ver" id='nav-right'>
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
  <div class="ub ub-ac shop-top-glist bg-color-w">
    <div class="ub ub-ac ub-pc sort ub-f1" sort="goods_id" order="<?php if ($this->_var['pager']['sort'] == 'goods_id'): ?><?php echo $this->_var['pager']['order']; ?><?php else: ?>ASC<?php endif; ?>">
      <div class="ulev-1 <?php if ($this->_var['pager']['sort'] == 'goods_id'): ?>f-color-red<?php endif; ?>"> 上架 </div>
      <div class="ub-img uwh-bus1 t-bus-icon m-l3 <?php if ($this->_var['pager']['sort'] == 'goods_id'): ?><?php echo $this->_var['pager']['order']; ?><?php endif; ?>"></div>
    </div>
    <div class="ub ub-ac ub-pc sort ub-f1" sort="salenum" order="<?php if ($this->_var['pager']['sort'] == 'salenum'): ?><?php echo $this->_var['pager']['order']; ?><?php else: ?>ASC<?php endif; ?>">
      <div class="ulev-1 <?php if ($this->_var['pager']['sort'] == 'salenum'): ?>f-color-red<?php endif; ?>"> 销量 </div>
      <div class="ub-img uwh-bus1 t-bus-icon m-l3 <?php if ($this->_var['pager']['sort'] == 'salenum'): ?><?php echo $this->_var['pager']['order']; ?><?php endif; ?>"></div>
    </div>
	<div class="ub ub-ac ub-pc sort ub-f1" sort="goods_price" order="<?php if ($this->_var['pager']['sort'] == 'goods_price'): ?><?php echo $this->_var['pager']['order']; ?><?php else: ?>ASC<?php endif; ?>">
      <div class="ulev-1 <?php if ($this->_var['pager']['sort'] == 'goods_price'): ?>f-color-red<?php endif; ?>"> 价格 </div>
      <div class="ub-img uwh-bus1 t-bus-icon m-l3 <?php if ($this->_var['pager']['sort'] == 'goods_price'): ?><?php echo $this->_var['pager']['order']; ?><?php endif; ?>"></div>
    </div>
	<div class="ub ub-ac ub-pc sort ub-f1" sort="last_update" order="<?php if ($this->_var['pager']['sort'] == 'last_update'): ?><?php echo $this->_var['pager']['order']; ?><?php else: ?>ASC<?php endif; ?>">
      <div class="ulev-1 <?php if ($this->_var['pager']['sort'] == 'last_update'): ?>f-color-red<?php endif; ?>"> 更新 </div>
      <div class="ub-img uwh-bus1 t-bus-icon m-l3 <?php if ($this->_var['pager']['sort'] == 'last_update'): ?><?php echo $this->_var['pager']['order']; ?><?php endif; ?>"></div>
    </div>
	<div class="ub ub-ac ub-pc sort ub-f1" sort="click_count" order="<?php if ($this->_var['pager']['sort'] == 'click_count'): ?><?php echo $this->_var['pager']['order']; ?><?php else: ?>ASC<?php endif; ?>">
      <div class="ulev-1 <?php if ($this->_var['pager']['sort'] == 'click_count'): ?>f-color-red<?php endif; ?>"> 人气 </div>
      <div class="ub-img uwh-bus1 t-bus-icon m-l3 <?php if ($this->_var['pager']['sort'] == 'click_count'): ?><?php echo $this->_var['pager']['order']; ?><?php endif; ?>"></div>
    </div>
    <div class="ub ub-ac ub-pc ubl border-hui ub-f1 _list_style" id="change-list">
      <div class="ub-img top-r-glist2 top-r-size" id="style_button"></div>
    </div>
  </div>
</div>
<div class="goodlist-b ios-top" id="goods_list_container" style="height:100%;overflow-y:scroll"> <?php endif; ?> 
  <?php echo $this->fetch('library/goods_list.lib'); ?>
  <?php if ($this->_var['is_full_page'] == 1): ?> </div>
<div id='scroll_to_top' class="ub-img"></div>
<div id="go_to_cart" class="ub-img">
<div class="num ub ub-ac ub-pc">
<div id='cart_num' class="ulev-2 f-color-red"><?php echo empty($this->_var['cart_num']) ? '0' : $this->_var['cart_num']; ?></div>
</div>
</div>
<?php endif; ?>