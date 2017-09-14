<!-- $Id: brand_search.htm 2015-02-10 derek $ -->
<div class="form-div">
  <form action="javascript:search_category()" name="searchForm">
    <img src="images/icon_search.gif" width="26" height="22" border="0" alt="SEARCH" />
    <?php echo $this->_var['lang']['keyword']; ?> <input type="text" name="cat_name" size="20" />
    <input type="submit" value="<?php echo $this->_var['lang']['button_search']; ?>" class="button" />
  </form>
</div>

<script language="JavaScript">
    function search_category()
    {
    	
        listTable.filter['cat_name'] = Utils.trim(document.forms['searchForm'].elements['cat_name'].value);
        listTable.filter['page'] = 1;
        
        listTable.loadList();
        
    }

</script>
