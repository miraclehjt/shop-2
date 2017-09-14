
var kxtimer;var KX001={appkey:'',receiver:'',timer:'',kxbtn:'',ckname:'kx_connect_session_key',curl:'http://www.kaixin001.com/login/connect.php',isIE:(navigator.appVersion.indexOf("MSIE")!=-1)?true:false,init:function(appkey,receiver,btntext,btnlogout,nostyle)
{this.appkey=appkey;this.receiver=receiver;this.kxbtn=document.getElementById("kx001_btn_login");if(typeof(btntext)!='undefined'&&btntext){this.btntext=btntext;}else{this.btntext=unescape("%u767B%u5F55");}
if(typeof(btnlogout)!='undefined'&&btnlogout){this.btnlogout=btnlogout;}else{this.btnlogout=unescape("%u9000%u51FA");}
if(typeof(nostyle)!='undefined'&&nostyle){this.nostyle=true;}else{this.nostyle=false;}
this.setEvent();},getCookie:function()
{var domain=this.getDomain();if(domain){document.domain=domain;}
var arr,reg=new RegExp("(^| )"+this.ckname+"=([^;]*)(;|$)");if(arr=document.cookie.match(reg))
return unescape(arr[2]);else
return null;},getDomain:function()
{var host=window.location.host;host=host.split('.');var domain='';if(host.length==4){domain=host[1]+'.'+host[2]+'.'+host[3];}else if(host.length==3){domain=host[1]+'.'+host[2];}else if(host.length==2){domain=host[0]+'.'+host[1];}
return domain;},delCookie:function()
{var domain=this.getDomain();if(domain){document.domain=domain;domain=";domain=."+domain;}
var exp=new Date();exp.setTime(exp.getTime()-1);var ck=this.getCookie(this.ckname);if(ck&&typeof(ck)!="undefined")
document.cookie=this.ckname+"='';expires="+exp.toGMTString()+";path=/"+domain;},displayCookie:function()
{},setEvent:function()
{ck=this.getCookie();if(ck&&typeof(ck)!="undefined"){this.displayLogout();}else{this.displayLogin();}
if(this.isIE)
{this.kxbtn.attachEvent("onclick",this.handleLogout);}else{this.kxbtn.addEventListener("click",this.handleLogout,false);}},handleLogout:function()
{var kxbtn=document.getElementById("kx001_btn_login");tip=kxbtn.attributes['tip'].nodeValue;if(tip=='1'){KX001.delCookie();window.setTimeout('KX001.displayLogin()',500);KX001.kaixinLogout(KX001.appkey,KX001.receiver);if(typeof(kx001_onlogout)=='function')
{window.setTimeout('kx001_onlogout()',500);}}},kaixinLogout:function(appkey,receiver)
{url='http://www.kaixin001.com/login/connect_logout.php?appkey='+appkey+'&re='+receiver;var t=document.createElement("div");t.innerHTML='<iframe id="kxiframeagent" src="'+url+'" scrolling="yes" style="display:none" height="0px" width="0px"></iframe>';document.documentElement.appendChild(t.firstChild);},handleLogin:function()
{ck=this.getCookie();if(ck&&typeof(ck)!="undefined"){this.displayLogout();if(typeof(kx001_onlogin)=='function')
{kx001_onlogin();}}},displayLogin:function()
{kxtimer=window.setInterval("KX001.handleLogin()",1000);this.kxbtn.href=this.curl+"?appkey="+this.appkey+"&re="+this.receiver+"&t="+Math.round(Math.random()*99);this.kxbtn.target="_blank";if(this.nostyle){this.kxbtn.innerHTML=this.btntext;}else{this.kxbtn.innerHTML="<span style='float:left;cursor:pointer;background:url() no-repeat 100% 0;padding-right:8px;height:23px;'>"+this.btntext+"</span>";this.kxbtn.style.background="transparent url() no-repeat scroll 0 0";this.kxbtn.style.color="#ffffff";this.kxbtn.style.paddingLeft="30px";this.kxbtn.style.fontSize="12px";this.kxbtn.style.height="23px";this.kxbtn.style.lineHeight="23px";this.kxbtn.style.textDecoration="none";this.kxbtn.style.overflow="hidden";if(this.isIE){this.kxbtn.style.styleFloat="left";}else{this.kxbtn.style.cssFloat="left";}}
this.kxbtn.setAttribute('tip','0');return false;},displayLogout:function()
{clearInterval(kxtimer);if(this.nostyle){this.kxbtn.innerHTML=this.btnlogout;}else{this.kxbtn.innerHTML="<span style='float:left;cursor:pointer;background:url() no-repeat 100% 0;padding-right:8px;height:23px;'>"+this.btnlogout+"</span>";this.kxbtn.style.background="transparent url() no-repeat scroll 0 0";this.kxbtn.style.color="#ffffff";this.kxbtn.style.paddingLeft="30px";this.kxbtn.style.fontSize="12px";this.kxbtn.style.height="23px";this.kxbtn.style.lineHeight="23px";this.kxbtn.style.textDecoration="none";this.kxbtn.style.overflow="hidden";this.kxbtn.target="_self";if(this.isIE){this.kxbtn.style.styleFloat="left";}else{this.kxbtn.style.cssFloat="left";}}
this.kxbtn.setAttribute('tip','1');this.kxbtn.href="javascript:void(0);";},showRestProxyDlg:function(url,title,mode,width,height,scrol)
{url=url+'&r='+Math.random();var scrollbars='no';if(scrol==1){scrollbars='yes';}
if(mode==1)
{var _top=(window.screen.height-height)/2;var _left=(window.screen.width-width)/2;window.open(url+'&uu=1','kaixinRestDialog','width='+width+'px,height='+height+'px,location=no,menubar=no,toolbar=no,scrollbars='+scrollbars+',resizable=no,status=no,top='+_top+'px,left='+_left+'px')}
else
{openKxRestWindow(url,width,height,title,scrol);}}};(function(){var g_agt=navigator.userAgent.toLowerCase();var is_opera=(g_agt.indexOf("opera")!=-1);var g_title="";var g_iframeno=0;var g_dialog_sWord;var g_dialog_sButton;var g_dialog_sAction;var g_dialog_excss;function $(s)
{return document.getElementById(s);}
function exist(s)
{return $(s)!=null;}
function myInnerHTML(idname,html)
{if(exist(idname))
{$(idname).innerHTML=html;}}
function _closeDialog()
{if('function'==typeof(close_dlg_callback))
{close_dlg_callback();}
new dialog().close();}
function dialog(v_w,v_h,v_title)
{var width=v_w;var height=v_h;var title=v_title;g_title=title;var sBox='\
      <div id="dialogBox" style="display:none;z-index:1999999;width:'+width+'px;">\
       <div class=ts460 style="position:absolute;top:0px;width:'+width+'px;opacity:0.4;filter:alpha(opacity=40);"><img src="" width="'+width+'" height="8" /></div>\
       <div style="position:absolute;height:'+height+'px;top:8px;" >\
       <table border="0" cellpadding="0" cellspacing="0">\
       <tr style="height:'+(height)+'px;"><td style="background:#000000;width:7px;opacity:0.4;filter:alpha(opacity=40);"></td>\
       <td style="width:'+(width-14)+'px;">\
        <div style="border:1px solid #565656;">\
        <table width="100%" border="0" cellpadding="0" cellspacing="0">\
        ';var sClose='<a style="color:#F6D2D8;text-decoration:none;" href="javascript:_closeKxRestDialog();"><b>×</b></a>';sBox+='\
        <tr height="24" bgcolor="#6795B4">\
         <td>\
          <div style="background:#D01E3B none repeat scroll 0 0;border-bottom:1px solid #565656;font-weight:bold;height:25px;" >\
           <div id="dialogBoxTitle" style="color:#FFFFFF;float:left;font-size:13px;padding:3px 8px;">'+title+'</div>\
           <div id="dialogClose" style="float:right;padding:2px 3px;">'+sClose+'</div>\
          </div>\
         </td>\
        </tr>\
        <tr valign="top">\
         <td id="dialogBody" style="height:'+(height-28)+'px" bgcolor="#ffffff"></td>\
        </tr>\
     ';sBox+='\
        </table>\
        </div>\
       </td>\
       <td style="background:#000000;width:7px;opacity:0.4;filter:alpha(opacity=40);"></td></tr>\
       </table>\
       </div>\
       <div class=ts460 style="position:absolute;top:'+parseInt(height+8)+'px;width:'+width+'px;opacity:0.4;filter:alpha(opacity=40);"><img src="" width="'+width+'" height="8" /></div>\
      </div><div id="dialogBoxShadow" style="display:none;z-index:19998;"></div>\
     ';var sIfram='\
      <iframe id="dialogIframBG" name="dialogIframBG" frameborder="0" marginheight="0" marginwidth="0" hspace="0" vspace="0" scrolling="no" style="position:absolute;z-index:19997;display:none;"></iframe>\
     ';var sBG='\
      <div id="dialogBoxBG" style="position:absolute;top:0px;left:0px;width:100%;height:100%;"></div>\
     ';this.init=function()
{$('dialogCase')?$('dialogCase').parentNode.removeChild($('dialogCase')):function(){};var oDiv=document.createElement('span');oDiv.id="dialogCase";if(!is_opera)
{oDiv.innerHTML=sBG+sIfram+sBox;}
else
{oDiv.innerHTML=sBG+sBox;}
document.body.appendChild(oDiv);}
this.open=function(_sUrl)
{this.show();var scrol="scrolling='no'";if(typeof arguments[1]!="undefined"&&arguments[1]==1){scrol='scrolling="yes" style="overflow:visible;"';}
if(typeof document.body.style.maxHeight==="undefined")
{var openIframe="<iframe width='100%' height='100%' name='iframe_parent' id='iframe_parent' frameborder='0' "+scrol+"></iframe>";myInnerHTML('dialogBody',openIframe);$('iframe_parent').src=_sUrl;}
else
{var openIframe="<iframe width='100%' height='100%' name='iframe_parent' id='iframe_parent' src='"+_sUrl+"' frameborder='0' "+scrol+"></iframe>";myInnerHTML('dialogBody',openIframe);}}
this.show=function()
{this.middle('dialogBox');if($('dialogIframBG'))
{$('dialogIframBG').style.top=$('dialogBox').style.top;$('dialogIframBG').style.left=$('dialogBox').style.left;$('dialogIframBG').style.width=$('dialogBox').offsetWidth+"px";$('dialogIframBG').style.height=$('dialogBox').offsetHeight+"px";$('dialogIframBG').style.display='block';}
if(!is_opera){this.shadow();}}
this.reset=function()
{this.close();}
this.close=function()
{if(window.removeEventListener)
{window.removeEventListener('resize',this.event_b,false);window.removeEventListener('scroll',this.event_b,false);}
else if(window.detachEvent)
{try{window.detachEvent('onresize',this.event_b);window.detachEvent('onscroll',this.event_b);}catch(e){}}
if($('dialogIframBG')){$('dialogIframBG').style.display='none';}
$('dialogBox').style.display='none';$('dialogBoxBG').style.display='none';$('dialogBoxShadow').style.display="none";if(typeof(parent.onDialogClose)=="function")
{parent.onDialogClose($('dialogBoxTitle').innerHTML);}}
this.set_title=function(title)
{if($("dialogBoxTitle"))
{$("dialogBoxTitle").innerHTML=title;}
return this;}
this.shadow=function()
{this.event_b_show();if(window.attachEvent)
{window.attachEvent('onresize',this.event_b);window.attachEvent('onscroll',this.event_b);}
else
{window.addEventListener('resize',this.event_b,false);window.addEventListener('scroll',this.event_b,false);}}
this.event_b=function()
{var oShadow=$('dialogBoxShadow');oShadow['style']['width']=document.documentElement.width+"px";oShadow['style']['height']=document.documentElement.height+"px";if(oShadow.style.display!="none")
{if(this.event_b_show)
{this.event_b_show();}}}
this.event_b_show=function()
{var oShadow=$('dialogBoxShadow');oShadow['style']['position']="absolute";oShadow['style']['display']="";oShadow['style']['opacity']="0.2";oShadow['style']['filter']="alpha(opacity=20)";oShadow['style']['background']="#000";var sClientWidth=parent?parent.document.body.offsetWidth:document.body.offsetWidth;var sClientHeight=parent?parent.document.body.offsetHeight:document.body.offsetHeight;var sScrollTop=parent?(parent.document.body.scrollTop+parent.document.documentElement.scrollTop):(document.body.scrollTop+document.documentElement.scrollTop);oShadow['style']['top']='0px';oShadow['style']['left']='0px';oShadow['style']['width']=sClientWidth+"px";oShadow['style']['height']=document.documentElement.height+"px";}
this.middle=function(_sId)
{$(_sId)['style']['display']='';$(_sId)['style']['position']="absolute";var sClientWidth=parent.document.body.clientWidth;var sClientHeight=parent.document.body.clientHeight;var sScrollTop=parent.document.body.scrollTop+parent.document.documentElement.scrollTop;var sleft=(sClientWidth-$(_sId).offsetWidth)/2;var iTop=sScrollTop+80;var sTop=iTop>0?iTop:0;$(_sId)['style']['left']=sleft+"px";$(_sId)['style']['top']=sTop+"px";}
this.resize=function(v_w,v_h)
{var dialogBody=$("dialogBody");var dialogBox=$("dialogBox");if(!dialogBody||!dialogBox)
{return;}
if($("dialogBoxTitle"))
{dialogBody.setStyle({height:(v_h-28)+"px"});}
else
{dialogBody.setStyle({height:(v_h-2)+"px"});}
dialogBox.setStyle({width:v_w+"px"}).down(".ts460").setStyle({width:v_w+"px"}).down().setStyle({width:v_w+"px"}).up().next(1).setStyle({top:(v_h+8)+"px",width:(v_w)+"px"}).down().setStyle({width:(v_w)+"px"}).up().previous().setStyle({height:(v_h)+"px"}).down().down("tr").setStyle({height:(v_h)+"px"}).down("td",1).setStyle({width:(v_w-14)+"px"});return this;}}
function openWindow(_sUrl,_sWidth,_sHeight,_sTitle)
{var oEdit=new dialog(_sWidth,_sHeight,_sTitle);oEdit.init();if(typeof arguments[4]!="undefined")
{oEdit.open(_sUrl,arguments[4]);}
else
{oEdit.open(_sUrl);}}
function openAlert(_sWord,_sButton,_sWidth,_sHeight,_sTitle,_sAction,_sButton2,_sAction2)
{return _openAlert(_sWord,_sButton,_sWidth,_sHeight,_sTitle,_sAction,"",_sButton2,_sAction2);}
function openAlertBlue(_sWord,_sButton,_sWidth,_sHeight,_sTitle,_sAction)
{var excss='.rbs1{border:1px solid #d7e7fe; float:left;}\n'+'.rb1-12,.rb2-12{height:23px; color:#fff; font-size:12px; background:#355582; padding:3px 5px; border-left:1px solid #fff; border-top:1px solid #fff; border-right:1px solid #6a6a6a; border-bottom:1px solid #6a6a6a; cursor:pointer;}\n'+'.rb2-12{background:#355582;}\n';return _openAlert(_sWord,_sButton,_sWidth,_sHeight,_sTitle,_sAction,excss);}
function _openAlert(_sWord,_sButton,_sWidth,_sHeight,_sTitle,_sAction,_excss,_sButton2,_sAction2)
{var oEdit=new dialog(_sWidth,_sHeight,_sTitle);oEdit.init();oEdit.show();var framename="iframe_parent_"+g_iframeno++;g_dialog_sWord=_sWord;g_dialog_sButton=_sButton;g_dialog_sAction=_sAction;g_dialog_excss=_excss;g_dialog_sButton2=_sButton2;g_dialog_sAction2=_sAction2;var openIframe="<iframe width='100%' height='100%' name='"+framename+"' id='"+framename+"' src='http://"+Kx.Lib.Request.getFullHost()+"/interface/diablank.php' frameborder='0' scrolling='no' onload=\"javascript:_openAlert_write('"+framename+"')\"></iframe>";myInnerHTML('dialogBody',openIframe);}
function _openAlert_write(framename)
{var _sWord=g_dialog_sWord;var _sButton=g_dialog_sButton;var _sAction=g_dialog_sAction;var _sButton2=g_dialog_sButton2;var _sAction2=g_dialog_sAction2;var _excss=g_dialog_excss;var iframe=window.frames[framename];if(_excss&&_excss.length)
{try
{iframe.document.getElementsByTagName('head').item(0).innerHTML+='<style>'+_excss+'</style>';}
catch(exc)
{var ss=iframe.document.createElement('style');ss.type="text/css";ss.styleSheet.cssText=_excss;iframe.document.getElementsByTagName('head').item(0).appendChild(ss);}}
if(_sAction==undefined)
{_sAction="new parent.dialog().reset();";}
iframe.document.body.innerHTML=alertHtml(_sWord,_sButton,_sAction,_sButton2,_sAction2);}
function alertHtml(_sWord,_sButton,_sAction,_sButton2,_sAction2)
{var html="";var html='<div class="ts4">\
       <div class="ts45" style="border-top:none;padding-top:0;">\
         '+_sWord+'\
        <div class="c"></div>\
       </div>\
       <div class="ts42 r">\
        <div class="rbs1"><input type="button" style="width:68px;" value="'+_sButton+'" title="'+_sButton+'" class="rb1-12" onmouseover="this.className=\'rb2-12\';" onmouseout="this.className=\'rb1-12\';" onclick="javascript:'+_sAction+'" /></div>';if(typeof(_sButton2)!="undefined")
{if(typeof(_sAction2)=="undefined")
{_sAction2="new parent.dialog().reset();";}
html+='<div class="flw5">&nbsp;</div><div class="rbs1"><input type="button" style="width:68px;" value="'+_sButton2+'" title="'+_sButton2+'" class="rb1-12" onmouseover="this.className=\'rb2-12\';" onmouseout="this.className=\'rb1-12\';" onclick="javascript:'+_sAction2+'" /></div>';}
html+='<div class="c"></div></div>';html+='</div>';return html;}
window.openKxRestWindow=openWindow;window._closeKxRestDialog=_closeDialog;})();