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
	<title>编辑昵称</title>
	<?= Html::cssFile('@web/style/css/font-awesome.min.css') ?>
	<?= Html::cssFile('@web/style/css/reset.css') ?>
	<?= Html::cssFile('@web/style/css/style.css') ?>
</head>
<body>
	<section class="bodyA"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/u0.gif" alt=""></section>
	<div id="body_h">
		<section class="pagetop">
			<a class="pagetopleft" href="/center/personaldata"><i class='icon-angle-left'></i></a>
			<h2>编辑性别</h2>
			<a class="pagetopright" href="/"></a>
		</section>
		<section class="headerh"></section>
		<section class="modular8">
			<form action="" method="post">
				<div class="oneelement borall">
					<select name="sex" id="" style="width:100%;display:block;direction: rtl;padding:0;">
						<option value="<?php echo $userinfo['gender']; ?>"><?php if($userinfo['gender'] == "1"){echo "男";}elseif($userinfo['gender'] == "2"){echo "女";}else{echo "请选择";}?></option>
						<option value="1">男</option>
						<option value="2">女</option>
					</select>
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
			var sex=$("select[name='sex']").val();
			reg=/(^[1][358][0-9]{9}$)/;
			if(!sex){
				$('#tip-error span').html('请选择性别');
				$('#tip-error').show();
				setTimeout(function(){
					$('#tip-error').fadeOut(500);
				},1000);
				$("select[name='sex']").focus();
			}else{
				$(this).parents("form").submit();
			}
		});
		$(".bodyA").hide();
	})
</script>
</body>
</html>