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
	<title>重新绑定手机号</title>
	<?= Html::cssFile('@web/style/css/font-awesome.min.css') ?>
	<?= Html::cssFile('@web/style/css/reset.css') ?>
	<?= Html::cssFile('@web/style/css/style.css') ?>
</head>
<body>
	<section class="bodyA"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/u0.gif" alt=""></section>
	<div id="body_h">
		<section class="pagetop">
			<a class="pagetopleft" href="/center/personaldata"><i class='icon-angle-left'></i></a>
			<h2>重新绑定手机号</h2>
			<a class="pagetopright" href="/"></a>
		</section>
		<section class="headerh"></section>
		<section class="modular8">
			<form action="" method="post">
				<div class="oneelement borall">
					<input class="changeelement" type="text" name="phone" placeholder="输入要绑定的手机号" value="">
				</div>
				<div class="twoelement haveborder">
					<input type="text" class="changeelement borall changeelementts" name="code" placeholder="请输入短信验证码">
					<p class="fixedelement1 bgfeb528-wf xjclass1">
						<input type="button" id="getnow" value="立即获取" >
					</p>
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
			var phone=$("input[name='phone']").val();
			var code=$("input[name='code']").val();
			reg=/(^[1][3578][0-9]{9}$)/;
			if(!reg.test(phone)){
				$('#tip-error span').html('请正确输入手机号');
				$('#tip-error').show();
				setTimeout(function(){
					$('#tip-error').fadeOut(500);
				},1000);
				$("input[name='phone']").focus();
			}else{
				$.post("/register/checkcode",{code:code,phone:phone},function(result){
					if(result == "1"){
						$(".formok-btn").parents("form").submit();
					}else{
						$('#tip-error span').html('请正确输入验证码');
						$('#tip-error').show();
						setTimeout(function(){$('#tip-error').fadeOut(500);},1000);
						$("input[name='code']").focus();
					}
				});
			}
		});
		$(".bodyA").hide();
		$("#getnow").click(function(event){
			event.preventDefault();
			var phone=$("input[name='phone']").val();
			reg=/(^[1][358][0-9]{9}$)/;
			if(!reg.test(phone)){
				$('#tip-error span').html('请正确输入手机号');
				$('#tip-error').show();
				setTimeout(function(){$('#tip-error').fadeOut(500);},1000);
				$("input[name='phone']").focus();
			}else{
				$.post("/register/checkphone",{phone:phone},function(result){
					if(result == "1"){
						var wait=60;
						function time() {
							if (wait == 0) {
								$(".xjclass1").removeClass("bghui-wc");
								$(".xjclass1").addClass("bgfeb528-wf");
								$("#getnow").attr("disabled", false);
								$("#getnow").val("重新获取");
								wait = 60;
							} else {
								$(".xjclass1").removeClass("bgfeb528-wf");
								$(".xjclass1").addClass("bghui-wc");
								$("#getnow").attr("disabled", true);
								$("#getnow").val("重新获取" + wait);
								wait--;
								setTimeout(function() {
									time()
								},1000)
							}
						}
						time();
						$.post("/register/getnow",{phone:phone},function(result){
							$('#tip-error span').html('验证码已发送，请注意查收');
							$('#tip-error').show();
							setTimeout(function(){$('#tip-error').fadeOut(500);},1000);
						});
					}else{
						$('#tip-error span').html('此手机号已注册');
						$('#tip-error').show();
						setTimeout(function(){$('#tip-error').fadeOut(500);},1000);
					}
				});
			}
		});
	})
</script>
</body>
</html>