Zepto(function($){
	$.zcontent.add_success(query_success);
	
});

function query_success(result)
{
	if(result.error > 0)
	{
		$.zalert.add(result.message);
		return;
	}
	else
	{
		$('#container').html(result.content);
	}
}
function toggle_menu()
  {
    if($('#con_order_manage_1').css('display') != 'none')
    {
      $('#menu_list').slideToggle(200);
	  $('#menu_list_marker').toggleClass('on off');
    }
    else
    {
		$('#menu_list_marker').removeClass();
		$('#menu_list_marker').addClass('on');
		$('#con_order_manage_2').slideLeftOut(200,function(){$('#con_order_manage_1').slideLeftIn(200)});
    }
  }
  
  function toggle_search()
  {
	$('#menu_list').css('display','none');
	
	if($('#con_order_manage_2').css('display') == 'none')
  {
		$('#con_order_manage_1').slideLeftOut(200,function(){$('#con_order_manage_2').slideLeftIn(200);$('#menu_list_marker').removeClass();
	$('#menu_list_marker').addClass('menu');});
  }
    else
	  {
		$('#con_order_manage_2').slideLeftOut(200,function(){$('#con_order_manage_1').slideLeftIn(200);$('#menu_list_marker').removeClass();
	$('#menu_list_marker').addClass('on');});
	  }
  }

  function refresh()
  {
	  $.zcontent.add_static(['is_ajax']);
	  $.zcontent.clear_non_static();
	  $.zcontent.query();
  }

  function search()
  {
    $.zcontent.query();
  }

  function prev_page()
  {
	$.zcontent.set('page',parseInt($.zcontent.get('page'))-1);
    search();
  }
  
  function next_page()
  {
    $.zcontent.set('page',parseInt($.zcontent.get('page'))+1);
    search();
  }

  function check_form_empty(formName)
  {
	  var form = document.forms[formName];
	  var elements = form.elements;
	  var is_empty = true;

	  for (x in elements)
	  {
		  if((elements[x].type == 'text' || elements[x].type == 'password') && $.trim(elements[x].value) != '')
		  {
			is_empty = false;
		  }
	  }

	  return is_empty;
  }