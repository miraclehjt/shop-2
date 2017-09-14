<?php

/**
 * 保存一个验证记录到数据库，如果存在则更新
 *
 * @param string $key
 *        	验证标识
 * @param string $code
 *        	验证值
 * @param string $type
 *        	验证类型
 * @param datetime $expired_time
 *        	过期时间
 * @param array $ext_info
 *        	扩展信息
 */
function save_validate_record ($key, $code, $type, $last_send_time, $expired_time, $ext_info = array())
{
	$record = array(
		// 验证代码
		"record_code" => $code, 
		// 业务类型
		"record_type" => $type, 
		// 业务类型
		"last_send_time" => $last_send_time, 
		// 过期时间
		"expired_time" => $expired_time, 
		// 扩展信息
		"ext_info" => serialize($ext_info)
	);
	
	$exist = check_validate_record_exist($key);
	
	if(! $exist)
	{
		$record['record_key'] = $key;
		// 记录创建时间
		$record["create_time"] = time();
		
		/* insert */
		$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('validate_record'), $record, 'INSERT');
	}
	else
	{
		/* update */
		$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('validate_record'), $record, 'UPDATE', "record_key = '$key'");
	}
}

/**
 * 检查验证记录在数据库中是否已经存在
 *
 * @param string $key        	
 * @return boolean
 */
function check_validate_record_exist ($key)
{
	$sql = "select count(*) from " . $GLOBALS['ecs']->table('validate_record') . " where record_key = '" . $key . "'";
	$count = $GLOBALS['db']->getOne($sql);
	
	if($count > 0)
	{
		return true;
	}
	else
	{
		return false;
	}
}

/**
 * 根据键删除验证记录
 *
 * @param string $key        	
 */
function remove_validate_record ($key)
{
	$sql = "delete from " . $GLOBALS['ecs']->table('validate_record') . " where record_key = '$key'";
	return $GLOBALS['db']->query($sql);
}

/**
 * 移除过期的验证记录
 *
 * @param string $key        	
 */
function remove_expired_validate_record ()
{
	$current_time = time();
	$sql = "delete from " . $GLOBALS['ecs']->table('validate_record') . " where expired_time < '$current_time'";
	return $GLOBALS['db']->query($sql);
}

/**
 * 基本验证
 *
 * @param string $key        	
 * @param string $value        	
 * @return int 0-验证信息不存在，1-验证码已过期, 2-验证码错误
 */
function validate_code ($key, $code)
{
	$record = get_validate_record($key);
	
	if($record == false)
	{
		return ERR_VALIDATE_KEY_NOT_EXIST;
	}
	else if($record['expired_time'] < time())
	{
		return ERR_VALIDATE_EXPIRED_TIME;
	}
	else if($record['record_code'] != $code)
	{
		return ERR_VALIDATE_CODE_NOT_MATCH;
	}
	else
	{
		return true;
	}
}

/**
 * 从数据库中获取验证记录信息，会将ext_info数组解析与结果合并
 *
 * @param string $key        	
 * @return boolean|array:
 */
function get_validate_record ($key)
{
	// 移除过期的验证记录
	remove_expired_validate_record();
	
	$sql = "select * from " . $GLOBALS['ecs']->table('validate_record') . " where record_key = '$key'";
	$row = $GLOBALS['db']->getRow($sql);
	
	if($row == false)
	{
		return false;
	}
	
	$row['ext_info'] = unserialize($row['ext_info']);
	
	$record = array(
		// 验证代码
		"record_key" => $row['record_key'], 
		// 验证代码
		"record_code" => $row['record_code'], 
		// 业务类型
		"record_type" => $row['record_type'], 
		// 开始时间
		"last_send_time" => $row['last_send_time'], 
		// 过期时间
		"expired_time" => $row['expired_time'], 
		// 创建时间
		"create_time" => $row['create_time']
	);
	
	$record = array_merge($record, $row['ext_info']);
	
	return $record;
}

?>