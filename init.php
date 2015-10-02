<?php
/**
 * @author qbuer
 * 建立依赖表
 */
	require_once('./config.php');
	require_once('./class/conn.class.php');
	$con=new conn();
	$sql = 
		"CREATE TABLE IF NOT EXISTS `weixin` (
			`ptid`   int(10) 	NOT NULL COMMENT '同users表的id' ,
			`openid` varchar(128) NOT NULL  COMMENT '微信用户id' ,
			PRIMARY KEY (`ptid`)
		) DEFAULT CHARSET=utf8 COMMENT='用户表';";
	$con->query($sql);
	$con->disconnect();
?>