<?php 
//   第三方登录接口，安装与卸载
/**
**/

define('IN_ECS' ,true);
include_once(dirname(__FILE__) . '/includes/init.php');
define('WEBSITE' , true);


if($_REQUEST['act'] == 'list')
{
	
	
	$web = getWebsiteList();
	$name = '';
	foreach($web as $key=>$val)
	{
		$name .= $val['name'] .',';
	}
	
	$smarty->assign('warning' , $_LANG['warning']);
	$smarty->assign('website_name' , $name); // 取回已有插件
	$smarty->assign('action_link' , array('href' => 'website.php?act=init' , 'text' => $_LANG['init']));
	$smarty->assign('ur_here' , $_LANG['ur_here']);
	$smarty->assign('website' , $web);
	assign_query_info();
	$smarty->display('website.htm');
}
elseif($_REQUEST['act'] == 'batch')
{
	$type = $_REQUEST['type'];
	
	// 生成的类
	$name = $_REQUEST['checkboxes'];
	if(empty($name) || !is_array($name))
	{
		$link[0] = array('href' => 'website.php?act=list' , 'text' => $_LANG['webstte_list']);
		sys_msg($_LANG['batch_yes'] , 0 ,  $link);
	}
	
	switch($type)
	{
		// 生成调用代码
		case 'create':
			$web = getWebsiteList();
			$show_name = getInt('is_show_name');
			$show_title = getInt('is_show_title');
			$show_help = getInt('is_show_help');
			$is_open = getInt('is_open');
			
			$url = $ecs->url().'ss';
			$url = dirname($url).'/';
			
			
			foreach($web as $key=>$val)
			{
				$web[$val['type']] = $val;
			}
			
			$name = array();
			$className = array();
			$t = array();
			$help = array();
			foreach($_REQUEST['checkboxes'] as $val)
			{
				if(!empty($web[$val]))
				{
					if($web[$val]['install'] == 1)
					{
						if( $show_name )
						{
							$name[] = $web[$val]['name'];
						}
						
						if( $show_help )
						{
							$help[] = $web[$val]['name'] . $_LANG['login'];
						}
						
						$className[] = $web[$val]['className'];
						$t[] = $web[$val]['type'];
					}
				}
			}
			
			$date = 'JnToo'.date('YmdHis');
			
			
			$contents = 'new website( "'.$url.'" , "'.join('|' , $t).'" , "'.join( '|' , $className).'" , '.
						($show_name ? '"'.join('|' , $name).'"' : 'false').' , '.($show_title ? '"'.$_LANG['qita'].'"' : 'false').','.
						($show_help ? '"'.join('|' , $help).'"' : 'false').' , '.($is_open ? 'true' : 'false').' ,"{$back_act}", "'.$date.'" )';
			
			$smarty->assign('evaljavascript' , $contents);
			$smarty->assign('scriptsrc' , $url.'js/website.js');
			assign_query_info();
			
			$smarty->assign('action_link' ,  array('href' => 'website.php?act=list' , 'text' => $_LANG['webstte_list']));
			$smarty->display('website_view.htm');
			exit();
			break;
		case 'uninstall':
			break;
	}
	$link[0] = array('href' => 'website.php?act=list' , 'text' => $_LANG['webstte_list']);
	sys_msg($_LANG['batch_yes'] , 0 ,  $link);
}
elseif($_REQUEST['act'] == 'install' || $_REQUEST['act'] == 'view')
{
	$view = $_REQUEST['act'] == 'view';
	$type = getChar('type');
	if(!$type) header('Location: website.php?act=list');
	$filepath = ROOT_PATH . 'includes/website/';
	
	if(file_exists($filepath .$type.'.php'))
	{
		include_once($filepath .$type.'.php');
		$info = $web[$i];
		
	}
	
	if($view)
	{
		if(file_exists($filepath .'config/'.$type.'_config.php'))
		{
			include_once($filepath .'config/'.$type.'_config.php');
			
			if(!empty($config))
			{
				$smarty->assign('config' , $config);
			}
			
			//$smarty->assign('app_key' , APP_KEY);
			//$smarty->assign('app_secret',APP_SECRET);
			$sql = 'SELECT rank_id,rank_name FROM '.$ecs->table('user_rank').' WHERE rank_id=\''.RANK_ID.'\'';
			$smarty->Assign('rank' , $db->getRow($sql));
		}
	}
	
	$smarty->assign('lang' ,$_LANG);
	$smarty->assign('info' , $info);
	$smarty->assign('ur_here' , $view ? $_LANG['ur_view'] : $_LANG['ur_install']);
	$smarty->assign('action_link' , array('href'=>'website.php?act=list' , 'text' => $_LANG['webstte_list']));
	$smarty->assign('type' , $type);
	$smarty->assign('act' , $view ? 'update_website' : 'query_install');
	assign_query_info();
	$smarty->display('website_install.htm');
}

elseif($_REQUEST['act']  == 'query_install' || $_REQUEST['act'] == 'update_website')
{
	
	$type = getChar('type');
	
	//$app_key = getChar('app_key');
	//$app_secret = getChar('app_secret');
	
	$rank_name = getChar('rank_name');
	$rank_id  = getInt('rank_id');
	$query = $_REQUEST['act']  == 'query_install';
	$olb_rank_name = getChar('olb_rank_name');
	if($query || !$rank_id)
	{
		$sql = 'INSERT INTO '.$ecs->table('user_rank').'(`rank_name` , `discount` , `special_rank`,`show_price`) VALUES'.
				"('$rank_name' , '100' , '1','0')";
		$db->query($sql);
		$rank_id = $db->insert_id();
	}
	else
	{
		if($rank_name != $olb_rank_name && $rank_id)
		{
			$sql = 'UPDATE '.$ecs->table('user_rank').' SET `rank_name` = '."'$rank_name' WHERE `rank_id`='$rank_id'";
			$db->query($sql);
		}
	}
	
	$commnet = '<?php '.
			   "\r\n // 第三方插件登录信息---------------------\r\n".
			   "define('RANK_ID' , '$rank_id'); \r\n";
	
	foreach($_POST['jntoo'] as $key => $val)
	{
		$commnet .= "define('$key' , '$val'); \r\n";
		$commnet .= "\$config['$key'] = '$val'; \r\n";
	}
	
	
			   
	$commnet .=	'?>';
	$filename = ROOT_PATH . 'includes/website/config/'.$type.'_config.php';
	
	file_put_contents($filename , $commnet);
	$link[0] = array('href' => 'website.php?act=list' , 'text' => $_LANG['webstte_list']);
	assign_query_info();
	
	sys_msg(($query ? $_LANG['yes_install'] : $_LANG['yes_update']) , 0 ,  $link);
}
elseif($_REQUEST['act'] == 'uninstall')
{
	$type = getChar('type');
	$filepath = ROOT_PATH . 'includes/website/';
	$link[0] = array('href' => 'website.php?act=list' , 'text' => $_LANG['webstte_list']);
	if(file_exists($filepath .'config/'.$type.'_config.php'))
	{
		include_once($filepath .'config/'.$type.'_config.php');
		if(!defined(RANK_ID))
			$db->query('DELETE FROM '.$ecs->table('user_rank').' WHERE `rank_id`=\''.RANK_ID.'\'');
		@unlink($filepath .'config/'.$type.'_config.php');
		assign_query_info();
		sys_msg($_LANG['yes_uninstall'] , 0 , $link);
	}
	assign_query_info();
	sys_msg($_LANG['no_uninstall'] , 1 , $link);
}
elseif($_REQUEST['act'] == 'init')
{
	$fields = $db->getCol('DESC '.$ecs->table('users'));
	$init = true;
	foreach($fields as $val)
	{
		if($val == 'aite_id')
		{
			$init = false;
			break;
		}
	}
	
	$link[0] = array('href' => 'website.php?act=list' , 'text' => $_LANG['webstte_list']);
	if($init)
	{
		$sql = 'ALTER TABLE '.$ecs->table('users').' ADD `aite_id` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `user_id`';
		$db->query($sql);
	}
	assign_query_info();
	sys_msg($_LANG['yes_init'] , 0 , $link);
}


function getInt($name , $def = 0)
{
	return empty($_REQUEST[$name]) ? $def : intval($_REQUEST[$name]);
}

function getChar($name , $def = '')
{
	return empty($_REQUEST[$name]) ? $def : htmlspecialchars(trim($_REQUEST[$name]));
}

function getWebsiteList()
{
	$filepath = ROOT_PATH . 'includes/website/';
	$openfn = opendir($filepath);
	$name = '';
	$web = array();
	while($file = readdir($openfn))
	{
		if($file != '.' && $file != '..' && $file != 'jntoo.php' && $file != 'config' && $file != 'tb_callback.php' && $file != 'tb_index.php' && substr($file , strlen($file)-4) == '.php' && substr($file , 0 , 3) != 'cls')
		{
			include_once($filepath . $file);
			
			if(file_exists($filepath.'config/'.$web[$i]['type'].'_config.php')) // 检查是否已经安装
			{
				$web[$i]['install'] = 1;
			}
			else
			{
				$web[$i]['install'] = 0;
			}
			$web[$i]['path'] = $filepath.$file;
			$web[$i]['file'] = $file;
		}
	}
	closedir($openfn);
	return $web;
}
?>