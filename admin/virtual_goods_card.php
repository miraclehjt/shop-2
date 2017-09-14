<?php

/**
 * 鸿宇多用户商城 虚拟卡商品管理程序
 * ============================================================================
 * 版权所有 2015-2016 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: sunlizhi $
 * $Id: virtual_card.php 17217 2015-07-19 06:29:08Z sunlizhi $
 */

define('IN_ECS', true);

/* 包含文件 */
require(dirname(__FILE__) . '/includes/init.php');
require_once(ROOT_PATH . 'includes/lib_code.php');
require_once(ROOT_PATH . 'includes/lib_order.php');


/*------------------------------------------------------ */
//-- 补货处理
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'replenish')
{
    assign_query_info();

    /* 检查权限 */
    admin_priv('virualcard');
    /* 验证goods_id是否合法 */
    if (empty($_REQUEST['goods_id']))
    {
        $link[] = array('text'=>$_LANG['go_back'],'href'=>'virtual_goods_card.php?act=list');
        sys_msg($_LANG['replenish_no_goods_id'], 1, $link);
    }
    else
    {
        $goods_name = $db->GetOne("SELECT goods_name From ".$ecs->table('goods')." WHERE goods_id='".$_REQUEST['goods_id']."' AND is_real = 0 AND extension_code='virtual_card' ");
        if (empty($goods_name))
        {
            $link[] = array('text'=>$_LANG['go_back'],'href'=>'virtual_goods_card.php?act=list');
            sys_msg($_LANG['replenish_no_get_goods_name'],1, $link);
        }
    }

    $card = array('goods_id'=>$_REQUEST['goods_id'],'goods_name'=>$goods_name, 'end_date'=>date('Y-m-d', strtotime('+1 year')));
    $smarty->assign('card', $card);

    $smarty->assign('ur_here', $_LANG['replenish']);
    $smarty->assign('action_link', array('text'=>$_LANG['go_list'], 'href'=>'virtual_goods_card.php?act=card&goods_id='.$card['goods_id']));
    $smarty->display('virtual_goods_card_info.htm');
}

/*------------------------------------------------------ */
//-- 编辑补货信息
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'edit_replenish')
{
    /* 检查权限 */
    admin_priv('virualcard');
    /* 获取卡片信息 */
    $sql = "SELECT T1.card_id, T1.goods_id, T2.goods_name,T1.card_sn,  T1.end_date  FROM ".
            $ecs->table('virtual_goods_card')." AS T1, ".$ecs->table('goods')." AS T2 ".
            "WHERE T1.goods_id = T2.goods_id AND T1.card_id = '$_REQUEST[card_id]'";
    $card = $db->GetRow($sql);
   
    $card['card_sn']=str_mid_replace($card['card_sn']);         
    $smarty->assign('ur_here',     $_LANG['replenish']);
    $smarty->assign('action_link', array('text'=>'返回虚拟券列表', 'href'=>'virtual_goods_card.php?act=all_card'));
    $smarty->assign('card',        $card);
    $smarty->display('virtual_goods_card_info.htm');
}

elseif ($_REQUEST['act'] == 'action')
{
    /* 检查权限 */
    admin_priv('virualcard');

    $_POST['card_sn'] = trim($_POST['card_sn']);

    /* 加密后的 */
    $coded_card_sn       = $_POST['card_sn'];
    $coded_old_card_sn   = $_POST['old_card_sn'];
   // $coded_old_card_sn = jiami($_POST['old_card_sn']);
    /* 在前后两次card_sn不一致时，检查是否有重复记录,一致时直接更新数据 */
    if ($_POST['card_sn'] != $_POST['old_card_sn'])
    {
        $sql = "SELECT count(*) FROM ".$ecs->table('virtual_goods_card')." WHERE goods_id='".$_POST['goods_id']."' AND card_sn='$coded_card_sn'";

        if ($db->GetOne($sql) > 0)
        {
             $link[] = array('text'=>$_LANG['go_back'], 'href'=>'virtual_goods_card.php?act=replenish&goods_id='.$_POST['goods_id']);
             sys_msg(sprintf($_LANG['card_sn_exist'],$_POST['card_sn']),1,$link);
        }
    }

    /* 如果old_card_sn不存在则新加一条记录 */
    if (empty($_POST['old_card_sn']))
    {
        /* 插入一条新记录 */
        $end_date = strtotime($_POST['end_dateYear'] . "-" . $_POST['end_dateMonth'] . "-" . $_POST['end_dateDay']);
        $add_date = gmtime();
        $sql = "INSERT INTO ".$ecs->table('virtual_goods_card')." (goods_id, card_sn,  end_date, add_date ) ".
               "VALUES ('$_POST[goods_id]', '$coded_card_sn', '$end_date', '$add_date' )";
        $db->query($sql);

        /* 如果添加成功且原卡号为空时商品库存加1 */
        if (empty($_POST['old_card_sn']))
        {
            $sql = "UPDATE ".$ecs->table('goods')." SET goods_number= goods_number+1 WHERE goods_id='$_POST[goods_id]'";
            $db->query($sql);
        }

        $link[] = array('text'=>$_LANG['go_list'], 'href'=>'virtual_goods_card.php?act=card&goods_id='.$_POST['goods_id']);
        $link[] = array('text'=>$_LANG['continue_add'], 'href'=>'virtual_goods_card.php?act=replenish&goods_id='.$_POST['goods_id']);
        sys_msg($_LANG['action_success'], 0, $link);
    }
    else
    {
        /* 更新数据 */
        $end_date = strtotime($_POST['end_dateYear'] . "-" . $_POST['end_dateMonth'] . "-" . $_POST['end_dateDay']);
        $sql = "UPDATE ".$ecs->table('virtual_goods_card')." SET card_sn='$coded_card_sn', end_date='$end_date' ".
               "WHERE card_id='$_POST[card_id]'";
        $db->query($sql);

        $link[] = array('text'=>$_LANG['go_list'], 'href'=>'virtual_goods_card.php?act=card&goods_id='.$_POST['goods_id']);
        $link[] = array('text'=>$_LANG['continue_add'], 'href'=>'virtual_goods_card.php?act=replenish&goods_id='.$_POST['goods_id']);
        sys_msg($_LANG['action_success'], 0, $link);
    }

}
/*------------------------------------------------------ */
//-- 订单列表　卡号惟一列表
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'card')
{
    /* 检查权限 */
    admin_priv('virualcard');

    /* 验证goods_id是否合法 */
    if (empty($_REQUEST['goods_id']))
    {
       // $link[] = array('text'=>$_LANG['go_back'],'href'=>'virtual_goods_card.php?act=list');
       // sys_msg($_LANG['replenish_no_goods_id'], 1, $link);
    }
    else
    {
        $goods_name = $db->GetOne("SELECT goods_name From ".$ecs->table('goods')." WHERE goods_id='".$_REQUEST['goods_id']."' AND is_real = 0 AND extension_code='virtual_card' ");
        if (empty($goods_name))
        {
            $link[] = array('text'=>$_LANG['go_back'],'href'=>'virtual_goods_card.php?act=list');
            sys_msg($_LANG['replenish_no_get_goods_name'],1, $link);
        }
    }

    if (empty($_REQUEST['order_sn']))
    {
        $_REQUEST['order_sn'] = '';
    }

    $smarty->assign('goods_id',     $_REQUEST['goods_id']);
    $smarty->assign('full_page',    1);
    $smarty->assign('lang',         $_LANG);
    $smarty->assign('ur_here',      $goods_name);
  //  $smarty->assign('action_link',  array('text'    => $_LANG['replenish'],
  //   'href'  => 'virtual_goods_card.php?act=replenish&goods_id='.$_REQUEST['goods_id']));
    $smarty->assign('goods_id',      $_REQUEST['goods_id']);

    $list = get_replenish_list();

    $smarty->assign('card_list',    $list['item']);
    $smarty->assign('filter',       $list['filter']);
    $smarty->assign('record_count', $list['record_count']);
    $smarty->assign('page_count',   $list['page_count']);

    $sort_flag = sort_flag($list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);
    assign_query_info();
    $smarty->display('virtual_goods_card_list.htm');
}



elseif ($_REQUEST['act'] == 'all_card')
{
    /* 检查权限 */
    admin_priv('virualcard');

    if (empty($_REQUEST['order_sn']))
    {
        $_REQUEST['order_sn'] = '';
    }

    $smarty->assign('full_page',    1);
    $smarty->assign('lang',         $_LANG);

   // $list = get_replenish_list();
    $list = get_virtual_order_list();
    $supplier = get_supplier_list();
    $smarty->assign('supplier',$supplier);
    $smarty->assign('order_list',    $list['item']);
    $smarty->assign('filter',       $list['filter']);
    $smarty->assign('record_count', $list['record_count']);
    $smarty->assign('page_count',   $list['page_count']);
    $smarty->assign('ur_here', $_LANG['virtual_order_list']);
    $sort_flag = sort_flag($list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    assign_query_info();
    $smarty->display('virtual_goods_card_list.htm');
}

/*
 * 虚拟商品验证显示验证信息列表
 */
if($_REQUEST['act']=='verification_info'){
    $supplier_id = 0 ;
    $card_sn = trim($_REQUEST['verification']);
    if(!empty($card_sn)){
        $sql = "select v.*,g.goods_name,g.goods_thumb,g.shop_price from ".$ecs->table('virtual_goods_card')."as v left join ".$ecs->table('goods')." as g on v.goods_id= g.goods_id where v.card_sn = '$card_sn' and v.is_saled = 1 and v.supplier_id = $supplier_id";
        $res = $db -> getRow($sql);
        if($res){
        $res['end_date'] = local_date('Y-m-d',$res['end_date']);
        $res['buy_date'] = empty($res['buy_date'])?'未使用':local_date('Y-m-d',$res['buy_date']);
        $res['is_verification'] = $res['is_verification']==1?'已验证':'未验证';
        }else{
             $res['msg'] = '0';
        }
        $smarty -> assign('result',$res);
    }
    $smarty->assign('ur_here', $_LANG['virtual_verification']);
    $smarty -> display("virtual_validate.htm");
}
/*
 * 虚拟商品验证
 */
if($_REQUEST['act']=='verification'){
    $supplier_id = 0;
    $result = array();
    $card_sn = trim($_REQUEST['verification']);
    
    $now = time();
    if(!empty($card_sn)){
        $result['card_sn'] = $card_sn;
        $sql = "select * from ".$ecs->table('virtual_goods_card')." where card_sn = '$card_sn' and is_saled = 1 and supplier_id = $supplier_id";
        $res = $db -> getRow($sql);
        $end_date = ($res['end_date']/1000+86400)*1000;
        if($res){
            if($res['is_verification'] == '0'){

                if($end_date >= $now){
                    $result['msg'] = '1';
                    $result['is_verification'] = $_LANG['message']['verification_success'];
                    $sql = "update ".$ecs->table('virtual_goods_card')." set is_verification = 1 , buy_date = ".time()." where card_sn = '$card_sn'";
                    $db -> query($sql);
                    /* 改变订单状态 */
                    $sql = "select count(*) from ".$ecs->table('virtual_goods_card')." where card_sn = '$card_sn' and  supplier_id = $supplier_id and is_verification=1";
                    if($db->getOne($sql)){
                        $sql = "update ".$ecs->table('order_info')." set order_status = '5', shipping_status = '2' , shipping_time_end = ".time()." where order_sn = '$res[order_sn]'";
                    }else{
                        $sql = "update ".$ecs->table('order_info')." set shipping_status = '2' , shipping_time_end = ".time()." where order_sn = '$res[order_sn]'";
                    }
                    $db -> query($sql);
                }else{
                    $result['msg'] = '3';
                    $result['is_verification'] = $_LANG['message']['verification_overdue'];
                }
            }else{
                 $result['msg'] = '2';
                 $result['is_verification'] = $_LANG['message']['verification_used'];
            }
        }else{
            $result['msg'] = '0';
            $result['is_verification'] = $_LANG['message']['not_found_verification'];
        }
    }
    $goods = $db -> getRow("select goods_name,goods_thumb,shop_price from ".$ecs->table('goods')." where goods_id = $res[goods_id]");
    $result['goods_name'] = $goods['goods_name'];
    $result['goods_thumb'] = $goods['goods_thumb'];
    $result['order_sn'] = $res['order_sn'];
    $result['end_date'] = local_date('Y-m-d',$res['end_date']);
    $result['card_id'] = $res['card_id'];
    $result['card_sn'] = $res['card_sn'];
    $result['buy_date'] = empty($res['buy_date'])?'未使用':local_date('Y-m-d',$res['buy_date']);
    $result['shop_price'] = $goods['shop_price'];
    $smarty->assign('ur_here', $_LANG['virtual_verification']);
    $smarty -> assign('result',$result);
    $smarty -> display("virtual_validate.htm");
}

/*------------------------------------------------------ */
//-- 虚拟卡列表，用于排序、翻页
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'query_card')
{
    $list = get_virtual_order_list();

    $smarty->assign('order_list',    $list['item']);
    $smarty->assign('filter',       $list['filter']);
    $smarty->assign('record_count', $list['record_count']);
    $smarty->assign('page_count',   $list['page_count']);

    $sort_flag = sort_flag($list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    make_json_result($smarty->fetch('virtual_goods_card_list.htm'), '',
        array('filter'=>$list['filter'], 'page_count'=>$list['page_count']));
}

/* 批量删除card */
elseif ($_REQUEST['act'] == 'batch_drop_card')
{
    /* 检查权限 */
    admin_priv('virualcard');

    $num = count($_POST['checkboxes']);
    $sql = "DELETE FROM ".$ecs->table('virtual_goods_card')." WHERE card_id ".db_create_in(implode(',',$_POST['checkboxes']));
    if ($db->query($sql))
    {
        /* 商品数量减$num */
        update_goods_number(intval($_REQUEST['goods_id']));
        $link[] = array('text'=>$_LANG['go_list'], 'href'=>'virtual_goods_card.php?act=card&goods_id='.$_REQUEST['goods_id']);
        sys_msg($_LANG['action_success'], 0, $link);
    }
}

elseif ($_REQUEST['act'] == 'del_virtual_order')
{
    /* 检查权限 */
    admin_priv('virualcard');

    $order_ids = $_POST['checkboxes'];
    foreach($order_ids as $order_id){
         $sql = " update ".$ecs->table('order_info')." set order_status = ".OS_INVALID." WHERE order_id = $order_id";
         $db->query($sql); 
         $order_sn = $db->getOne("select order_sn from ".$ecs->table('order_info')." where order_id = $order_id");
         $db->query("update ".$ecs->table('virtual_goods_card')." set is_saled = 0 where order_sn = '$order_sn'"); 
    }
        //设置验证码为未出售
    
        $link[] = array('text'=>'返回订单列表', 'href'=>'virtual_goods_card.php?act=all_card');
        sys_msg($_LANG['action_success'], 0, $link);   
}

/* 批量上传页面 */

elseif ($_REQUEST['act'] == 'batch_card_add')
{
    /* 检查权限 */
    admin_priv('virualcard');

    $smarty->assign('ur_here',          $_LANG['batch_card_add']);
    $smarty->assign('action_link',      array('text'=>$_LANG['virtual_card_list'], 'href'=>'virtual_goods.php?act=list&extension_code=virtual_card'));
    $smarty->assign('goods_id',           $_REQUEST['goods_id']);
    $smarty->display('batch_card_info.htm');
}

elseif ($_REQUEST['act'] == 'batch_confirm')
{
    /* 检查上传是否成功 */
    if ($_FILES['uploadfile']['tmp_name'] == '' || $_FILES['uploadfile']['tmp_name'] == 'none')
    {
        sys_msg($_LANG['uploadfile_fail'], 1);
    }

    $data = file($_FILES['uploadfile']['tmp_name']);
    $rec = array(); //数据数组
    $i = 0;
    $separator = trim($_POST['separator']);
    foreach ($data as $line)
    {
        $row = explode($separator, $line);
        switch(count($row))
        {
            case '3':
                $rec[$i]['end_date'] = $row[2];
            case '2':
                $rec[$i]['card_password'] = $row[1];
            case '1':
                $rec[$i]['card_sn']  = $row[0];
                break;
            default:
                $rec[$i]['card_sn']  = $row[0];
                $rec[$i]['card_password'] = $row[1];
                $rec[$i]['end_date'] = $row[2];
                break;
        }
        $i++;
    }

    $smarty->assign('ur_here',          $_LANG['batch_card_add']);
    $smarty->assign('action_link',      array('text'=>$_LANG['batch_card_add'], 'href'=>'virtual_goods_card.php?act=batch_card_add&goods_id='.$_REQUEST['goods_id']));
    $smarty->assign('list',               $rec);
    $smarty->display('batch_card_confirm.htm');

}
/* 批量上传处理 */
elseif ($_REQUEST['act'] == 'batch_insert')
{
    /* 检查权限 */
    admin_priv('virualcard');

    $add_time = gmtime();
    $i = 0;
    foreach ($_POST['checked'] as $key)
    {
        $rec['card_sn']  = encrypt($_POST['card_sn'][$key]);
        $rec['card_password'] = encrypt($_POST['card_password'][$key]);
        $rec['crc32']    = crc32(AUTH_KEY);
        $rec['end_date'] = empty($_POST['end_date'][$key]) ? 0 : strtotime($_POST['end_date'][$key]);
        $rec['goods_id'] = $_POST['goods_id'];
        $rec['add_date'] = $add_time;
        $db->AutoExecute($ecs->table('virtual_goods_card'), $rec, 'INSERT');
        $i++;
    }

    /* 更新商品库存 */
    update_goods_number(intval($_REQUEST['goods_id']));
    $link[] = array('text' => $_LANG['card'] , 'href' => 'virtual_goods_card.php?act=card&goods_id='.$_POST['goods_id']);
    sys_msg(sprintf($_LANG['batch_card_add_ok'], $i) , 0, $link);
}

/*------------------------------------------------------ */
//-- 更改加密串
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'change')
{
    /* 检查权限 */
    admin_priv('virualcard');

    $smarty->assign('ur_here', $_LANG['virtual_card_change']);

    assign_query_info();
    $smarty->display('virtual_card_change.htm');
}

/*------------------------------------------------------ */
//-- 提交更改
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'submit_change')
{
    /* 检查权限 */
    admin_priv('virualcard');

    if (isset($_POST['old_string']) && isset($_POST['new_string']))
    {
        // 检查原加密串是否正确
        if ($_POST['old_string'] != OLD_AUTH_KEY)
        {
            sys_msg($_LANG['invalid_old_string'], 1);
        }

        // 检查新加密串是否正确
        if ($_POST['new_string'] != AUTH_KEY)
        {
            sys_msg($_LANG['invalid_new_string'], 1);
        }

        // 检查原加密串和新加密串是否相同
        if ($_POST['old_string'] == $_POST['new_string'] || crc32($_POST['old_string']) == crc32($_POST['new_string']))
        {
            sys_msg($_LANG['same_string'], 1);
        }



        // 重新加密卡号和密码
        $old_crc32 = crc32($_POST['old_string']);
        $new_crc32 = crc32($_POST['new_string']);
        $sql = "SELECT card_id, card_sn, card_password FROM " . $ecs->table('virtual_goods_card') . " WHERE crc32 = '$old_crc32'";
        $res = $db->query($sql);
        while ($row = $db->fetchRow($res))
        {
            $row['card_sn'] = encrypt(decrypt($row['card_sn'], $_POST['old_string']), $_POST['new_string']);
            $row['card_password'] = encrypt(decrypt($row['card_password'], $_POST['old_string']), $_POST['new_string']);
            $row['crc32'] = $new_crc32;
            $db->autoExecute($ecs->table('virtual_goods_card'), $row, 'UPDATE', 'card_id = ' . $row['card_id']);
        }

        // 记录日志
        //admin_log();

        // 返回
        sys_msg($_LANG['change_key_ok'], 0, array(array('href' => 'virtual_goods_card.php?act=list', 'text' => $_LANG['virtual_card_list'])));
    }
}

/*------------------------------------------------------ */
//-- 切换是否已出售状态
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'toggle_sold')
{
    check_authz_json('virualcard');

    $id = intval($_POST['id']);
    $val = intval($_POST['val']);

    $sql = "UPDATE ".$ecs->table('virtual_goods_card')." SET is_saled= '$val' WHERE card_id='$id'";

    if ($db->query($sql, 'SILENT'))
    {
        /* 修改商品库存 */
        $sql = "SELECT goods_id FROM " . $ecs->table('virtual_goods_card') . " WHERE card_id = '$id' LIMIT 1";
        $goods_id = $db->getOne($sql);

        update_goods_number($goods_id);
        make_json_result($val);
    }
    else
    {
        make_json_error($_LANG['action_fail'] . "\n" .$db->error());
    }
}

/*------------------------------------------------------ */
//-- 删除卡片
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'remove_card')
{
    check_authz_json('virualcard');

    $id = intval($_GET['id']);

    $row = $db->GetRow('SELECT card_sn, goods_id FROM ' . $ecs->table('virtual_goods_card') . " WHERE card_id = '$id'");

    $sql = 'DELETE FROM ' . $ecs->table('virtual_goods_card') . " WHERE card_id = '$id'";
    if ($db->query($sql, 'SILENT'))
    {
        /* 修改商品数量 */
        update_goods_number($row['goods_id']);

        $url = 'virtual_goods_card.php?act=query_card&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);

        ecs_header("Location: $url\n");
        exit;
    }
    else
    {
        make_json_error($db->error());
    }
}

/*------------------------------------------------------ */
//-- 开始更改加密串：先检查原串和新串
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'start_change')
{
    $old_key = json_str_iconv(trim($_GET['old_key']));
    $new_key = json_str_iconv(trim($_GET['new_key']));
    // 检查原加密串和新加密串是否相同
    if ($old_key == $new_key || crc32($old_key) == crc32($new_key))
    {
        make_json_error($GLOBALS['_LANG']['same_string']);
    }
    if ($old_key != AUTH_KEY)
    {
        make_json_error($GLOBALS['_LANG']['invalid_old_string']);
    }
    else
    {
        $f=ROOT_PATH . 'data/config.php';
        file_put_contents($f,str_replace("'AUTH_KEY', '".AUTH_KEY."'","'AUTH_KEY', '".$new_key."'",file_get_contents($f)));
        file_put_contents($f,str_replace("'OLD_AUTH_KEY', '".OLD_AUTH_KEY."'","'OLD_AUTH_KEY', '".$old_key."'",file_get_contents($f)));
        @fclose($fp);
    }



    // 查询统计信息：总记录，使用原串的记录，使用新串的记录，使用未知串的记录
    $stat = array('all' => 0, 'new' => 0, 'old' => 0, 'unknown' => 0);
    $sql = "SELECT crc32, count(*) AS cnt FROM " . $ecs->table('virtual_goods_card') . " GROUP BY crc32";
    $res = $GLOBALS['db']->query($sql);
    while ($row = $db->fetchRow($res))
    {
        $stat['all'] += $row['cnt'];
        if (crc32($new_key) == $row['crc32'])
        {
            $stat['new'] += $row['cnt'];
        }
        elseif (crc32($old_key) == $row['crc32'])
        {
            $stat['old'] += $row['cnt'];
        }
        else
        {
            $stat['unknown'] += $row['cnt'];
        }
    }

    make_json_result(sprintf($GLOBALS['_LANG']['old_stat'], $stat['all'], $stat['new'], $stat['old'], $stat['unknown']));
}

/*------------------------------------------------------ */
//-- 更新加密串
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'on_change')
{
   // 重新加密卡号和密码
   $each_num    = 1;
   $old_crc32   = crc32(OLD_AUTH_KEY);
   $new_crc32   = crc32(AUTH_KEY);
   $updated     = intval($_GET['updated']);

   $sql = "SELECT card_id, card_sn, card_password ".
            " FROM " . $ecs->table('virtual_goods_card') .
            " WHERE crc32 = '$old_crc32' LIMIT $each_num";
   $res = $db->query($sql);

   while ($row = $db->fetchRow($res))
   {
       $row['card_sn']       = encrypt(decrypt($row['card_sn'], OLD_AUTH_KEY));
       $row['card_password'] = encrypt(decrypt($row['card_password'], OLD_AUTH_KEY));
       $row['crc32']         = $new_crc32;

       if (!$db->autoExecute($ecs->table('virtual_goods_card'), $row, 'UPDATE', 'card_id = ' . $row['card_id']))
       {
           make_json_error($updated, 0, $_LANG['update_error'] ."\n". $db->error());
       }

       $updated++;
    }

    // 查询是否还有未更新的
    $sql      = "SELECT COUNT(*) FROM " . $ecs->table('virtual_goods_card') . " WHERE crc32 = '$old_crc32' ";
    $left_num = $db->getOne($sql);

    if ($left_num > 0)
    {
        make_json_result($updated);
    }
    else
    {
        // 查询统计信息
        $stat = array('new' => 0, 'unknown' => 0);
        $sql = "SELECT crc32, count(*) AS cnt FROM " . $GLOBALS['ecs']->table('virtual_goods_card') . " GROUP BY crc32";
        $res = $GLOBALS['db']->query($sql);
        while ($row = $db->fetchRow($res))
        {
            if ($new_crc32 == $row['crc32'])
            {
                $stat['new'] += $row['cnt'];
            }
            else
            {
                $stat['unknown'] += $row['cnt'];
            }
        }

        make_json_result($updated, sprintf($_LANG['new_stat'], $stat['new'], $stat['unknown']));
    }
}


/*------------------------------------------------------ */
//-- 订单详情页面
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'info')
{
    /* 根据订单id或订单号查询订单信息 */
    if (isset($_REQUEST['order_id']))
    {
        $order_id = intval($_REQUEST['order_id']);
        $order = order_info($order_id);
	if ($db->getOne("select shipping_code from ".$ecs->table('shipping')." where shipping_id=".$order['shipping_id']) == "tc_express")
	{
		$order['tc_express'] = 1;
			
		$ko_order_sn  = $db->getOne("select invoice_no from ".$ecs->table('delivery_order')." where order_id=".$order_id);
		if ($ko_order_sn)
		{
			$kos_order_id = $db->getOne("select order_id from ".$ecs->table('kuaidi_order')." where order_sn='".$ko_order_sn."'");
		}

		$sql="select * from ". $ecs->table('kuaidi_order_status') ." where order_id='$kos_order_id'  order by status_id";
		$res_status = $db->query($sql);
		$have_shipping_info =0;
		$shipping_info ="";
		while($row_status = $db->fetchRow($res_status))
		{
			if ($row_status['status_display']==1)
			{				
				switch ($row_status['status_id'])
				{
					case 1 :
						$shipping_info .= "您提交了订单，请等待确认。 (".local_date('Y-m-d H:i:s', $row_status['status_time']).")";
						break;
					case 2 :
						$shipping_info .= "您的快件已经确认，等待快递员揽收。 (".local_date('Y-m-d H:i:s', $row_status['status_time']).")";
						break;
					case 3 :
						$postman_id = $db->getOne("select postman_id from ".$ecs->table('kuaidi_order')." where order_sn='".$order['invoice_no']."'");
						$postman_info = $db->getRow("select postman_name, mobile from ".$ecs->table('postman')." where postman_id=".$postman_id);
						$shipping_info .= "您的快件正在派送，快递员：".$postman_info['postman_name']."，电话：".$postman_info['mobile']." (".local_date('Y-m-d H:i:s', $row_status['status_time']).")";
						break;
					case 4 :
						$shipping_info .= "您的快件已经签收。 (".local_date('Y-m-d H:i:s', $row_status['status_time']).")";
						break;
					case 5 :
						$shipping_info .= "您的快件已被拒收。 (".local_date('Y-m-d H:i:s', $row_status['status_time']).")";
						break;
					case 6 :
						$shipping_info .= "您拒收的快件已被退回。 (".local_date('Y-m-d H:i:s', $row_status['status_time']).")";
						break;
					case 7 :
						$shipping_info .= "您的快件已经取消。 (".local_date('Y-m-d H:i:s', $row_status['status_time']).")";
						break;
				}
					
				$shipping_info .= "<br>";

				if ($row_status['status_id'] >= 1)
				{
					$have_shipping_info++;
				}
			}
		}
		if ($have_shipping_info)
		{
				$result_content = $shipping_info;
		}
		else
		{    
				$result_content ='抱歉，暂时还没有该运单的物流信息哦！';    					
		}
	}
	$smarty->assign('result_content',$result_content);
    }
    elseif (isset($_REQUEST['order_sn']))
    {
        $order_sn = trim($_REQUEST['order_sn']);
        $order = order_info(0, $order_sn);
    }
    else
    {
        /* 如果参数不存在，退出 */
        die('invalid parameter');
    }

    /* 如果订单不存在，退出 */
    if (empty($order))
    {
        die('order does not exist');
    }

    /* 根据订单是否完成检查权限 */
    if (order_finished($order))
    {
        admin_priv('order_view_finished');
    }
    else
    {
        admin_priv('order_view');
    }

    /* 如果管理员属于某个办事处，检查该订单是否也属于这个办事处 */
    $sql = "SELECT agency_id FROM " . $ecs->table('admin_user') . " WHERE user_id = '$_SESSION[admin_id]'";
    $agency_id = $db->getOne($sql);
    if ($agency_id > 0)
    {
        if ($order['agency_id'] != $agency_id)
        {
            sys_msg($_LANG['priv_error']);
        }
    }

    //如果为预售活动则需要判断预售活动是否已经成功结束了，如果未成功结束则不允许发货
    if($order['extension_code'] == PRE_SALE_CODE)
    {
    	$pre_sale_id = $order['extension_id'];
    	$sql = "select is_finished from " . $ecs->table('goods_activity') . " where act_id = '" . $pre_sale_id . "'";
    	$is_finished = $db->getOne($sql);
    	if($is_finished == PSS_SUCCEED)
    	{
    		$smarty->assign('pre_sale_success', '1');
    	}
    	else 
    	{
    		$smarty->assign('pre_sale_success', '0');
    	}
    	$smarty->assign('is_pre_sale', '1');
    }
    else 
    {
    	$smarty->assign('is_pre_sale', '0');
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
    $sql = "SELECT MAX(order_id) FROM " . $ecs->table('order_info') . " as o WHERE order_id < '$order[order_id]' and extension_code='virtual_good'";
    if ($agency_id > 0)
    {
        $sql .= " AND agency_id = '$agency_id'";
    }
    if (!empty($where))
    {
        $sql .= $where;
    }
    $smarty->assign('prev_id', $db->getOne($sql));
    $sql = "SELECT MIN(order_id) FROM " . $ecs->table('order_info') . " as o WHERE order_id > '$order[order_id]' and extension_code='virtual_good'";
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
    $sql = "SELECT concat(IFNULL(c.region_name, ''), '  ', IFNULL(p.region_name, ''), " .
                "'  ', IFNULL(t.region_name, ''), '  ', IFNULL(d.region_name, '')) AS region " .
            "FROM " . $ecs->table('order_info') . " AS o " .
                "LEFT JOIN " . $ecs->table('region') . " AS c ON o.country = c.region_id " .
                "LEFT JOIN " . $ecs->table('region') . " AS p ON o.province = p.region_id " .
                "LEFT JOIN " . $ecs->table('region') . " AS t ON o.city = t.region_id " .
                "LEFT JOIN " . $ecs->table('region') . " AS d ON o.district = d.region_id " .
            "WHERE o.order_id = '$order[order_id]'";
    $order['region'] = $db->getOne($sql);

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
            $row['package_goods_list'] = get_package_goods($row['goods_id'], $row['package_attr_id']); //修改 by bbs.hongyuvip.com
        }
		
		$sql_back = "SELECT bg.*, bo.back_type FROM " . $ecs->table('back_goods') . " AS bg " .
					" LEFT JOIN " . $ecs->table('back_order') . " AS bo " .
					" ON bg.back_id = bo.back_id " .
					" WHERE bo.order_id = " . $order['order_id'] .
					" AND bg.goods_id = " . $row['goods_id'] .
					" AND bg.product_id = " . $row['product_id'] .
					" AND bg.status_back < 6";
		$back_info = $db->getRow($sql_back);
		
		if (count($back_info['back_id']) > 0)
		{
			switch ($back_info['status_back'])
			{
				case '3' : $sb = "已完成"; break;
				case '5' : $sb = "已申请"; break;
				//case '6' : $sb = ""; break;
				//case '7' : $sb = ""; break;
				default : $sb = "正在"; break;
			}
			
			switch ($back_info['back_type'])
			{
				case '1' : $bt = "退货"; break;
				case '3' : $bt = "申请维修"; break;
				case '4' : $bt = "退款"; break;
				default : break;
			}
			
			$shouhou = $sb." ".$bt;
		}
		else
		{
			$shouhou = "正常";
		}
		
		$row['shouhou'] = $shouhou;

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
	/* 代码增加_start   By bbs.hongyuvip.com */
	if($order['pickup_point'] > 0)
	{
		$pickup_point = $db->getRow('select * from ' . $ecs->table('pickup_point') . ' where id=' . $order['pickup_point']);
		$smarty->assign('pickup_point',        $pickup_point);
	}
	/* 代码增加_end   By bbs.hongyuvip.com */
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
        $region_id .= !empty($_CFG['shop_district']) ? $_CFG['shop_district'] . ',' : '';
        
        $region_id .= !empty($order['country']) ? $order['country'] . ',' : '';
        $region_id .= !empty($order['province']) ? $order['province'] . ',' : '';
        $region_id .= !empty($order['city']) ? $order['city'] . ',' : '';
        $region_id .= !empty($order['district']) ? $order['district'] . ',' : '';
        
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
            $lable_box['t_shop_district'] = $region_array[$_CFG['shop_district']]; //网店-区/县
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
        /* 模板赋值 */
        $smarty->assign('ur_here', $_LANG['order_info']);
        $smarty->assign('action_link', array('href' => 'virtual_goods_card.php?act=all_card', 'text' => $_LANG['01_order_list']));

        /* 显示模板 */
        assign_query_info();
        $smarty->display('virtual_order_info.htm');
    }
}


/**
 * 获取虚拟订单列表
 * @return type
 */
function get_virtual_order_list(){    
    /* 查询条件 */
    $filter['goods_id']    = empty($_REQUEST['goods_id'])    ? 0 : intval($_REQUEST['goods_id']);
    $filter['search_type'] = empty($_REQUEST['search_type']) ? 0 : trim($_REQUEST['search_type']);
    $filter['order_sn']    = empty($_REQUEST['order_sn'])    ? 0 : trim($_REQUEST['order_sn']);
    $filter['keyword']     = empty($_REQUEST['keyword'])     ? 0 : trim($_REQUEST['keyword']);
   // $filter['is_verification'] = empty($_REQUEST['is_verification'])? 0 :trim($_REQUEST['is_verification']);

    $filter['supplier_id'] = (empty($_REQUEST['supplier_id']) && $_REQUEST['supplier_id'] != '0')? '' : intval($_REQUEST['supplier_id']);
    

    if (isset($_REQUEST['is_ajax']) && $_REQUEST['is_ajax'] == 1)
    {
        $filter['keyword'] = json_str_iconv($filter['keyword']);
        
    }
    $filter['sort_by']     = empty($_REQUEST['sort_by'])     ? 'card_id' : trim($_REQUEST['sort_by']);
    $filter['sort_order']  = empty($_REQUEST['sort_order'])  ? 'DESC' : trim($_REQUEST['sort_order']);
 
    $where  = (!empty($filter['goods_id'])) ? " AND goods_id = '" . $filter['goods_id'] . "' " : '';
    $where .= (!empty($filter['order_sn'])) ? " AND order_sn LIKE '%" . mysql_like_quote($filter['order_sn']) . "%' " : '';
  //  $where .= ($filter['is_verification'] !='') ? " AND is_verification = '" . $filter['is_verification'] . "' " : '';
    $where .= (empty($filter['supplier_id']) && $filter['supplier_id'] != '0') ? '' : " AND a.supplier_id = '" . $filter['supplier_id'] . "' ";
    //$where .= " and supplier_id = $_SESSION[supplier_id]";
    if (!empty($filter['keyword']))
    {
        if ($filter['search_type'] == 'card_sn')
        {
            $where .= " AND card_sn = '" .$filter['keyword']. "'";
        }
        else
        {
            $where .= " AND order_sn LIKE '%" . mysql_like_quote($filter['keyword']). "%' ";
        }
    }

    $sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('order_info') . " as a  WHERE 1  AND extension_code = 'virtual_good'  and order_status <> '".OS_INVALID."' " .$where;

    $filter['record_count'] = $GLOBALS['db']->getOne($sql);
    
    /* 分页大小 */
    $filter = page_and_size($filter);
    $start  = ($filter['page'] - 1) * $filter['page_size'];

    /* 查询 */
       $sql = "select a.order_id, a.order_sn, a.order_status, a.pay_status, b.goods_price, d.supplier_id, c.supplier_name, f.user_name  from ". $GLOBALS['ecs']->table('order_info') .
            "as a left join ". $GLOBALS['ecs']->table('order_goods') ." as b on a.order_id = b.order_id".
            " left join ". $GLOBALS['ecs']->table('goods')." as d on d.goods_id = b.goods_id".
            " left join ".$GLOBALS['ecs']->table('supplier')." as c on c.supplier_id = d.supplier_id".
            " left join ".$GLOBALS['ecs']->table('users')." as f on f.user_id = a.user_id".
            " where a.extension_code = 'virtual_good' and a.order_status <> '".OS_INVALID."' ".$where.
            " ORDER BY a.order_id DESC ".
            " LIMIT $start, ".$filter['page_size'];
    $all = $GLOBALS['db']->getAll($sql);

    $arr = array();
    foreach ($all AS $key => $row)
    {
        $card = get_order_card($row['order_sn']);
        $row['card'] = $card;
        $arr[] = $row;
    }
    return array('item' => $arr, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);
}

/**
 * 返回补货列表
 *
 * @return array
 */
function get_replenish_list()
{
    /* 查询条件 */
    $filter['goods_id']    = empty($_REQUEST['goods_id'])    ? 0 : intval($_REQUEST['goods_id']);
    $filter['search_type'] = empty($_REQUEST['search_type']) ? 0 : trim($_REQUEST['search_type']);
    $filter['order_sn']    = empty($_REQUEST['order_sn'])    ? 0 : trim($_REQUEST['order_sn']);
    $filter['keyword']     = empty($_REQUEST['keyword'])     ? 0 : trim($_REQUEST['keyword']);
    $filter['is_verification'] = $_REQUEST['is_verification'];

    $filter['supplier_id'] = (empty($_REQUEST['supplier_id']) && $_REQUEST['supplier_id'] != '0')? '' : intval($_REQUEST['supplier_id']);
    

    if (isset($_REQUEST['is_ajax']) && $_REQUEST['is_ajax'] == 1)
    {
        $filter['keyword'] = json_str_iconv($filter['keyword']);
        
    }
    $filter['sort_by']     = empty($_REQUEST['sort_by'])     ? 'card_id' : trim($_REQUEST['sort_by']);
    $filter['sort_order']  = empty($_REQUEST['sort_order'])  ? 'DESC' : trim($_REQUEST['sort_order']);
 
    $where  = (!empty($filter['goods_id'])) ? " AND goods_id = '" . $filter['goods_id'] . "' " : '';
    $where .= (!empty($filter['order_sn'])) ? " AND order_sn LIKE '%" . mysql_like_quote($filter['order_sn']) . "%' " : '';
    $where .= ($filter['is_verification'] !='') ? " AND is_verification = '" . $filter['is_verification'] . "' " : '';
    $where .= (empty($filter['supplier_id']) && $filter['supplier_id'] != '0') ? '' : " AND supplier_id = '" . $filter['supplier_id'] . "' ";
    //$where .= " and supplier_id = $_SESSION[supplier_id]";
    if (!empty($filter['keyword']))
    {
        if ($filter['search_type'] == 'card_sn')
        {
            $where .= " AND card_sn = '" .$filter['keyword']. "'";
        }
        else
        {
            $where .= " AND order_sn LIKE '%" . mysql_like_quote($filter['keyword']). "%' ";
        }
    }

    $sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('virtual_goods_card') . " WHERE 1 $where";
    $filter['record_count'] = $GLOBALS['db']->getOne($sql);
    
    /* 分页大小 */
    $filter = page_and_size($filter);
    $start  = ($filter['page'] - 1) * $filter['page_size'];

    /* 查询 */
    $sql = "SELECT card_id, goods_id, card_sn, add_date, end_date, buy_date, is_saled, order_sn, is_verification".
            " FROM ".$GLOBALS['ecs']->table('virtual_goods_card').
            " WHERE 1 ".$where.
            " ORDER BY $filter[sort_by] $filter[sort_order] ".
            " LIMIT $start, ".$filter['page_size'];
    $all = $GLOBALS['db']->getAll($sql);

    $arr = array();
    foreach ($all AS $key => $row)
    {

        $row['end_date'] = $row['end_date'] == 0 ? '' : date($GLOBALS['_CFG']['date_format'], $row['end_date']);
        $row['add_date'] = $row['add_date'] == 0 ? '' : date($GLOBALS['_CFG']['date_format'], $row['add_date']);
        $row['buy_date'] = $row['buy_date'] == 0 ? '' : date($GLOBALS['_CFG']['date_format'], $row['buy_date']);
        $order_goods = get_orderid_by_ordersn($row['order_sn']);
        $row['order_id'] = $order_goods['order_id'];
        $row['goods_price'] = $order_goods['goods_price']; 
        $row['supplier_id'] = $order_goods['supplier_id']; 
        $row['supplier_name'] = $order_goods['supplier_name']; 
        $row['user_name'] = $order_goods['user_name']; 
        $row['card_sn'] = str_mid_replace($row['card_sn']); 
        $arr[] = $row;
    }
   

    return array('item' => $arr, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);
}


function str_mid_replace($string) {
    if (! $string || !isset($string[1])) return $string;

    $len = strlen($string);
    $starNum = floor($len / 2); 
    $noStarNum = $len - $starNum;
    $leftNum = ceil($noStarNum / 2); 
    $rightNum = $noStarNum - $leftNum;

    $result = substr($string, 0, $leftNum);
    $result .= str_repeat('*', $starNum);
    $result .= substr($string, $len-$rightNum);

    return $result; 
}
/**
 * 更新虚拟商品的商品数量
 *
 * @access  public
 * @param   int     $goods_id
 *
 * @return bool
 */
function update_goods_number($goods_id)
{
    $sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('virtual_goods_card') . " WHERE goods_id = '$goods_id' AND is_saled = 0";
    $goods_number = $GLOBALS['db']->getOne($sql);

    $sql = "UPDATE " . $GLOBALS['ecs']->table('goods') . " SET goods_number = '$goods_number' WHERE goods_id = '$goods_id' AND extension_code='virtual_card'";

    return $GLOBALS['db']->query($sql);
}


function get_orderid_by_ordersn($order_sn){
    $sql = "select a.order_id, b.goods_price, d.supplier_id, c.supplier_name, f.user_name  from ". $GLOBALS['ecs']->table('order_info') .
            "as a left join ". $GLOBALS['ecs']->table('order_goods') ." as b on a.order_id = b.order_id".
            " left join ". $GLOBALS['ecs']->table('goods')." as d on d.goods_id = b.goods_id".
            " left join ".$GLOBALS['ecs']->table('supplier')." as c on c.supplier_id = d.supplier_id".
            " left join ".$GLOBALS['ecs']->table('order_info')." as e on e.order_id = a.order_id".
            " left join ".$GLOBALS['ecs']->table('users')." as f on f.user_id = e.user_id".
            " where a.order_sn = '$order_sn'";
    $res = $GLOBALS['db'] -> getRow($sql);
    return $res;
}

/**
 * 获取入驻商列表
 * @return type
 */
function get_supplier_list(){
    $sql = "select supplier_id, supplier_name from ". $GLOBALS['ecs']->table('supplier')." where status=1";
    $supplier = $GLOBALS['db']->getAll($sql);
    return $supplier;
}


function get_order_card($order_sn){
    $sql = "SELECT card_id, goods_id, card_sn, add_date, end_date, buy_date, is_saled, is_verification".
          " FROM ".$GLOBALS['ecs']->table('virtual_goods_card')." where order_sn = '".$order_sn."'";
    $card_list = $GLOBALS['db']->getAll($sql);
    foreach($card_list as $k=>$v){
        $card_list[$k]['end_date'] = $v['end_date'] == 0 ? '' : date($GLOBALS['_CFG']['date_format'], $v['end_date']);
        $card_list[$k]['add_date'] = $v['add_date'] == 0 ? '' : date($GLOBALS['_CFG']['date_format'], $v['add_date']);
        $card_list[$k]['buy_date'] = $v['buy_date'] == 0 ? '' : date($GLOBALS['_CFG']['date_format'], $v['buy_date']);
        $card_list[$k]['card_sn'] = str_mid_replace($v['card_sn']);
    }
    return $card_list;
}
?>