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
	<title><?= $cont['name']; ?></title>
	<?= Html::cssFile('@web/style/css/font-awesome.min.css') ?>
	<?= Html::cssFile('@web/style/css/reset.css') ?>
	<?= Html::cssFile('@web/style/css/style.css') ?>
</head>
<body>
	<section class="bodyA"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/u0.gif" alt=""></section>
	<div id="body_h">
		<section class="pagetop">
			<a class="pagetopleft" href="javascript:history.go(-1)"><i class='icon-angle-left'></i></a>
			<h2><?= $cont['name']; ?></h2>
			<a class="pagetopright" href="/"></a>
		</section>
		<section class="headerh"></section>
		<section class="modular31">
			<?php
				$img = explode(",",$cont['c_img']);
			?>
			<p>
				<?php
				if(!empty($img)){
				foreach ($img as $key => $value){ ?>
					<img width="100%" src="<?= Yii::getAlias('@web') . '/' ?>upload/<?= $value; ?>" alt="项目详情">
				<?php }} ?>
				<?= $cont['content']; ?></p>
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
	    var progressN = parseInt($("#progressN").text());
	    console.log(progressN);
	    $(".modular30-con1 span").css("width",progressN+"%");
		$(".bodyA").hide();
		$("#showshare")[CLICK](function(){
			event.preventDefault();
			$(".mask-share").removeClass("hide");
			$(".mask-sharebox").animate({bottom:"0"},300);
		});
		$("#noshare")[CLICK](function(){
			event.preventDefault();
			$(".mask-share").addClass("hide");
			$(".mask-sharebox").animate({bottom:"-80rem"},300);
		});
	})
</script>
</body>
</html>