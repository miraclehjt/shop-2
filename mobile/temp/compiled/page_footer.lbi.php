<div class="footer" >
      <div class="links"  id="ECS_MEMBERZONE"> <?php echo $this->smarty_insert_scripts(array('files'=>'utils.js')); ?>
          <?php 
$k = array (
  'name' => 'member_info',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?></div>
          <ul class="linkss" >
          <li>
            <a href="#">
            <i class="footerimg_1"></i>
            <span >客户端</span></a></li>
          <li>
          <a href="javascript:;"><i class="footerimg_2"></i><span class="gl">触屏版</span></a></li>
          <li><a href="index.php?is_c=1" class="goDesktop"><i class="footerimg_3"></i><span>电脑版</span></a></li></ul>
  	 <p class="mf_o4"><?php echo $this->_var['copyright']; ?></p>
</div>

