      <!-- $Id: page.htm 14216 2008-03-10 02:27:21Z testyang $ -->
      <?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js')); ?>
      <div id="turn-page">
        <?php echo $this->_var['lang']['total_records']; ?> <span id="totalRecords"><?php echo $this->_var['record_count']; ?></span>
        <?php echo $this->_var['lang']['total_pages']; ?> <span id="totalPages"><?php echo $this->_var['page_count']; ?></span>
        <?php echo $this->_var['lang']['page_current']; ?> <span id="pageCurrent"><?php echo $this->_var['filter']['page']; ?></span>
        <?php echo $this->_var['lang']['page_size']; ?> <input type='text' size='3' id='pageSize' value="<?php echo $this->_var['filter']['page_size']; ?>" onkeypress="return listTable.changePageSize(event)" />
        <span id="page-link">
          <a href="javascript:listTable.gotoPageFirst()"><?php echo $this->_var['lang']['page_first']; ?></a>
          <a href="javascript:listTable.gotoPagePrev()"><?php echo $this->_var['lang']['page_prev']; ?></a>
          <a href="javascript:listTable.gotoPageNext()"><?php echo $this->_var['lang']['page_next']; ?></a>
          <a href="javascript:listTable.gotoPageLast()"><?php echo $this->_var['lang']['page_last']; ?></a>
          <select id="gotoPage" onchange="listTable.gotoPage(this.value)">
            <?php echo $this->smarty_create_pages(array('count'=>$this->_var['page_count'],'page'=>$this->_var['filter']['page'])); ?>
          </select>
        </span>
      </div>
