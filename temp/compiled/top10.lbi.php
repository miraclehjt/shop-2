<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php if ($this->_var['top_goods']): ?>
<script>
var old = new Array();
function show_goodspic(id,type)
{
  if(old[type]!=null)
  {
	  document.getElementById(type+"b"+old[type]).style.display='none';
	  document.getElementById(type+"s"+old[type]).style.display='block';
  }
      document.getElementById(type+"s"+id).style.display='none';
	  document.getElementById(type+"b"+id).style.display='block';
	  old[type] = id;
}

</script>
<div id="weekRank" class="m rank" >
  <div class="mt">
    <h2>销量排行榜</h2>
  </div>
  <div class="mc">
    <ul class="tabcon">
      <?php $_from = $this->_var['top_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['top_goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['top_goods']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['top_goods']['iteration']++;
?>
      
      <li class="fore <?php if ($this->_foreach['top_goods']['iteration'] < 4): ?>fore1<?php endif; ?>" id="top2b<?php echo $this->_foreach['top_goods']['iteration']; ?>" style="display:none; <?php if (($this->_foreach['top_goods']['iteration'] == $this->_foreach['top_goods']['total'])): ?>border-bottom:none;<?php endif; ?>"><span><?php echo $this->_foreach['top_goods']['iteration']; ?></span>
        <div class="p-img"><a target='_blank' href='<?php echo $this->_var['goods']['url']; ?>'> <img src="<?php echo $this->_var['goods']['thumb']; ?>" alt="<?php echo htmlspecialchars($this->_var['goods']['name']); ?>" width="50" height="50"/></a></div>
        <div class="p-name"><a target='_blank' href='<?php echo $this->_var['goods']['url']; ?>'><?php echo $this->_var['goods']['short_name']; ?></a></div>
        <div class="price" style=" color:#DD0000"> <?php echo $this->_var['goods']['price']; ?> </div>
      </li>
      <li <?php if (($this->_foreach['top_goods']['iteration'] == $this->_foreach['top_goods']['total'])): ?>style=" border-bottom:none;"<?php endif; ?> <?php if ($this->_foreach['top_goods']['iteration'] < 4): ?>class=" fore1"<?php endif; ?> id="top2s<?php echo $this->_foreach['top_goods']['iteration']; ?>" onMouseOver="show_goodspic(<?php echo $this->_foreach['top_goods']['iteration']; ?>,'top2')" ><span><?php echo $this->_foreach['top_goods']['iteration']; ?></span>
      <div class="p-name"><a  href='<?php echo $this->_var['goods']['url']; ?>'><?php echo $this->_var['goods']['short_name']; ?><font color="#ff6600" ></font></a></div>
      </li>
      
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      
    </ul>
  </div>
</div>
<script type=text/javascript>show_goodspic(1,'top2');</script>
<?php endif; ?>