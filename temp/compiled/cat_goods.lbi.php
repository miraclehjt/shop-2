<?php
$GLOBALS['smarty']->assign('cat_recommend_type',get_cat_recommend_type($GLOBALS['smarty']->_var['goods_cat']['id']));

?>
<div class="w floor">
	<div class="floor02 clearfix">
		<div id="f0" class="home-standard-layout tm-chaoshi-floorlayout <?php if ($this->_var['goods_cat']['id'] == 1): ?>style-one<?php elseif ($this->_var['goods_cat']['id'] == 2): ?> style-two<?php elseif ($this->_var['goods_cat']['id'] == 3): ?>style-three<?php elseif ($this->_var['goods_cat']['id'] == 4): ?>style-four<?php elseif ($this->_var['goods_cat']['id'] == 5): ?>style-five<?php elseif ($this->_var['goods_cat']['id'] == 6): ?>style-six<?php elseif ($this->_var['goods_cat']['id'] == 7): ?>style-seven<?php elseif ($this->_var['goods_cat']['id'] == 8): ?>style-eight<?php endif; ?>">
			<?php
	 		$GLOBALS['smarty']->assign('index_image3',get_advlist('首页-分类ID'.$GLOBALS['smarty']->_var['goods_cat']['id'].'通栏广告', 1));
	 		?>
			<?php $_from = $this->_var['index_image3']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'ad_0_34227600_1505113128');$this->_foreach['index_image'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['index_image']['total'] > 0):
    foreach ($_from AS $this->_var['ad_0_34227600_1505113128']):
        $this->_foreach['index_image']['iteration']++;
?>
			<a href="<?php echo $this->_var['ad_0_34227600_1505113128']['url']; ?>" class="j_ItemInfo_tong">
				<img data-original="<?php echo $this->_var['ad_0_34227600_1505113128']['image']; ?>" src="themes/68ecshopcom_360buy/images/loading1.gif" alt="" height="100" width="1210">
			</a>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			<div class="m-floor">
				<div class="header left_floor">
					<h2>
						<span>
							<?php if ($this->_var['goods_cat']['id'] == 1): ?>
							1F
							<?php elseif ($this->_var['goods_cat']['id'] == 2): ?>
							2F
							<?php elseif ($this->_var['goods_cat']['id'] == 3): ?>
							3F
							<?php elseif ($this->_var['goods_cat']['id'] == 4): ?>
							4F
							<?php elseif ($this->_var['goods_cat']['id'] == 5): ?>
							5F
							<?php elseif ($this->_var['goods_cat']['id'] == 6): ?>
							6F
							<?php elseif ($this->_var['goods_cat']['id'] == 7): ?>
							7F
							<?php elseif ($this->_var['goods_cat']['id'] == 8): ?>
							8F
							<?php endif; ?>
						</span>
						<a href="<?php echo $this->_var['goods_cat']['url']; ?>" target="_blank"><?php echo htmlspecialchars($this->_var['goods_cat']['name']); ?></a>
					</h2>
					<div class="recommend">
						<div class="words">
							<?php
            				$ii = 0;
							$GLOBALS['smarty']->assign('child_cat',get_hot_cat_tree($GLOBALS['smarty']->_var['goods_cat']['id'], 3));
	    					?>
							<?php $_from = $this->_var['child_cat']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat_0_34327600_1505113128');$this->_foreach['name1'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name1']['total'] > 0):
    foreach ($_from AS $this->_var['cat_0_34327600_1505113128']):
        $this->_foreach['name1']['iteration']++;
?>
							<?php $_from = $this->_var['cat_0_34327600_1505113128']['child']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat_child');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['cat_child']):
        $this->_foreach['name']['iteration']++;
?>
							<?php
	        				$ii = $ii + 1;
							$GLOBALS['smarty']->assign('ii', $ii);
							?>
							<?php if ($this->_var['ii'] < 10): ?>
							<a href="<?php echo $this->_var['cat_child']['url']; ?>">
								<b><?php echo htmlspecialchars($this->_var['cat_child']['name']); ?></b>
							</a>
							<?php endif; ?>
							<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
							<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
						</div>
						<?php
						$GLOBALS['smarty']->assign('index_image',get_advlist('首页-分类ID'.$GLOBALS['smarty']->_var['goods_cat']['id'].'-左侧图片', 1));
	 					?>
						<?php if ($this->_var['index_image']): ?>
						<?php $_from = $this->_var['index_image']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'ad_0_34327600_1505113128');$this->_foreach['index_image'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['index_image']['total'] > 0):
    foreach ($_from AS $this->_var['ad_0_34327600_1505113128']):
        $this->_foreach['index_image']['iteration']++;
?>
						<a href="<?php echo $this->_var['ad_0_34327600_1505113128']['url']; ?>" target="_blank" class="banner">
							<img data-original="<?php echo $this->_var['ad_0_34327600_1505113128']['image']; ?>" src="themes/68ecshopcom_360buy/images/loading.gif" height="297" width="240">
						</a>
						<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
						<?php endif; ?>
					</div>
				</div>
				<div class="content mid_floor">
					<div class="goods">
						<div class="middle-layout">
							<ul class="tabs-nav">
								<li class="tabs-selected">
									<h3>精挑细选</h3>
								</li>
								<?php
	 
			$GLOBALS['smarty']->assign('child_cat',get_child_cat($GLOBALS['smarty']->_var['goods_cat']['id'], 3));
	?>
								<?php $_from = $this->_var['child_cat']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat_item');$this->_foreach['child_cat'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['child_cat']['total'] > 0):
    foreach ($_from AS $this->_var['cat_item']):
        $this->_foreach['child_cat']['iteration']++;
?>
								<li class="">
									<h3><?php echo htmlspecialchars($this->_var['cat_item']['name']); ?></h3>
								</li>
								<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
							</ul>
							<div class="tabs-panel">
								<?php
		 $GLOBALS['smarty']->assign('best_goods', get_cat_recommend_goods('best', get_children($GLOBALS['smarty']->_var['goods_cat']['id']), 8));

		?>
								<?php $_from = $this->_var['best_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods_0_34427600_1505113128');$this->_foreach['cat_item_goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['cat_item_goods']['total'] > 0):
    foreach ($_from AS $this->_var['goods_0_34427600_1505113128']):
        $this->_foreach['cat_item_goods']['iteration']++;
?>
								<div class="j_ItemInfo" id="li_<?php echo $this->_var['goods_0_34427600_1505113128']['id']; ?>" <?php if ($this->_foreach['cat_item_goods']['iteration'] % 4 == 0): ?>style="border-right: none"<?php endif; ?>>
									<div class="wrap">
										<a target="_blank" href="<?php echo $this->_var['goods_0_34427600_1505113128']['url']; ?>" title="<?php echo htmlspecialchars($this->_var['goods_0_34427600_1505113128']['name']); ?>">
											<img data-original="<?php echo $this->_var['goods_0_34427600_1505113128']['thumb']; ?>" src="themes/68ecshopcom_360buy/images/loading.gif" alt="<?php echo htmlspecialchars($this->_var['goods_0_34427600_1505113128']['name']); ?>" height="160" width="160" class="pic_img_<?php echo $this->_var['goods_0_34427600_1505113128']['id']; ?>">
										</a>
										<p class="title">
											<a target="_blank" href="<?php echo $this->_var['goods_0_34427600_1505113128']['url']; ?>" title="<?php echo htmlspecialchars($this->_var['goods_0_34427600_1505113128']['name']); ?>"><?php echo $this->_var['goods_0_34427600_1505113128']['short_style_name']; ?></a>
										</p>
										<p class="o-price"><?php echo $this->_var['goods_0_34427600_1505113128']['market_price']; ?></p>
										<p class="price">
											<span class="j_CurPrice">
												<?php if ($this->_var['goods_0_34427600_1505113128']['promote_price'] != ""): ?>
												<?php echo $this->_var['goods_0_34427600_1505113128']['promote_price']; ?>
												<?php else: ?>
												<?php echo $this->_var['goods_0_34427600_1505113128']['shop_price']; ?>
												<?php endif; ?>
											</span>
										</p>
										<a class="j_AddCart" onclick="addToCart(<?php echo $this->_var['goods_0_34427600_1505113128']['id']; ?>)" title="加入购物车"></a>
										<i class="product-mask"></i>
									</div>
								</div>
								<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
							</div>
							<?php $_from = $this->_var['child_cat']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat_item');$this->_foreach['child_cat'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['child_cat']['total'] > 0):
    foreach ($_from AS $this->_var['cat_item']):
        $this->_foreach['child_cat']['iteration']++;
?>
							<?php
							$GLOBALS['smarty']->assign('child_cat_index', $child_cat_index);
							?>
							<div class="tabs-panel tabs-hide">
								<ul>
									<?php
									$GLOBALS['smarty']->assign('new_goods', get_cat_recommend_goods('new', get_children($GLOBALS['smarty']->_var['cat_item']['id']), 8));
									?>
									<?php $_from = $this->_var['new_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods_0_34527600_1505113128');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['goods_0_34527600_1505113128']):
        $this->_foreach['goods']['iteration']++;
?>
									<div class="j_ItemInfo" <?php if ($this->_foreach['goods']['iteration'] % 4 == 0): ?>style="border-right: none"<?php endif; ?>>
										<div class="wrap">
											<a target="_blank" href="<?php echo $this->_var['goods_0_34527600_1505113128']['url']; ?>" title="<?php echo htmlspecialchars($this->_var['goods_0_34527600_1505113128']['name']); ?>">
												<img src="<?php echo $this->_var['goods_0_34527600_1505113128']['thumb']; ?>" alt="<?php echo htmlspecialchars($this->_var['goods_0_34527600_1505113128']['name']); ?>" height="160" width="160">
											</a>
											<p class="title">
												<a target="_blank" href="<?php echo $this->_var['goods_0_34527600_1505113128']['url']; ?>" title="<?php echo htmlspecialchars($this->_var['goods_0_34527600_1505113128']['name']); ?>"><?php echo $this->_var['goods_0_34527600_1505113128']['short_style_name']; ?></a>
											</p>
											<p class="o-price"><?php echo $this->_var['goods_0_34527600_1505113128']['market_price']; ?></p>
											<p class="price">
												<span class="j_CurPrice">
													<?php if ($this->_var['goods_0_34527600_1505113128']['promote_price'] != ""): ?>
													<?php echo $this->_var['goods_0_34527600_1505113128']['promote_price']; ?>
													<?php else: ?>
													<?php echo $this->_var['goods_0_34527600_1505113128']['shop_price']; ?>
													<?php endif; ?>
												</span>
											</p>
											<a class="j_AddCart" onclick="addToCart(<?php echo $this->_var['goods_0_34527600_1505113128']['id']; ?>)" title="加入购物车"></a>
										</div>
									</div>
									<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
								</ul>
							</div>
							<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
						</div>
					</div>
				</div>
				<div class="promo">
					<?php
		 			$GLOBALS['smarty']->assign('index_image1',get_advlist('首页-分类ID'.$GLOBALS['smarty']->_var['goods_cat']['id'].'右侧广告1', 1));
	 				?>
					<?php $_from = $this->_var['index_image1']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'ad_0_34627600_1505113128');$this->_foreach['index_image'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['index_image']['total'] > 0):
    foreach ($_from AS $this->_var['ad_0_34627600_1505113128']):
        $this->_foreach['index_image']['iteration']++;
?>
					<a href="<?php echo $this->_var['ad_0_34627600_1505113128']['url']; ?>" class="j_ItemInfo">
						<img data-original="<?php echo $this->_var['ad_0_34627600_1505113128']['image']; ?>" src="themes/68ecshopcom_360buy/images/loading2.gif" alt="" height="278" width="150">
					</a>
					<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
					<?php
		 			$GLOBALS['smarty']->assign('index_image2',get_advlist('首页-分类ID'.$GLOBALS['smarty']->_var['goods_cat']['id'].'右侧广告2', 1));
	 				?>
					<?php $_from = $this->_var['index_image2']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'ad_0_34627600_1505113128');$this->_foreach['index_image'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['index_image']['total'] > 0):
    foreach ($_from AS $this->_var['ad_0_34627600_1505113128']):
        $this->_foreach['index_image']['iteration']++;
?>
					<a href="<?php echo $this->_var['ad_0_34627600_1505113128']['url']; ?>" class="j_ItemInfo">
						<img data-original="<?php echo $this->_var['ad_0_34627600_1505113128']['image']; ?>" src="themes/68ecshopcom_360buy/images/loading2.gif" alt="" height="279" width="150">
					</a>
					<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				</div>
				<div class="promo_brand">
					<div class="recommend-brand">
						<div class="gw_con">
							<div class="anli">
								<div class="anli_con">
									<ul class="yyyy_<?php echo $this->_var['goods_cat']['id']; ?> anli_con_num" style="position: absolute; width: 1210px; height: 40px; top: 0px; left: 0px;">
										<?php
										$GLOBALS['smarty']->assign('catbrand',get_cat_brands($GLOBALS['smarty']->_var['goods_cat']['id'], 14));
	    								?>
										<?php $_from = $this->_var['catbrand']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');$this->_foreach['catbrand'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['catbrand']['total'] > 0):
    foreach ($_from AS $this->_var['item']):
        $this->_foreach['catbrand']['iteration']++;
?>
										<li <?php if (($this->_foreach['catbrand']['iteration'] <= 1)): ?>class="fore1"<?php endif; ?>>
											<a href="<?php echo $this->_var['item']['url']; ?>" target="_blank" title="<?php echo htmlspecialchars($this->_var['item']['name']); ?>">
												<img width="100" height="40" src="data/brandlogo/<?php echo $this->_var['item']['logo']; ?>" alt="<?php echo htmlspecialchars($this->_var['item']['name']); ?>">
											</a>
										</li>
										<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
									</ul>
									<div class="anniu">
										<a class="gw_left right_<?php echo $this->_var['goods_cat']['id']; ?>" href="javascript:void(0)">
											<img src="themes/68ecshopcom_360buy/images/upgrade_ad/icon-slide-left.png" />
										</a>
										<a class="gw_right left_<?php echo $this->_var['goods_cat']['id']; ?>" href="javascript:void(0)">
											<img src="themes/68ecshopcom_360buy/images/upgrade_ad/icon-slide-right.png" />
										</a>
									</div>
								</div>
							</div>
						</div>
						<script type="text/javascript">
						Move(".left_<?php echo $this->_var['goods_cat']['id']; ?>",".right_<?php echo $this->_var['goods_cat']['id']; ?>",".yyyy_<?php echo $this->_var['goods_cat']['id']; ?>",".anli","10");
						</script>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="blank5"></div>
