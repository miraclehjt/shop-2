<?php if ($this->_var['is_full_page'] == 1): ?> 

<div id="filter_container" class="mfp-hide">
  <div class="screen bg-color-w p-l-r2" style="position:relative; padding-bottom:3.5em; padding-top:0.8em; overflow-y:scroll; height:90%">
  <?php if ($this->_var['brand_list']): ?>
    <div class="screen_name2 f-color-zi _fold <?php if ($_REQUEST['brand'] > 0): ?>expand<?php endif; ?>" fold_key="brand_box">品牌</div>
    <div class="screen_name3_div <?php if ($_REQUEST['brand'] <= 0): ?>uhide<?php endif; ?>" id='brand_box'> 
	<?php $_from = $this->_var['brands']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'brand');$this->_foreach['brands_68ecshop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['brands_68ecshop']['total'] > 0):
    foreach ($_from AS $this->_var['brand']):
        $this->_foreach['brands_68ecshop']['iteration']++;
?>
      <div class="screen_name3 screen_logo _checkbox <?php if ($this->_var['brand']['selected'] > 0): ?>checked<?php endif; ?>" checked="<?php if ($this->_var['brand']['selected'] > 0): ?>true<?php else: ?>false<?php endif; ?>" value="<?php echo $this->_var['brand']['brand_id']; ?>" name="brand" radio="true" cancel="true" id="brand_<?php echo $this->_var['brand']['brand_id']; ?>">
	  <?php if ($this->_var['brand']['brand_logo']): ?> 
	  <img src="<?php echo $this->_var['url']; ?>data/brandlogo/<?php echo $this->_var['brand']['brand_logo']; ?>" /> 
	  <?php else: ?>
      <?php echo $this->_var['brand']['brand_name']; ?> 
      <?php endif; ?> 
	</div>
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      <div class="clear1"></div>
    </div>
	<?php endif; ?>
    <?php $_from = $this->_var['filter_attr_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'filter_attr');$this->_foreach['filter_attr_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['filter_attr_list']['total'] > 0):
    foreach ($_from AS $this->_var['filter_attr']):
        $this->_foreach['filter_attr_list']['iteration']++;
?>
    <div class="screen_name2 f-color-zi icon-up ubt border-faixan _fold" fold_key="filter_box_<?php echo $this->_foreach['filter_attr_list']['iteration']; ?>"> <?php echo htmlspecialchars($this->_var['filter_attr']['filter_attr_name']); ?> </div>
    <div class="screen_name3_div filter_box uhide" id="filter_box_<?php echo $this->_foreach['filter_attr_list']['iteration']; ?>">
	<?php $_from = $this->_var['filter_attr']['attr_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'attr');$this->_foreach['attr_list_68ecshop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['attr_list_68ecshop']['total'] > 0):
    foreach ($_from AS $this->_var['attr']):
        $this->_foreach['attr_list_68ecshop']['iteration']++;
?>
      <?php if ($this->_var['filter_attr']['filter_attr_name'] == '颜色' && $this->_var['attr']['color_code']): ?>
      <div class="screen_name4 f-color-6 _checkbox" radio="true" name="filter_<?php echo $this->_foreach['filter_attr_list']['iteration']; ?>" cancel="true" id="filter_<?php echo $this->_var['attr']['goods_id']; ?>" value="<?php echo $this->_var['attr']['goods_id']; ?>" style='background:#<?php echo $this->_var['attr']['color_code']; ?>;'>&nbsp;</div>
      <?php else: ?>
      <div class="screen_name3 f-color-6 _checkbox" radio="true" name="filter_<?php echo $this->_foreach['filter_attr_list']['iteration']; ?>" cancel="true" id="filter_<?php echo $this->_var['attr']['goods_id']; ?>" value="<?php echo $this->_var['attr']['goods_id']; ?>"><?php echo $this->_var['attr']['attr_value']; ?></div>
      <?php endif; ?>
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> </div>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	<?php if ($_REQUEST['supplier_id'] <= 0): ?>
	<div class="screen_name2 f-color-zi icon-up ubt border-faixan _fold expand" fold_key="supplier">商家</div>
	<div class="screen_name3_div" id="supplier"> 
      <div class="screen_name3 f-color-6 _checkbox <?php if ($_REQUEST['filter'] == 1): ?>checked<?php endif; ?>" <?php if ($_REQUEST['filter'] == 1): ?>checked="true"<?php endif; ?> radio="true" value="1" name="filter" id="filter_1">网站自营</div>
	  <div class="screen_name3 f-color-6 _checkbox <?php if ($_REQUEST['filter'] == 2): ?>checked<?php endif; ?>" <?php if ($_REQUEST['filter'] == 2): ?>checked="true"<?php endif; ?> radio="true" value="2" name="filter" id="filter_2">入驻商店铺</div>
	  </div>
	  <?php endif; ?>
	  <div class="screen_name2 f-color-zi icon-up ubt border-faixan _fold expand" fold_key="stock">库存</div>
	<div class="screen_name3_div" id="stock"> 
      <div class="screen_name3 f-color-6 _checkbox <?php if ($_REQUEST['mystock'] > 0): ?>checked<?php endif; ?>" <?php if ($_REQUEST['mystock'] > 0): ?>checked="true"<?php endif; ?> radio="true" value="1" name="stock" id="stock_1">有货</div>
	  </div>
	  <div class="clear1"></div>
	  <?php if ($this->_var['price_grade']): ?>
	  <div class="screen_name2 f-color-zi icon-up ubt border-faixan _fold expand" fold_key="price">选择价格</div>
	  <div class="screen_name3_div" id="price"> 
	  <?php $_from = $this->_var['price_grade']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'price');$this->_foreach['price'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['price']['total'] > 0):
    foreach ($_from AS $this->_var['price']):
        $this->_foreach['price']['iteration']++;
?>
      <div class="screen_name3 f-color-6 _checkbox <?php if ($this->_var['price']['selected'] == 1): ?>checked<?php endif; ?>" <?php if ($this->_var['price']['selected'] == 1): ?>checked="true"<?php endif; ?> radio="true" value="<?php echo $this->_var['price']['start']; ?>,<?php echo $this->_var['price']['end']; ?>" name="price" id="price_<?php echo $this->_foreach['price']['iteration']; ?>"><?php echo $this->_var['price']['price_range']; ?></div>
	  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	  </div>
	  <?php endif; ?>
	  <div class="screen_name2 f-color-zi ubt border-faixan">输入价格</div>
     <div class="uinput1 ub ub-f1 ub-ac p-l-r3 _checkbox" radio="true" cancel="false" value="input" name="price" id="price_input">
      <input name='price_min' id='price_min' type="text" class="price f-color-6 ub-f1" />
      <div class="m-l-r2">-</div>
      <input name='price_max' id='price_max' type="text" class="price f-color-6 ub-f1"/>
      </div>
    </div>
  <div class="screen_btm p-fixed-btm ub ubt border-hui yy-top">
      <div class="ub-f1"></div>
      <div class="ub-pe btn-red1 ub ub-ac" id='confirm_select_button'>
        <div>完成</div>
      </div>
    </div>
</div>
<div class="p-fixed headroom" id='header' style='height:5.5em;'>
  <div class="uh bc-text-head ub head-h bc-head-glist">
    <div class="nav-btn2 _back" id="nav-left">
      <div class="icon-back1 ub-img"></div>
    </div>
    <div class="ub-f1 ub ub-ac uc-a1 bg-color uinn-ele2 m-t-b1">
      <div class="uwh-ele1 ub-img ele-search"></div>
      <div class="ub-f1 f-color-5f s-input1 uof">
      <form action="" onsubmit="return false;">
        <input type="search" id='search_input' value='<?php echo $this->_var['keywords']; ?>' placeholder="<?php if ($this->_var['input_place_holder']): ?><?php echo $this->_var['input_place_holder']; ?><?php else: ?>搜索商品<?php endif; ?>" class="ulev-9"/>
      </form>
      </div>
    </div>
    <div class="nav-btn1 nav-bt" id='filter_button'>
      <div class="ulev-9 f-color-5f"> 筛选 </div>
    </div>
  </div>
  <div class="ub ub-ac top-glist ubb border-faxian">
    <div class="ub ub-ac ub-pc sort ub-f1" sort='goods_id' order="<?php if ($this->_var['pager']['sort'] == 'goods_id'): ?><?php echo $this->_var['pager']['order']; ?><?php else: ?>ASC<?php endif; ?>">
      <div class="ulev-9 <?php if ($this->_var['pager']['sort'] == 'goods_id'): ?>f-color-red<?php endif; ?>">上架</div>
      <div class="ub-img uwh-bus1 t-bus-icon m-l3 <?php if ($this->_var['pager']['sort'] == 'goods_id'): ?><?php echo $this->_var['pager']['order']; ?><?php endif; ?>"></div>
       </div>
    <div class="ub ub-ac ub-pc sort ub-f1" sort='salenum' order="<?php if ($this->_var['pager']['sort'] == 'salenum'): ?><?php echo $this->_var['pager']['order']; ?><?php else: ?>ASC<?php endif; ?>">
      <div class="ulev-9 <?php if ($this->_var['pager']['sort'] == 'salenum'): ?>f-color-red<?php endif; ?>">销量</div>
      <div class="ub-img uwh-bus1 t-bus-icon m-l3 <?php if ($this->_var['pager']['sort'] == 'salenum'): ?><?php echo $this->_var['pager']['order']; ?><?php endif; ?>"></div>
    </div>
    <div class="ub ub-ac ub-pc ub-pc sort ub-f1" sort='goods_price' order="<?php if ($this->_var['pager']['sort'] == 'goods_price'): ?><?php echo $this->_var['pager']['order']; ?><?php else: ?>ASC<?php endif; ?>">
      <div class="ulev-9 <?php if ($this->_var['pager']['sort'] == 'goods_price'): ?>f-color-red<?php endif; ?>">价格</div>
      <div class="ub-img uwh-bus1 t-bus-icon m-l3 <?php if ($this->_var['pager']['sort'] == 'goods_price'): ?><?php echo $this->_var['pager']['order']; ?><?php endif; ?>"></div>
	  </div>
 <div class="ub ub-ac ub-pc sort ub-f1" sort='last_update' order="<?php if ($this->_var['pager']['sort'] == 'last_update'): ?><?php echo $this->_var['pager']['order']; ?><?php else: ?>ASC<?php endif; ?>">
      <div class="ulev-9 <?php if ($this->_var['pager']['sort'] == 'last_update'): ?>f-color-red<?php endif; ?>">更新</div>
      <div class="ub-img uwh-bus1 t-bus-icon m-l3 <?php if ($this->_var['pager']['sort'] == 'last_update'): ?><?php echo $this->_var['pager']['order']; ?><?php endif; ?>"></div>
       </div>
    <div class="ub ub-ac ub-pc sort ub-f1" sort='click_count' order="<?php if ($this->_var['pager']['sort'] == 'click_count'): ?><?php echo $this->_var['pager']['order']; ?><?php else: ?>ASC<?php endif; ?>">
      <div class="ulev-9 <?php if ($this->_var['pager']['sort'] == 'click_count'): ?>f-color-red<?php endif; ?>">人气</div>
      <div class="ub-img uwh-bus1 t-bus-icon m-l3 <?php if ($this->_var['pager']['sort'] == 'click_count'): ?><?php echo $this->_var['pager']['order']; ?><?php endif; ?>"></div>
    </div>
    <div class="ub ub-ac ub-pc ubl border-hui ub-f1 p-l _list_style" id="change-list">
      <div class="ub-img top-r-glist2 top-r-size" id='style_button'></div>
    </div>
  </div>
</div>
<div class="goodlist-s f-color-6 ios-top" id='goods_list_container'> <?php endif; ?>  
  <?php echo $this->fetch('/library/goods_list.lib'); ?>
  <?php if ($this->_var['is_full_page'] == 1): ?>
  </div>
<div id='scroll_to_top' class="ub-img"></div>
<div id="go_to_cart" class="ub-img">
<div class="num ub ub-ac ub-pc">
<div id='cart_num' class="ulev-2 f-color-red"><?php echo empty($this->_var['cart_num']) ? '0' : $this->_var['cart_num']; ?></div>
</div>
</div>
<?php endif; ?> 