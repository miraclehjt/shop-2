<?php
define('IN_ECS', true);
require(dirname(__FILE__) . '/includes/init.php');
require_once(ROOT_PATH . 'includes/lib_order.php');
require_once(ROOT_PATH . 'includes/lib_supplier_common_wap.php');
$act = empty($_REQUEST['act'])?'list':trim($_REQUEST['act']);
//库存查询
if($act == 'list')
{
	$data = goods_stock();
    $goods = $data['goods'];
    $filter = $data['filter'];
    $smarty->assign('goods',$goods);
    $smarty->assign('filter',$filter);
    _wap_assign_header_info('库存列表');
    _wap_assign_footer_order_info();
    _wap_display_page('goods_stock_list.htm');
}

//获取商品库存列表
function goods_stock()
{
    global $ecs,$db;
    $result = get_filter($param_str);
    if($result === false)
    {
        $filter['goods_name'] = empty($_REQUEST['goods_name'])?'':trim($_REQUEST['goods_name']);
        $filter['goods_sn'] = empty($_REQUEST['goods_sn'])?'':trim($_REQUEST['goods_sn']);
        $where = ' WHERE supplier_id='.$_SESSION['supplier_id'];
        if(!empty($filter['goods_name']))
        {
            $where .= ' AND goods_name LIKE "%'.$filter['goods_name'].'%" ';
        }
        if(!empty($filter['goods_sn']))
        {
            $where .= ' AND goods_sn LIKE "%'.$filter['goods_sn'].'%" ';
        }
        $sql = 'SELECT COUNT(*) FROM '.$ecs->table('goods').$where;
        $filter['record_count'] = $db->getOne($sql);

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
        $filter = page_and_size($filter);
        $limit = ' LIMIT '. $filter['start'] .',' . $filter['page_size'];
        $sql = 'SELECT goods_id,goods_sn,goods_name,goods_number FROM '.$ecs->table('goods').$where.$limit;
        set_filter($filter, $sql);
    }
    else
    {
        $sql    = $result['sql'];
        $filter = $result['filter'];
    }

    $goods = $db->getAll($sql);

    foreach($goods as $goods_key => $goods_val)
    {
        $sql = 'SELECT goods_attr AS goods_attr_id,product_number FROM '.$ecs->table('products').' WHERE goods_id='.$goods_val['goods_id'];
        $attr = $db->getAll($sql);
        foreach($attr as $attr_key => $attr_val)
        {
            $goods_attr_arr = explode('|',$attr_val['goods_attr_id']);
            $attr_sql = implode(' OR goods_attr_id= ',$goods_attr_arr);
            $sql = 'SELECT attr_value FROM '.$ecs->table('goods_attr').' WHERE goods_attr_id='.$attr_sql;
            $attr_name_arr = $db->getAll($sql);
            $attr_name = '';
            foreach( $attr_name_arr as $name_key=>$name_val)
            {
                $attr_name .= implode(' ',$name_val);
            }
            $attr_val['goods_attr_name'] = $attr_name;
            $attr[$attr_key] = $attr_val;
        }
        $goods_val['goods_attr'] = $attr;
        $goods[$goods_key] = $goods_val;
    }

    $arr = array('goods' => $goods, 'filter' => $filter);
    return $arr;
}
