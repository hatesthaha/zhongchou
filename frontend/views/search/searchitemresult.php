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
		<section class="pagetop pagetopsearch">
			<div>
				<a class="pagetopleft2" href="javascript:history.go(-1)"><i class='icon-angle-left'></i></a>
				<input class="pagetopsearchinp" type="text" name="search" placeholder="请输入关键字">
				<a class="pagetopsearchtn">搜索</a>
			</div>
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
							<li onclick="screen(0)"><span class="newhover">全部</span></li>
							<!--<li onclick="screen(1)"><span>公益梦</span></li>-->
							<li onclick="screen(2)"><span>白日梦</span></li>
							<li onclick="screen(3)"><span>屌丝梦</span></li>
							<li onclick="screen(4)"><span>土豪梦</span></li>
							<li onclick="screen(5)"><span>入道梦</span></li>
							<li onclick="screen(6)"><span>超神梦</span></li>
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
							<li onclick="screen(15)"><span class="newhover">默认</span></li>
							<li onclick="screen(8)"><span>最新上线</span></li>
							<li onclick="screen(9)"><span>目标金额</span></li>
							<li onclick="screen(10)"><span>支持人数</span></li>
							<li onclick="screen(11)"><span>筹款额</span></li>
						</ul>
					</li>
					<li>
						<p><span>
						<?php 
								if(isset($condition)){
									switch ($condition[1]) {
										case '5':
											echo "众筹中";
											break;
										case '6':
											echo "即将开始";
											break;
										case '7':
											echo "成功结束";
											break;
										default:
											echo "进程";
											break;
									}
								}else{
									echo "进程";
								}
							?>
						</span><i class="icon-angle-down"></i></p>
						<ul class="subnavpage hide">
							<li onclick="screen(15)"><span class="newhover">进程</span></li>
							<li onclick="screen(12)"><span>众筹中</span></li>
							<li onclick="screen(13)"><span>即将开始</span></li>
							<li onclick="screen(14)"><span>成功结束</span></li>
						</ul>
					</li>
				</ul>
			</section>
			<section class="modular25con">
				<ul>
					<!--此处为循环div开始-->
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
								<img <?php if ($value['status']!=2){echo 'class="hui-pagerq img3"'; }else{ echo 'class="img3"'; } ?>  width="100%" src="<?= Yii::getAlias('@web') . '/' ?><?php if(isset($value['img'])&&$value['img']!=""){ $img = explode(',', $value['img']); echo 'upload/'.$img[0]; }else{echo "style/images/nopicture.jpg";} ?>">
								<div class="project-word">
									<p class="project-wordt"><?= mb_substr(strip_tags(html_entity_decode($value['name'])),0,15,'utf-8')?></p>
									<p>目标金额：<?= $value['target_money'] ?></p>
								</div>
								<div class="projectcircle">
									<div class="circle">
									    <div class="pie_left"><div class="left"></div></div>
									    <div class="pie_right"><div class="right"></div></div>
									    <div class="mask Greencolor">
									    	<?php
									    		if($value['status']==0){
									    			echo '<p class="no-start">即将开始</p>';

									    			//echo "<p class='hide'><span class='NUM'>".empty($value['wanchengdu'])?0:$value['wanchengdu'] ."</span>%</p>";
									    		}elseif($value['status']==1){
									    			echo '<p class="no-start">已结束</p>';
									    			echo "<p class='hide'><span class='NUM'>100</span>%</p>";

									    		}else{
									    			echo '<p>';echo empty($value['wanchengdu'])?0:$value['wanchengdu']; echo '%</p>';echo "<p class='hide'><span class='NUM'>"; echo empty($value['wanchengdu'])?0:$value['wanchengdu'] ; echo "</span>%</p>";
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
	    $("#searchitembtn")[CLICK](function(event){
	    	event.preventDefault();
    		$(".subnavpage").addClass("hide");
	    	$(".modular25-tit > ul > li").removeClass("yellowco");
	    	$(this).parents(".pagetop").hide();
	    	$("#searchitemdiv").show();
	    	$("#searchitemdiv").find("inpuhttpt").focus();
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
	    		TH.addClass("yellowco");
	    		$(".subnavpage").addClass("hide");
	    		THU.removeClass("hide");
	    	}else{
	    		TH.removeClass("yellowco");
	    		$(".subnavpage").addClass("hide");
	    		THU.addClass("hide");
	    	}
	    });
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
		$(".pagetopsearchtn")[CLICK](function(event){
			var content= $(".pagetopsearchinp").val();
			if(content==""){
				$('#tip-error span').html('请输入关键字');
				$('#tip-error').show();
				setTimeout(function(){$('#tip-error').fadeOut(500);},1000);
				return ;
			}
			location.href="/search/search/?content="+content;
		})
	})
function screen(id){
		var tid=<?php if(isset($condition))echo $condition[0];else echo 0; ?>;
		var sort=<?php if(isset($condition))echo $condition[1];else echo 0; ?>;
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
				sort=5;
				break;
			case 13:
				sort=6;
				break;
			case 14:
				sort=7;
				break;
			case 15:
				sort=0;
				break;
			default:
				tid=sort=0;
		}

		location.href=<?php echo '"'.Url::to(['search/searchitem']).'?tid="';?>+tid+"&sort="+sort;
		
	}
</script>
</body>
</html>