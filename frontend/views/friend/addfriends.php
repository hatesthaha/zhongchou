<?php
use yii\helpers\Html;
use frontend\models\Friends;
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
	<title>添加好友</title>
	<?= Html::cssFile('@web/style/css/font-awesome.min.css') ?>
	<?= Html::cssFile('@web/style/css/reset.css') ?>
	<?= Html::cssFile('@web/style/css/style.css') ?>
</head>
<body>
	<section class="bodyA"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/u0.gif" alt=""></section>
	<div id="body_h" class="bgeee">
		<section class="pagetop">
			<a class="pagetopleft" href="/friend/myconcern"><i class='icon-angle-left'></i></a>
			<h2>添加好友</h2>
			<a class="pagetopright" href="/"></a>
		</section>
		<section class="headerh"></section>
		<section class="modular20">
			<input type="text" name="searchpeople" placeholder="手机号/账号" value="<?php if(!empty($_GET['kw'])){echo $_GET['kw'];}?>">
			<a href="/friend/addfriends" id="reset"><i class="icon-remove"></i></a>
			<a><i class="icon-search"></i></a>
		</section>
		<?php if(!empty($NO)): ?>
		<section class="headerh" style="text-align:center;"><span>暂无搜索结果，试着添加以下用户为好友吧</span></section>
		<?php endif ?>
		<section class="modular21">
		    <h2 class="modular21-tit">好友推荐</h2>
			<ul>
			<?php foreach($friendx as $_k => $vo) : ?>
			<?php
				$isfrd = Friends::find()->where(['user_id'=>$userinfo['id'],'friends_id'=>$vo['id']])->one();
			?>
				<li>
					<a href="/friend/accountitem/?id=<?= $vo['id']; ?>">
						<p class="self-img self-img2">
						<?php if(empty($vo['head'])): ?>
						<img src="<?= Yii::getAlias('@web') . '/' ?>style/images/header-img.jpg" alt="">
						<?php else: ?>
						<img src="<?= Yii::getAlias('@web') . '/' ?>upload/<?= $vo['head']; ?>" alt="">
						<?php endif ?>
						</p>
						<div class="modular21desc">
							<div>
								<p class="self-name self-name1h"><span class="self-nameword">
								<?php if(empty($vo['name'])):?>
								<?= $vo['phone']; ?>
								<?php else: ?>
								<?= $vo['name']; ?>
								<?endif ?>
								</span><span>
								<?php
									$level = Level::findBySql('select * from level where grade <= '.$vo['prestige'].' order by id desc')->one();
									$l_dis = explode(",",$level['pic']);
									//print_r($l_dis);
								?>
								<?php foreach ($l_dis as $key => $value): ?>
								<img src="<?= Yii::getAlias('@web') . '/' ?>style/images/<?= $value; ?>.png">
								<?php endforeach ?>
								</span></p>
								<p class="self-desc self-desc1h"><?= $vo['signature']; ?></p>
							</div>
						</div>
						<p class="<?php if(!empty($isfrd)){echo "modular21add";}else{echo "modular21no";}?> modular21btn"><span style="display:none;"><?= $vo['id']; ?></span></p>
					</a>
				</li>
			<?php endforeach; ?>
			</ul>
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
		$("body").on('click','.modular21 li .modular21no',function(event){
			event.preventDefault();
			var THICON = $(this);
			THICON.removeClass("modular21no");
			THICON.addClass("modular21add");
			var me = <?= $userinfo['id']; ?>;
			var other = $(this).find('span').html();
			$.post("/friend/add",{me:me,other:other},function(result){
				if(result == "1"){
					$('#tip-error span').html('添加好友成功');
					$('#tip-error').show();
					setTimeout(function(){$('#tip-error').fadeOut(500);},1000);
				}else{
					$('#tip-error span').html('这个小伙伴已经是你的好友了哦');
					$('#tip-error').show();
					setTimeout(function(){$('#tip-error').fadeOut(500);},1000);
				}
			});
		});
		$(".bodyA").hide();
		$("#reset").hide();
		if($("input[name='searchpeople']").val()){
			$("#reset").show();
		}
		$(".icon-search")[CLICK](function(event){
			event.preventDefault();
			var searchpeople=$("input[name='searchpeople']").val();
			if(!searchpeople){
				return false;
			}else{
				location.href = "/friend/addfriends/?kw="+searchpeople;
			}
		});
	})
</script>
</body>
</html>