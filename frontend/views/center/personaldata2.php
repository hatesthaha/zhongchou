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
	<title>个人资料</title>
	<?= Html::cssFile('@web/style/css/font-awesome.min.css') ?>
	<?= Html::cssFile('@web/style/css/reset.css') ?>
	<?= Html::cssFile('@web/style/css/style.css') ?>
</head>
<body>
	<section class="bodyA"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/u0.gif" alt=""></section>
	<div id="body_h" class="bgeee">
		<section class="pagetop">
			<a class="pagetopleft" href="/center/personalcenter"><i class='icon-angle-left'></i></a>
			<h2>个人资料</h2>
			<a class="pagetopright formok-btn" href="/"></a>
		</section>
		<section class="headerh"></section>
		<section class="modular16">
			<form action="/" method="post">
				<div class="modular16-con">
					<div class="twoelement">
						<p class="fixedelement2">头像</p>
					    <p class="changeelement boxtext-r">
					    <?php if(!empty($userinfo['head'])){?>
					    <img class="peosonalheaimg" src="<?= Yii::getAlias('@web') . '/' ?>upload/<?= $userinfo['head']; ?>" alt="头像">
					    <?php }else{?>
					    <img class="peosonalheaimg" src="<?= Yii::getAlias('@web') . '/' ?>style/images/header-img.jpg" alt="头像">
					    <?php } ?>

					    <i class="icon-angle-right"></i><a href="/center/infohead"><input class="smallimginput"/></a></p>
					</div>
					<div class="twoelement">
						<p class="fixedelement2">昵称</p>
					    <p class="changeelement boxtext-r text-r" style="padding:0 1rem;"><a href="/center/infoname" class="wid100db"><?php if($userinfo['name']){echo $userinfo['name'];}else{echo '请完善用户名';}?></a><i class="rigd icon-angle-right"></i></p>
					</div>
					<div class="twoelement">
						<p class="fixedelement2">性别</p>
					    <p class="changeelement boxtext-r text-r" style="padding:0 1rem;"><a href="/center/infosex" class="wid100db"><?php if($userinfo['gender'] == "1"){echo "男";}elseif($userinfo['gender'] == "2"){echo "女";}else{echo "保密";}?></a><i class="rigd icon-angle-right"></i></p>
					</div>
					<div class="twoelement">
						<p class="fixedelement2">等级</p>
					    <p class="changeelement boxtext-r text-r" style="padding:0 1rem;"><a href="/center/vintroduce" class="wid100db">
					<?php
						$level = Level::findBySql('select * from level where grade <= '.$userinfo['prestige'].' order by id desc')->one();
						$l_dis = explode(",",$level['pic']);
						//print_r($l_dis);
					?>
					<?php foreach ($l_dis as $key => $value): ?>
					<img src="<?= Yii::getAlias('@web') . '/' ?>style/images/<?= $value; ?>.png" style="height:1rem;width:1rem;">
					<?php endforeach ?>
					    </a><i class="rigd icon-angle-right"></i></p>
					</div>
					<div class="twoelement">
						<p class="fixedelement2">手机</p>
					    <p class="changeelement boxtext-r text-r" style="padding:0 1rem;"><a href="/center/infophone" class="wid100db"><?php echo substr($userinfo['phone'],0,3); ?>****<?php echo substr($userinfo['phone'],7,4); ?></a><i class="rigd icon-angle-right"></i></p>
					</div>
					<div class="twoelement">
						<p class="fixedelement2">邮箱</p>
					    <p class="changeelement boxtext-r text-r" style="padding:0 1rem;"><a href="/center/infoemail" class="wid100db"><?php if($userinfo['email']){echo $userinfo['email'];}else{echo '绑定邮箱';}?></a><i class="rigd icon-angle-right"></i></p>
					</div>
				</div>
				<div class="modular16-con">
					<div class="twoelement">
						<p class="fixedelement2">个性签名</p>
					    <p class="changeelement boxtext-r text-r" style="padding:0 1rem;"><a href="/center/editinformation" class="wid100db"><?php if($userinfo['signature']){echo $userinfo['signature'];}else{echo '您还没有设置个性签名';}?></a><i class="rigd icon-angle-right"></i></p>
					</div>
<!-- 					<div class="twoelement">
						<p class="fixedelement2">修改密码</p>
					    <p class="changeelement boxtext-r text-r" style="padding:0 1rem;"><a href="/center/infopassword" class="wid100db">&nbsp;</a><i class="rigd icon-angle-right"></i></p>
					</div> -->
				</div>
<!-- 				<div class="modular6">
					<p class="form-ok"><input class="resetform bgfeb528-wf" name="formok-btn" type="button" value="安全退出" id="quit"></p>
				</div> -->
			</form>
		</section>
	</div>
	<p id="tip-error"><span>表单验证错误信息</span></p>
<?= Html::jsFile('@web/style/js/jquery-2.1.1.min.js') ?>
<?= Html::jsFile('@web/style/js/reset.js') ?>
<?= Html::jsFile('@web/style/js/area.js') ?>
<script>
	$(document).ready(function(){
	var UA=window.navigator.userAgent;  //使用设备
	var CLICK="click";
	if(/ipad|iphone|android/.test(UA)){   //判断使用设备
		CLICK="tap";
	};
	$(".bodyA").hide();
	$("#quit").click(function(){
		location.href = "/center/quit";
	})
	})
</script>
</body>
</html>