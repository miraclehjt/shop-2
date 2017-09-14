/**
 * @type {string}
 * @description 窗口类型，分为window和popover两种
 *              使用open_page打开的窗口为popover
 *              使用open_win打开的窗口为window
 *				服务器端必须为popover
 */
var page_type = 'popover'
/**
 * @type {string}
 * @description 窗口名称
 *              默认是open_win和open_page函数的win_name参数
 */
var page_name = 'pay'
/**
 * 动画持续时间
 * 单位:ms(毫秒)
 */ 
/**
 * @constant
 * @type {number}
 * @description 1秒钟 
 */
var DUR_SECOND = 1000
/**
 * @constant
 * @type {number}
 * @description 1分钟 
 */
var DUR_MINUTE = 60000
/**
 * @constant
 * @type {number}
 * @description 1小时 
 */
var DUR_HOUR = 3600000
/**
 * @constant
 * @type {number}
 * @description 1天 
 */
var DUR_DAY = 86400000
/**
 * @constant
 * @type {number}
 * @description 默认动画时间
 *              一般用于 打开窗口、关闭窗口、加载动画
 */
var DUR_ANIMATION = 200
/**
 * @constant
 * @type {number}
 * @description 默认弹窗时间
 */
var DUR_TOAST = 1000
/**
 * @constant
 * @type {number}
 * @description 默认自动轮播事件
 */
var DUR_AUTO_PLAY = 2000
/**
 * @constant
 * @type {number}
 * @description 在多久之内点击两次后退键退出应用
 */
var DUR_BACK = 3000
/**
 * @constant
 * @type {number}
 * @description 音频默认播放时间
 */
var DUR_AUDIO = 2000
/**
 * @constant
 * @type {number}
 * @description 请求超时时间
 */
var DUR_REQUEST_TIMEOUT = 15000
/**
 * @constant
 * @type {number}
 * @description 定位超时时间
 */
var DUR_GET_ADDRESS = 30000
/**
 * @constant
 * @type {number}
 * @description 定位间隔时间，默认为一小时
 */
var DUR_CHECK_GPS_LOCATION = DUR_HOUR
/**
 * 事件ID
 * 用于发布事件和注册事件
 * 例如subscribe(CHANNEL_LOGIN_SUCCESS,some_func)注册了登录成功事件
 * publish(CHANNEL_LOGIN_SUCCESS)发布登录成功事件，就会执行some_func函数
 */
/**
 * @constant
 * @type {string}
 * @description 登录成功
 */
var CHANNEL_LOGIN_SUCCESS = '100'
/**
 * @constant
 * @type {string}
 * @description 刷新购物车数量
 */
var CHANNEL_UPDATE_CART = '101'
/**
 * @constant
 * @type {string}
 * @description 更新收货人信息
 */
var CHANNEL_UPDATE_CONSIGNEE = '102'
/**
 * @constant
 * @type {string}
 * @description 退出登录
 */
var CHANNEL_LOGOUT_SUCCESS = '103'
/**
 * @constant
 * @type {string}
 * @description 添加关注
 */
var CHANNEL_FOLLOW_SUPPLIER = '104'
/**
 * @constant
 * @type {string}
 * @description 取消关注
 */
var CHANNEL_UNFOLLOW_SUPPLIER = '105'
/**
 * @constant
 * @type {string}
 * @description 加入购物车
 */
var CHANNEL_ADD_TO_CART = '106'
/**
 * @constant
 * @type {string}
 * @description 保存收货人信息
 */
var CHANNEL_SAVE_CONSIGNEE = '107'
/**
 * @constant
 * @type {string}
 * @description 发布晒单
 */
var CHANNEL_SAVE_SHAIDAN = '108'
/**
 * @constant
 * @type {string}
 * @description 发送留言
 */
var CHANNEL_SEND_MESSAGE = '109'
/**
 * @constant
 * @type {string}
 * @description 添加收藏
 */
var CHANNEL_COLLECT_GOODS = '110'
/**
 * @constant
 * @type {string}
 * @description 取消收藏
 */
var CHANNEL_UNCOLLECT_GOODS = '111'
/**
 * @constant
 * @type {string}
 * @description 下单成功
 */
var CHANNEL_ORDER_DONE = '112'
/**
 * @constant
 * @type {string}
 * @description 收到推送消息
 */
var CHANNEL_RECEIVE_MESSAGE = '113'
/**
 * @constant
 * @type {string}
 * @description 添加推送消息
 */
var CHANNEL_UPDATE_MESSAGE = '114'
/**
 * @constant
 * @type {string}
 * @description 更新用户信息
 */
var CHANNEL_UPDATE_USER_INFO = '115'
/**
 * @constant
 * @type {string}
 * @description 注册成功
 */
var CHANNEL_REGISTER_SUCCESS = '116'
/**
 * @constant
 * @type {string}
 * @description 获取当前位置
 */
var CHANNEL_GET_ADDRESS = '117'
/**
 * @constant
 * @type {string}
 * @description 无法获取当前位置
 */
var CHANNEL_GET_ADDRESS_FAIL = '118'
/**
 * @constant
 * @type {string}
 * @description 支付完成，无论成功还是失败
 */
var CHANNEL_PAY_RESPOND = '119'
/**
 * @constant
 * @type {string}
 * @description 取消登录
 */
var CHANNEL_ABORT_LOGIN = '120'
/**
 * @constant
 * @type {string}
 * @description 更改当前城市
 */
var CHANNEL_CHANGE_CITY = '121'
/**
 * @function back
 * @description 后退到指定窗口
 *              默认后退到上一个窗口
 * @param {string} anim_id 动画ID
 * @param {number} duration 动画时间
 * @param {string} target 目标窗口名称
 */
function back(anim_id, duration, target) {
    if (arguments.length === 1 && typeof anim_id == 'object') {
        duration = anim_id.duration
        target = anim_id.target
        anim_id = anim_id.anim_id
    }
	if ( typeof anim_id === 'undefined') {
		anim_id = -1
	}
	if ( typeof duration === 'undefined') {
		duration = DUR_ANIMATION
	}
	if (page_type == 'popover') {
		if(typeof target == 'undefined'){
			eval_script(page_name, 'back(' + anim_id + ', ' + duration + ')')
		}
		else{
			eval_script(page_name, 'back(' + anim_id + ', ' + duration + ',"' + target+ '")')
		}
	}
}

/**
 * @function back_to_user
 * @description 返回到root窗口
 *              然后打开用户中心
 * @param {string} script 打开用户中心后执行的脚本
 */
function back_to_user() {
    eval_script('root', 'setTimeout(function(){open_con(4)},DUR_ANIMATION)')
    back({
        target : 'root'
    })
}

/**
 * @function eval_script
 * @description 指定窗口执行指定的代码
 * @param {!string|array} win_name 执行script的窗口名称
 * @param {string} script 要执行的代码
 * @param {string} type 窗口类型（window、popover）
 * @param {?string|array} pop_name 如果窗口类型为popover
 *                          且没有传入此参数
 *                          则默认使用win_name作为弹窗的名称
 */
function eval_script(win_name, script, type, pop_name) {
    if (arguments.length === 1 && typeof win_name == 'object') {
        script = win_name.script
        type = win_name.type
        pop_name = win_name.pop_name
        win_name = win_name.win_name
    }
    if ( typeof type == 'undefined') {
        type = 'window'
    }
    if (typeof win_name == 'string' && win_name.length == 0) {
        return false
    }
    if (typeof win_name == 'string') {
        win_name = [win_name]
    }

    if (type === 'popover' && typeof pop_name == 'undefined') {
        pop_name = win_name
    }
    if (type === 'popover' && typeof pop_name == 'string') {
        pop_name = [pop_name]
    }
    for (i in win_name) {
        if (type === 'window') {
            uexWindow.evaluateScript(win_name[i],0, script)
        } else if (type === 'popover') {
            uexWindow.evaluatePopoverScript(win_name[i], pop_name[i], script)
        }
    }
}