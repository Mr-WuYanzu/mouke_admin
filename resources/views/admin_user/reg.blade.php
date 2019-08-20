<!DOCTYPE html>
<html>
<!-- Head -->
<head>
	<title>XXXXXXXXXXXXXXXX</title>
	<!-- Meta-Tags -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<script src="https://cdn.dingxiang-inc.com/ctu-group/captcha-ui/index.js"></script>
		{{--<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>--}}
	<!-- //Meta-Tags -->

	<!-- Style --> <link rel="stylesheet" href="/css/style.css" type="text/css" media="all">
</head>
<!-- //Head -->
<!-- Body -->
<body>
	<h1>注册</h1>
	<div class="container w3layouts agileits">
		<div >

			<h2>注 册</h2>

			<div class="send-button w3layouts agileits">
				<input type="text" Name="Name" placeholder="用户名" required="">
				<input type="text" Name="Email" placeholder="邮箱" required="">
				<input type="password" Name="Password" placeholder="密码" required="">
				<input type="text" Name="Phone Number" placeholder="手机号码" required="">



				<div id="demo-inline-down"></div>


			</div><input type="submit" value="免费注册">
		</div>
		<div class="clear"></div>
	</div>
</body>
<!-- //Body -->
</html>
<script src="./layui/layui.js"></script>
<script src="./js/jquery-3.2.1.min.js"></script>
<script>
	$(function(){
		var _token='';
		var myCaptcha = _dx.Captcha(document.getElementById('demo-inline-down'), {
			appId: '8c0fd7390d55c12925d5d104e83d906b',
			style: 'inline',
			language: 'cn', // 语言为英语
			width:300,
			success: function (token) {
				// console.log('token:', token);
				_token = token;
			}
		});

		//点击注册 判断验证码是否正确
		$(document).on('click','#test',function(){
			if(_token == ''){
				layer.msg('请点击验证',{icon:5,time:1000});
			}else{
				layer.msg('验证成功',{icon:1,time:1000});
			}
		});
	})
</script>