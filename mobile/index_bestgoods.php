<?php

/**
 * 鸿宇多用户商城 广告处理文件
 * ============================================================================
 * 版权所有 2015-2016 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: Shadow & 鸿宇
 * $Id: affiche.php 17217 2016-01-19 06:29:08Z Shadow & 鸿宇
*/

define('IN_ECS', true);
//define('INIT_NO_SMARTY', true);
require(dirname(__FILE__) . '/includes/init.php');

    
$last = $_POST['last'];
$amount = $_POST['amount'];
//异步调用

if (!empty($_REQUEST['act']) && $_REQUEST['act'] == 'ajax')
{
   include('includes/cls_json.php');

	$limit = " limit $last,$amount";//每次加载的个数
    $json   = new JSON;


  
$goodslist = get_index_best( $limit );

foreach($goodslist as $val){
    	$GLOBALS['smarty']->assign('goods',$val);
    	$res[]['info']  = $GLOBALS['smarty']->fetch('library/index_best_goods_2.lbi');
}
}
die($json->encode($res));


/**
 * 获得推荐商品
 *
 * @access  public
 * @param   string      $type       推荐类型，可以是 best, new, hot
 * @return  array
 */
function get_index_best( $limit = '')
{


        $time = gmtime();


        //取出所有符合条件的商品数据，并将结果存入对应的推荐类型数组中
        $sql = 'SELECT g.goods_id, g.goods_name,g.click_count, g.goods_name_style, g.market_price, g.shop_price AS org_price, g.promote_price, ' .
                "IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS shop_price, ".
                "promote_start_date, promote_end_date, g.goods_brief, g.goods_thumb, g.goods_img, RAND() AS rnd " .
                'FROM ' . $GLOBALS['ecs']->table('goods') . ' AS g ' .
                "LEFT JOIN " . $GLOBALS['ecs']->table('member_price') . " AS mp ".
                "ON mp.goods_id = g.goods_id AND mp.user_rank = '$_SESSION[user_rank]' ";
   
        $sql .= ' WHERE g.is_on_sale = 1 AND g.is_alone_sale = 1 AND g.is_delete = 0 AND g.is_virtual=0 AND g.is_best = "best" ';
        $sql .= ' ORDER BY g.sort_order, g.last_update DESC';
		$sql .= " $limit";


        $result = $GLOBALS['db']->getAll($sql);
        foreach ($result AS $idx => $row)
        {
            if ($row['promote_price'] > 0)
            {
                $promote_price = bargain_price($row['promote_price'], $row['promote_start_date'], $row['promote_end_date']);
                $goods[$idx]['promote_price'] = $promote_price > 0 ? price_format($promote_price) : '';
            }
            else
            {
                $goods[$idx]['promote_price'] = '';
            }

            $goods[$idx]['id']           = $row['goods_id'];
            $goods[$idx]['name']         = $row['goods_name'];
            $goods[$idx]['brief']        = $row['goods_brief'];
            $goods[$idx]['brand_name']   = isset($goods_data['brand'][$row['goods_id']]) ? $goods_data['brand'][$row['goods_id']] : '';
            $goods[$idx]['goods_style_name']   = add_style($row['goods_name'],$row['goods_name_style']);

            $goods[$idx]['short_name']   = $GLOBALS['_CFG']['goods_name_length'] > 0 ?
                                               sub_str($row['goods_name'], $GLOBALS['_CFG']['goods_name_length']) : $row['goods_name'];
            $goods[$idx]['short_style_name']   = add_style($goods[$idx]['short_name'],$row['goods_name_style']);
            $goods[$idx]['market_price'] = price_format($row['market_price']);
            $goods[$idx]['shop_price']   = price_format($row['shop_price']);
            $goods[$idx]['thumb']        = '../'. get_image_path($row['goods_id'], $row['goods_thumb'], true);
            $goods[$idx]['goods_img']    = '../'. get_image_path($row['goods_id'], $row['goods_img']);
            $goods[$idx]['url']          = build_uri('goods', array('gid' => $row['goods_id']), $row['goods_name']);
			$goods[$idx]['sell_count']   =selled_count($row['goods_id']);
			$goods[$idx]['pinglun']   =get_evaluation_sum($row['goods_id']);
			$goods[$idx]['count'] = selled_count($row['goods_id']);
			$goods[$idx]['click_count'] = $row['click_count'];
        }
    return $goods;
}


?>