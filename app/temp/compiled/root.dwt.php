<div id="page_0" class="up ub ub-ver bc-bg" tabindex="0">
	
	<div id="header" class="ub">
		
		<div class="uh bc-text-head ub bc-head1 maxh head-h ubb border-red" id="header0" status_bar_color='0'>
			<div class="nav-btn1 ub-ver qrcode_button" id="qrcode_button_1">
				<div class="ub-img top-left"></div>
				<div class="tx-c ulev-2 m-top2">
					扫码
				</div>
			</div>
			<div class="ub-f1 ub ub-ac uc-a1 sc-bg uinn-ele2 m-t-b1 search_button">
				<div class="uwh-ele1 ub-img ele-search"></div>
				<div class="ub-f1 ulev-9 sc-text-hui m-l2">
					请输入商品/店铺名称
				</div>
			</div>
			<div class="nav-btn1 ub-ver" id="message_button">
				<div class="ub-img top-right"></div>
				<div class="msg-circle ulev-2 f-color-red ub ub-pc ub-ac" id='message_count_label'>0</div>
				<div class="tx-c ulev-2 m-top2">
					消息
				</div>
			</div>
		</div>
		
		<div class="uh bc-text-head ub bc-head-glist maxh head-h" id="header1">
			<div class="ub-f2 ub ub-ac uc-a1 bg-color uinn-ele2 m-l1 m-t-b1 search_button">
				<div class="uwh-ele1 ub-img ele-search"></div>
				<div class="ub-f1 uinn1 sc-text-hui ulev-9">
					请输入商品/店铺名称
				</div>
			</div>
			<div class="nav-btn2 ub-ver qrcode_button" id="qrcode_button_2">
				<div class="ub-img top-right-c h-w-6"></div>
			</div>
		</div>
		
		<div class="uh ub ub-ac bc-head-grey maxh head-h" id="header2">
			<div class="nav-btn" id="nav-left"></div>
			<div class="ut ub-f1 ulev-3 ut-s tx-c bc-text">
				发现
			</div>
			<div class="nav-btn nav-bt" id="nav-right"></div>
		</div>
		
		<div class="uh ub ub-ac bc-head-grey maxh head-h" id="header3">
			<div class="nav-btn" id="nav-left"></div>
			<div class="ut ub-f1 ulev-3 ut-s tx-c bc-text">
				购物车
			</div>
			<div class="nav-btn nav-bt ulev-1 f-color-red p-r1" id="clear_cart_button">
				清空购物车
			</div>
		</div>
		
		<div class="uh ub ub-ac bc-head-grey maxh head-h" id="header4">
			<div class="nav-btn" id="nav-left"></div>
			<div class="ut ub-f1 ulev-3 ut-s tx-c bc-text">
				用户中心
			</div>
			<div class="nav-btn nav-bt" id="nav-right"></div>
		</div>
	</div>
	
	
	<div id="content" class="ub-f1 tx-l t-bla bg-color ub"></div>
	
	
	<div id="footer" class="uf t-bla ub foot-bg">
		<div class="ub ub-f1 ub-ver ub-pc ub-ac footer_menu footer-on" data-index="0">
			<div class="ub-img btm-icons home"></div>
			<div class="foot-font">
				<div>
					首页
				</div>
			</div>
		</div>
		<div class="ub ub-f1 ub-ver ub-pc ub-ac footer_menu" data-index="1">
			<div class="ub-img btm-icons list"></div>
			<div class="foot-font">
				<div>
					分类
				</div>
			</div>
		</div>
		<div class="ub ub-f1 ub-ver ub-pc ub-ac footer_menu" data-index="2">
			<div class="ub-img btm-icons discovery"></div>
			<div class="foot-font">
				<div>
					发现
				</div>
			</div>
		</div>
		<div class="ub ub-f1 ub-ver ub-pc ub-ac footer_menu" data-index="3">
			<div class="ub-img btm-icons cart">
				<div id='cart_num_label' class="cart_num_label_root">
					<div class="ub ub-ac ub-pc ulev-2"><?php echo empty($this->_var['cart_num']) ? '0' : $this->_var['cart_num']; ?></div>
				</div>
			</div>
			<div class="foot-font">
				<div>
					购物车
				</div>
			</div>
		</div>
		<div class="ub ub-f1 ub-ver ub-pc ub-ac footer_menu" data-index="4">
			<div class="ub-img btm-icons user"></div>
			<div class="foot-font">
				<div>
					个人中心
				</div>
			</div>
		</div>
	</div>
	
</div>
