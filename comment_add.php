<?php 

define('IN_ECS',true); 
require(dirname(__FILE__) .'/includes/init.php'); 
if ((DEBUG_MODE &2) != 2) 
{ 
$smarty->caching = true; 
} 

if ( $_REQUEST['action_comm'] == 'save') 
{ 
$goods_id = $_REQUEST['id']; 
$cmt_type = $_REQUEST['cmt_type']; 
$status = 1 -$GLOBALS['_CFG']['comment_check']; 
$user_id = empty($_SESSION['user_id']) ?0 : $_SESSION['user_id']; 
$user_name = empty($cmt->username) ?$_SESSION['user_name'] : trim($cmt->username);
 $user_name = htmlspecialchars($user_name); 
$title =  $_POST['comment_title'] ?$_POST['comment_title'] : ''; 
$content =  $_POST['content'] ; 
$rank =  $_POST['comment_rank']; 
$sql = "INSERT INTO ".$GLOBALS['ecs']->table('comment') . 
"(comment_type, id_value, email, user_name, title, content, comment_rank, add_time, ip_address, status, parent_id, user_id) VALUES ".
 "('".$cmt_type."', '".$goods_id."', '', '$user_name', '$title', '".$content."', '".$rank."', ".gmtime().", '".real_ip()."', '$status', '0', '$user_id')";
 $GLOBALS['db']->query($sql); 
$cmid = $GLOBALS['db']->insert_id(); 
clear_cache_files(); 
$Loaction = 'goods.php?id='.$goods_id ; 
ecs_header("Location: $Loaction\n"); 
} 
$act = !empty($_GET['act']) ?$_GET['act'] : ''; 
if ($act == 'cat_rec') 
{ 
$rec_array = array(1 =>'best',2 =>'new',3 =>'hot'); 
$rec_type = !empty($_REQUEST['rec_type']) ?intval($_REQUEST['rec_type']) : '1'; 
$cat_id = !empty($_REQUEST['cid']) ?intval($_REQUEST['cid']) : '0'; 
include_once('includes/cls_json.php'); 
$json = new JSON; 
$result   = array('error'=>0,'content'=>'','type'=>$rec_type,'cat_id'=>$cat_id);
 $children = get_children($cat_id); 
$smarty->assign($rec_array[$rec_type] .'_goods',get_category_recommend_goods($rec_array[$rec_type],$children));
 $smarty->assign('cat_rec_sign',1); 
$result['content'] = $smarty->fetch('library/recommend_'.$rec_array[$rec_type] .'.lbi');
 die($json->encode($result)); 
} 
$cache_id = sprintf('%X',crc32($_SESSION['user_rank'] .'-'.$_CFG['lang'])); 
if (true) 
{ 
$goods_id = isset($_REQUEST['id'])  ?intval($_REQUEST['id']) : 0; 
assign_template(); 
$smarty->assign('id',$goods_id); 
$smarty->assign('type',0); 
$smarty->assign('keywords',htmlspecialchars($_CFG['shop_keywords'])); 
$smarty->assign('description',htmlspecialchars($_CFG['shop_desc'])); 
$smarty->assign('flash_theme',$_CFG['flash_theme']); 
$smarty->assign('feed_url',($_CFG['rewrite'] == 1) ?'feed.xml': 'feed.php'); 
$smarty->assign('categories',get_categories_tree()); 
$smarty->assign('helps',get_shop_help()); 
$smarty->assign('top_goods',get_top10()); 
$smarty->assign('best_goods',get_recommend_goods('best')); 
$smarty->assign('new_goods',get_recommend_goods('new')); 
$smarty->assign('hot_goods',get_recommend_goods('hot')); 
$smarty->assign('promotion_goods',get_promote_goods()); 
$smarty->assign('brand_list',get_brands()); 
$smarty->assign('promotion_info',get_promotion_info()); 
$smarty->assign('shop_notice',$_CFG['shop_notice']); 
$smarty->assign('index_ad',$_CFG['index_ad']); 
if ($_CFG['index_ad'] == 'cus') 
{ 
$sql = 'SELECT ad_type, content, url FROM '.$ecs->table("ad_custom") .' WHERE ad_status = 1';
 $ad = $db->getRow($sql,true); 
$smarty->assign('ad',$ad); 
} 
$links = index_get_links(); 
$smarty->assign('img_links',$links['img']); 
$smarty->assign('txt_links',$links['txt']); 
$smarty->assign('data_dir',DATA_DIR); 
$cat_recommend_res = $db->getAll("SELECT c.cat_id, c.cat_name, cr.recommend_type FROM ".$ecs->table("cat_recommend") ." AS cr INNER JOIN ".$ecs->table("category") ." AS c ON cr.cat_id=c.cat_id");
 if (!empty($cat_recommend_res)) 
{ 
$cat_rec_array = array(); 
foreach($cat_recommend_res as $cat_recommend_data) 
{ 
$cat_rec[$cat_recommend_data['recommend_type']][] = array('cat_id'=>$cat_recommend_data['cat_id'],'cat_name'=>$cat_recommend_data['cat_name']);
 } 
$smarty->assign('cat_rec',$cat_rec); 
} 
$sql="select * from ".$GLOBALS['ecs']->table("comment")." where comment_id='$_REQUEST[cmid]' ";
 $comment_con=$db->getRow($sql); 
if($comment_con) 
{ 
$comment_con['add_time']= local_date($GLOBALS['_CFG']['time_format'],$comment_con['add_time']);
 } 
$smarty->assign('comment_con',$comment_con); 
assign_dynamic('index'); 
} 
$position = assign_ur_here($goods['cat_id'],$goods['goods_name']); 
$smarty->assign('page_title',$position['title']); 
$smarty->assign('ur_here',$position['ur_here']); 
$sql = 'SELECT * from '.$GLOBALS['ecs']->table('goods')." where goods_id='$goods_id'";
 $row = $GLOBALS['db']->getRow($sql); 
$smarty->assign('bought_goods',get_also_bought($goods_id)); 
$row['goods_nameon']= str_replace("¡¿","",$row['goods_nameon']); 
$row['goods_nameon']= str_replace("¡¾","",$row['goods_nameon']); 
$smarty->assign('goods',$row); 
$smarty->display('comment_add.dwt'); 
function index_get_links() 
{ 
$sql = 'SELECT link_logo, link_name, link_url FROM '.$GLOBALS['ecs']->table('friend_link') .' ORDER BY show_order';
 $res = $GLOBALS['db']->getAll($sql); 
$links['img'] = $links['txt'] = array(); 
foreach ($res AS $row) 
{ 
if (!empty($row['link_logo'])) 
{ 
$links['img'][] = array('name'=>$row['link_name'], 
'url'=>$row['link_url'], 
'logo'=>$row['link_logo']); 
} 
else 
{ 
$links['txt'][] = array('name'=>$row['link_name'], 
'url'=>$row['link_url']); 
} 
} 
return $links; 
} 
function get_promote_goods_pro($cat_id = array(0)) 
{ 
for( $i=0;$i<count($cat_id);$i++) { 
if( $i<count($cat_id)-1 ) { 
$search .=  get_children($cat_id[$i]) ."OR ".get_extension_goods(get_children($cat_id[$i])) .' OR ';
 } 
else { 
$search .=  get_children($cat_id[$i]) ."OR ".get_extension_goods(get_children($cat_id[$i]));
 } 
} 
$time = gmtime(); 
$order_type = $GLOBALS['_CFG']['recommend_order']; 
$num = 12; 
$sql = 'SELECT g.goods_id, g.goods_name, g.goods_name_style, g.market_price, g.shop_price AS org_price, g.promote_price, '.
 "IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS shop_price, ". 
"promote_start_date, promote_end_date, g.goods_brief, g.goods_thumb, goods_img, b.brand_name, ".
 "g.is_best, g.is_new, g.is_hot, g.is_promote, RAND() AS rnd ". 
'FROM '.$GLOBALS['ecs']->table('goods') .' AS g '. 
'LEFT JOIN '.$GLOBALS['ecs']->table('brand') .' AS b ON b.brand_id = g.brand_id '.
 "LEFT JOIN ".$GLOBALS['ecs']->table('member_price') ." AS mp ". 
"ON mp.goods_id = g.goods_id AND mp.user_rank = '$_SESSION[user_rank]' ". 
'WHERE g.is_on_sale = 1 AND g.is_alone_sale = 1 AND g.is_delete = 0 '. 
" AND g.is_promote = 1 AND promote_start_date <= '$time' AND promote_end_date >= '$time'".
 "AND (".$search .") "; 
$sql .= $order_type == 0 ?' ORDER BY g.sort_order, g.last_update DESC': ' ORDER BY rnd';
 $sql .= " LIMIT $num "; 
$result = $GLOBALS['db']->getAll($sql); 
$goods = array(); 
foreach ($result AS $idx =>$row) 
{ 
if ($row['promote_price'] >0) 
{ 
$promote_price = bargain_price($row['promote_price'],$row['promote_start_date'],$row['promote_end_date']);
 $goods[$idx]['promote_price'] = $promote_price >0 ?price_format($promote_price) : '';
 } 
else 
{ 
$goods[$idx]['promote_price'] = ''; 
} 
$goods[$idx]['id']           = $row['goods_id']; 
$goods[$idx]['name']         = $row['goods_name']; 
$goods[$idx]['brief']        = $row['goods_brief']; 
$goods[$idx]['brand_name']   = $row['brand_name']; 
$goods[$idx]['goods_style_name']   = add_style($row['goods_name'],$row['goods_name_style']);
 $goods[$idx]['short_name']   = $GLOBALS['_CFG']['goods_name_length'] >0 ?sub_str($row['goods_name'],$GLOBALS['_CFG']['goods_name_length']) : $row['goods_name'];
 $goods[$idx]['short_style_name']   = add_style($goods[$idx]['short_name'],$row['goods_name_style']);
 $goods[$idx]['market_price'] = price_format($row['market_price']); 
$goods[$idx]['shop_price']   = price_format($row['shop_price']); 
$goods[$idx]['thumb']        = get_image_path($row['goods_id'],$row['goods_thumb'],true);
 $goods[$idx]['goods_img']    = get_image_path($row['goods_id'],$row['goods_img']);
 $goods[$idx]['url']          = build_uri('goods',array('gid'=>$row['goods_id']),$row['goods_name']);
 $time = gmtime(); 
if ($time >= $row['promote_start_date'] &&$time <= $row['promote_end_date']) 
{ 
$goods[$idx]['gmt_end_time']  = local_date('M d, Y H:i:s',$row['promote_end_date']);
 } 
else 
{ 
$goods[$idx]['gmt_end_time'] = 0; 
} 
} 
return $goods; 
} 
function get_also_bought($goods_id) 
{ 
$sql = 'SELECT COUNT(b.goods_id ) AS num, g.goods_id, g.goods_name, g.goods_brief, g.goods_thumb, g.goods_img, g.shop_price, g.promote_price, g.promote_start_date, g.promote_end_date '.
 'FROM '.$GLOBALS['ecs']->table('order_goods') .' AS a '. 
'LEFT JOIN '.$GLOBALS['ecs']->table('order_goods') .' AS b ON b.order_id = a.order_id '.
 'LEFT JOIN '.$GLOBALS['ecs']->table('goods') .' AS g ON g.goods_id = b.goods_id '.
 "WHERE a.goods_id = '$goods_id' AND b.goods_id <> '$goods_id' AND g.is_on_sale = 1 AND g.is_alone_sale = 1 AND g.is_delete = 0 ".
 'GROUP BY b.goods_id '. 
'ORDER BY num DESC '. 
'LIMIT '.$GLOBALS['_CFG']['bought_goods']; 
$res = $GLOBALS['db']->query($sql); 
$key = 0; 
$arr = array(); 
while ($row = $GLOBALS['db']->fetchRow($res)) 
{ 
$arr[$key]['goods_brief']    = $row['goods_brief']; 
$arr[$key]['goods_id']    = $row['goods_id']; 
$arr[$key]['goods_name']  = $row['goods_name']; 
$arr[$key]['short_name']  = $GLOBALS['_CFG']['goods_name_length'] >0 ? 
sub_str($row['goods_name'],$GLOBALS['_CFG']['goods_name_length']) : $row['goods_name'];
 $arr[$key]['goods_thumb'] = get_image_path($row['goods_id'],$row['goods_thumb'],true);
 $arr[$key]['goods_img']   = get_image_path($row['goods_id'],$row['goods_img']);
 $arr[$key]['shop_price']  = price_format($row['shop_price']); 
$arr[$key]['url']         = build_uri('goods',array('gid'=>$row['goods_id']),$row['goods_name']);
 if ($row['promote_price'] >0) 
{ 
$arr[$key]['promote_price'] = bargain_price($row['promote_price'],$row['promote_start_date'],$row['promote_end_date']);
 $arr[$key]['formated_promote_price'] = price_format($arr[$key]['promote_price']);
 } 
else 
{ 
$arr[$key]['promote_price'] = 0; 
} 
$key++; 
} 
return $arr; 
} 
function http() 
{ 
return (isset($_SERVER['HTTPS']) &&(strtolower($_SERVER['HTTPS']) != 'off')) ?'https://': 'http://';
 } 
function get_domain() 
{ 
$protocol = http(); 
if (isset($_SERVER['HTTP_X_FORWARDED_HOST'])) 
{ 
$host = $_SERVER['HTTP_X_FORWARDED_HOST']; 
} 
elseif (isset($_SERVER['HTTP_HOST'])) 
{ 
$host = $_SERVER['HTTP_HOST']; 
} 
else 
{ 
if (isset($_SERVER['SERVER_PORT'])) 
{ 
$port = ':'.$_SERVER['SERVER_PORT']; 
if ((':80'== $port &&'http://'== $protocol) ||(':443'== $port &&'https://'== $protocol))
 { 
$port = ''; 
} 
} 
else 
{ 
$port = ''; 
} 
if (isset($_SERVER['SERVER_NAME'])) 
{ 
$host = $_SERVER['SERVER_NAME'] .$port; 
} 
elseif (isset($_SERVER['SERVER_ADDR'])) 
{ 
$host = $_SERVER['SERVER_ADDR'] .$port; 
} 
} 
return $protocol .$host; 
} 

?> 