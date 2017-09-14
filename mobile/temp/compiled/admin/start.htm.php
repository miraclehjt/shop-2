<!-- $Id: start.htm 17216 2011-01-19 06:03:12Z Shadow & 鸿宇 -->

<?php echo $this->fetch('pageheader.htm'); ?>

<!-- directory install start -->



<script type="Text/Javascript" language="JavaScript">

<!--

  Ajax.call('cloud.php?is_ajax=1&act=cloud_remind','', cloud_api, 'GET', 'JSON');

    function cloud_api(result)

    {

      //alert(result.content);

      if(result.content=='0')

      {

        document.getElementById("cloud_list").style.display ='none';

      }

      else

       {

         document.getElementById("cloud_list").innerHTML =result.content;

      }

    } 

   function cloud_close(id)

    {

      Ajax.call('cloud.php?is_ajax=1&act=close_remind&remind_id='+id,'', cloud_api, 'GET', 'JSON');

    }

  //-->

 </script> 



<ul style="padding:0; margin: 0; list-style-type:none; color: #CC0000;">

 <!-- <script type="text/javascript" src="http://bbs.hongyuvip.com/notice.php?v=1&n=8&f=ul"></script>-->

</ul>

<!-- directory install end -->

<!-- start personal message -->

<?php if ($this->_var['admin_msg']): ?>

<div class="list-div" style="border: 1px solid #CC0000">

  <table cellspacing='1' cellpadding='3'>

    <tr>

      <th><?php echo $this->_var['lang']['pm_title']; ?></th>

      <th><?php echo $this->_var['lang']['pm_username']; ?></th>

      <th><?php echo $this->_var['lang']['pm_time']; ?></th>

    </tr>

    <?php $_from = $this->_var['admin_msg']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'msg');if (count($_from)):
    foreach ($_from AS $this->_var['msg']):
?>

      <tr align="center">

        <td align="left"><a href="message.php?act=view&id=<?php echo $this->_var['msg']['message_id']; ?>"><?php echo sub_str($this->_var['msg']['title'],60); ?></a></td>

        <td><?php echo $this->_var['msg']['user_name']; ?></td>

        <td><?php echo $this->_var['msg']['send_date']; ?></td>

      </tr>

    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

  </table>

  </div>

<br />

<?php endif; ?>

<!-- end personal message -->


<!-- start system information -->

<div class="list-div">

<table cellspacing='1' cellpadding='3'>

  <tr>

    <th colspan="4" class="group-title"><?php echo $this->_var['lang']['system_info']; ?></th>

  </tr>

  <tr>

    <td width="20%"><?php echo $this->_var['lang']['os']; ?></td>

    <td width="30%"><?php echo $this->_var['sys_info']['os']; ?> (<?php echo $this->_var['sys_info']['ip']; ?>)</td>

    <td width="20%"><?php echo $this->_var['lang']['web_server']; ?></td>

    <td width="30%"><?php echo $this->_var['sys_info']['web_server']; ?></td>

  </tr>

  <tr>

    <td><?php echo $this->_var['lang']['php_version']; ?></td>

    <td><?php echo $this->_var['sys_info']['php_ver']; ?></td>

    <td><?php echo $this->_var['lang']['mysql_version']; ?></td>

    <td><?php echo $this->_var['sys_info']['mysql_ver']; ?></td>

  </tr>

  <tr>

    <td><?php echo $this->_var['lang']['safe_mode']; ?></td>

    <td><?php echo $this->_var['sys_info']['safe_mode']; ?></td>

    <td><?php echo $this->_var['lang']['safe_mode_gid']; ?></td>

    <td><?php echo $this->_var['sys_info']['safe_mode_gid']; ?></td>

  </tr>

  <tr>

    <td><?php echo $this->_var['lang']['socket']; ?></td>

    <td><?php echo $this->_var['sys_info']['socket']; ?></td>

    <td><?php echo $this->_var['lang']['timezone']; ?></td>

    <td><?php echo $this->_var['sys_info']['timezone']; ?></td>

  </tr>

  <tr>

    <td><?php echo $this->_var['lang']['gd_version']; ?></td>

    <td><?php echo $this->_var['sys_info']['gd']; ?></td>

    <td><?php echo $this->_var['lang']['zlib']; ?></td>

    <td><?php echo $this->_var['sys_info']['zlib']; ?></td>

  </tr>

  <tr>

    <td><?php echo $this->_var['lang']['ip_version']; ?></td>

    <td><?php echo $this->_var['sys_info']['ip_version']; ?></td>

    <td><?php echo $this->_var['lang']['max_filesize']; ?></td>

    <td><?php echo $this->_var['sys_info']['max_filesize']; ?></td>

  </tr>

  <tr>

    <td>鸿宇多用户商城 多商户 WAP V4版</td>

    <td>客服 QQ 1527200768</td>

    <td><?php echo $this->_var['lang']['install_date']; ?></td>

    <td><?php echo $this->_var['install_date']; ?></td>

  </tr>

  <tr>

    <td><?php echo $this->_var['lang']['ec_charset']; ?></td>

    <td><?php echo $this->_var['ecs_charset']; ?></td>

    <td>鸿宇官网:</td>

    <td>HongYuvip.com</td>

  </tr>

</table>

</div>
<br />

<div class="list-div">
<table cellspacing='1' cellpadding='1'>

  <tr>
    <th class="group-title">安全提示</th>
  </tr>
  <tr>
  	<td>
    强烈建议您将data/config.php文件属性设置为644（linu/unix）或只读权限（WinNT）<br />
    强烈建议您在网站上线之后将后台入口目录admin重命名，可增加系统安全性<br />
    请注意定期做好数据备份，数据的定期备份可最大限度的保障您网站数据的安全
    </td>
  </tr>
  </table>
</div>



<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js')); ?>

<script type="Text/Javascript" language="JavaScript">

<!--

onload = function()

{

  /* 检查订单 */

  startCheckOrder();

}

  Ajax.call('index.php?is_ajax=1&act=main_api','', start_api, 'GET', 'TEXT','FLASE');

  //Ajax.call('cloud.php?is_ajax=1&act=cloud_remind','', cloud_api, 'GET', 'JSON');

   function start_api(result)

    {

      apilist = document.getElementById("lilist").innerHTML;

      document.getElementById("lilist").innerHTML =result+apilist;

      if(document.getElementById("Marquee") != null)

      {

        var Mar = document.getElementById("Marquee");

        lis = Mar.getElementsByTagName('div');

        //alert(lis.length); //显示li元素的个数

        if(lis.length>1)

        {

          api_styel();

        }      

      }

    }

 

      function api_styel()

      {

        if(document.getElementById("Marquee") != null)

        {

            var Mar = document.getElementById("Marquee");

            if (Browser.isIE)

            {

              Mar.style.height = "52px";

            }

            else

            {

              Mar.style.height = "36px";

            }

            

            var child_div=Mar.getElementsByTagName("div");



        var picH = 16;//移动高度

        var scrollstep=2;//移动步幅,越大越快

        var scrolltime=30;//移动频度(毫秒)越大越慢

        var stoptime=4000;//间断时间(毫秒)

        var tmpH = 0;

        

        function start()

        {

          if(tmpH < picH)

          {

            tmpH += scrollstep;

            if(tmpH > picH )tmpH = picH ;

            Mar.scrollTop = tmpH;

            setTimeout(start,scrolltime);

          }

          else

          {

            tmpH = 0;

            Mar.appendChild(child_div[0]);

            Mar.scrollTop = 0;

            setTimeout(start,stoptime);

          }

        }

        setTimeout(start,stoptime);

        }

      }

//-->

</script>



<?php echo $this->fetch('pagefooter.htm'); ?>

