<?php
use yii\helpers\Html;
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
	<title>我的等级</title>
	<?= Html::cssFile('@web/style/css/font-awesome.min.css') ?>
	<?= Html::cssFile('@web/style/css/reset.css') ?>
	<?= Html::cssFile('@web/style/css/style.css') ?>
</head>
<body>
	<section class="bodyA"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/u0.gif" alt=""></section>
	<div id="body_h" class="bgeee">
		<section class="pagetop">
			<a class="pagetopleft" href="/center/personalcenter"><i class='icon-angle-left'></i></a>
			<h2>我的等级</h2>
			<a class="pagetopright" href="/"></a>
		</section>
		<section class="headerh"></section>
		<section class="modular37 text-c">
			<span class="modular371">
				当前等级为：
				<?php
					$level = Level::findBySql('select * from level where grade <= '.$userinfo['prestige'].' order by id desc')->one();
					$l_dis = explode(",",$level['pic']);
					//print_r($l_dis);
				?>
				<?php foreach ($l_dis as $key => $value): ?>
				<img src="<?= Yii::getAlias('@web') . '/' ?>style/images/<?= $value; ?>.png" style="width:1rem;height:1rem;">
				
				<?php endforeach ?>
<?= ($level['id']-1)."级"; ?>
			</span>
			<?php
				$n_id = $level['id'] + 1;
				$next = Level::find()->where(['id'=>$n_id]) ->one();
				$n_l_need = $next['grade'] - $userinfo['prestige'];
			?>
			<?php if($userinfo['prestige'] >= 50000 ):?>
			<p class="modular372">您已经站在人生巅峰啦</p>
			<?php else: ?>
			<p class="modular372">距离升级还需要<span class="yellowco" style="font-size:1.6rem;">&nbsp;<?= $n_l_need; ?>&nbsp;</span>声望</p>
			<?php endif ?>
		</section>
		<section class="modular8 bgfff modular36">
			<h2>等级说明</h2>
			<p><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/d.png">声望值为0的用户</p>
			<p><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/c1.png">声望值大于0且小于等于1的用户</p>
			<p><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/c1.png"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/c2.png">声望值大于1且小于等于100的用户</p>
			<p>......</p>
			<p><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/a.png"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/c1.png">声望值大于400且小于等于900的用户</p>
			<p>......</p>
			<p><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/a.png"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/a.png"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/c1.png">声望值大于2900且小于等于3900的用户</p>
			<p>......</p>
			<p><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/a.png"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/a.png"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/a.png"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/c1.png">声望值大于7900且小于等于12900的用户</p>
			<p>......</p>
			<p><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/a.png"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/a.png"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/a.png"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/a.png">声望值大于等于50000的用户</p>
		</section>
		<section class="modular8 bgfff modular36">
			<h2>声望说明</h2>
			<p>1.签到可以获取声望</p>
			<p>2.支持某个项目N元，获得声望值为N*10，每天上限为1000</p>
		</section>
		<section class="modular8 bgfff modular36">
			<h2>等级特权</h2>
			<p>1.等级越高，发起的项目排序越靠前</p>
		</section><br><br>
			<p class="nextlinkpage">
						<a class="bgfeb528-wf" href="/center/personalcenter">朕明白了！</a>
					</p>
					<br><br>
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