<ul class="order_tab" style="position:relative">
  <li id="order_manage1" class="first" onclick="toggle_menu();"><?php echo $this->_var['ur_here']; ?>
    <i id="menu_list_marker" class='on'></i>
    <ul class="order_type" style="display:none" id='menu_list'>
      <li <?php if ($this->_var['ur_here'] == '订单列表'): ?>class='curr'<?php endif; ?>><a href="order.php?act=list">订单列表</a></li>
      <li <?php if ($this->_var['ur_here'] == '发货单列表'): ?>class='curr'<?php endif; ?>><a href="order.php?act=delivery_list">发货单列表</a></li>
      <li <?php if ($this->_var['ur_here'] == '佣金列表'): ?>class='curr'<?php endif; ?>><a href="supplier_rebate.php?act=list">佣金列表</a></li>
      <li <?php if ($this->_var['ur_here'] == '库存列表'): ?>class='curr'<?php endif; ?>><a href="goods_stock.php?act=list">库存列表</a></li>
      <li <?php if ($this->_var['ur_here'] == '退款/退货/维修订单列表'): ?>class='curr'<?php endif; ?>><a href="back.php?act=back_list">退换货列表</a></li>
    </ul>
  </li>
  <li id="order_manage2" onclick="toggle_search();">查询<i class='search'></i></li>
</ul>