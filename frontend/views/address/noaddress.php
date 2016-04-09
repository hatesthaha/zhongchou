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
	<title>收货地址</title>
	<?= Html::cssFile('@web/style/css/font-awesome.min.css') ?>
	<?= Html::cssFile('@web/style/css/reset.css') ?>
	<?= Html::cssFile('@web/style/css/style.css') ?>
</head>
<body>
	<section class="bodyA"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/u0.gif" alt=""></section>
	<div id="body_h">
		<section class="pagetop">
			<a class="pagetopleft" href="javascript:history.go(-1)"><i class='icon-angle-left'></i></a>
			<h2>收货地址</h2>
			<a class="pagetopright formok-btn" href="/"></a>
		</section>
		<section class="headerh"></section>
		<section class="modular7">
			<form action="/" method="post">
				<br><br><br>
				<p class="text-c"><img width="38%;" src="<?= Yii::getAlias('@web') . '/' ?>style/images/no-address.jpg" alt="没有填写收货地址"></p><br>
				<p class="font14 text-c redcc">您还没有填写收货地址</p>
				<p class="nextlinkpage">
					<a class="bgfeb528-wf" href="/address/receiptaddaddress">添加收货地址</a>
				</p>
		</section>
	</div>
	<p id="tip-error"><span>表单验证错误信息</span></p>
<?= Html::jsFile('@web/style/js/jquery-2.1.1.min.js') ?>
<?= Html::jsFile('@web/style/js/reset.js') ?>
<script>
	$(document).ready(function(){
		var UA=window.navigator.userAgent;  //使用设备
		var CLICK="click";
		if(/ipad|iphone|android/.test(UA)){   //判断使用设备
			CLICK="tap";
		};
		$(".bodyA").hide();
	})
</script>
</body>
</html>