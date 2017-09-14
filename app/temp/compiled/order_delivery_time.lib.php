<div class="checkBox_jm m-top3 bg-color-w">
  <div class="uinn-eo5 ub ub-ac ubb border-hui _fold"  fold_key="delivery_time_box" value_key='delivery_time'>
  <div class="ub-f1 f-color-zi ulev-9 p-all5">送货时间</div>
  <div class='ub-pe xuanzhong ulev-1 selected_indicator' id='selected_delivery_time'>仅工作日送货</div>
  <div class="sc-text ulev-1-4 umar-r fa fold_indicator"></div>
  </div>
  <div class="timebox ulev-1 p-all1 uhide f-color-6" id="delivery_time_box">    
    <ul>
      <li class='delivery_time _checkbox checked checkbox_radio' name="delivery_time" radio="true" checked="true" cancel="false" value="仅工作日送货">仅工作日送货</li>
      <li class='delivery_time _checkbox checkbox_radio' name="delivery_time" radio="true" cancel="false" value="仅周末送货">仅周末送货</li>
      <li class='delivery_time _checkbox checkbox_radio' name="delivery_time" radio="true" cancel="false" value="工作日/周末/假日均可">工作日/周末/假日均可</li>
      <li id='delivery_time_button' class='delivery_time _checkbox checkbox_radio' name="delivery_time" radio="true" cancel="false" value="指定送货时间">指定送货时间</li>
    </ul>
	<div class="ulev-1 sc-text-hui tx-l p-all1">送货时间仅作参考，快递公司会尽量满足您的要求</div>
  </div>
</div>
<ul id="treelist" class="time_table ulev-1 uhide"  placeholder="指定送货时间" style="display: none;">
	<?php $_from = $this->_var['week_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'week');if (count($_from)):
    foreach ($_from AS $this->_var['week']):
?>
  <li value="0"><span  value="0" title="<?php echo $this->_var['week']['name']; ?>"><?php echo $this->_var['week']['name']; ?> <?php echo $this->_var['week']['week']; ?></span>
	<ul align=center>
		<?php if ($this->_var['week']['time1']): ?>
		<li value="1"> <span value="0" class='exact_time' title="<?php echo $this->_var['week']['name']; ?> <?php echo $this->_var['week']['week']; ?> 9:00--15:00">9:00--15:00</span></li>
		<?php endif; ?>
		<?php if ($this->_var['week']['time2']): ?>
		<li value="1"> <span value="0" class='exact_time' title="<?php echo $this->_var['week']['name']; ?> <?php echo $this->_var['week']['week']; ?> 15:00--19:00">15:00--19:00</span></li>
		<?php endif; ?>
		<?php if ($this->_var['week']['time3']): ?>
		<li value="1"> <span value="0" class='exact_time' title="<?php echo $this->_var['week']['name']; ?> <?php echo $this->_var['week']['week']; ?> 19:00--22:00">19:00--22:00</span></li>
		<?php endif; ?>
	</ul>
  </li>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</ul>
