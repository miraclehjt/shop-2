<?php if ($this->_var['best_goods']): ?>
<section class="index_floor">
  <div class="floor_body1">
    <h2><em></em><?php echo $this->_var['lang']['best_goods']; ?><div class="geng"> <a href="search.php?intro=best" >更多</a> <span></span></div></h2>
    <div id="scroll_best" class="scroll_hot">
      <div class="bd">
        <ul>
          <?php $_from = $this->_var['best_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['best_goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['best_goods']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['best_goods']['iteration']++;
?>
          <li >
            <a href="<?php echo $this->_var['goods']['url']; ?>" title="<?php echo htmlspecialchars($this->_var['goods']['name']); ?>">
             <div class="index_pro"> 
              <div class="products_kuang">
                <img src="<?php echo $this->_var['option']['static_path']; ?><?php echo $this->_var['goods']['thumb']; ?>"></div>
              <div class="goods_name"><?php echo $this->_var['goods']['name']; ?></div>
              <div class="price">
                         <a href="javascript:addToCart(<?php echo $this->_var['goods']['id']; ?>)" class="btns">
                    <img src="themesmobile/68ecshopcom_mobile/images/index_flow.png">
                </a>
              <span href="<?php echo $this->_var['goods']['url']; ?>" class="price_pro"> <?php if ($this->_var['goods']['promote_price']): ?><?php echo $this->_var['goods']['promote_price']; ?><?php else: ?><?php echo $this->_var['goods']['shop_price']; ?><?php endif; ?></span>
      
      
              </div>
              </div>
            </a>
          </li>

          <?php if ($this->_foreach['best_goods']['iteration'] % 3 == 0 && $this->_foreach['best_goods']['iteration'] != $this->_foreach['best_goods']['total']): ?> </ul>
        <ul>
          <?php endif; ?><?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?></div>
        <div class="hd">
          <ul></ul>
        </div>
      </div>
    </div>
  </section>

  <script type="text/javascript">
    TouchSlide({ 
      slideCell:"#scroll_best",
      titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
      effect:"leftLoop", 
      autoPage:true, //自动分页
      //switchLoad:"_src" //切换加载，真实图片路径为"_src" 
    });
  </script>
<?php endif; ?>