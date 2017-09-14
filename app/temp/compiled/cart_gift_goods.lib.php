<div class="uh bg-color-w f-color-red ub" id="tab_container">
  <div class="uf t-bla ub ubb border-hui">
  <?php $_from = $this->_var['favourable_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'favourable');$this->_foreach['favour'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['favour']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['favourable']):
        $this->_foreach['favour']['iteration']++;
?>
    <div class="ulev-1 ub-f1 _tab <?php if (($this->_foreach['favour']['iteration'] <= 1)): ?>selected<?php endif; ?>" id='tab_<?php echo $this->_var['key']; ?>' tab_key='<?php echo $this->_var['key']; ?>' act_id="<?php echo $this->_var['favourable']['act_id']; ?>">赠品 <?php echo $this->_foreach['favour']['iteration']; ?>
    </div>
	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  </div>
</div>
<?php $_from = $this->_var['favourable_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'favourable');$this->_foreach['gift_tab'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['gift_tab']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['favourable']):
        $this->_foreach['gift_tab']['iteration']++;
?>
<div class="<?php if (($this->_foreach['gift_tab']['iteration'] - 1) > 0): ?>uhide<?php endif; ?> _tab_content ub-f1" id="tab_content_<?php echo $this->_var['key']; ?>" act_id="<?php echo $this->_var['favourable']['act_id']; ?>">
  <div class="uinn-a1 ubb border-faxian">
  <div class="m-btm4 ulev-1 f-color-6"><?php echo $this->_var['favourable']['act_name']; ?></div>
    <div class="m-btm4 ulev-1 f-color-6"><?php echo $this->_var['favourable']['act_type_desc']; ?></div>
    <div class="gm-btm4 ulev-1 f-color-6">价格满足<span class="f-color-red"><?php if ($this->_var['favourable']['formated_max_amount'] == '0.00'): ?>	<?php echo $this->_var['favourable']['formated_min_amount']; ?>以上<?php else: ?><?php echo $this->_var['favourable']['formated_min_amount']; ?> ~ <?php echo $this->_var['favourable']['formated_max_amount']; ?><?php endif; ?></span>才可以享受赠品哦！</div>
    <div class="m-btm4 ulev-1 f-color-6">活动时间：<?php echo $this->_var['favourable']['start_time']; ?> ~ <?php echo $this->_var['favourable']['end_time']; ?></div>
    <div class="m-btm4 ulev-1 f-color-6">参加活动商品：<span class="f-color-red"><?php echo $this->_var['lang']['far_ext'][$this->_var['favourable']['act_range']]; ?>  <?php echo $this->_var['favourable']['act_range_desc']; ?></span></div>
  </div>
  <?php if ($this->_var['favourable']['act_type'] == 0): ?>
  <?php $_from = $this->_var['favourable']['gift']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'gift');if (count($_from)):
    foreach ($_from AS $this->_var['gift']):
?>
  <div class="uinn-a1 gift" gift_id='<?php echo $this->_var['gift']['id']; ?>'>
    <div class="ubb ub border-faxian t-bla ub-ac lis">
      <div class="ub ub ub-ver">
        <div class="">
          <div class="lis-icon ub-img"><img src="<?php echo $this->_var['url']; ?><?php echo $this->_var['gift']['goods_thumb']; ?>" style="width:4.6em; height:4.6em;"></div>
          <div class="ulev-1 bc-text umar-t"></div>
        </div>
      </div>
      <div class="ub-f1 ub ub-pj ub-ac">
        <div class="ub-f1 ub ub-ver">
          <div class="bc-text ub ub-ver ulev-1 ut-m line1 gift-m3"><?php echo $this->_var['gift']['name']; ?></div>
          <div class="ulev-1 sc-text1 uinn3 gift-m3">
            <div class="ub umar-t">
              <div class="ulev-1 ub ub-f1 f-color-6">数量：
                <input value="1" type="text" class="gift-text uba border-hui bg-color-w ulev-1" disabled=disabled />
              </div>
              <div class="ulev-1 ub ub-f1 ub-ac ub-pe f-color-red">[<?php echo $this->_var['gift']['formated_price']; ?>]</div>
            </div>
          </div>
        </div>
      </div>
      <div class="_checkbox checkbox_normal" name="gift_<?php echo $this->_var['key']; ?>" value="<?php echo $this->_var['gift']['id']; ?>" id="gift_<?php echo $this->_var['gift']['id']; ?>"></div>
    </div>
  </div>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  <?php endif; ?>
</div>
<div id="confirm_button" class="cancel">取消</div>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>