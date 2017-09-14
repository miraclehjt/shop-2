<li>
            <a href="<?php echo $this->_var['goods']['url']; ?>" title="<?php echo htmlspecialchars($this->_var['goods']['name']); ?>">
            <div class="index_pro">
              <div class="products_kuang">
                <img src="<?php echo $this->_var['goods']['thumb']; ?>"></div>
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
