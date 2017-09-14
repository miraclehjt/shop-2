<!-- $Id: brand_search.htm 2009-05-04 liuhui $ -->
<div class="form-div">
  <form action="javascript:search_brand()" name="searchForm">
    <img src="images/icon_search.gif" width="26" height="22" border="0" alt="SEARCH" />
    商品名称 <input type="text" name="goods_name" size="15" /> &nbsp; 
    晒单标题 <input type="text" name="title" size="15" /> &nbsp; 
    晒单会员 <input type="text" name="user_name" size="15" />
    <input type="submit" value="<?php echo $this->_var['lang']['button_search']; ?>" class="button" />
  </form>
</div>

<script language="JavaScript">
    function search_brand()
    {
        listTable.filter['user_name'] = Utils.trim(document.forms['searchForm'].elements['user_name'].value);
		listTable.filter['title'] = Utils.trim(document.forms['searchForm'].elements['title'].value);
		listTable.filter['goods_name'] = Utils.trim(document.forms['searchForm'].elements['goods_name'].value);
        listTable.filter['page'] = 1;
        
        listTable.loadList();
    }

</script>
