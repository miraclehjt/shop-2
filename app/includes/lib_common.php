<?php
if(!defined('IN_CTRL'))
{
	die('Hacking alert');
}

/**
 * 获取最终价格
 */
function get_final_price_app($goods_id, $goods_num = '1', $is_spec_price = false, $spec = array())
{

    $final_price   = '0'; //商品最终购买价格
    $volume_price  = '0'; //商品优惠价格
    $promote_price = '0'; //商品促销价格
    $user_price    = '0'; //商品会员价格
	$exclusive = '0';//手机专享价格
    //取得商品优惠价格列表
    $price_list   = get_volume_price_list($goods_id, '1');

    if (!empty($price_list))
    {
        foreach ($price_list as $value)
        {
            if ($goods_num >= $value['number'])
            {
                $volume_price = $value['price'];
            }
        }
    }

	$discount = isset($GLOBALS['tongbu_user_discount']) ? $GLOBALS['tongbu_user_discount'] : $_SESSION['discount'];
	$user_rank = isset($GLOBALS['tongbu_user_rank']) ? $GLOBALS['tongbu_user_rank'] : $_SESSION['user_rank'];

    //取得商品促销价格列表
    /* 取得商品信息 */
    $sql = "SELECT g.promote_price, g.promote_start_date, g.promote_end_date, ".
                "IFNULL(mp.user_price, g.shop_price * '" . $discount . "') AS shop_price,g.exclusive ".
           " FROM " .$GLOBALS['ecs']->table('goods'). " AS g ".
           " LEFT JOIN " . $GLOBALS['ecs']->table('member_price') . " AS mp ".
                   "ON mp.goods_id = g.goods_id AND mp.user_rank = '" . $user_rank. "' ".
           " WHERE g.goods_id = '" . $goods_id . "'" .
           " AND g.is_delete = 0";
    $goods = $GLOBALS['db']->getRow($sql);

    /* 计算商品的促销价格 */
    if ($goods['promote_price'] > 0)
    {
        $promote_price = bargain_price($goods['promote_price'], $goods['promote_start_date'], $goods['promote_end_date']);
    }
    else
    {
        $promote_price = 0;
    }

    //取得商品会员价格列表
    $user_price    = $goods['shop_price'];
	
	//取得手机专享价格
	$exclusive = $goods['exclusive'];

    //比较商品的促销价格，会员价格，优惠价格
    if (empty($volume_price) && empty($promote_price) && $exclusive < 0)
    {
        //如果优惠价格，促销价格都为空则取会员价格
        $final_price = $user_price;
    }
    elseif (!empty($volume_price) && empty($promote_price) && $exclusive < 0)
    {
        //如果优惠价格为空时不参加这个比较。
        $final_price = min($volume_price, $user_price);
    }
    elseif (empty($volume_price) && !empty($promote_price) && $exclusive < 0)
    {
        //如果促销价格为空时不参加这个比较。
        $final_price = min($promote_price, $user_price);
    }
    elseif (!empty($volume_price) && !empty($promote_price) && $exclusive < 0)
    {
        //取促销价格，会员价格，优惠价格最小值
        $final_price = min($volume_price, $promote_price, $user_price);
    }
	elseif (empty($volume_price) && empty($promote_price) && $exclusive >= 0)
    {
        $final_price = min($exclusive, $user_price);
    }
    elseif (!empty($volume_price) && empty($promote_price) && $exclusive >= 0)
    {
        $final_price = min($volume_price, $exclusive,$user_price);
    }
    elseif (empty($volume_price) && !empty($promote_price) && $exclusive >= 0)
    {
        $final_price = min($promote_price, $exclusive,$user_price);
    }
    elseif (!empty($volume_price) && !empty($promote_price) && $exclusive >= 0)
    {
        $final_price = min($volume_price, $promote_price, $user_price,$exclusive);
    }
    else
    {
        $final_price = $user_price;
    }

    //如果需要加入规格价格
    if ($is_spec_price)
    {
        if (!empty($spec))
        {
            $spec_price   = spec_price($spec);
            $final_price += $spec_price;
        }
    }

    //返回商品最终购买价格
    return $final_price;
}