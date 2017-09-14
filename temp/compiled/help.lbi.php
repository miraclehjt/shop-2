<?php if ($this->_var['helps']): ?>
<div class="site-footer" style="border-top:1px solid #dfdfdf">
  <div class="wrapper">
<div class="footer-links clearfix"> 
      <?php $_from = $this->_var['helps']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'help_cat');$this->_foreach['no'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['no']['total'] > 0):
    foreach ($_from AS $this->_var['help_cat']):
        $this->_foreach['no']['iteration']++;
?>
      <dl class="col-links <?php if (($this->_foreach['no']['iteration'] <= 1)): ?>col-links-first<?php endif; ?>">
        <dt><?php echo $this->_var['help_cat']['cat_name']; ?></dt>
        <?php $_from = $this->_var['help_cat']['article']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
        <dd><a rel="nofollow" href="help.php?id=<?php echo $this->_var['item']['article_id']; ?>" target="_blank"><?php echo $this->_var['item']['short_title']; ?></a></dd>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      </dl>
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      <div class="col-contact">
        <p class="phone">400-888-8888</p>
        <p>周一至周五 9:00-17:30<br>
          （仅收市话费）</p>
        <a rel="nofollow" class="btn2 btn-primary btn-small" href="javascript:void(0);" style="color:#fff">24小时在线客服</a> </div>
    </div>
  </div>
</div>
<?php endif; ?>