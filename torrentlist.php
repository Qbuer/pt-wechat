<?php
	require_once('./class/conn.class.php');
	require_once('./config.php');
	include('./include/function.php');
	$con = new conn();
	$keyword = NULL;
	$other = NULL;
	if(isset($_GET['openid']) && $_GET['openid']!='') 
		$user_openid = $con->mres( $_GET['openid'] );
	else exit;
	if(@isset($_GET['keyword'])) {
		$keyword = $con->mres( $_GET['keyword']);
	}else if(@isset($_GET['other'])) {
		$keyword = NULL;
		$other = $_GET['other'];
		if($other != 'hot') die();
	}
	if( bind_check() ) {
		if( $keyword ){
			$sql = "SELECT * FROM `torrents` WHERE `name` LIKE '%$keyword%' OR `small_descr` LIKE '%$keyword%'";
			$result = $con->query($sql);
		}else if ($other == 'hot'){
			$sql = "SELECT * FROM `torrents` WHERE `picktype` = 'hot' ";
			$result = $con->query($sql);
		}	
	}else die();
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv = "Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>种子列表</title>
	<link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="./css/style.css">
</head>
<body>
	<div class = 'container'>
		<div>
			<form class = 'form-inline' action = 'torrentlist.php'>
				<label for = 'keyword' class = 'sr-only' >关键字</label>
				<input type = 'text' name = 'keyword' class = 'form-control' id = 'keyword' placeholder = '搜索...'>
				<input type = 'text' name = 'openid' style = 'display:none' value = '<?php echo $user_openid ?>'>
				<button class = 'btn btn-primary ' id = 'search-button'>搜索</button>
			</form>
		</div>
		<div>
			<?php foreach ($result as $key => $value) : ?>
					<div class = 'box'>
						<div class = 'title'>
							<a href ='torrents.php?torrent=<?php echo $value['id'];?>&openid=<?php echo $user_openid;?> '><p><?php echo $value['name'];?></p></a>
							<p><?php echo $value['small_descr'];?></p>
							<p>上传:<?php echo $value['seeders'];?>&nbsp;&nbsp;下载:<?php echo $value['leechers'];?></p>
						</div>
						<div class = 'action'>
							<button class='btn btn-success download btn-sm'  href = 'download.php?torrent=<?php echo $value['id'] ;?>&openid=<?php echo $user_openid;?>'>下载</a>
						</div>
					</div>
			<?php endforeach ?>
		</div>
	</div>
	<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
	<script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script type="text/javascript" src = './js/ptweixin.js'></script>
</body>
</html>
