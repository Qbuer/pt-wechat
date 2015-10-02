<?php 
	/**
	 *微信扫一扫认证界面
	 */
	if( !isset( $_GET['openid'] ) ) die('你的ip已被记录.请勿作弊');
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv = "Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>账号绑定</title>
	<link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<script type="text/javascript" src = 'http://res.wx.qq.com/open/js/jweixin-1.1.0.js' ></script>
	<link rel="stylesheet" type="text/css" href="./css/style.css">
</head>
<body>
	<span id = 'openid' style = 'display:none'><?php echo $_GET['openid']; ?></span>
	<div class = 'container'>
		<div class = "panel panel-success">
			<div class = 'panel-heading'>
				<h3 class = 'panel-title'>绑定账号</h3>
			</div>
			<div class = 'panel-body'>
				<div class="alert alert-info" role="alert" id = 'bind-success' style ='display:none'>你已成功绑定账号</div>
				<form class = 'form-horizontal' action = '#'>
					<div class = 'form-group'>
						<label for = 'User' class = 'col-xs-3 control-label' >账号</label>
						<div class = 'col-xs-9'>
							<input type = 'text' class = 'form-control' id = 'User' placeholder="请输入您的PT账号">
						</div>
					</div>
					<div class = 'form-group'>
						<label for = 'Password' class = 'col-xs-3 control-label' >密码</label>
						<div class = 'col-xs-9'>
							<input type = 'password' class = 'form-control' id = 'Password' placeholder="请输入您的PT密码">
						</div>
					</div>
				</form>
				<button type = 'submit' class = 'btn btn-success btn-block' id = 'bind-button'>绑定！</button>
			</div>
		</div>
	</div>
	<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
	<script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script type="text/javascript" src = './js/ptweixin.js'></script>	
	<script type="text/javascript">
	<?php 
		require_once('./config.php');
		require_once('./class/conn.class.php');
		include('./include/function.php');
		$user_openid = $_GET['openid'];
		$user_ptid = -1;
		$con = new conn();
		if( bind_check() ) :
			$sql = "SELECT `username` FROM `users` WHERE `id` = $user_ptid ";
			$result = $con->query($sql);
			$username = $result[0]['username'];
		?>

			$('#bind-success').html('成功绑定账号:'+<?php echo "'$username'";?>);
			$('#bind-success').show();
			$('#bind-button').attr('disabled','disabled');
		<?php endif
			
		?>
	</script>
</body>
