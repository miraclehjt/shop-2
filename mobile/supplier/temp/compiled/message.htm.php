<!DOCTYPE HTML>
<html>
  <head>
    <?php echo $this->fetch('html_header.htm'); ?>
    <?php if ($this->_var['auto_redirect']): ?>
    <script>
      var _wap_auto_redir_seconds = '3';
      var _wap_auto_redir_url = '<?php echo $this->_var['default_url']; ?>';
    
      Zepto(function($){
        window.setInterval(start_redir, 1000);
      })

      function start_redir()
      {
        if (_wap_auto_redir_seconds <= 0)
        {
          window.clearInterval();
          return;
        }

        _wap_auto_redir_seconds --;

        $('#_wap_auto_redir_span').html(_wap_auto_redir_seconds);

        if (_wap_auto_redir_seconds == 0)
        {
          location.href = _wap_auto_redir_url;
          window.clearInterval();
        }
      }
    </script>
    <?php endif; ?>
  </head>
  <body>
  <?php echo $this->fetch('page_header.htm'); ?>
  <section>
  	<div class="msg">
    <?php if ($this->_var['msg_type'] == 0): ?>
    <p><img src='images/sys_normal_msg_icon.png'/></p>
    <?php elseif ($this->_var['msg_type'] == 1): ?>
    <p><img src='images/sys_error_msg_icon.png'/></p>
    <?php elseif ($this->_var['msg_type'] == 2): ?>
    <p><img src='images/sys_question_msg_icon.png'/></p>
    <?php endif; ?>
    <p class="msg_detail"><?php echo $this->_var['msg_detail']; ?></p>
    <?php if ($this->_var['auto_redirect']): ?>
    <p><span id='_wap_auto_redir_span'>3</span>秒后自动跳转</p>
    <?php endif; ?>
    <?php $_from = $this->_var['links']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'link');if (count($_from)):
    foreach ($_from AS $this->_var['link']):
?>
    <p><a href='<?php echo $this->_var['link']['href']; ?>'><?php echo $this->_var['link']['text']; ?></a></p>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </div>
  </section>
  </body>
</html>