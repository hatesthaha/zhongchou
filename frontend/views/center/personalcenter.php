<?php
use yii\helpers\Html;
use frontend\models\Message;
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
	<title>个人中心</title>
	<?= Html::cssFile('@web/style/css/font-awesome.min.css') ?>
	<?= Html::cssFile('@web/style/css/reset.css') ?>
	<?= Html::cssFile('@web/style/css/style.css') ?>
</head>
<body>
	<section class="bodyA"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/u0.gif" alt=""></section>
	<div id="body_h" class="bgeaeaea">
		<section class="pagetop">
			<a class="pagetopleft" href="/site/index"><i class='icon-angle-left'></i></a>
			<h2>个人中心</h2>
			<a class="pagetopright" href="/"></a>
		</section>
		<section class="headerh"></section>
		<section class="modular10">
			<div>
				<img width="100%;" src="<?= Yii::getAlias('@web') . '/' ?>style/images/myself-bg.jpg" alt="个人中心">
				<table>
					<tr>
						<td class="self-img" rowspan="3" style="height: 9.5rem;width:7.5rem;">
							<a href="/center/personaldata" style="display:block;width:6.5rem;height:6.5rem;">
							<?php if(!empty($userinfo['head'])){?>
							<img width="100%" src="<?= Yii::getAlias('@web') . '/' ?>upload/<?= $userinfo['head']; ?>" alt="头像" style="position: relative; top:0.2rem; ">
							<?php }else{?>
							<img width="100%" src="<?= Yii::getAlias('@web') . '/' ?>style/images/header-img.jpg" alt="头像" style="position: relative; top:0.2rem;">
							<?php }?>
							</a>
							<p style="width:100%;height:0.4rem;"></p>
						    <p class="bgfeb528-wf radius2" style="font-size:0.8rem;line-height:1.2rem;padding:0 0.2rem;"> 项目资格：<?=$userinfo['tmoney'] ?></p>
						</td>
						<td class="self-info">
							<a class="modular10-newh" href="/message/mynews"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/self-information.png" alt="消息"></a>
							<?php
								$pd = Message::findBySql('SELECT * FROM message where to_id = '.$userinfo['id'].' and type = 0')->all();
								//print_r($pd);
							?>
							<?php if(!empty($pd)): ?>
							<p class="modular16-conhave"></p>
							<?php endif ?>
						</td>
					</tr>
					<tr>
						<td class="self-name"><a href="/center/personaldata" class="fffc" ><?php if($userinfo['name']){echo $userinfo['name'];}else{echo '请完善用户名 ';}?>
						<i class="icon-edit" style="vertical-align: middle;"></i><span><br>
						<?php
							$level = Level::findBySql('select * from level where grade <= '.$userinfo['prestige'].' order by id desc')->one();
							$l_dis = explode(",",$level['pic']);
							//print_r($l_dis);
						?>
						<?php foreach ($l_dis as $key => $value): ?>
						<img src="<?= Yii::getAlias('@web') . '/' ?>style/images/<?= $value; ?>.png">
						<?php endforeach ?>
						</span></a></td>
						<!--此处的图片代表等级-->
					</tr>
					<tr>
						<td class="self-desc" style="height:2.4rem;"><a href="/center/personaldata" class="fffc"><?php if($userinfo['signature']){echo $userinfo['signature'];}else{echo '您还没有设置个性签名';}?></a></td>
					</tr>
				</table>
			</div>
		</section>
		<section class="pagenav modular11 borb">
			<ul class="clearfix">
				<li>
					<a href="/center/vintroduce">
						<p><?= $userinfo['prestige']; ?></p>
						<p>我的声望</p>
					</a>
				</li>
				<li>
					<a href="/friend/myfans">
						<p><?= $fans; ?></p>
						<p>我的粉丝</p>
					</a>
				</li>
				<li>
					<a href="/friend/myconcern">
						<p><?= $focus; ?></p>
						<p>我的关注</p>
					</a>
				</li>
			</ul>
		</section>
		<section class="pagenav modular12 bort borb">
			<ul class="clearfix">
				<li>
					<a href="/order/myorder/?type=dfk">
						<p><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/selft-nav1.png" alt="待付款"></p>
						<p>待付款</p>
					</a>
				</li>
				<li>
					<a href="/order/myorder/?type=dfh">
						<p><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/selft-nav2.png" alt="待发货"></p>
						<p>待发货</p>
					</a>
				</li>
				<li>
					<a href="/order/myorder/?type=dsh">
						<p><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/selft-nav3.png" alt="待收货"></p>
						<p>待收货</p>
					</a>
				</li>
				<li>
					<a href="/order/myorder?type=all">
						<p><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/selft-nav4.png" alt="全部订单"></p>
						<p>全部订单</p>
					</a>
				</li>
			</ul>
		</section>
		<section class="pagelist">
			<ul>
				<li>
					<a href="/project/mylaunch">
						<span><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/selft-list1.png" alt="我的发起">我的发起</span>
						<i class="icon-angle-right"></i>
					</a>
				</li>
				<li>
					<a href="/center/zigeshuoming">
						<span><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/selft-list8.png" alt="我的资格">资格说明</span>
						<i class="icon-angle-right"></i>
					</a>
				</li>
				<!--<li>
					<a href="/center/aboutus">
						<span><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/selft-list2.png" alt="每日签到">关于我们</span>
						<i class="icon-angle-right"></i>
					</a>
				</li>-->
				<li>
					<a href="/center/signed">
						<span><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/selft-list3.png" alt="每日签到">每日签到</span>
						<i class="icon-angle-right"></i>
					</a>
				</li>
				<li>
					<a href="/center/mycollection">
						<span><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/selft-list4.png" alt="我的收藏">我的收藏</span>
						<i class="icon-angle-right"></i>
					</a>
				</li>
				<li>
					<?php if(!empty($addpd)): ?>
					<a href="/address/receiptaddaddress2">
					<?php else: ?>
					<a href="/address/noaddress">
					<?php endif ?>
						<span><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/selft-list6.png" alt="收货地址">收货地址</span>
						<i class="icon-angle-right"></i>
					</a>
				</li>
				<li>
					<a href="/center/commonproblem">
						<span><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/selft-list5.png" alt="常见问题">常见问题</span>
						<i class="icon-angle-right"></i>
					</a>
				</li>
				<li>
					<a href="/center/commonproblem?aid=5">
						<span><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/selft-list7.png" alt="操作指南">操作指南</span>
						<i class="icon-angle-right"></i>
					</a>
				</li>
				
			</ul>
		</section>
		<div class="footerh"></div>
	</div>
	<?= $this->render('//layouts/footer_section', [
        //'model' => $model,
    ]) ?>
<?= Html::jsFile('@web/style/js/jquery-2.1.1.min.js') ?>
<?= Html::jsFile('@web/style/js/reset.js') ?>
<script>
	$(document).ready(function(){
		$(".bodyA").hide();
	})
</script>
</body>
</html>