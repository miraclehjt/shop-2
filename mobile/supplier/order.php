<?php
define('IN_ECS', true);
require(dirname(__FILE__) . '/includes/init.php');
require_once(ROOT_PATH.'includes/lib_order.php');
require_once(ROOT_PATH . 'includes/lib_supplier_common_wap.php');
require_once(ROOT_PATH.'languages/'.$_CFG['lang'].'/order.php');
require_once(ROOT_PATH.'languages/'.$_CFG['lang'].'/back.php');
$smarty->assign('lang',$_LANG);
$act = empty($_REQUEST['act'])?'list':trim($_REQUEST['act']);
//订单列表
if($act == 'list')
{
	$data = order_list();
	$filter = $data['filter'];
    $orders = $data['orders'];

    $smarty->assign('orders',$orders);
    $smarty->assign('filter',$data['filter']);
	
	$sel_status = $filter['composite_status'];
	assign_status_list($sel_status);
	
    _wap_assign_header_info('订单列表');
    _wap_assign_footer_order_info();
    _wap_display_page('order_list.htm');
}

//订单详情
elseif($act == 'info')
{
    /* 根据订单id或订单号查询订单信息 */
    if (isset($_REQUEST['order_id']))
    {
        $order_id = intval($_REQUEST['order_id']);
        $order = order_info($order_id);
    }
    elseif (isset($_REQUEST['order_sn']))
    {
        $order_sn = trim($_REQUEST['order_sn']);
        $order = order_info(0, $order_sn);
    }
    else
    {
        /* 如果参数不存在，退出 */
        sys_msg('参数错误！',1);
    }

    /* 如果订单不存在，退出 */
    if (empty($order))
    {
        sys_msg('订单不存在！',1);
    }

   

    /* 如果管理员属于某个办事处，检查该订单是否也属于这个办事处 */
    $sql = "SELECT agency_id FROM " . $ecs->table('admin_user') . " WHERE user_id = '$_SESSION[admin_id]'";
    $agency_id = $db->getOne($sql);
    if ($agency_id > 0)
    {
        if ($order['agency_id'] != $agency_id)
        {
            sys_msg($_LANG['priv_error'],1);
        }
    }

    /* 取得上一个、下一个订单号 */
    if (!empty($_COOKIE['ECSCP']['lastfilter']))
    {
        $filter = unserialize(urldecode($_COOKIE['ECSCP']['lastfilter']));
        if (!empty($filter['composite_status']))
        {
            $where = '';
            //综合状态
            switch($filter['composite_status'])
            {
                case CS_AWAIT_PAY :
                    $where .= order_query_sql('await_pay');
                    break;

                case CS_AWAIT_SHIP :
                    $where .= order_query_sql('await_ship');
                    break;

                case CS_FINISHED :
                    $where .= order_query_sql('finished');
                    break;

                default:
                    if ($filter['composite_status'] != -1)
                    {
                        $where .= " AND o.order_status = '$filter[composite_status]' ";
                    }
            }
        }
    }
    $sql = "SELECT MAX(order_id) FROM " . $ecs->table('order_info') . " as o WHERE supplier_id = '$order[supplier_id]' and order_id < '$order[order_id]'";
    if ($agency_id > 0)
    {
        $sql .= " AND agency_id = '$agency_id'";
    }
    if (!empty($where))
    {
        $sql .= $where;
    }
    $smarty->assign('prev_id', $db->getOne($sql));
    $sql = "SELECT MIN(order_id) FROM " . $ecs->table('order_info') . " as o WHERE supplier_id = '$order[supplier_id]' and order_id > '$order[order_id]'";

    if ($agency_id > 0)
    {
        $sql .= " AND agency_id = '$agency_id'";
    }
    if (!empty($where))
    {
        $sql .= $where;
    }
    $smarty->assign('next_id', $db->getOne($sql));

    /* 取得用户名 */
    if ($order['user_id'] > 0)
    {
        $user = user_info($order['user_id']);
        if (!empty($user))
        {
            $order['user_name'] = $user['user_name'];
        }
    }

    /* 取得所有办事处 */
    $sql = "SELECT agency_id, agency_name FROM " . $ecs->table('agency');
    $smarty->assign('agency_list', $db->getAll($sql));

    /* 取得区域名 */
    $sql = "SELECT CONCAT(IFNULL(c.region_name, ''), '  ', IFNULL(p.region_name, ''), " .
                "'  ', IFNULL(t.region_name, ''), '  ', IFNULL(d.region_name, '')) AS region " .
            "FROM " . $ecs->table('order_info') . " AS o " .
                "LEFT JOIN " . $ecs->table('region') . " AS c ON o.country = c.region_id " .
                "LEFT JOIN " . $ecs->table('region') . " AS p ON o.province = p.region_id " .
                "LEFT JOIN " . $ecs->table('region') . " AS t ON o.city = t.region_id " .
                "LEFT JOIN " . $ecs->table('region') . " AS d ON o.district = d.region_id " .
            "WHERE o.order_id = '$order[order_id]'";
    $order['region'] = $db->getOne($sql);
    //自提点地址
    if(!empty($order['is_pickup']) && !empty($order['pickup_point']))
    {
        $sql = 'SELECT pp.shop_name,pp.address,pp.phone,pp.contact,pr.region_name AS province_name,cr.region_name AS city_name,dr.region_name AS district_name FROM '.$ecs->table('pickup_point').' AS pp LEFT JOIN '.$ecs->table('region').' AS pr ON pr.region_id=pp.province_id LEFT JOIN '.$ecs->table('region').' AS cr ON cr.region_id=pp.city_id LEFT JOIN '.$ecs->table('region').' AS dr ON dr.region_id=pp.district_id WHERE pp.id='.$order['pickup_point'];
        $order['pickup_point_info'] = $db->getRow($sql);
    }
    //增值税发票地址信息
    if($order['inv_type'] == 'vat_invoice')
    {
        $sql = 'SELECT region_name FROM'.$ecs->table('region').' WHERE region_id='.$order['inv_consignee_country'];
        $order['inv_consignee_country_name'] = $db->getOne($sql);
        $sql = 'SELECT region_name FROM'.$ecs->table('region').' WHERE region_id='.$order['inv_consignee_province'];
        $order['inv_consignee_province_name'] = $db->getOne($sql);
        $sql = 'SELECT region_name FROM'.$ecs->table('region').' WHERE region_id='.$order['inv_consignee_city'];
        $order['inv_consignee_city_name'] = $db->getOne($sql);
        $sql = 'SELECT region_name FROM'.$ecs->table('region').' WHERE region_id='.$order['inv_consignee_district'];
        $order['inv_consignee_district_name'] = $db->getOne($sql);
    }
    /* 格式化金额 */
    if ($order['order_amount'] < 0)
    {
        $order['money_refund']          = abs($order['order_amount']);
        $order['formated_money_refund'] = price_format(abs($order['order_amount']));
    }

    /* 其他处理 */
    $order['order_time']    = local_date($_CFG['time_format'], $order['add_time']);
    $order['pay_time']      = $order['pay_time'] > 0 ?
        local_date($_CFG['time_format'], $order['pay_time']) : $_LANG['ps'][PS_UNPAYED];
    $order['shipping_time'] = $order['shipping_time'] > 0 ?
        local_date($_CFG['time_format'], $order['shipping_time']) : $_LANG['ss'][SS_UNSHIPPED];
    $order['status']        = $_LANG['os'][$order['order_status']] . ',' . $_LANG['ps'][$order['pay_status']] . ',' . $_LANG['ss'][$order['shipping_status']];
    $order['invoice_no']    = $order['shipping_status'] == SS_UNSHIPPED || $order['shipping_status'] == SS_PREPARING ? $_LANG['ss'][SS_UNSHIPPED] : $order['invoice_no'];

    /* 取得订单的来源 */
    if ($order['from_ad'] == 0)
    {
        $order['referer'] = empty($order['referer']) ? $_LANG['from_self_site'] : $order['referer'];
    }
    elseif ($order['from_ad'] == -1)
    {
        $order['referer'] = $_LANG['from_goods_js'] . ' ('.$_LANG['from'] . $order['referer'].')';
    }
    else
    {
        /* 查询广告的名称 */
         $ad_name = $db->getOne("SELECT ad_name FROM " .$ecs->table('ad'). " WHERE ad_id='$order[from_ad]'");
         $order['referer'] = $_LANG['from_ad_js'] . $ad_name . ' ('.$_LANG['from'] . $order['referer'].')';
    }

    /* 此订单的发货备注(此订单的最后一条操作记录) */
    $sql = "SELECT action_note FROM " . $ecs->table('order_action').
           " WHERE order_id = '$order[order_id]' AND shipping_status = 1 ORDER BY log_time DESC";
    $order['invoice_note'] = $db->getOne($sql);

    /* 取得订单商品总重量 */
    $weight_price = order_weight_price($order['order_id']);
    $order['total_weight'] = $weight_price['formated_weight'];

    /* 参数赋值：订单 */
    $smarty->assign('order', $order);

    /* 取得用户信息 */
    if ($order['user_id'] > 0)
    {
        /* 用户等级 */
        if ($user['user_rank'] > 0)
        {
            $where = " WHERE rank_id = '$user[user_rank]' ";
        }
        else
        {
            $where = " WHERE min_points <= " . intval($user['rank_points']) . " ORDER BY min_points DESC ";
        }
        $sql = "SELECT rank_name FROM " . $ecs->table('user_rank') . $where;
        $user['rank_name'] = $db->getOne($sql);

        // 用户红包数量
        $day    = getdate();
        $today  = local_mktime(23, 59, 59, $day['mon'], $day['mday'], $day['year']);
        $sql = "SELECT COUNT(*) " .
                "FROM " . $ecs->table('bonus_type') . " AS bt, " . $ecs->table('user_bonus') . " AS ub " .
                "WHERE bt.type_id = ub.bonus_type_id " .
                "AND ub.user_id = '$order[user_id]' " .
                "AND ub.order_id = 0 " .
                "AND bt.use_start_date <= '$today' " .
                "AND bt.use_end_date >= '$today'";
        $user['bonus_count'] = $db->getOne($sql);
        $smarty->assign('user', $user);

        // 地址信息
        $sql = "SELECT * FROM " . $ecs->table('user_address') . " WHERE user_id = '$order[user_id]'";
        $smarty->assign('address_list', $db->getAll($sql));
    }

    /* 取得订单商品及货品 */
    $goods_list = array();
    $goods_attr = array();
    $sql = "SELECT o.*, IF(o.product_id > 0, p.product_number, g.goods_number) AS storage, o.goods_attr, g.suppliers_id, IFNULL(b.brand_name, '') AS brand_name, p.product_sn
            FROM " . $ecs->table('order_goods') . " AS o
                LEFT JOIN " . $ecs->table('products') . " AS p
                    ON p.product_id = o.product_id
                LEFT JOIN " . $ecs->table('goods') . " AS g
                    ON o.goods_id = g.goods_id
                LEFT JOIN " . $ecs->table('brand') . " AS b
                    ON g.brand_id = b.brand_id
            WHERE o.order_id = '$order[order_id]'";
    $res = $db->query($sql);
    while ($row = $db->fetchRow($res))
    {
        /* 虚拟商品支持 */
        if ($row['is_real'] == 0)
        {
            /* 取得语言项 */
            $filename = ROOT_PATH . 'plugins/' . $row['extension_code'] . '/languages/common_' . $_CFG['lang'] . '.php';
            if (file_exists($filename))
            {
                include_once($filename);
                if (!empty($_LANG[$row['extension_code'].'_link']))
                {
                    $row['goods_name'] = $row['goods_name'] . sprintf($_LANG[$row['extension_code'].'_link'], $row['goods_id'], $order['order_sn']);
                }
            }
        }

        $row['formated_subtotal']       = price_format($row['goods_price'] * $row['goods_number']);
        $row['formated_goods_price']    = price_format($row['goods_price']);

        $goods_attr[] = explode(' ', trim($row['goods_attr'])); //将商品属性拆分为一个数组

        if ($row['extension_code'] == 'package_buy')
        {
            $row['storage'] = '';
            $row['brand_name'] = '';
            $row['package_goods_list'] = get_package_goods($row['goods_id']);
        }

        $goods_list[] = $row;
    }

    $attr = array();
    $arr  = array();
    foreach ($goods_attr AS $index => $array_val)
    {
        foreach ($array_val AS $value)
        {
            $arr = explode(':', $value);//以 : 号将属性拆开
            $attr[$index][] =  @array('name' => $arr[0], 'value' => $arr[1]);
        }
    }

    $smarty->assign('goods_attr', $attr);
    $smarty->assign('goods_list', $goods_list);

    /* 取得能执行的操作列表 */
    $operable_list = operable_list($order);
    $smarty->assign('operable_list', $operable_list);
    /* 取得订单操作记录 */
    $act_list = array();
    $sql = "SELECT * FROM " . $ecs->table('order_action') . " WHERE order_id = '$order[order_id]' ORDER BY log_time DESC,action_id DESC";
    $res = $db->query($sql);
    while ($row = $db->fetchRow($res))
    {
        $row['order_status']    = $_LANG['os'][$row['order_status']];
        $row['pay_status']      = $_LANG['ps'][$row['pay_status']];
        $row['shipping_status'] = $_LANG['ss'][$row['shipping_status']];
        $row['action_time']     = local_date($_CFG['time_format'], $row['log_time']);
        $act_list[] = $row;
    }
    $smarty->assign('action_list', $act_list);

    /* 取得是否存在实体商品 */
    $smarty->assign('exist_real_goods', exist_real_goods($order['order_id']));

    /* 是否打印订单，分别赋值 */
    if (isset($_GET['print']))
    {
        $smarty->assign('shop_name',    $_CFG['shop_name']);
        $smarty->assign('shop_url',     $ecs->url());
        $smarty->assign('shop_address', $_CFG['shop_address']);
        $smarty->assign('service_phone',$_CFG['service_phone']);
        $smarty->assign('print_time',   local_date($_CFG['time_format']));
        $smarty->assign('action_user',  $_SESSION['admin_name']);

        $smarty->template_dir = '../' . DATA_DIR;
        $smarty->display('order_print.html');
    }
    /* 打印快递单 */
    elseif (isset($_GET['shipping_print']))
    {
        //$smarty->assign('print_time',   local_date($_CFG['time_format']));
        //发货地址所在地
        $region_array = array();
        $region_id = !empty($_CFG['shop_country']) ? $_CFG['shop_country'] . ',' : '';
        $region_id .= !empty($_CFG['shop_province']) ? $_CFG['shop_province'] . ',' : '';
        $region_id .= !empty($_CFG['shop_city']) ? $_CFG['shop_city'] . ',' : '';
        $region_id = substr($region_id, 0, -1);
        $region = $db->getAll("SELECT region_id, region_name FROM " . $ecs->table("region") . " WHERE region_id IN ($region_id)");
        if (!empty($region))
        {
            foreach($region as $region_data)
            {
                $region_array[$region_data['region_id']] = $region_data['region_name'];
            }
        }
        $smarty->assign('shop_name',    $_CFG['shop_name']);
        $smarty->assign('order_id',    $order_id);
        $smarty->assign('province', $region_array[$_CFG['shop_province']]);
        $smarty->assign('city', $region_array[$_CFG['shop_city']]);
        $smarty->assign('shop_address', $_CFG['shop_address']);
        $smarty->assign('service_phone',$_CFG['service_phone']);
        $shipping = $db->getRow("SELECT * FROM " . $ecs->table("shipping") . " WHERE shipping_id = " . $order['shipping_id']);

        //打印单模式
        if ($shipping['print_model'] == 2)
        {
            /* 可视化 */
            /* 快递单 */
            $shipping['print_bg'] = empty($shipping['print_bg']) ? '' : get_site_root_url() . $shipping['print_bg'];

            /* 取快递单背景宽高 */
            if (!empty($shipping['print_bg']))
            {
                $_size = @getimagesize($shipping['print_bg']);

                if ($_size != false)
                {
                    $shipping['print_bg_size'] = array('width' => $_size[0], 'height' => $_size[1]);
                }
            }

            if (empty($shipping['print_bg_size']))
            {
                $shipping['print_bg_size'] = array('width' => '1024', 'height' => '600');
            }

            /* 标签信息 */
            $lable_box = array();
            $lable_box['t_shop_country'] = $region_array[$_CFG['shop_country']]; //网店-国家
            $lable_box['t_shop_city'] = $region_array[$_CFG['shop_city']]; //网店-城市
            $lable_box['t_shop_province'] = $region_array[$_CFG['shop_province']]; //网店-省份
            $lable_box['t_shop_name'] = $_CFG['shop_name']; //网店-名称
            $lable_box['t_shop_district'] = ''; //网店-区/县
            $lable_box['t_shop_tel'] = $_CFG['service_phone']; //网店-联系电话
            $lable_box['t_shop_address'] = $_CFG['shop_address']; //网店-地址
            $lable_box['t_customer_country'] = $region_array[$order['country']]; //收件人-国家
            $lable_box['t_customer_province'] = $region_array[$order['province']]; //收件人-省份
            $lable_box['t_customer_city'] = $region_array[$order['city']]; //收件人-城市
            $lable_box['t_customer_district'] = $region_array[$order['district']]; //收件人-区/县
            $lable_box['t_customer_tel'] = $order['tel']; //收件人-电话
            $lable_box['t_customer_mobel'] = $order['mobile']; //收件人-手机
            $lable_box['t_customer_post'] = $order['zipcode']; //收件人-邮编
            $lable_box['t_customer_address'] = $order['address']; //收件人-详细地址
            $lable_box['t_customer_name'] = $order['consignee']; //收件人-姓名

            $gmtime_utc_temp = gmtime(); //获取 UTC 时间戳
            $lable_box['t_year'] = date('Y', $gmtime_utc_temp); //年-当日日期
            $lable_box['t_months'] = date('m', $gmtime_utc_temp); //月-当日日期
            $lable_box['t_day'] = date('d', $gmtime_utc_temp); //日-当日日期

            $lable_box['t_order_no'] = $order['order_sn']; //订单号-订单
            $lable_box['t_order_postscript'] = $order['postscript']; //备注-订单
            $lable_box['t_order_best_time'] = $order['best_time']; //送货时间-订单
            $lable_box['t_pigeon'] = '√'; //√-对号
            $lable_box['t_custom_content'] = ''; //自定义内容

            //标签替换
            $temp_config_lable = explode('||,||', $shipping['config_lable']);
            if (!is_array($temp_config_lable))
            {
                $temp_config_lable[] = $shipping['config_lable'];
            }
            foreach ($temp_config_lable as $temp_key => $temp_lable)
            {
                $temp_info = explode(',', $temp_lable);
                if (is_array($temp_info))
                {
                    $temp_info[1] = $lable_box[$temp_info[0]];
                }
                $temp_config_lable[$temp_key] = implode(',', $temp_info);
            }
            $shipping['config_lable'] = implode('||,||',  $temp_config_lable);

            $smarty->assign('shipping', $shipping);

            $smarty->display('print.htm');
        }
        elseif (!empty($shipping['shipping_print']))
        {
            /* 代码 */
            echo $smarty->fetch("str:" . $shipping['shipping_print']);
        }
        else
        {
            $shipping_code = $db->getOne("SELECT shipping_code FROM " . $ecs->table('shipping') . " WHERE shipping_id=" . $order['shipping_id']);
            if ($shipping_code)
            {
                include_once(ROOT_PATH . 'includes/modules/shipping/' . $shipping_code . '.php');
            }

            if (!empty($_LANG['shipping_print']))
            {
                echo $smarty->fetch("str:$_LANG[shipping_print]");
            }
            else
            {
                echo $_LANG['no_print_shipping'];
            }
        }
    }
    else
    {
        _wap_assign_header_info('订单详情');
        _wap_assign_footer_order_info();
        _wap_display_page('order_info.htm');
    }
}

elseif($act == 'edit')
{
    /* 检查权限 */
    //admin_priv('order_edit');

    /* 取得参数 order_id */
    $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
    $smarty->assign('order_id', $order_id);

    /* 取得参数 step */
    $step_list = array('user', 'goods', 'consignee', 'shipping', 'payment', 'other', 'money');
    $step = isset($_GET['step']) && in_array($_GET['step'], $step_list) ? $_GET['step'] : 'user';
    $smarty->assign('step', $step);

    /* 取得参数 act */
    $act = $_GET['act'];
    $smarty->assign('ur_here',$_LANG['add_order']);
    $smarty->assign('step_act', $act);

    /* 取得订单信息 */
    if ($order_id > 0)
    {
        $order = order_info($order_id);

        /* 发货单格式化 */
        $order['invoice_no'] = str_replace('<br>', ',', $order['invoice_no']);

        /* 如果已发货，就不能修改订单了（配送方式和发货单号除外） */
        if ($order['shipping_status'] == SS_SHIPPED || $order['shipping_status'] == SS_RECEIVED)
        {
            if ($step != 'shipping')
            {
                sys_msg($_LANG['cannot_edit_order_shipped']);
            }
            else
            {
                $step = 'invoice';
                $smarty->assign('step', $step);
            }
        }

        $smarty->assign('order', $order);
    }
    else
    {
        if ($act != 'add' || $step != 'user')
        {
            die('invalid params');
        }
    }

    /* 选择会员 */
    if ('user' == $step)
    {
        // 无操作
    }

    /* 增删改商品 */
    elseif ('goods' == $step)
    {
        /* 取得订单商品 */
        $goods_list = order_goods($order_id);
        if (!empty($goods_list))
        {
            foreach ($goods_list AS $key => $goods)
            {
                /* 计算属性数 */
                $attr = $goods['goods_attr'];
                if ($attr == '')
                {
                    $goods_list[$key]['rows'] = 1;
                }
                else
                {
                    $goods_list[$key]['rows'] = count(explode(chr(13), $attr));
                }
            }
        }

        $smarty->assign('goods_list', $goods_list);

        /* 取得商品总金额 */
        $smarty->assign('goods_amount', order_amount($order_id));
    }

    // 设置收货人
    elseif ('consignee' == $step)
    {
        /* 查询是否存在实体商品 */
        $exist_real_goods = exist_real_goods($order_id);
        $smarty->assign('exist_real_goods', $exist_real_goods);

        /* 取得收货地址列表 */
        if ($order['user_id'] > 0)
        {
            $smarty->assign('address_list', address_list($order['user_id']));

            $address_id = isset($_REQUEST['address_id']) ? intval($_REQUEST['address_id']) : 0;
            if ($address_id > 0)
            {
                $address = address_info($address_id);
                if ($address)
                {
                    $order['consignee']     = $address['consignee'];
                    $order['country']       = $address['country'];
                    $order['province']      = $address['province'];
                    $order['city']          = $address['city'];
                    $order['district']      = $address['district'];
                    $order['email']         = $address['email'];
                    $order['address']       = $address['address'];
                    $order['zipcode']       = $address['zipcode'];
                    $order['tel']           = $address['tel'];
                    $order['mobile']        = $address['mobile'];
                    $order['sign_building'] = $address['sign_building'];
                    $order['best_time']     = $address['best_time'];
                    $smarty->assign('order', $order);
                }
            }
        }

        if ($exist_real_goods)
        {
            /* 取得国家 */
            $smarty->assign('country_list', get_regions());
            if ($order['country'] > 0)
            {
                /* 取得省份 */
                $smarty->assign('province_list', get_regions(1, $order['country']));
                if ($order['province'] > 0)
                {
                    /* 取得城市 */
                    $smarty->assign('city_list', get_regions(2, $order['province']));
                    if ($order['city'] > 0)
                    {
                        /* 取得区域 */
                        $smarty->assign('district_list', get_regions(3, $order['city']));
                    }
                }
            }
        }
    }

    // 选择配送方式
    elseif ('shipping' == $step)
    {
        /* 如果不存在实体商品 */
        if (!exist_real_goods($order_id))
        {
            die ('Hacking Attemp');
        }

        /* 取得可用的配送方式列表 */
        $region_id_list = array(
            $order['country'], $order['province'], $order['city'], $order['district']
        );
        $shipping_list = available_shipping_list($region_id_list);

        /* 取得配送费用 */
        $total = order_weight_price($order_id);
        foreach ($shipping_list AS $key => $shipping)
        {
            $shipping_fee = shipping_fee($shipping['shipping_code'],
                unserialize($shipping['configure']), $total['weight'], $total['amount'], $total['number']);
            $shipping_list[$key]['shipping_fee'] = $shipping_fee;
            $shipping_list[$key]['format_shipping_fee'] = price_format($shipping_fee);
            $shipping_list[$key]['free_money'] = price_format($shipping['configure']['free_money']);
        }
        $smarty->assign('shipping_list', $shipping_list);
    }

    // 选择支付方式
    elseif ('payment' == $step)
    {
        /* 取得可用的支付方式列表 */
        if (exist_real_goods($order_id))
        {
            /* 存在实体商品 */
            $region_id_list = array(
                $order['country'], $order['province'], $order['city'], $order['district']
            );
            $shipping_area = shipping_area_info($order['shipping_id'], $region_id_list);
            $pay_fee = ($shipping_area['support_cod'] == 1) ? $shipping_area['pay_fee'] : 0;

            $payment_list = available_payment_list($shipping_area['support_cod'], $pay_fee);
        }
        else
        {
            /* 不存在实体商品 */
            $payment_list = available_payment_list(false);
        }

        /* 过滤掉使用余额支付 */
        foreach ($payment_list as $key => $payment)
        {
            if ($payment['pay_code'] == 'balance')
            {
                unset($payment_list[$key]);
            }
        }
        $smarty->assign('payment_list', $payment_list);
    }

    // 选择包装、贺卡
    elseif ('other' == $step)
    {
        /* 查询是否存在实体商品 */
        $exist_real_goods = exist_real_goods($order_id);
        $smarty->assign('exist_real_goods', $exist_real_goods);

        if ($exist_real_goods)
        {
            /* 取得包装列表 */
            $smarty->assign('pack_list', pack_list());

            /* 取得贺卡列表 */
            $smarty->assign('card_list', card_list());
        }
    }

    // 费用
    elseif ('money' == $step)
    {
        /* 查询是否存在实体商品 */
        $exist_real_goods = exist_real_goods($order_id);
        $smarty->assign('exist_real_goods', $exist_real_goods);

        /* 取得用户信息 */
        if ($order['user_id'] > 0)
        {
            $user = user_info($order['user_id']);

            /* 计算可用余额 */
            $smarty->assign('available_user_money', $order['surplus'] + $user['user_money']);

            /* 计算可用积分 */
            $smarty->assign('available_pay_points', $order['integral'] + $user['pay_points']);

            /* 取得用户可用红包 
            $user_bonus = user_bonus($order['user_id'], $order['goods_amount']);
            if ($order['bonus_id'] > 0)
            {
                $bonus = bonus_info($order['bonus_id']);
                $user_bonus[] = $bonus;
            }
            $smarty->assign('available_bonus', $user_bonus);*/
			/* 取得用户可用红包 */
            $user_bonus = user_bonus($order['user_id'], array($order['supplier_id']=>$order['goods_amount']));
			if (!empty($user_bonus)){
				$user_bonus1 = $user_bonus[$order['supplier_id']];
				foreach($user_bonus1 as $key=>$val){
					$user_bonus1[$key] = bonus_info($val['bonus_id']);
				}
				$smarty->assign('available_bonus', $user_bonus1);
			}
        }
    }

    // 发货后修改配送方式和发货单号
    elseif ('invoice' == $step)
    {
        /* 如果不存在实体商品 */
        if (!exist_real_goods($order_id))
        {
            die ('Hacking Attemp');
        }

        /* 取得可用的配送方式列表 */
        $region_id_list = array(
            $order['country'], $order['province'], $order['city'], $order['district']
        );
        $shipping_list = available_shipping_list($region_id_list);

        $smarty->assign('shipping_list', $shipping_list);
    }

    /* 显示模板 */
    assign_query_info();
    _wap_assign_header_info('修改订单信息','修改订单信息',0,1,0);
    _wap_display_page('order_step.htm');
}

elseif ($act == 'step_post')
{
    /* 检查权限 */
    //admin_priv('order_edit');

    /* 取得参数 step */
    $step_list = array('user', 'edit_goods', 'add_goods', 'goods', 'consignee', 'shipping', 'payment', 'other', 'money', 'invoice');
    $step = isset($_REQUEST['step']) && in_array($_REQUEST['step'], $step_list) ? $_REQUEST['step'] : 'user';

    /* 取得参数 order_id */
    $order_id = isset($_REQUEST['order_id']) ? intval($_REQUEST['order_id']) : 0;
    if ($order_id > 0)
    {
        $old_order = order_info($order_id);
    }

    /* 取得参数 step_act 添加还是编辑 */
    $step_act = isset($_REQUEST['step_act']) ? $_REQUEST['step_act'] : 'add';

    /* 插入订单信息 */
    if ('user' == $step)
    {
        /* 取得参数：user_id */
        $user_id = ($_POST['anonymous'] == 1) ? 0 : intval($_POST['user']);

        /* 插入新订单，状态为无效 */
        $order = array(
            'user_id'           => $user_id,
            'add_time'          => gmtime(),
            'order_status'      => OS_INVALID,
            'shipping_status'   => SS_UNSHIPPED,
            'pay_status'        => PS_UNPAYED,
            'from_ad'           => 0,
            'referer'           => $_LANG['admin']
        );

        do
        {
            $order['order_sn'] = get_order_sn();
            if ($db->autoExecute($ecs->table('order_info'), $order, 'INSERT', '', 'SILENT'))
            {
                break;
            }
            else
            {
                if ($db->errno() != 1062)
                {
                    die($db->error());
                }
            }
        }
        while (true); // 防止订单号重复

        $order_id = $db->insert_id();

        /* todo 记录日志 */
        admin_log($order['order_sn'], 'add', 'order');

        /* 插入 pay_log */
        $sql = 'INSERT INTO ' . $ecs->table('pay_log') . " (order_id, order_amount, order_type, is_paid)" .
                " VALUES ('$order_id', 0, '" . PAY_ORDER . "', 0)";
        $db->query($sql);

        /* 下一步 */
        ecs_header("Location: order.php?act=" . $step_act . "&order_id=" . $order_id . "&step=goods\n");
        exit;
    }
    /* 编辑商品信息 */
    elseif ('edit_goods' == $step)
    {
        if (isset($_POST['rec_id']))
        {
            foreach ($_POST['rec_id'] AS $key => $rec_id)
            {
              $sql = "SELECT goods_number ".
                      'FROM ' . $GLOBALS['ecs']->table('goods') .
                      "WHERE goods_id =".$_POST['goods_id'][$key];
                /* 取得参数 */
              $goods_price = floatval($_POST['goods_price'][$key]);
              $goods_number = intval($_POST['goods_number'][$key]);
              $goods_attr = $_POST['goods_attr'][$key];
              $product_id = intval($_POST['product_id'][$key]);
              if($product_id)
                {

                   $sql = "SELECT product_number ".
                          'FROM ' . $GLOBALS['ecs']->table('products') .
                          " WHERE product_id =".$_POST['product_id'][$key];
                }
              $goods_number_all = $db->getOne($sql);
              if($goods_number_all>=$goods_number)
              {
                /* 修改 */
                $sql = "UPDATE " . $ecs->table('order_goods') .
                        " SET goods_price = '$goods_price', " .
                        "goods_number = '$goods_number', " .
                        "goods_attr = '$goods_attr' " .
                        "WHERE rec_id = '$rec_id' LIMIT 1";
                $db->query($sql);
              }
              else
              {
               sys_msg($_LANG['goods_num_err']);


              }
            }

            /* 更新商品总金额和订单总金额 */
            $goods_amount = order_amount($order_id);
            update_order($order_id, array('goods_amount' => $goods_amount));
            update_order_amount($order_id);

            /* 更新 pay_log */
            update_pay_log($order_id);

            /* todo 记录日志 */
            $sn = $old_order['order_sn'];
            $new_order = order_info($order_id);
            if ($old_order['total_fee'] != $new_order['total_fee'])
            {
                $sn .= ',' . sprintf($_LANG['order_amount_change'], $old_order['total_fee'], $new_order['total_fee']);
            }
            admin_log($sn, 'edit', 'order');
        }

        /* 跳回订单商品 */
        ecs_header("Location: order.php?act=" . $step_act . "&order_id=" . $order_id . "&step=goods\n");
        exit;
    }
    /* 添加商品 */
    elseif ('add_goods' == $step)
    {
        /* 取得参数 */
        $goods_id = intval($_POST['goodslist']);
        $goods_price = $_POST['add_price'] != 'user_input' ? floatval($_POST['add_price']) : floatval($_POST['input_price']);
        $goods_attr = '0';
        for ($i = 0; $i < $_POST['spec_count']; $i++)
        {
            if (is_array($_POST['spec_' . $i]))
            {
                $temp_array = $_POST['spec_' . $i];
                $temp_array_count = count($_POST['spec_' . $i]);
                for ($j = 0; $j < $temp_array_count; $j++)
                {
                    if($temp_array[$j]!==NULL)
                    {
                        $goods_attr .= ',' . $temp_array[$j];
                    }
                }
            }
            else
            {
                if($_POST['spec_' . $i]!==NULL)
                {
                    $goods_attr .= ',' . $_POST['spec_' . $i];
                }
            }
        }
        $goods_number = $_POST['add_number'];
        $attr_list = $goods_attr;

        $goods_attr = explode(',',$goods_attr);
        $k   =   array_search(0,$goods_attr);
        unset($goods_attr[$k]);


        $sql = "SELECT attr_value ".
            'FROM ' . $GLOBALS['ecs']->table('goods_attr') .
            "WHERE goods_attr_id in($attr_list)";
       $res = $db->query($sql);
        while ($row = $db->fetchRow($res))
        {
            $attr_value[] = $row['attr_value'];
        }

        $attr_value = implode(",",$attr_value);

        $sql = "SELECT * FROM " .$GLOBALS['ecs']->table('products'). " WHERE goods_id = '$goods_id' LIMIT 0, 1";
        $prod = $GLOBALS['db']->getRow($sql);


        if (is_spec($goods_attr) && !empty($prod))
        {
            $product_info = get_products_info($_REQUEST['goodslist'], $goods_attr);
        }

        //商品存在规格 是货品 检查该货品库存
        if (is_spec($goods_attr) && !empty($prod))
        {
            if (!empty($goods_attr))
            {
                /* 取规格的货品库存 */
                if ($goods_number > $product_info['product_number'])
                {
                    $url = "order.php?act=" . $step_act . "&order_id=" . $order_id . "&step=goods";

                    echo '<a href="'.$url.'">'.$_LANG['goods_num_err'] .'</a>';
                    exit;

                    return false;
                }
            }
        }

        if(is_spec($goods_attr) && !empty($prod))
        {
        /* 插入订单商品 */
            $sql = "INSERT INTO " . $ecs->table('order_goods') .
                        "(order_id, goods_id, goods_name, goods_sn, product_id, goods_number, market_price, " .
                        "goods_price, goods_attr, is_real, extension_code, parent_id, is_gift, goods_attr_id) " .
                    "SELECT '$order_id', goods_id, goods_name, goods_sn, " .$product_info['product_id'].", ".
                        "'$goods_number', market_price, '$goods_price', '" .$attr_value . "', " .
                        "is_real, extension_code, 0, 0 , '".implode(',',$goods_attr)."' " .
                    "FROM " . $ecs->table('goods') .
                    " WHERE goods_id = '$goods_id' LIMIT 1";
        }
        else
        {
             $sql = "INSERT INTO " . $ecs->table('order_goods') .
                    " (order_id, goods_id, goods_name, goods_sn, " .
                    "goods_number, market_price, goods_price, goods_attr, " .
                    "is_real, extension_code, parent_id, is_gift)" .
                "SELECT '$order_id', goods_id, goods_name, goods_sn, " .
                    "'$goods_number', market_price, '$goods_price', '" . $attr_value. "', " .
                    "is_real, extension_code, 0, 0 " .
                "FROM " . $ecs->table('goods') .
                " WHERE goods_id = '$goods_id' LIMIT 1";
        }
        $db->query($sql);

        /* 如果使用库存，且下订单时减库存，则修改库存 */
        if ($_CFG['use_storage'] == '1' && $_CFG['stock_dec_time'] == SDT_PLACE)
        {

            //（货品）
            if (!empty($product_info['product_id']))
            {
                $sql = "UPDATE " . $ecs->table('products') . "
                                    SET product_number = product_number - " . $goods_number . "
                                    WHERE product_id = " . $product_info['product_id'];

                $db->query($sql);
            }


            $sql = "UPDATE " . $ecs->table('goods') .
                    " SET `goods_number` = goods_number - '" . $goods_number . "' " .
                    " WHERE `goods_id` = '" . $goods_id . "' LIMIT 1";
            $db->query($sql);
        }

        /* 更新商品总金额和订单总金额 */
        update_order($order_id, array('goods_amount' => order_amount($order_id)));
        update_order_amount($order_id);

        /* 更新 pay_log */
        update_pay_log($order_id);

        /* todo 记录日志 */
        $sn = $old_order['order_sn'];
        $new_order = order_info($order_id);
        if ($old_order['total_fee'] != $new_order['total_fee'])
        {
            $sn .= ',' . sprintf($_LANG['order_amount_change'], $old_order['total_fee'], $new_order['total_fee']);
        }
        admin_log($sn, 'edit', 'order');

        /* 跳回订单商品 */
        ecs_header("Location: order.php?act=" . $step_act . "&order_id=" . $order_id . "&step=goods\n");
        exit;
    }
    /* 商品 */
    elseif ('goods' == $step)
    {
        /* 下一步 */
        if (isset($_POST['next']))
        {
            ecs_header("Location: order.php?act=" . $step_act . "&order_id=" . $order_id . "&step=consignee\n");
            exit;
        }
        /* 完成 */
        elseif (isset($_POST['finish']))
        {
            /* 初始化提示信息和链接 */
            $msgs   = array();
            $links  = array();

            /* 如果已付款，检查金额是否变动，并执行相应操作 */
            $order = order_info($order_id);
            handle_order_money_change($order, $msgs, $links);

            /* 显示提示信息 */
            if (!empty($msgs))
            {
                sys_msg(join(chr(13), $msgs), 0, $links);
            }
            else
            {
                /* 跳转到订单详情 */
                ecs_header("Location: order.php?act=info&order_id=" . $order_id . "\n");
                exit;
            }
        }
    }
    /* 保存收货人信息 */
    elseif ('consignee' == $step)
    {
        /* 保存订单 */
        $order = $_POST;
        $order['agency_id'] = get_agency_by_regions(array($order['country'], $order['province'], $order['city'], $order['district']));
        update_order($order_id, $order);

        /* 该订单所属办事处是否变化 */
        $agency_changed = $old_order['agency_id'] != $order['agency_id'];

        /* todo 记录日志 */
        $sn = $old_order['order_sn'];
        admin_log($sn, 'edit', 'order');

        if (isset($_POST['next']))
        {
            /* 下一步 */
            if (exist_real_goods($order_id))
            {
                /* 存在实体商品，去配送方式 */
                ecs_header("Location: order.php?act=" . $step_act . "&order_id=" . $order_id . "&step=shipping\n");
                exit;
            }
            else
            {
                /* 不存在实体商品，去支付方式 */
                ecs_header("Location: order.php?act=" . $step_act . "&order_id=" . $order_id . "&step=payment\n");
                exit;
            }
        }
        elseif (isset($_POST['finish']))
        {
            /* 如果是编辑且存在实体商品，检查收货人地区的改变是否影响原来选的配送 */
            if ('edit' == $step_act && exist_real_goods($order_id))
            {
                $order = order_info($order_id);

                /* 取得可用配送方式 */
                $region_id_list = array(
                    $order['country'], $order['province'], $order['city'], $order['district']
                );
                $shipping_list = available_shipping_list($region_id_list);

                /* 判断订单的配送是否在可用配送之内 */
                $exist = false;
                foreach ($shipping_list AS $shipping)
                {
                    if ($shipping['shipping_id'] == $order['shipping_id'])
                    {
                        $exist = true;
                        break;
                    }
                }

                /* 如果不在可用配送之内，提示用户去修改配送 */
                if (!$exist)
                {
                    // 修改配送为空，配送费和保价费为0
                    update_order($order_id, array('shipping_id' => 0, 'shipping_name' => ''));
                    $links[] = array('text' => $_LANG['step']['shipping'], 'href' => 'order.php?act=edit&order_id=' . $order_id . '&step=shipping');
                    sys_msg($_LANG['continue_shipping'], 1, $links);
                }
            }

            /* 完成 */
            if ($agency_changed)
            {
                ecs_header("Location: order.php?act=order_list\n");
            }
            else
            {
                ecs_header("Location: order.php?act=info&order_id=" . $order_id . "\n");
            }
            exit;
        }
    }
    /* 保存配送信息 */
    elseif ('shipping' == $step)
    {
        /* 如果不存在实体商品，退出 */
        if (!exist_real_goods($order_id))
        {
            die ('Hacking Attemp');
        }

        /* 取得订单信息 */
        $order_info = order_info($order_id);
        $region_id_list = array($order_info['country'], $order_info['province'], $order_info['city'], $order_info['district']);

        /* 保存订单 */
        $shipping_id = $_POST['shipping'];
        $shipping = shipping_area_info($shipping_id, $region_id_list);
        $weight_amount = order_weight_price($order_id);
        $shipping_fee = shipping_fee($shipping['shipping_code'], $shipping['configure'], $weight_amount['weight'], $weight_amount['amount'], $weight_amount['number']);
        $order = array(
            'shipping_id' => $shipping_id,
            'shipping_name' => addslashes($shipping['shipping_name']),
            'shipping_fee' => $shipping_fee
        );

        if (isset($_POST['insure']))
        {
            /* 计算保价费 */
            $order['insure_fee'] = shipping_insure_fee($shipping['shipping_code'], order_amount($order_id), $shipping['insure']);
        }
        else
        {
            $order['insure_fee'] = 0;
        }
        update_order($order_id, $order);
        update_order_amount($order_id);

        /* 更新 pay_log */
        update_pay_log($order_id);

        /* 清除首页缓存：发货单查询 */
        clear_cache_files('index.dwt');

        /* todo 记录日志 */
        $sn = $old_order['order_sn'];
        $new_order = order_info($order_id);
        if ($old_order['total_fee'] != $new_order['total_fee'])
        {
            $sn .= ',' . sprintf($_LANG['order_amount_change'], $old_order['total_fee'], $new_order['total_fee']);
        }
        admin_log($sn, 'edit', 'order');

        if (isset($_POST['next']))
        {
            /* 下一步 */
            ecs_header("Location: order.php?act=" . $step_act . "&order_id=" . $order_id . "&step=payment\n");
            exit;
        }
        elseif (isset($_POST['finish']))
        {
            /* 初始化提示信息和链接 */
            $msgs   = array();
            $links  = array();

            /* 如果已付款，检查金额是否变动，并执行相应操作 */
            $order = order_info($order_id);
            handle_order_money_change($order, $msgs, $links);

            /* 如果是编辑且配送不支持货到付款且原支付方式是货到付款 */
            if ('edit' == $step_act && $shipping['support_cod'] == 0)
            {
                $payment = payment_info($order['pay_id']);
                if ($payment['is_cod'] == 1)
                {
                    /* 修改支付为空 */
                    update_order($order_id, array('pay_id' => 0, 'pay_name' => ''));
                    $msgs[]     = $_LANG['continue_payment'];
                    $links[]    = array('text' => $_LANG['step']['payment'], 'href' => 'order.php?act=' . $step_act . '&order_id=' . $order_id . '&step=payment');
                }
            }

            /* 显示提示信息 */
            if (!empty($msgs))
            {
                sys_msg(join(chr(13), $msgs), 0, $links);
            }
            else
            {
                /* 完成 */
                ecs_header("Location: order.php?act=info&order_id=" . $order_id . "\n");
                exit;
            }
        }
    }
    /* 保存支付信息 */
    elseif ('payment' == $step)
    {
        /* 取得支付信息 */
        $pay_id = $_POST['payment'];
        $payment = payment_info($pay_id);

        /* 计算支付费用 */
        $order_amount = order_amount($order_id);
        if ($payment['is_cod'] == 1)
        {
            $order = order_info($order_id);
            $region_id_list = array(
                $order['country'], $order['province'], $order['city'], $order['district']
            );
            $shipping = shipping_area_info($order['shipping_id'], $region_id_list);
            $pay_fee = pay_fee($pay_id, $order_amount, $shipping['pay_fee']);
        }
        else
        {
            $pay_fee = pay_fee($pay_id, $order_amount);
        }

        /* 保存订单 */
        $order = array(
            'pay_id' => $pay_id,
            'pay_name' => addslashes($payment['pay_name']),
            'pay_fee' => $pay_fee
        );
        update_order($order_id, $order);
        update_order_amount($order_id);

        /* 更新 pay_log */
        update_pay_log($order_id);

        /* todo 记录日志 */
        $sn = $old_order['order_sn'];
        $new_order = order_info($order_id);
        if ($old_order['total_fee'] != $new_order['total_fee'])
        {
            $sn .= ',' . sprintf($_LANG['order_amount_change'], $old_order['total_fee'], $new_order['total_fee']);
        }
        admin_log($sn, 'edit', 'order');

        if (isset($_POST['next']))
        {
            /* 下一步 */
            ecs_header("Location: order.php?act=" . $step_act . "&order_id=" . $order_id . "&step=other\n");
            exit;
        }
        elseif (isset($_POST['finish']))
        {
            /* 初始化提示信息和链接 */
            $msgs   = array();
            $links  = array();

            /* 如果已付款，检查金额是否变动，并执行相应操作 */
            $order = order_info($order_id);
            handle_order_money_change($order, $msgs, $links);

            /* 显示提示信息 */
            if (!empty($msgs))
            {
                sys_msg(join(chr(13), $msgs), 0, $links);
            }
            else
            {
                /* 完成 */
                ecs_header("Location: order.php?act=info&order_id=" . $order_id . "\n");
                exit;
            }
        }
    }
    elseif ('other' == $step)
    {
        /* 保存订单 */
        $order = array();
        if (isset($_POST['pack']) && $_POST['pack'] > 0)
        {
            $pack               = pack_info($_POST['pack']);
            $order['pack_id']   = $pack['pack_id'];
            $order['pack_name'] = addslashes($pack['pack_name']);
            $order['pack_fee']  = $pack['pack_fee'];
        }
        else
        {
            $order['pack_id']   = 0;
            $order['pack_name'] = '';
            $order['pack_fee']  = 0;
        }
        if (isset($_POST['card']) && $_POST['card'] > 0)
        {
            $card               = card_info($_POST['card']);
            $order['card_id']   = $card['card_id'];
            $order['card_name'] = addslashes($card['card_name']);
            $order['card_fee']  = $card['card_fee'];
            $order['card_message'] = $_POST['card_message'];
        }
        else
        {
            $order['card_id']   = 0;
            $order['card_name'] = '';
            $order['card_fee']  = 0;
            $order['card_message'] = '';
        }
        $order['inv_type']      = $_POST['inv_type'];
        $order['inv_payee']     = $_POST['inv_payee'];
        $order['inv_content']   = $_POST['inv_content'];
        $order['how_oos']       = $_POST['how_oos'];
        $order['postscript']    = $_POST['postscript'];
        $order['to_buyer']      = $_POST['to_buyer'];
        update_order($order_id, $order);
        update_order_amount($order_id);

        /* 更新 pay_log */
        update_pay_log($order_id);

        /* todo 记录日志 */
        $sn = $old_order['order_sn'];
        admin_log($sn, 'edit', 'order');

        if (isset($_POST['next']))
        {
            /* 下一步 */
            ecs_header("Location: order.php?act=" . $step_act . "&order_id=" . $order_id . "&step=money\n");
            exit;
        }
        elseif (isset($_POST['finish']))
        {
            /* 完成 */
            ecs_header("Location: order.php?act=info&order_id=" . $order_id . "\n");
            exit;
        }
    }
    elseif ('money' == $step)
    {
        /* 取得订单信息 */
        $old_order = order_info($order_id);
        if ($old_order['user_id'] > 0)
        {
            /* 取得用户信息 */
            $user = user_info($old_order['user_id']);
        }

        /* 保存信息 */
        $order['goods_amount']  = $old_order['goods_amount'];
        $order['discount']      = isset($_POST['discount']) && floatval($_POST['discount']) >= 0 ? round(floatval($_POST['discount']), 2) : 0;
        $order['tax']           = round(floatval($_POST['tax']), 2);
        $order['shipping_fee']  = isset($_POST['shipping_fee']) && floatval($_POST['shipping_fee']) >= 0 ? round(floatval($_POST['shipping_fee']), 2) : 0;
        $order['insure_fee']    = isset($_POST['insure_fee']) && floatval($_POST['insure_fee']) >= 0 ? round(floatval($_POST['insure_fee']), 2) : 0;
        $order['pay_fee']       = floatval($_POST['pay_fee']) >= 0 ? round(floatval($_POST['pay_fee']), 2) : 0;
        $order['pack_fee']      = isset($_POST['pack_fee']) && floatval($_POST['pack_fee']) >= 0 ? round(floatval($_POST['pack_fee']), 2) : 0;
        $order['card_fee']      = isset($_POST['card_fee']) && floatval($_POST['card_fee']) >= 0 ? round(floatval($_POST['card_fee']), 2) : 0;

        $order['money_paid']    = $old_order['money_paid'];
        $order['surplus']       = 0;
        //$order['integral']      = 0;
        $order['integral']=intval($_POST['integral']) >= 0 ? intval($_POST['integral']) : 0;
        $order['integral_money']= 0;
        $order['bonus_id']      = 0;
        $order['bonus']         = 0;

        /* 计算待付款金额 */
        $order['order_amount']  = $order['goods_amount'] - $order['discount']
                                + $order['tax']
                                + $order['shipping_fee']
                                + $order['insure_fee']
                                + $order['pay_fee']
                                + $order['pack_fee']
                                + $order['card_fee']
                                - $order['money_paid'];
        if ($order['order_amount'] > 0)
        {
            if ($old_order['user_id'] > 0)
            {
                /* 如果选择了红包，先使用红包支付 */
                if ($_POST['bonus_id'] > 0)
                {
                    /* todo 检查红包是否可用 */
                    $order['bonus_id']      = $_POST['bonus_id'];
                    $bonus                  = bonus_info($_POST['bonus_id']);
                    $order['bonus']         = $bonus['type_money'];

                    $order['order_amount']  -= $order['bonus'];
                }

                /* 使用红包之后待付款金额仍大于0 */
                if ($order['order_amount'] > 0)
                {
                    if($old_order['extension_code']!='exchange_goods')
                    {
                    /* 如果设置了积分，再使用积分支付 */
                       if (isset($_POST['integral']) && intval($_POST['integral']) > 0)
                         {
                           /* 检查积分是否足够 */
                           $order['integral']          = intval($_POST['integral']);
                           $order['integral_money']    = value_of_integral(intval($_POST['integral']));
                           if ($old_order['integral'] + $user['pay_points'] < $order['integral'])
                                {
                                   sys_msg($_LANG['pay_points_not_enough']);
                                }

                           $order['order_amount'] -= $order['integral_money'];
                         }
                    }
                    else
                    {
                      if (intval($_POST['integral']) > $user['pay_points']+$old_order['integral'])
                        {
                          sys_msg($_LANG['pay_points_not_enough']);
                        }

                    }
                    if ($order['order_amount'] > 0)
                    {
                        /* 如果设置了余额，再使用余额支付 */
                        if (isset($_POST['surplus']) && floatval($_POST['surplus']) >= 0)
                        {
                            /* 检查余额是否足够 */
                            $order['surplus'] = round(floatval($_POST['surplus']), 2);
                            if ($old_order['surplus'] + $user['user_money'] + $user['credit_line'] < $order['surplus'])
                            {
                                sys_msg($_LANG['user_money_not_enough']);
                            }

                            /* 如果红包和积分和余额足以支付，把待付款金额改为0，退回部分积分余额 */
                            $order['order_amount'] -= $order['surplus'];
                            if ($order['order_amount'] < 0)
                            {
                                $order['surplus']       += $order['order_amount'];
                                $order['order_amount']  = 0;
                            }
                        }
                    }
                    else
                    {
                        /* 如果红包和积分足以支付，把待付款金额改为0，退回部分积分 */
                        $order['integral_money']    += $order['order_amount'];
                        $order['integral']          = integral_of_value($order['integral_money']);
                        $order['order_amount']      = 0;
                    }
                }
                else
                {
                    /* 如果红包足以支付，把待付款金额设为0 */
                    $order['order_amount'] = 0;
                }
            }
        }

        update_order($order_id, $order);

        /* 更新 pay_log */
        update_pay_log($order_id);

        /* todo 记录日志 */
        $sn = $old_order['order_sn'];
        $new_order = order_info($order_id);
        if ($old_order['total_fee'] != $new_order['total_fee'])
        {
            $sn .= ',' . sprintf($_LANG['order_amount_change'], $old_order['total_fee'], $new_order['total_fee']);
        }
        admin_log($sn, 'edit', 'order');

        /* 如果余额、积分、红包有变化，做相应更新 */
        if ($old_order['user_id'] > 0)
        {
            $user_money_change = $old_order['surplus'] - $order['surplus'];
            if ($user_money_change != 0)
            {
                log_account_change($user['user_id'], $user_money_change, 0, 0, 0, sprintf($_LANG['change_use_surplus'], $old_order['order_sn']));
            }

            $pay_points_change = $old_order['integral'] - $order['integral'];
            if ($pay_points_change != 0)
            {
                log_account_change($user['user_id'], 0, 0, 0, $pay_points_change, sprintf($_LANG['change_use_integral'], $old_order['order_sn']));
            }

            if ($old_order['bonus_id'] != $order['bonus_id'])
            {
                if ($old_order['bonus_id'] > 0)
                {
                    $sql = "UPDATE " . $ecs->table('user_bonus') .
                            " SET used_time = 0, order_id = 0 " .
                            "WHERE bonus_id = '$old_order[bonus_id]' LIMIT 1";
                    $db->query($sql);
                }

                if ($order['bonus_id'] > 0)
                {
                    $sql = "UPDATE " . $ecs->table('user_bonus') .
                            " SET used_time = '" . gmtime() . "', order_id = '$order_id' " .
                            "WHERE bonus_id = '$order[bonus_id]' LIMIT 1";
                    $db->query($sql);
                }
            }
        }

        if (isset($_POST['finish']))
        {
            /* 完成 */
            if ($step_act == 'add')
            {
                /* 订单改为已确认，（已付款） */
                $arr['order_status'] = OS_CONFIRMED;
                $arr['confirm_time'] = gmtime();
                if ($order['order_amount'] <= 0)
                {
                    $arr['pay_status']  = PS_PAYED;
                    $arr['pay_time']    = gmtime();
                }
                update_order($order_id, $arr);
            }

            /* 初始化提示信息和链接 */
            $msgs   = array();
            $links  = array();

            /* 如果已付款，检查金额是否变动，并执行相应操作 */
            $order = order_info($order_id);
            handle_order_money_change($order, $msgs, $links);

            /* 显示提示信息 */
            if (!empty($msgs))
            {
                sys_msg(join(chr(13), $msgs), 0, $links);
            }
            else
            {
                ecs_header("Location: order.php?act=info&order_id=" . $order_id . "\n");
                exit;
            }
        }
    }
    /* 保存发货后的配送方式和发货单号 */
    elseif ('invoice' == $step)
    {
        /* 如果不存在实体商品，退出 */
        if (!exist_real_goods($order_id))
        {
            die ('Hacking Attemp');
        }

        /* 保存订单 */
        $shipping_id    = $_POST['shipping'];
        $shipping       = shipping_info($shipping_id);
        $invoice_no     = trim($_POST['invoice_no']);
        $invoice_no     = str_replace(',', '<br>', $invoice_no);
        $order = array(
            'shipping_id'   => $shipping_id,
            'shipping_name' => addslashes($shipping['shipping_name']),
            'invoice_no'    => $invoice_no
        );
        update_order($order_id, $order);

        /* todo 记录日志 */
        $sn = $old_order['order_sn'];
        admin_log($sn, 'edit', 'order');

        if (isset($_POST['finish']))
        {
            ecs_header("Location: order.php?act=info&order_id=" . $order_id . "\n");
            exit;
        }
    }
}

//一键发货
elseif($act == 'quick_delivery')
{
    global $ecs,$db;

    $order_id = empty($_REQUEST['order_id']) ? 0 : intval($_REQUEST['order_id']);
    $express_no = empty($_REQUEST['express_no']) ? 0 : intval($_REQUEST['express_no']);

    if(empty($express_no))
    {
        sys_msg('请输入快递单号！',1);
    }
    
    if(empty($order_id))
    {
        sys_msg('请输入订单号！',1);
    }

    //检测订单是否属于该商户、检测订单是否处于待发货状态
    $sql = 'SELECT COUNT(*) FROM '.$ecs->table('order_info').' WHERE supplier_id='.$_SESSION['supplier_id'].order_query_sql('await_ship');
    $result = $db->getOne($sql);
    if(empty($result))
    {
        sys_msg('不满足一键发货条件！',1);
    }
    
    quick_delivery($order_id,$express_no);
}

//发货列表
elseif($act == 'delivery_list')
{
    /* 查询 */
    $data = delivery_list($delivery_sn,$order_sn,$consignee,$page);
    $delivery_list = $data['delivery'];
	$filter = $data['filter'];
	
    /* 模板赋值 */
    $smarty->assign('delivery_list',$delivery_list);
    $smarty->assign('filter',$data['filter']);
    _wap_assign_header_info('发货单列表');
    _wap_assign_footer_order_info();
    _wap_display_page('delivery_list.htm');
}

//发货单详情
elseif($act == 'delivery_info')
{
    admin_priv('delivery_order');

    $delivery_id = intval(trim($_REQUEST['delivery_id']));

    /* 根据发货单id查询发货单信息 */
    if (!empty($delivery_id))
    {
        $delivery_order = delivery_order_info($delivery_id);
    }
    else
    {
        die('order does not exist');
    }

    /* 如果管理员属于某个办事处，检查该订单是否也属于这个办事处 */
    $sql = "SELECT agency_id FROM " . $ecs->table('admin_user') . " WHERE user_id = '" . $_SESSION['admin_id'] . "'";
    $agency_id = $db->getOne($sql);
    if ($agency_id > 0)
    {
        if ($delivery_order['agency_id'] != $agency_id)
        {
            sys_msg($_LANG['priv_error']);
        }

        /* 取当前办事处信息 */
        $sql = "SELECT agency_name FROM " . $ecs->table('agency') . " WHERE agency_id = '$agency_id' LIMIT 0, 1";
        $agency_name = $db->getOne($sql);
        $delivery_order['agency_name'] = $agency_name;
    }

    /* 取得用户名 */
    if ($delivery_order['user_id'] > 0)
    {
        $user = user_info($delivery_order['user_id']);
        if (!empty($user))
        {
            $delivery_order['user_name'] = $user['user_name'];
        }
    }

    /* 取得区域名 */
    $sql = "SELECT concat(IFNULL(c.region_name, ''), '  ', IFNULL(p.region_name, ''), " .
                "'  ', IFNULL(t.region_name, ''), '  ', IFNULL(d.region_name, '')) AS region " .
            "FROM " . $ecs->table('order_info') . " AS o " .
                "LEFT JOIN " . $ecs->table('region') . " AS c ON o.country = c.region_id " .
                "LEFT JOIN " . $ecs->table('region') . " AS p ON o.province = p.region_id " .
                "LEFT JOIN " . $ecs->table('region') . " AS t ON o.city = t.region_id " .
                "LEFT JOIN " . $ecs->table('region') . " AS d ON o.district = d.region_id " .
            "WHERE o.order_id = '" . $delivery_order['order_id'] . "'";
    $delivery_order['region'] = $db->getOne($sql);

    /* 是否保价 */
    $order['insure_yn'] = empty($order['insure_fee']) ? 0 : 1;

    /* 取得发货单商品 */
    $goods_sql = "SELECT *
                  FROM " . $ecs->table('delivery_goods') . "
                  WHERE delivery_id = " . $delivery_order['delivery_id'];
    $goods_list = $GLOBALS['db']->getAll($goods_sql);

    /* 是否存在实体商品 */
    $exist_real_goods = 0;
    if ($goods_list)
    {
        foreach ($goods_list as $value)
        {
            if ($value['is_real'])
            {
                $exist_real_goods++;
            }
        }
    }

    /* 取得订单操作记录 */
    $act_list = array();
    $sql = "SELECT * FROM " . $ecs->table('order_action') . " WHERE order_id = '" . $delivery_order['order_id'] . "' AND action_place = 1 ORDER BY log_time DESC,action_id DESC";
    $res = $db->query($sql);
    while ($row = $db->fetchRow($res))
    {
        $row['order_status']    = $_LANG['os'][$row['order_status']];
        $row['pay_status']      = $_LANG['ps'][$row['pay_status']];
        $row['shipping_status'] = ($row['shipping_status'] == SS_SHIPPED_ING) ? $_LANG['ss_admin'][SS_SHIPPED_ING] : $_LANG['ss'][$row['shipping_status']];
        $row['action_time']     = local_date($_CFG['time_format'], $row['log_time']);
        $act_list[] = $row;
    }
    $smarty->assign('action_list', $act_list);

    /* 模板赋值 */
    $smarty->assign('delivery_order', $delivery_order);
    $smarty->assign('exist_real_goods', $exist_real_goods);
    $smarty->assign('goods_list', $goods_list);
    $smarty->assign('delivery_id', $delivery_id); // 发货单id

    /* 显示模板 */
    $smarty->assign('ur_here', $_LANG['delivery_operate'] . $_LANG['detail']);
    $smarty->assign('action_link', array('href' => 'order.php?act=delivery_list&' . list_link_postfix(), 'text' => $_LANG['09_delivery_order']));
    $smarty->assign('action_act', ($delivery_order['status'] == 2) ? 'delivery_ship' : 'delivery_cancel_ship');
    assign_query_info();
    _wap_assign_header_info('发货单详情');
    _wap_assign_footer_order_info();
    _wap_display_page('delivery_info.htm');
}
elseif($act == 'remove_delivery')
{
    $delivery_id = empty($_REQUEST['delivery_id']) ? '' : trim($_REQUEST['delivery_id']);
    // 删除发货单

    // 查询：发货单信息
    $delivery_order = delivery_order_info($delivery_id);

    // 如果status不是退货
    if ($delivery_order['status'] != 1)
    {
        /* 处理退货 */
        delivery_return_goods($value_is, $delivery_order);
    }

    // 如果status是已发货并且发货单号不为空
    if ($delivery_order['status'] == 0 && $delivery_order['invoice_no'] != '')
    {
        /* 更新：删除订单中的发货单号 */
        del_order_invoice_no($delivery_order['order_id'], $delivery_order['invoice_no']);
    }

    // 更新：删除发货单
    $sql = "DELETE FROM ".$ecs->table('delivery_order'). " WHERE delivery_id = '$delivery_id'";
    $db->query($sql);

    /* 返回 */
    sys_msg($_LANG['tips_delivery_del'], 0, array(array('href'=>'order.php?act=delivery_list' , 'text' => $_LANG['return_list'])));
}
//发货单执行发货操作
elseif($act == 'delivery')
{
    $order_id = empty($_REQUEST['order_id']) ? '' : trim($_REQUEST['order_id']);
    $delivery_id = empty($_REQUEST['delivery_id']) ? '' : trim($_REQUEST['delivery_id']);
    $express_no = empty($_REQUEST['express_no']) ? '' : trim($_REQUEST['express_no']);
    delivery($order_id,$delivery_id,$express_no);
}
//发货单取消发货
elseif($act == 'cancel_delivery')
{
    $order_id = empty($_REQUEST['order_id']) ? '' : trim($_REQUEST['order_id']);
    $delivery_id = empty($_REQUEST['delivery_id']) ? '' : trim($_REQUEST['delivery_id']);
    cancel_delivery($order_id,$delivery_id);
}

/**
 *  获取订单列表信息
 *
 * @access  public
 * @param
 *
 * @return void
 */
function order_list()
{
    $result = get_filter();
    if ($result === false)
    {
        /* 过滤信息 */
        $filter['order_sn'] = empty($_REQUEST['order_sn']) ? '' : trim($_REQUEST['order_sn']);
        if (!empty($_GET['is_ajax']) && $_GET['is_ajax'] == 1)
        {
            $_REQUEST['consignee'] = json_str_iconv($_REQUEST['consignee']);
        }
        $filter['consignee'] = empty($_REQUEST['consignee']) ? '' : trim($_REQUEST['consignee']);
        $filter['email'] = empty($_REQUEST['email']) ? '' : trim($_REQUEST['email']);
        $filter['address'] = empty($_REQUEST['address']) ? '' : trim($_REQUEST['address']);
        $filter['zipcode'] = empty($_REQUEST['zipcode']) ? '' : trim($_REQUEST['zipcode']);
        $filter['tel'] = empty($_REQUEST['tel']) ? '' : trim($_REQUEST['tel']);
        $filter['mobile'] = empty($_REQUEST['mobile']) ? 0 : intval($_REQUEST['mobile']);
        $filter['country'] = empty($_REQUEST['country']) ? 0 : intval($_REQUEST['country']);
        $filter['province'] = empty($_REQUEST['province']) ? 0 : intval($_REQUEST['province']);
        $filter['city'] = empty($_REQUEST['city']) ? 0 : intval($_REQUEST['city']);
        $filter['district'] = empty($_REQUEST['district']) ? 0 : intval($_REQUEST['district']);
        $filter['shipping_id'] = empty($_REQUEST['shipping_id']) ? 0 : intval($_REQUEST['shipping_id']);
        $filter['pay_id'] = empty($_REQUEST['pay_id']) ? 0 : intval($_REQUEST['pay_id']);
        $filter['order_status'] = isset($_REQUEST['order_status']) ? intval($_REQUEST['order_status']) : -1;
        $filter['shipping_status'] = isset($_REQUEST['shipping_status']) ? intval($_REQUEST['shipping_status']) : -1;
        $filter['pay_status'] = isset($_REQUEST['pay_status']) ? intval($_REQUEST['pay_status']) : -1;
        $filter['user_id'] = empty($_REQUEST['user_id']) ? 0 : intval($_REQUEST['user_id']);
        $filter['user_name'] = empty($_REQUEST['user_name']) ? '' : trim($_REQUEST['user_name']);
        $filter['composite_status'] = isset($_REQUEST['composite_status']) ? intval($_REQUEST['composite_status']) : -1;
        $filter['group_buy_id'] = isset($_REQUEST['group_buy_id']) ? intval($_REQUEST['group_buy_id']) : 0;

        $filter['sort_by'] = empty($_REQUEST['sort_by']) ? 'add_time' : trim($_REQUEST['sort_by']);
        $filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);

        $filter['start_time'] = empty($_REQUEST['start_time']) ? '' : (strpos($_REQUEST['start_time'], '-') > 0 ?  local_strtotime($_REQUEST['start_time']) : $_REQUEST['start_time']);
        $filter['end_time'] = empty($_REQUEST['end_time']) ? '' : (strpos($_REQUEST['end_time'], '-') > 0 ?  local_strtotime($_REQUEST['end_time']) : $_REQUEST['end_time']);

        $where = "WHERE o.supplier_id='".$_SESSION['supplier_id']."' ";
        if ($filter['order_sn'])
        {
            $where .= " AND o.order_sn LIKE '%" . mysql_like_quote($filter['order_sn']) . "%'";
        }
        if ($filter['consignee'])
        {
            $where .= " AND o.consignee LIKE '%" . mysql_like_quote($filter['consignee']) . "%'";
        }
        if ($filter['email'])
        {
            $where .= " AND o.email LIKE '%" . mysql_like_quote($filter['email']) . "%'";
        }
        if ($filter['address'])
        {
            $where .= " AND o.address LIKE '%" . mysql_like_quote($filter['address']) . "%'";
        }
        if ($filter['zipcode'])
        {
            $where .= " AND o.zipcode LIKE '%" . mysql_like_quote($filter['zipcode']) . "%'";
        }
        if ($filter['tel'])
        {
            $where .= " AND o.tel LIKE '%" . mysql_like_quote($filter['tel']) . "%'";
        }
        if ($filter['mobile'])
        {
            $where .= " AND o.mobile LIKE '%" .mysql_like_quote($filter['mobile']) . "%'";
        }
        if ($filter['country'])
        {
            $where .= " AND o.country = '$filter[country]'";
        }
        if ($filter['province'])
        {
            $where .= " AND o.province = '$filter[province]'";
        }
        if ($filter['city'])
        {
            $where .= " AND o.city = '$filter[city]'";
        }
        if ($filter['district'])
        {
            $where .= " AND o.district = '$filter[district]'";
        }
        if ($filter['shipping_id'])
        {
            $where .= " AND o.shipping_id  = '$filter[shipping_id]'";
        }
        if ($filter['pay_id'])
        {
            $where .= " AND o.pay_id  = '$filter[pay_id]'";
        }
        if ($filter['order_status'] != -1)
        {
            $where .= " AND o.order_status  = '$filter[order_status]'";
        }
        if ($filter['shipping_status'] != -1)
        {
            $where .= " AND o.shipping_status = '$filter[shipping_status]'";
        }
        if ($filter['pay_status'] != -1)
        {
            $where .= " AND o.pay_status = '$filter[pay_status]'";
        }
        if ($filter['user_id'])
        {
            $where .= " AND o.user_id = '$filter[user_id]'";
        }
        if ($filter['user_name'])
        {
            $where .= " AND u.user_name LIKE '%" . mysql_like_quote($filter['user_name']) . "%'";
        }
        if ($filter['start_time'])
        {
            $where .= " AND o.add_time >= '$filter[start_time]'";
        }
        if ($filter['end_time'])
        {
            $where .= " AND o.add_time <= '$filter[end_time]'";
        }

        //综合状态
        switch($filter['composite_status'])
        {
            case CS_AWAIT_PAY :
                $where .= order_query_sql('await_pay');
                break;

            case CS_AWAIT_SHIP :
                $where .= order_query_sql('await_ship');
                break;

            case CS_FINISHED :
                $where .= order_query_sql('finished');
                break;

            case PS_PAYING :
                if ($filter['composite_status'] != -1)
                {
                    $where .= " AND o.pay_status = '$filter[composite_status]' ";
                }
                break;
            case OS_SHIPPED_PART :
                if ($filter['composite_status'] != -1)
                {
                    $where .= " AND o.shipping_status  = '$filter[composite_status]'-2 ";
                }
                break;
            default:
                if ($filter['composite_status'] != -1)
                {
                    $where .= " AND o.order_status = '$filter[composite_status]' ";
                }
        }

        /* 团购订单 */
        if ($filter['group_buy_id'])
        {
            $where .= " AND o.extension_code = 'group_buy' AND o.extension_id = '$filter[group_buy_id]' ";
        }

        /* 如果管理员属于某个办事处，只列出这个办事处管辖的订单 */
        $sql = "SELECT agency_id FROM " . $GLOBALS['ecs']->table('admin_user') . " WHERE user_id = '$_SESSION[admin_id]'";
        $agency_id = $GLOBALS['db']->getOne($sql);
        if ($agency_id > 0)
        {
            $where .= " AND o.agency_id = '$agency_id' ";
        }

        /* 分页大小 */
        $filter['page'] = empty($_REQUEST['page']) || (intval($_REQUEST['page']) <= 0) ? 1 : intval($_REQUEST['page']);

        if (isset($_REQUEST['page_size']) && intval($_REQUEST['page_size']) > 0)
        {
            $filter['page_size'] = intval($_REQUEST['page_size']);
        }
        elseif (isset($_COOKIE['ECSCP']['page_size']) && intval($_COOKIE['ECSCP']['page_size']) > 0)
        {
            $filter['page_size'] = intval($_COOKIE['ECSCP']['page_size']);
        }
        else
        {
            $filter['page_size'] = 15;
        }

        /* 记录总数 */
        if ($filter['user_name'])
        {
            $sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('order_info') . " AS o ,".
                   $GLOBALS['ecs']->table('users') . " AS u " . $where;
        }
        else
        {
            $sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('order_info') . " AS o ". $where;
        }

        $filter['record_count']   = $GLOBALS['db']->getOne($sql);
        $filter['page_count']     = $filter['record_count'] > 0 ? ceil($filter['record_count'] / $filter['page_size']) : 1;

        /* 查询 */
        $sql = "SELECT o.order_id, o.order_sn, o.add_time, o.order_status, o.shipping_status, o.order_amount, o.money_paid," .
                    "o.pay_status, o.consignee, o.address, o.email, o.tel, o.extension_code, o.extension_id, " .
                    "(" . order_amount_field('o.') . ") AS total_fee, " .
                    "IFNULL(u.user_name, '" .$GLOBALS['_LANG']['anonymous']. "') AS buyer ".
                " FROM " . $GLOBALS['ecs']->table('order_info') . " AS o " .
                " LEFT JOIN " .$GLOBALS['ecs']->table('users'). " AS u ON u.user_id=o.user_id ". $where .
                " ORDER BY $filter[sort_by] $filter[sort_order] ".
                " LIMIT " . ($filter['page'] - 1) * $filter['page_size'] . ",$filter[page_size]";

        foreach (array('order_sn', 'consignee', 'email', 'address', 'zipcode', 'tel', 'user_name') AS $val)
        {
            $filter[$val] = stripslashes($filter[$val]);
        }
        set_filter($filter, $sql);
    }
    else
    {
        $sql    = $result['sql'];
        $filter = $result['filter'];
    }

    $row = $GLOBALS['db']->getAll($sql);

    /* 格式话数据 */
    foreach ($row AS $key => $value)
    {
        $row[$key]['formated_order_amount'] = price_format($value['order_amount']);
        $row[$key]['formated_money_paid'] = price_format($value['money_paid']);
        $row[$key]['formated_total_fee'] = price_format($value['total_fee']);
        $row[$key]['short_order_time'] = local_date('m-d H:i', $value['add_time']);
        if ($value['order_status'] == OS_INVALID || $value['order_status'] == OS_CANCELED)
        {
            /* 如果该订单为无效或取消则显示删除链接 */
            $row[$key]['can_remove'] = 1;
        }
        else
        {
            $row[$key]['can_remove'] = 0;
        }
    }
    $arr = array('orders' => $row, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);

    return $arr;
}

/**
 *  获取发货单列表信息
 *
 * @access  public
 * @param
 *
 * @return void
 */
function delivery_list()
{
    $result = get_filter();
    if ($result === false)
    {
        $aiax = isset($_GET['is_ajax']) ? $_GET['is_ajax'] : 0;

        /* 过滤信息 */
        $filter['delivery_sn'] = empty($_REQUEST['delivery_sn']) ? '' : trim($_REQUEST['delivery_sn']);
        $filter['order_sn'] = empty($_REQUEST['order_sn']) ? '' : trim($_REQUEST['order_sn']);
        $filter['order_id'] = empty($_REQUEST['order_id']) ? 0 : intval($_REQUEST['order_id']);
        if ($aiax == 1 && !empty($_REQUEST['consignee']))
        {
            $_REQUEST['consignee'] = json_str_iconv($_REQUEST['consignee']);
        }
        $filter['consignee'] = empty($_REQUEST['consignee']) ? '' : trim($_REQUEST['consignee']);
        $filter['status'] = isset($_REQUEST['status']) ? $_REQUEST['status'] : -1;

        $filter['sort_by'] = empty($_REQUEST['sort_by']) ? 'update_time' : trim($_REQUEST['sort_by']);
        $filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);

        $where = "WHERE o.supplier_id='". $_SESSION['supplier_id'] ."' ";
        if ($filter['order_sn'])
        {
            $where .= " AND d.order_sn LIKE '%" . mysql_like_quote($filter['order_sn']) . "%'";
        }
        if ($filter['consignee'])
        {
            $where .= " AND d.consignee LIKE '%" . mysql_like_quote($filter['consignee']) . "%'";
        }
        if ($filter['status'] >= 0)
        {
            $where .= " AND d.status = '" . mysql_like_quote($filter['status']) . "'";
        }
        if ($filter['delivery_sn'])
        {
            $where .= " AND d.delivery_sn LIKE '%" . mysql_like_quote($filter['delivery_sn']) . "%'";
        }

        /* 获取管理员信息 */
        $admin_info = admin_info();

        /* 如果管理员属于某个办事处，只列出这个办事处管辖的发货单 */
        if ($admin_info['agency_id'] > 0)
        {
            $where .= " AND d.agency_id = '" . $admin_info['agency_id'] . "' ";
        }

        /* 如果管理员属于某个供货商，只列出这个供货商的发货单 */
        if ($admin_info['suppliers_id'] > 0)
        {
            $where .= " AND d.suppliers_id = '" . $admin_info['suppliers_id'] . "' ";
        }

        /* 分页大小 */
        $filter['page'] = empty($_REQUEST['page']) || (intval($_REQUEST['page']) <= 0) ? 1 : intval($_REQUEST['page']);

        if (isset($_REQUEST['page_size']) && intval($_REQUEST['page_size']) > 0)
        {
            $filter['page_size'] = intval($_REQUEST['page_size']);
        }
        elseif (isset($_COOKIE['ECSCP']['page_size']) && intval($_COOKIE['ECSCP']['page_size']) > 0)
        {
            $filter['page_size'] = intval($_COOKIE['ECSCP']['page_size']);
        }
        else
        {
            $filter['page_size'] = 15;
        }

        /* 记录总数 */
        $sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('delivery_order') . "AS d left join  ". $GLOBALS['ecs']->table('order_info')." AS o on d.order_id=o.order_id ". $where;
        $filter['record_count']   = $GLOBALS['db']->getOne($sql);
        $filter['page_count']     = $filter['record_count'] > 0 ? ceil($filter['record_count'] / $filter['page_size']) : 1;

        /* 查询 */
        $sql = "SELECT d.delivery_id, d.delivery_sn, d.order_sn, d.order_id, d.add_time, d.action_user, d.consignee, d.country,
                       d.province, d.city, d.district, d.tel, d.status, d.update_time, d.email, d.suppliers_id
                FROM " . $GLOBALS['ecs']->table("delivery_order") . " AS d left join ". $GLOBALS['ecs']->table("order_info") . " AS o on d.order_id=o.order_id 
                $where
                ORDER BY d." . $filter['sort_by'] . " " . $filter['sort_order']. "
                LIMIT " . ($filter['page'] - 1) * $filter['page_size'] . ", " . $filter['page_size'] . " ";

        set_filter($filter, $sql);
    }
    else
    {
        $sql    = $result['sql'];
        $filter = $result['filter'];
    }

    /* 获取供货商列表 */
    $suppliers_list = get_suppliers_list();
    $_suppliers_list = array();
    foreach ($suppliers_list as $value)
    {
        $_suppliers_list[$value['suppliers_id']] = $value['suppliers_name'];
    }

    $row = $GLOBALS['db']->getAll($sql);

    /* 格式化数据 */
    foreach ($row AS $key => $value)
    {
        $row[$key]['add_time'] = local_date($GLOBALS['_CFG']['time_format'], $value['add_time']);
        $row[$key]['update_time'] = local_date($GLOBALS['_CFG']['time_format'], $value['update_time']);
        if ($value['status'] == 1)
        {
            $row[$key]['status_name'] = $GLOBALS['_LANG']['delivery_status'][1];
        }
        elseif ($value['status'] == 2)
        {
            $row[$key]['status_name'] = $GLOBALS['_LANG']['delivery_status'][2];
        }
        else
        {
        $row[$key]['status_name'] = $GLOBALS['_LANG']['delivery_status'][0];
        }
        $row[$key]['suppliers_name'] = isset($_suppliers_list[$value['suppliers_id']]) ? $_suppliers_list[$value['suppliers_id']] : '';
    }
    $arr = array('delivery' => $row, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);

    return $arr;
}

/**
 * 取得发货单信息
 * @param   int     $delivery_order   发货单id（如果delivery_order > 0 就按id查，否则按sn查）
 * @param   string  $delivery_sn      发货单号
 * @return  array   发货单信息（金额都有相应格式化的字段，前缀是formated_）
 */
function delivery_order_info($delivery_id, $delivery_sn = '')
{
    $return_order = array();
    if (empty($delivery_id) || !is_numeric($delivery_id))
    {
        return $return_order;
    }

    $where = '';
    /* 获取管理员信息 */
    $admin_info = admin_info();

    /* 如果管理员属于某个办事处，只列出这个办事处管辖的发货单 */
    if ($admin_info['agency_id'] > 0)
    {
        $where .= " AND agency_id = '" . $admin_info['agency_id'] . "' ";
    }

    /* 如果管理员属于某个供货商，只列出这个供货商的发货单 */
    if ($admin_info['suppliers_id'] > 0)
    {
        $where .= " AND suppliers_id = '" . $admin_info['suppliers_id'] . "' ";
    }

    $sql = "SELECT * FROM " . $GLOBALS['ecs']->table('delivery_order');
    if ($delivery_id > 0)
    {
        $sql .= " WHERE delivery_id = '$delivery_id'";
    }
    else
    {
        $sql .= " WHERE delivery_sn = '$delivery_sn'";
    }

    $sql .= $where;
    $sql .= " LIMIT 0, 1";
    $delivery = $GLOBALS['db']->getRow($sql);
    if ($delivery)
    {
        /* 格式化金额字段 */
        $delivery['formated_insure_fee']     = price_format($delivery['insure_fee'], false);
        $delivery['formated_shipping_fee']   = price_format($delivery['shipping_fee'], false);

        /* 格式化时间字段 */
        $delivery['formated_add_time']       = local_date($GLOBALS['_CFG']['time_format'], $delivery['add_time']);
        $delivery['formated_update_time']    = local_date($GLOBALS['_CFG']['time_format'], $delivery['update_time']);

        $return_order = $delivery;
    }

    return $return_order;
}


function quick_delivery($order_id,$invoice_no,$action_note='Wap端一键发货')
{
    global $db,$ecs;
    if (!empty($invoice_no))
    {
        $order_id = intval(trim($order_id));

        $action_note = trim($action_note);

        /* 查询：根据订单id查询订单信息 */
        if (!empty($order_id))
        {
            $order = order_info($order_id);
        }
        else
        {
            die('order does not exist');
        }
        /* 查询：根据订单是否完成 检查权限 */
        if (order_finished($order))
        {
            admin_priv('order_view_finished');
        }
        else
        {
            admin_priv('order_view');
        }

        /* 查询：如果管理员属于某个办事处，检查该订单是否也属于这个办事处 */
        $sql = "SELECT agency_id FROM " . $ecs->table('supplier_admin_user') . " WHERE user_id = '$_SESSION[supplier_user_id]'";
        $agency_id = $db->getOne($sql);
        if ($agency_id > 0)
        {
            if ($order['agency_id'] != $agency_id)
            {
                sys_msg($_LANG['priv_error'], 0);
            }
        }
        /* 查询：取得用户名 */
        if ($order['user_id'] > 0)
        {
            $user = user_info($order['user_id']);
            if (!empty($user))
            {
                $order['user_name'] = $user['user_name'];
            }
        }
        /* 查询：取得区域名 */
        
        $order['region'] = $db->getOne($sql);

        /* 查询：其他处理 */
        $order['order_time']    = local_date($_CFG['time_format'], $order['add_time']);
        $order['invoice_no']    = $order['shipping_status'] == SS_UNSHIPPED || $order['shipping_status'] == SS_PREPARING ? $_LANG['ss'][SS_UNSHIPPED] : $order['invoice_no'];

	    /* 查询：是否保价 */
        $order['insure_yn'] = empty($order['insure_fee']) ? 0 : 1;
        /* 查询：是否存在实体商品 */
        $exist_real_goods = exist_real_goods($order_id);
        
		/* 查询：取得订单商品 */
        $_goods = get_order_goods(array('order_id' => $order['order_id'], 'order_sn' =>$order['order_sn']));

        $attr = $_goods['attr'];
        $goods_list = $_goods['goods_list'];
        unset($_goods);
	
        /* 查询：商品已发货数量 此单可发货数量 */
        if ($goods_list)
        {
			foreach ($goods_list as $key=>$goods_value)
            {
                if (!$goods_value['goods_id'])
                {
                    continue;
                }

                /* 超级礼包 */
                if (($goods_value['extension_code'] == 'package_buy') && (count($goods_value['package_goods_list']) > 0))
                {
                    $goods_list[$key]['package_goods_list'] = package_goods($goods_value['package_goods_list'], $goods_value['goods_number'], $goods_value['order_id'], $goods_value['extension_code'], $goods_value['goods_id']);

                    foreach ($goods_list[$key]['package_goods_list'] as $pg_key => $pg_value)
                    {
                        $goods_list[$key]['package_goods_list'][$pg_key]['readonly'] = '';
                        /* 使用库存 是否缺货 */
                        if ($pg_value['storage'] <= 0 && $_CFG['use_storage'] == '1' && $_CFG['stock_dec_time'] == SDT_SHIP)
                        {
                            $goods_list[$key]['package_goods_list'][$pg_key]['send'] = $_LANG['act_good_vacancy'];
                            $goods_list[$key]['package_goods_list'][$pg_key]['readonly'] = 'readonly="readonly"';
                        }
                        /* 将已经全部发货的商品设置为只读 */
                        elseif ($pg_value['send'] <= 0)
                        {
                            $goods_list[$key]['package_goods_list'][$pg_key]['send'] = $_LANG['act_good_delivery'];
                            $goods_list[$key]['package_goods_list'][$pg_key]['readonly'] = 'readonly="readonly"';
                        }
                    }
                }
                else
                {
                    $goods_list[$key]['sended'] = $goods_value['send_number'];
                    $goods_list[$key]['sended'] = $goods_value['goods_number'];
                    $goods_list[$key]['send'] = $goods_value['goods_number'] - $goods_value['send_number'];
					$goods_list[$key]['readonly'] = '';
                    /* 是否缺货 */
                    if ($goods_value['storage'] <= 0 && $_CFG['use_storage'] == '1'  && $_CFG['stock_dec_time'] == SDT_SHIP)
                    {
                        $goods_list[$key]['send'] = $_LANG['act_good_vacancy'];
                        $goods_list[$key]['readonly'] = 'readonly="readonly"';
                    }
                    elseif ($goods_list[$key]['send'] <= 0)
                    {
                        $goods_list[$key]['send'] = $_LANG['act_good_delivery'];
                        $goods_list[$key]['readonly'] = 'readonly="readonly"';
                    }
                }
            }
        }
		
		$suppliers_id = 0;
		
		$delivery['order_sn'] = trim($order['order_sn']);
		$delivery['add_time'] = trim($order['order_time']);
		$delivery['user_id'] = intval(trim($order['user_id']));
		$delivery['how_oos'] = trim($order['how_oos']);
		$delivery['shipping_id'] = trim($order['shipping_id']);
		$delivery['shipping_fee'] = trim($order['shipping_fee']);
		$delivery['consignee'] = trim($order['consignee']);
		$delivery['address'] = trim($order['address']);
		$delivery['country'] = intval(trim($order['country']));
		$delivery['province'] = intval(trim($order['province']));
		$delivery['city'] = intval(trim($order['city']));
		$delivery['district'] = intval(trim($order['district']));
		$delivery['sign_building'] = trim($order['sign_building']);
		$delivery['email'] = trim($order['email']);
		$delivery['zipcode'] = trim($order['zipcode']);
		$delivery['tel'] = trim($order['tel']);
		$delivery['mobile'] = trim($order['mobile']);
		$delivery['best_time'] = trim($order['best_time']);
		$delivery['postscript'] = trim($order['postscript']);
		$delivery['how_oos'] = trim($order['how_oos']);
		$delivery['insure_fee'] = floatval(trim($order['insure_fee']));
		$delivery['shipping_fee'] = floatval(trim($order['shipping_fee']));
		$delivery['agency_id'] = intval(trim($order['agency_id']));
		$delivery['shipping_name'] = trim($order['shipping_name']);

    /* 查询订单信息 */
    $order = order_info($order_id);
    /* 检查能否操作 */
    $operable_list = operable_list($order);
	
    /* 初始化提示信息 */
   $msg = '';

		/* 定义当前时间 */
       

        /* 取得订单商品 */
        $_goods = get_order_goods(array('order_id' => $order_id, 'order_sn' => $delivery['order_sn']));
        $goods_list = $_goods['goods_list'];
	

		        /* 检查此单发货商品库存缺货情况 */
        /* $goods_list已经过处理 超值礼包中商品库存已取得 */
        $virtual_goods = array();
        $package_virtual_goods = array();
        /* 生成发货单 */
        /* 获取发货单号和流水号 */
        $delivery['delivery_sn'] = get_delivery_sn();
        $delivery_sn = $delivery['delivery_sn'];

        /* 获取当前操作员 */
        $delivery['action_user'] = $_SESSION['supplier_name'];

        /* 获取发货单生成时间 */
 	define('GMTIME_UTC', gmtime()); 
        $delivery['update_time'] = GMTIME_UTC;
        $delivery_time = $delivery['update_time'];
        $sql ="select add_time from ". $GLOBALS['ecs']->table('order_info') ." WHERE order_sn = '" . $delivery['order_sn'] . "'";
        $delivery['add_time'] =  $GLOBALS['db']->GetOne($sql);
        /* 获取发货单所属供应商 */
        $delivery['suppliers_id'] = $suppliers_id;

        /* 设置默认值 */
        $delivery['status'] = 2; // 正常
        $delivery['order_id'] = $order_id;

        /* 过滤字段项 */
        $filter_fileds = array(
                               'order_sn', 'add_time', 'user_id', 'how_oos', 'shipping_id', 'shipping_fee',
                               'consignee', 'address', 'country', 'province', 'city', 'district', 'sign_building',
                               'email', 'zipcode', 'tel', 'mobile', 'best_time', 'postscript', 'insure_fee',
                               'agency_id', 'delivery_sn', 'action_user', 'update_time',
                               'suppliers_id', 'status', 'order_id', 'shipping_name'
                               );
        $_delivery = array();
        foreach ($filter_fileds as $value)
        {
            $_delivery[$value] = $delivery[$value];
        }
        /* 发货单入库 */
        $query = $db->autoExecute($ecs->table('delivery_order'), $_delivery, 'INSERT', '', 'SILENT');
        $delivery_id = $db->insert_id();
        if ($delivery_id)
        {

            $delivery_goods = array();
			
            //发货单商品入库
            if (!empty($goods_list))
            {
                foreach ($goods_list as $value)
                {
                    // 商品（实货）（虚货）
                    if (empty($value['extension_code']) || $value['extension_code'] == 'virtual_card')
                    {
                        $delivery_goods = array('delivery_id' => $delivery_id,
                                                'goods_id' => $value['goods_id'],
                                                'product_id' => $value['product_id'],
                                                'product_sn' => $value['product_sn'],
                                                'goods_id' => $value['goods_id'],
                                                'goods_name' => $value['goods_name'],
                                                'brand_name' => $value['brand_name'],
                                                'goods_sn' => $value['goods_sn'],
                                                'send_number' => $value['goods_number'],
                                                'parent_id' => 0,
                                                'is_real' => $value['is_real'],
                                                'goods_attr' => $value['goods_attr']
                                                );
                        /* 如果是货品 */
                        if (!empty($value['product_id']))
                        {
                            $delivery_goods['product_id'] = $value['product_id'];

                        }
                        $query = $db->autoExecute($ecs->table('delivery_goods'), $delivery_goods, 'INSERT', '', 'SILENT');
						$sql = "UPDATE ".$GLOBALS['ecs']->table('order_goods'). "
                SET send_number = " . $value['goods_number'] . "
                WHERE order_id = '" . $value['order_id'] . "'
                AND goods_id = '" . $value['goods_id'] . "' ";
                $GLOBALS['db']->query($sql, 'SILENT');
                    }
                    // 商品（超值礼包）
                    elseif ($value['extension_code'] == 'package_buy')
                    {
                        foreach ($value['package_goods_list'] as $pg_key => $pg_value)
                        {
                            $delivery_pg_goods = array('delivery_id' => $delivery_id,
                                                    'goods_id' => $pg_value['goods_id'],
                                                    'product_id' => $pg_value['product_id'],
                                                    'product_sn' => $pg_value['product_sn'],
                                                    'goods_name' => $pg_value['goods_name'],
                                                    'brand_name' => '',
                                                    'goods_sn' => $pg_value['goods_sn'],
                                                    'send_number' => $value['goods_number'],
                                                    'parent_id' => $value['goods_id'], // 礼包ID
                                                    'extension_code' => $value['extension_code'], // 礼包
                                                    'is_real' => $pg_value['is_real']
                                                    );
                            $query = $db->autoExecute($ecs->table('delivery_goods'), $delivery_pg_goods, 'INSERT', '', 'SILENT');
							$sql = "UPDATE ".$GLOBALS['ecs']->table('order_goods'). "
                SET send_number = " . $value['goods_number'] . "
                WHERE order_id = '" . $value['order_id'] . "'
                AND goods_id = '" . $pg_value['goods_id'] . "' ";
                $GLOBALS['db']->query($sql, 'SILENT');
                        }
                    }
                }
            }
        }
        else
        {
            /* 操作失败 */
            $links[] = array('text' => $_LANG['order_info'], 'href' => 'order.php?act=info&order_id=' . $order_id);
            sys_msg($_LANG['act_false'], 1, $links);
        }
        unset($filter_fileds, $delivery, $_delivery, $order_finish);

        /* 定单信息更新处理 */
        if (true)
        {

            /* 标记订单为已确认 "发货中" */
            /* 更新发货时间 */
            $order_finish = get_order_finish($order_id);
            $shipping_status = SS_SHIPPED_ING;
            if ($order['order_status'] != OS_CONFIRMED && $order['order_status'] != OS_SPLITED && $order['order_status'] != OS_SPLITING_PART)
            {
                $arr['order_status']    = OS_CONFIRMED;
                $arr['confirm_time']    = GMTIME_UTC;
            }
            $arr['order_status'] = $order_finish ? OS_SPLITED : OS_SPLITING_PART; // 全部分单、部分分单
            $arr['shipping_status']     = $shipping_status;
            update_order($order_id, $arr);
		}

        /* 记录log */
        order_action($order['order_sn'], $arr['order_status'], $shipping_status, $order['pay_status'], $action_note);

        /* 清除缓存 */
        clear_cache_files();

	/* 根据发货单id查询发货单信息 */
    if (!empty($delivery_id))
    {
        $delivery_order = delivery_order_info($delivery_id);
    }
	elseif (!empty($order_sn))
    {

		$delivery_id = $GLOBALS['db']->getOne("SELECT delivery_id FROM " . $ecs->table('delivery_order') . " WHERE order_sn = " . $order_sn );
        $delivery_order = delivery_order_info($delivery_id);
    }
    else
    {
        die('order does not exist');
    }

    /* 如果管理员属于某个办事处，检查该订单是否也属于这个办事处 */
    $sql = "SELECT agency_id FROM " . $ecs->table('supplier_admin_user') . " WHERE user_id = '" . $_SESSION['supplier_user_id'] . "'";
    $agency_id = $db->getOne($sql);
    if ($agency_id > 0)
    {
        if ($delivery_order['agency_id'] != $agency_id)
        {
            sys_msg($_LANG['priv_error']);
        }

        /* 取当前办事处信息 */
        $sql = "SELECT agency_name FROM " . $ecs->table('agency') . " WHERE agency_id = '$agency_id' LIMIT 0, 1";
        $agency_name = $db->getOne($sql);
        $delivery_order['agency_name'] = $agency_name;
    }

    /* 取得用户名 */
    if ($delivery_order['user_id'] > 0)
    {
        $user = user_info($delivery_order['user_id']);
        if (!empty($user))
        {
            $delivery_order['user_name'] = $user['user_name'];
        }
    }

    /* 取得区域名 */
    $sql = "SELECT concat(IFNULL(c.region_name, ''), '  ', IFNULL(p.region_name, ''), " .
                "'  ', IFNULL(t.region_name, ''), '  ', IFNULL(d.region_name, '')) AS region " .
            "FROM " . $ecs->table('order_info') . " AS o " .
                "LEFT JOIN " . $ecs->table('region') . " AS c ON o.country = c.region_id " .
                "LEFT JOIN " . $ecs->table('region') . " AS p ON o.province = p.region_id " .
                "LEFT JOIN " . $ecs->table('region') . " AS t ON o.city = t.region_id " .
                "LEFT JOIN " . $ecs->table('region') . " AS d ON o.district = d.region_id " .
            "WHERE o.order_id = '" . $delivery_order['order_id'] . "'";
    $delivery_order['region'] = $db->getOne($sql);

    /* 是否保价 */
    $order['insure_yn'] = empty($order['insure_fee']) ? 0 : 1;

    /* 取得发货单商品 */
    $goods_sql = "SELECT *
                  FROM " . $ecs->table('delivery_goods') . "
                  WHERE delivery_id = " . $delivery_order['delivery_id'];
    $goods_list = $GLOBALS['db']->getAll($goods_sql);

    /* 是否存在实体商品 */
    $exist_real_goods = 0;
    if ($goods_list)
    {
        foreach ($goods_list as $value)
        {
            if ($value['is_real'])
            {
                $exist_real_goods++;
            }
        }
    }

    /* 取得订单操作记录 */
    $act_list = array();
    $sql = "SELECT * FROM " . $ecs->table('order_action') . " WHERE order_id = '" . $delivery_order['order_id'] . "' AND action_place = 1 ORDER BY log_time DESC,action_id DESC";
    $res = $db->query($sql);
    while ($row = $db->fetchRow($res))
    {
        $row['order_status']    = $_LANG['os'][$row['order_status']];
        $row['pay_status']      = $_LANG['ps'][$row['pay_status']];
        $row['shipping_status'] = ($row['shipping_status'] == SS_SHIPPED_ING) ? $_LANG['ss_admin'][SS_SHIPPED_ING] : $_LANG['ss'][$row['shipping_status']];
        $row['action_time']     = local_date($_CFG['time_format'], $row['log_time']);
        $act_list[] = $row;
    }

	/*同步发货*/
	/*判断支付方式是否支付宝*/
	$alipay    = false;
	$order     = order_info($delivery_order['order_id']);  //根据订单ID查询订单信息，返回数组$order
	$payment   = payment_info($order['pay_id']);           //取得支付方式信息

    /* 定义当前时间 */
    define('GMTIME_UTC', gmtime()); // 获取 UTC 时间戳

    /* 根据发货单id查询发货单信息 */
    if (!empty($delivery_id))
    {
        $delivery_order = delivery_order_info($delivery_id);
    }
    else
    {
        die('order does not exist');
    }

    /* 查询订单信息 */
    $order = order_info($order_id);

    /* 检查此单发货商品库存缺货情况 */
    $virtual_goods = array();
    $delivery_stock_sql = "SELECT DG.goods_id, DG.is_real, DG.product_id, SUM(DG.send_number) AS sums, IF(DG.product_id > 0, P.product_number, G.goods_number) AS storage, G.goods_name,DG.goods_attr, DG.send_number
        FROM " . $GLOBALS['ecs']->table('delivery_goods') . " AS DG, " . $GLOBALS['ecs']->table('goods') . " AS G, " . $GLOBALS['ecs']->table('products') . " AS P
        WHERE DG.goods_id = G.goods_id
        AND DG.delivery_id = '$delivery_id'
        AND DG.product_id = P.product_id
        GROUP BY DG.product_id ";

    $delivery_stock_result = $GLOBALS['db']->getAll($delivery_stock_sql);

    /* 如果商品存在规格就查询规格，如果不存在规格按商品库存查询 */
    if(!empty($delivery_stock_result))
    {
        foreach ($delivery_stock_result as $value)
        {
            if (($value['sums'] > $value['storage'] || $value['storage'] <= 0) && (($_CFG['use_storage'] == '1'  && $_CFG['stock_dec_time'] == SDT_SHIP) || ($_CFG['use_storage'] == '0' && $value['is_real'] == 0)))
            {
                /* 操作失败 */
                $links[] = array('text' => $_LANG['order_info'], 'href' => 'order.php?act=delivery_info&delivery_id=' . $delivery_id);
                sys_msg(sprintf($_LANG['act_good_vacancy'], $value['goods_name']), 1, $links);
                break;
            }

            /* 虚拟商品列表 virtual_card*/
            if ($value['is_real'] == 0)
            {
                $virtual_goods[] = array(
                               'goods_id' => $value['goods_id'],
                               'goods_name' => $value['goods_name'],
                               'num' => $value['send_number']
                               );
            }
        }
    }
    else
    {
        $delivery_stock_sql = "SELECT DG.goods_id, DG.is_real, SUM(DG.send_number) AS sums, G.goods_number, G.goods_name,DG.goods_attr, DG.send_number
        FROM " . $GLOBALS['ecs']->table('delivery_goods') . " AS DG, " . $GLOBALS['ecs']->table('goods') . " AS G
        WHERE DG.goods_id = G.goods_id
        AND DG.delivery_id = '$delivery_id'
        GROUP BY DG.goods_id ";
        $delivery_stock_result = $GLOBALS['db']->getAll($delivery_stock_sql);
        foreach ($delivery_stock_result as $value)
        {
            if (($value['sums'] > $value['goods_number'] || $value['goods_number'] <= 0) && (($_CFG['use_storage'] == '1'  && $_CFG['stock_dec_time'] == SDT_SHIP) || ($_CFG['use_storage'] == '0' && $value['is_real'] == 0)))
            {
                /* 操作失败 */
                $links[] = array('text' => $_LANG['order_info'], 'href' => 'order.php?act=delivery_info&delivery_id=' . $delivery_id);
                sys_msg(sprintf($_LANG['act_good_vacancy'], $value['goods_name']), 1, $links);
                break;
            }

            /* 虚拟商品列表 virtual_card*/
            if ($value['is_real'] == 0)
            {
                $virtual_goods[] = array(
                               'goods_id' => $value['goods_id'],
                               'goods_name' => $value['goods_name'],
                               'num' => $value['send_number'],
                               );
            }
        }
    }

    /* 发货 */
    /* 处理虚拟卡 商品（虚货） */
    if (is_array($virtual_goods) && count($virtual_goods) > 0)
    {
        foreach ($virtual_goods as $virtual_value)
        {
            virtual_card_shipping($virtual_value,$order['order_sn'], $msg, 'split');
        }
    }

    /* 如果使用库存，且发货时减库存，则修改库存 */
    /*if ($_CFG['use_storage'] == '1' && $_CFG['stock_dec_time'] == SDT_SHIP)
    {

        foreach ($delivery_stock_result as $value)
        {

            // 商品（实货）、超级礼包（实货） 
            if ($value['is_real'] != 0)
            {
                //（货品）
                if (!empty($value['product_id']))
                {
                    $minus_stock_sql = "UPDATE " . $GLOBALS['ecs']->table('products') . "
                                        SET product_number = product_number - " . $value['sums'] . "
                                        WHERE product_id = " . $value['product_id'];
                    $GLOBALS['db']->query($minus_stock_sql, 'SILENT');
                }

                $minus_stock_sql = "UPDATE " . $GLOBALS['ecs']->table('goods') . "
                                    SET goods_number = goods_number - " . $value['sums'] . "
                                    WHERE goods_id = " . $value['goods_id'];

                $GLOBALS['db']->query($minus_stock_sql, 'SILENT');
            }
        }
    }

    /* 修改发货单信息 */
    $invoice_no = trim($invoice_no);
    $_delivery['invoice_no'] = $invoice_no;
    $_delivery['status'] = 0; // 0，为已发货
    $query = $db->autoExecute($ecs->table('delivery_order'), $_delivery, 'UPDATE', "delivery_id = $delivery_id", 'SILENT');
    if (!$query)
    {
        /* 操作失败 */
        $links[] = array('text' => $_LANG['delivery_sn'] . $_LANG['detail'], 'href' => 'order.php?act=delivery_info&delivery_id=' . $delivery_id);
        sys_msg($_LANG['act_false'], 1, $links);
    }

    /* 标记订单为已确认 "已发货" */
    /* 更新发货时间 */
    $order_finish = get_all_delivery_finish($order_id);
    $shipping_status = ($order_finish == 1) ? SS_SHIPPED : SS_SHIPPED_PART;
    $arr['shipping_status']     = $shipping_status;
    $arr['shipping_time']       = GMTIME_UTC; // 发货时间
    $arr['invoice_no']          = trim($order['invoice_no'] . '<br>' . $invoice_no, '<br>');
    update_order($order_id, $arr);

    /* 发货单发货记录log */
    order_action($order['order_sn'], OS_CONFIRMED, $shipping_status, $order['pay_status'], $action_note, null, 1);
    /* 如果当前订单已经全部发货 */
    if ($order_finish)
    {
        /* 如果订单用户不为空，计算积分，并发给用户；发红包 */
        if ($order['user_id'] > 0)
        {
            /* 取得用户信息 */
            $user = user_info($order['user_id']);

            /* 计算并发放积分 */
            $integral = integral_to_give($order);

            log_account_change($order['user_id'], 0, 0, intval($integral['rank_points']), intval($integral['custom_points']), sprintf($_LANG['order_gift_integral'], $order['order_sn']));

            /* 发放红包 */
            send_order_bonus($order_id,$order['supplier_id']);
        }

        /* 发送邮件 */
        $cfg = $_CFG['send_ship_email'];
        if ($cfg == '1')
        {
            $order['invoice_no'] = $invoice_no;
            $tpl = get_mail_template('deliver_notice');
            $smarty->assign('order', $order);
            $smarty->assign('send_time', local_date($_CFG['time_format']));
            $smarty->assign('shop_name', $_CFG['shop_name']);
            $smarty->assign('send_date', local_date($_CFG['date_format']));
            $smarty->assign('sent_date', local_date($_CFG['date_format']));
            $smarty->assign('confirm_url', $ecs->url() . 'receive.php?id=' . $order['order_id'] . '&con=' . rawurlencode($order['consignee']));
            $smarty->assign('send_msg_url',$ecs->url() . 'user.php?act=message_list&order_id=' . $order['order_id']);
            $content = $smarty->fetch('str:' . $tpl['template_content']);
            if (!send_mail($order['consignee'], $order['email'], $tpl['template_subject'], $content, $tpl['is_html']))
            {
                $msg = $_LANG['send_mail_fail'];
            }
        }

        /* 如果需要，发短信 */
        if ($GLOBALS['_CFG']['sms_order_shipped'] == '1' && $order['mobile'] != '')
        {
            include_once('../send.php');
				$content = '您的订单已发货，订单号为'.$order['order_sn'].'收货人为'.$order['consignee'].'收货地址为'.$order['address'].'，请注意查收【'.$GLOBALS['_CFG']['shop_name'].'】';
				sendSMS($order['mobile'],$content);
        }
    }

    /* 清除缓存 */
    clear_cache_files();

    /* 操作成功 */
    $links[] = array('text' => '发货单列表', 'href' => 'order.php?act=delivery_list');
    $links[] = array('text' => $_LANG['delivery_sn'] . $_LANG['detail'], 'href' => 'order.php?act=delivery_info&delivery_id=' . $delivery_id);
    sys_msg($_LANG['act_ok'], 0, $links);
	
    }
}

function delivery($order_id,$deliery_id,$express_no)
{
     /* 定义当前时间 */
    define('GMTIME_UTC', gmtime()); // 获取 UTC 时间戳

    /* 取得参数 */
    $delivery   = array();
    $delivery['invoice_no'] = $express_no;
    $action_note    = isset($_REQUEST['action_note']) ? trim($_REQUEST['action_note']) : '';

    /* 根据发货单id查询发货单信息 */
    if (!empty($delivery_id))
    {
        $delivery_order = delivery_order_info($delivery_id);
    }
    else
    {
        die('order does not exist');
    }

    /* 查询订单信息 */
    $order = order_info($order_id);

    /* 检查此单发货商品库存缺货情况 */
    $virtual_goods = array();
    $delivery_stock_sql = "SELECT DG.goods_id, DG.is_real, DG.product_id, SUM(DG.send_number) AS sums, IF(DG.product_id > 0, P.product_number, G.goods_number) AS storage, G.goods_name, DG.send_number
        FROM " . $GLOBALS['ecs']->table('delivery_goods') . " AS DG, " . $GLOBALS['ecs']->table('goods') . " AS G, " . $GLOBALS['ecs']->table('products') . " AS P
        WHERE DG.goods_id = G.goods_id
        AND DG.delivery_id = '$delivery_id'
        AND DG.product_id = P.product_id
        GROUP BY DG.product_id ";

    $delivery_stock_result = $GLOBALS['db']->getAll($delivery_stock_sql);

    /* 如果商品存在规格就查询规格，如果不存在规格按商品库存查询 */
    if(!empty($delivery_stock_result))
    {
        foreach ($delivery_stock_result as $value)
        {
            if (($value['sums'] > $value['storage'] || $value['storage'] <= 0) && (($_CFG['use_storage'] == '1'  && $_CFG['stock_dec_time'] == SDT_SHIP) || ($_CFG['use_storage'] == '0' && $value['is_real'] == 0)))
            {
                /* 操作失败 */
                $links[] = array('text' => $GLOBALS['_LANG']['order_info'], 'href' => 'order.php?act=delivery_info&delivery_id=' . $delivery_id);
                sys_msg(sprintf($GLOBALS['_LANG']['act_good_vacancy'], $value['goods_name']), 1, $links);
                break;
            }

            /* 虚拟商品列表 virtual_card*/
            if ($value['is_real'] == 0)
            {
                $virtual_goods[] = array(
                               'goods_id' => $value['goods_id'],
                               'goods_name' => $value['goods_name'],
                               'num' => $value['send_number']
                               );
            }
        }
    }
    else
    {
        $delivery_stock_sql = "SELECT DG.goods_id, DG.is_real, SUM(DG.send_number) AS sums, G.goods_number, G.goods_name, DG.send_number
        FROM " . $GLOBALS['ecs']->table('delivery_goods') . " AS DG, " . $GLOBALS['ecs']->table('goods') . " AS G
        WHERE DG.goods_id = G.goods_id
        AND DG.delivery_id = '$delivery_id'
        GROUP BY DG.goods_id ";
        $delivery_stock_result = $GLOBALS['db']->getAll($delivery_stock_sql);
        foreach ($delivery_stock_result as $value)
        {
            if (($value['sums'] > $value['goods_number'] || $value['goods_number'] <= 0) && (($_CFG['use_storage'] == '1'  && $_CFG['stock_dec_time'] == SDT_SHIP) || ($_CFG['use_storage'] == '0' && $value['is_real'] == 0)))
            {
                /* 操作失败 */
                $links[] = array('text' => $GLOBALS['_LANG']['order_info'], 'href' => 'order.php?act=delivery_info&delivery_id=' . $delivery_id);
                sys_msg(sprintf($GLOBALS['_LANG']['act_good_vacancy'], $value['goods_name']), 1, $links);
                break;
            }

            /* 虚拟商品列表 virtual_card*/
            if ($value['is_real'] == 0)
            {
                $virtual_goods[] = array(
                               'goods_id' => $value['goods_id'],
                               'goods_name' => $value['goods_name'],
                               'num' => $value['send_number']
                               );
            }
        }
    }

    /* 发货 */
    /* 处理虚拟卡 商品（虚货） */
    if (is_array($virtual_goods) && count($virtual_goods) > 0)
    {
        foreach ($virtual_goods as $virtual_value)
        {
            virtual_card_shipping($virtual_value,$order['order_sn'], $msg, 'split');
        }
    }

    /* 如果使用库存，且发货时减库存，则修改库存 */
    if ($_CFG['use_storage'] == '1' && $_CFG['stock_dec_time'] == SDT_SHIP)
    {

        foreach ($delivery_stock_result as $value)
        {

            /* 商品（实货）、超级礼包（实货） */
            if ($value['is_real'] != 0)
            {
                //（货品）
                if (!empty($value['product_id']))
                {
                    $minus_stock_sql = "UPDATE " . $GLOBALS['ecs']->table('products') . "
                                        SET product_number = product_number - " . $value['sums'] . "
                                        WHERE product_id = " . $value['product_id'];
                    $GLOBALS['db']->query($minus_stock_sql, 'SILENT');
                }

                $minus_stock_sql = "UPDATE " . $GLOBALS['ecs']->table('goods') . "
                                    SET goods_number = goods_number - " . $value['sums'] . "
                                    WHERE goods_id = " . $value['goods_id'];

                $GLOBALS['db']->query($minus_stock_sql, 'SILENT');
            }
        }
    }

    /* 修改发货单信息 */
    $invoice_no = str_replace(',', '<br>', $delivery['invoice_no']);
    $invoice_no = trim($invoice_no, '<br>');
    $_delivery['invoice_no'] = $invoice_no;
    $_delivery['status'] = 0; // 0，为已发货
    $query = $db->autoExecute($ecs->table('delivery_order'), $_delivery, 'UPDATE', "delivery_id = $delivery_id", 'SILENT');
    if (!$query)
    {
        /* 操作失败 */
        $links[] = array('text' => $GLOBALS['_LANG']['delivery_sn'] . $GLOBALS['_LANG']['detail'], 'href' => 'order.php?act=delivery_info&delivery_id=' . $delivery_id);
        sys_msg($GLOBALS['_LANG']['act_false'], 1, $links);
    }

    /* 标记订单为已确认 “已发货” */
    /* 更新发货时间 */
    $order_finish = get_all_delivery_finish($order_id);
    $shipping_status = ($order_finish == 1) ? SS_SHIPPED : SS_SHIPPED_PART;
    $arr['shipping_status']     = $shipping_status;
    $arr['shipping_time']       = GMTIME_UTC; // 发货时间
    $arr['invoice_no']          = trim($order['invoice_no'] . '<br>' . $invoice_no, '<br>');
    update_order($order_id, $arr);

    /* 发货单发货记录log */
    order_action($order['order_sn'], OS_CONFIRMED, $shipping_status, $order['pay_status'], $action_note, null, 1);

    /* 如果当前订单已经全部发货 */
    if ($order_finish)
    {
        /* 如果订单用户不为空，计算积分，并发给用户；发红包 */
        if ($order['user_id'] > 0)
        {
            /* 取得用户信息 */
            $user = user_info($order['user_id']);

            /* 计算并发放积分 */
            $integral = integral_to_give($order);

            log_account_change($order['user_id'], 0, 0, intval($integral['rank_points']), intval($integral['custom_points']), sprintf($GLOBALS['_LANG']['order_gift_integral'], $order['order_sn']));

            /* 发放红包 */
            send_order_bonus($order_id,$order['supplier_id']);
        }

        /* 发送邮件 */
        $cfg = $_CFG['send_ship_email'];
        if ($cfg == '1')
        {
            $order['invoice_no'] = $invoice_no;
            $tpl = get_mail_template('deliver_notice');
            $smarty->assign('order', $order);
            $smarty->assign('send_time', local_date($_CFG['time_format']));
            $smarty->assign('shop_name', $_CFG['shop_name']);
            $smarty->assign('send_date', local_date($_CFG['date_format']));
            $smarty->assign('sent_date', local_date($_CFG['date_format']));
            $smarty->assign('confirm_url', $ecs->url() . 'receive.php?id=' . $order['order_id'] . '&con=' . rawurlencode($order['consignee']));
            $smarty->assign('send_msg_url',$ecs->url() . 'user.php?act=message_list&order_id=' . $order['order_id']);
            $content = $smarty->fetch('str:' . $tpl['template_content']);
            if (!send_mail($order['consignee'], $order['email'], $tpl['template_subject'], $content, $tpl['is_html']))
            {
                $msg = $GLOBALS['_LANG']['send_mail_fail'];
            }
        }

		/* 如果需要，发短信 */
        if ($GLOBALS['_CFG']['sms_order_shipped'] == '1' && $order['mobile'] != '')
        {
            include_once('../send.php');
				$content = '您的订单已发货，订单号为'.$order['order_sn'].'收货人为'.$order['consignee'].'收货地址为'.$order['address'].'，请注意查收【'.$GLOBALS['_CFG']['shop_name'].'】';
				sendSMS($order['mobile'],$content);
        }
    }

    /* 清除缓存 */
    clear_cache_files();

    /* 操作成功 */
    $links[] = array('text' => $GLOBALS['_LANG']['09_delivery_order'], 'href' => 'order.php?act=delivery_list');
    $links[] = array('text' => $GLOBALS['_LANG']['delivery_sn'] . $GLOBALS['_LANG']['detail'], 'href' => 'order.php?act=delivery_info&delivery_id=' . $delivery_id);
    sys_msg($GLOBALS['_LANG']['act_ok'], 0, $links);
}


function cancel_delivery($order_id,$delivery_id)
{
    global $db,$ecs;
    /* 取得参数 */
    $delivery = '';

    /* 根据发货单id查询发货单信息 */
    if (!empty($delivery_id))
    {
        $delivery_order = delivery_order_info($delivery_id);
    }
    else
    {
        sys_msg('订单号不能为空！',1);
    }

    /* 查询订单信息 */
    $order = order_info($order_id);

    /* 取消当前发货单物流单号 */
    $_delivery['invoice_no'] = '';
    $_delivery['status'] = 2;
    $query = $db->autoExecute($ecs->table('delivery_order'), $_delivery, 'UPDATE', "delivery_id = $delivery_id", 'SILENT');
    if (!$query)
    {
        /* 操作失败 */
        $links[] = array('text' => $GLOBALS['_LANG']['delivery_sn'] . $GLOBALS['_LANG']['detail'], 'href' => 'order.php?act=delivery_info&delivery_id=' . $delivery_id);
        sys_msg($GLOBALS['_LANG']['act_false'], 1, $links);
        exit;
    }

    /* 修改定单发货单号 */
    $invoice_no_order = explode('<br>', $order['invoice_no']);
    $invoice_no_delivery = explode('<br>', $delivery_order['invoice_no']);
    foreach ($invoice_no_order as $key => $value)
    {
        $delivery_key = array_search($value, $invoice_no_delivery);
        if ($delivery_key !== false)
        {
            unset($invoice_no_order[$key], $invoice_no_delivery[$delivery_key]);
            if (count($invoice_no_delivery) == 0)
            {
                break;
            }
        }
    }
    $_order['invoice_no'] = implode('<br>', $invoice_no_order);

    /* 更新配送状态 */
    $order_finish = get_all_delivery_finish($order_id);
    $shipping_status = ($order_finish == -1) ? SS_SHIPPED_PART : SS_SHIPPED_ING;
    $arr['shipping_status']     = $shipping_status;
    if ($shipping_status == SS_SHIPPED_ING)
    {
        $arr['shipping_time']   = ''; // 发货时间
    }
    $arr['invoice_no']          = $_order['invoice_no'];
    update_order($order_id, $arr);

    /* 发货单取消发货记录log */
    order_action($order['order_sn'], $order['order_status'], $shipping_status, $order['pay_status'], $action_note, null, 1);

    /* 如果使用库存，则增加库存 */
    if ($_CFG['use_storage'] == '1' && $_CFG['stock_dec_time'] == SDT_SHIP)
    {
        // 检查此单发货商品数量
        $virtual_goods = array();
        $delivery_stock_sql = "SELECT DG.goods_id, DG.product_id, DG.is_real, SUM(DG.send_number) AS sums
            FROM " . $GLOBALS['ecs']->table('delivery_goods') . " AS DG
            WHERE DG.delivery_id = '$delivery_id'
            GROUP BY DG.goods_id ";
        $delivery_stock_result = $GLOBALS['db']->getAll($delivery_stock_sql);
        foreach ($delivery_stock_result as $key => $value)
        {
            /* 虚拟商品 */
            if ($value['is_real'] == 0)
            {
                continue;
            }

            //（货品）
            if (!empty($value['product_id']))
            {
                $minus_stock_sql = "UPDATE " . $GLOBALS['ecs']->table('products') . "
                                    SET product_number = product_number + " . $value['sums'] . "
                                    WHERE product_id = " . $value['product_id'];
                $GLOBALS['db']->query($minus_stock_sql, 'SILENT');
            }

            $minus_stock_sql = "UPDATE " . $GLOBALS['ecs']->table('goods') . "
                                SET goods_number = goods_number + " . $value['sums'] . "
                                WHERE goods_id = " . $value['goods_id'];
            $GLOBALS['db']->query($minus_stock_sql, 'SILENT');
        }
    }

    /* 发货单全退回时，退回其它 */
    if ($order['order_status'] == SS_SHIPPED_ING)
    {
        /* 如果订单用户不为空，计算积分，并退回 */
        if ($order['user_id'] > 0)
        {
            /* 取得用户信息 */
            $user = user_info($order['user_id']);

            /* 计算并退回积分 */
            $integral = integral_to_give($order);
            log_account_change($order['user_id'], 0, 0, (-1) * intval($integral['rank_points']), (-1) * intval($integral['custom_points']), sprintf($GLOBALS['_LANG']['return_order_gift_integral'], $order['order_sn']));

            /* todo 计算并退回红包 */
            return_order_bonus($order_id);
        }
    }
    /* 清除缓存 */
    clear_cache_files();
    /* 操作成功 */
    $links[] = array('text' => $GLOBALS['_LANG']['delivery_sn'] . $GLOBALS['_LANG']['detail'], 'href' => 'order.php?act=delivery_info&delivery_id=' . $delivery_id);
    sys_msg($GLOBALS['_LANG']['act_ok'], 0, $links);
}

/**
 * 取得订单商品
 * @param   array     $order  订单数组
 * @return array
 */
function get_order_goods($order)
{
    $goods_list = array();
    $goods_attr = array();
    $sql = "SELECT o.*, g.suppliers_id AS suppliers_id,IF(o.product_id > 0, p.product_number, g.goods_number) AS storage, o.goods_attr, IFNULL(b.brand_name, '') AS brand_name, p.product_sn " .
            "FROM " . $GLOBALS['ecs']->table('order_goods') . " AS o ".
            "LEFT JOIN " . $GLOBALS['ecs']->table('products') . " AS p ON o.product_id = p.product_id " .
            "LEFT JOIN " . $GLOBALS['ecs']->table('goods') . " AS g ON o.goods_id = g.goods_id " .
            "LEFT JOIN " . $GLOBALS['ecs']->table('brand') . " AS b ON g.brand_id = b.brand_id " .
            "WHERE o.order_id = '$order[order_id]' ";
    $res = $GLOBALS['db']->query($sql);
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        // 虚拟商品支持
        if ($row['is_real'] == 0)
        {
            /* 取得语言项 */
            $filename = ROOT_PATH . 'plugins/' . $row['extension_code'] . '/languages/common_' . $GLOBALS['_CFG']['lang'] . '.php';
            if (file_exists($filename))
            {
                include_once($filename);
                if (!empty($GLOBALS['_LANG'][$row['extension_code'].'_link']))
                {
                    $row['goods_name'] = $row['goods_name'] . sprintf($GLOBALS['_LANG'][$row['extension_code'].'_link'], $row['goods_id'], $order['order_sn']);
                }
            }
        }

        $row['formated_subtotal']       = price_format($row['goods_price'] * $row['goods_number']);
        $row['formated_goods_price']    = price_format($row['goods_price']);

        $goods_attr[] = explode(' ', trim($row['goods_attr'])); //将商品属性拆分为一个数组

        if ($row['extension_code'] == 'package_buy')
        {
            $row['storage'] = '';
            $row['brand_name'] = '';
            $row['package_goods_list'] = get_package_goods_list($row['goods_id']);
        }

        //处理货品id
        $row['product_id'] = empty($row['product_id']) ? 0 : $row['product_id'];

        $goods_list[] = $row;
    }

    $attr = array();
    $arr  = array();
    foreach ($goods_attr AS $index => $array_val)
    {
        foreach ($array_val AS $value)
        {
            $arr = explode(':', $value);//以 : 号将属性拆开
            $attr[$index][] =  @array('name' => $arr[0], 'value' => $arr[1]);
        }
    }

    return array('goods_list' => $goods_list, 'attr' => $attr);
}

/**
 * 返回某个订单可执行的操作列表，包括权限判断
 * @param   array   $order      订单信息 order_status, shipping_status, pay_status
 * @param   bool    $is_cod     支付方式是否货到付款
 * @return  array   可执行的操作  confirm, pay, unpay, prepare, ship, unship, receive, cancel, invalid, return, drop
 * 格式 array('confirm' => true, 'pay' => true)
 */
function operable_list($order)
{
    /* 取得订单状态、发货状态、付款状态 */
    $os = $order['order_status'];
    $ss = $order['shipping_status'];
    $ps = $order['pay_status'];
    /* 取得订单操作权限 */
    $actions = 'all';
    if ($actions == 'all')
    {
        $priv_list  = array('os' => true, 'ss' => true, 'ps' => true, 'edit' => true);
    }
    else
    {
        $actions    = ',' . $actions . ',';
        $priv_list  = array(
            'os'    => strpos($actions, ',order_os_edit,') !== false,
            'ss'    => strpos($actions, ',order_ss_edit,') !== false,
            'ps'    => strpos($actions, ',order_ps_edit,') !== false,
            'edit'  => strpos($actions, ',order_edit,') !== false
        );
    }
    /* 取得订单支付方式是否货到付款 */
    $payment = payment_info($order['pay_id']);
    $is_cod  = $payment['is_cod'] == 1;

    /* 根据状态返回可执行操作 */
    $list = array();
    if (OS_UNCONFIRMED == $os)
    {
        /* 状态：未确认 => 未付款、未发货 */
        if ($priv_list['os'])
        {
            $list['confirm']    = true; // 确认
            $list['invalid']    = true; // 无效
            $list['cancel']     = true; // 取消
            if ($is_cod)
            {
                /* 货到付款 */
                if ($priv_list['ss'])
                {
                    $list['prepare'] = true; // 配货
                    $list['split'] = true; // 分单
                }
            }
            else
            {
                /* 不是货到付款 */
                if ($priv_list['ps'])
                {
                    $list['pay'] = true;  // 付款
                }
            }
        }
    }
    elseif (OS_CONFIRMED == $os || OS_SPLITED == $os || OS_SPLITING_PART == $os)
    {
        /* 状态：已确认 */
        if (PS_UNPAYED == $ps)
        {
            /* 状态：已确认、未付款 */
            if (SS_UNSHIPPED == $ss || SS_PREPARING == $ss)
            {
                /* 状态：已确认、未付款、未发货（或配货中） */
                if ($priv_list['os'])
                {
                    $list['cancel'] = true; // 取消
                    $list['invalid'] = true; // 无效
                }
                if ($is_cod)
                {
                    /* 货到付款 */
                    if ($priv_list['ss'])
                    {
                        if (SS_UNSHIPPED == $ss)
                        {
                            $list['prepare'] = true; // 配货
                        }
                        $list['split'] = true; // 分单
                    }
                }
                else
                {
                    /* 不是货到付款 */
                    if ($priv_list['ps'])
                    {
                        $list['pay'] = true; // 付款
                    }
                }
            }
            /* 状态：已确认、未付款、发货中 */
            elseif (SS_SHIPPED_ING == $ss || SS_SHIPPED_PART == $ss)
            {
                // 部分分单
                if (OS_SPLITING_PART == $os)
                {
                    $list['split'] = true; // 分单
                }
                $list['to_delivery'] = true; // 去发货
            }
            else
            {
                /* 状态：已确认、未付款、已发货或已收货 => 货到付款 */
                if ($priv_list['ps'])
                {
                    $list['pay'] = true; // 付款
                }
                if ($priv_list['ss'])
                {
                    if (SS_SHIPPED == $ss)
                    {
                        $list['receive'] = true; // 收货确认
                    }
                    $list['unship'] = true; // 设为未发货
                    if ($priv_list['os'])
                    {
                        $list['return'] = true; // 退货
                    }
                }
            }
        }
        else
        {
            /* 状态：已确认、已付款和付款中 */
            if (SS_UNSHIPPED == $ss || SS_PREPARING == $ss)
            {
                /* 状态：已确认、已付款和付款中、未发货（配货中） => 不是货到付款 */
                if ($priv_list['ss'])
                {
                    if (SS_UNSHIPPED == $ss)
                    {
                        $list['prepare'] = true; // 配货
                    }
                    $list['split'] = true; // 分单
                }
                if ($priv_list['ps'])
                {
                    $list['unpay'] = true; // 设为未付款
                    if ($priv_list['os'])
                    {
                        $list['cancel'] = true; // 取消
                    }
                }
            }
            /* 状态：已确认、未付款、发货中 */
            elseif (SS_SHIPPED_ING == $ss || SS_SHIPPED_PART == $ss)
            {
                // 部分分单
                if (OS_SPLITING_PART == $os)
                {
                    $list['split'] = true; // 分单
                }
                $list['to_delivery'] = true; // 去发货
            }
            else
            {
                /* 状态：已确认、已付款和付款中、已发货或已收货 */
                if ($priv_list['ss'])
                {
                    if (SS_SHIPPED == $ss)
                    {
                        $list['receive'] = true; // 收货确认
                    }
                    if (!$is_cod)
                    {
                        $list['unship'] = true; // 设为未发货
                    }
                }
                if ($priv_list['ps'] && $is_cod)
                {
                    $list['unpay']  = true; // 设为未付款
                }
                if ($priv_list['os'] && $priv_list['ss'] && $priv_list['ps'])
                {
                    $list['return'] = true; // 退货（包括退款）
                }
            }
        }
    }
    elseif (OS_CANCELED == $os)
    {
        /* 状态：取消 */
        if ($priv_list['os'])
        {
            $list['confirm'] = true;
        }
        if ($priv_list['edit'])
        {
            $list['remove'] = true;
        }
    }
    elseif (OS_INVALID == $os)
    {
        /* 状态：无效 */
        if ($priv_list['os'])
        {
            $list['confirm'] = true;
        }
        if ($priv_list['edit'])
        {
            $list['remove'] = true;
        }
    }
    elseif (OS_RETURNED == $os)
    {
        /* 状态：退货 */
        if ($priv_list['os'])
        {
            $list['confirm'] = true;
        }
    }

    /* 修正发货操作 */
    if (!empty($list['split']))
    {
        /* 如果是团购活动且未处理成功，不能发货 */
        if ($order['extension_code'] == 'group_buy')
        {
            include_once(ROOT_PATH . 'includes/lib_goods.php');
            $group_buy = group_buy_info(intval($order['extension_id']));
            if ($group_buy['status'] != GBS_SUCCEED)
            {
                unset($list['split']);
                unset($list['to_delivery']);
            }
        }

        /* 如果部分发货 不允许 取消 订单 */
        if (order_deliveryed($order['order_id']))
        {
            $list['return'] = true; // 退货（包括退款）
            unset($list['cancel']); // 取消
        }
    }

    /* 售后 */
    $list['after_service'] = true;

    return $list;
}

/**
 * 判断订单是否已发货（含部分发货）
 * @param   int     $order_id  订单 id
 * @return  int     1，已发货；0，未发货
 */
function order_deliveryed($order_id)
{
    $return_res = 0;

    if (empty($order_id))
    {
        return $return_res;
    }

    $sql = 'SELECT COUNT(delivery_id)
            FROM ' . $GLOBALS['ecs']->table('delivery_order') . '
            WHERE order_id = \''. $order_id . '\'
            AND status = 0';
    $sum = $GLOBALS['db']->getOne($sql);

    if ($sum)
    {
        $return_res = 1;
    }

    return $return_res;
}

/**
 * 订单中的商品是否已经全部发货
 * @param   int     $order_id  订单 id
 * @return  int     1，全部发货；0，未全部发货
 */
function get_order_finish($order_id)
{
    $return_res = 0;

    if (empty($order_id))
    {
        return $return_res;
    }

    $sql = 'SELECT COUNT(rec_id)
            FROM ' . $GLOBALS['ecs']->table('order_goods') . '
            WHERE order_id = \'' . $order_id . '\'
            AND goods_number > send_number';

    $sum = $GLOBALS['db']->getOne($sql);
    if (empty($sum))
    {
        $return_res = 1;
    }

    return $return_res;
}

/**
 * 判断订单的发货单是否全部发货
 * @param   int     $order_id  订单 id
 * @return  int     1，全部发货；0，未全部发货；-1，部分发货；-2，完全没发货；
 */
function get_all_delivery_finish($order_id)
{
    $return_res = 0;

    if (empty($order_id))
    {
        return $return_res;
    }

    /* 未全部分单 */
    if (!get_order_finish($order_id))
    {
        return $return_res;
    }
    /* 已全部分单 */
    else
    {
        // 是否全部发货
        $sql = "SELECT COUNT(delivery_id)
                FROM " . $GLOBALS['ecs']->table('delivery_order') . "
                WHERE order_id = '$order_id'
                AND status = 2 ";
        $sum = $GLOBALS['db']->getOne($sql);
        // 全部发货
        if (empty($sum))
        {
            $return_res = 1;
        }
        // 未全部发货
        else
        {
            /* 订单全部发货中时：当前发货单总数 */
            $sql = "SELECT COUNT(delivery_id)
            FROM " . $GLOBALS['ecs']->table('delivery_order') . "
            WHERE order_id = '$order_id'
            AND status <> 1 ";
            $_sum = $GLOBALS['db']->getOne($sql);
            if ($_sum == $sum)
            {
                $return_res = -2; // 完全没发货
            }
            else
            {
                $return_res = -1; // 部分发货
            }
        }
    }

    return $return_res;
}


/**
 * 删除发货单时进行退货
 *
 * @access   public
 * @param    int     $delivery_id      发货单id
 * @param    array   $delivery_order   发货单信息数组
 *
 * @return  void
 */
function delivery_return_goods($delivery_id, $delivery_order)
{
    /* 查询：取得发货单商品 */
    $goods_sql = "SELECT *
                 FROM " . $GLOBALS['ecs']->table('delivery_goods') . "
                 WHERE delivery_id = " . $delivery_order['delivery_id'];
    $goods_list = $GLOBALS['db']->getAll($goods_sql);
    /* 更新： */
    foreach ($goods_list as $key=>$val)
    {
        $sql = "UPDATE " . $GLOBALS['ecs']->table('order_goods') .
               " SET send_number = send_number-'".$goods_list[$key]['send_number']. "'".
               " WHERE order_id = '".$delivery_order['order_id']."' AND goods_id = '".$goods_list[$key]['goods_id']."' LIMIT 1";
        $GLOBALS['db']->query($sql);
    }
    $sql = "UPDATE " . $GLOBALS['ecs']->table('order_info') .
           " SET shipping_status = '0' , order_status = 1".
           " WHERE order_id = '".$delivery_order['order_id']."' LIMIT 1";
    $GLOBALS['db']->query($sql);
}

/**
 * 删除发货单时删除其在订单中的发货单号
 *
 * @access   public
 * @param    int      $order_id              定单id
 * @param    string   $delivery_invoice_no   发货单号
 *
 * @return  void
 */
function del_order_invoice_no($order_id, $delivery_invoice_no)
{
    /* 查询：取得订单中的发货单号 */
    $sql = "SELECT invoice_no
            FROM " . $GLOBALS['ecs']->table('order_info') . "
            WHERE order_id = '$order_id'";
    $order_invoice_no = $GLOBALS['db']->getOne($sql);

    /* 如果为空就结束处理 */
    if (empty($order_invoice_no))
    {
        return;
    }

    /* 去除当前发货单号 */
    $order_array = explode('<br>', $order_invoice_no);
    $delivery_array = explode('<br>', $delivery_invoice_no);

    foreach ($order_array as $key => $invoice_no)
    {
        if ($ii = array_search($invoice_no, $delivery_array))
        {
            unset($order_array[$key], $delivery_array[$ii]);
        }
    }

    $arr['invoice_no'] = implode('<br>', $order_array);
    update_order($order_id, $arr);
}


/**
 * 更新订单对应的 pay_log
 * 如果未支付，修改支付金额；否则，生成新的支付log
 * @param   int     $order_id   订单id
 */
function update_pay_log($order_id)
{
    $order_id = intval($order_id);
    if ($order_id > 0)
    {
        $sql = "SELECT order_amount FROM " . $GLOBALS['ecs']->table('order_info') .
                " WHERE order_id = '$order_id'";
        $order_amount = $GLOBALS['db']->getOne($sql);
        if (!is_null($order_amount))
        {
            $sql = "SELECT log_id FROM " . $GLOBALS['ecs']->table('pay_log') .
                    " WHERE order_id = '$order_id'" .
                    " AND order_type = '" . PAY_ORDER . "'" .
                    " AND is_paid = 0";
            $log_id = intval($GLOBALS['db']->getOne($sql));
            if ($log_id > 0)
            {
                /* 未付款，更新支付金额 */
                $sql = "UPDATE " . $GLOBALS['ecs']->table('pay_log') .
                        " SET order_amount = '$order_amount' " .
                        "WHERE log_id = '$log_id' LIMIT 1";
            }
            else
            {
                /* 已付款，生成新的pay_log */
                $sql = "INSERT INTO " . $GLOBALS['ecs']->table('pay_log') .
                        " (order_id, order_amount, order_type, is_paid)" .
                        "VALUES('$order_id', '$order_amount', '" . PAY_ORDER . "', 0)";
            }
            $GLOBALS['db']->query($sql);
        }
    }
}

/**
 * 处理编辑订单时订单金额变动
 * @param   array   $order  订单信息
 * @param   array   $msgs   提示信息
 * @param   array   $links  链接信息
 */
function handle_order_money_change($order, &$msgs, &$links)
{
    $order_id = $order['order_id'];
    if ($order['pay_status'] == PS_PAYED || $order['pay_status'] == PS_PAYING)
    {
        /* 应付款金额 */
        $money_dues = $order['order_amount'];
        if ($money_dues > 0)
        {
            /* 修改订单为未付款 */
            update_order($order_id, array('pay_status' => PS_UNPAYED, 'pay_time' => 0));
            $msgs[]     = $GLOBALS['_LANG']['amount_increase'];
            $links[]    = array('text' => $GLOBALS['_LANG']['order_info'], 'href' => 'order.php?act=info&order_id=' . $order_id);
        }
        elseif ($money_dues < 0)
        {
            $anonymous  = $order['user_id'] > 0 ? 0 : 1;
            $msgs[]     = $GLOBALS['_LANG']['amount_decrease'];
            $links[]    = array('text' => $GLOBALS['_LANG']['refund'], 'href' => 'order.php?act=process&func=load_refund&anonymous=' .
                $anonymous . '&order_id=' . $order_id . '&refund_amount=' . abs($money_dues));
        }
    }
}
/**
 * 取得供货商列表
 * @return array    二维数组
 */
function get_suppliers_list()
{
    $sql = 'SELECT *
            FROM ' . $GLOBALS['ecs']->table('suppliers') . '
            WHERE is_check = 1
            ORDER BY suppliers_name ASC';
    $res = $GLOBALS['db']->getAll($sql);

    if (!is_array($res))
    {
        $res = array();
    }

    return $res;
}
/**
 * 更新订单总金额
 * @param   int     $order_id   订单id
 * @return  bool
 */
function update_order_amount($order_id)
{
    include_once(ROOT_PATH . 'includes/lib_order.php');
    //更新订单总金额
    $sql = "UPDATE " . $GLOBALS['ecs']->table('order_info') .
            " SET order_amount = " . order_due_field() .
            " WHERE order_id = '$order_id' LIMIT 1";

    return $GLOBALS['db']->query($sql);
}

