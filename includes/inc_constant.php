<?php

/**
 * 鸿宇多用户商城 常量
 * ============================================================================
 * 版权所有 2015-2016 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * $Author: Shadow & 鸿宇
 * $Id: inc_constant.php 17217 2016-01-19 06:29:08Z Shadow & 鸿宇
*/

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

/* 图片处理相关常数 */
define('ERR_INVALID_IMAGE',         1);
define('ERR_NO_GD',                 2);
define('ERR_IMAGE_NOT_EXISTS',      3);
define('ERR_DIRECTORY_READONLY',    4);
define('ERR_UPLOAD_FAILURE',        5);
define('ERR_INVALID_PARAM',         6);
define('ERR_INVALID_IMAGE_TYPE',    7);

/* 插件相关常数 */
define('ERR_COPYFILE_FAILED',       1);
define('ERR_CREATETABLE_FAILED',    2);
define('ERR_DELETEFILE_FAILED',     3);

/* 商品属性类型常数 */
define('ATTR_TEXT',                 0);
define('ATTR_OPTIONAL',             1);
define('ATTR_TEXTAREA',             2);
define('ATTR_URL',                  3);

/* 会员整合相关常数 */
define('ERR_USERNAME_EXISTS',       1); // 用户名已经存在
define('ERR_EMAIL_EXISTS',          2); // Email已经存在
define('ERR_INVALID_USERID',        3); // 无效的user_id
define('ERR_INVALID_USERNAME',      4); // 无效的用户名
define('ERR_INVALID_PASSWORD',      5); // 密码错误
define('ERR_INVALID_EMAIL',         6); // email错误
define('ERR_USERNAME_NOT_ALLOW',    7); // 用户名不允许注册
define('ERR_EMAIL_NOT_ALLOW',       8); // EMAIL不允许注册
define('ERR_MOBILE_PHONE_EXISTS',	9); // 手机号码已经存在
define('ERR_INVALID_MOBILE_PHONE',	10); // 手机号码错误
define('ERR_MOBILE_PHONE_NOT_ALLOW',11); // 手机号码不允许注册
define('ERR_INVALID_REGISTER_TYPE',	12); // 无效的注册类型

/* 加入购物车失败的错误代码 */
define('ERR_NOT_EXISTS',            1); // 商品不存在
define('ERR_OUT_OF_STOCK',          2); // 商品缺货
define('ERR_NOT_ON_SALE',           3); // 商品已下架
define('ERR_CANNT_ALONE_SALE',      4); // 商品不能单独销售
define('ERR_NO_BASIC_GOODS',        5); // 没有基本件
define('ERR_NEED_SELECT_ATTR',      6); // 需要用户选择属性

/* 购物车商品类型 */
define('CART_GENERAL_GOODS',        0); // 普通商品
define('CART_GROUP_BUY_GOODS',      1); // 团购商品
define('CART_AUCTION_GOODS',        2); // 拍卖商品
define('CART_SNATCH_GOODS',         3); // 夺宝奇兵
define('CART_EXCHANGE_GOODS',       4); // 积分商城
define('CART_PRE_SALE_GOODS',	    6); // 预售商品
define('CART_VIRTUAL_GROUP_GOODS',  7); // 虚拟团购


/* 订单状态 */
define('OS_UNCONFIRMED',            0); // 未确认
define('OS_CONFIRMED',              1); // 已确认
define('OS_CANCELED',               2); // 已取消
define('OS_INVALID',                3); // 无效
define('OS_RETURNED',               4); // 退货
define('OS_SPLITED',                5); // 已分单
define('OS_SPLITING_PART',          6); // 部分分单

/* 支付类型 */
define('PAY_ORDER',                 0); // 订单支付
define('PAY_SURPLUS',               1); // 会员预付款

/* 配送状态 */
define('SS_UNSHIPPED',              0); // 未发货
define('SS_SHIPPED',                1); // 已发货
define('SS_RECEIVED',               2); // 已收货
define('SS_PREPARING',              3); // 备货中
define('SS_SHIPPED_PART',           4); // 已发货(部分商品)
define('SS_SHIPPED_ING',            5); // 发货中(处理分单)
define('OS_SHIPPED_PART',           6); // 已发货(部分商品)

/* 支付状态 */
define('PS_UNPAYED',                0); // 未付款
define('PS_PAYING',                 1); // 付款中
define('PS_PAYED',                  2); // 已付款

/* 综合状态 */
define('CS_AWAIT_PAY',              100); // 待付款：货到付款且已发货且未付款，非货到付款且未付款
define('CS_AWAIT_SHIP',             101); // 待发货：货到付款且未发货，非货到付款且已付款且未发货
define('CS_FINISHED',               102); // 已完成：已确认、已付款、已发货

/* 缺货处理 */
define('OOS_WAIT',                  0); // 等待货物备齐后再发
define('OOS_CANCEL',                1); // 取消订单
define('OOS_CONSULT',               2); // 与店主协商

/* 帐户明细类型 */
define('SURPLUS_SAVE',              0); // 为帐户冲值
define('SURPLUS_RETURN',            1); // 从帐户提款

/* 评论状态 */
define('COMMENT_UNCHECKED',         0); // 未审核
define('COMMENT_CHECKED',           1); // 已审核或已回复(允许显示)
define('COMMENT_REPLYED',           2); // 该评论的内容属于回复

/* 红包发放的方式 */
define('SEND_BY_USER',              0); // 按用户发放
define('SEND_BY_GOODS',             1); // 按商品发放
define('SEND_BY_ORDER',             2); // 按订单发放
define('SEND_BY_PRINT',             3); // 线下发放
define('SEND_BY_REGISTER',    5); // 按注册用户发放      代码增加  BY  bbs.hongyuvip.com
define('SEND_BY_ONLINE',             4); // 线上发放
 
/* 广告的类型 */
define('IMG_AD',                    0); // 图片广告
define('FALSH_AD',                  1); // flash广告
define('CODE_AD',                   2); // 代码广告
define('TEXT_AD',                   3); // 文字广告

/* 是否需要用户选择属性 */
define('ATTR_NOT_NEED_SELECT',      0); // 不需要选择
define('ATTR_NEED_SELECT',          1); // 需要选择

/* 用户中心留言类型 */
define('M_MESSAGE',                 0); // 留言
define('M_COMPLAINT',               1); // 投诉
define('M_ENQUIRY',                 2); // 询问
define('M_CUSTOME',                 3); // 售后
define('M_BUY',                     4); // 求购
define('M_BUSINESS',                5); // 商家
define('M_COMMENT',                 6); // 评论

/* 团购活动状态 */
define('GROUP_BUY_CODE',			'group_by'); // 团购的代码标识
define('GBS_PRE_START',             0); // 未开始
define('GBS_UNDER_WAY',             1); // 进行中
define('GBS_FINISHED',              2); // 已结束
define('GBS_SUCCEED',               3); // 团购成功（可以发货了）
define('GBS_FAIL',                  4); // 团购失败

/* 预售活动状态 */
define('PRE_SALE_CODE',				'pre_sale'); // 预售的代码标识
define('VIRTUAL_SALE_CODE',    'virtual_good'); //虚拟团购标识
define('PSS_PRE_START',             0); // 未开始
define('PSS_UNDER_WAY',             1); // 进行中
define('PSS_FINISHED',              2); // 已结束
define('PSS_SUCCEED',               3); // 预售成功（可以发货了）
define('PSS_FAIL',                  4); // 预售失败

/* 红包是否发送邮件 */
define('BONUS_NOT_MAIL',            0);
define('BONUS_MAIL_SUCCEED',        1);
define('BONUS_MAIL_FAIL',           2);

/* 商品活动类型 */
define('GAT_SNATCH',                0);
define('GAT_GROUP_BUY',             1);
define('GAT_AUCTION',               2);
define('GAT_POINT_BUY',             3);
define('GAT_PACKAGE',               4); // 超值礼包
define('GAT_PRE_SALE',              5); // 预售活动

/* 帐号变动类型 */
define('ACT_SAVING',                0);     // 帐户冲值
define('ACT_DRAWING',               1);     // 帐户提款
define('ACT_ADJUSTING',             2);     // 调节帐户
define('ACT_OTHER',                99);     // 其他类型

/* 密码加密方法 */
define('PWD_MD5',                   1);  //md5加密方式
define('PWD_PRE_SALT',              2);  //前置验证串的加密方式
define('PWD_SUF_SALT',              3);  //后置验证串的加密方式

/* 文章分类类型 */
define('COMMON_CAT',                1); //普通分类
define('SYSTEM_CAT',                2); //系统默认分类
define('INFO_CAT',                  3); //网店信息分类
define('UPHELP_CAT',                4); //网店帮助分类分类
define('HELP_CAT',                  5); //网店帮助分类

/* 活动状态 */
define('PRE_START',                 0); // 未开始
define('UNDER_WAY',                 1); // 进行中
define('FINISHED',                  2); // 已结束
define('SETTLED',                   3); // 已处理

/* 验证码 */
define('CAPTCHA_REGISTER',          1); //注册时使用验证码
define('CAPTCHA_LOGIN',             2); //登录时使用验证码
define('CAPTCHA_COMMENT',           4); //评论时使用验证码
define('CAPTCHA_ADMIN',             8); //后台登录时使用验证码
define('CAPTCHA_LOGIN_FAIL',       16); //登录失败后显示验证码
define('CAPTCHA_MESSAGE',          32); //留言时使用验证码

/* 优惠活动的优惠范围 */
define('FAR_ALL',                   0); // 全部商品
define('FAR_CATEGORY',              1); // 按分类选择
define('FAR_BRAND',                 2); // 按品牌选择
define('FAR_GOODS',                 3); // 按商品选择

/* 优惠活动的优惠方式 */
define('FAT_GOODS',                 0); // 送赠品或优惠购买
define('FAT_PRICE',                 1); // 现金减免
define('FAT_DISCOUNT',              2); // 价格打折优惠

/* 评论条件 */
define('COMMENT_LOGIN',             1); //只有登录用户可以评论
define('COMMENT_CUSTOM',            2); //只有有过一次以上购买行为的用户可以评论
define('COMMENT_BOUGHT',            3); //只有购买够该商品的人可以评论

/* 减库存时机 */
define('SDT_SHIP',                  0); // 发货时
define('SDT_PLACE',                 1); // 下订单时

/* 加密方式 */
define('ENCRYPT_ZC',                1); //zc加密方式
define('ENCRYPT_UC',                2); //uc加密方式

/* 商品类别 */
define('G_REAL',                    1); //实体商品
define('G_CARD',                    0); //虚拟卡

/* 积分兑换 */
define('TO_P',                      0); //兑换到商城消费积分
define('FROM_P',                    1); //用商城消费积分兑换
define('TO_R',                      2); //兑换到商城等级积分
define('FROM_R',                    3); //用商城等级积分兑换

/* 支付宝商家账户 */
define('ALIPAY_AUTH', 'gh0bis45h89m5mwcoe85us4qrwispes0');
define('ALIPAY_ID', '2088002052150939');

/* 添加feed事件到UC的TYPE*/
define('BUY_GOODS',                 1); //购买商品
define('COMMENT_GOODS',             2); //添加商品评论

/* 邮件发送用户 */
define('SEND_LIST', 0);
define('SEND_USER', 1);
define('SEND_RANK', 2);

/*访问来源*/
define('WEB_FROM', 'pc');

/*佣金日志中的事件*/
define('REBATE_LOG_ORDER', 1);//佣金涉及到的订单
define('REBATE_LOG_LIST', 2);//佣金表状态

/* 生成静态页面的配置 */
define('PREFIX_CATEGORY', 'shangpin');   //保存 商品页、商品列表页的子目录前缀，不需要写 -
define('PREFIX_ARTICLECAT', 'wenzhang'); //保存 文章页、文章列表页的子目录前缀，不需要写 -
define('PREFIX_TOPIC', 'zhuanti');

/* license接口 */
define('LICENSE_VERSION', '1.0');

/* 配送方式 */
// define('SHIP_LIST', 'cac|city_express|ems|flat|fpd|post_express|post_mail|presswork|sf_express|sto_express|yto|zto');
// 增加配送方式
define('SHIP_LIST', 'cac|city_express|ems|flat|fpd|post_express|post_mail|presswork|sf_express|sto_express|yto|zto|yd_express|bestex|ttkd|zjs|qfkd|deppon');


/* 在线客服聊天 */
define('CUSTOMER_SERVICE', 0); //客服
define('CUSTOMER_PRE', 1); //售前
define('CUSTOMER_AFTER', 2); //售后

//聊天系统配置
define('CHAT_OF_TIMEOUT', '10');// 检查聊天服务是否正在运行的超时时间，单位：秒
define('CHAT_OF_SERVER_IP', '115.29.76.109');// 服务器IP地址
define('CHAT_OF_SERVER_PORT', '9090');// 服务器端口号
define('CHAT_OF_HTTP_BIND_PORT', '7070');// 服务器Http-Bind的端口号
define('CHAT_OF_ADMIN_USERNAME', 'admin');// OpenFire登录管理员用户名
define('CHAT_OF_ADMIN_PASSWORD', 'openfire@pwd');// OpenFire登录管理员密码，此密码与登录OpenFire管理界面保持一致

//验证记录
define('ERR_VALIDATE_KEY_NOT_EXIST', 0);// 验证信息不存在
define('ERR_VALIDATE_EXPIRED_TIME', 1);// 验证码已过期
define('ERR_VALIDATE_CODE_NOT_MATCH', 2);// 验证码错误

//验证类型
define('VT_EMAIL_REGISTER', 'email_register');// 邮箱注册
define('VT_MOBILE_REGISTER', 'mobile_register');// 手机注册
define('VT_EMAIL_FIND_PWD', 'email_find_password');// 邮箱找回密码
define('VT_MOBILE_FIND_PWD', 'mobile_find_password');// 手机号找回密码
define('VT_EMAIL_VALIDATE', 'email_validate');// 邮箱验证
define('VT_MOBILE_VALIDATE', 'mobile_validate');// 手机验证



?>