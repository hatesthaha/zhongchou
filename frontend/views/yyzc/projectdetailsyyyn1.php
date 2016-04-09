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
	<meta content="转让变现快,提现实时到,多重保障,本息保护,账户托管至新浪支付" name="Keywords">
	<meta name="description" content="仌仌众梦" />	
	<title>获得者本次所有参与码</title>
	<?= Html::cssFile('@web/style/css/font-awesome.min.css') ?>
	<?= Html::cssFile('@web/style/css/reset.css') ?>
	<?= Html::cssFile('@web/style/css/style.css') ?>
</head>
<body>
	<section class="bodyA"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/u0.gif" alt=""></section>
	<div id="body_h" class="bgeee">
		<section class="pagetop">
			<a class="pagetopleft" href="javascript:history.go(-1)"><i class='icon-angle-left'></i></a>
			<h2>获得者本次所有参与码</h2>
			<a class="pagetopright" href="/"></a>
		</section>
		<section class="headerh"></section>
		<p class="modular44">幸运得主本次总共参与 <span class="redcol"><?= $times; ?></span> 人次</p>
		<section class="modular45">
<!-- 			<h2>2016-03-01 10:22:59.564</h2> -->
				<ul class="clearfix">
					<?php foreach ($nums as $key => $value): ?>
					<li style="color:<?php if($value['lucky_num'] == $lucky){echo 'red';}?>;"><?= $value['lucky_num']; ?></li>
					<?php endforeach ?>
				</ul>
		</section>
	</div>
<?= Html::jsFile('@web/style/js/jquery-2.1.1.min.js') ?>
<?= Html::jsFile('@web/style/js/reset.js') ?>
<script>
	$(document).ready(function(){
	    var UA=window.navigator.userAgent;  //使用设备
	    var CLICK="click";
	    if(/ipad|iphone|android/.test(UA)){   //判断使用设备
	        CLICK="tap";
	    };
	    $(".swipe li img").height($(".swipe li img").width()/2);
		$(".bodyA").hide();
	})
</script>
</body>
</html>