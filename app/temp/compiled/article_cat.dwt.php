<ul class="f-color-6 ">
  <?php $_from = $this->_var['articlecat']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'cat');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['cat']):
?>
  <li class="ubb ub border-faxian article_p2 bg-color-w ub-ac lis article_<?php echo $this->_var['cat']['parent_id']; ?> level_<?php echo $this->_var['cat']['level']; ?> <?php if ($this->_var['cat']['level'] != 0): ?> uhide <?php endif; ?>"  cat_id='<?php echo $this->_var['cat']['cat_id']; ?>' cat_name="<?php echo $this->_var['cat']['cat_name']; ?>"> <?php if ($this->_var['cat']['level'] == 0): ?>
    <div class="lv_title ub-f1 ub ulev-9 ub-ver ut-m  article_cat" ><?php echo $this->_var['cat']['cat_name']; ?></div>
    <?php else: ?>
    <div class="lv_title ub-f1 ub ulev-9 ub-ver ut-m  article_cat" style="padding-left:<?php echo $this->_var['cat']['level']; ?>em" ><?php echo $this->_var['cat']['cat_name']; ?></div>
    <?php endif; ?>
    <?php if ($this->_var['cat']['has_children'] > 0): ?>
    <div class="fa fa-angle-right ulev2 article_p2 sc-text article_toggle"></div>
    <?php endif; ?> </li>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</ul>
