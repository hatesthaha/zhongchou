<?php
use yii\helpers\Html;
use frontend\models\Collect;
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
	<meta content="转让变现快,提现实时到,多重保障,本息保护,账户托管至新浪支付" name="Keywords">
	<meta name="description" content="仌仌众梦" />	
	<title><?= $product['name']; ?></title>
	<?= Html::cssFile('@web/style/css/font-awesome.min.css') ?>
	<?= Html::cssFile('@web/style/css/reset.css') ?>
	<?= Html::cssFile('@web/style/css/style.css') ?>
</head>
<body>
	<section class="bodyA"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/u0.gif" alt=""></section>
	<div id="body_h" class="bgeee">
		<section class="pagetop">
			<a class="pagetopleft" href="javascript:history.go(-1)"><i class='icon-angle-left'></i></a>
			<h2><?= $product['name']; ?></h2>
			<a class="pagetopright" href="/"></a>
		</section>
		<section class="headerh"></section>
		<section class="bannerPane2">
		    <div class="swipe">
		        <ul id="slider">
		        	<?php foreach(explode(",",$product['img']) as $_k => $vo): ?>
		            <li style="display:block;">
		                <img width="100%" src="<?= Yii::getAlias('@web') . '/' ?><?php if(!empty($vo)&&$vo!=""){ echo 'upload/'.$vo; }else{echo "style/images/nopicture.jpg";} ?>" alt="项目名称" />
		            </li>
		            <?php endforeach; ?>
		        </ul>
		        <div id="pagenavi">
		        	<?php foreach(explode(",",$product['img']) as $_k => $vo): ?>
		            <a href="javascript:void(0);" class="<?php if($_k == "0"){echo "active";}?>"><?= $_k; ?></a>
		            <?php endforeach; ?>
		        </div>
		    </div>
		</section>
		<section class="modular30">
			<p class="modular30-con4 clearfix"><span class="float-right text-r"><?=
			Yii::$app->formatter->format($product['total_money']/$product['target_money'], ['percent', 2])
			?></span></p>
			<p class="modular30-con1"><span style="width:<?=
			Yii::$app->formatter->format($product['total_money']/$product['target_money'], ['percent', 2])
			?>;"></span></p>
			<p class="modular30-con2 clearfix"><span class="float-left text-l"><?=
			Yii::$app->formatter->format($product['total_money']/$product['target_money'], ['percent', 2])
			?></span><span class="float-left text-c">￥<?= $product['total_money']; ?></span><span class="float-right text-r"><em id="progressN">￥<?= $product['target_money']; ?></em></span></p>
			<p class="modular30-con3 clearfix"><span class="float-left text-l">达成率</span><span class="float-left text-c">目前筹资</span><span class="text-r float-right">目标金额</span></p>
		</section>
		<!--<section class="modular30">
			<p class="modular30-con1"><span></span></p>
			<p class="modular30-con2 clearfix"><span class="float-left">￥<?= $product['target_money']; ?></span><span class="float-right" style="text-align: right;"><em id="progressN" class="hide"><?php echo $product['total_money']/$product['target_money']*100; ?></em><?php $res = $product['target_money']-$product['total_money']; if($res == "0"){echo "已完成";}elseif($res < "0"){ echo "超额完成";}else{echo "￥".$res;} ?></span></p>
			<p class="modular30-con3 clearfix"><span class="float-left">总需人次</span><span class="float-right" style="text-align: right;">剩余人次</span></p>
		</section>-->
		<section class="modular41">
			<ul><li><a href="/yyzc/projectdetailsyyn1/?id=<?php echo $_GET['id']; ?>">所有记录<i class="icon-angle-right"></i></a></li></ul>
			<ul><li><a href="javascript:;">项目详情</a></li></ul>
			<?php
				$img = explode(",",$product['c_img']);
			?>
			<p>
				<?php
				if(!empty($img)){
				foreach ($img as $key => $value){ 
					if (!empty($value)) {
				?>
					<img width="100%" src="<?= Yii::getAlias('@web') . '/' ?>upload/<?= $value; ?>" alt="项目详情">
					<?php }}} ?>
				<?= $product['content']; ?></p>
		</section>
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
						$coll = Collect::find()->where(['user_id'=>$userinfo['id'],'goods_id'=>$_GET['id']])->one();
					?>
					<?php if(!empty($coll)): ?>
					<p><i class="icon-star"></i></p><p class="collecttext">已关注</p>
					<?php else: ?>
					<p><i class="icon-star-empty"></i></p><p class="collecttext">关注</p>
					<?php endif ?>
				</a>
			</li>
			<li class="footer2auto">
				<?php if(!empty($needlogin)): ?>
				<a href="/register/signin/?link=<?php echo $_SERVER['REQUEST_URI']; ?>">需要登录</a>
				<?php else: ?>
				<a href="/order/orderinformationyy/?pid=<?php echo $_GET['id']; ?>">我要夺宝</a>
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
	    $(".swipe li img").height($(".swipe li img").width()/2);
	    var progressN = parseInt($("#progressN").text());
	    console.log(progressN);
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
		var id = <?php echo $_GET['id']; ?>;
		<?php if(!empty($userinfo)): ?>
		var who = <?php echo $userinfo['id']; ?>;
		<?php endif ?>
		$("body").on('click','.icon-star-empty',function(){
			<?php if(!empty($userinfo)): ?>
			$.post("/project/collect",{id:id,who:who},function(result){
				if(result == "1"){
					$(".icon-star-empty").attr("class","icon-star");
					$(".collecttext").html("已关注");
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
					$(".collecttext").html("关注");
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
	})
</script>
</body>
</html>