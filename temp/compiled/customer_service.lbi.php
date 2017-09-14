<div class="customer_service">
  <dl class="sidebar_subdl">
    
    <dd id="qqdd"> <img src="themes/68ecshopcom_360buy/images/chat/web_logo.png" width="30" height="29"/> <a style="color:#000000; font-size:14px; margin-left:10px; vertical-align:middle" target="_self" href="javascript:chat_online();" 
                                alt="点击这里给我发消息" title="点击这里给我发消息">在线客服</a> </dd>
    <?php $_from = $this->_var['customer']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'customer_0_73429800_1505113128');$this->_foreach['customer'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['customer']['total'] > 0):
    foreach ($_from AS $this->_var['customer_0_73429800_1505113128']):
        $this->_foreach['customer']['iteration']++;
?>
      <?php if ($this->_var['customer_0_73429800_1505113128']['cus_type'] == 0): ?>
          <dd id="qqdd"> <img src="themes/68ecshopcom_360buy/images/qq1.gif" width="30" height="29"/> <a style="color:#000000; font-size:14px; margin-left:10px;" target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $this->_var['customer_0_73429800_1505113128']['cus_no']; ?>&site=qq&menu=yes" 
                                alt="点击这里给我发消息" title="点击这里给我发消息"><?php echo $this->_var['customer_0_73429800_1505113128']['cus_name']; ?></a> </dd>
      <?php else: ?>
          <dd id="qqdd"> <img src="themes/68ecshopcom_360buy/images/ww1.gif" width="30" height="29"/> <a style="color:#000000; font-size:14px; margin-left:10px;" target="_blank" href="http://amos1.taobao.com/msg.ww?v=2&uid=<?php echo $this->_var['customer_0_73429800_1505113128']['cus_no']; ?>&s=2" 
                                alt="点击这里给我发消息" title="点击这里给我发消息"><?php echo $this->_var['customer_0_73429800_1505113128']['cus_name']; ?></a> </dd>
      <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  </dl>
  <div class="clearbox"></div>
</div>
