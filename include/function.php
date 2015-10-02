<?php
	const BIND = 'bind';
	const STATUS = 'status';
	const HOT = 'hot';
	const NEWLY = 'new';
	const SEARCH = 'search';

	/**
	 *	@param string $var 构造的全局变量字符串
	 */
	function mkglobal( $vars ) {
		global $con;
		$vars = explode( ':',$vars );
		foreach ($vars as $key => $value) {
			if( isset($_GET[$key]) ){
				$GLOBALS[$value] = $con->mres( $_GET[$value] );
			}elseif( isset($_POST[$value] )) {
				$GLOBALS[$value] = $con->mres( $_POST[$value] );
			}else{
				return false;
			}
		}
		return true;
	}
	/**
	 * 返回用户绑定链接
	 * @return string $text;
	 */
	function user_bind() {
		global $ptset,$user_openid;
		$base_url = $ptset['base_url'];
		$url = "http://$base_url/ptweixin/go.php?openid=$user_openid&operation=bind";
		$text = "<a href = '$url' >点击绑定</a>";
		return $text;
	}

	/**
	 * 检查用户是否绑定过微信账号,未绑定返回false ,绑定返回true ,并设置$user_ptid;
	 * @return bool 
	 */
	function bind_check() {
		global $con,$user_openid,$user_ptid;
		$sql = "SELECT `ptid` FROM `weixin` WHERE `openid` = '$user_openid'";
		$result = $con->query($sql);
		if ( $result == NULL) {//没有绑定
			return false;
		}else{
			$user_ptid = $result[0]['ptid'];
			return true;
		}
	}
	/**
	 *  搜索种子
	 * @param string $keyword 查询关键字
	 * @param string $other 其他限制条件
	 * @return string $text 查询结果
	 */
	function search( $keyword , $other ) {
		global $con,$user_openid,$user_ptid;
		if( $keyword ) {
			$sql = "SELECT * FROM `torrents` WHERE `name` LIKE '%$keyword%' OR `small_descr` LIKE '%$keyword%' ";
			$result = torrents_info( $sql , 5 );
			$text = $result['text'];
			if( $result['count'] > 5 ) $text .= "共有{$result['count']}条结果,<a href = 'torrentlist.php?keyword={$keyword}&openid=$user_openid'>[查看]</a>全部";
		}else if( $other == HOT ) {
			$sql = "SELECT * FROM `torrents` WHERE `picktype` = 'hot' ";
			$result = torrents_info( $sql , 5 );
			$text = $result['text'];
			if( $result['count'] > 5 ) $text .= "共有{$result['count']}条结果,<a href = 'torrentlist.php?other=hot&openid=$user_openid'>[查看]</a>全部";
		}else if ( $other == NEWLY ) {
			$sql = "SELECT * FROM torrents where visible='yes' ORDER BY added DESC LIMIT 5";
			$result = torrents_info( $sql , 5 );
			$text = $result['text'];
		}
		return $text;
	}
	/**
	 * @param string $sql 种子满足的sql表达式 
	 * @param int $limit 返回结果数 0 不限制
	 * @return array text 查询结果 count 查询数量
	 */
	function torrents_info ( $sql , $limit) {
		global $con,$user_openid,$user_ptid;
		$result = $con->query($sql);
		$text = '';
		$empty = '没有查询结果';
		$count = 0;
		if( $result ) {
			$count = count( $result );
			$i = 1;
			foreach ($result as $key => $value) {
				$text .= "{$value['name']}<a href = 'torrents.php?torrent={$value['id']}&openid=$user_openid'>[详情]</a>做种[{$value['seeders']}]下载[{$value['leechers']}]<a href = 'download.php?torrent={$value['id']}&openid=$user_openid'>下载</a><br>";
				$i++;
				if($limit != 0 )
					if( $i > $limit ) break;
			}
			return array( 'text' => $text , 'count' => $count);
		}else 
			return array( 'text' => $empty , 'count' => 0);
	}
	/**
	 * 用户信息
	 * @return string $text 用户信息
	 *
	 */
	function user_status () {
		global $con,$user_openid,$user_ptid;
		$sql = "SELECT COUNT(*) FROM `peers` WHERE `peer_id` = $user_ptid AND `seeder` = 'yes' ";
		$result = $con->query($sql);
		$seed = $result[0]['COUNT(*)'];//做种数
		$sql = "SELECT COUNT(*) FROM `peers` WHERE `peer_id` = $user_ptid AND `seeder` = 'no' ";
		$result = $con->query($sql);
		$leed = $result[0]['COUNT(*)'];//下载数
		$sql = "SELECT * FROM `users` WHERE  `id` = $user_ptid";
		$result = $con->query($sql);
		$rs = $result[0];
		$user_name = $rs['username'];
		$downloaded = mksize( $rs['downloaded'] * 1);
		$uploaded = mksize( $rs['uploaded'] * 1);
		$text = "亲爱的{$user_name}!么么哒<br>上传:{$seed},下载:{$leed}<br>上传量:{$uploaded},下载量:{$downloaded}";
		return $text;
	}
	/**
	 * 单位换算
	 * @param int 字节数
	 * @return string 转换后的单位
	 */
	function mksize($bytes){
		if ($bytes < 1000 * 1024)
		return number_format($bytes / 1024, 2) . "KB";
		elseif ($bytes < 1000 * 1048576)
		return number_format($bytes / 1048576, 2) . "MB";
		elseif ($bytes < 1000 * 1073741824)
		return number_format($bytes / 1073741824, 2) . "GB";
		elseif ($bytes < 1000 * 1099511627776)
		return number_format($bytes / 1099511627776, 3) . "TB";
		else
		return number_format($bytes / 1125899906842624, 3) . "PB";
	}
?>