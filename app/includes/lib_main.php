<?php
if(!defined('IN_CTRL'))
{
	die('Hacking alert');
}
 /**
 * 重新计算购物车中的商品价格：目的是当用户登录时享受会员价格，当用户退出登录时不享受会员价格
 * 如果商品有促销，价格不变
 *
 * @access  public
 * @return  void
 */
function recalculate_price_app()
{
    /* 取得有可能改变价格的商品：除配件和赠品之外的商品 */
    $sql = 'SELECT c.rec_id, c.goods_id, c.goods_attr_id,g.market_price, g.promote_price, g.promote_start_date, c.goods_number,'.
                "g.promote_end_date, IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS member_price ".
            'FROM ' . $GLOBALS['ecs']->table('cart') . ' AS c '.
            'LEFT JOIN ' . $GLOBALS['ecs']->table('goods') . ' AS g ON g.goods_id = c.goods_id '.
            "LEFT JOIN " . $GLOBALS['ecs']->table('member_price') . " AS mp ".
                    "ON mp.goods_id = g.goods_id AND mp.user_rank = '" . $_SESSION['user_rank'] . "' ".
            "WHERE session_id = '" .SESS_ID. "' AND c.parent_id = 0 AND c.is_gift = 0 AND c.goods_id > 0 " .
            "AND c.rec_type = '" . CART_GENERAL_GOODS . "' AND c.extension_code <> 'package_buy'";

            $res = $GLOBALS['db']->getAll($sql);

    foreach ($res AS $row)
    {
        $attr_id    = empty($row['goods_attr_id']) ? array() : explode(',', $row['goods_attr_id']);


        $goods_price = get_final_price_app($row['goods_id'], 1, true, $attr_id);


        $goods_sql = "UPDATE " .$GLOBALS['ecs']->table('cart'). " SET market_price = '".$row['market_price']."', goods_price = '$goods_price' ".
                     "WHERE goods_id = '" . $row['goods_id'] . "' AND session_id = '" . SESS_ID . "' AND rec_id = '" . $row['rec_id'] . "'";

        $GLOBALS['db']->query($goods_sql);
    }

	/* 代码增加_start  By  www.68ecshop.com */
	$time1=local_strtotime('today');
	$time2=local_strtotime('today') + 86400; 
	$sql = "select rec_id,goods_id,goods_attr,goods_attr_id,goods_number ".  
				" from ".$GLOBALS['ecs']->table('cart')  ." where user_id=0 ".
				" AND session_id = '" .SESS_ID. "' AND parent_id = 0 ".
				" AND is_gift = 0 AND goods_id > 0 " .
				"AND rec_type = '" . CART_GENERAL_GOODS . "' ";
	$res = $GLOBALS['db']->query($sql);
   while ($row = $GLOBALS['db']->fetchRow($res))
    {
		$sql = "select rec_id from ".$GLOBALS['ecs']->table('cart')." where user_id='". $_SESSION['user_id'] ."' ".
					//" AND add_time >='$time1' and add_time<'$time2' ".
					" AND goods_id='$row[goods_id]' and goods_attr_id= '$row[goods_attr_id]' ";
		$rec_id = $GLOBALS['db']->getOne($sql);
		if($rec_id)
		{
			$sql = "update ".$GLOBALS['ecs']->table('cart')." set goods_number= goods_number + ".$row['goods_number'].
						" where rec_id='$rec_id' ";
			$GLOBALS['db']->query($sql);
			$sql="delete from ".$GLOBALS['ecs']->table('cart')." where rec_id='".$row['rec_id']."'";
			$GLOBALS['db']->query($sql);
			//app功能修改
			$_SESSION['rec_id'][$row['rec_id']] = $rec_id;
		}
		else
		{
			$sql = "update ".$GLOBALS['ecs']->table('cart')." set user_id='$_SESSION[user_id]' ".
						" where rec_id='".$row['rec_id']."'";
			$GLOBALS['db']->query($sql);
		}
	}
	/* 代码增加_end  By  www.68ecshop.com */

    /* 删除赠品，重新选择 */
    $GLOBALS['db']->query('DELETE FROM ' . $GLOBALS['ecs']->table('cart') .
        " WHERE session_id = '" . SESS_ID . "' AND is_gift > 0");
}