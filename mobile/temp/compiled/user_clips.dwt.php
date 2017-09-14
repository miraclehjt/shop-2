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
<link rel="stylesheet" type="text/css" href="themesmobile/68ecshopcom_mobile/css/user.css"/>
<link rel="stylesheet" type="text/css" href="themesmobile/68ecshopcom_mobile/css/public.css"/>
<script src="themesmobile/68ecshopcom_mobile/js/modernizr.js"></script>
<script type="text/javascript" src="themesmobile/68ecshopcom_mobile/js/jquery.js"></script>
<?php echo $this->smarty_insert_scripts(array('files'=>'jquery.json.js,transport.js')); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'common.js,utils.js')); ?>
</head>
<body>
      
      <?php if ($this->_var['action'] != 'default'): ?>
      <header>
      <div class="tab_nav">
        <div class="header">
          <div class="h-left"><a class="sb-back" href="javascript:history.back(-1)" title="返回"></a></div>
          <div class="h-mid"><?php if ($this->_var['action'] == 'default'): ?>用户中心 <?php elseif ($this->_var['action'] == 'affiliate'): ?>我的推荐<?php elseif ($this->_var['action'] == 'collection_list' || $this->_var['action'] == 'follow_shop' || $this->_var['action'] == 'booking_list'): ?>我的收藏<?php elseif ($this->_var['action'] == 'message_list'): ?>我的留言<?php elseif ($this->_var['action'] == 'comment_list'): ?>我的评价<?php endif; ?></div>
          <div class="h-right">
            <aside class="top_bar">
              <div onClick="show_menu();$('#close_btn').addClass('hid');" id="show_more"><a href="javascript:;"></a> </div>
            </aside>
          </div>
        </div>
      </div>
      </header>
       	<?php echo $this->fetch('library/up_menu.lbi'); ?> 
        <?php endif; ?>
<div id="tbh5v0">
<?php if ($this->_var['action'] == 'default'): ?>
<?php echo $this->fetch('library/user_nav.lbi'); ?>
<?php endif; ?>

<?php if ($this->_var['action'] == 'collection_list' || $this->_var['action'] == 'follow_shop'): ?><?php echo $this->fetch('library/user_collection.lbi'); ?><?php endif; ?>

<?php if ($this->_var['action'] == 'message_list'): ?><?php echo $this->fetch('library/user_message.lbi'); ?><?php endif; ?>
<?php if ($this->_var['action'] == 'comment_list'): ?><?php echo $this->fetch('library/user_comments.lbi'); ?><?php endif; ?>
  
  <?php if ($this->_var['action'] == 'affiliate'): ?><?php echo $this->fetch('library/user_affiliate.lbi'); ?><?php endif; ?> 
  
  <?php echo $this->fetch('library/page_footer.lbi'); ?> </div>
<?php echo $this->fetch('library/footer_nav.lbi'); ?>
</body>
</html>