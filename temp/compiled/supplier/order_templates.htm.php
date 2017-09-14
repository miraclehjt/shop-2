<!-- $Id: order_templates.htm 14216 2008-03-10 02:27:21Z testyang $ -->
<?php echo $this->fetch('pageheader.htm'); ?>
<form action="order.php" method="post">
<div class="main-div">
    <table width="100%">
     <tr><td><?php echo $this->_var['fckeditor']; ?></td></tr>
    </table>
    <div class="button-div ">
    <input type="hidden" name="act" value="<?php echo $this->_var['act']; ?>" />
    <input type="submit" value="<?php echo $this->_var['lang']['button_submit']; ?>" class="button" />
  </div>
</div>
</form>
<script type="Text/Javascript" language="JavaScript">
<!--

onload = function()
{
  // 开始检查订单
  startCheckOrder();
}

//-->
</script>
<?php echo $this->fetch('pagefooter.htm'); ?>