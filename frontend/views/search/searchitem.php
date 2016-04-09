<?php
	use yii\helpers\Html;
	use yii\helpers\Url;
	use frontend\models\Term;
	$this->title="全部";
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
	<title><?= Html::encode($this->title) ?></title>
	<?php $this->head() ?>
    <?= Html::cssFile('@web/style/css/font-awesome.min.css')?>
    <?= Html::cssFile('@web/style/css/reset.css') ?>
    <?= Html::cssFile('@web/style/css/style.css')?>
</head>
<body>
	<section class="bodyA"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/u0.gif" alt=""></section>
	<div id="body_h">
		<section class="pagetop">
			<a class="pagetopleft" href="/site/index"><i class='icon-angle-left'></i></a>
			<h2>全部</h2>
			<a class="pagetopright" href="<?= Url::to(['search/search'])?>"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/searchitop.png" alt="搜索"></a>
		</section>
		<section class="headerh"></section>
		<section class="modular25">
			<section class="modular25-tit">
				<ul class="clearfix">
					<li>
						<p><span>
							<?php 
								if(isset($condition)){
									switch ($condition[0]) {
										case '2':
											echo "白日梦";
											break;
										case '3':
											echo "屌丝梦";
											break;
										case '4':
											echo "土豪梦";
											break;
										case '5':
											echo "入道梦";
											break;
										case '6':
											echo "超神梦";
											break;
										case '8':
											echo "一元夺宝";
											break;
										// case '7':
											// echo "公益梦";
											// break;
										
										default:
											echo "全部";
											break;
									}
								}else{
									echo "全部";
								}
							?>
						</span><i class="icon-angle-down"></i></p>
						<ul class="subnavpage hide onesubnav">
							<li onclick="screen(0)"><span class="<?php if(empty($_GET['tid']) || !empty($_GET['tid']) && $_GET['tid'] == '0'){echo "newhover";}?>">全部</span></li>
							<!--<li onclick="screen(1)"><span class="<?php if(!empty($_GET['tid']) && $_GET['tid'] == '7'){echo "newhover";}?>">公益梦</span></li>-->
							<li onclick="screen(2)"><span class="<?php if(!empty($_GET['tid']) && $_GET['tid'] == '2'){echo "newhover";}?>">白日梦</span></li>
							<li onclick="screen(3)"><span class="<?php if(!empty($_GET['tid']) && $_GET['tid'] == '3'){echo "newhover";}?>">屌丝梦</span></li>
							<li onclick="screen(4)"><span class="<?php if(!empty($_GET['tid']) && $_GET['tid'] == '4'){echo "newhover";}?>">土豪梦</span></li>
							<li onclick="screen(5)"><span class="<?php if(!empty($_GET['tid']) && $_GET['tid'] == '5'){echo "newhover";}?>">入道梦</span></li>
							<li onclick="screen(6)"><span class="<?php if(!empty($_GET['tid']) && $_GET['tid'] == '6'){echo "newhover";}?>">超神梦</span></li>
							<li onclick="screen(7)"><span>一元夺宝</span></li>
						</ul>
					</li>
					<li>
						<p><span>
							<?php 
								if(isset($condition)){
									switch ($condition[1]) {
										case '1':
											echo "最新上线";
											break;
										case '2':
											echo "目标金额";
											break;
										case '3':
											echo "支持人数";
											break;
										case '4':
											echo "筹款金额";
											break;
										default:
											echo "默认";
											break;
									}
								}else{
									echo "默认";
								}
							?>
						</span><i class="icon-angle-down"></i></p>
						<ul class="subnavpage hide">
							<li onclick="screen(15)"><span class="<?php if(empty($_GET['sort']) || !empty($_GET['sort']) && $_GET['sort'] == '0'){echo "newhover";}?>"> 默  认 </span></li>
							<li onclick="screen(8)"><span class="<?php if(!empty($_GET['sort']) && $_GET['sort'] == '1'){echo "newhover";}?>">最新上线</span></li>
							<li onclick="screen(9)"><span class="<?php if(!empty($_GET['sort']) && $_GET['sort'] == '2'){echo "newhover";}?>">目标金额</span></li>
							<li onclick="screen(10)"><span class="<?php if(!empty($_GET['sort']) && $_GET['sort'] == '3'){echo "newhover";}?>">支持人数</span></li>
							<li onclick="screen(11)"><span class="<?php if(!empty($_GET['sort']) && $_GET['sort'] == '4'){echo "newhover";}?>">筹 款 额</span></li>
						</ul>
					</li>
					<li>
						<p><span>
						<?php 
								if(isset($condition)){
									switch ($condition[2]) {
										case '1':
											echo "众 筹 中";
											break;
										case '2':
											echo "即将开始";
											break;
										case '3':
											echo "成功结束";
											break;
										case '4':
											echo "暂 停 中";
											break;
										default:
											echo " 进  程 ";
											break;
									}
								}else{
									echo "进程";
								}
							?>
						</span><i class="icon-angle-down"></i></p>
						<ul class="subnavpage hide">
							<li onclick="screen(16)"><span class="<?php if(empty($_GET['status']) || !empty($_GET['status']) && $_GET['status'] == '0'){echo "newhover";}?>"> 进  程 </span></li>
							<li onclick="screen(12)"><span class="<?php if(!empty($_GET['status']) && $_GET['status'] == '1'){echo "newhover";}?>">众 筹 中</span></li>
							<li onclick="screen(13)"><span class="<?php if(!empty($_GET['status']) && $_GET['status'] == '2'){echo "newhover";}?>">即将开始</span></li>
							<!--<li onclick="screen(17)"><span>暂 停 中</span></li>-->
							<li onclick="screen(14)"><span class="<?php if(!empty($_GET['status']) && $_GET['status'] == '3'){echo "newhover";}?>">成功结束</span></li>
						</ul>
					</li>
				</ul>
			</section>
			<section class="modular25con">
				<ul>
					<!--此处为循环div开始-->
				<?php if(!empty($product)){
					foreach ($product as $key => $value) {
						$aorb = Term::find()->where(['id'=>$value['term_id']])->one();
				?>
					<li>
						<div class="project-con borall">
							<?php if($aorb['parent_id'] == "1"): ?>
							<a href="/project/projectdetails/?id=<?= $value['id']; ?>">
							<?php else: ?>
							<a href="/yyzc/projectdetailsyy/?id=<?= $value['id']; ?>">
							<?php endif ?>
								<img <?php if ($value['status']!=2){echo 'class="hui-pagerq img3"'; }else{echo 'class="img3"';} ?>  width="100%" src="<?= Yii::getAlias('@web') . '/' ?><?php if(isset($value['img'])&&$value['img']!=""){ $img = explode(',', $value['img']); echo 'upload/'.$img[0]; }else{echo "style/images/nopicture.jpg";} ?>">
								<div class="project-word">
									<p class="project-wordt"><?= mb_substr(strip_tags(html_entity_decode($value['name'])),0,15,'utf-8')?></p>
									<p>目标金额：<?= $value['target_money'] ?>
									<?php
										if ($value['status'] == 0 && !empty($value['paixu']) ) {
											if ($value['sorted_at'] != 0) {
												echo "&nbsp;&nbsp;&nbsp;当前排序：".$value['paixu'];
											} else {
												echo "&nbsp;&nbsp;&nbsp;当前排序：尚未进行排序";
											}
										}
									?>
									</p>
									
								</div>
								<div class="projectcircle">
									<div class="circle">
									    <div class="pie_left"><div class="left"></div></div>
									    <div class="pie_right"><div class="right"></div></div>
									    <div class="mask Greencolor">
									    	<?php
									    		if($value['status']==0){
									    			echo '<p class="no-start">即将开始</p>';

									    			//echo "<p class='hide'><span class='NUM'>". isset($value['wanchengdu'])?$value['wanchengdu']:0 ."</span>%</p>";
									    		}elseif($value['status']==1){
									    			echo '<p class="no-start">已结束</p>';
									    			echo "<p class='hide'><span class='NUM'>100</span>%</p>";

									    		}else{
									    			echo '<p>';echo isset($value['wanchengdu'])?$value['wanchengdu']:0; echo '%</p>';echo "<p class='hide'><span class='NUM'>"; echo isset($value['wanchengdu'])?$value['wanchengdu']:0 ; echo "</span>%</p>";
									    		}
									    	?>
									    </div>
									</div>
								</div>
							</a>
						</div>
					</li>
				<?php }}else{
					echo '<p class="font14 text-c redcc">暂无数据</p>';
				} ?>
				</ul>
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
	    $("#searchitembtn")[CLICK](function(event){
	    	event.preventDefault();
    		$(".subnavpage").addClass("hide");
	    	$(".modular25-tit > ul > li").removeClass("yellowco");
	    	$(this).parents(".pagetop").hide();
	    	$("#searchitemdiv").show();
	    	$("#searchitemdiv").find("input").focus();
	    });
		//圆形进度条开始
	    $('.circle').each(function(index, el) {
	        var num = $(this).find('.NUM').text() * 3.6;
	        if (num<=180) {
	            $(this).find('.right').css('transform', "rotate(" + num + "deg)");
	        } else {
	            $(this).find('.right').css('transform', "rotate(180deg)");
	            $(this).find('.left').css('transform', "rotate(" + (num - 180) + "deg)");
	        };
	    });
	    $(".modular25-tit > ul > li")[CLICK](function(){
	    	var TH = $(this);
	    	    THU = $(this).find(".subnavpage");
	    	if(THU.hasClass("hide")){
	    		$(".modular25-tit > ul > li").removeClass("yellowco");
	    		TH.addClass("yellowco");
	    		$(".subnavpage").addClass("hide");
	    		THU.removeClass("hide");
	    	}else{
	    		$(".modular25-tit > ul > li").removeClass("yellowco");
	    		TH.removeClass("yellowco");
	    		$(".subnavpage").addClass("hide");
	    		THU.addClass("hide");
	    	}
	    });
	    $(".onesubnav li")[CLICK](function(){
	    	var THONE = $(this).find("span").text();
	    	$(".pagetop h2").html(THONE);
	    })
	    $(".modular25con")[CLICK](function(){
    		$(".subnavpage").addClass("hide");
	    });
	    //选择的筛选条件js，THVAL为选择的筛选条件。
	    $(".subnavpage li span")[CLICK](function(){
	    	var THVAL = $(this).text();
	    	    THTIT = $(this).parents(".subnavpage").siblings("p").find("span");
	    	    THSPAN = $(this).parents(".subnavpage").find("span");
	    	THSPAN.removeClass("newhover");
	    	$(this).addClass("newhover");
	    	console.log(THVAL);
	    	THTIT.text(THVAL);

	    });
		//圆形进度条结束
		$(".bodyA").hide();
	})
	function screen(id){
		var tid=<?php if(isset($condition))echo $condition[0];else echo 0; ?>;
		var sort=<?php if(isset($condition))echo $condition[1];else echo 0; ?>;
		var status=<?php if(isset($condition))echo $condition[2];else echo 0; ?>;
		switch(id){
			case 0:
				tid=0;
				break;
			case 1:
				tid=7;
				break;
			case 2:
				tid=2;
				break;
			case 3:
				tid=3;
				break;
			case 4:
				tid=4;
				break;
			case 5:
				tid=5;
				break;
			case 6:
				tid=6;
				break;
			case 7:
				tid=8;
				break;
			case 8:
				sort=1;
				break;
			case 9:
				sort=2;
				break;
			case 10:
				sort=3;
				break;
			case 11:
				sort=4;
				break;
			case 12:
				status=1;
				break;
			case 13:
				status=2;
				break;
			case 14:
				status=3;
				break;
			// case 17:
			// 	status=4;
			// 	break;
			case 15:
				sort=0;
				break;
			case 16:
				status=0;
				break;
			default:
				status=tid=sort=0;
		}

		location.href=<?php echo '"'.Url::to(['search/searchitem']).'?tid="';?>+tid+"&sort="+sort+"&status="+status;
		
	}
</script>