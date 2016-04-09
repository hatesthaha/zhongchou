<?php
use yii\helpers\Html;
use yii\helpers\Url;
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
	<meta content="我的发起" name="Keywords">
	<meta name="description" content="仌仌众梦" />	
	<title>我的发起</title>
	<?= Html::cssFile('@web/style/css/font-awesome.min.css') ?>
	<?= Html::cssFile('@web/style/css/reset.css') ?>
	<?= Html::cssFile('@web/style/css/style.css') ?>
	<?= Html::jsFile('@web/style/js/jquery-2.1.1.min.js') ?>
	<?= Html::jsFile('@web/style/js/reset.js') ?>
</head>
<body>
	<section class="bodyA"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/u0.gif" alt=""></section>
	<div id="body_h">
		<section class="pagetop">
			<a class="pagetopleft" href="javascript:history.go(-1);"><i class='icon-angle-left'></i></a>
			<h2>我的发起</h2>
			<a class="pagetopright"><i class="icon-plus">发起项目</i></a>
		</section>
		<section class="headerh"></section>
		<?php if (empty($uinfo['tmoney']) || $uinfo['tmoney'] < 100) {?>
		<section style="background: #eee; padding: 0 0 0.5rem;">
		    <p style="padding: 0.8rem 1.2rem; border-bottom: 1px solid #dcdcdc; border-top: 1px solid #dcdcdc;background: #fff;">您的项目发起权限小于<span class="redco" style="font-size:1.4rem">100</span>元，暂不能发起众筹，请先去支持他人来提升权限吧</p>
		</section>
		<?php } else {?>
		<section style="background: #eee; padding: 0 0 0.5rem;">
		    <p style="padding: 0.8rem 1.2rem; border-bottom: 1px solid #dcdcdc; border-top: 1px solid #dcdcdc;background: #fff;">您的项目发起最大金额为：<span class="redco" style="font-size:1.4rem"><?= $uinfo['tmoney']; ?></span>元</p>
		</section>
		<?php }?>
		<section clas
		<section class="modular25con">
			<ul><?php if(empty($product)) echo "<div style='color:#CBC9C2;'>您尚未发起任何项目！</div>";?>
				<!--<li>
					<div class="project-con borall">
						<a href="">
							<img width="100%" src="<?= Yii::getAlias('@web') . '/' ?>style/images/nopicture.jpg" alt="公益梦">
							<div class="project2-word">
								<p>目标金额：100000/进行中</p>
							</div>
							<p class="modular54"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/lunch1.png" alt="已通过" ></p>
						</a>
					</div>
				</li>
				<li>
					<div class="project-con borall">
						<a href="">
							<img width="100%" src="<?= Yii::getAlias('@web') . '/' ?>style/images/nopicture.jpg" alt="公益梦">
							<div class="project2-word">
								<p>目标金额：100000/进行中</p>
							</div>
							<p class="modular54"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/lunch2.png" alt="未通过" ></p>
						</a>
					</div>
				</li>
				<li>
					<div class="project-con borall">
						<a href="">
							<img width="100%" src="<?= Yii::getAlias('@web') . '/' ?>style/images/nopicture.jpg" alt="公益梦">
							<div class="project2-word">
								<p>目标金额：100000/进行中</p>
							</div>
							<p class="modular54"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/lunch3.png" alt="待审核" ></p>
						</a>
					</div>
				</li>-->
			<?php foreach($product as $key => $val) : ?>
			<?php
				$aorb = Term::find()->where(['id'=>$val['term_id']])->one();
			?>
				<li>
					<div class="project-con borall">
						<?php if($aorb['parent_id'] == "1"): ?>
						<a href="<?= yii\helpers\Url::to(['project/projectdetails']);?>/?id=<?= $val['id']; ?>">
						<?php else: ?>
						<a href="<?= yii\helpers\Url::to(['yyzc/projectdetailsyy']);?>/?id=<?= $val['id']; ?>">
						<?php endif ?>
							<img width="100%" class='img3' src="<?= Yii::getAlias('@web') . '/' ?><?php if(isset($val['img'])&&$val['img']!=""){ $img = explode(',', $val['img']); echo 'upload/'.$img[0]; }else{echo "style/images/daishenhe.jpg";} ?>"/>
				
							<div class="project2-word">
								<p class="project-wordt"><?= $val['term']?>: <?= mb_substr(strip_tags(html_entity_decode($val['name'])),0,10,'utf-8')?>&nbsp;&nbsp;<?php if($val['shenhe'] ==1 && $val['status']==0){ echo  "预计上线时间：".$val['waittime']."天后"; }?>
								<br>目标金额：<?= $val['target_money']; ?>
								<?php if($val['shenhe'] == 1): ?>
									<?php if($val['status'] == 0): ?>
										尚未开始
								&nbsp;&nbsp;队列顺序：<?= $val['paixu']?> 
									<?php elseif($val['status'] == 1): ?>
										已结束
									<?php elseif($val['status'] == 2): ?>
										进行中
									<?php endif ?>
								<?php endif ?>
								</p>
							</div>
							<?php if($val['shenhe'] == 0):?>
							<p class="modular54"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/lunch3.png" alt="待审核" ></p>
							<?php elseif ($val['shenhe'] == 2):?>
							<p class="modular54"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/lunch2.png" alt="未通过" ></p>
							<?php elseif ($val['shenhe'] == 1):?>
							<p class="modular54"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/lunch1.png" alt="已通过" ></p>
							<?php endif;?>
						</a>
					</div>
				</li>
			<?php endforeach;?>
			<br><br><br>
			</ul>
		</section>
		<?= $this->render('//layouts/footer_section', [
        //'model' => $model,
    ]) ?>
	</div>
	<p id="tip-error"><span>表单验证错误信息</span></p>
<script>
	$(document).ready(function(){
		$(".bodyA").hide();
		$(".pagetopright").click(function(){
			var id = <?= $uinfo['id']; ?>;
			$.post("/project/check",{id:id},function(result){
				if(result == "1"){
					location.href = "/project/wanttolaunch";
				}else if(result == "2"){
					$('#tip-error span').html('你还有项目未完成');
					$('#tip-error').show();
					setTimeout(function(){
						$('#tip-error').fadeOut(500);
					},1000);
					setTimeout(function(){
						location.href = "/center/commonproblem";
					},1000);
				}else if(result == 3){
					$('#tip-error span').html('您尚未达到发起项目权限');
					$('#tip-error').show();
					setTimeout(function(){
						$('#tip-error').fadeOut(500);
					},1000);
					setTimeout(function(){
						location.href = "/center/commonproblem";
					},1000);
				}else if(result == "0"){
					$('#tip-error span').html('你不能发起项目');
					$('#tip-error').show();
					setTimeout(function(){
						$('#tip-error').fadeOut(500);
					},1000);
					setTimeout(function(){
						location.href = "/center/commonproblem";
					},1000);
				}
			});
		});
	})
</script>
</body>
</html>