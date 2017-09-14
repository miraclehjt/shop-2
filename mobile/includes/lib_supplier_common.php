<?php

/**
 * 鸿宇多用户商城 公用函数库
 * ============================================================================
 * 版权所有 2015-2016 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: Shadow & 鸿宇
 * $Id: lib_common.php 17217 2016-01-19 06:29:08Z Shadow & 鸿宇
*/

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

/**
 * 获取本店铺商品数量
 */
function get_supplier_goods_count($suppid=0){
	
	$suppid = (intval($suppid)>0) ? intval($suppid) : intval($_GET['suppId']);
	$sql="SELECT count(`goods_id`) FROM ".$GLOBALS['ecs']->table('goods')." as g WHERE  g.is_delete = 0 AND g.is_on_sale = 1 AND g.is_alone_sale = 1 AND g.is_virtual = 0 AND g.supplier_id='$suppid'";
   return $GLOBALS['db']->getOne($sql);
}

function assign_template_supplier($ctype = '', $catlist = array())
{
    global $smarty,$suppinfo,$index_price;
    
    $shoplogo = empty($GLOBALS['_CFG']['shop_logo']) ? 'themes/'.$GLOBALS['_CFG']['template'].'/images/dianpu.jpg' : $GLOBALS['_CFG']['shop_logo'];
    $smarty->assign('shoplogo',        $shoplogo);//商家logo
    $smarty->assign('shopname',        htmlspecialchars($GLOBALS['_CFG']['shop_name']));//店铺名称
    $smarty->assign('username',        htmlspecialchars($suppinfo['supplier_name']));//商家名称
    $smarty->assign('userrank',        htmlspecialchars($suppinfo['rank_name']));//商家等级
    $smarty->assign('service_phone',   $GLOBALS['_CFG']['service_phone']);//客服电话
    $smarty->assign('region', get_province_city($GLOBALS['_CFG']['shop_province'],$GLOBALS['_CFG']['shop_city']));
    $smarty->assign('address', $GLOBALS['_CFG']['shop_address']);
    $smarty->assign('createtime',      gmdate('Y-m-d',$suppinfo['add_time']));//商家创建时间
    $smarty->assign('goodsnum',      get_supplier_goods_count());//商家商品数量
    $smarty->assign('keywords',        htmlspecialchars($GLOBALS['_CFG']['shop_keywords']));
    $smarty->assign('description',     htmlspecialchars($GLOBALS['_CFG']['shop_desc']));
    $smarty->assign('navcolor',     $GLOBALS['_CFG']['shop_header_color']);  // 头部
    $smarty->assign('shopheader',     $GLOBALS['_CFG']['shop_header_text']);  // 头部
    $smarty->assign('flash_theme',     $GLOBALS['_CFG']['flash_theme']);  // Flash轮播图片模板
    $smarty->assign('shop_notice',     $GLOBALS['_CFG']['shop_notice']);       // 商店公告
    $smarty->assign('search_price',     $index_price);       // 导航上搜索条件中的价格条件
    $smarty->assign('suppid',     $_GET['suppId']);//获取店铺id，首页生成店铺二维码用 lw
   
    $smarty->assign('navigator_list_supplier',        get_navigator_supplier($ctype, $catlist));  //自定义导航栏
    
    $smarty->assign('top_goods',       get_top10_supplier());           // 销售排行

    if (!empty($GLOBALS['_CFG']['search_keywords']))
    {
        $searchkeywords = explode(',', trim($GLOBALS['_CFG']['search_keywords']));
    }
    else
    {
        $searchkeywords = array();
    }
    $smarty->assign('searchkeywords', $searchkeywords);
}

/**
 * 添加商品名样式
 * @param   string     $goods_name     商品名称
 * @param   string     $style          样式参数
 * @return  string
 */
function add_style_supplier($goods_name, $style)
{
    $goods_style_name = $goods_name;

    $arr   = explode('+', $style);

    $font_color     = !empty($arr[0]) ? $arr[0] : '';
    $font_style = !empty($arr[1]) ? $arr[1] : '';

    if ($font_color!='')
    {
        $goods_style_name = '<font color=' . $font_color . '>' . $goods_style_name . '</font>';
    }
    if ($font_style != '')
    {
        $goods_style_name = '<' . $font_style .'>' . $goods_style_name . '</' . $font_style . '>';
    }
    return $goods_style_name;
}

/**
 * 获得指定的规格的价格
 *
 * @access  public
 * @param   mix     $spec   规格ID的数组或者逗号分隔的字符串
 * @return  void
 */
function spec_price_supplier($spec)
{
    if (!empty($spec))
    {
        if(is_array($spec))
        {
            foreach($spec as $key=>$val)
            {
                $spec[$key]=addslashes($val);
            }
        }
        else
        {
            $spec=addslashes($spec);
        }

        $where = db_create_in($spec, 'goods_attr_id');

        $sql = 'SELECT SUM(attr_price) AS attr_price FROM ' . $GLOBALS['ecs']->table('goods_attr') . " WHERE $where";
        $price = floatval($GLOBALS['db']->getOne($sql));
    }
    else
    {
        $price = 0;
    }

    return $price;
}


/**
 * 取得自定义导航栏列表
 * @param   string      $type    位置，如top、bottom、middle
 * @return  array         列表
 */
function get_navigator_supplier($ctype = '', $catlist = array())
{
    $sql = 'SELECT * FROM '. $GLOBALS['ecs']->table('supplier_nav') . '
            WHERE ifshow = \'1\' AND supplier_id='.$_GET['suppId'].' ORDER BY type, vieworder';
    $res = $GLOBALS['db']->query($sql);

    $cur_url = substr(strrchr($_SERVER['REQUEST_URI'],'/'),1);

    if (intval($GLOBALS['_CFG']['rewrite']))
    {
        if(strpos($cur_url, '-'))
        {
            preg_match('/([a-z]*)-([0-9]*)/',$cur_url,$matches);
            $cur_url = $matches[1].'.php?id='.$matches[2];
        }
    }
    else
    {
        $cur_url = substr(strrchr($_SERVER['REQUEST_URI'],'/'),1);
    }

    $noindex = false;
    $active = 0;
    $navlist = array(
        'top' => array(),
        'middle' => array(),
        'bottom' => array()
    );
    while ($row = $GLOBALS['db']->fetchRow($res))
    {
        $navlist[$row['type']][] = array(
            'name'      =>  $row['name'],
            'opennew'   =>  $row['opennew'],
            'url'       =>  $row['url'],
            'ctype'     =>  $row['ctype'],
            'cid'       =>  $row['cid'],
            );
    }

    /*遍历自定义是否存在currentPage*/
    foreach($navlist['middle'] as $k=>$v)
    {
        $condition = empty($ctype) ? (strpos($cur_url, $v['url']) === 0) : (strpos($cur_url, $v['url']) === 0 && strlen($cur_url) == strlen($v['url']));
        if ($condition)
        {
            $navlist['middle'][$k]['active'] = 1;
            $noindex = true;
            $active += 1;
        }
    }

    if(!empty($ctype) && $active < 1)
    {
        foreach($catlist as $key => $val)
        {
            foreach($navlist['middle'] as $k=>$v)
            {
                if(!empty($v['ctype']) && $v['ctype'] == $ctype && $v['cid'] == $val && $active < 1)
                {
                    $navlist['middle'][$k]['active'] = 1;
                    $noindex = true;
                    $active += 1;
                }
            }
        }
    }

    if ($noindex == false) {
        $navlist['config']['index'] = 1;
    }

    return $navlist;
}

/**
 * 载入配置信息
 *
 * @access  public
 * @return  array
 */
function load_config_supplier()
{
    $arr = array();
    
    $suppid = (isset($_GET['suppId'])&& intval($_GET['suppId'])>0) ? intval($_GET['suppId']) : (isset($_SESSION['supplier_id']) ? $_SESSION['supplier_id'] : 0);
    if($suppid <= 0){
    	return $arr;
    }

    $data = read_static_cache('supplier_shop_config'.$suppid);
    if ($data === false)
    {
        $sql = 'SELECT code, value FROM ' . $GLOBALS['ecs']->table('supplier_shop_config') . ' WHERE parent_id > 0 AND supplier_id='.$suppid;
        $res = $GLOBALS['db']->getAll($sql);

        foreach ($res AS $row)
        {
            $arr[$row['code']] = $row['value'];
        }

        /* 对数值型设置处理 */
        /*
        $arr['watermark_alpha']      = intval($arr['watermark_alpha']);
        $arr['market_price_rate']    = floatval($arr['market_price_rate']);
        $arr['integral_scale']       = floatval($arr['integral_scale']);
        //$arr['integral_percent']     = floatval($arr['integral_percent']);
        $arr['cache_time']           = intval($arr['cache_time']);
        $arr['thumb_width']          = intval($arr['thumb_width']);
        $arr['thumb_height']         = intval($arr['thumb_height']);
        $arr['image_width']          = intval($arr['image_width']);
        $arr['image_height']         = intval($arr['image_height']);
        $arr['best_number']          = !empty($arr['best_number']) && intval($arr['best_number']) > 0 ? intval($arr['best_number'])     : 3;
        $arr['new_number']           = !empty($arr['new_number']) && intval($arr['new_number']) > 0 ? intval($arr['new_number'])      : 3;
        $arr['hot_number']           = !empty($arr['hot_number']) && intval($arr['hot_number']) > 0 ? intval($arr['hot_number'])      : 3;
        $arr['promote_number']       = !empty($arr['promote_number']) && intval($arr['promote_number']) > 0 ? intval($arr['promote_number'])  : 3;
        $arr['top_number']           = intval($arr['top_number'])      > 0 ? intval($arr['top_number'])      : 10;
        $arr['history_number']       = intval($arr['history_number'])  > 0 ? intval($arr['history_number'])  : 5;
        $arr['comments_number']      = intval($arr['comments_number']) > 0 ? intval($arr['comments_number']) : 5;
        $arr['article_number']       = intval($arr['article_number'])  > 0 ? intval($arr['article_number'])  : 5;
        $arr['page_size']            = intval($arr['page_size'])       > 0 ? intval($arr['page_size'])       : 10;
        $arr['bought_goods']         = intval($arr['bought_goods']);
        $arr['goods_name_length']    = intval($arr['goods_name_length']);
        $arr['top10_time']           = intval($arr['top10_time']);
        $arr['goods_gallery_number'] = intval($arr['goods_gallery_number']) ? intval($arr['goods_gallery_number']) : 5;
        $arr['no_picture']           = !empty($arr['no_picture']) ? str_replace('../', './', $arr['no_picture']) : 'images/no_picture.gif'; // 修改默认商品图片的路径
        $arr['qq']                   = !empty($arr['qq']) ? $arr['qq'] : '';
        $arr['ww']                   = !empty($arr['ww']) ? $arr['ww'] : '';
        $arr['default_storage']      = isset($arr['default_storage']) ? intval($arr['default_storage']) : 1;
        $arr['min_goods_amount']     = isset($arr['min_goods_amount']) ? floatval($arr['min_goods_amount']) : 0;
        $arr['one_step_buy']         = empty($arr['one_step_buy']) ? 0 : 1;
        $arr['invoice_type']         = empty($arr['invoice_type']) ? array('type' => array(), 'rate' => array()) : unserialize($arr['invoice_type']);
        $arr['show_order_type']      = isset($arr['show_order_type']) ? $arr['show_order_type'] : 0;    // 显示方式默认为列表方式
        $arr['help_open']            = isset($arr['help_open']) ? $arr['help_open'] : 1;    // 显示方式默认为列表方式
        */
        
        if (!isset($GLOBALS['_CFG']['ecs_version']))
        {
            /* 如果没有版本号则默认为2.0.5 */
            $GLOBALS['_CFG']['ecs_version'] = 'v2.0.5';
        }

        //限定语言项
        $lang_array = array('zh_cn', 'zh_tw', 'en_us');
        //if (empty($arr['lang']) || !in_array($arr['lang'], $lang_array))
        //{
            $arr['lang'] = 'zh_cn'; // 默认语言为简体中文
        //}

        //if (empty($arr['integrate_code']))
        //{
            $arr['integrate_code'] = 'ecshop'; // 默认的会员整合插件为 ecshop
        //}
        write_static_cache('supplier_shop_config'.$suppid, $arr);
    }
    else
    {
        $arr = $data;
    }

    return $arr;
}

/**
 * 获得指定分类同级的所有分类以及该分类下的子分类
 *
 * @access  public
 * @param   integer     $cat_id     分类编号
 * @return  array
 */
function get_categories_tree_supplier($cat_id = 0)
{
    if ($cat_id > 0)
    {
        $sql = 'SELECT parent_id FROM ' . $GLOBALS['ecs']->table('supplier_category') . " WHERE cat_id = '$cat_id' AND supplier_id=".$_GET['suppId'];
        $parent_id = $GLOBALS['db']->getOne($sql);
    }
    else
    {
        $parent_id = 0;
    }

    /*
     判断当前分类中全是是否是底级分类，
     如果是取出底级分类上级分类，
     如果不是取当前分类及其下的子分类
    */
    $sql = 'SELECT count(*) FROM ' . $GLOBALS['ecs']->table('supplier_category') . " WHERE parent_id = '$parent_id' AND is_show = 1 AND supplier_id=".$_GET['suppId'];
    if ($GLOBALS['db']->getOne($sql) || $parent_id == 0)
    {
        /* 获取当前分类及其子分类 */
        $sql = 'SELECT cat_id,cat_name ,parent_id,is_show ' .
                'FROM ' . $GLOBALS['ecs']->table('supplier_category') .
                "WHERE parent_id = '$parent_id' AND is_show = 1 AND supplier_id=".$_GET['suppId']." ORDER BY sort_order ASC, cat_id ASC";

        $res = $GLOBALS['db']->getAll($sql);

        foreach ($res AS $row)
        {
            if ($row['is_show'])
            {
                $cat_arr[$row['cat_id']]['id']   = $row['cat_id'];
                $cat_arr[$row['cat_id']]['name'] = $row['cat_name'];
                $cat_arr[$row['cat_id']]['url']  = build_uri('supplier', array('go'=>'category','suppid'=>$_GET['suppId'],'cid' => $row['cat_id']), $row['cat_name']);

                if (isset($row['cat_id']) != NULL)
                {
                    $cat_arr[$row['cat_id']]['cat_id'] = get_child_tree_supplier($row['cat_id']);
                }
            }
        }
    }
    if(isset($cat_arr))
    {
        return $cat_arr;
    }
}

function get_child_tree_supplier($tree_id = 0)
{
    $three_arr = array();
    $sql = 'SELECT count(*) FROM ' . $GLOBALS['ecs']->table('supplier_category') . " WHERE parent_id = '$tree_id' AND is_show = 1 AND supplier_id=".$_GET['suppId'];
    if ($GLOBALS['db']->getOne($sql) || $tree_id == 0)
    {
        $child_sql = 'SELECT cat_id, cat_name, parent_id, is_show ' .
                'FROM ' . $GLOBALS['ecs']->table('supplier_category') .
                "WHERE parent_id = '$tree_id' AND is_show = 1 AND supplier_id=".$_GET['suppId']." ORDER BY sort_order ASC, cat_id ASC";
        $res = $GLOBALS['db']->getAll($child_sql);
        foreach ($res AS $row)
        {
            if ($row['is_show'])

               $three_arr[$row['cat_id']]['id']   = $row['cat_id'];
               $three_arr[$row['cat_id']]['name'] = $row['cat_name'];
               $three_arr[$row['cat_id']]['url']  = build_uri('supplier', array('go'=>'category','suppid'=>$_GET['suppId'],'cid' => $row['cat_id']), $row['cat_name']);

               if (isset($row['cat_id']) != NULL)
                   {
                       $three_arr[$row['cat_id']]['cat_id'] = get_child_tree_supplier($row['cat_id']);

            }
        }
    }
    return $three_arr;
}

/**
 * 获得指定分类下所有底层分类的ID
 *
 * @access  public
 * @param   integer     $cat        指定的分类ID
 * @param   string      $attr		用来标记sql语句中表简省的前缀
 * @return  string
 */
function get_children_supplier($cat = 0,$attr='sgc')
{
    return $attr.'.cat_id ' . db_create_in(array_unique(array_merge(array($cat), array_keys(cat_list_supplier($cat, 0, false)))));
}

/**
 * 获得指定分类下的子分类的数组
 *
 * @access  public
 * @param   int     $cat_id     分类的ID
 * @param   int     $selected   当前选中分类的ID
 * @param   boolean $re_type    返回的类型: 值为真时返回下拉列表,否则返回数组
 * @param   int     $level      限定返回的级数。为0时返回所有级数
 * @param   int     $is_show_all 如果为true显示所有分类，如果为false隐藏不可见分类。
 * @return  mix
 */
function cat_list_supplier($cat_id = 0, $selected = 0, $re_type = true, $level = 0, $is_show_all = true)
{
    static $res = NULL;
    
    $suppid = (isset($_GET['suppId']) && intval($_GET['suppId'])>0) ? intval($_GET['suppId']) : $_SESSION['supplier_id'];

    if ($res === NULL)
    {
        
            $sql = "SELECT c.cat_id, c.cat_name, c.measure_unit, c.parent_id, c.is_show, c.show_in_nav, c.grade, c.sort_order, COUNT(s.cat_id) AS has_children ".
                'FROM ' . $GLOBALS['ecs']->table('supplier_category') . " AS c ".
                "LEFT JOIN " . $GLOBALS['ecs']->table('supplier_category') . " AS s ON s.parent_id=c.cat_id  where c.supplier_id = ".$suppid.
                " GROUP BY c.cat_id ".
                'ORDER BY c.parent_id, c.sort_order ASC';
            $res = $GLOBALS['db']->getAll($sql);

            /*$sql = "SELECT cat_id, COUNT(*) AS goods_num " .
                    " FROM " . $GLOBALS['ecs']->table('goods') .
                    " WHERE supplier_id = ".$_SESSION['supplier_id']." AND is_delete = 0 AND is_on_sale = 1 " .
                    " GROUP BY cat_id";
            $res2 = $GLOBALS['db']->getAll($sql);*/

            $sql = "SELECT gc.cat_id, COUNT(*) AS goods_num " .
                    " FROM " . $GLOBALS['ecs']->table('supplier_goods_cat') . " AS gc , " . $GLOBALS['ecs']->table('goods') . " AS g " .
                    " WHERE gc.supplier_id = ".$suppid." AND g.goods_id = gc.goods_id AND g.is_delete = 0 AND g.is_on_sale = 1 " .
                    " GROUP BY gc.cat_id";
            $res3 = $GLOBALS['db']->getAll($sql);

            $newres = array();
            //foreach($res2 as $k=>$v)
            //{
                //$newres[$v['cat_id']] = $v['goods_num'];
                foreach($res3 as $ks=>$vs)
                {
                	$newres[$vs['cat_id']] = $vs['goods_num'];
                   // if($v['cat_id'] == $vs['cat_id'])
                    //{
                    //$newres[$v['cat_id']] = $v['goods_num'] + $vs['goods_num'];
                   // }
                }
            //}

            foreach($res as $k=>$v)
            {
                $res[$k]['goods_num'] = !empty($newres[$v['cat_id']]) ? $newres[$v['cat_id']] : 0;
            }
        
    }

    if (empty($res) == true)
    {
        return $re_type ? '' : array();
    }

    $options = cat_options_supplier($cat_id, $res); // 获得指定分类下的子分类的数组

    $children_level = 99999; //大于这个分类的将被删除
    if ($is_show_all == false)
    {
        foreach ($options as $key => $val)
        {
            if ($val['level'] > $children_level)
            {
                unset($options[$key]);
            }
            else
            {
                if ($val['is_show'] == 0)
                {
                    unset($options[$key]);
                    if ($children_level > $val['level'])
                    {
                        $children_level = $val['level']; //标记一下，这样子分类也能删除
                    }
                }
                else
                {
                    $children_level = 99999; //恢复初始值
                }
            }
        }
    }

    /* 截取到指定的缩减级别 */
    if ($level > 0)
    {
        if ($cat_id == 0)
        {
            $end_level = $level;
        }
        else
        {
            $first_item = reset($options); // 获取第一个元素
            $end_level  = $first_item['level'] + $level;
        }

        /* 保留level小于end_level的部分 */
        foreach ($options AS $key => $val)
        {
            if ($val['level'] >= $end_level)
            {
                unset($options[$key]);
            }
        }
    }

    if ($re_type == true)
    {
        $select = '';
        foreach ($options AS $var)
        {
            $select .= '<option value="' . $var['cat_id'] . '" ';
            $select .= ($selected == $var['cat_id']) ? "selected='ture'" : '';
            $select .= '>';
            if ($var['level'] > 0)
            {
                $select .= str_repeat('&nbsp;', $var['level'] * 4);
            }
            $select .= htmlspecialchars(addslashes($var['cat_name']), ENT_QUOTES) . '</option>';
        }

        return $select;
    }
    else
    {
        foreach ($options AS $key => $value)
        {
            $options[$key]['url'] = build_uri('category', array('cid' => $value['cat_id']), $value['cat_name']);
        }

        return $options;
    }
}

/**
 * 过滤和排序所有分类，返回一个带有缩进级别的数组
 *
 * @access  private
 * @param   int     $cat_id     上级分类ID
 * @param   array   $arr        含有所有分类的数组
 * @param   int     $level      级别
 * @return  void
 */
function cat_options_supplier($spec_cat_id, $arr)
{
    static $cat_options = array();

    if (isset($cat_options[$spec_cat_id]))
    {
        return $cat_options[$spec_cat_id];
    }

    if (!isset($cat_options[0]))
    {
        $level = $last_cat_id = 0;
        $options = $cat_id_array = $level_array = array();
        
            while (!empty($arr))
            {
                foreach ($arr AS $key => $value)
                {
                    $cat_id = $value['cat_id'];
                    if ($level == 0 && $last_cat_id == 0)
                    {
                        if ($value['parent_id'] > 0)
                        {
                            break;
                        }

                        $options[$cat_id]          = $value;
                        $options[$cat_id]['level'] = $level;
                        $options[$cat_id]['id']    = $cat_id;
                        $options[$cat_id]['name']  = $value['cat_name'];
                        unset($arr[$key]);

                        if ($value['has_children'] == 0)
                        {
                            continue;
                        }
                        $last_cat_id  = $cat_id;
                        $cat_id_array = array($cat_id);
                        $level_array[$last_cat_id] = ++$level;
                        continue;
                    }

                    if ($value['parent_id'] == $last_cat_id)
                    {
                        $options[$cat_id]          = $value;
                        $options[$cat_id]['level'] = $level;
                        $options[$cat_id]['id']    = $cat_id;
                        $options[$cat_id]['name']  = $value['cat_name'];
                        unset($arr[$key]);

                        if ($value['has_children'] > 0)
                        {
                            if (end($cat_id_array) != $last_cat_id)
                            {
                                $cat_id_array[] = $last_cat_id;
                            }
                            $last_cat_id    = $cat_id;
                            $cat_id_array[] = $cat_id;
                            $level_array[$last_cat_id] = ++$level;
                        }
                    }
                    elseif ($value['parent_id'] > $last_cat_id)
                    {
                        break;
                    }
                }

                $count = count($cat_id_array);
                if ($count > 1)
                {
                    $last_cat_id = array_pop($cat_id_array);
                }
                elseif ($count == 1)
                {
                    if ($last_cat_id != end($cat_id_array))
                    {
                        $last_cat_id = end($cat_id_array);
                    }
                    else
                    {
                        $level = 0;
                        $last_cat_id = 0;
                        $cat_id_array = array();
                        continue;
                    }
                }

                if ($last_cat_id && isset($level_array[$last_cat_id]))
                {
                    $level = $level_array[$last_cat_id];
                }
                else
                {
                    $level = 0;
                }
            }
            
        $cat_options[0] = $options;
    }
    else
    {
        $options = $cat_options[0];
    }

    if (!$spec_cat_id)
    {
        return $options;
    }
    else
    {
        if (empty($options[$spec_cat_id]))
        {
            return array();
        }

        $spec_cat_id_level = $options[$spec_cat_id]['level'];

        foreach ($options AS $key => $value)
        {
            if ($key != $spec_cat_id)
            {
                unset($options[$key]);
            }
            else
            {
                break;
            }
        }

        $spec_cat_id_array = array();
        foreach ($options AS $key => $value)
        {
            if (($spec_cat_id_level == $value['level'] && $value['cat_id'] != $spec_cat_id) ||
                ($spec_cat_id_level > $value['level']))
            {
                break;
            }
            else
            {
                $spec_cat_id_array[$key] = $value;
            }
        }
        $cat_options[$spec_cat_id] = $spec_cat_id_array;

        return $spec_cat_id_array;
    }
}

/**
 * 调用当前分类的销售排行榜
 *
 * @access  public
 * @param   string  $cats   查询的分类
 * @return  array
 */
function get_top10_supplier($cats = '')
{
	$suppid = (isset($_GET['suppId']) && intval($_GET['suppId'])>0) ? intval($_GET['suppId']) : $_SESSION['supplier_id'];
	
    $cats = get_children($cats);
    $where = "AND g.supplier_id=".$suppid;
    $where .= !empty($cats) ? " AND ($cats OR " . get_extension_goods($cats) . ") " : '';

    /* 排行统计的时间 */
    switch ($GLOBALS['_CFG']['top10_time'])
    {
        case 1: // 一年
            $top10_time = "AND o.order_sn >= '" . date('Ymd', gmtime() - 365 * 86400) . "'";
        break;
        case 2: // 半年
            $top10_time = "AND o.order_sn >= '" . date('Ymd', gmtime() - 180 * 86400) . "'";
        break;
        case 3: // 三个月
            $top10_time = "AND o.order_sn >= '" . date('Ymd', gmtime() - 90 * 86400) . "'";
        break;
        case 4: // 一个月
            $top10_time = "AND o.order_sn >= '" . date('Ymd', gmtime() - 30 * 86400) . "'";
        break;
        default:
            $top10_time = '';
    }

    $sql = 'SELECT g.goods_id, g.goods_name, g.shop_price, g.market_price, g.original_img, g.goods_thumb, SUM(og.goods_number) as goods_number, g.supplier_id ' .
           'FROM ' . $GLOBALS['ecs']->table('goods') . ' AS g, ' .
                $GLOBALS['ecs']->table('order_info') . ' AS o, ' .
                $GLOBALS['ecs']->table('order_goods') . ' AS og ' .
           "WHERE g.is_on_sale = 1 AND g.is_alone_sale = 1 AND g.is_delete = 0 $where $top10_time " ;
    //判断是否启用库存，库存数量是否大于0
    if ($GLOBALS['_CFG']['use_storage'] == 1)
    {
        $sql .= " AND g.goods_number > 0 ";
    }
    $sql .= ' AND og.order_id = o.order_id AND og.goods_id = g.goods_id ' .
           "AND (o.order_status = '" . OS_CONFIRMED .  "' OR o.order_status = '" . OS_SPLITED . "') " .
           "AND (o.pay_status = '" . PS_PAYED . "' OR o.pay_status = '" . PS_PAYING . "') " .
           "AND (o.shipping_status = '" . SS_SHIPPED . "' OR o.shipping_status = '" . SS_RECEIVED . "') " .
           'GROUP BY g.goods_id ORDER BY goods_number DESC, g.goods_id DESC LIMIT ' . $GLOBALS['_CFG']['top_number'];
           
    $arr = $GLOBALS['db']->getAll($sql);

    for ($i = 0, $count = count($arr); $i < $count; $i++)
    {
        $arr[$i]['short_name'] = $GLOBALS['_CFG']['goods_name_length'] > 0 ?
                                    sub_str($arr[$i]['goods_name'], $GLOBALS['_CFG']['goods_name_length']) : $arr[$i]['goods_name'];
        $arr[$i]['url']        = build_uri('goods', array('gid' => $arr[$i]['goods_id']), $arr[$i]['goods_name']);
        $arr[$i]['thumb'] = get_image_path($arr[$i]['goods_id'], $arr[$i]['goods_thumb'],true);
	$arr[$i]['original_img'] = get_image_path($arr[$i]['goods_id'], $arr[$i]['original_img']);
        $arr[$i]['shop_price'] = price_format($arr[$i]['shop_price']);
	$arr[$i]['market_price'] = price_format($arr[$i]['market_price']);
    }

    return $arr;
}

/**
 * 获得所有扩展分类属于指定分类的所有商品ID
 *
 * @access  public
 * @param   string $cat_id     分类查询字符串
 * @return  string
 */
function get_extension_goods_supplier($cats)
{
    $extension_goods_array = '';
    $suppid = (isset($_GET['suppId']) && intval($_GET['suppId'])>0) ? intval($_GET['suppId']) : $_SESSION['supplier_id'];
    $sql = 'SELECT goods_id FROM ' . $GLOBALS['ecs']->table('supplier_goods_cat') . " AS sgc WHERE $cats";
    $extension_goods_array = $GLOBALS['db']->getCol($sql);
    return db_create_in($extension_goods_array, 'sgc.goods_id');
}

?>