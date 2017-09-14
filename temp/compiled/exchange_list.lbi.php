<div class="w mt15">
  <form method="GET" class="sort" name="listform">
    <div id="filter">
      <div class='fore1' style="border:none;">
        <dl class='order'>
          <dt><?php echo $this->_var['lang']['goods_list']; ?>：</dt>
          <dd  class=<?php if ($this->_var['pager']['search']['sort'] == 'goods_id'): ?>curr<?php endif; ?>><a href="exchange.php?<?php $_from = $this->_var['pager']['search']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?><?php if ($this->_var['key'] != "sort" && $this->_var['key'] != "order"): ?><?php echo $this->_var['key']; ?>=<?php echo $this->_var['item']; ?>&<?php endif; ?><?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>page=<?php echo $this->_var['pager']['page']; ?>&sort=goods_id&order=<?php if ($this->_var['pager']['search']['order'] == 'DESC'): ?>ASC<?php else: ?>DESC<?php endif; ?>#list">上架</a><b></b></dd>
          <dd  class=<?php if ($this->_var['pager']['search']['sort'] == 'exchange_integral'): ?>curr<?php endif; ?>><a href="exchange.php?display=<?php echo $this->_var['pager']['display']; ?>&brand=<?php echo $this->_var['brand_id']; ?>&price_min=<?php echo $this->_var['price_min']; ?>&price_max=<?php echo $this->_var['price_max']; ?>&filter_attr=<?php echo $this->_var['filter_attr']; ?>&page=<?php echo $this->_var['pager']['page']; ?>&sort=exchange_integral&order=<?php if ($this->_var['pager']['sort'] == 'exchange_integral' && $this->_var['pager']['order'] == 'DESC'): ?>ASC<?php else: ?>DESC<?php endif; ?>#goods_list">积分</a><b></b></dd>
          <dd class=<?php if ($this->_var['pager']['search']['sort'] == 'last_update'): ?>curr<?php endif; ?>><a href="exchange.php?<?php $_from = $this->_var['pager']['search']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?><?php if ($this->_var['key'] != "sort" && $this->_var['key'] != "order"): ?><?php echo $this->_var['key']; ?>=<?php echo $this->_var['item']; ?>&<?php endif; ?><?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>page=<?php echo $this->_var['pager']['page']; ?>&sort=last_update&order=<?php if ($this->_var['pager']['search']['order'] == 'DESC'): ?>ASC<?php else: ?>DESC<?php endif; ?>#list">更新</a><b></b></dd>
          <dd class=<?php if ($this->_var['pager']['search']['sort'] == 'click_count'): ?>curr<?php endif; ?>><A 
  href="exchange.php?category=<?php echo $this->_var['category']; ?>&display=<?php echo $this->_var['pager']['display']; ?>&brand=<?php echo $this->_var['brand_id']; ?>&price_min=<?php echo $this->_var['price_min']; ?>&price_max=<?php echo $this->_var['price_max']; ?>&filter_attr=<?php echo $this->_var['filter_attr']; ?>&page=<?php echo $this->_var['pager']['page']; ?>&sort=click_count&order=<?php if ($this->_var['pager']['sort'] == 'click_count' && $this->_var['pager']['order'] == 'DESC'): ?>ASC<?php else: ?>DESC<?php endif; ?>#goods_list" >人气</a><b></b></dd>
        </dl>
        <div class='pagin pagin-m'><span class='text'><?php echo $this->_var['pager']['page']; ?>/<?php echo $this->_var['pager']['page_count']; ?></span><?php if ($this->_var['pager']['page_prev']): ?> 
          <a href="<?php echo $this->_var['pager']['page_prev']; ?>" class="prev" >上一页<b></b></a> 
          <?php else: ?> 
          <span class="prev-disabled">上一页<b></b></span> 
          <?php endif; ?> 
          <?php if ($this->_var['pager']['page_next']): ?> 
          <a href="<?php echo $this->_var['pager']['page_next']; ?>" class="next" >下一页<b></b></a> 
          <?php else: ?> 
          <span class="next-disabled">下一页<b></b></span> 
          <?php endif; ?></div>
        <div class='total'><span>共<strong><?php echo $this->_var['pager']['record_count']; ?></strong>个商品</span></div>
        <span class='clr'></span></div>
    </div>
  </form>
</div>
<div class="w mt15">
<div class="act-list">
    <form name="compareForm" method="post">
      <ul class="clearfix">
        <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods_0_69693000_1505113751');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['goods_0_69693000_1505113751']):
        $this->_foreach['goods']['iteration']++;
?> 
        <?php if ($this->_var['goods_0_69693000_1505113751']['goods_id']): ?>
        <li <?php if ($this->_foreach['goods']['iteration'] % 4 == 1): ?>class="first"<?php endif; ?>>
            <div class="img">
                <a href='<?php echo $this->_var['goods_0_69693000_1505113751']['url']; ?>' target="_blank" title="<?php echo htmlspecialchars($this->_var['goods_0_69693000_1505113751']['goods_name']); ?>"><img  src='<?php echo $this->_var['goods_0_69693000_1505113751']['goods_thumb']; ?>' width="200" height="200" alt='<?php echo htmlspecialchars($this->_var['goods_0_69693000_1505113751']['name']); ?>' /></a>
                <p class="absBg"></p>
                <p class="absFg"><a href='<?php echo $this->_var['goods_0_69693000_1505113751']['url']; ?>' target="_blank" title="<?php echo htmlspecialchars($this->_var['goods_0_69693000_1505113751']['goods_name']); ?>"><?php echo $this->_var['goods_0_69693000_1505113751']['goods_name']; ?></a></p>
            </div>
            <div class="info">
                <div class="price"><strong class="red arial"><?php echo $this->_var['goods_0_69693000_1505113751']['exchange_integral']; ?></strong><span class="red jifen">积分</span></div>
                <div class="discount"><span class="f16 yahei"><a href='<?php echo $this->_var['goods_0_69693000_1505113751']['url']; ?>' target="_blank">立即兑换</a></span></div>
            </div>
        </li>
        <?php endif; ?> 
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        
      </ul>
    </form>
    <div class="pager">
    <?php echo $this->fetch('library/pages.lbi'); ?> 
      </div>
  </div>
</div>
<div class="blank5"></div>
