<?php
use yii\helpers\Html;
use frontend\models\Member;
use frontend\models\Level;
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
	<style>
	.modular21desc p{
		padding-left:1rem;
		padding-right:1rm;
	}
	</style>
	<title>我的粉丝</title>
	<?= Html::cssFile('@web/style/css/font-awesome.min.css') ?>
	<?= Html::cssFile('@web/style/css/reset.css') ?>
	<?= Html::cssFile('@web/style/css/style.css') ?>
</head>
<body>
	<section class="bodyA"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/u0.gif" alt=""></section>
	<div id="body_h" class="bgeee">
		<section class="pagetop">
			<a class="pagetopleft" href="/center/personalcenter"><i class='icon-angle-left'></i></a>
			<h2>我的粉丝</h2>
			<a class="pagetopright" href="/"></a>
		</section>
		<section class="headerh"></section>
		<section class="modular21 modular22">
			<ul>
	
			<?php
			if(!empty($myf)){
			foreach($myf as $_k => $vo) : ?>
			
				<?php
					$friend = Member::find()->where(['id' => $vo['user_id']])->one();
				?>
				<li>
					<a href="/friend/accountitem/?id=<?= $friend['id']; ?>">
						<p class="self-img self-img2">
						<?php if(!empty($friend['head'])): ?>
						<img src="<?= Yii::getAlias('@web') . '/' ?>upload/<?= $friend['head']; ?>" alt="">
						<?php else: ?>
						<img src="<?= Yii::getAlias('@web') . '/' ?>style/images/header-img.jpg" alt="">
						<?php endif ?>
						</p>
						<div class="modular21desc">
							<div>
								<p class="self-name self-name1h"><span class="self-nameword">
								<?php if(!empty($friend['name'])): ?>
								<?= $friend['name']; ?>
								<?php else: ?>
								<?= $friend['phone']; ?>
								<?php endif ?>
								</span><span><br>
								<?php
									$level = Level::findBySql('select * from level where grade <= '.$friend['prestige'].' order by id desc')->one();
									$l_dis = explode(",",$level['pic']);
									//print_r($l_dis);
								?>
								<?php foreach ($l_dis as $key => $value): ?>
								<img src="<?= Yii::getAlias('@web') . '/' ?>style/images/<?= $value; ?>.png">
								<?php endforeach ?>
								</span></p>
								<p class="self-desc self-desc1h"><?= $friend['signature']; ?></p>
							</div>
						</div>
					</a>
				</li>
			<?php endforeach; ?>
			</ul>
			<?php }else{?>
			<div class="modular21desc"><p ><br><br><br>您还没有粉丝呢，去发起一个自己的众筹项目或者到社区去转转来吸引更多的粉丝吧。</p><br><br><br>
			</div><br><br><br><br>
			<p class="nextlinkpage">
						<a class="bgfeb528-wf" href="<?php if(in_array($gonggao[0]['term_id'], [2, 3, 4, 5, 6])){echo '/project/projectdetails/?id='.$gonggao[0]['id'];}else{echo '/yyzc/projectdetailsyy/?id='.$gonggao[0]['id']; }?>">去看看最新众筹项目吧</a>
					</p>
			<?php } ?>
		</section>
		<div class="footerh"></div>
	</div>
	<section>
		<ul class="footer clearfix">
			<li>
				<a href="/site/index">
					<img src="<?= Yii::getAlias('@web') . '/' ?>style/images/footer1.png" alt="首页"><p>首页</p>
				</a>
			</li>
			<!--<li>
				<a href="/search/searchitem">
					<img src="<?= Yii::getAlias('@web') . '/' ?>style/images/footer2.png" alt="全部"><p>全部</p>
				</a>
			</li>-->
			<li>
				<a href="/project/mylaunch">
					<img src="<?= Yii::getAlias('@web') . '/' ?>style/images/footer2.png" alt="全部"><p>发起</p>
				</a>
			</li>
			<li>
				<a href="">
					<img src="<?= Yii::getAlias('@web') . '/' ?>style/images/footer3.png" alt="社区"><p>社区</p>
				</a>
			</li>
			<li>
				<a href="/center/personalcenter">
					<img src="<?= Yii::getAlias('@web') . '/' ?>style/images/footer4.png" alt="个人中心"><p>个人中心</p>
				</a>
			</li>		
		</ul>
	</section>
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