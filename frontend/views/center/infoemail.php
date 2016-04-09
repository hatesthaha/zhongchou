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
	<title>编辑邮箱</title>
	<?= Html::cssFile('@web/style/css/font-awesome.min.css') ?>
	<?= Html::cssFile('@web/style/css/reset.css') ?>
	<?= Html::cssFile('@web/style/css/style.css') ?>
</head>
<body>
	<section class="bodyA"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/u0.gif" alt=""></section>
	<div id="body_h">
		<section class="pagetop">
			<a class="pagetopleft" href="/center/personaldata"><i class='icon-angle-left'></i></a>
			<h2>编辑邮箱</h2>
			<a class="pagetopright" href="/"></a>
		</section>
		<section class="headerh"></section>
		<section class="modular8">
			<form action="" method="post" id="form">
				<div class="oneelement borall">
					<input class="changeelement" type="text" name="email" placeholder="输入当前绑定的邮箱" value="<?php echo $userinfo['email']; ?>">
				</div>
				<p class="form-ok"><input class="formok-btn bgfeb528-wf" name="formok-btn" type="submit" value="确认"></p>
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
			var email=$("input[name='email']").val();
			reg=/(^[1][358][0-9]{9}$)/;
			if(!email){
				$('#tip-error span').html('请输入您的邮箱');
				$('#tip-error').show();
				setTimeout(function(){
					$('#tip-error').fadeOut(500);
				},1000);
				$("input[name='email']").focus();
			}else if(email.length > 50){
				$('#tip-error span').html('邮箱过长');
				$('#tip-error').show();
				setTimeout(function(){
					$('#tip-error').fadeOut(500);
				},1000);
				$("input[name='email']").focus();
			}else{
				$.post("/register/checkemail",{email:email},function(result){
					if(result == "1"){
						$("#form").submit();
					}else{
						$('#tip-error span').html('此邮箱已被绑定，请更换重试');
						$('#tip-error').show();
						setTimeout(function(){$('#tip-error').fadeOut(500);},1000);
					}
				});
			}
		});
		$(".bodyA").hide();
	})
</script>
</body>
</html>