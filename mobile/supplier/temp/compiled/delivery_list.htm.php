<?php if ($this->_var['full_page'] == 1): ?>
<!DOCTYPE HTML>
<html>
  <head>
    <?php echo $this->fetch('html_header.htm'); ?>
    <script>
      function search_delivery()
      {
        if(check_form_empty('theForm'))
        {
          $.zalert.add('至少有一项输入不为空！',1)
        }
        else
        {
          $.zcontent.set('delivery_sn',$('#delivery_sn').val());
          $.zcontent.set('order_sn',$('#order_sn').val());
          $.zcontent.set('consignee',$('#consignee').val());
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
          <div class="order_pd">
            <div class="order order_t">
              <form name="theForm" method="" action="" class="order_search" onsubmit='search_delivery();return false;'>
                <table width="100%" border="0">
                  <tr>
                    <td>
                      <input type="text" name="delivery_sn" id='delivery_sn' class="inputBg" placeholder="请输入发货单流水号" <?php if ($this->_var['filter']['delivery_sn']): ?>value='<?php echo $this->_var['filter']['delivery_sn']; ?>'<?php endif; ?>/>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <input type="text" name="order_sn" id='order_sn' class="inputBg" placeholder="请输入订单号" <?php if ($this->_var['filter']['order_sn']): ?>value='<?php echo $this->_var['filter']['order_sn']; ?>'<?php endif; ?>//>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <input type="text" name="consignee" id='consignee' class="inputBg" placeholder="请输入收货人" <?php if ($this->_var['filter']['consignee']): ?>value='<?php echo $this->_var['filter']['consignee']; ?>'<?php endif; ?>//>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <input type="submit" name="" class="button2" value="查找"/>
                    </td>
                  </tr>
                </table>
              </form>
            </div>
          </div>
        </div>
        <div class="order_con order_con1" id="con_order_manage_1">
		<?php echo $this->fetch('store_menu.htm'); ?>
          <div class="order_pd">
            <div class="order">
              <ul class="order_list">
                <?php $_from = $this->_var['delivery_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'delivery');if (count($_from)):
    foreach ($_from AS $this->_var['delivery']):
?>
                <li>
                  <table width="100%" cellpadding="3" cellspacing="1" >
                    <tr>
                      <td colspan="2" align="left">发货单流水号：<?php echo $this->_var['delivery']['delivery_sn']; ?></td>
                    </tr>
                    <tr>
                      <td align="left">订单号：<?php echo $this->_var['delivery']['order_sn']; ?></td>
                      <td align="right">收货人：<?php echo $this->_var['delivery']['consignee']; ?></td>
                    </tr>
                    <tr>
                      <td colspan="2" align="left">下单时间：<?php echo $this->_var['delivery']['add_time']; ?></td>
                    </tr>
                    <tr>
                      <td colspan="2" align="left">发货时间：<?php echo $this->_var['delivery']['update_time']; ?></td>
                    </tr>
                    <tr>
                      <td align="left">发货状态：<?php echo $this->_var['delivery']['status_name']; ?></td>
                      <td align="right">
                        <a href="order.php?act=delivery_info&delivery_id=<?php echo $this->_var['delivery']['delivery_id']; ?>" class="font">查看</a>
                        <a href="order.php?act=remove_delivery&delivery_id=<?php echo $this->_var['delivery']['delivery_id']; ?>" class="font font1">移除</a>
                      </td>
                    </tr>
                  </table>
                </li>
                <?php endforeach; else: ?>
                <li><div class="no_order">没有找到任何发货单！</div></li>
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