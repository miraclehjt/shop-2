
<script type="text/javascript">
			   function tell_me(goods_id, no_have_val)
			   {
			
			  no_have = (typeof(no_have_val) == "undefined" ? 0 : no_have_val)
			  Ajax.call('user.php?act=book_goods', 'id=' + goods_id + '&no_have=' + no_have, tellmeResponse, 'GET', 'JSON');
			
				}
				
	
			 function tell_me1( no_have_val)
			{
				var num=document.getElementById('book_number').value;
				var tel=document.getElementById('phone_num').value;
				var email=document.getElementById('arrival_email').value;
				var goods_id = document.getElementById('g_id').value;
			
				
				no_have = (typeof(no_have_val) == "undefined" ? 0 : no_have_val);
				Ajax.call('user.php?act=add_book_goods', 'id=' + goods_id + '&no_have=' + no_have+ '&num=' + num+ '&tel=' + tel+ '&em=' + email, tellmeResponse, 'GET', 'JSON');
	
			}
			
			function tellmeResponse(result)
			{
				
				if(result.error==1)
				{
				//document.getElementById('tell_me_form').style.display = document.getElementById('tell_me_form').style.display=='none'?'block':'none';
				document.getElementById('tell_me_form').style.display = 'block';
				document.getElementById('bg').style.display='block';
				document.getElementById('phone_num').value=result.tel;
				document.getElementById('arrival_email').value=result.email;

				}
				 if(result.error==0)
				 {
					 alert(result.message);
					 }
				 if(result.error==2)
				  {
					  alert(result.message);
				  	  document.getElementById('tell_me_form').style.display = document.getElementById('tell_me_form').style.display=='none'?'block':'none';
					  document.getElementById('bg').style.display='none';
					  }
				 
			}
    </script>
<div id="tell_me_form" style="display:none;">
  <div class="tell_me_tit">到货通知<span class="tell_me_close"></span></div>
  <div class="tell_me_con">
  	<table width="0" border="0" cellspacing="1" cellpadding="5">
      <tr>
        <td align="left" style="padding:15px 0 15px 0;"><div style="background:#FFFDEE ;padding:10px 10px;border:1px dotted #ff3300;height:60px;line-height:150%; font-weight:normal">
            <p id="rgoods_name" style="font-size:15px;color:#F52648; height:30px; line-height:30px; overflow:hidden"></p>对不起，该商品已经库存不足暂停销售。
您可以通过“到货通知”来预定该商品。
            当商品进行补货时，我们将以短信、邮件的形式通知您，最多发送一次，不会对您造成干扰。 </div></td>
      </tr>
    </table>

    <table cellpadding=0 cellspacing=0 width="100%" border=0>
      <tr>
        <td width="150" align="right" class="td_l">数量：</td>
        <td align="left" class="td_r"><input type="text" value="1" id="book_number" /></td>
      </tr>
      <tr>
        <td align="right" class="td_l">手机号码：</td>
        <td align="left" class="td_r"><input type="text" value="" id="phone_num" /></td>
      </tr>
      <tr>
        <td align="right" class="td_l">电子邮箱：</td>
        <td align="left" class="td_r"><input type="text" value="" id="arrival_email" /></td>
      </tr>
      <tr>
        <td class="td_l">&nbsp;</td>
        <td align="left" class="td_r"><input type="button" value="提交" onclick="tell_me1()" class="tell_btn"/>
        	<input type="hidden" id="g_id" value="" />
          <input type="reset" value="重置"   class="tell_btn"/></td>
      </tr>
    </table>
  </div>
</div>
<script>
                $(function(){
					$('#tell_me_form').css('left',($(window).width()-500)/2);
					$('#tell_me_form').css('top',($(window).height()-300)/2);
					$('.tell_me_close').click(function(){
						$('#tell_me_form').hide();	
						document.getElementById('bg').style.display='none';
					})
				})
                </script> 
