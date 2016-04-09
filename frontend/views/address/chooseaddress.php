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
	<title>选择收货地址</title>
	<?= Html::cssFile('@web/style/css/font-awesome.min.css') ?>
	<?= Html::cssFile('@web/style/css/reset.css') ?>
	<?= Html::cssFile('@web/style/css/style.css') ?>
</head>
<body>
	<section class="bodyA"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/u0.gif" alt=""></section>
	<div id="body_h" class="bgeee">
		<section class="pagetop">
			<a class="pagetopleft" href="javascript:history.go(-1)"><i class='icon-angle-left'></i></a>
			<h2>选择收货地址</h2>
			<?php if(!empty($_GET['type']) && !empty($_GET['pid'])){?>
			<a class="pagetopright" href="/address/manageaddress/?type=yy&pid=<?= $_GET['pid']; ?>">管理</a>
			<?php }elseif(!empty($_GET['xiugai']) && $_GET['xiugai']=='true' && !empty($_GET['pid']) && is_numeric($_GET['pid']) ){ ?>
				<a class="pagetopright" href="/address/manageaddress/?xiugai=true&pid=<?= $_GET['pid'] ?>">管理</a>
			<?php } else{ ?>
			<a class="pagetopright" href="/address/manageaddress">管理</a>
			<?php }?>
		</section>
		<section class="headerh"></section>
		<section class="modular17">
			<ul>
				<?php foreach($add as $_k => $vo) { ?>
				<li>
				<?php if(!empty($_GET['type']) && !empty($_GET['pid'])){?>
				<a href="/order/orderinformationyy/?pid=<?= $_GET['pid']; ?>&id=<?= $vo['id']; ?>">
				<?php }elseif(!empty($_GET['xiugai']) && $_GET['xiugai']=='true' && !empty($_GET['pid']) && is_numeric($_GET['pid']) ){ ?>
				<a href="/project/xiugai/?aid=<?= $vo['id']; ?>&pid=<?= $_GET['pid'] ?>">
				<?php }else{ ?>
				<a href="/project/wanttolaunch/?id=<?= $vo['id']; ?>">
				<?php }?>
				<input type="hidden" value="<?= $vo['id']; ?>" id="editme">
					<div class="modular17-con">
						<p class="clearfix text-r"><span class="float-left">收货人：<?= $vo['username']; ?></span><span class="modular17-cond"><?= $vo['phone']; ?></span></p>
						<p class="modular17-cond">收货地址：<?= $vo['province']; ?><?= $vo['city']; ?><?= $vo['county']; ?><?= $vo['address']; ?></p>
					</div>
				</a>
				</li>
				<?php }?>
			</ul>
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
		$(".modular17 li")[CLICK](function(){
			$(".modular17 li").removeClass("current4");
			$(this).addClass("current4");
		})
		$(".bodyA").hide();
	})
</script>
</body>
</html>