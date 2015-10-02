$('#bind-button').click(function () {
	var user = $('#User').val();
	var password = $('#Password').val();
	var openid = $('#openid').html();
	$.post(
		'do.php',
		{user:user,password:password,openid:openid},
		function (data) {
			msg_handle( data, function ( data ){
				alert('绑定成功!');
				$('#bind-success').html('成功绑定账号:'+user);
				$('#bind-success').show();
				$('#bind-button').attr('disabled','disabled');
			})} ,
		'json');
})
$('.download').click(function () {
	var url = $(this).attr('href');
	$.post(
		url,
		// msg_handle( data , function (data){
		// 	alert('添加下载成功!');
		// 	$(this).attr('disabled','disabled');
		// }),
		function (data){
			msg_handle(data , function (data) {
				alert('添加下载成功!');
		 		$(this).attr('disabled','disabled');
			})
		},
		'json'
		)
})
function msg_handle( data , callback ) {
	if ( data.status == 'fail')
		alert(data.errmsg);
	else if( data.status == 'success' ){
		if( callback ){
			callback( data );
		}
	}
}