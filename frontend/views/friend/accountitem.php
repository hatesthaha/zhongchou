<?php
use yii\helpers\Html;
use frontend\models\Friends;
use frontend\models\Product;
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
	<title>账户项目信息</title>
	<?= Html::cssFile('@web/style/css/font-awesome.min.css') ?>
	<?= Html::cssFile('@web/style/css/reset.css') ?>
	<?= Html::cssFile('@web/style/css/style.css') ?>
</head>
<body>
	<section class="bodyA"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/u0.gif" alt=""></section>
	<div id="body_h">
		<section class="pagetop">
			<a class="pagetopleft" href="javascript:history.go(-1)"><i class='icon-angle-left'></i></a>
			<h2>用户项目信息</h2>
			<a class="pagetopright" href="/"></a>
		</section>
		<section class="headerh"></section>
		<section class="modular25">
			<section class="modular27 text-c">
				<p class="modular27-con1">
				<?php if(!empty($data['head'])): ?>
					<img width="100%" height="100%" src="<?= Yii::getAlias('@web') . '/' ?>upload/<?= $data['head']; ?>" alt="用户名">
				<?php else: ?>
					<img width="100%" height="100%" src="<?= Yii::getAlias('@web') . '/' ?>style/images/header-img.jpg" alt="用户名">
				<?php endif ?>
				</p>
				<p class="modular27-con2">
				<?php if(!empty($data['name'])): ?>
				<?= $data['name']; ?>
				<?php else: ?>
				<?= $data['phone']; ?>
				<?php endif ?>
				<?php
					$level = Level::findBySql('select * from level where grade <= '.$data['prestige'].' order by id desc')->one();
					$l_dis = explode(",",$level['pic']);
					//print_r($l_dis);
				?>
				<?php foreach ($l_dis as $key => $value): ?>
				<img src="<?= Yii::getAlias('@web') . '/' ?>style/images/<?= $value; ?>.png">
				<?php endforeach ?>
				</p>
				<p class="modular27-con3">
				<?php if(!empty($data['gender'])): ?>
				<img src="<?= Yii::getAlias('@web') . '/' ?>style/images/<?php if($data['gender'] == "1"){echo "sexnan";}elseif($data['gender'] == "2"){echo "sexnv";}; ?>.png">
				<?php endif ?>
				<?= $data['signature']; ?></p>
				<?php
					$focus = Friends::find()->andWhere(['user_id' => $data['id']])->count('id');
					$fans = Friends::find()->andWhere(['friends_id' => $data['id']])->count('id');
				?>
				<p class="modular27-con4"><a>关注&nbsp;&nbsp;<?= $focus; ?>&nbsp;</a>|<a>&nbsp;粉丝&nbsp;&nbsp;<?= $fans; ?></a></p>
			</section>
			<ul class="modular28 clearfix">
				<li data-cato="mould-28list1" class="current7"><span>发起的项目</span></li>
				<li data-cato="mould-28list2"><span>收藏的项目</span></li>
			</ul>
			<section id="mould-28list1" class="modular25con hide">
				<ul>
				<?php foreach($fpro as $_k => $vo) : ?>
					<?php
						$img = explode(",",$vo['img']);
					?>
					<?php if($vo['shenhe'] != "0" && $vo['shenhe'] != "2"): ?>
					<li>
						<div class="project-con borall">
							<a href="/project/projectdetails/?id=<?= $vo['id']; ?>">
								<img width="100%" src="<?= Yii::getAlias('@web') . '/' ?>upload/<?= $img[0]; ?>" alt="公益梦">
								<div class="project-word">
									<p class="project-wordt"><?= $vo['name']; ?>
									<?php if($vo['status'] == "0"): ?>
										(尚未开始)
									<?php elseif($vo['status'] == "1"): ?>
										(已结束)
									<?php elseif($vo['status'] == "2"): ?>
										(进行中)
									<?php endif ?>
									</p>
									<p>目标金额：<?= $vo['target_money']; ?></p>
								</div>
							</a>
						</div>
					</li>
					<?php endif ?>
				<?php endforeach; ?>
				</ul>
			</section>
			<section id="mould-28list2" class="modular25con hide">
				<ul>
				<?php foreach($spro as $_k => $vo) : ?>
				<?php
					$value = Product::find()->where(['id'=>$vo['goods_id']])->one();
					$img = explode(",",$value['img']);
				?>
					<li>
						<div class="project-con borall">
							<a href="/project/projectdetails/?id=<?= $value['id']; ?>">
								<img width="100%" src="<?= Yii::getAlias('@web') . '/' ?>upload/<?= $img[0]; ?>" alt="公益梦">
								<div class="project-word">
									<p class="project-wordt"><?= $value['name']; ?></p>
									<p>目标金额：<?= $value['target_money']; ?></p>
								</div>
							</a>
						</div>
					</li>
				<?php endforeach; ?>
				</ul>
			</section>
			<div class="footerh3"></div>
			<ul class="modular29 clearfix text-c footer3">
				<li>
				<?php if($yes == "1"): ?>
				<a class="current7" id="n"><i class="icon-plus"></i>已关注</a>
				<?php else: ?>
				<a class="current7" id="add"><i class="icon-plus"></i>加关注</a>
				<?php endif ?>
				</li>
				<li><a href="/message/reply/?to=<?= $data['id']; ?>"><i class="icon-envelope-alt"></i>发私信</a></li>
			</ul>
		</section>
	</div>
	<p id="tip-error"><span>表单验证错误信息</span></p>
<?= Html::jsFile('@web/style/js/jquery-2.1.1.min.js') ?>
<?= Html::jsFile('@web/style/js/reset.js') ?>
<script>
	$(document).ready(function(){
		var UA=window.navigator.userAgent;  //使用设备
		var CLICK="click";
		if(/ipad|iphone|android/.test(UA)){   //判断使用设备
			CLICK="tap";
		}
		var catoFram=$(".modular25con");
		var subNav=$(".modular28 li");
		$("#mould-28list1").removeClass("hide");
		subNav[0].className += " current7" ;
		subNav[CLICK](function(event){
			event.preventDefault();
			var _this=$(this);
			var id=_this.data("cato"); 
			var cur=$("#"+id);
			subNav.removeClass("current7");
			_this.addClass("current7");
			catoFram.addClass("hide");
			cur.scrollTop(0);
			cur.removeClass("hide");
		});
		$(".bodyA").hide();
		$("body").on('click','#add',function(){
			var me = <?= $me; ?>;
			var other = <?= $data['id']; ?>;
			$(this).html("<i class='icon-plus'></i>已关注");
			$(this).attr("id","n");
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
		$("body").on('click','#n',function(){
			var me = <?= $me; ?>;
			var other = <?= $data['id']; ?>;
			$(this).html("<i class='icon-plus'></i>加关注");
			$(this).attr("id","add");
			$.post("/friend/del",{me:me,other:other},function(result){
				if(result == "1"){
					$('#tip-error span').html('删除好友成功');
					$('#tip-error').show();
					setTimeout(function(){$('#tip-error').fadeOut(500);},1000);
				}else{
					$('#tip-error span').html('这个小伙伴已经删除了哦');
					$('#tip-error').show();
					setTimeout(function(){$('#tip-error').fadeOut(500);},1000);
				}
			});
		});
	})
</script>
</body>
</html>