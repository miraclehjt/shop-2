<?php
 $GLOBALS['smarty']->assign('thiscid1',get_wap_parent_id_tree($GLOBALS['smarty']->_var['goods_cat']['id']));
?>
<section class="index_floor_lou">
    <div class="floor_body ">
        <h2>
            <em></em><?php echo htmlspecialchars($this->_var['goods_cat']['name']); ?><div class="geng"><a href="<?php echo $this->_var['goods_cat']['url']; ?>" >更多</a> <span></span></div>
         </h2>
        <ul>
            <?php $_from = $this->_var['cat_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods_0_96515700_1505210454');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['goods_0_96515700_1505210454']):
        $this->_foreach['name']['iteration']++;
?>
            <li>
                <a href="<?php echo $this->_var['goods_0_96515700_1505210454']['url']; ?>" title="<?php echo htmlspecialchars($this->_var['goods_0_96515700_1505210454']['name']); ?>">
                <div class="index_pro"> 
                    <div class="products_kuang">
                        <img src="<?php echo $this->_var['option']['static_path']; ?><?php echo $this->_var['goods_0_96515700_1505210454']['thumb']; ?>"></div>
                    <div class="goods_name"><?php echo sub_str($this->_var['goods_0_96515700_1505210454']['name'],17); ?></div>
                    <div class="price">
                            <a href="javascript:addToCart(<?php echo $this->_var['goods_0_96515700_1505210454']['id']; ?>)" class="btns">
                            <img src="themesmobile/68ecshopcom_mobile/images/index_flow.png"></a>
                     <span class="price_pro">
                            <?php if ($this->_var['goods_0_96515700_1505210454']['promote_price']): ?><?php echo $this->_var['goods_0_96515700_1505210454']['promote_price']; ?><?php else: ?><?php echo $this->_var['goods_0_96515700_1505210454']['shop_price']; ?><?php endif; ?>
                        </span>
                    </div>
                    </div>
                </a>
            </li>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </ul>
    </div>
</section>




