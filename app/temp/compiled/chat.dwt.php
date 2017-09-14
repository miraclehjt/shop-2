<div class="bc-blue2 m-top9" id="content_container">
</div>
<div class="ub p-fixed-btm1" style="height:3em;font-size:1em;">
  <div class="ub-f1 uh bc-text-head ub sc-bg maxh ubt ubb border-hui p-l-r2">
    <div class="ub-f1 ub ub-ac uc-a1 bg-color-w m-t-b1">
      <input class="chat-textarea" id="editor" placeholder="请说明您要咨询的问题……" maxlength="256" />
    </div>
    <div class="nav-btn1 ub-ver sc-bg-active uba border-faxian m-t-b1 uc-a1 m-l2" id="btn_send">
      <div class="tx-c ulev-1 f-color-6">发送</div>
    </div>
  </div>
</div>
<script>
<?php if ($this->_var['headimg'] != false): ?>
var headimg = "<?php echo $this->_var['url']; ?><?php echo $this->_var['headimg']; ?>"
<?php else: ?>
var headimg = 'img/user.jpg'
<?php endif; ?>
<?php if ($this->_var['cs_headimg']): ?>
var cs_headimg = "<?php echo $this->_var['url']; ?><?php echo $this->_var['cs_headimg']; ?>"
<?php else: ?>
var cs_headimg = 'img/others_pic.png'
<?php endif; ?>
var fromId = "<?php echo $this->_var['from']; ?>"
var password = "<?php echo $this->_var['password']; ?>"
var toId = "<?php echo $this->_var['to']; ?>"
var username = "<?php echo $this->_var['username']; ?>"
var customername = "<?php echo $this->_var['customername']; ?>"
var chat_goods_id = "<?php echo $this->_var['chat_goods_id']; ?>"
var chat_supp_id = "<?php echo $this->_var['chat_supp_id']; ?>"
var chat_order_id = "<?php echo $this->_var['chat_order_id']; ?>"
var chat_order_sn = "<?php echo $this->_var['chat_order_sn']; ?>"
var system_notice = "<?php echo $this->_var['system_notice']; ?>"
</script>