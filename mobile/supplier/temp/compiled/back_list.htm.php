<?php if ($this->_var['full_page'] == 1): ?>
<!DOCTYPE html>
<html>
  <head>
    <?php echo $this->fetch('html_header.htm'); ?>
    <script>
      function change_order_type(order_type)
      {
        $.zcontent.set('order_type',order_type);
        search();
      }
      
      function change_back_type(back_type)
      {
        if(back_type == $.zcontent.get('back_type'))
        {
          $.zcontent.set('back_type','');
        }
        else
        {
          $.zcontent.set('back_type',back_type);
        }
        search();
      }
      function search_back_order()
      {
        if(check_form_empty('theForm'))
        {
          $.zalert.add('至少有一项输入不为空！',1)
        }
        else
        {
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
            <form name="theForm" method="" action="" class="order_search" onsubmit='return search_back_order();return false;'>
              <table width="100%" border="0">
                <tr>
                  <td>
                    <input type="text" name="order_sn" id='order_sn' class="inputBg" placeholder="请输入订单号" <?php if ($this->_var['filter']['order_sn']): ?>value='<?php echo $this->_var['filter']['order_sn']; ?>'<?php endif; ?>/>
                  </td>
                </tr>
                <tr>
                  <td>
                    <input type="text" name="consignee" id='consignee' class="inputBg" placeholder="请输入申请人姓名" <?php if ($this->_var['filter']['consignee']): ?>value='<?php echo $this->_var['filter']['consignee']; ?>'<?php endif; ?>/>
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
      <div class="order_con" id="con_order_manage_1">
        <ul class="back_list_type">
          <li <?php if (! $this->_var['filter']['order_type'] || $this->_var['filter']['order_type'] == ''): ?>class="curr"<?php endif; ?> id="type1" onclick="change_order_type('')">全部</li>
          <li <?php if ($this->_var['filter']['order_type'] == '2'): ?>class="curr"<?php endif; ?>id="type2" onclick="change_order_type('2')">未完成</li>
          <li <?php if ($this->_var['filter']['order_type'] == '3'): ?>class="curr"<?php endif; ?> id="type3" onclick="change_order_type('3')">已完成</li>
        </ul>
        <ul class="back_list_type row2">
          <li <?php if ($this->_var['filter']['back_type'] == $this->_var['back_type_goods']): ?>class="curr"<?php endif; ?> id="type4" onclick="change_back_type('<?php echo $this->_var['back_type_goods']; ?>')">退货</li>
          <li <?php if ($this->_var['filter']['back_type'] == $this->_var['back_type_money']): ?>class="curr"<?php endif; ?>id="type5" onclick="change_back_type('<?php echo $this->_var['back_type_money']; ?>')">退款</li>
          <li <?php if ($this->_var['filter']['back_type'] == $this->_var['back_type_repair']): ?>class="curr"<?php endif; ?> id="type6" onclick="change_back_type('<?php echo $this->_var['back_type_repair']; ?>')">返修</li>
        </ul>
		
        <div class="order_pd" id="con_type_1">
          <div class="order">
            <ul class="order_list">
              <?php $_from = $this->_var['back_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'back_order');if (count($_from)):
    foreach ($_from AS $this->_var['back_order']):
?>
              <li>
                <table width="100%" cellpadding="3" cellspacing="1" >
                  <tr>
                    <td align="left">申请人：<?php echo $this->_var['back_order']['consignee']; ?></td>
                    <td align="right" colspan="2"><?php echo $this->_var['back_order']['add_time']; ?></td>
                  </tr>
                  <tr>
                    <td colspan="3" align="left">ID：<?php echo $this->_var['back_order']['goods_id']; ?>&nbsp;&nbsp;<?php if ($this->_var['back_order']['brand_name']): ?>[<?php echo $this->_var['back_order']['brand_name']; ?>]<?php endif; ?><?php echo $this->_var['back_order']['goods_name']; ?></td>
                  </tr>
                  <tr>
                    <td colspan="3" align="left">当前状态：<?php echo $this->_var['back_order']['status_back_val']; ?></td>
                  </tr>
                  <tr>
                    <td align="left">应退：<?php echo $this->_var['back_order']['refund_money_1']; ?></td>
                    <td align="left">实退：<?php echo $this->_var['back_order']['refund_money_2']; ?></td>
                    <td align="right"><a href="back.php?act=back_info&back_id=<?php echo $this->_var['back_order']['back_id']; ?>" class="font">查看</a><a href="back.php?act=remove_back&back_id=<?php echo $this->_var['back_order']['back_id']; ?>" class="font font1">移除</a></td>
                  </tr>
                </table>
              </li>
              <?php endforeach; else: ?>
              <li><div class="no_order" style="">您还没有任何退换货订单哦！</div></li>
              <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </ul>
          </div>
          <?php echo $this->fetch('page.htm'); ?>
        </div>
    </section>
    <?php echo $this->fetch('page_footer.htm'); ?>
    <?php if ($this->_var['full_page'] == 1): ?>
    </div>
    <?php echo $this->fetch('static_div.htm'); ?>
  </body>
</html>
<?php endif; ?>

