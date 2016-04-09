<?php
use yii\helpers\Html;
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
	<title>一元夺宝</title>
	<?= Html::cssFile('@web/style/css/font-awesome.min.css') ?>
	<?= Html::cssFile('@web/style/css/reset.css') ?>
	<?= Html::cssFile('@web/style/css/style.css') ?>
</head>
<body>
	<section class="bodyA"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/u0.gif" alt=""></section>
	<div id="body_h">
		<section class="pagetop">
			<a class="pagetopleft" href="/site/index"><i class='icon-angle-left'></i></a>
			<h2>一元夺宝</h2>
			<!--<a class="pagetopright" href="search.html"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/searchitop.png" alt="搜索"></a>-->
		</section>
		<section class="headerh"></section>
		<section class="modular31">
			<section class="modular31-tit modular33tit">
				<ul class="clearfix">
					<?php if(!empty($_GET['cond']) && $_GET['cond'] == "1"): ?>
					<li class="current7">
					<?php else: ?>
					<li>
					<?php endif ?>
						<?php if(!empty($_GET['cate'])): ?>
						<p><a href="/yyzc/itemlist/?cate=<?php echo $_GET['cate']; ?>&cond=1"><span>最新</span></a></p>
						<?php else: ?>
						<p><a href="/yyzc/itemlist/?cond=1"><span>最新</span></a></p>
						<?php endif ?>
					</li>
					<?php if(!empty($_GET['cond']) && $_GET['cond'] == "2"): ?>
					<li class="current7">
					<?php else: ?>
					<li>
					<?php endif ?>
						<?php if(!empty($_GET['cate'])): ?>
						<p><a href="/yyzc/itemlist/?cate=<?php echo $_GET['cate']; ?>&cond=2"><span>最快</span></a></p>
						<?php else: ?>
						<p><a href="/yyzc/itemlist/?cond=2"><span>最快</span></a></p>
						<?php endif ?>
					</li>
					<?php if(!empty($_GET['cond']) && $_GET['cond'] == "3"): ?>
					<li class="current7">
					<?php else: ?>
					<li>
					<?php endif ?>
						<?php if(!empty($_GET['cate'])): ?>
						<p><a href="/yyzc/itemlist/?cate=<?php echo $_GET['cate']; ?>&cond=3"><span>最热</span></a></p>
						<?php else: ?>
						<p><a href="/yyzc/itemlist/?cond=3"><span>最热</span></a></p>
						<?php endif ?>
					</li>
					<?php if(!empty($_GET['cond']) && $_GET['cond'] == "4" || !empty($_GET['cond']) && $_GET['cond'] == "5"): ?>
					<li class="current7">
					<?php else: ?>
					<li>
					<?php endif ?>
						<p><a id="price"><span>价格</span>
							<?php if(!empty($_GET['cond']) && $_GET['cond'] == "5"): ?>
							<i class="icon-caret-down"></i>
							<?php elseif(!empty($_GET['cond']) && $_GET['cond'] == "4" || !empty($_GET['cond']) || empty($_GET['cond'])): ?>
							<i class="icon-caret-up"></i>
							<?php endif ?>
						</a></p>
					</li>




					<?php //if(!empty($_GET['cond']) && $_GET['cond'] == "6" || !empty($_GET['cond']) && $_GET['cond'] == "7"): ?>
<!-- 					<li class="current7"> -->
					<?php //else: ?>
<!-- 					<li> -->
					<?php //endif ?>
<!-- 						<p><a id="half"><span>折扣</span> -->
							<?php //if(!empty($_GET['cond']) && $_GET['cond'] == "7"): ?>
<!-- 							<i class="icon-caret-down"></i> -->
							<?php //elseif(!empty($_GET['cond']) && $_GET['cond'] == "6" || !empty($_GET['cond']) || empty($_GET['cond'])): ?>
<!-- 							<i class="icon-caret-up"></i> -->
							<?php //endif ?>
<!-- 						</a></p>
					</li> -->




				</ul>
			</section>
			<section class="modular32con">
				<div class="modular32-left modular33tit">
					<ul>
						<?php if(!empty($_GET['cate']) && $_GET['cate'] == "all" || empty($_GET['cate'])): ?>
						<li class="current7">
						<?php else: ?>
						<li>
						<?php endif ?>
							<?php if(!empty($_GET['cond'])): ?>
							<a href="/yyzc/itemlist/?cate=all&cond=<?php echo $_GET['cond']; ?>">全部商品</a>
							<?php else: ?>
							<a href="/yyzc/itemlist/?cate=all">全部商品</a>
							<?php endif ?>
						</li>
						<?php foreach($term as $_k => $vo) : ?>
						<?php if(!empty($_GET['cate']) && $_GET['cate'] == $vo['id']): ?>
						<li class="current7">
						<?php else: ?>
						<li>
						<?php endif ?>
							<?php if(!empty($_GET['cond'])): ?>
							<a href="/yyzc/itemlist/?cate=<?= $vo['id']; ?>&cond=<?php echo $_GET['cond']; ?>"><?= $vo['name']; ?></a>
							<?php else: ?>
							<a href="/yyzc/itemlist/?cate=<?= $vo['id']; ?>"><?= $vo['name']; ?></a>
							<?php endif ?>
						</li>
						<?php endforeach; ?>
					</ul>
				</div>
				<p class="modular32-middent"></p>
				<div class="modular32-right">
					<div>
						<ul class="modular32-rightcon clearfix">
							<?php foreach($product as $_k => $vo): ?>
							<?php
								$img = explode(",",$vo['img']);
								$per = $vo['total_money']/$vo['target_money']*100;
							?>
							<li>
								<div>
									<a href="/yyzc/projectdetailsyy/?id=<?= $vo['id']; ?>">
										<div>
											<p class="modular32wcon1"><img width="100%" src="<?= Yii::getAlias('@web') . '/' ?>upload/<?= $img[0]; ?>" alt="<?= $vo['name']; ?>"></p>
											<p><?= $vo['name']; ?></p>
										</div>
									</a>
									<div class="modular32wcon1div">
										<div>
											<div>
												<p>总需：<span><?= $vo['target_money']; ?></span>元</p>
												<p class="modular32line"><span><?= $per; ?></span></p>
												<?php if($per > "100"): ?>
												<p>超额完成</p>
												<?php elseif($per == "100"): ?>
												<p>已完成</p>
												<?php else: ?>
												<p>剩余：<span><?= $vo['target_money']-$vo['total_money']; ?></span>元</p>
												<?php endif ?>
											</div>
										</div>
										<a href="/order/orderinformationyy/?pid=<?php echo $vo['id']; ?>"><img width="100%" src="<?= Yii::getAlias('@web') . '/' ?>style/images/buybtn.png" alt="加入购入车"></a>
									</div>
								</div>
							</li>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>
			</section>
			<div class="footerh"></div>
		</section>
	</div>
	  <?= $this->render('//layouts/footer_section', [
        //'model' => $model,
    ]) ?>
<?= Html::jsFile('@web/style/js/jquery-2.1.1.min.js') ?>
<?= Html::jsFile('@web/style/js/reset.js') ?>
<script>
	$(document).ready(function(){
		var UA=window.navigator.userAgent;  //使用设备
		var CLICK="click";
		if(/ipad|iphone|android/.test(UA)){   //判断使用设备
			CLICK="tap";
		};
		$(".modular32wcon1 img").height($(".modular32wcon1 img").width()/2);
		$(".modular32-middent").height($(".modular32con").height());
		$(".modular32line span").each(function(){
			var LineN = parseInt($(this).text());
			$(this).css("width",LineN+"%");
		})
		$(".modular33tit li")[CLICK](function(){
			var TH = $(this),
			THP = $(this).parents(".modular33tit");
			THHI = TH.find('i');
			THP.find("li").removeClass("current7");
			TH.addClass("current7");
			var isign = TH.find('p a').attr("id");
			<?php if(!empty($_GET['cate'])): ?>
			var cate = "<?php echo $_GET['cate']; ?>";
			<?php else: ?>
			var cate = "all";
			<?php endif ?>
			if(isign == "price"){
				if(THHI.length > 0){
					if(THHI.hasClass("icon-caret-down")){
						THHI.removeClass("icon-caret-down");
						THHI.addClass("icon-caret-up");
						location.href = "/yyzc/itemlist/?cate="+cate+"&cond=4";
					}else{
						THHI.addClass("icon-caret-down");
						THHI.removeClass("icon-caret-up");
						location.href = "/yyzc/itemlist/?cate="+cate+"&cond=5";
					}
				}
			}
			if(isign == "half"){
				if(THHI.length > 0){
					if(THHI.hasClass("icon-caret-down")){
						THHI.removeClass("icon-caret-down");
						THHI.addClass("icon-caret-up");
						location.href = "/yyzc/itemlist/?cate="+cate+"&cond=6";
					}else{
						THHI.addClass("icon-caret-down");
						THHI.removeClass("icon-caret-up");
						location.href = "/yyzc/itemlist/?cate="+cate+"&cond=7";
					}
				}
			}
		});
		$(".bodyA").hide();
	})
</script>
</body>
</html>