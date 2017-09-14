<div class="uinn-eo5 ub ub-ac ubb border-faxian _fold expand" suppid="<?php echo $this->_var['key']; ?>" fold_key="shipping_box_<?php echo $this->_var['key']; ?>" value_key='shipping_<?php echo $this->_var['key']; ?>'>
  <div class="ub-f1 f-color-zi ulev-9 p-all5">配送方式</div>
  <div class='ub-pe xuanzhong uhide selected_indicator ulev-1' id='selected_shipping_<?php echo $this->_var['key']; ?>'></div>
  <div class="ub-pe sc-text ulev-1-4 umar-r fa fold_indicator"></div>
</div>
<?php if ($this->_var['goodsinfo']['shipping_html']): ?>
<div id='shipping_box_<?php echo $this->_var['key']; ?>' class="p-l-r6 f-color-6 ubb border-hui">
  <?php echo $this->_var['goodsinfo']['shipping_html']; ?>
  </div>
  <?php endif; ?>
<div id='select_pickup_point_<?php echo $this->_var['key']; ?>' class='uhide select_pickup_point p-all5 f-color-6 ulev-1 tx-r'></div>