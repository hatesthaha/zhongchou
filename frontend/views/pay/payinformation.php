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
	<title>支付信息</title>
	<?= Html::cssFile('@web/style/css/font-awesome.min.css') ?>
	<?= Html::cssFile('@web/style/css/reset.css') ?>
	<?= Html::cssFile('@web/style/css/style.css') ?>
</head>
<body>
 <form id="form1" method="post" action="<?php echo "/pay/weixin?jine=$jine&oid=$oid&pid=$pid"; ?>">
	<section class="bodyA"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/u0.gif" alt=""></section>
	<div id="body_h" class="bgeee">
		<section class="pagetop">
			<a class="pagetopleft" href="javascript:history.go(-1)"><i class='icon-angle-left'></i></a>
			<h2>支付信息</h2>
			<a class="pagetopright" href="/"></a>
		</section>
		<section class="headerh"></section>
		<p class="modular23">订单总额：<span>￥<?= $jine?></span><input name="order" type="hidden" value="<?= $oid ?>"/><input name="pid" type="hidden" value="<?= $pid ?>"/></p>
		<section class="modular24">
			<ul>
				<input type="hidden" name="jine" value="<?= $jine?>">
				<input type="hidden" name="oid" value="<?= $oid?>">
				<input type="hidden" name="pid" value="<?= $pid?>">
<!-- 				<li>
					<div>
						<p class="modular24img"><img width="100%" src="<?= Yii::getAlias('@web') . '/' ?>style/images/pay1.png" alt="网银支付"></p>
						<div class="modular24word">
							<div id="1">
								<h2>百度钱包</h2>
								<p>百度安全支付服务百度安全支付服务百度安全支付服务</p>
							</div>
						</div>
					</div>
				</li>
				<li>
					<div>
						<p class="modular24img"><img width="100%" src="<?= Yii::getAlias('@web') . '/' ?>style/images/pay2.png" alt="百度钱包"></p>
						<div class="modular24word">
							<div id="2">
								<h2>百度钱包</h2>
								<p>百度安全支付服务</p>
							</div>
						</div>
					</div>
				</li> -->
				<li>
					<div>
						<p class="modular24img"><img width="100%" src="<?= Yii::getAlias('@web') . '/' ?>style/images/pay3.png" alt="微信支付"></p>
						<div class="modular24word">
							<div id="3">
								<h2>微信支付</h2>
								<p>微信安全支付服务</p>
							</div>
						</div>
					</div>
				</li>
				<!--<li>
					<div>
						<p class="modular24img"><img width="100%" src="<?= Yii::getAlias('@web') . '/' ?>style/images/pay4.png" alt="支付宝"></p>
						<div class="modular24word">
							<div id="4" class="current5">
								<h2>支付宝</h2>
								<p>百度安全支付服务</p>
							</div>
						</div>
					</div>
				</li>-->
			</ul>
		</section>
		<div>
			<p class="form-ok modular8" >
				<!---<a class="bgfeb528-wf" href="javascript:pay();">确认支付</a></a>-->
				<a><input class="bgfeb528-wf" type="submit" name="" value="确认支付"  />
			</p>
		</div>
	</div>
</form>
<?= Html::jsFile('@web/style/js/jquery-2.1.1.min.js') ?>
<?= Html::jsFile('@web/style/js/reset.js') ?>
<script>
	
	//ISONE =0
	$(document).ready(function(){
		// $(".modular24 li").click(function(event){
		// 	$(".modular24word > div").removeClass("current5");
		// 	$(this).find(".modular24word > div").addClass("current5");
		// 	var zhifu=$(this).find(".modular24word > div").attr('id');
		// 	if (zhifu==4){
		// 		document.getElementById("form1").action="/pay/payconfirm?jine=<?= $jine?>&oid=<?= $oid ?>&pid=<?= $pid ?>";
		// 	}else if(zhifu==3){
		// 		document.getElementById("form1").action="/pay/weixin?jine=<?= $jine?>&oid=<?= $oid ?>&pid=<?= $pid ?>";
		// 	}
		// });
		$(".bgfeb528-wf").click(function(){
			this.disabled='disabled';
			$('#form1').submit();
		})
	});
	$(".bodyA").hide();
	
</script>
</body>
</html>