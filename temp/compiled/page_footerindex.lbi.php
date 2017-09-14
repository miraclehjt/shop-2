<div class="site-footer">
  <div class="container wrapper">
    <div class="footer-service">
      <ul class="list-service clearfix">
        <li> <a class="ic1" rel="nofollow" href="" target="_blank" > <strong>24小时快速发货</strong> </a> </li>
        <li> <a class="ic2" rel="nofollow" href="" target="_blank"><strong>7天无理由退货</strong> </a> </li>
        <li> <a class="ic3" rel="nofollow" href="" target="_blank" > <strong>15天免费换货</strong> </a> </li>
        <li> <a class="ic4" rel="nofollow" href="" target="_blank"> <strong>满39元包邮</strong> </a> </li>
        <li> <a class="ic5" rel="nofollow" href="" target="_blank"> <strong>百余家售后网点</strong> </a> </li>
      </ul>
    </div>
    <div class="footer-links clearfix"> 
      <?php $_from = $this->_var['helps']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'help_cat');$this->_foreach['no'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['no']['total'] > 0):
    foreach ($_from AS $this->_var['help_cat']):
        $this->_foreach['no']['iteration']++;
?>
      <dl class="col-links <?php if (($this->_foreach['no']['iteration'] <= 1)): ?>col-links-first<?php endif; ?>">
        <dt><?php echo $this->_var['help_cat']['cat_name']; ?></dt>
        <?php $_from = $this->_var['help_cat']['article']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item_0_56528900_1505113128');if (count($_from)):
    foreach ($_from AS $this->_var['item_0_56528900_1505113128']):
?>
        <dd><a rel="nofollow" href="help.php?id=<?php echo $this->_var['item_0_56528900_1505113128']['article_id']; ?>" target="_blank"><?php echo $this->_var['item_0_56528900_1505113128']['short_title']; ?></a></dd>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      </dl>
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      <div class="col-contact">
        <p class="phone">400-888-8888</p>
        <p>周一至周五 9:00-17:30<br>
          （仅收市话费）</p>
        <a rel="nofollow" class="btn2 btn-primary btn-small" href="javascript:void(0);" style="color:#fff">24小时在线客服</a> </div>
    </div>
    <div class="footer-info clearfix" >
      <div class="info-text">
      <?php if ($this->_var['img_links'] || $this->_var['txt_links']): ?> 
        <p>友情链接：
        <?php $_from = $this->_var['img_links']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'link');if (count($_from)):
    foreach ($_from AS $this->_var['link']):
?>
        <a href="<?php echo $this->_var['link']['url']; ?>" target="_blank" title="<?php echo $this->_var['link']['name']; ?>"><?php echo $this->_var['link']['name']; ?></a><span class="sep">|</span>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    <?php $_from = $this->_var['txt_links']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'link');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['link']):
        $this->_foreach['name']['iteration']++;
?>
   <a href="<?php echo $this->_var['link']['url']; ?>" target="_blank" title="<?php echo $this->_var['link']['name']; ?>"><?php echo $this->_var['link']['name']; ?></a><?php if (! ($this->_foreach['name']['iteration'] == $this->_foreach['name']['total'])): ?><span class="sep">|</span><?php endif; ?>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </p>
        <?php endif; ?>
        <p class="nav_bottom">
        <?php if ($this->_var['navigator_list']['bottom']): ?>
      <?php $_from = $this->_var['navigator_list']['bottom']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'nav_0_56628900_1505113128');$this->_foreach['nav_bottom_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['nav_bottom_list']['total'] > 0):
    foreach ($_from AS $this->_var['nav_0_56628900_1505113128']):
        $this->_foreach['nav_bottom_list']['iteration']++;
?>
      <a href="<?php echo $this->_var['nav_0_56628900_1505113128']['url']; ?>" <?php if ($this->_var['nav_0_56628900_1505113128']['opennew'] == 1): ?>target="_blank"<?php endif; ?>><?php echo $this->_var['nav_0_56628900_1505113128']['name']; ?></a><em <?php if (($this->_foreach['nav_bottom_list']['iteration'] == $this->_foreach['nav_bottom_list']['total'])): ?>style="display:none"<?php endif; ?>>|</em>
         <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      <?php endif; ?>
      <?php if ($this->_var['icp_number']): ?>
      <?php echo $this->_var['lang']['icp_number']; ?>:<a href="http://www.miibeian.gov.cn/" target="_blank"><?php echo $this->_var['icp_number']; ?></a>
      <?php endif; ?>
      </p>
      <p>
      <a href="javascript:;"><?php echo $this->_var['copyright']; ?></a> <a href="javascript:;"><?php echo $this->_var['shop_address']; ?> <?php echo $this->_var['shop_postcode']; ?></a>
      <a href="javascript:;"><?php if ($this->_var['service_phone']): ?>
      Tel: <?php echo $this->_var['service_phone']; ?>
      <?php endif; ?></a>
        <a href="javascript:;"><?php if ($this->_var['service_email']): ?>
      E-mail: <?php echo $this->_var['service_email']; ?>
      <?php endif; ?></a>
      </p>
      <p>
      <?php if ($this->_var['stats_code']): ?>
      <?php echo $this->_var['stats_code']; ?>
      <?php endif; ?>
      <?php $_from = $this->_var['qq']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'im');if (count($_from)):
    foreach ($_from AS $this->_var['im']):
?>
      <?php if ($this->_var['im']): ?>
      <a href="http://wpa.qq.com/msgrd?V=1&amp;Uin=<?php echo $this->_var['im']; ?>&amp;Site=<?php echo $this->_var['shop_name']; ?>&amp;Menu=yes" target="_blank"><img src="http://wpa.qq.com/pa?p=1:<?php echo $this->_var['im']; ?>:4" height="16" border="0" alt="QQ" /> <?php echo $this->_var['im']; ?></a>
      <?php endif; ?>
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      <?php $_from = $this->_var['ww']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'im');if (count($_from)):
    foreach ($_from AS $this->_var['im']):
?>
      <?php if ($this->_var['im']): ?>
      <a href="http://amos1.taobao.com/msg.ww?v=2&uid=<?php echo urlencode($this->_var['im']); ?>&s=2" target="_blank"><img src="http://amos1.taobao.com/online.ww?v=2&uid=<?php echo urlencode($this->_var['im']); ?>&s=2" width="16" height="16" border="0" alt="淘宝旺旺" /><?php echo $this->_var['im']; ?></a>
      <?php endif; ?>
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      <?php $_from = $this->_var['ym']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'im');if (count($_from)):
    foreach ($_from AS $this->_var['im']):
?>
      <?php if ($this->_var['im']): ?>
      <a href="http://edit.yahoo.com/config/send_webmesg?.target=<?php echo $this->_var['im']; ?>n&.src=pg" target="_blank"><img src="themes/68ecshopcom_360buy/images/yahoo.gif" width="18" height="17" border="0" alt="Yahoo Messenger" /> <?php echo $this->_var['im']; ?></a>
      <?php endif; ?>
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      <?php $_from = $this->_var['msn']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'im');if (count($_from)):
    foreach ($_from AS $this->_var['im']):
?>
      <?php if ($this->_var['im']): ?>
      <img src="themes/68ecshopcom_360buy/images/msn.gif" width="18" height="17" border="0" alt="MSN" /> <a href="msnim:chat?contact=<?php echo $this->_var['im']; ?>"><?php echo $this->_var['im']; ?></a>
      <?php endif; ?>
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      <?php $_from = $this->_var['skype']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'im');if (count($_from)):
    foreach ($_from AS $this->_var['im']):
?>
      <?php if ($this->_var['im']): ?>
      <img src="http://mystatus.skype.com/smallclassic/<?php echo urlencode($this->_var['im']); ?>" alt="Skype" /><a href="skype:<?php echo urlencode($this->_var['im']); ?>?call"><?php echo $this->_var['im']; ?></a>
      <?php endif; ?>
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      </p>
      </div>      
    </div>    
  </div>
</div>

<script type="text/javascript">
Ajax.call('api/okgoods.php', '', '', 'GET', 'JSON');
$("img").lazyload({
    effect       : "fadeIn",
	 skip_invisible : true,
	 failure_limit : 20
});
</script>
