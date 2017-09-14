<script type="text/javascript">
var process_request = "<?php echo $this->_var['lang']['process_request']; ?>";
</script>
<div id="sn-bd">
  <div class="sn-container"> 
  	<?php echo $this->smarty_insert_scripts(array('files'=>'utils.js,common.min.js')); ?>
    <font id="login-info" class="sn-login-info">
    	<?php 
$k = array (
  'name' => 'member_info',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?>
    </font>
    <ul class="sn-quick-menu">
      <li class="sn-mytaobao menu-item j_MyTaobao">
        <div class="sn-menu">
        	<a aria-haspopup="menu-2" tabindex="0" class="menu-hd" href="user.php" target="_top" rel="nofollow">我的信息<b></b></a>
          	<div id="menu-2" class="menu-bd">
            	<div class="menu-bd-panel" id="myTaobaoPanel">
                	<a href="user.php?act=order_list" target="_top" rel="nofollow">已买到的宝贝</a> 
                    <a href="user.php?act=address_list" target="_top" rel="nofollow">我的地址管理</a> 
               </div>
          </div>
        </div>
      </li>
      <li class="sn-mybrand">
      	<a target="_top" id="J_SnMyBrand" class="sn-mybrand-link mui-global-iconfont" href="user.php?act=follow_shop">我关注的店铺</a> 
      </li>
      <li class="sn-cart mini-cart menu">
      	<a id="mc-menu-hd" class="sn-cart-link mui-global-iconfont" href="flow.php" target="_top" rel="nofollow">购物车</a>
      </li>
      <li class="sn-favorite menu-item">
        <div class="sn-menu"> 
        	<a aria-haspopup="menu-4" tabindex="0" class="menu-hd" href="user.php?act=collection_list" target="_top" rel="nofollow">收藏夹<b></b></a>
          	<div id="menu-4" class="menu-bd">
            	<div class="menu-bd-panel"> 
                	<a href="user.php?act=collection_list" target="_top" rel="nofollow">收藏的宝贝</a> 
                    <a href="user.php?act=follow_shop" target="_top" rel="nofollow">收藏的店铺</a> 
                </div>
          </div>
        </div>
      </li>
      <li class="sn-separator"></li>
      <script type="text/javascript">
		function show_qcord(){
			var qs=document.getElementById('sn-qrcode');
			qs.style.display="block";
		}
		function hide_qcord(){
			var qs=document.getElementById('sn-qrcode');
			qs.style.display="none";
		}
	  </script>
      <li class="menu-item">
      	<div class="sn-menu">
        <a aria-haspopup="menu-6" tabindex="0" class="menu-hd sn-mobile-link" href="" target="_top">手机版<b></b></a>
        <div class="menu-bd sn-qrcode" id="menu-5">
          <ul>
            <li class="app_xiazai">
              <a href="#" target="_top" class="app_store"></a>
              <img src="themes/68ecshopcom_360buy/images/app.jpg" alt="手机客户端" width="76px" height="76px" />               
            </li>
            <li class="app_xiazai1">
              <a href="#" target="_top" class="app_android"></a> 
              <img src="themes/68ecshopcom_360buy/images/android.jpg" alt="手机客户端" width="76px" height="76px" /> 
            </li>
           
          </ul>
        </div>
        </div>
      </li>
      <li class="sn-seller menu-item">
        <div class="sn-menu J_DirectPromo">
        <a aria-haspopup="menu-6" tabindex="0" class="menu-hd" href="" target="_top">商家支持<b></b></a>
        <div class="menu-bd" id="menu-6">
          <ul>
            <li>
              <h3>商家：</h3>
              <?php $_from = $this->_var['navigator_list']['top']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'nav');$this->_foreach['nav_top_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['nav_top_list']['total'] > 0):
    foreach ($_from AS $this->_var['nav']):
        $this->_foreach['nav_top_list']['iteration']++;
?> 
              <a href="<?php echo $this->_var['nav']['url']; ?>" <?php if ($this->_var['nav']['opennew'] == 1): ?>target="_blank" <?php endif; ?>><?php echo $this->_var['nav']['name']; ?></a> 
              <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
            </li>
            <li>
              <h3>帮助：</h3>
              <a href="help.php" target="_top" title="帮助中心">帮助中心</a> 
            </li>
          </ul>
        </div>
      </li>
      <li class="sn-sitemap">
        <div class="sn-menu">
          <h3 class="menu-hd" tabindex="0" aria-haspopup="menu-8"><span class="sn-site-link">网站导航</span><b></b></h3>
          <div class="menu-bd sn-sitemap-bd" id="menu-8">
            <div class="site-cont site-hot">
              <h2>平台管理中心<span>Platform</span></h2>
              <ul class="site-list">
                <li><a href="/admin">平台PC端后台 </a></li>
                <li><a href="/mobile/admin">平台手机端后台 </a></li>
              </ul>
            </div>
            <div class="site-cont site-market">
              <h2>商家管理中心<span>Management</span></h2>
              <ul class="site-list">
                <li><a href="/supplier">商家PC端后台 </a></li>
                <li><a href="/mobile/supplier">商家手机端后台 </a></li>
              </ul>
            </div>
            <div class="site-cont site-brand">
              <h2>关于我们<span>About</span></h2>
              <ul class="site-list">
                <li><a href="http://hongyuvip.com">鸿宇科技有限公司 </a></li>
              </ul>
            </div>
          </div>
        </div>
      </li>
    </ul>
  </div>
</div>
</div>
<script>
header_login();
function header_login()
{	
	Ajax.call('login_act_ajax.php', '', loginactResponse, 'GET', 'JSON', '1', '1');
}
function loginactResponse(result)
{
	var MEMBERZONE =document.getElementById('login-info');
	MEMBERZONE.innerHTML= result.memberinfo;
}
</script>