<?php
use yii\helpers\Html;
use frontend\models\Member;
use frontend\models\Message;
use frontend\models\Term;
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
	<title>消息</title>
	<?= Html::cssFile('@web/style/css/font-awesome.min.css') ?>
	<?= Html::cssFile('@web/style/css/reset.css') ?>
	<?= Html::cssFile('@web/style/css/style.css') ?>
</head>
<body>
	<section class="bodyA"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/u0.gif" alt=""></section>
	<div id="body_h">
		<section class="pagetop">
			<a class="pagetopleft" href="/center/personalcenter"><i class='icon-angle-left'></i></a>
			<h2>消息</h2>
			<a class="pagetopright" href="/"></a>
		</section>
		<section class="headerh"></section>
		<section class="modular16">
			<section class="modular16-tit pagenav modular11 borb">
				<ul class="clearfix">
					<li data-cato="mould-16list1" class="current2">
						<a href=""><span>通知</span></a>
					</li>
					<li data-cato="mould-16list2">
						<a href=""><span>私信</span></a>
					</li>
					<li data-cato="mould-16list3">
						<a href=""><span>我的</span></a>
					</li>
				</ul>
			</section>
			<section id="mould-16list1" class="modular16-con hide">
				<ul>
				<?php foreach($product as $_k => $vo) : ?>
				<?php
					$aorb = Term::find()->where(['id'=>$vo['term_id']])->one();
				?>
					<li>
						<?php if($aorb['parent_id'] == "1"): ?>
						<a href="/project/projectdetails/?id=<?= $vo['id']; ?>">
						<?php else: ?>
						<a href="/yyzc/projectdetailsyy/?id=<?= $vo['id']; ?>">
						<?php endif ?>
							<div class="modular16-conicon">
								<p class="modular16-conimg"><img width="50%" src="<?= Yii::getAlias('@web') . '/' ?>style/images/self-information.png" alt="活动通知"></p>
								<?php $stra = strval($userinfo['seen']); $strb = strval($vo['id']); if(!strpos($stra,$strb)): ?>
								<p class="modular16-conhave"></p>
								<?php endif ?>
							</div>
							<div class="modular16-conword">
								<div>
									<p class="modular16-cont text-r clearfix"><span class="float-left"><?= $vo['name']; ?></span><span class="modular16-cond"><?php echo date("m-d H:i",$vo['created_at']);?></span></p>
									<p class="modular16-cond"><?= $vo['content']; ?></p>
								</div>
							</div>
						</a>
					</li>
				<?php endforeach;?>
				</ul>
			</section>
			<section id="mould-16list2" class="modular16-con hide">
				<ul>
				<?php foreach($message as $_k => $vo) : ?>
					<?php
						$who = Member::find()->where(['id' => $vo['from_id']])->one();
						$pd = Message::findBySql('SELECT * FROM message where from_id = '.$who['id'].' and to_id = '.$vo['to_id'].' order by id DESC')->one();
					?>
					<li>
						<a href="/message/privateletter/?from=<?= $who['id']; ?>&me=<?= $vo['to_id']; ?>">
							<div class="modular16-conicon">
								<p class="modular16-conimg"><img width="50%" src="<?= Yii::getAlias('@web') . '/' ?>style/images/self-information.png" alt="活动通知"></p>
								<?php if($pd['type'] != "1"): ?>
								<p class="modular16-conhave"></p>
								<?php endif ?>
							</div>
							<div class="modular16-conword">
								<div>
									<p class="modular16-cont text-r clearfix"><span class="float-left">
									<?php if($who['name'] == ""): ?>
									<?= $who['phone']; ?>
									<?php else: ?>
									<?= $who['name']; ?>
									<?php endif ?>
									发来的私信</span><span class="modular16-cond"><?php echo date("m-d H:i",$pd['created_at']);?></span></p>
									<p class="modular16-cond"><?= $vo['message'] ?></p>
								</div>
							</div>
						</a>
					</li>
				<?php endforeach;?>
				</ul>
			</section>
			<section id="mould-16list3" class="modular16-con hide">
				<ul>
				<?php if(!empty($mypro)): ?>
				<?php foreach($mypro as $_k => $vo) : ?>
					<li>
						<a href="/project/projectdetails/?id=<?= $vo['id']; ?>">
							<div class="modular16-conicon">
								<p class="modular16-conimg"><img width="50%" src="<?= Yii::getAlias('@web') . '/' ?>style/images/self-information.png" alt="我的通知"></p>
								<?php $stra = strval($userinfo['seen']); $strb = strval($vo['id']); if(!strpos($stra,$strb)): ?>
								<p class="modular16-conhave"></p>
								<?php endif ?>
							</div>
							<div class="modular16-conword">
								<div>
									<p class="modular16-cont text-r clearfix"><span class="float-left"><?= $vo['name']; ?></span><span class="modular16-cond"><?php echo date("m-d H:i",$vo['created_at']);?></span></p>
									<p class="modular16-cond"><?= $vo['content']; ?></p>
								</div>
							</div>
						</a>
					</li>
				<?php endforeach;?>
				<?php endif ?>
				</ul>
			</section>
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
		}
		var catoFram=$(".modular16-con");
		var subNav=$(".modular16-tit li");
		$("#mould-16list1").removeClass("hide");
		subNav[0].className += " current2" ;
		subNav[CLICK](function(event){
			event.preventDefault();
			var _this=$(this);
			var id=_this.data("cato"); 
			var cur=$("#"+id);
			subNav.removeClass("current2");
			_this.addClass("current2");
			catoFram.addClass("hide");
			cur.scrollTop(0);
			cur.removeClass("hide");
		});
		
		
		$(".bodyA").hide();
	})
</script>
</body>
</html>