/**
 * 标签上鼠标移动事件的处理函数
 * @return
 */
document.getElementById("tabbar-div").onmouseover = function(e)
{
  var obj = Utils.srcElement(e);

  if (obj.className == "tab-back")
  {
    obj.className = "tab-hover";
  }
}

document.getElementById("tabbar-div").onmouseout = function(e)
{
  var obj = Utils.srcElement(e);

  if (obj.className == "tab-hover")
  {
    obj.className = "tab-back";
  }
}

/**
 * 处理点击标签的事件的函数
 * @param : e  FireFox 事件句柄
 *
 * @return
 */
document.getElementById("tabbar-div").onclick = function(e)
{
  var obj = Utils.srcElement(e);

  /* 代码增加_start  By bbs.hongyuvip.com */
		if (obj.id=="gallery-tab")
		{
			document.getElementById("goods_info_submit").style.display='none';
			document.getElementById("goods_info_reset").style.display='none';
		}else{
			if(document.getElementById("goods_info_submit"))
			{
				document.getElementById("goods_info_submit").style.display='';
			}
			if(document.getElementById("goods_info_reset"))
			{
			document.getElementById("goods_info_reset").style.display='';
			}
		}
		/* 代码增加_end  By bbs.hongyuvip.com */

  if (obj.className == "tab-front" || obj.className == '' || obj.tagName.toLowerCase() != 'span')
  {
    return;
  }
  else
  {
    objTable = obj.id.substring(0, obj.id.lastIndexOf("-")) + "-table";

    var tables = document.getElementsByTagName("table");
    var spans  = document.getElementsByTagName("span");

    for (i = 0; i < tables.length; i ++ )
    {
      if (tables[i].id == objTable)
      {
        tables[i].style.display = (Browser.isIE) ? "block" : "table";
      }
      else
      {
        var tblId = tables[i].id.match(/-table$/);

        if (tblId == "-table")
        {
          tables[i].style.display = "none";
        }
      }
    }

    for (i = 0; spans.length; i ++ )
    {
      if (spans[i].className == "tab-front")
      {
        spans[i].className = "tab-back";
        obj.className = "tab-front";
        break;
      }
    }
  }
}
