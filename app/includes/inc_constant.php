<?php
if(!defined('IN_CTRL'))
{
	die('Hacking alert');
}
define('ERR_NEED_LOGIN_FIRST','100');
define('ERR_NO_MORE_GOODS','101');
define('ERR_NO_MORE_COMMENT','102');
define('ERR_END_OF_LIST','103');
define('ERR_NOT_SPT_PRE_SALE','104');
define('ERR_NOT_SPT_VIRTUAL_GOODS','105');
define('ERR_NEED_VERIFY_SURPLUS','106');
define('ERR_OVER_BUY_MAX','107');//要加购物车的数量超过限购数量
define('ERR_NEED_LOGIN_TO_BUY','108');//限购商品，需要登录
define('ERR_NEED_SEL_GOODS','109');//结算时没有选择商品
define('ERR_GET_LOCATION','110');
define('ERR_NO_GUIDE_PICTURE','111');
define('ERR_NOT_IN_DISTRIBUTION','112');
define('ERR_SHOP_CLOSED','113');//店铺关闭
/* 综合状态 */
define('CS_SHIPPED',              103); // 待收货：已发货
if(!defined('APP_FROM')){
	define('APP_FROM','app');
}