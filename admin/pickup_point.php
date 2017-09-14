<?php

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
$exc   = new exchange($ecs->table("pickup_point"), $db, 'id', 'shop_name');
/*------------------------------------------------------ */
//-- 自提点列表
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'list')
{
    /* 取得过滤条件 */
    $filter = array();
    $smarty->assign('ur_here',      $_LANG['17_pickup_point_manage']);
    $smarty->assign('action_link',  array('text' => $_LANG['pickup_point_add'], 'href' => 'pickup_point.php?act=add'));
    $smarty->assign('full_page',    1);
    $smarty->assign('filter',       $filter);
	
	$sql = 'select * from ' . $ecs->table('region') . ' where parent_id=' . $GLOBALS['_CFG']['shop_country'];
	$province_list = $db->getAll($sql);
	$smarty->assign('province_list',       $province_list);
	
    $pickup_point = get_pickup_point_list();

    $smarty->assign('pickup_point_list',    $pickup_point['arr']);
    $smarty->assign('filter',          $pickup_point['filter']);
    $smarty->assign('record_count',    $pickup_point['record_count']);
    $smarty->assign('page_count',      $pickup_point['page_count']);

    $sort_flag  = sort_flag($pickup_point['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    assign_query_info();
    $smarty->display('pickup_point_list.htm');
}

/*------------------------------------------------------ */
//-- 翻页，排序
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'query')
{
    $pickup_point = get_pickup_point_list();
	
    $smarty->assign('pickup_point_list',    $pickup_point['arr']);
    $smarty->assign('filter',          $pickup_point['filter']);
    $smarty->assign('record_count',    $pickup_point['record_count']);
    $smarty->assign('page_count',      $pickup_point['page_count']);

    $sort_flag  = sort_flag($pickup_point['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    make_json_result($smarty->fetch('pickup_point_list.htm'), '',
        array('filter' => $pickup_point['filter'], 'page_count' => $pickup_point['page_count']));
}

/*------------------------------------------------------ */
//-- 添加自提点
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'add')
{
    /*初始化*/
    $pickup_point = array();
	$sql = 'select * from ' . $GLOBALS['ecs']->table('region') . ' where parent_id=' . $GLOBALS['_CFG']['shop_country'];
	$province_list = $GLOBALS['db']->getAll($sql);
	
	$smarty->assign('province_list',     $province_list);
    $smarty->assign('pickup_point',     $pickup_point);
    $smarty->assign('ur_here',     $_LANG['pickup_point_add']);
    $smarty->assign('action_link', array('text' => $_LANG['pickup_point_list'], 'href' => 'pickup_point.php?act=list'));
    $smarty->assign('form_action', 'insert');

    assign_query_info();
    $smarty->display('pickup_point_info.htm');
}

/*------------------------------------------------------ */
//-- 添加自提点
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'insert')
{
    /*插入数据*/
    $add_time = gmtime();
    if (empty($_POST['cat_id']))
    {
        $_POST['cat_id'] = 0;
    }
    $sql = "INSERT INTO ".$ecs->table('pickup_point')."(shop_name, address, contact, phone, province_id, ".
                "city_id, district_id) ".
            "VALUES ('$_POST[shop_name]', '$_POST[address]', '$_POST[contact]', '$_POST[phone]', ".
                "'$_POST[province]', '$_POST[city]', '$_POST[district]')";
    $db->query($sql);

    $link[0]['text'] = $_LANG['continue_add'];
    $link[0]['href'] = 'pickup_point.php?act=add';

    $link[1]['text'] = $_LANG['back_list'];
    $link[1]['href'] = 'pickup_point.php?act=list';

    admin_log($_POST['shop_name'],'add','pickup_point');

    clear_cache_files(); // 清除相关的缓存文件

    sys_msg($_LANG['pickup_point_add_succeed'],0, $link);
}

/*------------------------------------------------------ */
//-- 编辑自提点
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'edit')
{
    /* 取自提点数据 */
    $sql = "SELECT * FROM " .$ecs->table('pickup_point'). " WHERE id='$_REQUEST[id]'";
    $pickup_point = $db->GetRow($sql);
	
	$sql = 'select * from ' . $ecs->table('region') . ' where parent_id=' . $GLOBALS['_CFG']['shop_country'];
	$province_list = $db->getAll($sql);
	$sql = 'select * from ' . $ecs->table('region') . ' where parent_id=' . $pickup_point['province_id'];
	$city_list = $db->getAll($sql);
	$sql = 'select * from ' . $ecs->table('region') . ' where parent_id=' . $pickup_point['city_id'];
	$district_list = $db->getAll($sql);
	$smarty->assign('province_list',     $province_list);
	$smarty->assign('city_list',     $city_list);
	$smarty->assign('district_list',     $district_list);
	
    $smarty->assign('pickup_point',     $pickup_point);
    $smarty->assign('ur_here',     $_LANG['pickup_point_edit']);
    $smarty->assign('action_link', array('text' => $_LANG['pickup_point_list'], 'href' => 'pickup_point.php?act=list&' . list_link_postfix()));
    $smarty->assign('form_action', 'update');

    assign_query_info();
    $smarty->display('pickup_point_info.htm');
}

if ($_REQUEST['act'] =='update')
{
    if ($exc->edit("shop_name='$_POST[shop_name]', address='$_POST[address]', contact='$_POST[contact]', phone='$_POST[phone]', province_id='$_POST[province]', city_id='$_POST[city]', district_id ='$_POST[district]'", $_POST['id']))
    {
        $link[0]['text'] = $_LANG['back_list'];
        $link[0]['href'] = 'pickup_point.php?act=list&' . list_link_postfix();

        $note = sprintf($_LANG['pickup_point_edit_succeed'], stripslashes($_POST['shop_name']));
        admin_log($_POST['shop_name'], 'edit', 'pickup_point');

        clear_cache_files();

        sys_msg($note, 0, $link);
    }
    else
    {
        die($db->error());
    }
}

/*------------------------------------------------------ */
//-- 编辑自提点店名
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'edit_shop_name')
{
    $id    = intval($_POST['id']);
    $shop_name = json_str_iconv(trim($_POST['val']));

	if ($exc->edit("shop_name = '$shop_name'", $id))
	{
		clear_cache_files();
		admin_log($shop_name, 'edit', 'pickup_point');
		make_json_result(stripslashes($shop_name));
	}
	else
	{
		make_json_error($db->error());
	}
}

/*------------------------------------------------------ */
//-- 编辑自提点地址
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'edit_address')
{
    $id    = intval($_POST['id']);
    $address = json_str_iconv(trim($_POST['val']));

	if ($exc->edit("address = '$address'", $id))
	{
		clear_cache_files();
		admin_log($address, 'edit', 'pickup_point');
		make_json_result(stripslashes($address));
	}
	else
	{
		make_json_error($db->error());
	}
}

/*------------------------------------------------------ */
//-- 编辑自提点联系人
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'edit_contact')
{
    $id    = intval($_POST['id']);
    $contact = json_str_iconv(trim($_POST['val']));

	if ($exc->edit("contact = '$contact'", $id))
	{
		clear_cache_files();
		admin_log($contact, 'edit', 'pickup_point');
		make_json_result(stripslashes($contact));
	}
	else
	{
		make_json_error($db->error());
	}
}

/*------------------------------------------------------ */
//-- 编辑自提点联系方式
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'edit_phone')
{
    $id    = intval($_POST['id']);
    $phone = json_str_iconv(trim($_POST['val']));

	if ($exc->edit("phone = '$phone'", $id))
	{
		clear_cache_files();
		admin_log($phone, 'edit', 'pickup_point');
		make_json_result(stripslashes($phone));
	}
	else
	{
		make_json_error($db->error());
	}
}

/*------------------------------------------------------ */
//-- 删除自提点
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'remove')
{
    $id = intval($_GET['id']);

    $name = $exc->get_name($id);
    if ($exc->drop($id))
    {
        admin_log(addslashes($name),'remove','pickup_point');
        clear_cache_files();
    }

    $url = 'pickup_point.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);

    ecs_header("Location: $url\n");
    exit;
}

/*------------------------------------------------------ */
//-- 批量操作
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'batch')
{
    /* 批量删除 */
    if (isset($_POST['type']))
    {
        if ($_POST['type'] == 'button_remove')
        {
            if (!isset($_POST['checkboxes']) || !is_array($_POST['checkboxes']))
            {
                sys_msg($_LANG['no_select_pickup_point'], 1);
            }

            foreach ($_POST['checkboxes'] AS $key => $id)
            {
                if ($exc->drop($id))
                {
                    $name = $exc->get_name($id);
                    admin_log(addslashes($name),'remove','pickup_point');
                }
            }

        }
   }

    /* 清除缓存 */
    clear_cache_files();
    $lnk[] = array('text' => $_LANG['back_list'], 'href' => 'pickup_point.php?act=list');
    sys_msg($_LANG['batch_handle_ok'], 0, $lnk);
}

if ($_REQUEST['act'] == 'batch_add')
{
    /* 取得可选语言 */
    $dir = opendir('../languages');
    $lang_list = array(
        'UTF8'      => $_LANG['charset']['utf8'],
        'GB2312'    => $_LANG['charset']['zh_cn'],
        'BIG5'      => $_LANG['charset']['zh_tw'],
    );
    $download_list = array();
    while (@$file = readdir($dir))
    {
        if ($file != '.' && $file != '..' && $file != ".svn" && $file != "_svn" && is_dir('../languages/' .$file) == true)
        {
            $download_list[$file] = sprintf($_LANG['download_file'], isset($_LANG['charset'][$file]) ? $_LANG['charset'][$file] : $file);
        }
    }
    @closedir($dir);
    $smarty->assign('lang_list',     $lang_list);
    $smarty->assign('download_list', $download_list);

    /* 参数赋值 */
    $ur_here = $_LANG['pickup_point_add'];
    $smarty->assign('ur_here', $ur_here);

    /* 显示模板 */
    assign_query_info();
    $smarty->display('pickup_point_batch_add.htm');
}

/*------------------------------------------------------ */
//-- 下载文件
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'download')
{
    // 文件标签
    // Header("Content-type: application/octet-stream");
    header("Content-type: application/vnd.ms-excel; charset=utf-8");
    Header("Content-Disposition: attachment; filename=pickup_point_list.csv");

    // 下载
    if ($_GET['charset'] != $_CFG['lang'])
    {
        $lang_file = '../languages/' . $_GET['charset'] . '/admin/pickup_point.php';
        if (file_exists($lang_file))
        {
            unset($_LANG['upload_pickup_point']);
            require($lang_file);
        }
    }
    if (isset($_LANG['upload_pickup_point']))
    {
        /* 创建字符集转换对象 */
        if ($_GET['charset'] == 'zh_cn' || $_GET['charset'] == 'zh_tw')
        {
            $to_charset = $_GET['charset'] == 'zh_cn' ? 'GB2312' : 'BIG5';
            echo ecs_iconv(EC_CHARSET, $to_charset, join(',', $_LANG['upload_pickup_point']));
        }
        else
        {
            echo join(',', $_LANG['upload_pickup_point']);
        }
    }
    else
    {
        echo 'error: $_LANG[upload_pickup_point] not exists';
    }
}

elseif ($_REQUEST['act'] == 'upload')
{
    /* 将文件按行读入数组，逐行进行解析 */
    $line_number = 0;
    $arr = array();
    $pickup_point_list = array();
    $field_list = array_keys($_LANG['upload_pickup_point']); // 字段列表
    $data = file($_FILES['file']['tmp_name']);

        foreach ($data AS $line)
        {
            // 跳过第一行
            if ($line_number == 0)
            {
                $line_number++;
                continue;
            }

            // 转换编码
            if (($_POST['charset'] != 'UTF8') && (strpos(strtolower(EC_CHARSET), 'utf') === 0))
            {
                $line = ecs_iconv($_POST['charset'], 'UTF8', $line);
            }

            // 初始化
            $arr    = array();
            $buff   = '';
            $quote  = 0;
            $len    = strlen($line);
            for ($i = 0; $i < $len; $i++)
            {
                $char = $line[$i];

                if ('\\' == $char)
                {
                    $i++;
                    $char = $line[$i];

                    switch ($char)
                    {
                        case '"':
                            $buff .= '"';
                            break;
                        case '\'':
                            $buff .= '\'';
                            break;
                        case ',';
                            $buff .= ',';
                            break;
                        default:
                            $buff .= '\\' . $char;
                            break;
                    }
                }
                elseif ('"' == $char)
                {
                    if (0 == $quote)
                    {
                        $quote++;
                    }
                    else
                    {
                        $quote = 0;
                    }
                }
                elseif (',' == $char)
                {
                    if (0 == $quote)
                    {
                        if (!isset($field_list[count($arr)]))
                        {
                            continue;
                        }
                        $field_name = $field_list[count($arr)];
                        $arr[$field_name] = trim($buff);
                        $buff = '';
                        $quote = 0;
                    }
                    else
                    {
                        $buff .= $char;
                    }
                }
                else
                {
                    $buff .= $char;
                }

                if ($i == $len - 1)
                {
                    if (!isset($field_list[count($arr)]))
                    {
                        continue;
                    }
                    $field_name = $field_list[count($arr)];
                    $arr[$field_name] = trim($buff);
                }
            }
            $pickup_point_list[] = $arr;
        }

    $smarty->assign('pickup_point_list', $pickup_point_list);

    // 字段名称列表
    $smarty->assign('title_list', $_LANG['upload_pickup_point']);

    // 显示的字段列表
    $smarty->assign('field_show', array('shop_name' => true, 'address' => true, 'contact' => true, 'phone' => true, 'province' => true, 'city' => true, 'district' => true));

    /* 参数赋值 */
    $smarty->assign('ur_here', $_LANG['pickup_point_upload_confirm']);

    /* 显示模板 */
    assign_query_info();
    $smarty->display('pickup_point_upload_confirm.htm');

}

elseif ($_REQUEST['act'] == 'batch_insert')
{
	if (isset($_POST['checked']))
    {
        /* 字段默认值 */
        $default_value = array(
            'shop_name'      => '',
            'address'  => '',
            'contact'  => '',
            'phone'  => '',
            'province_id'    => 0,
            'city_id'   => 0,
            'district_id'       => 0
        );


        /* 字段列表 */
        $field_list = array_keys($_LANG['upload_pickup_point']);

        /* 获取商品good id */
        $max_id = $db->getOne("SELECT MAX(id) + 1 FROM ".$ecs->table('pickup_point'));

        /* 循环插入商品数据 */
        foreach ($_POST['checked'] AS $key => $value)
        {
            foreach ($field_list AS $field)
            {
				// 转换编码
				$field_value = isset($_POST[$field][$value]) ? $_POST[$field][$value] : '';
				if(in_array($field, array('shop_name', 'address', 'contact', 'phone')))
				{
					// 如果字段值为空，且有默认值，取默认值
					$field_arr[$field] = !isset($field_value) && isset($default_value[$field]) ? $default_value[$field] : $field_value;
				}
            }
			$city_info = get_city_info($_POST['province'][$value], $_POST['city'][$value], $_POST['district'][$value]);
			
			$field_arr['province_id'] = $city_info['province_id'] > 0 ? $city_info['province_id'] : 0;
			$field_arr['city_id'] = $city_info['city_id'] > 0 ? $city_info['city_id'] : 0;
			$field_arr['district_id'] = $city_info['district_id'] > 0 ? $city_info['district_id'] : 0;
			

            $db->autoExecute($ecs->table('pickup_point'), $field_arr, 'INSERT');

            $max_id = $db->insert_id() + 1;

        }
    }
    // 记录日志
    admin_log('', 'batch_upload', 'pickup_point');

    /* 显示提示信息，返回商品列表 */
    $link[] = array('href' => 'pickup_point.php?act=list', 'text' => $_LANG['pickup_point_list']);
    sys_msg($_LANG['batch_upload_ok'], 0, $link);

}

/* 获得自提点列表 */
function get_pickup_point_list()
{
    $result = get_filter();
    if ($result === false)
    {
        $filter = array();
        $filter['keyword']    = empty($_REQUEST['keyword']) ? '' : trim($_REQUEST['keyword']);
        if (isset($_REQUEST['is_ajax']) && $_REQUEST['is_ajax'] == 1)
        {
            $filter['keyword'] = json_str_iconv($filter['keyword']);
        }
        $filter['sort_by']    = empty($_REQUEST['sort_by']) ? 'id' : trim($_REQUEST['sort_by']);
        $filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);
		$filter['province']   = empty($_REQUEST['province']) ? '' : trim($_REQUEST['province']);
		$filter['city']   = empty($_REQUEST['city']) ? '' : trim($_REQUEST['city']);
		$filter['district']   = empty($_REQUEST['district']) ? '' : trim($_REQUEST['district']);
        $where = '';
        if (!empty($filter['keyword']))
        {
            $where = " AND (shop_name LIKE '%" . mysql_like_quote($filter['keyword']) . "%' OR contact LIKE '%" .
						 mysql_like_quote($filter['keyword']) . "%')";
        }
        if (!empty($filter['province']))
        {
            $where .= " AND province_id=" . $filter['province'];
        }
		if (!empty($filter['city']))
        {
            $where .= " AND city_id=" . $filter['city'];
        }
		if (!empty($filter['district']))
        {
            $where .= " AND district_id=" . $filter['district'];
        }

        /* 自提点总数 */
        $sql = 'SELECT COUNT(*) FROM ' . $GLOBALS['ecs']->table('pickup_point') .
               'WHERE supplier_id=0 ' .$where;
        $filter['record_count'] = $GLOBALS['db']->getOne($sql);

        $filter = page_and_size($filter);

        /* 获取自提点数据 */
        $sql = 'SELECT * '.
               'FROM ' .$GLOBALS['ecs']->table('pickup_point') .
               'WHERE supplier_id=0' .$where. ' ORDER by '.$filter['sort_by'].' '.$filter['sort_order'];

        $filter['keyword'] = stripslashes($filter['keyword']);
        set_filter($filter, $sql);
    }
    else
    {
        $sql    = $result['sql'];
        $filter = $result['filter'];
    }
    $arr = array();
    $res = $GLOBALS['db']->selectLimit($sql, $filter['page_size'], $filter['start']);

    while ($rows = $GLOBALS['db']->fetchRow($res))
    {
		$rows['province'] = get_city_name($rows['province_id']);
		$rows['city'] = get_city_name($rows['city_id']);
		$rows['district'] = get_city_name($rows['district_id']);
        $arr[] = $rows;
    }
    return array('arr' => $arr, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);
}

function get_city_name($city_id)
{
	$sql = 'select region_name from ' . $GLOBALS['ecs']->table('region') . ' where region_id=' . $city_id;
	return $GLOBALS['db']->getOne($sql);
}
?>