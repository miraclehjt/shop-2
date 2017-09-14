<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="http://localhost/weishop/" />
<meta name="Generator" content="HongYuJD v7_2" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />

<title><?php echo $this->_var['page_title']; ?></title>



<link rel="shortcut icon" href="favicon.ico" />
<link rel="icon" href="animated_favicon.gif" type="image/gif" />
<link href="<?php echo $this->_var['ecs_css_path']; ?>" rel="stylesheet" type="text/css" />
<link href="themes/68ecshopcom_360buy/css/article_list.css" rel="stylesheet" type="text/css" />

<?php echo $this->smarty_insert_scripts(array('files'=>'common.js')); ?>
<script src="themes/68ecshopcom_360buy/js/common.min.js" type="text/javascript"></script>
<script type="text/javascript" src="themes/68ecshopcom_360buy/js/zxbbs.min.js"></script>
<script type="text/javascript" src="themes/68ecshopcom_360buy/js/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="themes/68ecshopcom_360buy/js/slidePic.min.js"></script>
</head>
<body class="root_body">
<div id="site-nav"> 
<?php echo $this->fetch('library/page_header.lbi'); ?>
</div>
<div class="article_block clearfix">
  <div id="focus">
    <div class="stageBox">
      <div id="JS_focus_stage" style="margin-top: -1824px; "> 
      <?php echo $this->fetch('library/ar_ad.lbi'); ?>
      </div>
    </div>
    <div class="panel">
      <div id="JS_focus_nav" class="nav">
       <a class="" href="javascript:;" data-alt=""> 1 </a> 
       <a href="javascript:;" data-alt="" class=""> 2 </a> 
       <a href="javascript:;" data-alt="" class=""> 3 </a> 
       <a href="javascript:;" data-alt="" class=""> 4 </a> 
       <a href="javascript:;" data-alt="" class="current"> 5 </a> </div>
    </div>
  </div>
  <div class="articleList">
    <h3></h3>
<?php $_from = $this->_var['article_top']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'article');if (count($_from)):
    foreach ($_from AS $this->_var['article']):
?>
    <div class="learn_news">
      <h4><?php echo $this->_var['article']['title']; ?></h4>
      <p class="k_h"><a href="<?php echo $this->_var['article']['url']; ?>" target="_blank"><?php echo sub_str($this->_var['article']['content'],60); ?></a> </p>
      <p><a href="<?php echo $this->_var['article']['url']; ?>" class="red" target="_blank">【详细阅读】</a></p>
    </div>
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
    
        
    <ul class="allList bodertop mt10">    
    <?php $_from = $this->_var['article_top1']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'article');if (count($_from)):
    foreach ($_from AS $this->_var['article']):
?>
			<li><a class="kind" href="<?php echo $this->_var['article']['cat_url']; ?>" target="_blank"><?php echo $this->_var['article']['cat_name']; ?></a><span>|</span><a href="<?php echo $this->_var['article']['url']; ?>" target="_blank" title="<?php echo $this->_var['article']['title']; ?>"><?php echo $this->_var['article']['title']; ?></a></li>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
	</ul>
    
    <ul class="allList bodertop mt10">
<?php $_from = $this->_var['article_top2']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'article');if (count($_from)):
    foreach ($_from AS $this->_var['article']):
?>
			<li><a class="kind" href="<?php echo $this->_var['article']['cat_url']; ?>" target="_blank"><?php echo $this->_var['article']['cat_name']; ?></a><span>|</span><a href="<?php echo $this->_var['article']['url']; ?>" target="_blank" title="<?php echo $this->_var['article']['title']; ?>"><?php echo $this->_var['article']['title']; ?></a></li>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
	</ul>
  </div>
  
  
      
  <div class="pageSide">
    <div class="sideCom">
     <?php $_from = $this->_var['article_right1']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'article');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['article']):
        $this->_foreach['name']['iteration']++;
?>
     <?php if ($this->_foreach['name']['iteration'] <= 1): ?>
      <div class="title"><a class="ico ico3" href="<?php echo $this->_var['article']['cat_url']; ?>"></a><?php echo $this->_var['article']['cat_name']; ?></div>
      <?php endif; ?>
         <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
      <ul class="body">
       <?php $_from = $this->_var['article_right1']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'article');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['article']):
        $this->_foreach['name']['iteration']++;
?>
       <?php if ($this->_foreach['name']['iteration'] <= 3): ?>
        <li>
          <div class="subject"><span class="ico ico1"><?php echo $this->_foreach['name']['iteration']; ?></span><a href="<?php echo $this->_var['article']['url']; ?>" target="_blank" title="<?php echo $this->_var['article']['title']; ?>"><?php echo sub_str($this->_var['article']['title'],16); ?></a></div>
        </li>
        <?php endif; ?>
         <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
         <?php $_from = $this->_var['article_right1']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'article');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['article']):
        $this->_foreach['name']['iteration']++;
?>
       <?php if ($this->_foreach['name']['iteration'] > 3 & $this->_foreach['name']['iteration'] < 11): ?>
        <li>
           <div class="subject"><span class="ico ico2"><?php echo $this->_foreach['name']['iteration']; ?></span><a href="<?php echo $this->_var['article']['url']; ?>" target="_blank" title="<?php echo $this->_var['article']['title']; ?>"><?php echo sub_str($this->_var['article']['title'],16); ?></a></div>
        </li>
          <?php endif; ?>
         <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
      </ul>
    </div>
    

    <div class="pic Right"> 
    <?php $_from = $this->_var['article_imgad1']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'articleimg');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['articleimg']):
        $this->_foreach['name']['iteration']++;
?>
    <a href="<?php echo $this->_var['articleimg']['url']; ?>" target="_blank" title="<?php echo $this->_var['articleimg']['title']; ?>"><img src="<?php echo $this->_var['articleimg']['img']['0']; ?>" width="273" height="110"></a> 
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
    </div>
  </div>
  
  
</div>

    <div class="article_block homeAd">
    <div class="ad_list" style="margin-top: 0px; ">
<?php echo $this->fetch('library/ar_ad_mid.lbi'); ?>
   </div>
    </div>

     <div class="article_block clearfix">
    
		<div class="mainCom">
			<?php echo $this->fetch('library/article_tit1.lbi'); ?>
			<div class="body">
            	<div class="first">
                	 <?php $_from = $this->_var['article_left1_cat1']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'article');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['article']):
        $this->_foreach['name']['iteration']++;
?>
                <?php if ($this->_foreach['name']['iteration'] <= 1): ?>
                	<div class="head">
                    	<span><a href="<?php echo $this->_var['article']['cat_url']; ?>" target="_blank"><?php echo $this->_var['article']['cat_name']; ?></a></span>
                        <div class="Right gray">
                             <a class="last" href="<?php echo $this->_var['article']['cat_url']; ?>" target="_blank">更多</a>
                        </div>
                    </div>
                     <?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
                    	<ul class="allList">
                         <?php $_from = $this->_var['article_left1_cat1']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'article');if (count($_from)):
    foreach ($_from AS $this->_var['article']):
?>
									<li><a class="kind" href="<?php echo $this->_var['article']['cat_url']; ?>" target="_blank" title="<?php echo $this->_var['article']['cat_name']; ?>"><?php echo $this->_var['article']['cat_name']; ?></a><span>|</span><a href="<?php echo $this->_var['article']['url']; ?>" target="_blank" title="<?php echo $this->_var['article']['title']; ?>"><?php echo $this->_var['article']['title']; ?></a></li>                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>                              
					   </ul>
                </div>
                 
                <div class="first">
                	 <?php $_from = $this->_var['article_left1_cat2']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'article');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['article']):
        $this->_foreach['name']['iteration']++;
?>
                <?php if ($this->_foreach['name']['iteration'] <= 1): ?>
                	<div class="head">
                    	<span><a href="<?php echo $this->_var['article']['cat_url']; ?>" target="_blank"><?php echo $this->_var['article']['cat_name']; ?></a></span>
                        <div class="Right gray">
                             <a class="last" href="<?php echo $this->_var['article']['cat_url']; ?>" target="_blank">更多</a>
                        </div>
                    </div>
                     <?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
                    	<ul class="allList">
                         <?php $_from = $this->_var['article_left1_cat2']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'article');if (count($_from)):
    foreach ($_from AS $this->_var['article']):
?>
									<li><a class="kind" href="<?php echo $this->_var['article']['cat_url']; ?>" target="_blank" title="<?php echo $this->_var['article']['cat_name']; ?>"><?php echo $this->_var['article']['cat_name']; ?></a><span>|</span><a href="<?php echo $this->_var['article']['url']; ?>" target="_blank" title="<?php echo $this->_var['article']['title']; ?>"><?php echo $this->_var['article']['title']; ?></a></li>                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>                              
					   </ul>
                </div>		
			</div>
		</div>
             
  <div class="pageSide">
    <div class="sideCom">
     <?php $_from = $this->_var['article_right2']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'article');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['article']):
        $this->_foreach['name']['iteration']++;
?>
     <?php if ($this->_foreach['name']['iteration'] <= 1): ?>
      <div class="title"><a class="ico ico3" href="<?php echo $this->_var['article']['cat_url']; ?>"></a><?php echo $this->_var['article']['cat_name']; ?></div>
      <?php endif; ?>
         <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
      <ul class="body">
       <?php $_from = $this->_var['article_right2']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'article');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['article']):
        $this->_foreach['name']['iteration']++;
?>
       <?php if ($this->_foreach['name']['iteration'] <= 3): ?>
        <li>
          <div class="subject"><span class="ico ico1"><?php echo $this->_foreach['name']['iteration']; ?></span><a href="<?php echo $this->_var['article']['url']; ?>" target="_blank" title="<?php echo $this->_var['article']['title']; ?>"><?php echo sub_str($this->_var['article']['title'],20); ?></a></div>
        </li>
        <?php endif; ?>
         <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
         <?php $_from = $this->_var['article_right2']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'article');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['article']):
        $this->_foreach['name']['iteration']++;
?>
       <?php if ($this->_foreach['name']['iteration'] > 3 & $this->_foreach['name']['iteration'] < 11): ?>
        <li>
           <div class="subject"><span class="ico ico2"><?php echo $this->_foreach['name']['iteration']; ?></span><a href="<?php echo $this->_var['article']['url']; ?>" target="_blank" title="<?php echo $this->_var['article']['title']; ?>"><?php echo sub_str($this->_var['article']['title'],20); ?></a></div>
        </li>
          <?php endif; ?>
         <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
      </ul>
    </div>
   
  </div>
        
        </div>


<DIV class="artimg_box article_block">
<?php $_from = $this->_var['article_imgtit1']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'article');if (count($_from)):
    foreach ($_from AS $this->_var['article']):
?>
<DIV class=sec-title-1>
<H3><?php echo $this->_var['article']['cat_name']; ?></H3><A class="more" 
href="<?php echo $this->_var['article']['cat_url']; ?>">更多&gt;&gt;</A></DIV>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
<UL>
<?php $_from = $this->_var['article_img1']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'articleimg');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['articleimg']):
        $this->_foreach['name']['iteration']++;
?>
<?php if ($this->_foreach['name']['iteration'] <= 1): ?>
  <LI class=focus>
  <P><A href="<?php echo $this->_var['articleimg']['url']; ?>"><IMG class="view" alt="<?php echo $this->_var['articleimg']['title']; ?>" src="<?php if ($this->_var['articleimg']['img']['0']): ?><?php echo $this->_var['articleimg']['img']['0']; ?><?php else: ?>themes/68ecshopcom_360buy/images/upgrade_ad/article_img.jpg<?php endif; ?>"></A></P>
  <P><A class=txt title="<?php echo $this->_var['articleimg']['title']; ?>" target="_blank"
  href="<?php echo $this->_var['articleimg']['url']; ?>"><?php echo sub_str($this->_var['articleimg']['title'],10); ?></A></P></LI>
  <?php endif; ?>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
  <?php $_from = $this->_var['article_img1']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'articleimg');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['articleimg']):
        $this->_foreach['name']['iteration']++;
?>
<?php if ($this->_foreach['name']['iteration'] > 1): ?>
  <LI>
  <P><A href="<?php echo $this->_var['articleimg']['url']; ?>" target="_blank"><IMG class="view" alt="<?php echo $this->_var['articleimg']['title']; ?>" src="<?php if ($this->_var['articleimg']['img']['0']): ?><?php echo $this->_var['articleimg']['img']['0']; ?><?php else: ?>themes/68ecshopcom_360buy/images/upgrade_ad/article_img.jpg<?php endif; ?>"></A></P>
  <P><A class=txt title="<?php echo $this->_var['articleimg']['title']; ?>" target="_blank"
  href="<?php echo $this->_var['articleimg']['url']; ?>"><?php echo sub_str($this->_var['articleimg']['title'],10); ?></A></P></LI>
    <?php endif; ?>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
  </UL></DIV>

<div class="article_block clearfix">
		    
		<div class="mainCom">
			<?php echo $this->fetch('library/article_tit2.lbi'); ?>
			<div class="body">
            	<div class="first">
                	 <?php $_from = $this->_var['article_left2_cat1']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'article');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['article']):
        $this->_foreach['name']['iteration']++;
?>
                <?php if ($this->_foreach['name']['iteration'] <= 1): ?>
                	<div class="head">
                    	<span><a href="<?php echo $this->_var['article']['cat_url']; ?>" target="_blank"><?php echo $this->_var['article']['cat_name']; ?></a></span>
                        <div class="Right gray">
                             <a class="last" href="<?php echo $this->_var['article']['cat_url']; ?>" target="_blank">更多</a>
                        </div>
                    </div>
                     <?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
                    	<ul class="allList">
                         <?php $_from = $this->_var['article_left2_cat1']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'article');if (count($_from)):
    foreach ($_from AS $this->_var['article']):
?>
									<li><a class="kind" href="<?php echo $this->_var['article']['cat_url']; ?>" target="_blank" title="<?php echo $this->_var['article']['cat_name']; ?>"><?php echo $this->_var['article']['cat_name']; ?></a><span>|</span><a href="<?php echo $this->_var['article']['url']; ?>" target="_blank" title="<?php echo $this->_var['article']['title']; ?>"><?php echo $this->_var['article']['title']; ?></a></li>                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>                              
					   </ul>
                </div>
                 
                <div class="first">
                	 <?php $_from = $this->_var['article_left2_cat2']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'article');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['article']):
        $this->_foreach['name']['iteration']++;
?>
                <?php if ($this->_foreach['name']['iteration'] <= 1): ?>
                	<div class="head">
                    	<span><a href="<?php echo $this->_var['article']['cat_url']; ?>" target="_blank"><?php echo $this->_var['article']['cat_name']; ?></a></span>
                        <div class="Right gray">
                             <a class="last" href="<?php echo $this->_var['article']['cat_url']; ?>" target="_blank">更多</a>
                        </div>
                    </div>
                     <?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
                    	<ul class="allList">
                         <?php $_from = $this->_var['article_left2_cat2']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'article');if (count($_from)):
    foreach ($_from AS $this->_var['article']):
?>
									<li><a class="kind" href="<?php echo $this->_var['article']['cat_url']; ?>" target="_blank" title="<?php echo $this->_var['article']['cat_name']; ?>"><?php echo $this->_var['article']['cat_name']; ?></a><span>|</span><a href="<?php echo $this->_var['article']['url']; ?>" target="_blank" title="<?php echo $this->_var['article']['title']; ?>"><?php echo $this->_var['article']['title']; ?></a></li>                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>                              
					   </ul>
                </div>		
			</div>
		</div>

  <div class="pageSide">
    <div class="sideCom">
     <?php $_from = $this->_var['article_right3']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'article');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['article']):
        $this->_foreach['name']['iteration']++;
?>
     <?php if ($this->_foreach['name']['iteration'] <= 1): ?>
      <div class="title"><a class="ico ico3" href="<?php echo $this->_var['article']['cat_url']; ?>"></a><?php echo $this->_var['article']['cat_name']; ?></div>
      <?php endif; ?>
         <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
      <ul class="body">
       <?php $_from = $this->_var['article_right3']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'article');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['article']):
        $this->_foreach['name']['iteration']++;
?>
       <?php if ($this->_foreach['name']['iteration'] <= 3): ?>
        <li>
          <div class="subject"><span class="ico ico1"><?php echo $this->_foreach['name']['iteration']; ?></span><a href="<?php echo $this->_var['article']['url']; ?>" target="_blank" title="<?php echo $this->_var['article']['title']; ?>"><?php echo sub_str($this->_var['article']['title'],20); ?></a></div>
        </li>
        <?php endif; ?>
         <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
         <?php $_from = $this->_var['article_right3']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'article');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['article']):
        $this->_foreach['name']['iteration']++;
?>
       <?php if ($this->_foreach['name']['iteration'] > 3 & $this->_foreach['name']['iteration'] < 11): ?>
        <li>
           <div class="subject"><span class="ico ico2"><?php echo $this->_foreach['name']['iteration']; ?></span><a href="<?php echo $this->_var['article']['url']; ?>" target="_blank" title="<?php echo $this->_var['article']['title']; ?>"><?php echo sub_str($this->_var['article']['title'],20); ?></a></div>
        </li>
          <?php endif; ?>
         <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
      </ul>
    </div>
   
  </div>
        
        </div>
 
  
  <DIV class="artimg_box1 article_block" style="margin-bottom:10px;">
<?php $_from = $this->_var['article_imgtit2']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'article');if (count($_from)):
    foreach ($_from AS $this->_var['article']):
?>
<DIV class=sec-title-1>
<H3><?php echo $this->_var['article']['cat_name']; ?></H3><A class="more"  target="_blank"
href="<?php echo $this->_var['article']['cat_url']; ?>">更多&gt;&gt;</A></DIV>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
<UL>
  
   <?php $_from = $this->_var['article_img2']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'articleimg');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['articleimg']):
        $this->_foreach['name']['iteration']++;
?>
  <LI>
  <P><A href="<?php echo $this->_var['articleimg']['url']; ?>" target="_blank"><IMG class=view 
  alt="<?php echo $this->_var['articleimg']['title']; ?>" src="<?php if ($this->_var['articleimg']['img']['0']): ?><?php echo $this->_var['articleimg']['img']['0']; ?><?php else: ?>themes/68ecshopcom_360buy/images/upgrade_ad/article_img.jpg<?php endif; ?>"></A></P>
  <P><A class=txt title="<?php echo $this->_var['articleimg']['title']; ?>" target="_blank"
  href="<?php echo $this->_var['articleimg']['url']; ?>"><?php echo sub_str($this->_var['articleimg']['title'],10); ?></A></P></LI>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
  </UL></DIV>
  
  

<div class="article_block clearfix">
		<div class="mainCom">
			<?php echo $this->fetch('library/article_tit3.lbi'); ?>
			<div class="body">
            	<div class="first">
                	 <?php $_from = $this->_var['article_left3_cat1']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'article');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['article']):
        $this->_foreach['name']['iteration']++;
?>
                <?php if ($this->_foreach['name']['iteration'] <= 1): ?>
                	<div class="head">
                    	<span><a href="<?php echo $this->_var['article']['cat_url']; ?>" target="_blank"><?php echo $this->_var['article']['cat_name']; ?></a></span>
                        <div class="Right gray">
                             <a class="last" href="<?php echo $this->_var['article']['cat_url']; ?>" target="_blank">更多</a>
                        </div>
                    </div>
                     <?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
                    	<ul class="allList">
                         <?php $_from = $this->_var['article_left3_cat1']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'article');if (count($_from)):
    foreach ($_from AS $this->_var['article']):
?>
									<li><a class="kind" href="<?php echo $this->_var['article']['cat_url']; ?>" target="_blank" title="<?php echo $this->_var['article']['cat_name']; ?>"><?php echo $this->_var['article']['cat_name']; ?></a><span>|</span><a href="<?php echo $this->_var['article']['url']; ?>" target="_blank" title="<?php echo $this->_var['article']['title']; ?>"><?php echo $this->_var['article']['title']; ?></a></li>                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>                              
					   </ul>
                </div>
                 
                <div class="first">
                	 <?php $_from = $this->_var['article_left3_cat2']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'article');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['article']):
        $this->_foreach['name']['iteration']++;
?>
                <?php if ($this->_foreach['name']['iteration'] <= 1): ?>
                	<div class="head">
                    	<span><a href="<?php echo $this->_var['article']['cat_url']; ?>" target="_blank"><?php echo $this->_var['article']['cat_name']; ?></a></span>
                        <div class="Right gray">
                             <a class="last" href="<?php echo $this->_var['article']['cat_url']; ?>" target="_blank">更多</a>
                        </div>
                    </div>
                     <?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
                    	<ul class="allList">
                         <?php $_from = $this->_var['article_left3_cat2']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'article');if (count($_from)):
    foreach ($_from AS $this->_var['article']):
?>
									<li><a class="kind" href="<?php echo $this->_var['article']['cat_url']; ?>" target="_blank" title="<?php echo $this->_var['article']['cat_name']; ?>"><?php echo $this->_var['article']['cat_name']; ?></a><span>|</span><a href="<?php echo $this->_var['article']['url']; ?>" target="_blank" title="<?php echo $this->_var['article']['title']; ?>"><?php echo $this->_var['article']['title']; ?></a></li>                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>                              
					   </ul>
                </div>		
			</div>
		</div>
		
        
        
  <div class="pageSide">
    <div class="sideCom">
     <?php $_from = $this->_var['article_right4']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'article');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['article']):
        $this->_foreach['name']['iteration']++;
?>
     <?php if ($this->_foreach['name']['iteration'] <= 1): ?>
      <div class="title"><a class="ico ico3" href="<?php echo $this->_var['article']['cat_url']; ?>"></a><?php echo $this->_var['article']['cat_name']; ?></div>
      <?php endif; ?>
         <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
      <ul class="body">
       <?php $_from = $this->_var['article_right4']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'article');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['article']):
        $this->_foreach['name']['iteration']++;
?>
       <?php if ($this->_foreach['name']['iteration'] <= 3): ?>
        <li>
          <div class="subject"><span class="ico ico1"><?php echo $this->_foreach['name']['iteration']; ?></span><a href="<?php echo $this->_var['article']['url']; ?>" target="_blank" title="<?php echo $this->_var['article']['title']; ?>"><?php echo sub_str($this->_var['article']['title'],16); ?></a></div>
        </li>
        <?php endif; ?>
         <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
         <?php $_from = $this->_var['article_right4']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'article');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['article']):
        $this->_foreach['name']['iteration']++;
?>
       <?php if ($this->_foreach['name']['iteration'] > 3 & $this->_foreach['name']['iteration'] < 11): ?>
        <li>
           <div class="subject"><span class="ico ico2"><?php echo $this->_foreach['name']['iteration']; ?></span><a href="<?php echo $this->_var['article']['url']; ?>" target="_blank" title="<?php echo $this->_var['article']['title']; ?>"><?php echo sub_str($this->_var['article']['title'],16); ?></a></div>
        </li>
          <?php endif; ?>
         <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
      </ul>
    </div>
   
  </div>
        
        </div>
        
  
  <DIV class="artimg_box1 article_block" style="margin-bottom:10px;">
<?php $_from = $this->_var['article_imgtit3']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'article');if (count($_from)):
    foreach ($_from AS $this->_var['article']):
?>
<DIV class=sec-title-1>
<H3><?php echo $this->_var['article']['cat_name']; ?></H3><A class="more" 
href="<?php echo $this->_var['article']['cat_url']; ?>" target="_blank">更多&gt;&gt;</A></DIV>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
<UL>
  
   <?php $_from = $this->_var['article_img3']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'articleimg');$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from AS $this->_var['articleimg']):
        $this->_foreach['name']['iteration']++;
?>
  <LI>
  <P><A href="<?php echo $this->_var['articleimg']['url']; ?>" target="_blank"><IMG class="view" alt="<?php echo $this->_var['articleimg']['title']; ?>" src="<?php if ($this->_var['articleimg']['img']['0']): ?><?php echo $this->_var['articleimg']['img']['0']; ?><?php else: ?>themes/68ecshopcom_360buy/images/upgrade_ad/article_img.jpg<?php endif; ?>"></A></P>
  <P><A class=txt title="<?php echo $this->_var['articleimg']['title']; ?>" target="_blank"
  href="<?php echo $this->_var['articleimg']['url']; ?>"><?php echo sub_str($this->_var['articleimg']['title'],10); ?></A></P></LI>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
  </UL></DIV>

<script type="text/javascript">
new Tab(M.$("a","#JS_tab_nav"),M.$(".tab_body","#JS_tab_body"));
new Tab(M.$("a","#JS_tab_link_nav"),M.$(".tab_body","#JS_tab_link_body"));
focus();
</script>
<script type="text/javascript">
$(document).ready(function() {
	
	//专题滚动
	$('#subBody').slidePic(true,5000,250,3,20,'.container',3);
	
	//横幅广告滚动
    $('.homeAd').slideAds(5000,300,1);
});
</script>
<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>
</html>
