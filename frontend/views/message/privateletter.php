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
	<meta name="description" content="仌仌众梦" />	
	<title><?php if($ta['name'] == ""): ?><?= $ta['phone']; ?><?php else: ?><?= $ta['name']; ?><?php endif ?></title>
	<?= Html::cssFile('@web/style/css/font-awesome.min.css') ?>
	<?= Html::cssFile('@web/style/css/reset.css') ?>
	<?= Html::cssFile('@web/style/css/style.css') ?>
</head>
<body>
	<section class="bodyA"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/u0.gif" alt=""></section>
	<div id="body_h" class="bgeee">
		<section class="pagetop">
			<a class="pagetopleft" href="/message/mynews"><i class='icon-angle-left'></i></a>
			<h2><?php if($ta['name'] == ""): ?><?= $ta['phone']; ?><?php else: ?><?= $ta['name']; ?><?php endif ?></h2>
			<a class="pagetopright" href="/message/reply/?to=<?php echo $_GET['from']; ?>">回复</a>
		</section>
		<section class="headerh"></section>
		<section class="modular38">
		<?php foreach($message as $_k => $vo) : ?>
		<?php if($vo['from_id'] == $userinfo['id']): ?>
			<div class="ng-scope ng-scogeone">
				<!-- start ngIf: message.MMTime -->
				<p class="message_system"><span class="content ng-binding"><?php echo date("Y-m-d H:i:s", $vo['created_at']);?></span></p>
				<!-- end ngIf: message.MMTime -->
				<div class="ngcon-scope">
					<div>
						<div class="clearfix">
							<div class="ngcon-scopeword"><p><?= $vo['message']; ?></p></div>
						</div>
					</div>
					<p class="letterimg">
					<?php if($userinfo['head'] == ""): ?>
					<img width="100%" height="100%" src="<?= Yii::getAlias('@web') . '/' ?>style/images/header-img.jpg" alt="对方头像">
					<?php else: ?>
					<img width="100%" height="100%" src="<?= Yii::getAlias('@web') . '/' ?>upload/<?= $userinfo['head']; ?>" alt="对方头像">
					<?php endif ?>
					</p>
				</div>
			</div>
		<?php else: ?>
			<div class="ng-scope ng-scogetwo">
				<!-- start ngIf: message.MMTime -->
				<p class="message_system"><span class="content ng-binding"><?php echo date("Y-m-d H:i:s", $vo['created_at']);?></span></p>
				<!-- end ngIf: message.MMTime -->
				<div class="ngcon-scope">
					<p class="letterimg">
					<?php if($ta['head'] == ""): ?>
					<img width="100%" height="100%" src="<?= Yii::getAlias('@web') . '/' ?>style/images/header-img.jpg" alt="对方头像">
					<?php else: ?>
					<img width="100%" height="100%" src="<?= Yii::getAlias('@web') . '/' ?>upload/<?= $ta['head']; ?>" alt="对方头像">
					<?php endif ?>
					</p>
					<div>
						<div class="clearfix">
							<div class="ngcon-scopeword"><p><?= $vo['message']; ?></p></div>
						</div>
					</div>
				</div>
			</div>
		<?php endif ?>
		<?php endforeach;?>
		</section>
	</div>
<?= Html::jsFile('@web/style/js/jquery-2.1.1.min.js') ?>
<?= Html::jsFile('@web/style/js/reset.js') ?>
<script>
	$(document).ready(function(){
		$(".bodyA").hide();
		var a = $(window).height();
		$("body,html").animate({
            scrollTop: a
        }, 100)
	})
</script>
</body>
</html>