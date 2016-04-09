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
	<title>常见问题</title>
	<?= Html::cssFile('@web/style/css/font-awesome.min.css') ?>
	<?= Html::cssFile('@web/style/css/reset.css') ?>
	<?= Html::cssFile('@web/style/css/style.css') ?>
</head>
<body>
	<section class="bodyA"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/u0.gif" alt=""></section>
	<div id="body_h">
		<section class="pagetop">
			<a class="pagetopleft" href="/center/personalcenter"><i class='icon-angle-left'></i></a>
			<h2>操作指南</h2>
			<a class="pagetopright" href="/"></a>
		</section>
		<section class="headerh"></section>
		<section class="modular8">
			<p class="text-c"><img width="20%" src="<?= Yii::getAlias('@web') . '/' ?>style/images/header-img.png" alt=""></p><br>
			<?= $caozuozhinan['content']; ?> <br><br><br><br>
			<p class="nextlinkpage">
						<a class="bgfeb528-wf" href="/site/caozuozhinan?isok=1">朕明白了！</a>
					</p>
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
			reg=/(^[1][358][0-9]{9}$)/;
			if(!reg.test(phone)){
				$('#tip-error span').html('请正确输入手机号');
				$('#tip-error').show();
				setTimeout(function(){
					$('#tip-error').fadeOut(500);
				},1000);
				$("input[name='phone']").focus();
			}else{
				$(this).parents("form").submit();
			}
		});
		$(".bodyA").hide();
	})
</script>
</body>
</html>