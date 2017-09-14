<?php

/**
 * 鸿宇多用户商城 调查程序
 * ============================================================================
 * 版权所有 2015-2016 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: Shadow & 鸿宇
 * $Id: vote.php 17217 2016-01-19 06:29:08Z Shadow & 鸿宇
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
require(ROOT_PATH . 'includes/cls_json.php');

if (!isset($_REQUEST['vote']) || !isset($_REQUEST['options']) || !isset($_REQUEST['type']))
{
    ecs_header("Location: ./\n");
    exit;
}

$res        = array('error' => 0, 'message' => '', 'content' => '');

$vote_id    = intval($_POST['vote']);
$options    = trim($_POST['options']);
$type       = intval($_POST['type']);
$ip_address = real_ip();

if (vote_already_submited($vote_id, $ip_address))
{
    $res['error']   = 1;
    $res['message'] = $_LANG['vote_ip_same'];
}
else
{
    save_vote($vote_id, $ip_address, $options);

    $vote = get_vote($vote_id);
    if (!empty($vote))
    {
        $smarty->assign('vote_id', $vote['id']);
        $smarty->assign('vote',    $vote['content']);
    }

    $str = $smarty->fetch("library/vote.lbi");

    $pattern = '/(?:<(\w+)[^>]*> .*?)?<div\s+id="ECS_VOTE">(.*)<\/div>(?:.*?<\/\1>)?/is';

    if (preg_match($pattern, $str, $match))
    {
        $res['content'] = $match[2];
    }
    $res['message'] = $_LANG['vote_success'];
}

$json = new JSON;

echo $json->encode($res);

/*------------------------------------------------------ */
//-- PRIVATE FUNCTION
/*------------------------------------------------------ */

/**
 * 检查是否已经提交过投票
 *
 * @access  private
 * @param   integer     $vote_id
 * @param   string      $ip_address
 * @return  boolean
 */
function vote_already_submited($vote_id, $ip_address)
{
    $sql = "SELECT COUNT(*) FROM ".$GLOBALS['ecs']->table('vote_log')." ".
           "WHERE ip_address = '$ip_address' AND vote_id = '$vote_id' ";

    return ($GLOBALS['db']->GetOne($sql) > 0);
}

/**
 * 保存投票结果信息
 *
 * @access  public
 * @param   integer     $vote_id
 * @param   string      $ip_address
 * @param   string      $option_id
 * @return  void
 */
function save_vote($vote_id, $ip_address, $option_id)
{
    $sql = "INSERT INTO " . $GLOBALS['ecs']->table('vote_log') . " (vote_id, ip_address, vote_time) " .
           "VALUES ('$vote_id', '$ip_address', " . gmtime() .")";
    $res = $GLOBALS['db']->query($sql);

    /* 更新投票主题的数量 */
    $sql = "UPDATE " .$GLOBALS['ecs']->table('vote'). " SET ".
           "vote_count = vote_count + 1 ".
           "WHERE vote_id = '$vote_id'";
    $GLOBALS['db']->query($sql);

    /* 更新投票选项的数量 */
    $sql = "UPDATE " . $GLOBALS['ecs']->table('vote_option') . " SET " .
           "option_count = option_count + 1 " .
           "WHERE " . db_create_in($option_id, 'option_id');
    $GLOBALS['db']->query($sql);
}

?>