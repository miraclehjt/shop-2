<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

$sort = isset( $_REQUEST['sort'] ) && in_array( trim( strtolower( $_REQUEST['sort'] ) ), array( "goods_id", "shop_price", "sell_number", "comment_count" ) ) ? trim( $_REQUEST['sort'] ) : $default_sort_order_type;
$smarty->assign( "cat_list", cat_list( 0, 0, TRUE, 2, FALSE ) );
$smarty->assign( "brand_list", get_brand_list( ) );
$sql = "SELECT g.goods_id, g.goods_name,g.goods_sn, g.market_price,g.is_promote, g.is_new, g.is_best, g.is_hot, g.shop_price AS org_price, ".( "IFNULL(mp.user_price, g.shop_price * '".$_SESSION['discount']."') AS shop_price, " )."(select AVG(r.comment_rank) from ".$GLOBALS['ecs']->table( "comment" )." as r where r.id_value = g.goods_id AND r.comment_type = 0 AND r.parent_id = 0 AND r.status = 1) AS comment_rank, (select IFNULL(sum(r.id_value), 0) from ".$GLOBALS['ecs']->table( "comment" )." as r where r.id_value = g.goods_id AND r.comment_type = 0 AND r.parent_id = 0 AND r.status = 1) AS comment_count, (select IFNULL(sum(og.goods_number), 0) from ".$GLOBALS['ecs']->table( "order_goods" )." as og where og.goods_id = g.goods_id) AS sell_number, g.promote_price, g.promote_start_date, g.promote_end_date, g.goods_thumb, g.goods_img, g.goods_brief, g.goods_type FROM ".$ecs->table( "goods" )." AS g LEFT JOIN ".$GLOBALS['ecs']->table( "member_price" )." AS mp ".( "ON mp.goods_id = g.goods_id AND mp.user_rank = '".$_SESSION['user_rank']."' " ).( "WHERE g.is_delete = 0 AND g.is_on_sale = 1 AND g.is_alone_sale = 1 ".$attr_in." " )."AND (( 1 ".$categories.$keywords.$brand.$min_price.$max_price.$intro.$outstock." ) ".$tag_where." ) ".( "ORDER BY ".$sort." {$order}" );
$res = $db->SelectLimit( $sql, $size, ( $page - 1 ) * $size );
$arr = array( );
while ( $row = $db->FetchRow( $res ) )
{
		if ( 0 < $row['promote_price'] )
		{
				$promote_price = bargain_price( $row['promote_price'], $row['promote_start_date'], $row['promote_end_date'] );
		}
		else
		{
				$promote_price = 0;
		}
		$watermark_img = "";
		if ( $promote_price != 0 )
		{
				$watermark_img = "watermark_promote_small";
		}
		else if ( $row['is_new'] != 0 )
		{
				$watermark_img = "watermark_new_small";
		}
		else if ( $row['is_best'] != 0 )
		{
				$watermark_img = "watermark_best_small";
		}
		else if ( $row['is_hot'] != 0 )
		{
				$watermark_img = "watermark_hot_small";
		}
		if ( $watermark_img != "" )
		{
				$arr[$row['goods_id']]['watermark_img'] = $watermark_img;
		}
		$arr[$row['goods_id']]['goods_id'] = $row['goods_id'];
		if ( $display == "grid" )
		{
				$arr[$row['goods_id']]['short_name'] = 0 < $GLOBALS['_CFG']['goods_name_length'] ? sub_str( $row['goods_name'], $GLOBALS['_CFG']['goods_name_length'] ) : $row['goods_name'];
				$arr[$row['goods_id']]['goods_name'] = $row['goods_name'];
		}
		else
		{
				$arr[$row['goods_id']]['goods_name'] = $row['goods_name'];
		}
		$arr[$row['goods_id']]['goods_sn'] = $row['goods_sn'];
		$arr[$row['goods_id']]['comment_rank'] = $row['comment_rank'];
		$arr[$row['goods_id']]['comment_count'] = $row['comment_count'];
		$arr[$row['goods_id']]['sell_number'] = $row['sell_number'];
		$arr[$row['goods_id']]['is_promote'] = $row['is_promote'];
		$arr[$row['goods_id']]['is_new'] = $row['is_new'];
		$arr[$row['goods_id']]['is_best'] = $row['is_best'];
		$arr[$row['goods_id']]['is_hot'] = $row['is_hot'];
		$arr[$row['goods_id']]['type'] = $row['goods_type'];
		$arr[$row['goods_id']]['market_price'] = price_format( $row['market_price'] );
		$arr[$row['goods_id']]['shop_price'] = price_format( $row['shop_price'] );
		$arr[$row['goods_id']]['promote_price'] = 0 < $promote_price ? price_format( $promote_price ) : "";
		$arr[$row['goods_id']]['goods_brief'] = $row['goods_brief'];
		$arr[$row['goods_id']]['goods_thumb'] = get_image_path( $row['goods_id'], $row['goods_thumb'], TRUE );
		$arr[$row['goods_id']]['goods_img'] = get_image_path( $row['goods_id'], $row['goods_img'] );
		$arr[$row['goods_id']]['url'] = build_uri( "goods", array(
				"gid" => $row['goods_id']
		), $row['goods_name'] );
}
if ( $display == "grid" && count( $arr ) % 2 != 0 )
{
		$arr[] = array( );
}
$smarty->assign( "goods_list", $arr );
?>
