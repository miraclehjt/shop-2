<?php if (! $this->_var['goodsid'] || $this->_var['goodsid'] == 0): ?>
<?php if ($this->_var['is_full_page'] == 1): ?>
<div class="uh ub ub-ac bc-head-grey maxh ubb border-top head-h" id="header">
            <div class="nav-btn1 _back">
                <div class="icon-back1 ub-img"></div>
            </div>
            <h1 class="ut ub-f1 ulev-3 ut-s tx-c bc-text ub-ac" tabindex="0" id="win_title">我的推荐</h1>
            <div class="nav-btn1 ulev-1 p-r1 f-color-red"></div>
        </div>
<div class="ub-ver">
	<div class="ub user_check bg-color-w">
		<div class="ub-f1 _tab selected" tab_key="0" id="tab_0"><font>分成规则</font></div>
		<div class="ub-f1 _tab" tab_key="1" id="tab_1"><font>我的分成</font></div>
		<div class="ub-f1 _tab" tab_key="2" id="tab_2"><font>分成代码</font></div>
	</div>
	<div class="_tab_content m-all2 bg-color-w ulev-1 p-all5 f-color-6 l-h-2" id="tab_content_0"><?php echo $this->_var['affiliate_intro']; ?></div>
	<div class="_tab_content ub-ver uhide m-all2 bg-color-w f-color-6 ulev-9 " id="tab_content_1">
		<?php if ($this->_var['affiliate']['config']['separate_by'] == 0): ?>
		
        <div class="p-all5 ubb border-top tx-l f-color-zi">
		<?php echo $this->_var['lang']['affiliate_member']; ?>
        </div>
		<div class="ub l-h-2">
		<table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#E7E7E7">
	  <tr align="center">
		<td bgcolor="#ffffff"><?php echo $this->_var['lang']['affiliate_lever']; ?></td>
		<td bgcolor="#ffffff"><?php echo $this->_var['lang']['affiliate_num']; ?></td>
		<td bgcolor="#ffffff"><?php echo $this->_var['lang']['level_point']; ?></td>
		<td bgcolor="#ffffff"><?php echo $this->_var['lang']['level_money']; ?></td>
	  </tr>
	  <?php $_from = $this->_var['affdb']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('level', 'val');$this->_foreach['affdb'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['affdb']['total'] > 0):
    foreach ($_from AS $this->_var['level'] => $this->_var['val']):
        $this->_foreach['affdb']['iteration']++;
?>
	  <tr align="center">
		<td bgcolor="#ffffff"><?php echo $this->_var['level']; ?></td>
		<td bgcolor="#ffffff"><?php echo $this->_var['val']['num']; ?></td>
		<td bgcolor="#ffffff"><?php echo $this->_var['val']['point']; ?></td>
		<td bgcolor="#ffffff"><?php echo $this->_var['val']['money']; ?></td>
	  </tr>
	  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	</table>
	</div>
	 
	  <?php else: ?> 
	   
	   
	  <?php endif; ?> 
	   <div class="p-all5 ubb border-top tx-l f-color-zi">分成明细</div>
	  <div class="ub l-h-2">
	  <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#E7E7E7" id="content_container">
	  <tr align="center">
		<td bgcolor="#ffffff"><?php echo $this->_var['lang']['order_number']; ?></td>
		<td bgcolor="#ffffff"><?php echo $this->_var['lang']['affiliate_money']; ?></td>
		<td bgcolor="#ffffff"><?php echo $this->_var['lang']['affiliate_point']; ?></td>
		<td bgcolor="#ffffff"><?php echo $this->_var['lang']['affiliate_mode']; ?></td>
		<td bgcolor="#ffffff"><?php echo $this->_var['lang']['affiliate_status']; ?></td>
	  </tr>
	  <?php endif; ?>
	  <?php $_from = $this->_var['logdb']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'val');$this->_foreach['logdb'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['logdb']['total'] > 0):
    foreach ($_from AS $this->_var['val']):
        $this->_foreach['logdb']['iteration']++;
?>
	  <tr align="center">
		<td bgcolor="#ffffff"><?php echo $this->_var['val']['order_sn']; ?></td>
		<td bgcolor="#ffffff"><?php echo $this->_var['val']['money']; ?></td>
		<td bgcolor="#ffffff"><?php echo $this->_var['val']['point']; ?></td>
		<td bgcolor="#ffffff"><?php if ($this->_var['val']['separate_type'] == 1 || $this->_var['val']['separate_type'] === 0): ?> 
		  <?php echo $this->_var['lang']['affiliate_type'][$this->_var['val']['separate_type']]; ?> 
		  <?php else: ?> 
		  <?php echo $this->_var['lang']['affiliate_type'][$this->_var['affiliate_type']]; ?> 
		  <?php endif; ?></td>
		<td bgcolor="#ffffff"><?php echo $this->_var['lang']['affiliate_stats'][$this->_var['val']['is_separate']]; ?></td>
	  </tr>
	  <?php endforeach; else: ?>
	  <tr>
		<td colspan="5" align="center" bgcolor="#ffffff"><?php echo $this->_var['lang']['no_records']; ?></td>
	  </tr>
	  <?php endif; unset($_from); ?><?php $this->pop_vars();; ?> 
	  <?php if ($this->_var['is_full_page'] == 1): ?>
	  </table>
	  </div>
	</div>
	<div class="_tab_content ub-ver uhide" id="tab_content_2">
		<div class="ub ub-ac ub-pc m-top5">
			<img src="<?php echo $this->_var['url']; ?>erweima_png.php?data=<?php echo $this->_var['url']; ?>?u=<?php echo $this->_var['userid']; ?>" />
		</div>
	<div class="ub-ver ubl border-top ub ub-ac ub-pc p-l-r1" id='share_button'>
          <div class="to-share ub-img"></div>
          <div class="m-top2 btn-red-2">分享</div>
        </div>
	</div>
</div>
<script>
	var img = "<?php echo $this->_var['url']; ?>erweima_png.php?data=<?php echo $this->_var['url']; ?>?u=<?php echo $this->_var['userid']; ?>"
	var title = "<?php echo $this->_var['page_title']; ?>"
	var url = "<?php echo $this->_var['url']; ?>?u=<?php echo $this->_var['userid']; ?>"
</script>
<?php endif; ?>
  <?php else: ?> 
  
  <div class="ub-ver">
	<div class="ub">
		<img src="<?php echo $this->_var['url']; ?><?php echo $this->_var['goods']['goods_thumb']; ?>" />
	</div>
	<div class="ub"><?php echo $this->_var['goods']['goods_name']; ?></div>
	<div class="ub-ver ubl border-top ub ub-ac ub-pc p-l-r1" id='share_button'>
          <div class="to-share ub-img"></div>
          <div class="sc-text-hui ulev-2 tx-c m-top2">分享</div>
        </div>
  </div>
  <script>
  var img = "<?php echo $this->_var['url']; ?><?php echo $this->_var['goods']['goods_thumb']; ?>"
  var title = "<?php echo $this->_var['goods']['goods_name']; ?>"
	var url = "<?php echo $this->_var['url']; ?>mobile/goods.php?id=<?php echo $this->_var['goodsid']; ?>&u=<?php echo $this->_var['userid']; ?>"
</script>
<?php endif; ?>
<?php if ($this->_var['is_full_page'] == 1): ?>

<div class="bc-grey  mfp-hide uinn-p2 p-b2" style="position:fixed; width:100%; bottom:0" id='share_popup'>
  <div class="line-th ub ub-ac ub-pc m-all1">
    <div class="ub ulev-9 f-color-6 bc-grey p-l-r3">分享到</div>
  </div>
  <div class="ub p-all1 ulev-9" style="overflow-x:scroll">
    <div class="ub-ver ub ub-ac ub-pc share uhide weixin_share" share_type='weixin2'>
      <div class="ub-img h-w-10" style="background-image:url(img/share/social_wx_circle_press.png)"></div>
      <div class="p-t-b6 ulev-1 f-color-6 tx-c share" share_type='weibo'>朋友圈</div>
    </div>
    <div class="ub-ver ub ub-ac ub-pc share m-l1" share_type='tsina'>
      <div class="ub-img h-w-10" style="background-image:url(img/share/social_sina_weibo_press.png)"></div>
      <div class="p-t-b6 ulev-1 f-color-6 tx-c">新浪微博</div>
    </div>
    <div class="ub-ver ub ub-ac ub-pc share m-l1 weixin_share uhide" share_type='weixin1'>
      <div class="ub-img h-w-10" style="background-image:url(img/share/social_wx_press.png)"></div>
      <div class="p-t-b6 ulev-1 f-color-6 tx-c">微信好友</div>
    </div>
	<div class="ub-ver ub ub-ac ub-pc share m-l1 qq_share uhide" share_type='qq'>
      <div class="ub-img h-w-10" style="background-image:url(img/share/social_qq_press.png)"></div>
      <div class="p-t-b6 ulev-1 f-color-6 tx-c">QQ好友</div>
    </div>
    <div class="ub-ver ub ub-ac ub-pc share m-l1" share_type='qzone'>
      <div class="ub-img h-w-10" style="background-image:url(img/share/social_qzone_press.png)"></div>
      <div class="p-t-b6 ulev-1 f-color-6 tx-c">QQ空间</div>
    </div>
    <div class="ub-ver ub ub-ac ub-pc share m-l1" share_type='tqq'>
      <div class="ub-img h-w-10" style="background-image:url(img/share/social_tencent_weibo_press.png)"></div>
      <div class="p-t-b6 ulev-1 f-color-6 tx-c">腾讯微博</div>
    </div>
    <div class="ub-ver ub ub-ac ub-pc share m-l1" share_type='sms'>
      <div class="ub-img h-w-10" style="background-image:url(img/share/social_message_press.png)"></div>
      <div class="p-t-b6 ulev-1 f-color-6 tx-c">短信</div>
    </div>
  </div>
</div>
<?php endif; ?>
