
<?php

$GLOBALS['smarty']->assign('cainixihuan',   get_cainixihuan()); //猜你喜欢
?>
<?php if ($this->_var['cainixihuan']): ?>
<script type="text/javascript" src="themes/68ecshopcom_360buy/js/scrollpic.js"></script>
<DIV class=w>
<DIV id=product-track>
  <DIV class=right>
    <DIV class="m m2" id=maybe-like>
      <DIV class=mt  style=" background:none;">
        <H2>根据浏览猜你喜欢</H2>
        <DIV class=extra></DIV>
      </DIV>
      <DIV class=mc >
        
        <a class="guess-control" id="guess-forward">&lt;</a><a class="guess-control" id="guess-backward">&gt;</a>
        <div id="guess-scroll" >
 <ul class="lh" style="float:left;">
 <?php $_from = $this->_var['cainixihuan']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
   <li>
              <div class="p-img"> <a target="_blank" title="<?php echo $this->_var['goods']['goods_name']; ?>" href="<?php echo $this->_var['goods']['url']; ?>"><img height="130" width="130" alt="<?php echo $this->_var['goods']['goods_name']; ?>" src="<?php echo $this->_var['goods']['goods_thumb']; ?>"></a></div>
              <div class="p-name"> <a target="_blank" title="<?php echo $this->_var['goods']['goods_name']; ?>" href="<?php echo $this->_var['goods']['url']; ?>"><?php echo sub_str($this->_var['goods']['goods_name'],20); ?></a> </div>
              <div class="p-comm"> <span class="star sa5"></span><br/>
                <a target="_blank" href="<?php echo $this->_var['goods']['url']; ?>">(已有<?php echo $this->_var['goods']['evaluation']; ?>人评价)</a> </div>
              <div class="p-price"> <strong ><?php echo $this->_var['goods']['shop_price']; ?></strong> </div>
            </li>
 <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </ul>
        </DIV>
      </DIV>
      </DIV>
      <script language=javascript type=text/javascript>

		var scrollPic_01 = new ScrollPic();
		scrollPic_01.scrollContId   = "guess-scroll"; //内容容器ID
		scrollPic_01.arrLeftId      = "guess-forward";//左箭头ID
		scrollPic_01.arrRightId     = "guess-backward"; //右箭头ID
if(pageConfig.wideVersion&&pageConfig.compatible){
	scrollPic_01.frameWidth     = 900;//显示框宽度
	scrollPic_01.pageWidth      = 184; //翻页宽度
	}else{
		scrollPic_01.frameWidth     = 900;//显示框宽度
		scrollPic_01.pageWidth      = 184; //翻页宽度
		}
		scrollPic_01.speed          = 10; //移动速度(单位毫秒，越小越快)
		scrollPic_01.space          = 10; //每次移动像素(单位px，越大越快)
		scrollPic_01.autoPlay       = true; //自动播放
		scrollPic_01.autoPlayTime   = 3; //自动播放间隔时间(秒)

		scrollPic_01.initialize(); //初始化

</script>
    
    </DIV>
    <DIV class=left>
      <DIV class="m m2" id=recent-view-track  style="border-right:none;">
        <DIV class=mt>
          <H2>最近浏览</H2>
        </DIV>
        <DIV class=mc >
          <ul id='history_list'>
          <?php 
$k = array (
  'name' => 'history',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?>
          <li style="text-align:right;"><span ><a onclick="clear_history()" href="javascript:void(0);" style="color:#005AA0;">清空最近浏览商品>>&nbsp;</a></span></li>
          </ul>
         
        </DIV>
      </DIV>
      </DIV>
    <SPAN class=clr></SPAN></DIV>
</DIV>

<script type="text/javascript">
function clear_history()
{
Ajax.call('user.php', 'act=clear_history',clear_history_Response, 'GET', 'TEXT',1,1);
}
function clear_history_Response(res)
{
document.getElementById('history_list').innerHTML = '<?php echo $this->_var['lang']['no_history']; ?>';
}
</script> 
<?php endif; ?>