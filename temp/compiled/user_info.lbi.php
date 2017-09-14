<div class="sideNav">
  <h1><a href="#"><span>会员中心</span></a></h1>
  <div class="userInfo">
    <div class="myInfo clearfix"> 
      <div class="photo">
        <div class="mask"></div>
        
        <img id="headImagePath" src="<?php if ($_SESSION['headimg']): ?><?php echo $_SESSION['headimg']; ?><?php else: ?>themes/68ecshopcom_360buy/images/shengji_ad/peopleicon_01.gif<?php endif; ?>" height="80" width="80">
        
       <!-- <img id="headImagePath" src="themes/68ecshopcom_360buy/images/shengji_ad/peopleicon_02.gif" height="80" width="80">-->
      </div>
      <div class="info_op">
      	<ul>
        	<li class="info_op2"><i></i><a href="user.php?act=profile" >修改资料</a></li>
        	<li class="info_op3"><i></i><a href="user.php?act=logout" >安全退出</a></li>
        </ul>
      </div>
    </div>
    <p class="cost"><?php echo $_SESSION['user_name']; ?></p>
  </div>
</div>
