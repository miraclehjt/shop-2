// JavaScript Document 

/*
	初始化切换菜单面板的方法
	需要切换面板的铵钮元素为li, class为tabNav
	切换面板的内容元素为div, class为tabItem
	id: 面板库的总ID
	tabNav的元素个数必需与tabItem的个数一致
	切换面板的菜单必需为a元素，激活样式为curr
*/
function initTabs(id)
{

	var dom = document.getElementById(id);
	var t_navs = dom.getElementsByTagName("LI");
	var t_tabs = dom.getElementsByTagName("DIV");
	
	var navs = Array();
	var tabs = Array();
	
	for(var i=0;i<t_navs.length;i++)
	{
		if(t_navs[i].className == "tabNav")
		{
			navs.push(t_navs[i]);	
		}
	}
	
	for(var i=0;i<t_tabs.length;i++)
	{
		if(t_tabs[i].className == "tabItem")
		{
			tabs.push(t_tabs[i]);	
		}
	}

	for(var i=0;i<navs.length;i++)
	{
			if(i==0) //当第一个按钮时将按钮内的a设为curr
			{
				var a_els = navs[i].getElementsByTagName("A");
				for(var j=0;j<a_els.length;j++)
				{
						a_els[j].className = "curr";
				}
				tabs[i].style.display = "block";
			}			
			else
			{
				var a_els = navs[i].getElementsByTagName("A");
				for(var j=0;j<a_els.length;j++)
				{
						a_els[j].className = "";
				}
				tabs[i].style.display = "none";
			}
			navs[i].onmouseover =function(){ swap_tab(this, id); } //绑定事件

	}
}
function swap_tab(obj,id)
{
	var dom = document.getElementById(id);
	var t_navs = dom.getElementsByTagName("LI");
	var t_tabs = dom.getElementsByTagName("DIV");
	
	var navs = Array();
	var tabs = Array();
	
	for(var i=0;i<t_navs.length;i++)
	{
		if(t_navs[i].className == "tabNav")
		{
			navs.push(t_navs[i]);	
		}
	}
	
	for(var i=0;i<t_tabs.length;i++)
	{
		if(t_tabs[i].className == "tabItem")
		{
			tabs.push(t_tabs[i]);	
		}
	}
	
	for(var i=0;i<navs.length;i++)
	{
		if(obj==navs[i])
		{
			var a_els = navs[i].getElementsByTagName("A");
			for(var j=0;j<a_els.length;j++)
			{
					a_els[j].className = "curr";
			}	
			
			tabs[i].style.display="block";
		}
		else
		{
			var a_els = navs[i].getElementsByTagName("A");
			for(var j=0;j<a_els.length;j++)
			{
					a_els[j].className = "";
			}	
			tabs[i].style.display="none";
		}
	}
	
}


//无间断滚动
function Marquee()
{
	this.ID = document.getElementById(arguments[0]);
	if(!this.ID)
	{
		alert("您要设置的\"" + arguments[0] + "\"初始化错误\r\n请检查标签ID设置是否正确!");
		this.ID = -1;
		return;
	}
	this.Direction = this.Width = this.Height = this.DelayTime = this.WaitTime = this.CTL = this.StartID = this.Stop = this.MouseOver = 0;
	this.Step = 1;
	this.Timer = 30;
	this.DirectionArray = {"top":0 , "up":0 , "bottom":1 , "down":1 , "left":2 , "right":3};
	if(typeof arguments[1] == "number" || typeof arguments[1] == "string")this.Direction = arguments[1];
	if(typeof arguments[2] == "number")this.Step = arguments[2];
	if(typeof arguments[3] == "number")this.Width = arguments[3];
	if(typeof arguments[4] == "number")this.Height = arguments[4];
	if(typeof arguments[5] == "number")this.Timer = arguments[5];
	if(typeof arguments[6] == "number")this.DelayTime = arguments[6];
	if(typeof arguments[7] == "number")this.WaitTime = arguments[7];
	if(typeof arguments[8] == "number")this.ScrollStep = arguments[8];
	this.ID.style.overflow = this.ID.style.overflowX = this.ID.style.overflowY = "hidden";
	this.ID.noWrap = true;
	this.IsNotOpera = (navigator.userAgent.toLowerCase().indexOf("opera") == -1);
	if(arguments.length >= 7)this.Start();
}

Marquee.prototype.Start = function()
{
	if(this.ID == -1)return;
	if(this.WaitTime < 800)this.WaitTime = 800;
	if(this.Timer < 20)this.Timer = 20;
	if(this.Width == 0)this.Width = parseInt(this.ID.style.width);
	if(this.Height == 0)this.Height = parseInt(this.ID.style.height);
	if(typeof this.Direction == "string")this.Direction = this.DirectionArray[this.Direction.toString().toLowerCase()];
	this.HalfWidth = Math.round(this.Width / 2);
	this.HalfHeight = Math.round(this.Height / 2);
	this.BakStep = this.Step;
	this.ID.style.width = this.Width + "px";
	this.ID.style.height = this.Height + "px";
	if(typeof this.ScrollStep != "number")this.ScrollStep = this.Direction > 1 ? this.Width : this.Height;
	var templateLeft = "<table cellspacing='0' cellpadding='0' style='border-collapse:collapse;display:inline;'><tr><td noWrap=true style='white-space: nowrap;word-break:keep-all;'>MSCLASS_TEMP_HTML</td><td noWrap=true style='white-space: nowrap;word-break:keep-all;'>MSCLASS_TEMP_HTML</td></tr></table>";
	var templateTop = "<table cellspacing='0' cellpadding='0' style='border-collapse:collapse;'><tr><td>MSCLASS_TEMP_HTML</td></tr><tr><td>MSCLASS_TEMP_HTML</td></tr></table>";
	var msobj = this;
	msobj.tempHTML = msobj.ID.innerHTML;
	if(msobj.Direction <= 1)
	{
		msobj.ID.innerHTML = templateTop.replace(/MSCLASS_TEMP_HTML/g,msobj.ID.innerHTML);
	}
	else
	{
		if(msobj.ScrollStep == 0 && msobj.DelayTime == 0)
		{
			msobj.ID.innerHTML += msobj.ID.innerHTML;
		}
		else
		{
			msobj.ID.innerHTML = templateLeft.replace(/MSCLASS_TEMP_HTML/g,msobj.ID.innerHTML);
		}
	}
	var timer = this.Timer;
	var delaytime = this.DelayTime;
	var waittime = this.WaitTime;
	msobj.StartID = function(){msobj.Scroll()}
	msobj.Continue = function()
				{
					if(msobj.MouseOver == 1)
					{
						setTimeout(msobj.Continue,delaytime);
					}
					else
					{	clearInterval(msobj.TimerID);
						msobj.CTL = msobj.Stop = 0;
						msobj.TimerID = setInterval(msobj.StartID,timer);
					}
				}

	msobj.Pause = function()
			{
				msobj.Stop = 1;
				clearInterval(msobj.TimerID);
				setTimeout(msobj.Continue,delaytime);
			}

	msobj.Begin = function()
		{
			msobj.ClientScroll = msobj.Direction > 1 ? msobj.ID.scrollWidth / 2 : msobj.ID.scrollHeight / 2;
			if((msobj.Direction <= 1 && msobj.ClientScroll <= msobj.Height + msobj.Step) || (msobj.Direction > 1 && msobj.ClientScroll <= msobj.Width + msobj.Step))			{
				msobj.ID.innerHTML = msobj.tempHTML;
				delete(msobj.tempHTML);
				return;
			}
			delete(msobj.tempHTML);
			msobj.TimerID = setInterval(msobj.StartID,timer);
			if(msobj.ScrollStep < 0)return;
			msobj.ID.onmousemove = function(event)
						{
							if(msobj.ScrollStep == 0 && msobj.Direction > 1)
							{
								var event = event || window.event;
								if(window.event)
								{
									if(msobj.IsNotOpera)
									{
										msobj.EventLeft = event.srcElement.id == msobj.ID.id ? event.offsetX - msobj.ID.scrollLeft : event.srcElement.offsetLeft - msobj.ID.scrollLeft + event.offsetX;
									}
									else
									{
										msobj.ScrollStep = null;
										return;
									}
								}
								else
								{
									msobj.EventLeft = event.layerX - msobj.ID.scrollLeft;
								}
								msobj.Direction = msobj.EventLeft > msobj.HalfWidth ? 3 : 2;
								msobj.AbsCenter = Math.abs(msobj.HalfWidth - msobj.EventLeft);
								msobj.Step = Math.round(msobj.AbsCenter * (msobj.BakStep*2) / msobj.HalfWidth);
							}
						}
			msobj.ID.onmouseover = function()
						{
							if(msobj.ScrollStep == 0)return;
							msobj.MouseOver = 1;
							clearInterval(msobj.TimerID);
						}
			msobj.ID.onmouseout = function()
						{
							if(msobj.ScrollStep == 0)
							{
								if(msobj.Step == 0)msobj.Step = 1;
								return;
							}
							msobj.MouseOver = 0;
							if(msobj.Stop == 0)
							{
								clearInterval(msobj.TimerID);
								msobj.TimerID = setInterval(msobj.StartID,timer);
							}
						}
		}
	setTimeout(msobj.Begin,waittime);
}

Marquee.prototype.Scroll = function()
{
	switch(this.Direction)
	{
		case 0:
			this.CTL += this.Step;
			if(this.CTL >= this.ScrollStep && this.DelayTime > 0)
			{
				this.ID.scrollTop += this.ScrollStep + this.Step - this.CTL;
				this.Pause();
				return;
			}
			else
			{
				if(this.ID.scrollTop >= this.ClientScroll)
				{
					this.ID.scrollTop -= this.ClientScroll;
				}
				this.ID.scrollTop += this.Step;
			}
		break;

		case 1:
			this.CTL += this.Step;
			if(this.CTL >= this.ScrollStep && this.DelayTime > 0)
			{
				this.ID.scrollTop -= this.ScrollStep + this.Step - this.CTL;
				this.Pause();
				return;
			}
			else
			{
				if(this.ID.scrollTop <= 0)
				{
					this.ID.scrollTop += this.ClientScroll;
				}
				this.ID.scrollTop -= this.Step;
			}
		break;

		case 2:
			this.CTL += this.Step;
			if(this.CTL >= this.ScrollStep && this.DelayTime > 0)
			{
				this.ID.scrollLeft += this.ScrollStep + this.Step - this.CTL;
				this.Pause();
				return;
			}
			else
			{
				if(this.ID.scrollLeft >= this.ClientScroll)
				{
					this.ID.scrollLeft -= this.ClientScroll;
				}
				this.ID.scrollLeft += this.Step;
			}
		break;

		case 3:
			this.CTL += this.Step;
			if(this.CTL >= this.ScrollStep && this.DelayTime > 0)
			{
				this.ID.scrollLeft -= this.ScrollStep + this.Step - this.CTL;
				this.Pause();
				return;
			}
			else
			{
				if(this.ID.scrollLeft <= 0)
				{
					this.ID.scrollLeft += this.ClientScroll;
				}
				this.ID.scrollLeft -= this.Step;
			}
		break;
	}
}


/*切换产品图库*/
function sw_goodsimg(obj)
{
	imgs = obj.getElementsByTagName("IMG");
	document.getElementById("goods_bimg").src = imgs[0].src;
	var glist_divs = document.getElementById("goods_gallery").getElementsByTagName("DIV");
	for(var i=0;i<glist_divs.length;i++)
	{
		if(obj.parentNode == glist_divs[i])
		{
			glist_divs[i].className = "curr";
		}
		else
		{
			glist_divs[i].className = "";	
		}
	}
	//dev版本为放大镜的扩展
	
	ele_a = document.getElementById("goods_bimg").parentNode;
	if(ele_a.tagName=="A")
	{
		ele_a.href=imgs[0].src;	
	}
	
}




function obj2str(o)
{		
		    var r = [];
			if(typeof o =="string") return "\""+o.replace(/([\'\"\\])/g,"\\$1").replace(/(\n)/g,"\\n").replace(/(\r)/g,"\\r").replace(/(\t)/g,"\\t")+"\"";
			if(typeof o =="undefined") return "undefined";
			if(typeof o == "object"){				
				if(o===null) return "null";
				else if(!o.sort){
					for(var i in o)
					{		
						if(i!="toJSONString") //增加判断，清除对object原型的定义加入到json中
						r.push("\""+i+"\""+":"+obj2str(o[i]));
					}
					r="{"+r.join()+"}";
				}else{
					for(var i =0;i<o.length;i++)
						r.push(obj2str(o[i]))
					r="["+r.join()+"]"
				}
				return r;
			}
			return o.toString();
		//结束			
}
	
//用于定时器的自动滚动的层
lastScrollY=0;
function flowdiv(domid){
　　　var diffY;
　　　　if (document.documentElement && document.documentElement.scrollTop)
　　　　　　diffY = document.documentElement.scrollTop;
　　　　else if (document.body)
　　　　　　diffY = document.body.scrollTop
　　　　else
　　　　　　{/*Netscape stuff*/}
　　　　//alert(diffY);
　　　　percent=.1*(diffY-lastScrollY); 
　　　　if(percent>0) percent=Math.ceil(percent); 
　　　　else percent=Math.floor(percent); 
　　　　document.getElementById(domid).style.top=parseInt(document.getElementById(domid).style.top)+percent+"px";
　　　　lastScrollY=lastScrollY+percent; 
　　　　//alert(lastScrollY);
}



	
//下面开始重写调用tojson的一些ajax方法，主要针对common.js

/* *
 * 添加商品到购物车
 */
function addToCart(goodsId, parentId)
{
  var goods        = new Object();
  var spec_arr     = new Array();
  var fittings_arr = new Array();
  var number       = 1;
  var formBuy      = document.forms['ECS_FORMBUY'];

  // 检查是否有商品规格
  if (formBuy)
  {
    spec_arr = getSelectedAttributes(formBuy);

    if (formBuy.elements['number'])
    {
      number = formBuy.elements['number'].value;
    }
  }

  goods.spec     = spec_arr;
  goods.goods_id = goodsId;
  goods.number   = number;
  goods.parent   = (typeof(parentId) == "undefined") ? 0 : parseInt(parentId);

  Ajax.call('flow.php?step=add_to_cart', 'goods=' + obj2str(goods), addToCartResponse, 'POST', 'JSON');
}
/* *
 * 添加礼包到购物车
 */
function addPackageToCart(packageId)
{
  var package_info = new Object();
  var number       = 1;

  package_info.package_id = packageId
  package_info.number     = number;

  Ajax.call('flow.php?step=add_package_to_cart', 'package_info=' + obj2str(package_info), addPackageToCartResponse, 'POST', 'JSON');
}



