<!-- $Id: sitemap.htm 14216 2008-03-10 02:27:21Z testyang $ -->
<?php echo $this->fetch('pageheader.htm'); ?>
<form method="POST" action="" name="theForm">
<div class="main-div">
<p style="padding: 0 10px"><?php echo $this->_var['lang']['sitemaps_note']; ?></p>
</div>
<div class="main-div">
<table width="100%">
<tr>
    <td class="label"><?php echo $this->_var['lang']['homepage_changefreq']; ?></td>
    <td><select name="homepage_priority">
  <?php echo $this->html_options(array('values'=>$this->_var['arr_changefreq'],'output'=>$this->_var['arr_changefreq'],'selected'=>$this->_var['config']['homepage_priority'])); ?>
  </select><select name="homepage_changefreq">
  <?php echo $this->html_options(array('options'=>$this->_var['lang']['priority'],'selected'=>$this->_var['config']['homepage_changefreq'])); ?>
  </select></td>
</tr>
<tr>
    <td class="label"><?php echo $this->_var['lang']['category_changefreq']; ?></td>
    <td><select name="category_priority">
  <?php echo $this->html_options(array('values'=>$this->_var['arr_changefreq'],'output'=>$this->_var['arr_changefreq'],'selected'=>$this->_var['config']['category_priority'])); ?>
  </select><select name="category_changefreq">
  <?php echo $this->html_options(array('options'=>$this->_var['lang']['priority'],'selected'=>$this->_var['config']['category_changefreq'])); ?>
  </select></td>
</tr>
<tr>
    <td class="label"><?php echo $this->_var['lang']['content_changefreq']; ?></td>
    <td><select name="content_priority">
  <?php echo $this->html_options(array('values'=>$this->_var['arr_changefreq'],'output'=>$this->_var['arr_changefreq'],'selected'=>$this->_var['config']['content_priority'])); ?>
  </select><select name="content_changefreq">
  <?php echo $this->html_options(array('options'=>$this->_var['lang']['priority'],'selected'=>$this->_var['config']['content_changefreq'])); ?>
  </select></td>
</tr>
<tr>
    <td></td>
    <td><input type="submit" value="<?php echo $this->_var['lang']['button_submit']; ?>" class="button" /><input type="reset" value="<?php echo $this->_var['lang']['button_reset']; ?>" class="button" /></td>
</tr>
</table>
</div>
</form>

<script type="text/javascript" language="JavaScript">
<!--
onload = function()
{
    document.forms['theForm'].elements['homepage_changefreq'].focus();
    // 开始检查订单
    startCheckOrder();
}
//-->
</script>

<?php echo $this->fetch('pagefooter.htm'); ?>