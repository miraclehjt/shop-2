<?php

/**
 * 鸿宇多用户商城 提交用户咨询
 * ============================================================================
 * 版权所有 2005-2010 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $   Author: QQ123456789 $
 * $   bbs.hongyuvip.com $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
require(ROOT_PATH . 'includes/cls_json.php');

if (!isset($_REQUEST['cmt']) && !isset($_REQUEST['act']))
{
    /* 只有在没有提交咨询内容以及没有act的情况下才跳转 */
    ecs_header("Location: ./\n");
    exit;
}
$_REQUEST['cmt'] = isset($_REQUEST['cmt']) ? json_str_iconv($_REQUEST['cmt']) : '';

$json   = new JSON;
$result = array('error' => 0, 'message' => '', 'content' => '');

if (empty($_REQUEST['act']))
{
    /*
     * act 参数为空
     * 默认为添加咨询内容
     */
    $cmt  = $json->decode($_REQUEST['cmt']);
    $cmt->page = 1;
    $cmt->id   = !empty($cmt->id)   ? intval($cmt->id) : 0;

    if (empty($cmt) ||  !isset($cmt->id))
    {
        $result['error']   = 1;
        $result['message'] = '此咨询无效！';
    }
    elseif (!is_email($cmt->email))
    {
        $result['error']   = 1;
        $result['message'] = $_LANG['error_email'];
    }
    else
    {
        if ((intval($_CFG['captcha']) & CAPTCHA_QUESTION) && gd_version() > 0)
        {
            /* 检查验证码 */
            include_once('includes/cls_captcha.php');

            $validator = new captcha();
			$validator->session_word = 'captcha_zixun';
            if (!$validator->check_word($cmt->captcha))
            {
                $result['error']   = 1;
                $result['message'] = $_LANG['invalid_captcha'];
            }
            else
            {

                /* 无错误就保存留言 */
                if (empty($result['error']))
                {
                    add_question($cmt);
                }
            }
        }
        else
        {
            /* 没有验证码时，用时间来限制机器人发帖或恶意发评论 */
            if (!isset($_SESSION['send_time']))
            {
                $_SESSION['send_time'] = 0;
            }

            $cur_time = gmtime();
            if (($cur_time - $_SESSION['send_time']) < 30) // 小于30秒禁止发评论
            {
                $result['error']   = 1;
                $result['message'] = $_LANG['cmt_spam_warning'];
            }
            else
            {


                /* 无错误就保存留言 */
                if (empty($result['error']))
                {
                    add_question($cmt);
                    $_SESSION['send_time'] = $cur_time;
                }
            }
        }
    }
}
else
{
    /*
     * act 参数不为空
     * 默认为咨询内容列表
     * 根据 _GET 创建一个静态对象
     */
    $cmt = new stdClass();
    $cmt->id   = !empty($_GET['id'])   ? intval($_GET['id'])   : 0;
    $cmt->type = !empty($_GET['type']) ? intval($_GET['type']) : 0;
    $cmt->page = !empty($_GET['page']) ? intval($_GET['page']) : 1;
	$cmt->question_type = !empty($_GET['question_type']) ? intval($_GET['question_type']) : 0;
}

if ($result['error'] == 0)
{
    $comments = assign_question($cmt->id, $cmt->page, $cmt->question_type);

    $smarty->assign('id',           $cmt->id);
    $smarty->assign('username',     $_SESSION['user_name']);
    $smarty->assign('email',        $_SESSION['email']);
    $smarty->assign('question_list',     $comments['comments']);
    $smarty->assign('pager',        $comments['pager']);

    /* 验证码相关设置 */
    if ((intval($_CFG['captcha']) & CAPTCHA_QUESTION) && gd_version() > 0)
    {
        $smarty->assign('enabled_captcha_question', 1);
        $smarty->assign('rand', mt_rand());
    }

    $result['message'] = $_CFG['comment_check'] ? '您的咨询已成功提交, 请等待管理员的审核!' : '您的咨询已成功提交, 感谢您的参与!';
    $result['content'] = $smarty->fetch("library/question_list.lbi");
	$result['question_type'] = $cmt->question_type;
	$result['goods_id'] = $cmt->id;
}

echo $json->encode($result);

/*------------------------------------------------------ */
//-- PRIVATE FUNCTION
/*------------------------------------------------------ */

/**
 * 添加咨询内容
 *
 * @access  public
 * @param   object  $cmt
 * @return  void
 */
function add_question($cmt)
{
    /* 咨询是否需要审核 */
    $status = 1 - $GLOBALS['_CFG']['comment_check'];

    $user_id = empty($_SESSION['user_id']) ? 0 : $_SESSION['user_id'];
    $email = empty($cmt->email) ? $_SESSION['email'] : trim($cmt->email);
    $user_name = empty($cmt->username) ? $_SESSION['user_name'] : trim($cmt->username);
    $email = htmlspecialchars($email);
	$question_type = empty($cmt->question_type) ? 0 : intval($cmt->question_type);
    $user_name = htmlspecialchars($user_name);

    /* 保存咨询内容 */
    $sql = "INSERT INTO " .$GLOBALS['ecs']->table('question') .
           "( id_value, question_type, email, user_name, content,  add_time, ip_address, status, parent_id, user_id) VALUES " .
           "('" .$cmt->id. "', '$question_type', '$email', '$user_name', '" .$cmt->content."', ".gmtime().", '".real_ip()."', '$status', '0', '$user_id')";

    $result = $GLOBALS['db']->query($sql);
    clear_cache_files('question_list.lbi');
    return $result;
}





?>