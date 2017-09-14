<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="http://localhost/weishop/" />
<meta name="Generator" content="HongYuJD v7_2" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />

<title><?php echo $this->_var['page_title']; ?></title>



<link rel="shortcut icon" href="favicon.ico" />
<link rel="icon" href="animated_favicon.gif" type="image/gif" />
<link rel="stylesheet" type="text/css" href="themes/68ecshopcom_360buy/css/category.css" />
<script type="text/javascript" src="themes/68ecshopcom_360buy/js/jquery_006.js"></script> 
<script type="text/javascript" src="themes/68ecshopcom_360buy/js/search_goods.js"></script> 
<script type="text/javascript" src="themes/68ecshopcom_360buy/js/base-2011.js"></script>
<script type="text/javascript" src="themes/68ecshopcom_360buy/js/jquery-lazyload.js" ></script>
<?php echo $this->smarty_insert_scripts(array('files'=>'jquery.json.js,transport.js')); ?>

<?php echo $this->smarty_insert_scripts(array('files'=>'utils.js,common.js,global.js')); ?>
</head>
<body>
<div id="site-nav"> 
  <?php echo $this->fetch('library/page_header.lbi'); ?>
  <div class="blank"></div>
  <?php echo $this->fetch('library/ur_here.lbi'); ?> 
  
  <div class="w main">
    <div class="right-extra"> 
      <?php if ($this->_var['action'] == "form"): ?> 
      
      <div class="box">
        <div class="box_1">
          <h3 style="height:30px; line-height:30px; background:#f2f2f2; text-indent:15px; border:#dddddd 1px solid;"><span><?php echo $this->_var['lang']['advanced_search']; ?></span></h3>
          <div class="boxCenterList">
            <form action="search.php" method="get" name="advancedSearchForm" id="advancedSearchForm">
              <table border="0" align="center" cellpadding="3">
                <tr>
                  <td valign="top"><?php echo $this->_var['lang']['keywords']; ?>：</td>
                  <td><input name="keywords" id="keywords" type="text" size="40" maxlength="120" class="inputBg" value="<?php echo $this->_var['adv_val']['keywords']; ?>" />
                    <label for="sc_ds">
                      <input type="checkbox" name="sc_ds" value="1" id="sc_ds" <?php echo $this->_var['scck']; ?> />
                      <?php echo $this->_var['lang']['sc_ds']; ?></label>
                    <br />
                    <?php echo $this->_var['lang']['searchkeywords_notice']; ?> </td>
                </tr>
                <tr>
                  <td><?php echo $this->_var['lang']['category']; ?>：</td>
                  <td><select name="category" id="select" style="border:1px solid #ccc;">
                      <option value="0"><?php echo $this->_var['lang']['all_category']; ?></option>
                      
                    <?php echo $this->_var['cat_list']; ?>
                  
                    </select></td>
                </tr>
                <tr>
                  <td><?php echo $this->_var['lang']['brand']; ?>：</td>
                  <td><select name="brand" id="brand" style="border:1px solid #ccc;">
                      <option value="0"><?php echo $this->_var['lang']['all_brand']; ?></option>
                      
                    
            <?php echo $this->html_options(array('options'=>$this->_var['brand_list'],'selected'=>$this->_var['adv_val']['brand'])); ?>
          
                  
                    </select></td>
                </tr>
                <tr>
                  <td><?php echo $this->_var['lang']['price']; ?>：</td>
                  <td><input name="min_price" type="text" id="min_price" class="inputBg" value="<?php echo $this->_var['adv_val']['min_price']; ?>" size="10" maxlength="8" />
                    -
                    <input name="max_price" type="text" id="max_price" class="inputBg" value="<?php echo $this->_var['adv_val']['max_price']; ?>" size="10" maxlength="8" /></td>
                </tr>
                <?php if ($this->_var['goods_type_list']): ?>
                <tr>
                  <td><?php echo $this->_var['lang']['extension']; ?>：</td>
                  <td><select name="goods_type" onchange="this.form.submit()" style="border:1px solid #ccc;">
                      <option value="0"><?php echo $this->_var['lang']['all_option']; ?></option>
                      
                    
            <?php echo $this->html_options(array('options'=>$this->_var['goods_type_list'],'selected'=>$this->_var['goods_type_selected'])); ?>
          
                  
                    </select></td>
                </tr>
                <?php endif; ?> 
                <?php if ($this->_var['goods_type_selected'] > 0): ?> 
                <?php $_from = $this->_var['goods_attributes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?> 
                <?php if ($this->_var['item']['type'] == 1): ?>
                <tr>
                  <td><?php echo $this->_var['item']['attr']; ?>：</td>
                  <td colspan="3"><input name="attr[<?php echo $this->_var['item']['id']; ?>]" value="<?php echo $this->_var['item']['value']; ?>" class="inputBg" type="text" size="20" maxlength="120" /></td>
                </tr>
                <?php endif; ?> 
                <?php if ($this->_var['item']['type'] == 2): ?>
                <tr>
                  <td><?php echo $this->_var['item']['attr']; ?>：</td>
                  <td colspan="3"><input name="attr[<?php echo $this->_var['item']['id']; ?>][from]" class="inputBg" value="<?php echo $this->_var['item']['value']['from']; ?>" type="text" size="5" maxlength="5" />
                    -
                    <input name="attr[<?php echo $this->_var['item']['id']; ?>][to]" value="<?php echo $this->_var['item']['value']['to']; ?>"  class="inputBg" type="text" maxlength="5" /></td>
                </tr>
                <?php endif; ?> 
                <?php if ($this->_var['item']['type'] == 3): ?>
                <tr>
                  <td><?php echo $this->_var['item']['attr']; ?>：</td>
                  <td colspan="3"><select name="attr[<?php echo $this->_var['item']['id']; ?>]" style="border:1px solid #ccc;">
                      <option value="0"><?php echo $this->_var['lang']['all_option']; ?></option>
                      
                    
            <?php echo $this->html_options(array('options'=>$this->_var['item']['options'],'selected'=>$this->_var['item']['value'])); ?>
          
                  
                    </select></td>
                </tr>
                <?php endif; ?> 
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
                <?php endif; ?> 
                
                <?php if ($this->_var['use_storage'] == 1): ?>
                <tr>
                  <td>&nbsp;</td>
                  <td><label for="outstock"><input type="checkbox" name="outstock" value="1" id="outstock" <?php if ($this->_var['outstock']): ?>checked="checked"<?php endif; ?>/> <?php echo $this->_var['lang']['hidden_outstock']; ?></label></td>
                </tr>
                <?php endif; ?>
                
                <tr>
                  <td colspan="4" align="center"><input type="hidden" name="action" value="form" />
                    <input type="submit" name="Submit" class="bnt_blue_1" value="<?php echo $this->_var['lang']['button_search']; ?>" /></td>
                </tr>
              </table>
            </form>
          </div>
        </div>
      </div>
      <div class="blank5"></div>
      <?php endif; ?> 
      
      <?php if (isset ( $this->_var['goods_list'] )): ?>
      <div class="box">
        <div id="filter">
          <div class='fore1' style="border:none;">
            <dl class='order'>
              <dt> <?php if ($this->_var['intromode'] == 'best'): ?> 
                <span><?php echo $this->_var['lang']['best_goods']; ?></span> 
                <?php elseif ($this->_var['intromode'] == 'new'): ?> 
                <span><?php echo $this->_var['lang']['new_goods']; ?></span> 
                <?php elseif ($this->_var['intromode'] == 'hot'): ?> 
                <span><?php echo $this->_var['lang']['hot_goods']; ?></span> 
                <?php elseif ($this->_var['intromode'] == 'promotion'): ?> 
                <span><?php echo $this->_var['lang']['promotion_goods']; ?></span> 
                <?php else: ?> 
                <span><?php echo $this->_var['lang']['search_result']; ?></span> 
                <?php endif; ?>&nbsp;&nbsp;</dt>
              <dd  class=<?php if ($this->_var['pager']['search']['sort'] == 'goods_id'): ?>curr<?php endif; ?>>
              	<a href="search.php?<?php $_from = $this->_var['pager']['search']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?><?php if ($this->_var['key'] != "sort" && $this->_var['key'] != "order"): ?><?php echo $this->_var['key']; ?>=<?php echo $this->_var['item']; ?>&<?php endif; ?><?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>page=<?php echo $this->_var['pager']['page']; ?>&sort=goods_id&order=<?php if ($this->_var['pager']['search']['order'] == 'DESC'): ?>ASC<?php else: ?>DESC<?php endif; ?>#list">上架
                <b class="icon-order-<?php if ($this->_var['pager']['search']['sort'] == 'goods_id'): ?><?php echo $this->_var['pager']['search']['order']; ?><?php else: ?>DESC<?php endif; ?>ending"></b></a>
              </dd>
              <dd class=<?php if ($this->_var['pager']['search']['sort'] == 'shop_price'): ?>curr<?php endif; ?>>
              	<a href="search.php?<?php $_from = $this->_var['pager']['search']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?><?php if ($this->_var['key'] != "sort" && $this->_var['key'] != "order"): ?><?php echo $this->_var['key']; ?>=<?php echo $this->_var['item']; ?>&<?php endif; ?><?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>page=<?php echo $this->_var['pager']['page']; ?>&sort=shop_price&order=<?php if ($this->_var['pager']['search']['order'] == 'DESC'): ?>ASC<?php else: ?>DESC<?php endif; ?>#list">价格
                <b class="icon-order-<?php if ($this->_var['pager']['search']['sort'] == 'shop_price'): ?><?php echo $this->_var['pager']['search']['order']; ?><?php else: ?>DESC<?php endif; ?>ending"></b></a>
              </dd>
              <dd  class=<?php if ($this->_var['pager']['search']['sort'] == 'last_update'): ?>curr<?php endif; ?>>
              	<a href="search.php?<?php $_from = $this->_var['pager']['search']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?><?php if ($this->_var['key'] != "sort" && $this->_var['key'] != "order"): ?><?php echo $this->_var['key']; ?>=<?php echo $this->_var['item']; ?>&<?php endif; ?><?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>page=<?php echo $this->_var['pager']['page']; ?>&sort=last_update&order=<?php if ($this->_var['pager']['search']['order'] == 'DESC'): ?>ASC<?php else: ?>DESC<?php endif; ?>#list">更新
                <b class="icon-order-<?php if ($this->_var['pager']['search']['sort'] == 'last_update'): ?><?php echo $this->_var['pager']['search']['order']; ?><?php else: ?>DESC<?php endif; ?>ending"></b></a>
              </dd>
              <dd  class=<?php if ($this->_var['pager']['search']['sort'] == 'click_count'): ?>curr<?php endif; ?>>
              	<a href="search.php?<?php $_from = $this->_var['pager']['search']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?><?php if ($this->_var['key'] != "sort" && $this->_var['key'] != "order"): ?><?php echo $this->_var['key']; ?>=<?php echo $this->_var['item']; ?>&<?php endif; ?><?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>page=<?php echo $this->_var['pager']['page']; ?>&sort=click_count&order=<?php if ($this->_var['pager']['search']['order'] == 'DESC'): ?>ASC<?php else: ?>DESC<?php endif; ?>#list">人气
                <b class="icon-order-<?php if ($this->_var['pager']['search']['sort'] == 'click_count'): ?><?php echo $this->_var['pager']['search']['order']; ?><?php else: ?>DESC<?php endif; ?>ending"></b></a>
              </dd>
            </dl>
            <div class='pagin pagin-m'><span class='text'><font><?php echo $this->_var['pager']['page']; ?></font>/<?php echo $this->_var['pager']['page_count']; ?></span><?php if ($this->_var['pager']['page_prev']): ?> 
              <a href="<?php echo $this->_var['pager']['page_prev']; ?>" class="prev" >&lt;</a> 
              <?php else: ?> 
              <span class="prev-disabled">&lt;</span> 
              <?php endif; ?> 
              <?php if ($this->_var['pager']['page_next']): ?> 
              <a href="<?php echo $this->_var['pager']['page_next']; ?>" class="next" >&gt;</a> 
              <?php else: ?> 
              <span class="next-disabled">&gt;</span> 
              <?php endif; ?></div>
            <div class='total'><span>共<strong><?php echo $this->_var['pager']['record_count']; ?></strong>个商品</span></div>
            <span class='clr'></span></div>
        </div>
        <?php if ($this->_var['goods_list']): ?>
        <form action="compare.php" method="post" name="compareForm" id="compareForm" onsubmit="return compareGoods(this);">
          
          <?php if ($this->_var['beizhuxinxi_www_68ecshop_com']): ?>
          <div style="width:100%;height:50px;margin:10px 0;overflow:hidden;text-align:center;"> <?php echo $this->_var['beizhuxinxi_www_68ecshop_com']; ?> </div>
          <?php endif; ?>
          
          <div class="squares" nc_type="current_display_mode">
            <ul class="list_pic">
              <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['name']['iteration']++;
?> 
              <?php if ($this->_var['goods']['goods_id']): ?>
              <li id="li_<?php echo $this->_var['goods']['goods_id']; ?>" class="item" <?php if ($this->_foreach['name']['iteration'] % 4 == 1): ?>style="margin-left:0px;"<?php endif; ?>>
                <div class="goods-content" style="position:relative">
                <?php if ($this->_var['goods']['is_hot'] == 1): ?><span class="little_pic">爆款</span><?php endif; ?> 
		<?php if ($this->_var['goods']['is_best'] == 1): ?><span class="little_pic">精品</span><?php endif; ?>
		<?php if ($this->_var['goods']['is_new'] == 1): ?><span class="little_pic">新品</span><?php endif; ?> 
                  <div class="goods-pic">
                  	<a href="<?php echo $this->_var['goods']['url']; ?>" target="_blank" title="<?php echo htmlspecialchars($this->_var['goods']['name']); ?>">
                    	<img data-original="<?php echo $this->_var['goods']['goods_thumb']; ?>" src="themes/68ecshopcom_360buy/images/loading.gif" title="<?php echo htmlspecialchars($this->_var['goods']['name']); ?>" class="pic_img_<?php echo $this->_var['goods']['goods_id']; ?>">
                    </a>
		    <?php if ($this->_var['goods']['goods_number'] == 0): ?><div class="shop_over1"></div><?php endif; ?>
                  </div>
                  <div class="goods-info"> 
                    <div class="goods-name">
                    	<a href="<?php echo $this->_var['goods']['url']; ?>" target="_blank" title="<?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?>"><?php echo $this->_var['goods']['goods_name_www_68ecshop_com']; ?><em></em></a>
                    </div>
                    <div class="goods-price"> 
                    	<em class="sale-price" title="本店价<?php if ($this->_var['goods']['promote_price'] != ""): ?><?php echo $this->_var['goods']['promote_price']; ?><?php else: ?><?php echo $this->_var['goods']['shop_price']; ?><?php endif; ?>">
                        <?php if ($this->_var['goods']['promote_price'] != ""): ?>
                        <?php echo $this->_var['goods']['promote_price']; ?>
                        <?php else: ?>
                        <?php echo $this->_var['goods']['shop_price']; ?>
                        <?php endif; ?>
                        </em> 
                        <em class="market-price" title=""><?php echo $this->_var['goods']['market_price']; ?></em>
                    </div>
                    <div class="sell-stat">
                      <ul>
                        <li><a href="<?php echo $this->_var['goods']['url']; ?>" target="_blank" class="status"><?php echo $this->_var['goods']['count']; ?></a>
                          <p>商品销量</p>
                        </li>
                        <li><a href="<?php echo $this->_var['goods']['url']; ?>#product-detail" target="_blank"><?php echo $this->_var['goods']['comment_count']; ?></a>
                          <p>用户评论</p>
                        </li>
                        <li><em member_id="46"><a class="chat chat_offline" href="javascript:;"><?php echo $this->_var['goods']['click_count']; ?></a>&nbsp;</em>
                          <p>关注人气</p>
                        </li>
                      </ul>
                    </div>
                    <div class="store"> 
                    	<a id="collect_<?php echo $this->_var['goods']['goods_id']; ?>" href="javascript:collect(<?php echo $this->_var['goods']['goods_id']; ?>); re_collect(<?php echo $this->_var['goods']['goods_id']; ?>)" class="collet-btn<?php if ($this->_var['goods']['is_collet'] == 1): ?> collet-btn-t<?php endif; ?>"></a> 
                        <a class="compare-btn shop-compare" data-goods="<?php echo $this->_var['goods']['goods_id']; ?>" data-type="<?php echo $this->_var['goods']['type']; ?>" onclick="Compare.add(<?php echo $this->_var['goods']['goods_id']; ?>,'<?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?>','<?php echo $this->_var['goods']['type']; ?>', '<?php echo $this->_var['goods']['goods_thumb']; ?>', '<?php if ($_SESSION['user_name']): ?><?php if ($this->_var['goods']['is_promote'] && $this->_var['goods']['gmt_end_time']): ?><?php echo $this->_var['goods']['promote_price']; ?><?php else: ?><?php echo $this->_var['goods']['shop_price_formated']; ?> <?php endif; ?><?php else: ?><?php echo $this->_var['goods']['market_price']; ?><?php endif; ?>')"></a> 
                    </div>
                    <div class="add-cart"> <a href="javascript:addToCart(<?php echo $this->_var['goods']['goods_id']; ?>)" nctype="add_cart"><i class="icon-shopping-cart"></i>加入购物车</a> </div>
                  </div>
                </div>
              </li>
              <?php endif; ?> 
              <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </ul>
          </div>
        </form>
        <script type="text/javascript">
        <?php $_from = $this->_var['lang']['compare_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
        var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

                                <?php $_from = $this->_var['lang']['compare_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
        <?php if ($this->_var['key'] != 'button_compare'): ?>
        var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
        <?php else: ?>
        var button_compare = '';
        <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>


        var compare_no_goods = "<?php echo $this->_var['lang']['compare_no_goods']; ?>";
        window.onload = function()
        {
          Compare.init();
          fixpng();
        }
        var btn_buy = "<?php echo $this->_var['lang']['btn_buy']; ?>";
        var is_cancel = "<?php echo $this->_var['lang']['is_cancel']; ?>";
        var select_spe = "<?php echo $this->_var['lang']['select_spe']; ?>";
        </script> 
        <?php else: ?>
        <div style="padding:20px 0px; text-align:center" class="f5" ><?php echo $this->_var['lang']['no_search_result']; ?></div>
        <?php endif; ?> 
      </div>
      <div class="blank"></div>
      <?php echo $this->fetch('library/pages.lbi'); ?> 
      <?php endif; ?> 
    </div>
    <div class="left"> <?php echo $this->fetch('library/category_tree.lbi'); ?>
      <div style="height:10px; line-height:10px; clear:both;"></div>
      <?php echo $this->fetch('library/top10.lbi'); ?> </div>
     
   </div>
   <div style="height:0px; line-height:0px; clear:both;"></div>
   <?php echo $this->fetch('library/history.lbi'); ?>
  <div class="blank"></div>
    <?php echo $this->fetch('library/arrive_notice_list.lbi'); ?>
  <?php echo $this->fetch('library/help.lbi'); ?> 
  <?php echo $this->fetch('library/page_footer.lbi'); ?> 
  <?php echo $this->fetch('library/site_bar.lbi'); ?> 
</div>
<script type="text/javascript" src="themes/68ecshopcom_360buy/js/lib-v1.js"></script>
</body>

<script type="text/javascript" src="<?php echo $this->_var['option']['static_path']; ?>js/compare.js"></script>
<script type="text/javascript" src="<?php echo $this->_var['option']['static_path']; ?>js/json2.js"></script>
<script>
$(document).ready(function(e) {
	Compare.init();
    $('#compareBox .menu li').click(function(e) {
		$('#compareBox .menu li').each(function(index, element) {
			$(this).removeClass('current');
        });
		if($(this).attr('data-value') == 'compare')
		{
			$('#historyList').css('display', 'none');
			$('#compareList').css('display', 'block');
		}
		else
		{
			$('#historyList').css('display', 'block');
			$('#compareList').css('display', 'none');
		}
        $(this).addClass('current');
    });
	if($('#historyList li').length > 4)
	{
		$('#historyList ul').css('width', (226*$('#historyList li').length)+'px');
		$('#historyList #sc-prev').addClass('disable');
		var count = 0;
		$('#historyList #sc-next').click(function(e) {
			if(($('#historyList li').length-4) > count)
			{
				count++;
				$('#historyList #sc-prev').removeClass('disable');
				if(($('#historyList li').length-4) >= count)
					$('#historyList ul').animate({marginLeft:(-226*count)+'px'});
				if(($('#historyList li').length-4) == count)
					$('#historyList #sc-next').addClass('disable');
			}
        });
		$('#historyList #sc-prev').click(function(e) {
			if(count > 0)
			{
				count--;
				$('#historyList #sc-next').removeClass('disable');
				if(count >= 0)
					$('#historyList ul').animate({marginLeft:(-226*count)+'px'});
				if(count == 0)
					$('#historyList #sc-prev').addClass('disable');
			}
        });
	}
	else
	{
		$('#historyList #sc-prev').css('display', 'none');
		$('#historyList #sc-next').css('display', 'none');
	}
	var compareData = new Object();
	var compareCookie = document.getCookie('compareItems');
	var count = 0;
	if(compareCookie != null)
	{
		compareData = JSON.parse(compareCookie);
        for(var k in compareData)
        {
            if(typeof(compareData[k])=="function")
            	continue;
            $('.compare-btn').each(function(index, element) {
            	if(k == $(this).attr('data-goods'))
					$(this).css('background-position', '0 -99px');
        	});
			count ++;
        }
	}
	if(count>0)
	{
		$('#compareBox').css('display', 'block');
		$('.compareHolder').css('display', 'none');
	}
	
});
function toggle_compare_box()
{
	if($('#compareBox').css('display') == 'none')
	{
		$('#compareBox').css('display', 'block');
		$('.compareHolder').css('display', 'none');
	}
	else
	{
		$('#compareBox').css('display', 'none');
		$('.compareHolder').css('display', 'block');
	}
}
</script>
<div align="center" id="compareBox" style="display:none">
  <div class="menu">
    <ul>
      <li class="current" data-value='compare'>对比栏</li>
      <li data-value='history'>最近浏览</li>
    </ul>
    <a style="color:#005AA0;float: right; line-height: 32px; margin-right: 20px;" href="javascript:void(0)" onClick="toggle_compare_box()">隐藏</a>
    <div style="clear:both"></div>
  </div>
  <div id="compareList"></div>
  <div id="historyList" style="display:none;"><span id="sc-prev" class="sc-prev scroll-btn"></span><span id="sc-next" class="sc-next scroll-btn"></span>
    <div class="scroll_wrap"><?php 
$k = array (
  'name' => 'history_list',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?></div>
  </div>
</div>
<a class="compareHolder" href="javascript:void(0)" onClick="toggle_compare_box()">对比栏</a>

<script>
re_collect();

function re_collect(id)
{
  goods_id = (typeof(id) == "undefined" ? 0 : id);
  Ajax.call('user.php?act=re_collect', 'id=' + goods_id, re_collectResponse, 'GET', 'JSON');
}

function re_collectResponse(result)
{
  if (result.goods_id > 0)
  {
    document.getElementById("collect_" + result.goods_id).className = (result.is_collect == 1 ? "collet-btn collet-btn-t" : "collet-btn");
  }
  else
  {
    $("a[id^='collect_']").className = "collet-btn";
    for(i = 0; i < result.is_collect.length; i++)
    {
      document.getElementById("collect_" + result.is_collect[i]).className = "collet-btn collet-btn-t";
    }
  }
}

var skuIds = [];
$('ul.list-h li[sku]').each(function(i){
    skuIds.push($(this).attr('sku'));
})

var imgSize = 'n2';
if ( $('#plist').hasClass('plist-160') ) {
    imgSize = 'n2';
}
if ( $('#plist').hasClass('plist-220') ) {
    if ( $('#plist').hasClass('plist-160') ) {
        imgSize = 'n2';
    } else {
        imgSize = 'n7';
    }
}
if ( $('#plist').hasClass('plist-n7') ) {
    imgSize = 'n7';
}
if ( $('#plist').hasClass('plist-n8') ) {
    imgSize = 'n8';
}


$('.p-scroll').each(function() {
    var scroll = $(this).find('.p-scroll-wrap'),
        btnPrev = $(this).find('.p-scroll-prev'),
        btnNext = $(this).find('.p-scroll-next'),
        len = $(this).find('li').length;
    if ( len > 5 ) {
        btnPrev.css('display', 'inline');
        btnNext.css('display', 'inline');
        scroll.imgScroll({
            visible: 5,
            showControl: false,
            next: btnNext,
            prev: btnPrev
        });
    }
    var colors = scroll.find('img');
    colors.each(function() {
        $(this).mouseover(function() {
            var index = $(this).parent('li').parent('li').attr('index');
            var src = $(this).attr("src"),
                skuid = $(this).attr('data-skuid');
            scroll.find('a').removeClass('curr');
            $(this).parent('a').addClass('curr');
            var targetImg = $(this).parents('li').find('.p-img img').eq(0),
                targetImgLink = $(this).parents('li').find('.p-img a').eq(0),
                targetNameLink = $(this).parents('li').find('.p-name a').eq(0),
                targetFollowLink = $(this).parents('li').find('.product-follow a').eq(0);
            targetImg.attr( 'src', src.replace('\/n5\/', '\/'+imgSize+'\/') );
            targetImgLink.attr( 'href', targetImgLink.attr('href').replace(/\/\d{6,}/, '/'+skuid) );
            targetNameLink.attr( 'href', targetNameLink.attr('href').replace(/\/\d{6,}/, '/'+skuid) );
            targetFollowLink.attr( 'id', targetFollowLink.attr('id').replace(/coll\d{6,}/, 'coll'+skuid) );

        });
    });
});
$('#plist.plist-n7 .list-h>li').hover(function() {
    $(this).addClass('hover').find('.product-follow,.shop-name').show();
    $(this).find('.item-wrap').addClass('item-hover');
}, function() {
    $(this).removeClass('hover').find('.item-wrap').removeClass('item-hover');
    $(this).find('.product-follow,.shop-name').hide();
});


/* spu合并 end */
</script>
<script type="text/javascript">
$("img").lazyload({
    effect       : "fadeIn",
	 skip_invisible : true,
	 failure_limit : 20
});
</script>
</html>
