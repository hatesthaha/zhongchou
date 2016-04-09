<?php
use yii\helpers\Html;
use frontend\models\Member;
use frontend\models\Term;
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
	<title>我的收藏</title>
	<?= Html::cssFile('@web/style/css/font-awesome.min.css') ?>
	<?= Html::cssFile('@web/style/css/reset.css') ?>
	<?= Html::cssFile('@web/style/css/style.css') ?>
</head>
<body>
<style>
	.bgeaeaea{
		background: #fff;
	}
</style>
	<section class="bodyA"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/u0.gif" alt=""></section>
	<div id="body_h" class="bgeaeaea">
		<section class="pagetop">
			<a class="pagetopleft" href="/center/personalcenter"><i class='icon-angle-left'></i></a>
			<h2>我的收藏</h2>
			<a class="pagetopright" href=""></a>
		</section>
		<section class="headerh"></section>
		<section class="modular25con">
			<?php if(!empty($collect)):?>
			<ul>
				<?php foreach($collect as $_k => $vo) : ?>
					<?php
						$p_id = $vo['user_id'];
						$userinfo = Member::find()->where(['id' => $p_id])->one();
						$img = explode(",",$vo['img']);
						$aorb = Term::find()->where(['id'=>$vo['term_id']])->one();
					?>
				<li>
					<div class="project-con boralle radius5">
						<?php if($aorb['parent_id'] == "1"): ?>
						<a href="/project/projectdetails/?id=<?= $vo['id']; ?>">
						<?php else: ?>
						<a href="/yyzc/projectdetailsyy/?id=<?= $vo['id']; ?>">
						<?php endif ?>
							<div class="positionrq">
								<img width="100%" src="<?= Yii::getAlias('@web') . '/' ?>upload/<?= $img[0]; ?>" alt="公益梦">
								<div class="project2-word">
									<p>目标金额：<?= $vo['target_money']; ?>/进行中</p>
								</div>
							</div>
							<div class="project4-word">
								<h2><?= $vo['name']; ?></h2>
								<?php if($vo['term_id'] == 2 || $vo['term_id'] == 3 || $vo['term_id'] == 4 || $vo['term_id'] == 5 || $vo['term_id'] == 6): ?>
								<p><img class="project4-head" src="<?= Yii::getAlias('@web') . '/' ?>style/images/header-img.jpg" alt="头像">
									<?php if(!empty($userinfo['name'])): ?>
									<?= $userinfo['name']; ?>
									<?php else: ?>
									<?= $userinfo['phone']; ?>
									<?php endif ?>
									<?php
										$level = Level::findBySql('select * from level where grade <= '.$userinfo['prestige'].' order by id desc')->one();
										$l_dis = explode(",",$level['pic']);
										//print_r($l_dis);
									?>
									<?php foreach ($l_dis as $key => $value): ?>
									<img src="<?= Yii::getAlias('@web') . '/' ?>style/images/<?= $value; ?>.png">
									<?php endforeach ?>
								</p>
								<?php endif ?>
							</div>
						</a>
					</div>
				</li>
				<?php endforeach;?>
			</ul>
			<?php else: ?>
				<br><br><br>
				<p class="text-c"><img width="38%;" src="<?= Yii::getAlias('@web') . '/' ?>style/images/no-address.jpg" alt="没有填写收货地址"></p><br>
				<p class="font14 text-c redcc">您还没有收藏项目</p>
				<p class="font14 text-c redcc">快去收藏吧</p>
			<?php endif ?>
		</section>
	</div>
<?= Html::jsFile('@web/style/js/jquery-2.1.1.min.js') ?>
<?= Html::jsFile('@web/style/js/reset.js') ?>
<script>
	$(document).ready(function(){
		$(".bodyA").hide();
	})
</script>
</body>
</html>