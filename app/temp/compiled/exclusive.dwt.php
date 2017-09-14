<?php if ($this->_var['is_full_page'] == 1): ?>
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
	<div class="ub ub-ac ub-pc sort ub-f1" sort="click_count" order="<?php if ($this->_var['pager']['sort'] == 'click_count'): ?><?php echo $this->_var['pager']['order']; ?><?php else: ?>ASC<?php endif; ?>">
      <div class="ulev-1 <?php if ($this->_var['pager']['sort'] == 'click_count'): ?>f-color-red<?php endif; ?>"> 人气 </div>
      <div class="ub-img uwh-bus1 t-bus-icon m-l3 <?php if ($this->_var['pager']['sort'] == 'click_count'): ?><?php echo $this->_var['pager']['order']; ?><?php endif; ?>"></div>
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
        <div class="ulev-0 f-color-red m-l2"> 
          <?php echo $this->_var['goods']['formatted_goods_price']; ?>
        </div>
        <div class="ulev-5 sc-text f-line-through m-l2"> <?php echo $this->_var['goods']['formatted_shop_price']; ?> </div>
      </div>
      </div>
      <div class="ub ub-ac m-top1 ub-ae ubt border-hui p-t1">
        <div class="f-color-6 ulev-1 ub-f1"> 已售<span class="f-color-red"><?php echo $this->_var['goods']['salenum']; ?></span>件 </div>
      </div>
    </div>
  </div>
  <?php endif; ?> 
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
  <?php if ($this->_var['is_full_page'] == 1): ?> 
</div>
<div id='scroll_to_top' class="ub-img"></div>
<?php endif; ?>