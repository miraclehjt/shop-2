<?php if ($this->_var['is_full_page'] == 1): ?>

<div id="filter_container" class=" mfp-hide bc-grey">
  <div class="screen bg-color-w p-l-r2" style="position:relative; padding-bottom:3.5em; padding-top:0.8em; overflow-y:scroll; height:90%">
      <?php $_from = $this->_var['promote_category']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');$this->_foreach['promote_category'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['promote_category']['total'] > 0):
    foreach ($_from AS $this->_var['cat']):
        $this->_foreach['promote_category']['iteration']++;
?>
        <div class="screen_name2 f-color-zi icon-up ubt border-faixan _fold expand" fold_key="category_<?php echo $this->_foreach['promote_category']['iteration']; ?>"><?php echo $this->_var['cat']['name']; ?></div>
        <div class="screen_name3_div" id="category_<?php echo $this->_foreach['promote_category']['iteration']; ?>">
          <div class="screen_name3 f-color-6  _checkbox" radio="true" value='<?php echo $this->_var['cat']['id']; ?>' name='category' id="cat_<?php echo $this->_var['cat']['id']; ?>">全部</div>
          <?php $_from = $this->_var['cat']['cat_id']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'child');if (count($_from)):
    foreach ($_from AS $this->_var['child']):
?>
          <div class="screen_name3 f-color-6  _checkbox" radio="true" value='<?php echo $this->_var['child']['id']; ?>' name='category' id="cat_<?php echo $this->_var['child']['id']; ?>"><?php echo $this->_var['child']['name']; ?></div>
          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
          <div class="clear1"></div>
        </div>
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
  <div class="screen_btm p-fixed-btm ub ubt border-hui yy-top">
      <div class="ub-f1"></div>
      <div class="ub-pe btn-red1 ub ub-ac" id='confirm_select_button'>
        <div>完成</div>
      </div>
    </div>
</div>
</div>
<div class="p-fixed">
  <div class="ub ub-ac top-glist bg-color-w f-color-zi ubb border-hui p-t-b4">
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
	<div class="ub ub-ac ub-pc sort ub-f1" sort="zhekou" order="<?php if ($this->_var['pager']['sort'] == 'zhekou'): ?><?php echo $this->_var['pager']['order']; ?><?php else: ?>ASC<?php endif; ?>">
      <div class="ulev-1 <?php if ($this->_var['pager']['sort'] == 'zhekou'): ?>f-color-red<?php endif; ?>"> 折扣 </div>
      <div class="ub-img uwh-bus1 t-bus-icon m-l3 <?php if ($this->_var['pager']['sort'] == 'zhekou'): ?><?php echo $this->_var['pager']['order']; ?><?php endif; ?>"></div>
    </div>
    <div class="ub ub-ac ub-pc ubl border-hui ub-f1" id='filter_button'>
      <div class="ulev-1 f-color-6"> 筛选 </div>
    </div>
  </div>
</div>
<div class="m-top7" id='goods_list_container'> 
  <?php endif; ?> 
  <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'goods');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['goods']):
        $this->_foreach['name']['iteration']++;
?> 
  <?php if ($this->_var['goods']['goods_name'] != ''): ?>
  <div class="ub bg-color-w m-btm1 p-all4 ubb border-hui goods" goods_id='<?php echo $this->_var['goods']['goods_id']; ?>'>
    <div class="h-w-9 goods-img"><img src="<?php echo $this->_var['url']; ?><?php echo $this->_var['goods']['goods_thumb']; ?>"/> </div>
    <div class="ub-ver ub-f1 m-l1 goods-img ub">
    	<div class="ub-f1">
      <div class="f-color-zi text-change"> <font class="ulev-1"><?php echo $this->_var['goods']['goods_name']; ?></font> </div>
      <div class="ub ub-ac p-t-b4">
        <div class="duihuak ub-img ub ub-pc">
          <div class="ulev-2 bc-text-head m-top4"> <?php echo $this->_var['goods']['zhekou']; ?>折 </div>
        </div>
        <div class="ulev-0 f-color-red m-l2"> 
          <?php echo $this->_var['goods']['formatted_goods_price']; ?>
        </div>
        <div class="ulev-5 sc-text f-line-through m-l2"> <?php echo $this->_var['goods']['formatted_shop_price']; ?> </div>
      </div>
      </div>
      <div class="ub ub-ac m-top1 ub-ae ubt border-hui p-t1">
        <div class="f-color-6 ulev-1 ub-f1"> 已售<span class="f-color-red"><?php echo $this->_var['goods']['salenum']; ?></span>件 </div>
        <div class="ulev-1 ub-pe ub-ac ub">
          <div class="ub-img h-w-3 pro_time"></div>
          <span class="settime f-color-red" endTime="<?php echo $this->_var['goods']['promote_end_date']; ?>"></span> </div>
      </div>
    </div>
  </div>
  <?php endif; ?> 
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
  <?php if ($this->_var['is_full_page'] == 1): ?> 
</div>
<div id='scroll_to_top' class="ub-img"></div>
<?php endif; ?>