<?php
return array(
	//'配置项'=>'配置值'
    //'session_auto_start' => true,
    //'SESSION_OPTIONS' => array('use_only_cookies'=>0,'use_trans_sid'=>1),
    //ini_set('session.cookie_domain', ".domain.com"),
    //数据库设置
    'DB_TYPE' => 'mysql',
    'DB_HOST' => "SAE_MYSQL_HOST_M",
    'DB_NAME' => 'app_xiaoyuanyishu1',
    'DB_USER' => "SAE_MYSQL_USER",
    'DB_PWD' => "SAE_MYSQL_PASS",
    'DB_PREFIX' => '',
    'DB_CHARSET'=> 'utf8', // 字符集
    'DB_DEBUG'  =>  TRUE, // 数据库调试模式 
    // 配置邮件发送服务器
    'MAIL_HOST' =>'smtp.163.com',//smtp服务器的名称
    'MAIL_SMTPAUTH' =>TRUE, //启用smtp认证
    'MAIL_USERNAME' =>'guoyue04012040@163.com',//你的邮箱名
    'MAIL_FROM' =>'guoyue04012040@163.com',//发件人地址
    'MAIL_FROMNAME'=>'校园易书',//发件人姓名
    'MAIL_PASSWORD' =>'axtyezgh',//邮箱密码
    'MAIL_CHARSET' =>'utf-8',//设置邮件编码
    'MAIL_ISHTML' =>TRUE, // 是否HTML格式邮件
);