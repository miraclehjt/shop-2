<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>文件上传</title>
<link href="default.css" rel="stylesheet" type="text/css" />
<style type="text/css">
	.swfupload {
		position: absolute;
		z-index: 1;
	}
</style>

<script type="text/javascript" src="js/swfupload.js"></script>
<script type="text/javascript" src="js/swfupload.queue.js"></script>
<script type="text/javascript" src="js/fileprogress.js"></script>
<script type="text/javascript" src="js/handlers.js"></script>
<script type="text/javascript">
var dialog = window.parent;
var oEditor = dialog.InnerDialogLoaded();
var FCKLang = oEditor.FCKLang;
var swfu;

SWFUpload.onload = function () {
	var settings = {
		flash_url : "js/swfupload.swf",
		flash9_url : "js/swfupload_fp9.swf",
		upload_url: "upload2012.php",
		file_size_limit : "100 MB",
		file_types : "*.jpg;*.gif",
		file_types_description : "jpg图片,gif图片",
		file_upload_limit : 100,
		file_queue_limit : 0,
		custom_settings : {
			progressTarget : "fsUploadProgress",
			cancelButtonId : "btnCancel"
		},
		debug: false,

		// Button Settings
		button_placeholder_id : "spanButtonPlaceholder",
		button_width: 61,
		button_height: 22,
		button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
		button_cursor: SWFUpload.CURSOR.HAND,

		// The event handler functions are defined in handlers.js
		swfupload_preload_handler : swfUploadPreLoad,
		swfupload_load_failed_handler : swfUploadLoadFailed,
		swfupload_loaded_handler : swfUploadLoaded,
		file_queued_handler : fileQueued,
		file_queue_error_handler : fileQueueError,
		file_dialog_complete_handler : fileDialogComplete,
		upload_start_handler : uploadStart,
		upload_progress_handler : uploadProgress,
		upload_error_handler : uploadError,
		upload_success_handler : uploadSuccess,
		upload_complete_handler : uploadComplete,
		queue_complete_handler : queueComplete	// Queue plugin event

	};

	swfu = new SWFUpload(settings);
}

</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<div id="content">
	<h2>图片上传</h2>
	<br>
	<form id="form1"   action="swfupload.php" method="post" enctype="multipart/form-data">
	  <div id="divSWFUploadUI">
			<div class="fieldset flash" id="fsUploadProgress" style="float:left;margin-top:10px;background:#fff;">
			<span class="legend">上传状态</span>
			</div>
			<br>
			<p id="divStatus">已上传0个文件</p>
			<p>
				<span id="spanButtonPlaceholder"></span>
				<input id="btnUpload" type="button" value="选择文件" style="width: 61px; height: 22px; font-size: 8pt;" />
				<input id="btnCancel" type="button" value="取消上传" disabled="disabled" style="margin-left: 2px; height: 22px; font-size: 8pt;" />
                <input id="hdFileName" name="hdFileName" type="hidden" value="" />
			</p>
			<br style="clear: both;" />
		</div>
		<noscript style="background-color: #FFFF66; border-top: solid 4px #FF9966; border-bottom: solid 4px #FF9966; margin: 10px 25px; padding: 10px 15px;">
			We're sorry.  SWFUpload could not load.  You must have JavaScript enabled to enjoy SWFUpload.
		</noscript>
		<div id="divLoadingContent" class="content" style="background-color: #FFFF66; border-top: solid 4px #FF9966; border-bottom: solid 4px #FF9966; margin: 10px 25px; padding: 10px 15px; display: none;">
			SWFUpload is loading. Please wait a moment...
		</div>
		<div id="divLongLoading" class="content" style="background-color: #FFFF66; border-top: solid 4px #FF9966; border-bottom: solid 4px #FF9966; margin: 10px 25px; padding: 10px 15px; display: none;">
			SWFUpload is taking a long time to load or the load has failed.  Please make sure that the Flash Plugin is enabled and that a working version of the Adobe Flash Player is installed.
		</div>
		<div id="divAlternateContent" class="content" style="background-color: #FFFF66; border-top: solid 4px #FF9966; border-bottom: solid 4px #FF9966; margin: 10px 25px; padding: 10px 15px; display: none;">
			We're sorry.  SWFUpload could not load.  You may need to install or upgrade Flash Player.
			Visit the <a href="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash">Adobe website</a> to get the Flash Player.
		</div>
	</form>
</div>

<script type="text/javascript">


    var dialog = window.parent;
    dialog.SetOkButton(true);

    function Ok() {
        SetEditorContents();
        return true;
    }
    function SetEditorContents() {
        var fileList = document.getElementById("hdFileName").value;
        fileList = fileList.substr(0, fileList.length - 1);
        var filePath ='';
        var strs = fileList.split(',');
        var html = "";
        for (i = 0; i < strs.length; i++) {

            html += "<img src=" + filePath + strs[i] + "\><br>";

        }

        var Editor = window.parent.InnerDialogLoaded().FCK;
        Editor.InsertHtml(html);
        // Editor.InsertHtml("<img src=\"http://mat1.qq.com/www/iskin/skin4/expotclogo.gif\" border=\"0\" width=\"100\" height=\"45\">");

    }

    function test() {
        var s = document.getElementById("hdFileName").value;
        alert(s)
    }
</script>
</body>
</html>
