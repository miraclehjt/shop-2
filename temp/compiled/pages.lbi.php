<style>
   /*翻页*/
.xm-pagenavi {
    padding: 30px 0px;
    text-align: center;
}
.xm-pagenavi .numbers {
    display: inline-block;
    height: 18px;
    padding: 8px 13px;
    margin: 0px 2px;
    border: 1px solid #ddd;
	background:#fff;
    font-size: 14px;
    line-height: 18px;
    vertical-align: middle;
    color: #333;
}
.xm-pagenavi .first,.xm-pagenavi .last {
    border:1px #DFDFDF solid;
	cursor:pointer;
	color:#A5A5A5
}
.iconfont {
    font-family: "iconfont" !important;
    font-style: normal;
	color:#A5A5A5
}
.xm-pagenavi span.current {
    color: #fff;
	background:#E4393C;
	border:1px #E4393C solid
}
</style>
 
<form name="selectPageForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
<?php if ($this->_var['pager']['styleid'] == 0): ?>
<div id="pager">
<div class="xm-pagenavi">
	<a class="numbers first iconfont"  href="<?php echo $this->_var['pager']['page_prev']; ?>">上一页</a> 
    <a class="numbers last iconfont" href="<?php echo $this->_var['pager']['page_next']; ?>">下一页</a> 
    <?php $_from = $this->_var['pager']['search']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
      <?php if ($this->_var['key'] == 'keywords'): ?>
          <input type="hidden" name="<?php echo $this->_var['key']; ?>" value="<?php echo urldecode($this->_var['item']); ?>" />
        <?php else: ?>
          <input type="hidden" name="<?php echo $this->_var['key']; ?>" value="<?php echo $this->_var['item']; ?>" />
      <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    <select name="page" id="page" onchange="selectPage(this)">
    <?php echo $this->html_options(array('options'=>$this->_var['pager']['array'],'selected'=>$this->_var['pager']['page'])); ?>
    </select>
</div>
</div>
<?php else: ?>


 <div id="pager">
 <div class="xm-pagenavi">

    <?php if ($this->_var['pager']['page_prev']): ?><a class="numbers first iconfont" href="<?php echo $this->_var['pager']['page_prev']; ?>">&lt;</a><?php endif; ?>
     <?php if ($this->_var['pager']['page_count'] != 1): ?>
     <?php $_from = $this->_var['pager']['page_number']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
      <?php if ($this->_var['pager']['page'] == $this->_var['key']): ?>
      <span class="numbers current"><?php echo $this->_var['key']; ?></span>
      <?php else: ?>
      <a class="numbers" href="<?php echo $this->_var['item']; ?>"><?php echo $this->_var['key']; ?></a>
      <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  <?php endif; ?>
  <?php if ($this->_var['pager']['page_next']): ?><a class="numbers last iconfont" href="<?php echo $this->_var['pager']['page_next']; ?>">&gt;</a><?php endif; ?>
  <?php if ($this->_var['pager']['page_kbd']): ?>
  <a class="numbers" style="height:28px;line-height:23px;padding:0px;margin:0px;border:none">
    <?php $_from = $this->_var['pager']['search']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
      <?php if ($this->_var['key'] == 'keywords'): ?>
          <input type="hidden" name="<?php echo $this->_var['key']; ?>" value="<?php echo urldecode($this->_var['item']); ?>" />
        <?php else: ?>
          <input type="hidden" name="<?php echo $this->_var['key']; ?>" value="<?php echo $this->_var['item']; ?>" />
      <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    <kbd style="float:left;"><input type="text" name="page" onkeydown="if(event.keyCode==13)selectPage(this)" size="3" style=" height: 18px;padding: 8px;border: 1px solid #ddd;margin-top:-4px; text-align:center"/></kbd>
    </a>
    <?php endif; ?>
</div>
</div>


<?php endif; ?>
</form>
<script type="Text/Javascript" language="JavaScript">
<!--

function selectPage(sel)
{
  sel.form.submit();
}

//-->
</script>




