<?php

// ######(以下配置为PM环境：入网测试环境用，生产环境配置见文档说明)#######
// 签名证书路径
//const SDK_SIGN_CERT_PATH = './includes/modules/payment/unionpay/PM_700000000000001_acp.pfx';
define('SDK_SIGN_CERT_PATH','./includes/modules/payment/unionpay/PM_700000000000001_acp.pfx');

// 签名证书密码
//const SDK_SIGN_CERT_PWD = '000000';//'000000';
define('SDK_SIGN_CERT_PWD','000000');

// 密码加密证书（这条用不到的请随便配）
//const SDK_ENCRYPT_CERT_PATH = 'D:/wamp/www/ftp/upacp_sdk_php/verify_sign_acp.cer';
define('SDK_ENCRYPT_CERT_PATH','D:/wamp/www/ftp/upacp_sdk_php/verify_sign_acp.cer');

// 验签证书路径（请配到文件夹，不要配到具体文件）
//const SDK_VERIFY_CERT_DIR = 'D:/wamp/www/ftp/upacp_sdk_php/';
define('SDK_VERIFY_CERT_DIR','D:/wamp/www/ftp/upacp_sdk_php/');

// 前台请求地址
//const SDK_FRONT_TRANS_URL = 'https://101.231.204.80:5000/gateway/api/frontTransReq.do';测试地址
//const SDK_FRONT_TRANS_URL = 'https://101.231.204.80:5000/gateway/api/frontTransReq.do';
//const SDK_FRONT_TRANS_URL = 'https://gateway.95516.com/gateway/api/frontTransReq.do';//生产环境用的地址
define('SDK_FRONT_TRANS_URL','https://101.231.204.80:5000/gateway/api/frontTransReq.do');
?>