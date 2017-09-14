<?php if ($this->_var['is_full_page'] == 1): ?>
<div class="bg-color-w">
  <ul class="f-color-6 " id="article_list">
<?php endif; ?>
    <?php $_from = $this->_var['artciles_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'article');if (count($_from)):
    foreach ($_from AS $this->_var['article']):
?>
    <li class="ubb ub border-faxian bc-text ub-ac lis article article_p2" article_id='<?php echo $this->_var['article']['id']; ?>'>
      <div class="lv_title ub-f1 ub ulev-9 ub-ver ut-m"><?php echo $this->_var['article']['short_title']; ?></div>
      <div class="fa fa-angle-right ulev2 sc-text"></div>
    </li>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
<?php if ($this->_var['is_full_page'] == 1): ?>
  </ul>
</div>
<?php endif; ?>
