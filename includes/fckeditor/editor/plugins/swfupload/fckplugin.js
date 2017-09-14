 //注册

FCKCommands.RegisterCommand('swfupload', new FCKDialogCommand('swfupload', FCKLang.swfuploadDlgTitle, FCKPlugins.Items['swfupload'].Path + "swfupload.php", 600, 400));

 //定义工具栏

var oSwfuploadItem = new FCKToolbarButton('swfupload', FCKLang.swfupload);

oSwfuploadItem.IconPath = FCKPlugins.Items['swfupload'].Path + 'images/image_upload.gif';

 //注册

 FCKToolbarItems.RegisterItem('swfupload', oSwfuploadItem);


