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
<link rel="stylesheet" type="text/css" href="themes/68ecshopcom_360buy/css/<?php echo $this->_var['cat_style']; ?>" />
<script type="text/javascript" src="themes/68ecshopcom_360buy/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="themes/68ecshopcom_360buy/js/search_goods.js"></script>
<script type="text/javascript" src="themes/68ecshopcom_360buy/js/jquery_006.js"></script>
<script type="text/javascript" src="themes/68ecshopcom_360buy/js/base-2011.js"></script>
<script type="text/javascript" src="themes/68ecshopcom_360buy/js/jquery-lazyload.js" ></script>
<?php echo $this->smarty_insert_scripts(array('files'=>'jquery.json.js,transport.js')); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'common.js')); ?>
</head>
<body>
<div id="site-nav"> 
  <?php echo $this->fetch('library/page_header.lbi'); ?>
  <div class="first-show"> 
    <?php echo $this->fetch('library/ad.lbi'); ?>
    <div class="w">
      <div id="main-nav" class="mainnav">
        <div class="navbox">
          <div class="float-list" id="float-list"> 
            <?php $_from = get_categories_tree(0); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');$this->_foreach['cat0'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['cat0']['total'] > 0):
    foreach ($_from AS $this->_var['cat']):
        $this->_foreach['cat0']['iteration']++;
?> 
            <?php if ($this->_var['current_cat_pr_id'] == $this->_var['cat']['id']): ?> 
            <?php $_from = $this->_var['cat']['cat_id']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'child');$this->_foreach['namechild'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['namechild']['total'] > 0):
    foreach ($_from AS $this->_var['child']):
        $this->_foreach['namechild']['iteration']++;
?>
            <dl id="webf<?php echo $this->_foreach['namechild']['iteration']; ?>">
              <dt class=""> <strong style="background-position: -464px -62px;"><a href="<?php echo $this->_var['child']['url']; ?>"><?php echo htmlspecialchars($this->_var['child']['name']); ?></a></strong>
                <p> 
                  <?php $_from = $this->_var['child']['cat_id']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'childer');if (count($_from)):
    foreach ($_from AS $this->_var['childer']):
?> 
                  <a href="<?php echo $this->_var['childer']['url']; ?>" class="" title="<?php echo $this->_var['childer']['name']; ?>"><?php echo $this->_var['childer']['name']; ?></a> 
                  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
                </p>
                <b class="arrow-right"></b> 
              </dt>
              <dd style="top: 0px; min-height:108px;">
                <ul class="secondlist">
                  <li> <strong style="background-position: -464px -80px;"><a href="<?php echo $this->_var['child']['url']; ?>"><?php echo htmlspecialchars($this->_var['child']['name']); ?></a></strong>
                    <div class="float-list-cont"> 
                      <?php $_from = $this->_var['child']['cat_id']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'childer');if (count($_from)):
    foreach ($_from AS $this->_var['childer']):
?> 
                      <a href="<?php echo $this->_var['childer']['url']; ?>" class="" title="<?php echo $this->_var['childer']['name']; ?>"><?php echo $this->_var['childer']['name']; ?></a> 
                      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
                    </div>
                  </li>
                </ul>
              </dd>
            </dl>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
            <?php endif; ?> 
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
          </div>
        </div>
      </div>
      <script type="text/javascript" src="themes/68ecshopcom_360buy/js/categories_nav.js"></script> 
    </div>
    <div style="clear:both"></div>
    <div class="image-box1">
      <?php
		 $GLOBALS['smarty']->assign('index_image1',get_advlist('频道页-分类ID'.$GLOBALS['smarty']->_var['category'].'-图片1', 1));
	  ?>
      <?php $_from = $this->_var['index_image1']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'ad');$this->_foreach['index_image'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['index_image']['total'] > 0):
    foreach ($_from AS $this->_var['ad']):
        $this->_foreach['index_image']['iteration']++;
?> 
      <a href="<?php echo $this->_var['ad']['url']; ?>" target="_blank">
      	<img src="themes/68ecshopcom_360buy/images/loading.gif" data-original="<?php echo $this->_var['ad']['image']; ?>"  height="187" width="510">
      </a> 
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      <?php
		 $GLOBALS['smarty']->assign('index_image2',get_advlist('频道页-分类ID'.$GLOBALS['smarty']->_var['category'].'-图片2', 1));
	  ?>
      <?php $_from = $this->_var['index_image2']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'ad');$this->_foreach['index_image'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['index_image']['total'] > 0):
    foreach ($_from AS $this->_var['ad']):
        $this->_foreach['index_image']['iteration']++;
?> 
      <a href="<?php echo $this->_var['ad']['url']; ?>" target="_blank">
      	<img src="themes/68ecshopcom_360buy/images/loading.gif" data-original="<?php echo $this->_var['ad']['image']; ?>" height="187" width="340">
      </a> 
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      <?php
		 $GLOBALS['smarty']->assign('index_image3',get_advlist('频道页-分类ID'.$GLOBALS['smarty']->_var['category'].'-图片3', 1));
	  ?>
      <?php $_from = $this->_var['index_image3']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'ad');$this->_foreach['index_image'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['index_image']['total'] > 0):
    foreach ($_from AS $this->_var['ad']):
        $this->_foreach['index_image']['iteration']++;
?> 
      <a href="<?php echo $this->_var['ad']['url']; ?>" target="_blank" style="margin-right:0px">
      	<img src="themes/68ecshopcom_360buy/images/loading.gif" data-original="<?php echo $this->_var['ad']['image']; ?>"  height="187" width="340">
      </a> 
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
    </div>
  </div>
  <div class="blank10"></div>
  
  <?php $_from = $this->_var['childcat_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['cat']):
        $this->_foreach['name']['iteration']++;
?>
  <div class="floorWrapper">
    <div class="mt">
      <h2><?php echo $this->_foreach['name']['iteration']; ?>F<span><?php echo $this->_var['cat']['cat_name']; ?></span></h2>
      <a href="<?php echo $this->_var['cat']['url']; ?>" target="_blank" class="category_more">更多 &gt;</a> </div>
    <script type="text/javascript"> 
$(document).ready(function(){ 
$(".itemOuter .itemWrapper").mouseover(function(){ 
$(this).addClass("itemWrapper_hover"); 
}); 
$(".itemOuter .itemWrapper").mouseout(function(){ 
$(this).removeClass("itemWrapper_hover"); 
}); 
}); 
</script>
    <div class="floorContent"> 
    <?php $_from = $this->_var['cat']['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'catgoods');$this->_foreach['cat_children'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['cat_children']['total'] > 0):
    foreach ($_from AS $this->_var['catgoods']):
        $this->_foreach['cat_children']['iteration']++;
?>
      <div class="itemOuter"  id="li_<?php echo $this->_var['catgoods']['goods_id']; ?>">
        <div class="itemWrapper"> 
          <a class="add_to_cart" href="javascript:addToCart(<?php echo $this->_var['catgoods']['goods_id']; ?>)" title="加入购物车"></a>
          <a href="<?php echo $this->_var['catgoods']['url']; ?>" title='<?php echo htmlspecialchars($this->_var['catgoods']['goods_name']); ?>' target="_blank" class="itemImg">
            <img data-original="<?php echo $this->_var['catgoods']['goods_thumb']; ?>" src="themes/68ecshopcom_360buy/images/loading.gif"  class="pic_img_<?php echo $this->_var['catgoods']['goods_id']; ?>" height="160" width="160"> 
          </a>
          <p><a href="<?php echo $this->_var['catgoods']['url']; ?>" title='<?php echo htmlspecialchars($this->_var['catgoods']['goods_name']); ?>' target="_blank" class="itemName"> <?php echo $this->_var['catgoods']['goods_name']; ?></a></p>
          <div class="priceSection">
            <div class="priceNumber"> <span class="mainPrice"> <?php if ($this->_var['catgoods']['promote_price'] > 0): ?>
              <?php echo $this->_var['catgoods']['promote_price']; ?>
              <?php else: ?>
              <?php echo $this->_var['catgoods']['shop_price']; ?>
              <?php endif; ?> </span> <span class="subPrice"><del><?php echo $this->_var['catgoods']['market_price']; ?></del></span> 
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
    </div>
  </div>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  <div class="blank"></div>
  <?php echo $this->fetch('library/history.lbi'); ?>
  <div class="blank"></div>
    <?php echo $this->fetch('library/arrive_notice_list.lbi'); ?>
  <?php echo $this->fetch('library/help.lbi'); ?> 
  <?php echo $this->fetch('library/page_footer.lbi'); ?> 
  <?php echo $this->fetch('library/site_bar.lbi'); ?> 
</div>
<script type="text/javascript" src="themes/68ecshopcom_360buy/js/lib-v1.js"></script> 
<script>//收集skuId
var skuIds = [];
$('ul.list-h li[sku]').each(function(i){
    skuIds.push($(this).attr('sku'));
})

/* spu合并 begin */
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
$(document).ready(function(){
var headHeight=580;  //这个高度其实有更好的办法的。使用者根据自己的需要可以手工调整。
 
var nav=$("#filter");        //要悬浮的容器的id
$(window).scroll(function(){
 
if($(this).scrollTop()>headHeight){
nav.addClass("cat-nav-fixed");   //悬浮的样式
}
else{
nav.removeClass("cat-nav-fixed");
}
})
})
</script> 

<script type="text/javascript">
$("img").lazyload({
    effect       : "fadeIn",
	 skip_invisible : true,
	 failure_limit : 20
});
</script> 
<script type="text/javascript">
window.onload = function()
{
  Compare.init();
}
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
var btn_buy = "<?php echo $this->_var['lang']['btn_buy']; ?>";
var is_cancel = "<?php echo $this->_var['lang']['is_cancel']; ?>";
var select_spe = "<?php echo $this->_var['lang']['select_spe']; ?>";
</script>
</body>
</html>