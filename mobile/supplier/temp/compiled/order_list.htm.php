<?php if ($this->_var['full_page'] == 1): ?>
<!DOCTYPE HTML>
<html>
  <head>
    <?php echo $this->fetch('html_header.htm'); ?>
	<script src='js/touch.js'></script>
    <script>
      function search_order()
      {
        if(check_form_empty('theForm'))
        {
          $.zalert.add('至少有一项输入不为空！',1)
        }
        else
        {
          $.zcontent.set('order_sn',$('#order_sn').val());
          $.zcontent.set('user_name',$('#user_name').val());
		 
          search();
        }
        return false;
      }
    </script>
  </head>
  <body>
    <div id='container'>
      <?php endif; ?>
      <?php echo $this->fetch('page_header.htm'); ?>
      <section>
        <?php echo $this->fetch('menu_list.htm'); ?>
        <div class="order_con" id="con_order_manage_2" style="display:none">
          <div class="query_stock">
            <div class='order_search'>
              <form name="theForm" class="order_search" onsubmit='return search_order();'>
                <table width="100%" border="0">
                  <tr>
                    <td>
                      <input type="text" name="order_sn" id='order_sn' class="inputBg" placeholder="请输入订单号" <?php if ($this->_var['filter']['order_sn']): ?>value='<?php echo $this->_var['filter']['order_sn']; ?>'<?php endif; ?>/>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <input type="text" name="user_name" id='user_name' class="inputBg" placeholder="请输入买家姓名"  <?php if ($this->_var['filter']['user_name']): ?>value='<?php echo $this->_var['filter']['user_name']; ?>'<?php endif; ?>/>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <input type="submit" class="button2" value="查找"/>
                    </td>
                  </tr>
                </table>
              </form>
            </div>
          </div>
        </div>
        <div class="order_con" id="con_order_manage_1">
		<?php echo $this->fetch('order_status_list.htm'); ?>
		 
          <div class="order_pd"  id="con_type_1">
            <div class="order">
              <ul class="order_list">
                <?php $_from = $this->_var['orders']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'order');if (count($_from)):
    foreach ($_from AS $this->_var['order']):
?>
                <li>
                  <table width="100%" cellpadding="3" cellspacing="1" >
                    <tr>
                      <td align="left">订单号：<a href="order.php?act=info&order_id=<?php echo $this->_var['order']['order_id']; ?>"><?php echo $this->_var['order']['order_sn']; ?></a></td>
                      <td align="right">下单时间：<?php echo $this->_var['order']['short_order_time']; ?></td>
                    </tr>
                    <tr>
                      <td align="left">买家：<?php echo $this->_var['order']['buyer']; ?></td>
                      <td align="right">金额：<?php echo $this->_var['order']['formated_total_fee']; ?></td>
                    </tr>
                    <tr>
                      <td align="left">订单状态：<?php echo $this->_var['lang']['os'][$this->_var['order']['order_status']]; ?>,<?php echo $this->_var['lang']['ps'][$this->_var['order']['pay_status']]; ?>,<?php echo $this->_var['lang']['ss'][$this->_var['order']['shipping_status']]; ?></td>
                      <td align="right"><a href='navigate.php?act=navigate&order_id=<?php echo $this->_var['order']['order_id']; ?>' target='_blank'><img src='images/location.png' style='height:15px;'/></a>&nbsp;&nbsp;<a href="order.php?act=info&order_id=<?php echo $this->_var['order']['order_id']; ?>" class="font" >查看</a></td>
                    </tr>
                  </table>
                </li>
                <?php endforeach; else: ?>
                <li>
                  <div class="no_order" style="">没有找到任何订单！</div>
                </li>
                <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
              </ul>
            </div>
            <?php echo $this->fetch('page.htm'); ?>
          </div>
        </div>
      </section>
      <?php echo $this->fetch('page_footer.htm'); ?>
      <?php if ($this->_var['full_page'] == 1): ?>
    </div>
    <?php echo $this->fetch('static_div.htm'); ?>
  </body>
</html>
<?php endif; ?>

