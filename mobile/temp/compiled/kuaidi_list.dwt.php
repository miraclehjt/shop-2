<!DOCTYPE html >
<html>
<head>
<meta name="Generator" content="ECSHOP v2.7.3" />
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width">
<title><?php echo $this->_var['page_title']; ?></title>
<meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
<link rel="stylesheet" type="text/css" href="themesmobile/68ecshopcom_mobile/css/public.css">
<link rel="stylesheet" type="text/css" href="themesmobile/68ecshopcom_mobile/css/user.css">
<script type="text/javascript" src="themesmobile/68ecshopcom_mobile/js/jquery.js"></script>
<?php echo $this->smarty_insert_scripts(array('files'=>'jquery.json.js,transport.js')); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'common.js,utils.js')); ?>
</head>
<body style="background: #f4f2f3">

<div class="tab_nav">
  <div class="header">
    <div class="h-left"><a class="sb-back" href="javascript:history.back(-1)" title="返回"></a></div>
    <div class="h-mid">物流详情</div>
    <div class="h-right">
      <aside class="top_bar">
        <div onClick="show_menu();$('#close_btn').addClass('hid');" id="show_more"><a href="javascript:;"></a> </div>
      </aside>
    </div>
  </div>
</div>
<?php echo $this->fetch('library/up_menu.lbi'); ?> 
<div class="detail_top">
<div class="lan">
<dl>
<dt class="dingdan_5"></dt>
<dd><span><?php echo $this->_var['order']['shipping_name']; ?></span><br>
    <span class="dingdanhao">运单编码：<?php echo $this->_var['order']['invoice_no']; ?></span><br>
    <span>物流状态：<?php echo $this->_var['order']['shipping_status']; ?></span>
</dd>
</dl>
</div>
</div>

<div class="kd_dingdan">
<h2>物品信息</h2>
<?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
<dl>
          <dt><img src="./../<?php echo $this->_var['goods']['goods_thumb']; ?>"></dt>
          <dd class="name" class="pice" style=" width:55%;"><strong><?php echo $this->_var['goods']['goods_name']; ?></strong><span><?php echo $this->_var['goods']['goods_attr']; ?></span></dd>
          <dd class="pice" style=" font-size:13px; color:#F60; width:25%;">￥<?php echo $this->_var['goods']['goods_price']; ?><em>x<?php echo $this->_var['goods']['goods_number']; ?></em></dd>
</dl>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</div>
<div class="kd_wl">
<h2>物流跟踪</h2>
<?php if ($this->_var['kuaidi_list']): ?>
<?php $_from = $this->_var['kuaidi_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('i', 'kuaidi');if (count($_from)):
    foreach ($_from AS $this->_var['i'] => $this->_var['kuaidi']):
?>
<dl <?php if ($this->_var['i'] == '0'): ?>style=" margin-top:10px;"<?php endif; ?>>
<dt <?php if ($this->_var['i'] != '0'): ?>style=" background:#ccc;"<?php endif; ?>></dt>
<dd><p <?php if ($this->_var['i'] != '0'): ?>style=" color:#666"<?php endif; ?>> <?php echo $this->_var['kuaidi']['context']; ?></p>
<strong><?php if ($this->_var['kuaidi']['ftime']): ?><?php echo $this->_var['kuaidi']['ftime']; ?><?php else: ?><?php echo $this->_var['kuaidi']['time']; ?><?php endif; ?></strong>
</dd>
</dl>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
<?php else: ?>
<dl style=" margin-top:10px;">
<dt style=" background:#ccc;"></dt>
<dd><p>没有数据</p>
</dd>
</dl>
<?php endif; ?>
</div>
<?php echo $this->fetch('library/footer_nav.lbi'); ?>
</body>
</html>