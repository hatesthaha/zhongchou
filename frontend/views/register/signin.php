<?php
use yii\helpers\Html;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta content="yes" name="apple-mobile-web-app-capable">
	<meta content="yes" name="apple-touch-fullscreen">
	<meta name="data-spm" content="a215s">
	<meta content="telephone=no,email=no" name="format-detection">
	<meta content="fullscreen=yes,preventMove=no" name="ML-Config">
    	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<meta name="description" content="仌仌众梦" />	
	<title>登录</title>
	<?= Html::cssFile('@web/style/css/font-awesome.min.css') ?>
	<?= Html::cssFile('@web/style/css/reset.css') ?>
	<?= Html::cssFile('@web/style/css/style.css') ?>
</head>
<body>
	<section class="bodyA"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/u0.gif" alt=""></section>
	<div id="body_h">
		<section class="pagetop">
			<a class="pagetopleft" href="javascript:history.go(-1)"><i class='icon-angle-left'></i></a>
			<h2>登录</h2>
			<a class="pagetopright" href="/"></a>
		</section>
		<section class="headerh"></section>
		<section class="modular8">
			<p class="modular9"><img width="100%" src="<?= Yii::getAlias('@web') . '/' ?>style/images/header-img.jpg" alt="头像"></p><!--头像必须传正方形的-->
			<form action="" method="post">
				<div class="oneelement borall">
					<input class="changeelement iconinput1" type="text" name="emailorphone" placeholder="输入邮箱或手机号码" value="">
				</div>
				<div class="oneelement borall">
					<input type="password" class="changeelement iconinput2" name="password" placeholder="输入密码">
				</div>
				<p class="form-ok"><input class="formok-btn bgfeb528-wf" name="formok-btn" type="submit" value="登录"></p>
				<p class="fixedelement3 clearfix"><a class="float-left" href="/register/forgetpassword">忘记密码？</a><a class="float-right" href="/register/register">立即注册</a></p>
			</form>
		</section>
	</div>
	<p id="tip-error"><span>表单验证错误信息</span></p>
<?= Html::jsFile('@web/style/js/jquery-2.1.1.min.js') ?>
<?= Html::jsFile('@web/style/js/reset.js') ?>
<script>
	$(document).ready(function(){
		$(".formok-btn").click(function(event){
			event.preventDefault();
			var emailorphone=$("input[name='emailorphone']").val();
			var password=$("input[name='password']").val();
			if(!emailorphone || !password){
				$('#tip-error span').html('账号或密码为空');
				$('#tip-error').show();
				setTimeout(function(){$('#tip-error').fadeOut(500);},1000);
			}else{
				$(".formok-btn").parents("form").submit();
			}
		});
		$(".bodyA").hide();
	})
</script>
<?php if(!empty($_GET['login'])): ?>
	<script>
		$('#tip-error span').html('账号或密码错误');
		$('#tip-error').show();
		setTimeout(function(){$('#tip-error').fadeOut(500);},1000);
	</script>
<?php endif ?>
</body>
</html>