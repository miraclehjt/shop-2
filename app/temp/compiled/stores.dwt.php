<?php if ($this->_var['is_full_page'] == 1): ?>
<div id='store_container'> <?php if ($this->_var['has_no_cat'] != 1): ?>
  <div class="ub p-l-r2 bg-color-w m-btm1" style="overflow-x:scroll;">
    <div class="<?php if (! $_REQUEST['id']): ?> selected<?php endif; ?> cat_type ulev-1" cat_id=''> 全部 </div>
    <?php $_from = $this->_var['all']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');if (count($_from)):
    foreach ($_from AS $this->_var['cat']):
?>
    <div class="ulev-1 <?php if ($_REQUEST['id'] == $this->_var['cat']['str_id']): ?>selected<?php endif; ?> cat_type" cat_id="<?php echo $this->_var['cat']['str_id']; ?>"> <?php echo $this->_var['cat']['str_name']; ?> </div>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> </div>
  <?php endif; ?> 
  <?php endif; ?>
  <?php $_from = $this->_var['shops_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'shop');$this->_foreach['shop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['shop']['total'] > 0):
    foreach ($_from AS $this->_var['shop']):
        $this->_foreach['shop']['iteration']++;
?>
  <div class="shop_list bg-color-w ubb border-hui" id='shop_<?php echo $this->_var['shop']['supplier_id']; ?>' supplier_id="<?php echo $this->_var['shop']['supplier_id']; ?>" shop_name='<?php echo $this->_var['shop']['shop_name']; ?>'>
    <ul id="into-shop" class="shop_table">
      <div class="ub ub-pj ub-ac ubb border-faxian p-b1">
        <div class="ub ub-ac ub-pc shop_name">
          <div class="shop_logo goods-img"> <img src="<?php echo $this->_var['url']; ?><?php echo $this->_var['logopath']; ?>logo_supplier<?php echo $this->_var['shop']['supplier_id']; ?>.jpg"/> </div>
          <div class="ulev-9 p-l-r2 bc-text"><?php echo $this->_var['shop']['supplier_title']; ?></div>
        </div>
        <div class="ulev-1 shop_style uc-a1 ub-ac follow_button<?php if ($this->_var['shop']['is_followed'] > 0): ?> followed <?php endif; ?>" ><?php if ($this->_var['shop']['is_followed'] > 0): ?>已关注<?php else: ?>未关注<?php endif; ?></div>
      </div>
      <li class='shop_item ub ub-ac ubb border-faxian supplier'>
        <div class='shop_listimg'>
          <div class="h-w-7 goods-img"><img src="<?php echo $this->_var['url']; ?><?php echo $this->_var['shop']['logo']; ?>"/></div>
          <p class='shop_style1 ulev-2 sc-text-hui'>共<span class="f-color-red"><?php echo $this->_var['shop']['goods_number']; ?></span>件商品</p>
        </div>
        <div class="shop_item1">
          <p class="ulev-1 f-color-6 m-btm2">描述相符 ：<span class="f-color-red"> <?php if ($this->_var['shop']['avg_comment'] > 0): ?><?php echo $this->_var['shop']['avg_comment']; ?><?php else: ?>5<?php endif; ?></span></p>
          <p class="ulev-1 f-color-6 m-btm2">服务态度 ：<span class="f-color-red"> <?php if ($this->_var['shop']['avg_comment'] > 0): ?><?php echo $this->_var['shop']['avg_server']; ?><?php else: ?>5<?php endif; ?></span></p>
          <p class="ulev-1 f-color-6 m-btm2">发货速度 ：<span class="f-color-red"> <?php if ($this->_var['shop']['avg_comment'] > 0): ?><?php echo $this->_var['shop']['avg_shipping']; ?><?php else: ?>5<?php endif; ?></span></p>
          <p class='shop_desc ulev-1 f-color-6 umar-t1'>所在地：<?php echo $this->_var['shop']['address']; ?></p>
        </div>
      </li>
      <?php if ($this->_var['shop']['goods_info']): ?>
      <div class='ub' style='overflow-x:scroll;'> <?php $_from = $this->_var['shop']['goods_info']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['goods']['iteration']++;
?>
        <div class="ub ub-ver store-goods goods" goods_id="<?php echo $this->_var['goods']['goods_id']; ?>">
          <div class="ub-fh goods-img"> <img src="<?php echo $this->_var['url']; ?><?php echo $this->_var['goods']['goods_thumb']; ?>"/>
            <div class="ulev-2 shop-moy bc-text-head"><?php echo $this->_var['goods']['shop_p']; ?></div>
          </div>
          <div class="shop-name ulev-4 f-color-6"><?php echo $this->_var['goods']['goods_name']; ?></div>
        </div>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> </div>
      <?php endif; ?>
    </ul>
  </div>
  <?php endforeach; else: ?>
  <div class="no-con">没有更多店铺</div>
  <?php endif; unset($_from); ?><?php $this->pop_vars();; ?> 
  <?php if ($this->_var['is_full_page'] == 1): ?>
</div>
<?php endif; ?>
