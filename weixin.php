<?php
require_once("include/bittorrent.php");
dbconn(true);
require_once(get_langfile_path("torrents.php"));
loggedinorreturn();
parked();
if (isset($searchstr))
	stdhead($lang_torrents['head_search_results_for'].$searchstr_ori);
elseif ($sectiontype == $browsecatmode)
	stdhead($lang_torrents['head_torrents']);
else stdhead($lang_torrents['head_music']);
print("<table width=\"940\" class=\"main\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td  class=\"embedded\">");
	$rss = "http://pt.ghtt.net/torrentrss.php?rows=50&linktype=dl&passkey={$CURUSER['passkey']}&inclbookmarked=1";
	
	if (isset($_GET['do']) && $_GET['do']=='clear'){
		$sql = "SELECT * FROM `weixin` WHERE `ptid` = {$CURUSER['id']}";
		$res = sql_query($sql);
		if(mysql_num_rows($res) >0){
			$sql = "DELETE FROM `bookmarks` WHERE `userid` = {$CURUSER['id']}";
			sql_query($sql);
			$Cache->delete_value('user_'.$user_ptid.'_bookmark_array');
			if(mysql_affected_rows() > 0)
				echo "<script> alert ('清理成功')</script>";
			else 
				echo "<script> alert ('清理失败...')</script>";
		}
	}
?>
<div>
	<style type="text/css">
	.pic img {
		max-width: 300px;
	}
	#rss {
		font-weight: bold;
    	color: red;
	}
	.pic {
	}
	.utpic {
		border: solid thin;
    border-left: none;
    border-right: none;
    padding-bottom: 15px;
	}
	.weixinqr{
		position: absolute;
		right: 148px;
    	top: 460px;
	}
	.weixinqr img {
		max-width: 180px;
		
	}
	</style>
<div align=center>
	<h3>欢迎使用百川PT微信下载功能</h3>
	<p>功能简介:远程下载</p>
	<p>注意:</p>
	<p>使用远程下载功能将会定期清空你的收藏夹!</p>
	<p>若无法使用,请点击<a style='color:red' href = 'weixin.php?do=clear'>这里</a>恢复.<span style="color:red">这将清空你的收藏夹!</span></p>
	<p>Tips:添加下载后,由于网站缓存的缘故,可能不会立即下载.稍安勿躁.</p>
</div>
<div class = 'weixinqr' align=center>
	<img src = './ptweixin/weimg/qrcode.jpg'>
	<p>delltester</p>
</div>
<div class = 'set-ut'  align=center>
	<h4>Utorrent客户端设置</h4>
	<div class = 'utpic'>
		<p>1.右键 订阅</p>
		<img src = './ptweixin/weimg/step 1.png'>
	</div>
	<div class = 'utpic'>
		<p>2.点击 添加RSS订阅</p>
		<img src = './ptweixin/weimg/step 2.png'>
		
	</div>
	<div class = 'utpic'>
		<p>3.在订阅链接中输入下载链接</p>
		<p>这是你的下载链接(请勿泄露)<p>
		<p><span id = 'rss'><?php echo $rss; ?></span></p>
		<p>勾选 自动下载</p>
		<img src = './ptweixin/weimg/step 3.png'>
		
	</div>
	<div class = 'utpic'>
		<p>4.点击 选项</p>
		<img src = './ptweixin/weimg/step 4.png'>
		
	</div>
	<div class = 'utpic'>
		<p>5.点击 框 1 </p>
		<p>在框 2 中设置下载位置</p>
		<img src = './ptweixin/weimg/step 5.png'>
		
	</div>
	<h4>到此Utorrent客户端设置完毕</h4>
</div>
<br><br><br>
<div class='set-we' align=center>
<h3>功能展示</h3>
<div class = 'pic'>
	<p>发送 绑定 .绑定PT账号.</p>
	<img src = './ptweixin/weimg/we bind 1.png'>

</div>
<div class = 'pic'>
	<p>点击链接,进入绑定页面</p>
	<p>输入 PT账号,密码 完成绑定</p>
	<img src = './ptweixin/weimg/we bind 2.png'>
	<img src = './ptweixin/weimg/we bind 3.png'>
	
</div>
<div class = 'pic'>
	<p>发送 状态 ,可以看到当前的做种情况</p>
	<img src = './ptweixin/weimg/we status.png'>
	
</div>
<div class = 'pic'>
	<p>发送 查询@关键字 查询种子</p>
	<img src = './ptweixin/weimg/we search.png'>
	
</div>
<div class = 'pic'>
	<p>点击 下载 跳转至下载页面</p>
	<img src = './ptweixin/weimg/we download d.png'>
	
</div>
<div class = 'pic'>
	<p>点击 详情,可以看到种子的简介</p>
	<img src = './ptweixin/weimg/we detail.png'>
	
</div>
<div class = 'pic'>
	<p>在详情页点击 下载,也可远程下载</p>
	<img src = './ptweixin/weimg/we download.png'>
	
</div>
<div class = 'pic'>
	<p>重复下载会有提示</p>
	<img src = './ptweixin/weimg/we repeat.png'>
	
</div>
<div class = 'pic'>
	<p>热门种子,新种子查询</p>
	<img src = './ptweixin/weimg/we new.png'>
	<img src = './ptweixin/weimg/we hot.png'>
	
</div>
<div class = 'pic'>
	<p>种子列表</p>
	<img src = './ptweixin/weimg/we list.png'>
</div>
<h1>Enjoy It!</h1>
</div>

</div>
<br>
 
<?php 
print("</td></tr></table>");
stdfoot();
?>