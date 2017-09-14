<?php if ($this->_var['is_full_page'] == 1): ?>
<div id='content_container'> <?php endif; ?> 
  <?php $_from = $this->_var['message_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'message');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['message']):
?>
  <div class="bg-color-w ubb ubt border-faxian m-btm1 message" message_id='<?php echo $this->_var['key']; ?>' order_id="<?php echo $this->_var['message']['order_id']; ?>">
    <div class="ub p-all3">
      <div class="ub-f1 ub ub-ac">
        <div class="ulev-9 f-color-6"> <?php echo $this->_var['message']['msg_type']; ?></div>
        <div class="ulev-2 m-l1 sc-text-hui"> <?php echo $this->_var['message']['msg_time']; ?></div>
      </div>
      <div class="ub-pe ub ub-ac delete">
        <div class="ub-img search-icon2 h-w-1"></div>
        <div class="ulev-1 m-l3 f-color-red">删除</div>
      </div>
    </div>
    <div class="bc-grey p-all3">
      <div><font class="ulev-1 sc-text-hui">标题：</font><font class="ulev-1 f-color-zi"><?php echo $this->_var['message']['msg_title']; ?></font></div>
      <div class="m-top2"><font class="ulev-1 sc-text-hui">内容：</font><font class="ulev-1 f-color-zi"><?php echo $this->_var['message']['msg_content']; ?> </font></div>
    </div>
	<?php if ($this->_var['message']['message_img']): ?> 
	<div class="bc-grey p-all3">
	<img class="message_image" style="width:3em;height:3em;" src="<?php echo $this->_var['url']; ?>data/feedbackimg/<?php echo $this->_var['message']['message_img']; ?>" />
	</div>
  <?php endif; ?> 
  <?php if ($this->_var['message']['re_msg_content']): ?>
  <div>
  <div class="ub p-all3">
  <div class="ulev-9 f-color-6"><?php echo $this->_var['lang']['shopman_reply']; ?></div>
	<div class="ulev-2 m-l1 sc-text-hui"><?php echo $this->_var['message']['re_msg_time']; ?></div>
	<?php if ($this->_var['message']['re_user_email']): ?>
	<a style="display:block;width:0.9em;height:0.9em;" href="mailto:<?php echo $this->_var['message']['re_user_email']; ?>" class="m-l1"><img src="img/icons/mail.png" style="width:0.9em;height:0.9em;" /></a>
	<?php endif; ?>
	</div>
  <div class="bc-grey p-all3">
  <font class="ulev-1 sc-text-hui">内容：</font><font class="ulev-1 f-color-zi"><?php echo $this->_var['message']['re_msg_content']; ?></font></div>
  </div>
  <?php endif; ?> 
  </div>
  <?php endforeach; else: ?>
  <div class='no-con'>找不到更多留言</div>
  <?php endif; unset($_from); ?><?php $this->pop_vars();; ?> 
  <?php if ($this->_var['is_full_page'] == 1): ?> 
  </div>
<div id='scroll_to_top' class="ub-img"></div>
<?php endif; ?>