<?php
	require_once('./class/conn.class.php');
	require_once('./class/wechat.class.php');
	include ('./include/function.php');
	global $wechat_options;
	const BIND = 'bind';
	const STATUS = 'status';
	const HOT = 'hot';
	const NEW = 'new';
	const SEARCH = 'search';
	$con = new conn();
	$weObj = new Wechat( $wechat_options );
	$weObj->valid();
	$user = $weobj->getRevFrom();//获取用户openid
	$msg = $weobj->getRev();//获取用户发送的消息
	$msg = trim($msg);
	$operation = 'NULL';
	switch ($msg) {
		case '绑定':
			$operation = BIND;
			break;
		case '状态':
			$operation = STATUS;
			break;
		case '热门':
			$operation = HOT;
			break;
		case '最新':
			$operation = NEW;
			break;
		default:
			//查询@关键字
			if()
			break;
	}
	if ($operation == BIND){

	}else if ($operation == HOT){

	}else if ($operation == NEW){

	}else if ($operation == STATUS){

	}else if ($operation == SEARCH){

	}
	$weObj->text($text);
	$weObj->reply();

