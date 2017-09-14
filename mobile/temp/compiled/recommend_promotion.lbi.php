<?php if ($this->_var['promotion_goods']): ?>

<script>
var Tday = new Array();
var daysms = 24 * 60 * 60 * 1000
var hoursms = 60 * 60 * 1000
var Secondms = 60 * 1000
var microsecond = 1000
var DifferHour = -1
var DifferMinute = -1
var DifferSecond = -1
function clock(key)
{
   var time = new Date()
   var hour = time.getHours()
   var minute = time.getMinutes()
   var second = time.getSeconds()
   var timevalue = ""+((hour > 12) ? hour-12:hour)
   timevalue +=((minute < 10) ? ":0":":")+minute
   timevalue +=((second < 10) ? ":0":":")+second
   timevalue +=((hour >12 ) ? " PM":" AM")
   var convertHour = DifferHour
   var convertMinute = DifferMinute
   var convertSecond = DifferSecond
   var Diffms = Tday[key].getTime() - time.getTime()
   DifferHour = Math.floor(Diffms / daysms)
   Diffms -= DifferHour * daysms
   DifferMinute = Math.floor(Diffms / hoursms)
   Diffms -= DifferMinute * hoursms
   DifferSecond = Math.floor(Diffms / Secondms)
   Diffms -= DifferSecond * Secondms
   var dSecs = Math.floor(Diffms / microsecond)
  
   if(convertHour != DifferHour) a=DifferHour+":";
   if(convertMinute != DifferMinute) b=DifferMinute+":";
   if(convertSecond != DifferSecond) c=DifferSecond+"分"
     d=dSecs
     if (DifferHour>0) {a=a}
     else {a=''}
   document.getElementById("jstimerBox"+key).innerHTML = a + b + c ; //显示倒计时信息
}
</script>
<section class="index_floor_lou">
  <div class="floor_body" >
    <h2>
      <em></em><?php echo $this->_var['lang']['promotion_goods']; ?><div class="geng"><a href="search.php?intro=promotion" >更多</a> <span></span></div>
    </h2>
    <div id="scroll_promotion">
        <ul>
          <?php $_from = $this->_var['promotion_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'goods');$this->_foreach['promotion_goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['promotion_goods']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['goods']):
        $this->_foreach['promotion_goods']['iteration']++;
?>
          <li>
            <a href="<?php echo $this->_var['goods']['url']; ?>" title="<?php echo htmlspecialchars($this->_var['goods']['name']); ?>">
             <div class="index_pro"> 
              <div class="products_kuang">
              <div class="timerBox" id="jstimerBox<?php echo $this->_var['key']; ?>">正在加载请稍等</div>
                <img src="<?php echo $this->_var['option']['static_path']; ?><?php echo $this->_var['goods']['thumb']; ?>">
                </div>
              <div class="goods_name"><?php echo sub_str($this->_var['goods']['name'],17); ?></div>
              <div class="price">
              <a href="javascript:addToCart(<?php echo $this->_var['goods']['id']; ?>)" class="btns">
                  <img src="themesmobile/68ecshopcom_mobile/images/index_flow.png"></a>
                <span class="price_pro">
                  <?php if ($this->_var['goods']['promote_price']): ?><?php echo $this->_var['goods']['promote_price']; ?><?php else: ?><?php echo $this->_var['goods']['shop_price']; ?><?php endif; ?>
                </span>
                
              </div>
            </a>
</div>
<script>
Tday[<?php echo $this->_var['key']; ?>] = new Date("<?php echo $this->_var['goods']['gmt_end_time']; ?>");  
window.setInterval(function()    
{clock(<?php echo $this->_var['key']; ?>);}, 1000);  
</script>
          </li>
<?php if ($this->_foreach['promotion_goods']['iteration'] % 3 == 0 && $this->_foreach['promotion_goods']['iteration'] != $this->_foreach['promotion_goods']['total']): ?>
          </ul>
        <ul>
		<?php endif; ?>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?></div>
    </div>
  </section>
<?php endif; ?>