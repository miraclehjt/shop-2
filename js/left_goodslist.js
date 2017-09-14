var old = new Array();
var buyercmt;
function show_goodspic(id,type)
{
  if(old[type]!=null)
  {
	  document.getElementById(type+"b"+old[type]).style.display='none';
	  document.getElementById(type+"s"+old[type]).style.display='block';
  }
      document.getElementById(type+"s"+id).style.display='none';
	  document.getElementById(type+"b"+id).style.display='block';
	  old[type] = id;
}
function stopError() {

            return true;

          }

          window.onerror = stopError;

function MakeFlashString(source,id,width,height,wmode, otherParam)
{	
	return "<embed src="+source+" quality=high wmode="+wmode+" type=\"application/x-shockwave-flash\" pluginspage=\"https://www.macromedia.com/shockwave/download/index.cgi?p1_prod_version=shockwaveflash\" width="+width+" height="+height+"></embed>";
}

function MakeObjectString(classid, codebase, name, id, width,height, param)
{
	return "<object classid="+classid+" codebase="+codebase+" name="+name+" width="+width+" height="+height+" id="+id+"><param name=wmode value="+wmode+" />"+param+"</object>";
}
function chgActive(id)
{
	document.write(id.text);
}
// innerHTML Type
function SetInnerHTML(target, code)
{ 
	target.innerHTML = code; 
}

// Direct Write Type
function DocumentWrite(src)
{
	document.write(src);
}







