<?php
use yii\helpers\Html;
use frontend\models\Member;
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
	<title>计算结果</title>
	<?= Html::cssFile('@web/style/css/font-awesome.min.css') ?>
	<?= Html::cssFile('@web/style/css/reset.css') ?>
	<?= Html::cssFile('@web/style/css/style.css') ?>
</head>
<body>
	<section class="bodyA"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/u0.gif" alt=""></section>
	<div id="body_h">
		<section class="pagetop">
			<a class="pagetopleft" href="javascript:history.go(-1)"><i class='icon-angle-left'></i></a>
			<h2>计算结果</h2>
			<a class="pagetopright" href="/"></a>
		</section>
		<section class="headerh"></section>
		<section class="modular43">
			<table>
				<tr>
					<th>夺宝时间</th>
					<th>时间因子</th>
					<th>会员账号</th>
				</tr>
				<?php foreach ($result as $key => $value): ?>
				<?php
					$who = Member::find()->where(['id'=>$value['uid']])->one();
				?>
				<tr>
					<td><?= date("Y-m-d",$value['created_at']); ?> <br> <?= date("H:i:s",$value['created_at']); ?></td>
					<td class="redcol"><?= $value['created_at']; ?></td>
					<td>
						<?php if(!empty($who['name'])): ?>
						<?= $who['name']; ?>
						<?php else: ?>
						<?= $who['phone']; ?>
						<?php endif ?>
					</td>
				</tr>
				<?php endforeach ?>
			</table>
		</section>
		<section class="footerh4"></section>
		<footer class="footer footer4">
			<div class="footer4con">
				<p>计算结果：</p>
				<p>1、求和： <?= $sum; ?> (上面100条时间因子取值相加之和)</p>
				<p>3、求余：<?= $sum; ?> % <?= $count;?>(奖品需要人次) = <?= $qy; ?>(余数)</p>
				<p>3、求出幸运码：<?= $qy; ?>(余数) + 10000001 = <?php $lucky = $qy+10000001; echo $lucky; ?></p>
				<p class="resault"><span></span></p>
			</div>
		</footer>
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
	    $(".footerh4").height($(".footer4").height());
		$(".bodyA").hide();
	})
</script>
</body>
</html>