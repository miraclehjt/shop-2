<?php echo $this->fetch('pageheader.htm'); ?>

<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>

<div id="tabbody-div">

<form name="theForm" method="post" action="weixin.php?act=addkey&id=<?php echo $this->_var['keywords']['id']; ?>" enctype="multipart/form-data" onsubmit="return sub_key(this)">

  <table width="100%" cellpadding="3" cellspacing="1">

  <tbody>

  <tr>

    <td class="label">功能描述:</td>

    <td><input type="text" name="keyname" value="<?php echo $this->_var['keywords']['keyname']; ?>"></td>

  </tr>

  <tr>

    <td class="label">主关键字:</td>

    <td><input type="text" name="key" value="<?php echo $this->_var['keywords']['key']; ?>"></td>

  </tr>

  <tr>

    <td class="label">扩展关键字:</td>

    <td><input type="text" name="keys" value="<?php echo $this->_var['keywords']['keys']; ?>">(多个用空格分割)</td>

  </tr>

  <tr>

    <td class="label">回复类型:</td>

    <td>

	<input type="radio" name="diy_type" onclick="shownews(1)" value="1" <?php if ($this->_var['keywords']['diy_type'] != 2): ?>checked<?php endif; ?>>自定义文字

	<input type="radio" name="diy_type" onclick="shownews(2)" value="2" <?php if ($this->_var['keywords']['diy_type'] == 2): ?>checked<?php endif; ?>>自定义图文

	</td>

  </tr>

  <tr id="menuvalue" <?php if ($this->_var['keywords'] [ 'diy_type' ] == 2): ?>style="display:none"<?php endif; ?>>

    <td class="narrow-label">回复内容：</td>

	<td><textarea name="description1" cols="40" rows="5"><?php echo htmlspecialchars($this->_var['article']['description']); ?></textarea>
   <br /><span style=" color:#F30;">*&nbsp;注:&nbsp;此处必须填写内容，不能为空。</span>
    </td>

  </tr>



  <tr id="news" <?php if ($this->_var['keywords'] [ 'diy_type' ] != 2): ?>style="display:none"<?php endif; ?>>

	<td colspan="2">

		<table width="90%" align="right">

			<tr>

				<td class="narrow-label">标题：</td>

				<td><input type="text" name="title" size ="40" maxlength="60" value="<?php echo htmlspecialchars($this->_var['article']['title']); ?>" /></td>

			</tr>

			<tr>

				<td class="narrow-label">上传图片：</td>

				<td><input type="file" name="file"></td>

			</tr>

			<tr>

				<td class="narrow-label">描述内容：</td>

				<td><textarea name="description2" cols="40" rows="5"><?php echo htmlspecialchars($this->_var['article']['description']); ?></textarea></td>

			</tr>

			<tr>

				<td class="narrow-label">链接地址：</td>

				<td><input name="link_url" type="text" value="<?php echo htmlspecialchars($this->_var['article']['link']); ?>" maxlength="60"></td>

			</tr>

			<input type="hidden" name="article_cat" value="-1" />

			<input type="hidden" name="article_id" value="<?php echo $this->_var['article']['article_id']; ?>" />

			<input type="hidden" name="file_url" value="<?php echo $this->_var['article']['file_url']; ?>" />

		</table>

	</td>

</tr>

  <tr>

    <td colspan="2" align="center">

    <input type="submit" value="<?php echo $this->_var['lang']['button_submit']; ?>" class="button" />

    <input type="reset" value="<?php echo $this->_var['lang']['button_reset']; ?>" class="button" />

    </td>

  </tr>

</tbody></table>

</form>

</div>

<script language="JavaScript">
function sub_key(frm)
{
	 var key = frm.elements['key'].value;
	 if(key.length == 0)
	 {
		 alert('主关键词不能为空！');
		 return false; 
	 }
	 return true;
}
function shownews(t){

	if (t == 2) {

		document.getElementById('news').style.display = "";

		document.getElementById('menuvalue').style.display = "none";

	}else{

		document.getElementById('news').style.display = "none";

		document.getElementById('menuvalue').style.display = "";

	}

}

</script>



<?php echo $this->fetch('pagefooter.htm'); ?>