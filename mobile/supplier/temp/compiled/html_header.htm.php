<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
<title><?php echo $this->_var['ur_here']; ?></title>
<link href="styles/main.css" rel="stylesheet" type="text/css" />
<link href="styles/zalert.css" rel="stylesheet" type="text/css" />
<link href="styles/zprogress.css" rel="stylesheet" type="text/css" />
<link href='styles/intimidatetime.css' rel="stylesheet" type="text/css" />
<link href='styles/zscrolltotop.css' rel="stylesheet" type="text/css" />
<script type="text/javascript" src='js/zepto.min.js'></script>
<script type='text/javascript' src='js/fx.js'></script>
<script type='text/javascript' src='js/fx_methods.js'></script>
<script type='text/javascript' src='js/zcontent.js'></script>
<script type='text/javascript' src='js/zalert.js'></script>
<script type='text/javascript' src='js/zprogress.js'></script>
<script type='text/javascript' src='js/zextra_methods.js'></script>
<script type='text/javascript' src='js/zscroll.js'></script>
<script type='text/javascript' src='js/zscrolltotop.js'></script>
<script src='js/intimidatetime.js'></script>
<script src='js/intimidatetime.zh_CN.js'></script>
<script type="text/javascript" src='js/main.js'></script>

<script type='text/javascript'>
  Zepto(function($)
  {
    $.zcontent.set("url","<?php echo $_SERVER['SCRIPT_NAME']; ?>");
    <?php $_from = $_REQUEST; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
    $.zcontent.set("<?php echo $this->_var['key']; ?>","<?php echo $this->_var['item']; ?>");
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    <?php $_from = $_GET; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
    $.zcontent.add_static("<?php echo $this->_var['key']; ?>")
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	  $.intimidatetime.setDefaults($.intimidatetime.i18n['zh-CN']);
   $(document).on('ajaxStart', $.zprogress.start).on('ajaxStop', $.zprogress.done)
   $("#toTop").scrollToTop();
  });
</script>