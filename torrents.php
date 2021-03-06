<?php
require('./class/conn.class.php');
	require_once('./config.php');
	include('./include/function.php');
	$con = new conn();
	if(isset($_GET['openid']) && $_GET['openid']!='') $user_openid = $con->mres( $_GET['openid'] );
	else exit;
	if(isset($_GET['torrent'])) $torrent = $con->mres( $_GET['torrent'] ) * 1;
	else exit;
	if( bind_check() ) {
		$sql = "SELECT * FROM `torrents` WHERE `id` = $torrent ";
		$result = $con->query($sql);
	}
	?>
	<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv = "Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>种子详情</title>
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
				<button class = 'btn btn-primary' id = 'search-button'>搜索</button>
			</form>
		</div>
		<div>
			<?php foreach ($result as $key => $value) : ?>
					<div class = 'box'>
						<div class = 'title'>
							<p class = 'torrent-name'><?php echo $value['name'];?></p>
							<p class = 'torrent-name'><?php echo $value['small_descr'];?></p>
							<p>上传:<?php echo $value['seeders'];?>&nbsp;&nbsp;下载:<?php echo $value['leechers'];?></p>
						</div>
						<div class = 'action'>
							<button class='btn btn-success download btn-sm'  href = 'download.php?torrent=<?php echo $value['id'] ;?>&openid=<?php echo $user_openid;?>'>下载</a>
						</div>
						<div class = 'description'>
							<p><?php echo trim(preg_replace('/\[attach\]\w{32}\[\/attach\]/i', '', $value['descr']));?></p>
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