<div class="article-w">
  <div class="t-bla article_p ulev-9 ulh-oa f-color-zi"><?php echo htmlspecialchars($this->_var['article']['title']); ?></div>
  <div class="ub ubb border-hui article_p1 article_m2 ub-ac ulev-1 sc-text-hui">
    <div class="ub-f1 ulev-app1"> 更新时间：<?php echo $this->_var['article']['add_time']; ?></div>
    <div class="ub-pe ulev-app1 ufm1">作者：<?php echo htmlspecialchars($this->_var['article']['author']); ?></div>
  </div>
  <div class="ulh-oa2 ulev-app1 article_p ulev-1 f-color-6"> 
    <?php if ($this->_var['article']['content']): ?> 
    <?php echo $this->_var['article']['content']; ?> 
    <?php endif; ?> 
  </div>
</div>
