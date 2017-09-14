<?php if ($this->_var['action'] == 'message_list'): ?>
<div class="liuyan">
    <div class="liuyan_list">
     <?php if ($this->_var['message_list']): ?>		
      <?php $_from = $this->_var['message_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'message');$this->_foreach['message_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['message_list']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['message']):
        $this->_foreach['message_list']['iteration']++;
?>
      <dl>
        <dt><span class="title"><?php echo $this->_var['message']['msg_type']; ?></span><?php echo $this->_var['message']['msg_title']; ?></dt>
        <dd><?php echo $this->_var['item']['total_fee']; ?></dd>
        
        <dd><span><?php echo $this->_var['message']['msg_content']; ?><?php if ($this->_var['message']['message_img']): ?><a href="data/feedbackimg/<?php echo $this->_var['message']['message_img']; ?>" target="_bank"><?php echo $this->_var['lang']['view_upload_file']; ?></a><?php endif; ?></span> <font><?php echo $this->_var['item']['handler']; ?></font></dd>
        <span class="liuyan_time"><?php echo $this->_var['message']['msg_time']; ?></span>
        <?php if ($this->_var['message']['re_msg_content']): ?>
        <dt style=" margin-top:5px;"><span class="price"><?php echo $this->_var['lang']['shopman_reply']; ?></span></dt>
        <dd><span style="color:#F60"><?php echo $this->_var['message']['re_msg_content']; ?></span></dd>
        <span class="liuyan_time"><?php echo $this->_var['message']['re_msg_time']; ?></span>
        <?php endif; ?>
         
      </dl>
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      <?php echo $this->fetch('library/pages.lbi'); ?>
      
      <?php else: ?>
      <div id="list_0_0" class="font12"><?php echo $this->_var['lang']['message_empty']; ?></div>
      <?php endif; ?>
      </div>
     <div class="liuyandom"> 

      <section class="innercontent1">
        <form action="user.php" method="post" enctype="multipart/form-data" name="formMsg" onSubmit="return submitMsg()">
          <?php if ($this->_var['order_info']): ?>
            <div class="form_search"> <?php echo $this->_var['lang']['message_type']; ?>：<a href ="<?php echo $this->_var['order_info']['url']; ?>"><?php echo $this->_var['order_info']['order_sn']; ?></a>
              <input type="hidden" name="msg_type" value="5">
              <input type="hidden" name="order_id" value="<?php echo $this->_var['order_info']['order_id']; ?>">
            </div>
          <?php else: ?>
          <div>
            <div class="form_search"><span><?php echo $this->_var['lang']['message_type']; ?>：</span>
            <div class="anniu">
            <ul>
            <li class="on">
              <label for="msg_type0">
                <input type="radio" name="msg_type" value="0" checked="checked" class="radio" id="msg_type0">
                <?php echo $this->_var['lang']['type']['0']; ?></label>
                </li>
                <li>
              <label for="msg_type1">
                <input type="radio" name="msg_type" value="1" class="radio" id="msg_type1">
                <?php echo $this->_var['lang']['type']['1']; ?></label>
                </li>
                <li>
              <label for="msg_type2">
                <input type="radio" name="msg_type" value="2" class="radio" id="msg_type2">
                <?php echo $this->_var['lang']['type']['2']; ?></label>
                </li>
                <li>
              <label for="msg_type3">
                <input type="radio" name="msg_type" value="3" class="radio" id="msg_type3">
                <?php echo $this->_var['lang']['type']['3']; ?></label>
                </li>
                <li>
              <label for="msg_type4">
                <input type="radio" name="msg_type" value="4" class="radio" id="msg_type4">
                <?php echo $this->_var['lang']['type']['4']; ?></label>
                </li>
                </ul>
                </div>
            </div>
          </div>
          <?php endif; ?>
          <label for="msg_title">
          <div class="field_else">
          <span>留言主题：</span>
              <input type="text" name="msg_title" id="msg_title" placeholder="*<?php echo $this->_var['lang']['message_title']; ?>"/>
          </div>
          </label>
          <div class="field_else">
              <label for="msg_content"> 
              <span><?php echo $this->_var['lang']['message_content']; ?>：</span>
               <textarea name="msg_content" id="msg_content" style="height:100px;"></textarea>
              </label>
          </div>
          <div style=" padding-bottom:10px;">
            <input type="submit" value="<?php echo $this->_var['lang']['submit_message']; ?>" class="btn_big1"/>
          </div>
          <input type="hidden" name="act" value="act_add_message">
        </form>
      </section>
      </div>
</div>
<?php endif; ?>

    <script>
    $('.anniu ul li').click(function(){
	$(this).find("input").attr("checked","checked");
	$('.anniu ul li').removeClass("on");
	$(this).addClass("on");
	})
    </script>