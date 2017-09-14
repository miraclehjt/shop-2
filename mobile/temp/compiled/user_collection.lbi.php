<script type="text/javascript">
				/*第一种形式 第二种形式 更换显示样式*/
				function setGoodsTab(name,cursel,n){
					$('html,body').animate({'scrollTop':0},600);
				for(i=1;i<=n;i++){
				var menu=document.getElementById(name+i);
				var con=document.getElementById("user_"+name+"_"+i);
				menu.className=i==cursel?"on":"";
				con.style.display=i==cursel?"block":"none";
				}
				}
				</script>
<div class="sc_nav">
    <ul>
      <li><a href="user.php?act=collection_list" class="tab_head <?php if ($this->_var['action'] == 'collection_list'): ?>on<?php endif; ?>" id="goods_ka1" >收藏的宝贝</a></li>
      <li><a href="user.php?act=follow_shop" class="tab_head <?php if ($this->_var['action'] == 'follow_shop'): ?>on<?php endif; ?>" id="goods_ka2" >收藏的店铺</a></li>
     </ul>
 </div>

  <div class="main" id="user_goods_ka_1" <?php if ($this->_var['action'] != 'collection_list'): ?>style="display:none;"<?php endif; ?>>         
 <?php if ($this->_var['goods_list']): ?>
 <form name="theForm" method="post" action="">
 <div class="shouchang">
 <ul>
  <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['goods_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods_list']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['goods_list']['iteration']++;
?>
  <li>
            
              <div class="imgurl"><a href="<?php echo $this->_var['goods']['url']; ?>" ><img src="<?php echo $this->_var['goods']['goods_thumb']; ?>" width="100" height="100"></a></div>
              <a href="<?php echo $this->_var['goods']['url']; ?>">
              <div class="order_info">
                <dl>
                  <dt><?php echo sub_str($this->_var['goods']['goods_name'],13); ?></dt>
                  <dd><strong><?php if ($this->_var['goods']['promote_price']): ?><?php echo $this->_var['goods']['promote_price']; ?><?php else: ?><?php echo $this->_var['goods']['shop_price']; ?><?php endif; ?></strong></dd>
                </dl>
              </div>
              </a>
              <div class="dingdancaozuo" >
              <a href="javascript:addToCart(<?php echo $this->_var['goods']['goods_id']; ?>)" class="s_flow" style=" color:#fff">加入购物车</a>
               <a href="user.php?act=delete_collection&collection_id=<?php echo $this->_var['goods']['rec_id']; ?>" class="s_out" style=" color:#fff" >删除</a></div>
          </li>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
   </ul>
  </div>
</form>
<?php else: ?>
<div id="list_0_0" class="font12"><?php echo $this->_var['lang']['collection_empty']; ?></div>
<?php endif; ?>
<?php if ($this->_var['goods_list']): ?><?php echo $this->fetch('library/pages.lbi'); ?><?php endif; ?> 
</div>
   
<div class="main" id="user_goods_ka_2" <?php if ($this->_var['action'] != 'follow_shop'): ?>style="display:none"<?php endif; ?>>
 <?php if ($this->_var['shop_list']): ?>
 <form name="theForm" method="post" action="">
 <div class="dianpu">
 <ul>
  <?php $_from = $this->_var['shop_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'shop');$this->_foreach['shop_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['shop_list']['total'] > 0):
    foreach ($_from AS $this->_var['shop']):
        $this->_foreach['shop_list']['iteration']++;
?>
  <li>
            
              <div class="imgurl"><a href="<?php echo $this->_var['shop']['url']; ?>" ><img src="./../<?php echo $this->_var['shop']['shop_logo']; ?>" width="100" height="100"></a></div>
              <a href="<?php echo $this->_var['shop']['url']; ?>">
              <div class="order_info">
                <dl>
                  <dt><span style=" color:#FFF">店铺</span><?php echo sub_str($this->_var['shop']['shop_name'],13); ?></dt>
                  <dd><img src="themesmobile/68ecshopcom_mobile/images/dianpu2.png" height="25"><span><?php if ($this->_var['shop']['rank_id'] == '1'): ?>初级店铺<?php elseif ($this->_var['shop']['rank_id'] == '2'): ?>中级店铺<?php elseif ($this->_var['shop']['rank_id'] == '3'): ?>高级店铺<?php else: ?>初级店铺<?php endif; ?></span></dd>
                  <a class="outdianpu" style=" color:#FFF" href="javascript:if (confirm('确定取消收藏？')) location.href='user.php?act=del_follow&rec_id=<?php echo $this->_var['shop']['id']; ?>'">删除收藏</a>
                 </dl>
              </div>
              </a>
          </li>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
   </ul>
  </div>
</form>
<?php else: ?>
<div id="list_0_0" class="font12">您还没有收藏店铺哦！</div>
<?php endif; ?>
<?php if ($this->_var['shop_list']): ?><?php echo $this->fetch('library/pages.lbi'); ?><?php endif; ?> 
</div>


<script language="JavaScript">
	var elements = document.forms['theForm'].elements;
	var url = '<?php echo $this->_var['url']; ?>';
	var u   = '<?php echo $this->_var['user_id']; ?>';
	/**
	 * 生成代码
	 */
	function genCode()
	{
			// 检查输入
			if (isNaN(parseInt(elements['goods_num'].value)))
			{
					alert('<?php echo $this->_var['lang']['goods_num_must_be_int']; ?>');
					return;
			}
			if (elements['goods_num'].value < 1)
			{
					alert('<?php echo $this->_var['lang']['goods_num_must_over_0']; ?>');
					return;
			}

			// 生成代码
			var code = '\<script src=\"' + url + 'goods_script.php?';
			code += 'need_image=' + elements['need_image'].value + '&';
			code += 'goods_num=' + elements['goods_num'].value + '&';
			code += 'arrange=' + elements['arrange'].value + '&';
			code += 'charset=' + elements['charset'].value + '&u=' + u;
			code += '\"\>\</script\>';
			elements['code'].value = code;
			elements['code'].select();
			if (Browser.isIE)
          {
              window.clipboardData.setData("Text",code);
          }
      }
			var compare_no_goods = "<?php echo $this->_var['lang']['compare_no_goods']; ?>";
			var btn_buy = "<?php echo $this->_var['lang']['btn_buy']; ?>";
			var is_cancel = "<?php echo $this->_var['lang']['is_cancel']; ?>";
			var select_spe = "<?php echo $this->_var['lang']['select_spe']; ?>";
  </script>