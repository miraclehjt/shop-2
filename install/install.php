<?php
/**
 * 鸿宇原创安装版
 * Created by PhpStorm.
 * User: Shadow
 * Date: 2016-05-18 0008
 * Time: 13:14
 * Http: bbs.hongyuvip.com
 */
header("content-Type: text/html; charset=Utf-8"); //设置字符的编码是utp-8
if(file_exists('../data/install.lock') and file_exists('../mobile/data/install.lock')){
    echo "<script>alert('程序已安装，如需重新安装请删除data和mobile/data目录下install.lock文件');</script>";
    echo '程序已安装，如需重新安装请删除data和mobile/data目录下install.lock文件';
    exit;
}else{
    $db = new DBManage ( $db_host, $db_user, $db_pass, $db_name, 'utf8' );
    $db->restore ( 'hy.sql');
}

class DbManage {
    var $db; // 数据库连接
    var $database; // 所用数据库
    var $sqldir; // 数据库备份文件夹
    // 换行符
    private $ds = "n";
    // 存储SQL的变量
    public $sqlContent = "";
    // 每条sql语句的结尾符
    public $sqlEnd = ";";

    /**
     * 初始化
     *
     * @param string $host
     * @param string $username
     * @param string $password
     * @param string $database
     * @param string $charset
     */
    function __construct($host = 'localhost', $username = 'root', $password = '', $database = 'test', $charset = 'utf8') {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
        $this->charset = $charset;
        set_time_limit(0);//无时间限制
        @ob_end_flush();
        // 连接数据库
        $this->db = @mysql_connect ( $this->host, $this->username, $this->password ) or die( '<p class="dbDebug"><span class="err">Mysql Connect Error : </span>'.mysql_error().'</p>');
        // 选择使用哪个数据库
        mysql_select_db ( $this->database, $this->db ) or die('<p class="dbDebug"><span class="err">Mysql Connect Error:</span>'.mysql_error().'</p>');
        // 数据库编码方式
        mysql_query ( 'SET NAMES ' . $this->charset, $this->db );

    }

    /*
     * 新增查询数据库表
     */
    function getTables() {
        $res = mysql_query ( "SHOW TABLES" );
        $tables = array ();
        while ( $row = mysql_fetch_array ( $res ) ) {
            $tables [] = $row [0];
        }
        return $tables;
    }


    /**
     * 导入备份数据
     * 参数：文件路径(必填)
     * @param string $sqlfile
     */
    function restore($sqlfile) {
        // 检测文件是否存在
        if (! file_exists ( $sqlfile )) {
            $this->_showMsg("sql文件不存在！请检查",true);
            exit ();
        }
        $this->lock ( $this->database );
        // 获取数据库存储位置
        $sqlpath = pathinfo ( $sqlfile );
        $this->sqldir = $sqlpath ['dirname'];
        // 检测是否包含分卷
        $volume = explode ( "_v", $sqlfile );
        $volume_path = $volume [0];
        $this->_showMsg("请勿刷新及关闭浏览器以防止程序被中止，如有不慎！将导致数据库结构受损");
        $this->_showMsg("正在导入备份数据，请稍等！");
        if (empty ( $volume [1] )) {
            $this->_showMsg ( "正在导入sql：<span class='imp'>" . $sqlfile . '</span>');
            // 没有分卷
            if ($this->_import ( $sqlfile )) {
                $sql = "ALTER TABLE ecs_shipping ADD supplier_id mediumint(8) UNSIGNED not null DEFAULT 0 COMMENT '0:平台方;大于0:入驻商id' AFTER support_pickup;";
                $this->_insert_into($sql);
                $this->_showMsg( "数据库导入成功！<br/><br/>请登录PC管理后台 -> 清除缓存<br/><br/>这次一次我们重新定义用户体验！<br/><br/>你是否还沉浸在安装的喜悦之中吗？<meta http-equiv='refresh' content='2;url=../admin/index.php' />");
                $fp=fopen("../data/install.lock","w");
                fputs($fp,'ECSHOP INSTALLED hongyuvip.com');
                fclose($fp);
                $fp=fopen("../mobile/data/install.lock","w");
                fputs($fp,'ECSHOP INSTALLED hongyuvip.com');
                fclose($fp);
                mysql_close ( $this->db );
            } else {
                $this->_showMsg('数据库导入失败！',true);
                exit ();
            }
        }
    }
    //  及时输出信息
    private function _showMsg($msg,$err=false){
        $err = $err ? "<span class='err'>ERROR:</span>" : '' ;
        echo "<p class='dbDebug'>".$err . $msg."</p>";
        flush();

    }

    /**
     * 将sql导入到数据库（普通导入）
     * @param string $sqlfile
     * @return boolean
     */
    private function _import($sqlfile) {
        // sql文件包含的sql语句数组
        $sqls = array ();
        $f = fopen ( $sqlfile, "rb" );
        // 创建表缓冲变量
        $create_table = '';
        while ( ! feof ( $f ) ) {
            // 读取每一行sql
            $line = fgets ( $f );
            // 这一步为了将创建表合成完整的sql语句
            // 如果结尾没有包含';'(即为一个完整的sql语句，这里是插入语句)，并且不包含'ENGINE='(即创建表的最后一句)
            if (! preg_match ( '/;/', $line ) || preg_match ( '/ENGINE=/', $line )) {
                // 将本次sql语句与创建表sql连接存起来
                $create_table .= $line;
                // 如果包含了创建表的最后一句
                if (preg_match ( '/ENGINE=/', $create_table)) {
                    //执行sql语句创建表
                    $this->_insert_into($create_table);
                    // 清空当前，准备下一个表的创建
                    $create_table = '';
                }
                // 跳过本次
                continue;
            }
            //执行sql语句
            $this->_insert_into($line);
        }
        fclose ( $f );
        return true;
    }

    //插入单条sql语句
    private function _insert_into($sql){
        if (! mysql_query ( trim ( $sql ) )) {
            $this->msg .= mysql_error ();
            return false;
        }
    }

    /*
     * -------------------------------数据库导入end---------------------------------
     */

    // 关闭数据库连接
    private function close() {
        mysql_close ( $this->db );
    }

    // 锁定数据库，以免备份或导入时出错
    private function lock($tablename, $op = "WRITE") {
        if (mysql_query ( "lock tables " . $tablename . " " . $op ))
            return true;
        else
            return false;
    }

    // 解锁
    private function unlock() {
        if (mysql_query ( "unlock tables" ))
            return true;
        else
            return false;
    }

    // 析构
    function __destruct() {
        if($this->db){
            mysql_query ( "unlock tables", $this->db );
            mysql_close ( $this->db );
        }
    }

}