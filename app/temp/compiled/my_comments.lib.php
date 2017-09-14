    <div class="ubb border-hui bg-color-w ulev-1 ios-top1">
      <div class="ub p-t-b4 f-color-6 ubb border-faxian">
	  <div class="comments-hpd ub ub-ac ub-pc ub-f1 ubr border-faxian"><div><div class="f-color-red ulev2"><?php echo $this->_var['rank_num']['rank_pa']; ?>%</div><p>好评度</p></div></div>
        <div class="ub-f1">
          <div class="ub ub-pc ub-ac m-btm3">
			<div class="umar-ar6 w-min3">好评：
				<span class="sc-text-hui">(<?php echo $this->_var['rank_num']['rank_pa']; ?>%)</span>
			</div>
			<div class="hpd1">
				<div class="hpd2" style="width:<?php echo $this->_var['rank_num']['rank_pa']; ?>%"></div>
			</div>
		  </div>
          <div class="ub ub-pc ub-ac m-btm3">
			  <div class="umar-ar6 w-min3">中评：
				<span class="sc-text-hui">(<?php echo $this->_var['rank_num']['rank_pb']; ?>%)</span>
			  </div>
			  <div class="hpd1">
				<div class="hpd2" style="width:<?php echo $this->_var['rank_num']['rank_pb']; ?>%"></div>
			  </div>
		  </div>
          <div class="ub ub-pc ub-ac m-btm3">
			  <div class="umar-ar6 w-min3">差评：
			  <span class="sc-text-hui">(<?php echo $this->_var['rank_num']['rank_pc']; ?>%)</span>
			  </div>
			  <div class="hpd1">
				<div class="hpd2" style="width:<?php echo $this->_var['rank_num']['rank_pc']; ?>%"></div>
			  </div>
		  </div>
        </div>
      </div>
      <div class="ub umar-t1 p-all2">
        <div class="comments-num curr comment_tap ub-f1 tx-c" comment_type='0'>
          全部评价
          <div class="num-div ub ub-pc">
            <div class="num"><?php echo $this->_var['rank_num']['rank_total']; ?></div>
          </div>
        </div>
        <div class="comments-num comment_tap ub-f1 tx-c" comment_type='1'>
          好评
          <div class="num-div ub ub-pc">
            <div class="num"><?php echo $this->_var['rank_num']['rank_a']; ?></div>
          </div>
        </div>
        <div class="comments-num comment_tap ub-f1 tx-c" comment_type='2'>
          中评
          <div class="num-div ub ub-pc">
            <div class="num"><?php echo $this->_var['rank_num']['rank_b']; ?></div>
          </div>
        </div>
        <div class="comments-num comment_tap ub-f1 tx-c" comment_type='3'>
          差评
          <div class="num-div ub ub-pc">
            <div class="num"><?php echo $this->_var['rank_num']['rank_c']; ?></div>
          </div>
        </div>
        <div class="comments-num comment_tap ub-f1 tx-c" comment_type='4'>
          用户晒单
          <div class="num-div ub ub-pc">
            <div class="num"><?php echo $this->_var['rank_num']['shaidan_num']; ?></div>
          </div>
        </div>
      </div>
	  <div id='comment_container'>
	  <?php echo $this->fetch('library/my_comments_list.lib'); ?>
	  </div>
    </div>