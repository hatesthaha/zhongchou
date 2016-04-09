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
	<title><?= $product['name']; ?></title>
	<?= Html::cssFile('@web/style/css/font-awesome.min.css') ?>
	<?= Html::cssFile('@web/style/css/reset.css') ?>
	<?= Html::cssFile('@web/style/css/style.css') ?>
</head>
<body>
	<section class="bodyA"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/u0.gif" alt=""></section>
	<div id="body_h" class="bgeee">
		<section class="pagetop">
			<a class="pagetopleft" href="javascript:history.go(-1)"><i class='icon-angle-left'></i></a>
			<h2><?= $product['name']; ?></h2>
			<a class="pagetopright" href="/"></a>
		</section>
		<section class="headerh"></section>
		<section class="bannerPane2">
		    <div class="swipe">
		        <ul id="slider">
		        	<?php foreach(explode(",",$product['img']) as $_k => $vo): ?>
		            <li style="display:block;">
		                <img width="100%" src="<?= Yii::getAlias('@web') . '/' ?>upload/<?= $vo; ?>" alt="项目名称" />
		            </li>
		            <?php endforeach; ?>
		        </ul>
		        <div id="pagenavi">
		        	<?php foreach(explode(",",$product['img']) as $_k => $vo): ?>
		            <a href="javascript:void(0);" class="<?php if($_k == "0"){echo "active";}?>"><?= $_k; ?></a>
		            <?php endforeach; ?>
		        </div>
		    </div>
		</section>
		<section class="modular30">
			<p class="modular30-con1"><span></span></p>
			<p class="modular30-con2 clearfix"><span class="float-left">￥<?= $product['target_money']; ?></span><span class="float-right"><em id="progressN" class="hide"><?php echo $product['total_money']/$product['target_money']*100; ?></em><?php $res = $product['target_money']-$product['total_money']; if($res == "0"){echo "已完成";}elseif($res < "0"){ echo "超额完成";}else{echo "￥".$res;} ?></span></p>
			<p class="modular30-con3 clearfix"><span class="float-left">总需人次</span><span class="float-right">剩余人次</span></p>
		</section>
		<section class="modular40">
			<h2>奖品获得者</h2>
			<div class="modular40-con">
				<a href="/yyzc/projectdetailsyyyn1/?id=<?= $_GET['id']; ?>">
				<p class="modular40-conimg"><img width="100%" height="100%" src="<?= Yii::getAlias('@web') . '/' ?>style/images/yyzc.png" alt="一元众筹"></p>
				<div class="modular40-condiv">
					<ul>
						<li>获得者：<span style="color:red;"><?php if(!empty($who['name'])): ?><?= $who['name']; ?><?php else: ?><?= $who['phone']; ?><?php endif ?></span></li>
						<li>参与时间：<?= date("Y-m-d H:i:s",$time['created_at']); ?></li>
						<li>本次参与：<span style="color:red;"><?= $times; ?></span> 人次</li>
						<li>幸运号码：<span style="color:red;"><?= $lucky; ?></span></li>
					</ul>
				</div>
				</a>
			</div>
		</section>
		<section class="modular41">
			<ul><li><a href="/yyzc/projectdetailsyyn1/?id=<?php echo $_GET['id']; ?>">所有记录<i class="icon-angle-right"></i></a></li></ul>
			<ul><li><a href="/yyzc/projectdetailsyyn2/?id=<?php echo $_GET['id']; ?>">项目详情<i class="icon-angle-right"></i></a></li></ul>
			<ul><li><a href="/yyzc/projectdetailsyyn3/?id=<?php echo $_GET['id']; ?>">计算详情<i class="icon-angle-right"></i></a></li></ul>
		</section>
	</div>
<?= Html::jsFile('@web/style/js/touchscroll.js') ?>
<?= Html::jsFile('@web/style/js/touchscroll.dev.js') ?>
<?= Html::jsFile('@web/style/js/run.js') ?>
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