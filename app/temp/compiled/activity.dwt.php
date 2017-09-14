<div class="activity"> 
   
  <?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'val');$this->_foreach['val'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['val']['total'] > 0):
    foreach ($_from AS $this->_var['val']):
        $this->_foreach['val']['iteration']++;
?>
  <div class="activity-p2">
    <div class="ub ub-ver">
      <div class="ub ub-f1 p-t-b3">
        <div class="ulev-9 activity-m activity-bg f-color-red"> 活动<?php echo $this->_foreach['val']['iteration']; ?> </div>
        <div class="ulev-1 activity-m sc-text-hui ub ub-ac"> <?php echo $this->_var['val']['act_name']; ?> </div>
      </div>
      <div> <img src="<?php echo $this->_var['url']; ?><?php echo empty($this->_var['val']['logo']) ? 'images/ceshi.jpg' : $this->_var['val']['logo']; ?>" class="phone1"> </div>
      <div class="ulev-1 sc-text-hui p-t-b2"> <?php echo $this->_var['lang']['label_user_rank']; ?> <span class="f-color-6"> 
        <?php $_from = $this->_var['val']['user_rank']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'user');if (count($_from)):
    foreach ($_from AS $this->_var['user']):
?> 
        <?php echo $this->_var['user']; ?>&nbsp;&nbsp; 
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
        </span> </div>
      <div class="ulev-1 sc-text-hui activity-p2"> <?php echo $this->_var['lang']['label_end_time']; ?><span class="f-color-red"><?php echo $this->_var['val']['end_time']; ?></span> </div>
      <div class="ub ub-pj">
        <div class="ulev-1 sc-text-hui p-t-b2"> <?php echo $this->_var['lang']['label_max_amount']; ?> <span class="f-color-6"> 
          <?php if ($this->_var['val']['max_amount'] > 0): ?> 
          <?php echo $this->_var['val']['max_amount']; ?> 
          <?php else: ?> 
          无 
          <?php endif; ?> 
          </span> </div>
        <div class="ulev-1 sc-text-hui p-t-b2"> <?php echo $this->_var['lang']['label_min_amount']; ?><span class="f-color-6"><?php echo $this->_var['val']['min_amount']; ?></span> </div>
      </div>
      <div class="ulev-1 sc-text-hui activity-p2"> <?php echo $this->_var['lang']['label_act_range']; ?> 
        <?php if ($this->_var['val']['act_range'] == $this->_var['lang']['far_all']): ?> 
        <?php echo $this->_var['val']['act_range']; ?> 
        <?php else: ?> 
        <?php $_from = $this->_var['val']['act_range_ext']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'ext');if (count($_from)):
    foreach ($_from AS $this->_var['ext']):
?> 
        <span class="f-color-red _page" page_type="<?php echo $this->_var['val']['page_type']; ?>" page_file="<?php echo $this->_var['val']['page_file']; ?>" page_param="<?php echo $this->_var['val']['page_param']; ?>" <?php echo $this->_var['val']['page_param_name']; ?>="<?php echo $this->_var['ext']['id']; ?>" supplier_id="<?php echo $this->_var['val']['supplier_id']; ?>"><?php echo $this->_var['ext']['name']; ?></span> 
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
        <?php endif; ?> 
      </div>
      <div class="ub">
        <div class="ulev-1 sc-text-hui"> <?php echo $this->_var['lang']['label_act_type']; ?><span class="f-color-6"><?php echo $this->_var['val']['act_type']; ?><?php if ($this->_var['val']['act_type'] != $this->_var['lang']['fat_goods']): ?><?php echo $this->_var['val']['act_type_ext']; ?><?php endif; ?> </span> </div>
      </div>
    </div>
     
    <?php if ($this->_var['val']['gift']): ?>
    <div class="mar-aL1" id="act1" >
      <div class="ub uinn-p2" style='overflow-x:scroll;'> 
        <?php $_from = $this->_var['val']['gift']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['name1'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name1']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['name1']['iteration']++;
?>
        <div class="bg-color-w ub ub-ver activity-w goods p-b1" goods_id='<?php echo $this->_var['goods']['id']; ?>'>
          <div class="ub-img uwh-eleL ub-fh goods-img"><img src="<?php echo $this->_var['url']; ?><?php echo $this->_var['goods']['thumb']; ?>" style="width:4em; height:4em;"/> </div>
          <div class="ub ub-ver ut-m ulev-1 line1 f-color-6 umar-t1"> <?php echo $this->_var['goods']['name']; ?> </div>
        </div>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
      </div>
    </div>
    <?php endif; ?> 
     
  </div>
  <div class="ubb border-hui m-top3 m-btm1"></div>
   
  <?php endforeach; else: ?>
  <div class="clear1">没有更多活动</div>
  <?php endif; unset($_from); ?><?php $this->pop_vars();; ?> 
</div>
