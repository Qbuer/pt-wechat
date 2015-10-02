<?php
	require('./class/conn.class.php');
	require_once('./config.php');
	include('./include/function.php');
	$con = new conn();
	if(isset($_GET['openid']) && $_GET['openid']!='') $user_openid = $con->mres( $_GET['openid'] );
	else exit;
	if(isset($_GET['torrent'])) $torrent = $con->mres( $_GET['torrent'] ) * 1;
	else exit;
	$url = "download.php?openid=$user_openid&torrent=$torrent";
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv = "Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>下载</title>
	<link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<script type="text/javascript" src = 'http://res.wx.qq.com/open/js/jweixin-1.1.0.js' ></script>
	<link rel="stylesheet" type="text/css" href="./css/style.css">
</head>
<body>
	<span id = 'openid' style = 'display:none'><?php echo $_GET['openid']; ?></span>
	<div class = 'container'>
		<div class = "panel panel-success">
			<div class = 'panel-heading'>
				<h3 class = 'panel-title'>远程下载</h3>
			</div>
				<div class="alert alert-info" role="alert" id = 'download-success' style ='display:none'>下载成功</div>
			</div>
		</div>
	</div>
	<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
	<script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script type="text/javascript" src = './js/ptweixin.js'></script>	
	<script type="text/javascript">
	<?php 
		if( bind_check() ) :?>
			$.post(
				'<?php echo $url;?>',
				function (data){
					msg_handle(data , function (data) {
						alert('添加下载成功!');
						$('#download-success').show();
					})
				},
				'json'
				)	
		<? endif ?>
	</script>
</body>
