<?php

/**
 * 鸿宇多用户商城 专题前台
 * ============================================================================
 * 版权所有 2015-2016 鸿宇多用户商城科技有限公司，并保留所有权利。
 * 网站地址: http://bbs.hongyuvip.com；
 * ----------------------------------------------------------------------------
 * 仅供学习交流使用，如需商用请购买正版版权。鸿宇不承担任何法律责任。
 * 踏踏实实做事，堂堂正正做人。
 * ============================================================================
 * @author:     webboy <laupeng@163.com>
 * @version:    v2.1
 * ---------------------------------------------
 */

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

if ((DEBUG_MODE & 2) != 2)
{
    $smarty->caching = true;
}

if (empty($_SESSION['user_id'])){
	$back_act = "apply_index.php";
	if (!empty($_SERVER['QUERY_STRING']))
    {
      $back_act = 'apply.php?' . strip_tags($_SERVER['QUERY_STRING']);
    }
    show_message('请先登陆！', array('返回上一页','点击去登陆'), array($back_act, 'user.php'), 'info');
}

$userid = $_SESSION['user_id'];

$shownum = (isset($_REQUEST['shownum'])) ? intval($_REQUEST['shownum']) : 0;

$upload_size_limit = $_CFG['upload_size_limit'] == '-1' ? ini_get('upload_max_filesize') : $_CFG['upload_size_limit'];

if(isset($_POST['do']) && $_POST['do']){
	unset($apply,$save);
	if($shownum == 1){
		if($_POST['company'])
		{
	    $save['company_name'] = isset($_POST['company_name']) ? trim(addslashes(htmlspecialchars($_POST['company_name']))) : ''; 
		$save['country'] = isset($_POST['country']) ? intval($_POST['country']) : 1; 
		$save['province'] = isset($_POST['province']) ? intval($_POST['province']) : 1; 
		$save['city'] = isset($_POST['city']) ? intval($_POST['city']) : 1; 
		$save['district'] = isset($_POST['district']) ? intval($_POST['district']) : 1; 
		$save['address'] = isset($_POST['address']) ? trim(addslashes(htmlspecialchars($_POST['address']))) : '';
		$save['tel'] = isset($_POST['tel']) ? trim(addslashes(htmlspecialchars($_POST['tel']))) : '';
		$save['guimo'] = isset($_POST['guimo']) ? trim(addslashes(htmlspecialchars($_POST['guimo']))) : '';
		$save['email'] = isset($_POST['email']) ? trim($_POST['email']) : '';
		$save['company_type'] = isset($_POST['company_type']) ? trim($_POST['company_type']) : '';
		$save['contacts_name'] = isset($_POST['contacts_name']) ? trim(addslashes(htmlspecialchars($_POST['contacts_name']))) : '';
	    $save['contacts_phone'] = isset($_POST['contacts_phone']) ? trim(addslashes(htmlspecialchars($_POST['contacts_phone']))) : '';
	    $save['business_licence_number'] = isset($_POST['business_licence_number']) ? trim(addslashes(htmlspecialchars($_POST['business_licence_number']))) : '';
	    $save['business_sphere'] = isset($_POST['business_sphere']) ? trim(addslashes(htmlspecialchars($_POST['business_sphere']))) : '';
	    $save['organization_code'] = isset($_POST['organization_code']) ? trim(addslashes(htmlspecialchars($_POST['organization_code']))) : '';
	    
		if (isset($_FILES['zhizhao']) && $_FILES['zhizhao']['tmp_name'] != '' &&  isset($_FILES['zhizhao']['tmp_name']) && $_FILES['zhizhao']['tmp_name'] != 'none')
		{
			if($_FILES['zhizhao']['size'] / 1024 > $upload_size_limit)
	        {
	            $err->add(sprintf($_LANG['upload_file_limit'], $upload_size_limit));
				$err->show($_LANG['back_up_page']);
	        }
	        $zhizhao_img = upload_file($_FILES['zhizhao'], 'supplier');
	        if ($zhizhao_img === false)
	        {
	            $err->add('营业执照号电子版图片上传失败！');
				$err->show($_LANG['back_up_page']);
	        }
			else
			{
			   $save['zhizhao'] = $zhizhao_img;
			}
		}
		if (isset($_FILES['organization_code_electronic']) && $_FILES['organization_code_electronic']['tmp_name'] != '' &&  isset($_FILES['organization_code_electronic']['tmp_name']) && $_FILES['organization_code_electronic']['tmp_name'] != 'none')
		{
			if($_FILES['organization_code_electronic']['size'] / 1024 > $upload_size_limit)
	        {
	            $err->add(sprintf($_LANG['upload_file_limit'], $upload_size_limit));
				$err->show($_LANG['back_up_page']);
	        }
	        $organization_code_electronic_img = upload_file($_FILES['organization_code_electronic'], 'supplier');
	        if ($organization_code_electronic_img === false)
	        {
	            $err->add('组织机构代码证电子版图片上传失败！');
				$err->show($_LANG['back_up_page']);
	        }
			else
			{
				$save['organization_code_electronic'] = $organization_code_electronic_img;
			}
		}
		if (isset($_FILES['general_taxpayer']) && $_FILES['general_taxpayer']['tmp_name'] != '' &&  isset($_FILES['general_taxpayer']['tmp_name']) && $_FILES['general_taxpayer']['tmp_name'] != 'none')
		{
			if($_FILES['general_taxpayer']['size'] / 1024 > $upload_size_limit)
	        {
	            $err->add(sprintf($_LANG['upload_file_limit'], $upload_size_limit));
				$err->show($_LANG['back_up_page']);
	        }
	        $general_taxpayer_img = upload_file($_FILES['general_taxpayer'], 'supplier');
	        if ($general_taxpayer_img === false)
	        {
	            $err->add('组织机构代码证电子版图片上传失败！');
				$err->show($_LANG['back_up_page']);
	        }
			else
			{
				$save['general_taxpayer'] = $general_taxpayer_img;
			}
		}
		$save['applynum'] = 1;//公司信息认证一
		
		//必填项验证
		$save1 = array_filter($save);
		if(count($save1)!=count($save)){
			show_message('请认真填写必填申请资料！', '返回', 'apply.php', 'wrong');
			}
			 if ($db->autoExecute($ecs->table('supplier'), $save, 'UPDATE', 'user_id='.$userid) !== false){
				header("location:apply.php");
				exit;
			 }else{
				show_message('操作失败！', '返回', 'apply.php', 'wrong');
			 }
		}
		if($_POST['person'])
		{
			$save['company_name'] = isset($_POST['company_name']) ? trim(addslashes(htmlspecialchars($_POST['company_name']))) : ''; 
			$save['country'] = isset($_POST['country']) ? intval($_POST['country']) : 1; 
			$save['province'] = isset($_POST['province']) ? intval($_POST['province']) : 1; 
			$save['city'] = isset($_POST['city']) ? intval($_POST['city']) : 1; 
			$save['district'] = isset($_POST['district']) ? intval($_POST['district']) : 1; 
			$save['address'] = isset($_POST['address']) ? trim(addslashes(htmlspecialchars($_POST['address']))) : '';
			
			$save['contacts_name'] = isset($_POST['contacts_name']) ? trim(addslashes(htmlspecialchars($_POST['contacts_name']))) : '';
			$save['contacts_phone'] = isset($_POST['contacts_phone']) ? trim(addslashes(htmlspecialchars($_POST['contacts_phone']))) : '';
			$save['email'] = isset($_POST['email']) ? trim($_POST['email']) : '';

			$save['id_card_no'] = isset($_POST['id_card_no']) ? trim(addslashes(htmlspecialchars($_POST['id_card_no']))) : '';

			$save['bank_account_name'] = isset($_POST['bank_account_name']) ? trim(addslashes(htmlspecialchars($_POST['bank_account_name']))) : '';
			$save['bank_account_number'] = isset($_POST['bank_account_number']) ? trim(addslashes(htmlspecialchars($_POST['bank_account_number']))) : '';
			$save['bank_name'] = isset($_POST['bank_name']) ? trim(addslashes(htmlspecialchars($_POST['bank_name']))) : '';
			$save['bank_code'] = isset($_POST['bank_code']) ? trim(addslashes(htmlspecialchars($_POST['bank_code']))) : '';
			
			if (isset($_FILES['handheld_idcard']) && $_FILES['handheld_idcard']['tmp_name'] != '' &&  isset($_FILES['handheld_idcard']['tmp_name']) && $_FILES['handheld_idcard']['tmp_name'] != 'none')
			{
				if($_FILES['handheld_idcard']['size'] / 1024 > $upload_size_limit)
				{
					$err->add(sprintf($_LANG['upload_file_limit'], $upload_size_limit));
					$err->show($_LANG['back_up_page']);
				}
				$handheld_idcard_img = upload_file($_FILES['handheld_idcard'], 'supplier');
				if ($handheld_idcard_img === false)
				{
					$err->add('手持身份证照片上传失败！');
					$err->show($_LANG['back_up_page']);
				}
				else
				{
					$save['handheld_idcard'] = $handheld_idcard_img;
				}
			}
			if (isset($_FILES['idcard_front']) && $_FILES['idcard_front']['tmp_name'] != '' &&  isset($_FILES['idcard_front']['tmp_name']) && $_FILES['idcard_front']['tmp_name'] != 'none')
			{
				if($_FILES['idcard_front']['size'] / 1024 > $upload_size_limit)
				{
					$err->add(sprintf($_LANG['upload_file_limit'], $upload_size_limit));
					$err->show($_LANG['back_up_page']);
				}
				$idcard_front_img = upload_file($_FILES['idcard_front'], 'supplier');
				if ($idcard_front_img === false)
				{
					$err->add('身份证正面照片上传失败！');
					$err->show($_LANG['back_up_page']);
				}
				else
				{
					$save['idcard_front'] = $idcard_front_img;
				}
			}
			if (isset($_FILES['idcard_reverse']) && $_FILES['idcard_reverse']['tmp_name'] != '' &&  isset($_FILES['idcard_reverse']['tmp_name']) && $_FILES['idcard_reverse']['tmp_name'] != 'none')
			{
				if($_FILES['idcard_reverse']['size'] / 1024 > $upload_size_limit)
				{
					$err->add(sprintf($_LANG['upload_file_limit'], $upload_size_limit));
					$err->show($_LANG['back_up_page']);
				}
				$idcard_reverse_img = upload_file($_FILES['idcard_reverse'], 'supplier');
				if ($idcard_reverse_img === false)
				{
					$err->add('身份证反面照片上传失败！');
					$err->show($_LANG['back_up_page']);
				}
				else
				{
					$save['idcard_reverse'] = $idcard_reverse_img;
				}
			}
			
			$save['applynum'] = 2;//公司信息认证一
			
			//必填项验证
			$save1 = array_filter($save);
			if(count($save1)!=count($save)){
				show_message('请认真填写必填申请资料！', '返回', 'apply.php', 'wrong');
			}
			
			 if ($db->autoExecute($ecs->table('supplier'), $save, 'UPDATE', 'user_id='.$userid) !== false){
				header("location:apply.php");
				exit;
			 }else{
				show_message('操作失败！', '返回', 'apply.php', 'wrong');
			 }
		}
		
	}elseif($shownum == 2){
		
		$save['bank_account_name'] = isset($_POST['bank_account_name']) ? trim(addslashes(htmlspecialchars($_POST['bank_account_name']))) : '';
	    $save['bank_account_number'] = isset($_POST['bank_account_number']) ? trim(addslashes(htmlspecialchars($_POST['bank_account_number']))) : '';
	    $save['bank_name'] = isset($_POST['bank_name']) ? trim(addslashes(htmlspecialchars($_POST['bank_name']))) : '';
	    $save['bank_code'] = isset($_POST['bank_code']) ? trim(addslashes(htmlspecialchars($_POST['bank_code']))) : '';
	    $save['settlement_bank_account_name'] = isset($_POST['settlement_bank_account_name']) ? trim(addslashes(htmlspecialchars($_POST['settlement_bank_account_name']))) : '';
	    $save['settlement_bank_account_number'] = isset($_POST['settlement_bank_account_number']) ? trim(addslashes(htmlspecialchars($_POST['settlement_bank_account_number']))) : '';
	    $save['settlement_bank_name'] = isset($_POST['settlement_bank_name']) ? trim(addslashes(htmlspecialchars($_POST['settlement_bank_name']))) : '';
	    $save['settlement_bank_code'] = isset($_POST['settlement_bank_code']) ? trim(addslashes(htmlspecialchars($_POST['settlement_bank_code']))) : '';
	    $save['tax_registration_certificate'] = isset($_POST['tax_registration_certificate']) ? trim(addslashes(htmlspecialchars($_POST['tax_registration_certificate']))) : '';
	    $save['taxpayer_id'] = isset($_POST['taxpayer_id']) ? trim(addslashes(htmlspecialchars($_POST['taxpayer_id']))) : '';
	    
		if (isset($_FILES['bank_licence_electronic']) && $_FILES['bank_licence_electronic']['tmp_name'] != '' &&  isset($_FILES['bank_licence_electronic']['tmp_name']) && $_FILES['bank_licence_electronic']['tmp_name'] != 'none')
		{
			if($_FILES['bank_licence_electronic']['size'] / 1024 > $upload_size_limit)
	        {
	            $err->add(sprintf($_LANG['upload_file_limit'], $upload_size_limit));
				$err->show($_LANG['back_up_page']);
	        }
	        $bank_licence_electronic_img = upload_file($_FILES['bank_licence_electronic'], 'supplier');
	        if ($bank_licence_electronic_img === false)
	        {
	            $err->add('开户银行许可证电子版图片上传失败！');
				$err->show($_LANG['back_up_page']);
	        }
			else
			{
				$save['bank_licence_electronic'] = $bank_licence_electronic_img;
			}
		}
		if (isset($_FILES['tax_registration_certificate_electronic']) && $_FILES['tax_registration_certificate_electronic']['tmp_name'] != '' &&  isset($_FILES['tax_registration_certificate_electronic']['tmp_name']) && $_FILES['tax_registration_certificate_electronic']['tmp_name'] != 'none')
		{
			if($_FILES['tax_registration_certificate_electronic']['size'] / 1024 > $upload_size_limit)
	        {
	            $err->add(sprintf($_LANG['upload_file_limit'], $upload_size_limit));
				$err->show($_LANG['back_up_page']);
	        }
	        $tax_registration_certificate_electronic_img = upload_file($_FILES['tax_registration_certificate_electronic'], 'supplier');
	        if ($tax_registration_certificate_electronic_img === false)
	        {
	            $err->add('税务登记证号电子版图片上传失败！');
				$err->show($_LANG['back_up_page']);
	        }
			else
			{
				$save['tax_registration_certificate_electronic'] = $tax_registration_certificate_electronic_img;
			}
		}
		
		$save['applynum'] = 2;//公司信息认证二
		
		//必填项验证
		$save1 = array_filter($save);
		if(count($save1)!=count($save)){
			show_message('请认真填写必填申请资料！', '返回', 'apply.php', 'wrong');
		}
		
		 if ($db->autoExecute($ecs->table('supplier'), $save, 'UPDATE', 'user_id='.$userid) !== false){
		 	header("location:apply.php");
		 	exit;
		 }else{
		 	show_message('操作失败！', '返回', 'apply.php', 'wrong');
		 }
		
	}elseif($shownum == 3){
		$save['supplier_name'] = isset($_POST['supplier_name']) ? trim(addslashes(htmlspecialchars($_POST['supplier_name']))) : ''; 
		$save['rank_id'] = isset($_POST['rank_id']) ? intval($_POST['rank_id']) : 0; 
		$save['type_id'] = isset($_POST['type_id']) ? intval($_POST['type_id']) : 0; 
		
		$save['applynum'] = 3;//店铺信息设置
		
		//必填项验证
		$save1 = array_filter($save);
		if(count($save1)!=count($save)){
			show_message('请认真填写必填申请资料！', '返回', 'apply.php', 'wrong');
		}
		
		 if ($db->autoExecute($ecs->table('supplier'), $save, 'UPDATE', 'user_id='.$userid) !== false){
		 	header("location:apply.php");
		 	exit;
		 }else{
		 	show_message('操作失败！', '返回', 'apply.php', 'wrong');
		 }
		
	}else{//同意入驻协议
		
		
		if(isset($_POST['input_apply_agreement']) && intval($_POST['input_apply_agreement']) > 0){
			
			$sql = "select * from ".$ecs->table('supplier')." where user_id=".$userid." limit 1";
			$info = $db->getRow($sql);
			
			$apply['user_id'] = $userid;
			$apply['status'] = 0;
			$apply['applynum'] = 0;//同意入驻协议
			if($info){
				if ($db->autoExecute($ecs->table('supplier'), $apply, 'UPDATE', 'user_id='.$userid) !== false){
				 	header("location:apply.php");
				 	exit;
				 }else{
				 	show_message('请点击同意入驻协议！', '返回', 'apply.php', 'wrong');
				 }
			}else{
				 if ($db->autoExecute($ecs->table('supplier'), $apply) !== false){
				 	header("location:apply.php");
				 	exit;
				 }else{
				 	show_message('请点击同意入驻协议！', '返回', 'apply.php', 'wrong');
				 }
			}
		}else{
			$err->add('请点击同意入驻协议！');
			$err->show($_LANG['back_up_page']);
		}
	}
}


if (!$smarty->is_cached($templates, $cache_id))
{ 

    /* 模板赋值 */
    assign_template();
    $position = assign_ur_here();
    $smarty->assign('page_title',       $position['title']);       // 页面标题
    $smarty->assign('ur_here',          $position['ur_here'] . '> ' . $topic['title']);     // 当前位置
    
}
$smarty->assign('piclimit',$upload_size_limit);
$smarty->assign('userid',intval($_SESSION['user_id']));
$smarty->display('apply.dwt');

?>