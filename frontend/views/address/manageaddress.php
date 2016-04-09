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
	<title>管理收货地址</title>
	<?= Html::cssFile('@web/style/css/font-awesome.min.css') ?>
	<?= Html::cssFile('@web/style/css/reset.css') ?>
	<?= Html::cssFile('@web/style/css/style.css') ?>
</head>
<body>
	<section class="bodyA"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/u0.gif" alt=""></section>
	<div id="body_h" class="bgeee">
		<section class="pagetop">
			<a class="pagetopleft" href="javascript:history.go(-1)"><i class='icon-angle-left'></i></a>
			<h2>管理收货地址</h2>
			<a class="pagetopright">完成</a>
		</section>
		<section class="headerh"></section>
		<section class="modular17">
			<ul>
				<?php foreach($add as $_k => $vo) : ?>
				<li <?php if(count($add)-1==$_k){echo 'class="current3"';}?>>
				<input type="hidden" value="<?= $vo['id']; ?>" id="editme">
					<div class="modular17-con">
						<p class="clearfix text-r"><span class="float-left">收货人：<?= $vo['username']; ?></span><span class="modular17-cond"><?= $vo['phone']; ?></span></p>
						<p class="modular17-cond">收货地址：<?= $vo['province']; ?><?= $vo['city']; ?><?= $vo['county']; ?><?= $vo['address']; ?></p>
					</div>
				</li>
				<?php endforeach;?>
			</ul>
		</section>
		<div>
			<p class="nextlinkpage">
				<?php if(!empty($_GET['type']) && !empty($_GET['pid'])){ ?>
				<a class="bgfeb528-wf" href="/address/receiptaddaddress3/?type=yy&pid=<?= $_GET['pid']; ?>">添加新地址</a>
				<?php }elseif(!empty($_GET['xiugai']) && $_GET['xiugai']=='true' && !empty($_GET['pid']) && is_numeric($_GET['pid']) ){ ?>
					<a class="bgfeb528-wf" href="/address/receiptaddaddress3?xiugai=true&pid=<?= $_GET['pid'] ?>">添加新地址</a>
				<?php }else{ ?>
				<a class="bgfeb528-wf" href="/address/receiptaddaddress3">添加新地址</a>
				<?php } ?>
			</p>
		</div>
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
			$(".modular17 li").removeClass("current3");
			$(this).addClass("current3");
		})
		$(".bodyA").hide();
		$(".pagetopright").click(function(){
			var val = $(".current3 #editme").val();
			if(!val){
				$('#tip-error span').html('请选择一项');
				$('#tip-error').show();
				setTimeout(function(){$('#tip-error').fadeOut(500);},1000);
				return false;
			}else{
				<?php if(!empty($_GET['type']) && !empty($_GET['pid'])){ ?>
					location.href = "/order/orderinformationyy/?pid=<?= $_GET['pid']; ?>&id="+val;
				<?php }elseif(!empty($_GET['xiugai']) && $_GET['xiugai']=='true' && !empty($_GET['pid']) && is_numeric($_GET['pid']) ){ ?>
				location.href = "/project/xiugai/?pid=<?= $_GET['pid'] ?>&aid="+val;
			
				<?php }else{ ?>
					location.href = "/project/wanttolaunch/?id="+val;
				<?php } ?>
			}
		});
	})
</script>
</body>
</html>