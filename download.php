<?php
	require('./class/conn.class.php');
	require_once('./config.php');
	include('./include/function.php');
	require_once('../classes/class_cache.php');
	$Cache = NEW CACHE();
	$con = new conn();
	if(isset($_GET['openid']) && $_GET['openid']!='') $user_openid = $con->mres( $_GET['openid'] );
	else exit;
	if(isset($_GET['torrent'])) $torrent = $con->mres( $_GET['torrent'] ) * 1;
	else exit;
	if( bind_check() ) {
		$sql = "SELECT * FROM `bookmarks` WHERE `torrentid` = $torrent AND `userid` = $user_ptid";
		$res = $con->query($sql);
		if( empty($res) ){
			$sql = "INSERT INTO bookmarks (torrentid, userid) VALUES ( $torrent , $user_ptid )";
			if( $con->query($sql) ) {
				echo json_encode( array( 'status' => 'success') );
				$Cache->delete_value('user_'.$user_ptid.'_bookmark_array');
			}else 
				echo json_encode( array( 'status' => 'fail' , 'errmsg' => '远程下载失败'));
		}else 
			echo json_encode( array( 'status' => 'fail' , 'errmsg' => '已经下载过了!'));
	}