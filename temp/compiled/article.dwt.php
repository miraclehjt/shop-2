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
<link href="<?php echo $this->_var['ecs_css_path']; ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="themes/68ecshopcom_360buy/js/jquery-1.9.1.min.js" ></script>
<?php echo $this->smarty_insert_scripts(array('files'=>'jquery.json.js,transport.js')); ?>

<?php echo $this->smarty_insert_scripts(array('files'=>'common.js')); ?>
</head>
<body>
<div id="site-nav"> 
  <?php echo $this->fetch('library/page_header.lbi'); ?>
  <div class="blank"></div>
  <?php echo $this->fetch('library/ur_here.lbi'); ?>
  <div class="w main" >
    <div class="right-extra"> 
      <div class="box">
        <div class="box_1 article-68">
          <div style="border:1px solid #E4E4E4; padding:10px 15px 20px;">
            <div class="tc" style="padding:8px;"> <font class="f5 f6"><?php echo htmlspecialchars($this->_var['article']['title']); ?></font><br />
              <font class="f3"><?php echo htmlspecialchars($this->_var['article']['author']); ?> / <?php echo $this->_var['article']['add_time']; ?></font> </div>
            <?php if ($this->_var['article']['content']): ?> 
            <?php echo $this->_var['article']['content']; ?> 
            <?php endif; ?> 
            <?php if ($this->_var['article']['open_type'] == 2 || $this->_var['article']['open_type'] == 1): ?><br />
            <div><a href="<?php echo $this->_var['article']['file_url']; ?>" target="_blank"><?php echo $this->_var['lang']['relative_file']; ?></a></div>
            <?php endif; ?>
            <div  style="padding:8px;height:40px; margin-top:15px;border-top:1px solid #ccc;">
              <div style="width:700px; text-align:left;float:left "> 
                <?php if ($this->_var['next_article']): ?>
                <?php echo $this->_var['lang']['next_article']; ?>:<a href="<?php echo $this->_var['next_article']['url']; ?>" class="f6"><?php echo $this->_var['next_article']['title']; ?></a><br />
                <?php endif; ?> 
                <?php if ($this->_var['prev_article']): ?>
                <?php echo $this->_var['lang']['prev_article']; ?>:<a href="<?php echo $this->_var['prev_article']['url']; ?>" class="f6"><?php echo $this->_var['prev_article']['title']; ?></a> <?php endif; ?> </div>
              <div style="width:170px;float:right;">
                <div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a title="分享到QQ空间" href="#" class="bds_qzone" data-cmd="qzone"></a><a title="分享到新浪微博" href="#" class="bds_tsina" data-cmd="tsina"></a><a title="分享到腾讯微博" href="#" class="bds_tqq" data-cmd="tqq"></a><a title="分享到人人网" href="#" class="bds_renren" data-cmd="renren"></a><a title="分享到微信" href="#" class="bds_weixin" data-cmd="weixin"></a><a title="分享到一键分享" href="#" class="bds_mshare" data-cmd="mshare"></a></div>
                <script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"16"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script> 
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="blank"></div>
    </div>
    <div class="left-extra"> 
	<?php echo $this->fetch('library/article_category_tree.lbi'); ?> 
	
<?php echo $this->fetch('library/goods_related.lbi'); ?>
 
    </div>
    <div class="blank"></div>
  </div>
  <?php echo $this->fetch('library/help.lbi'); ?> 
  <?php echo $this->fetch('library/page_footer.lbi'); ?> 
</div>
</body>
</html>
