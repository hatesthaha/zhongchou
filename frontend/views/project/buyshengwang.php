<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\i18n\Formatter;
use frontend\models\Collect;
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
	<title><?= $proinfo['name']; ?></title>
	<?= Html::cssFile('@web/style/css/font-awesome.min.css') ?>
	<?= Html::cssFile('@web/style/css/reset.css') ?>
	<?= Html::cssFile('@web/style/css/style.css') ?>

</head>
<body>
	<section class="bodyA"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/u0.gif" alt=""></section>
	<div id="body_h" class="bgeee">
		<section class="pagetop">
			<a class="pagetopleft" href="javascript:history.go(-1)"><i class='icon-angle-left'></i></a>
			<h2><?= $proinfo['name']; ?></h2>
			<a class="pagetopright" href="/"></a>
		</section>
		<section class="headerh"></section>
		<section class="bannerPane2">
		    <div class="swipe">
		        <ul id="slider">
				<?php if(!empty($proinfo['img'])){ ?>
				<?php foreach($proinfo['img'] as $key => $val) : ?>
		            <li style="display:block;">
		                <img width="100%" src="<?= Yii::getAlias('@web') . '/' ?>upload/<?=$val?>" alt="<?=$proinfo['name']; ?>" />
		            </li>
		        <?php endforeach;?>
				<?php }else{?>
					<li style="display:block;">
		                <img width="100%" src="<?= Yii::getAlias('@web') . '/' ?>style/images/nopicture.jpg" alt="<?=$proinfo['name']; ?>" />
		            </li>
				<?php }?>
		        </ul>
		        <div id="pagenavi">
				<?php foreach($proinfo['img'] as $key => $val) : ?>
		            <a href="javascript:void(0);" class="<?php if($key == "0"){echo "active";}?>"><?= $key+1 ?></a>
				<?php endforeach;?>
		        </div>
		    </div>
		</section>
		<!--<section class="modular30">
			<p class="modular30-con4 clearfix"><span class="float-right text-r"><?=
			Yii::$app->formatter->format($proinfo['total_money']/$proinfo['target_money'], ['percent', 2])
			?></span></p>
			<p class="modular30-con1"><span></span></p>
			<p class="modular30-con2 clearfix"><span class="float-left text-l"><?=
			Yii::$app->formatter->format($proinfo['total_money']/$proinfo['target_money'], ['percent', 2])
			?></span><span class="float-left text-c">￥<?= $proinfo['total_money']; ?></span><span class="float-right text-r"><em id="progressN">￥<?= $proinfo['target_money']; ?></em></span></p>
			<p class="modular30-con3 clearfix"><span class="float-left text-l">达成率</span><span class="float-left text-c">目前筹资</span><span class="text-r float-right">目标金额</span></p>
		</section>-->
		<section class="modular302">
		  <h2 style="color:#3c3c3c;font-weight:bold;font-size: 0.46875rem;height:25px;line-height:25px;">详情介绍</h2>
		  <p><?= $proinfo['content']; ?></p>
		
		</section>
		
		
        <!-- <p class="modular51 clearfix"><span data-cato="modular531">产品详情</span><span data-cato="modular532">所有参与记录</span></p>-->
		<section class="modular302" id="modular531">
		
		
		<?php
		
		if(isset($proinfo['c_img'])){
		foreach($proinfo['c_img'] as $key => $val) { ?>
			<p><img width="95%" src="<?= Yii::getAlias('@web') . '/' ?>upload/<?=$val?>" alt="项目详情"></p>
		<?php }}?>
		</section>
       <!-- <section class="modular50 modular53" id="modular532">
            <ul class="modular50-list" id="xialalist">
				<?php 
					if(!empty($jilu)) { 
					foreach($jilu as $jilua){
				?>
				
					<li>
						<p class="modular50-listimg"><img src="<?= Yii::getAlias('@web') . '/' ?><?php if(!empty($jilua['u']['head'])){echo 'upload/'. $jilua['u']['head'];}else{echo 'style/images/header-img.jpg';}?>" alt="头像"></p>
						<div class="modular50-listcon">
							<div>
								<h2><?= empty($jilua['u']['name'])?$jilua['u']['phone']:$jilua['u']['name'] ?></h2>
								<p>支持金额<span><?= $jilua['money'] ?></span>元</p>
								<p><?php echo date('Y-m-d H:i:s', $jilua['updated_at']);?></p>
							</div>
						</div>
					</li>
					<?php }}?>
            </ul>
        </section>-->
	</div>
	<section class="mask-share hide">
		<div class="positionrq"> 
			<section class="mask-sharebox">
				<ul class="clearfix">
					<li><a title="qqim" onclick="javascript:bShare.share(event,'qqim',0);return false;"><p><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/share1.png" alt="QQ好友"></p><p>QQ好友</p></a></li>
					<li><a title="qzone" onclick="javascript:bShare.share(event,'qzone',0);return false;"><p><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/share2.png" alt="QQ空间"></p><p>QQ空间</p></a></li>
					<li><a title="qqxiaoyou" onclick="javascript:bShare.share(event,'qqxiaoyou',0);return false;"><p><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/share3.png" alt="朋友网"></p><p>朋友网</p></a></li>
					<li><a title="qqmb" onclick="javascript:bShare.share(event,'qqmb',0);return false;"><p><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/share4.png" alt="腾讯微博"></p><p>腾讯微博</p></a></li>
					<li><a title="douban" onclick="javascript:bShare.share(event,'douban',0);return false;"><p><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/share5.png" alt="豆瓣网"></p><p>豆瓣网</p></a></li>
					<li><a title="weixin" onclick="javascript:bShare.share(event,'weixin',0);return false;"><p><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/share7.png" alt="微信好友"></p><p>微信好友</p></a></li>
					<li><a title="sinaminiblog" onclick="javascript:bShare.share(event,'sinaminiblog',0);return false;"><p><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/share9.png" alt="新浪微博"></p><p>新浪微博</p></a></li>
					<li><a title="renren" onclick="javascript:bShare.share(event,'renren',0);return false;"><p><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/share10.png" alt="人人网"></p><p>人人网</p></a></li>
				</ul>
				<p><span class="mask-noshare" id="noshare">取消</span></p>
			</section>
		</div>
	</section>
	<div class="footerh2"></div>
	<section>
		<ul class="footer2 clearfix">
			<li>
				<a id="showshare" href="/">
					<p><i class="icon-share"></i></p><p>分享</p>
				</a>
			</li>
			<li>
				<a>
					<?php
						$coll = Collect::find()->where(['user_id'=>$userinfo['id'],'goods_id'=>$proinfo['id']])->one();
					?>
					<?php if(!empty($coll)): ?>
					<p><i class="icon-star"></i></p><p class="collecttext">已收藏</p>
					<?php else: ?>
					<p><i class="icon-star-empty"></i></p><p class="collecttext">收藏</p>
					<?php endif ?>
				</a>
			</li>
			<li class="footer2auto">
			<?php if($proinfo['status'] == "0"): ?>
				<a>尚未开始</a>
			<?php elseif($proinfo['status'] == "1"): ?>
				<a>已结束</a>
			<?php elseif($proinfo['status'] == "2"): ?>
					<a href="/order/buyshengwang/?pid=<?php echo $proinfo['id']; ?>">购买声望</a>
			<?php endif ?>
			</li>
		</ul>
	</section>
	<p id="tip-error"><span>表单验证错误信息</span></p>
	<?= Html::jsFile('@web/style/js/touchscroll.js') ?>
	<?= Html::jsFile('@web/style/js/touchscroll.dev.js') ?>
	<?= Html::jsFile('@web/style/js/run.js') ?>
	<?= Html::jsFile('@web/style/js/jquery-2.1.1.min.js') ?>
	<?= Html::jsFile('@web/style/js/reset.js') ?>
<script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/buttonLite.js#style=-1&amp;uuid=&amp;pophcol=2&amp;lang=zh"></script>
<script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/bshareC0.js"></script>
<script>
	$(document).ready(function(){
	    var UA=window.navigator.userAgent;  //使用设备
	    var CLICK="click";
	    if(/ipad|iphone|android/.test(UA)){   //判断使用设备
	        CLICK="tap";
	    };
	    $(".swipe li img").height($(".swipe li img").width()*0.4);
	    var progressN = parseInt($("#progressN").text());
	    $(".modular30-con1 span").css("width",progressN+"%");
		$(".bodyA").hide();
		$("#showshare")[CLICK](function(){
			event.preventDefault();
			$(".mask-share").removeClass("hide");
			$(".mask-sharebox").animate({bottom:"0"},300);
		});
		$("#noshare")[CLICK](function(){
			event.preventDefault();
			$(".mask-share").addClass("hide");
			$(".mask-sharebox").animate({bottom:"-80rem"},300);
		});
		// $("#guanzhuP")[CLICK](function(event){
			// event.preventDefault();
			// var isguanzhu = '<?php echo !empty($check);?>';
			// if (isguanzhu==""){
				// var other = <?= $proinfo['user_id']; ?>;
				// $.post("/project/add",{other:other},function(result){
					// if(result == 'true'){
						// $("#guanzhuP").addClass("activeon");
						// $("#guanzhuP").html("已关注");
						// $('#tip-error span').html('关注成功');
						// $('#tip-error').show();
						// setTimeout(function(){$('#tip-error').fadeOut(500);},1000);
					// }else {
						// $('#tip-error span').html('服务器繁忙，请稍后再试');
						// $('#tip-error').show();
						// setTimeout(function(){$('#tip-error').fadeOut(500);},1000);
					// }
				// });
			// }
		// });
        // var catoFram=$(".modular53");
        // var subNav=$(".modular51 span");
        // catoFram[0].style.display="block";
        // subNav[0].className += " oncur" ;
        // subNav[CLICK](function(){
            // var _this=$(this);
            // var id=_this.data("cato");
            // var cur=$("#"+id);
            // subNav.removeClass("oncur");
            // _this.addClass("oncur");
            // catoFram.hide();
            // cur.show();
        // });
		var id = <?php echo $proinfo['id']; ?>;
		<?php if(!empty($userinfo)): ?>
		var who = <?php echo $userinfo['id']; ?>;
		<?php endif ?>
		$("body").on('click','.icon-star-empty',function(){
			<?php if(!empty($userinfo)): ?>
			$.post("/project/collect",{id:id,who:who},function(result){
				if(result == "1"){
					$(".icon-star-empty").attr("class","icon-star");
					$(".collecttext").html("已收藏");
                    $('#tip-error span').html('收藏成功');
                    $('#tip-error').show();
                    setTimeout(function(){$('#tip-error').fadeOut(500);},1000);
				}else{
                    $('#tip-error span').html('服务器繁忙，请稍后再试');
                    $('#tip-error').show();
                    setTimeout(function(){$('#tip-error').fadeOut(500);},1000);
				}
			});
			<?php else: ?>
                    $('#tip-error span').html('请登录后再试');
                    $('#tip-error').show();
                    setTimeout(function(){$('#tip-error').fadeOut(500);},1000);
			<?php endif ?>
		});
		$("body").on('click','.icon-star',function(){
			$.post("/project/delcollect",{id:id,who:who},function(result){
				if(result == "1"){
					$(".icon-star").attr("class","icon-star-empty");
					$(".collecttext").html("收藏");
                    $('#tip-error span').html('删除收藏');
                    $('#tip-error').show();
                    setTimeout(function(){$('#tip-error').fadeOut(500);},1000);
				}else{
                    $('#tip-error span').html('服务器繁忙，请稍后再试');
                    $('#tip-error').show();
                    setTimeout(function(){$('#tip-error').fadeOut(500);},1000);
				}
			});
		});
		
				
		
		
		//下拉加载
	
	} )
</script>
</body>
</html>