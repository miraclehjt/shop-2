
<form id="formCart" name="formCart" method="post" action="flow.php" >
  <a href="flow.php" class="btn" style="height:135px; padding-top:5px; color:#fff;" id="collectBox"> <i></i> 购<br/>
  物<br/>
  车<br/>
  <span style="margin-top:7px;" ><?php echo $this->_var['str']; ?></span> </a>
  <div class="dropdown" id="J-flow-drop" style="opacity: 1; margin-right: 0px; display:none;"> 
    <?php if ($this->_var['goods']): ?>
    <div class="bar clearfix">
      <div class="tip grid-c-l">共<span class="count"><?php echo $this->_var['str']; ?></span>件宝贝</div>
      <div class="btn-bar grid-c-r"> <a href="flow.php" class="submit-btn" rel="nofollow">去购物车结算</a> </div>
    </div>
    <div class="cart_goods">
    <div class="cart_goods_list">
    <ul class="unstyled">
     <?php $_from = $this->_var['goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods_0_75429900_1505113128');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['goods_0_75429900_1505113128']):
        $this->_foreach['goods']['iteration']++;
?>
      <li><a href="<?php echo $this->_var['goods_0_75429900_1505113128']['url']; ?>"><img src="<?php if ($this->_var['goods_0_75429900_1505113128']['goods_thumb'] == 'package_img'): ?>themes/68ecshopcom_360buy/images/jmpic/ico_cart_package.gif<?php else: ?><?php echo $this->_var['goods_0_75429900_1505113128']['goods_thumb']; ?><?php endif; ?>">
        <h4><?php echo $this->_var['goods_0_75429900_1505113128']['short_name']; ?></h4>
        <span><?php echo $this->_var['goods_0_75429900_1505113128']['goods_price']; ?><strong style="margin:0 7px;">×</strong><?php echo $this->_var['goods_0_75429900_1505113128']['goods_number']; ?></span></a> <i class="del-btn" title="删除" onClick="deleteCartGoods(<?php echo $this->_var['goods_0_75429900_1505113128']['rec_id']; ?>)">×</i></li>
     <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </ul>
    </div>
    </div>
    <?php else: ?>
    <div class="empty-tip">
      <p></p>
      <p><a href="index.php" rel="nofollow">您的购物车里什么都没有哦，再去看看吧</a></p>
    </div>
    <?php endif; ?> 
    <span class="cart_arrow"><b class="arrow-1"></b> <b class="arrow-2"></b></span> </div>
  <script type="text/javascript">
function deleteCartGoods(rec_id)
{
Ajax.call('delete_cart_goods.php', 'id='+rec_id, deleteCartGoodsResponse, 'POST', 'JSON');
}

/**
 * 接收返回的信息
 */
function deleteCartGoodsResponse(res)
{
  if (res.error)
  {
    alert(res.err_msg);
  }
  else
  {
      document.getElementById('ECS_CARTINFO').innerHTML = res.content;
  }
}
</script> 
  <script>
$("#ECS_CARTINFO").mouseover(function() {
    $("#J-flow-drop").show();
});
$("#ECS_CARTINFO").mouseout(function() {
 $("#J-flow-drop").hide();
});
$("#ECS_CARTINFO").mouseenter(function() {
    $("#J-flow-drop").show();
});
$("#ECS_CARTINFO").mouseleave(function() {
 $("#J-flow-drop").hide();
});
</script>
</form>
