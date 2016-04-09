<?php
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\file\FileInput;
use yii\widgets\ActiveForm; 
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
	<meta content="我要发起" name="Keywords">
	<meta name="description" content="仌仌众梦" />	
	<title>我要发起</title>
	<?= Html::cssFile('@web/style/css/font-awesome.min.css') ?>
	<?= Html::cssFile('@web/style/css/reset.css') ?>
	<?= Html::cssFile('@web/style/css/style.css') ?>
	<?= Html::jsFile('@web/style/js/jquery-2.1.3.min.js') ?>
	<?= Html::jsFile('@web/style/js/reset.js') ?>
	
	<?= Html::jsFile('@web/style/js/localResizeIMG2.js') ?>
	<?= Html::jsFile('@web/style/js/mobileBUGFix.mini.js') ?>

<style>
	#tip-error span{
		width: 80%;
	}
</style>

</head>
<body>
	<section class="bodyA"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/u0.gif" alt=""></section>
	<div id="body_h">
		<section class="pagetop">
			<a class="pagetopleft" href="javascript:history.go(-1)"><i class='icon-angle-left'></i></a>
			<h2>我要发起</h2>
			<!--<a class="pagetopright" href="/">完成</a>-->
		</section>
		<section class="headerh"></section>
		<section style="background: #eee; padding: 0 0 0.5rem;">
		    <p style="padding: 0.8rem 1.2rem; border-bottom: 1px solid #dcdcdc; border-top: 1px solid #dcdcdc;background: #fff;">您的项目发起最大金额为：<span class="redco" style="font-size:1.4rem"><?= $userinfo['tmoney']; ?></span>元</p>
		</section>
		<section class="modular34 bgeee">
			<div class="modular34con1" style=" border-top: 1px solid #dcdcdc;">
				<a class="modular34con1word" href="/address/chooseaddress">
					<div>
						<div>
						<?php if(!empty($noadd)): ?>
							请选择收货地址
						<?php else: ?>
							<p class="clearfix text-r"><span class="float-left">收货人：<?= $address['username']; ?></span><span class="modular17-cond"><?= $address['phone']; ?></span></p>
							<p class="modular17-cond">收货地址：<?= $address['province']; ?><?= $address['city']; ?><?= $address['county']; ?><?= $address['address']; ?></p>
						<?php endif ?>						</div>
					</div>
					<p><i class="icon-angle-right"></i></p>
				</a>
			</div>
			<form action="" method="POST" id='form'>
				<!--<div class="modular34con2">

					<div class="clearfix">
						<p class="float-left" style="line-height:3.7rem;">设置封面</p>
						<p class="float-right phoneaddimg"><img width="100%" height="100%" src="<?= Yii::getAlias('@web') . '/' ?>style/images/phoneaddimg.png" alt="">
						
						<input type="file" id="doc" name="Product[img][]" accept="image/*"/>
						
						</p>
					</div>
					
					
					<div class="xjclass3">
						<ul class="clearfix" id="dd">

						</ul>
					</div>

					<p class="xjclass5">最多传4张，图片大小需相同，建议图片宽高比例2.4:1，效果最佳。</p>
				</div>-->
				<div class="modular34con3">
					<div class="modular7-con">
						<div class="twoelement">
							<p class="fixedelement2">项目标题</p>
							<input id="name" type="text" class="changeelement" name="projectname" placeholder='标题' value="">
							<i class="rigd rigdx icon-remove hide"></i>
						</div>
						<div class="twoelement modular7-con2">
							<p class="fixedelement2">参考价格</p>
							<input id="targetmoney" type="text" class="changeelement" name="chouzje" placeholder='您可发起100~<?= $userinfo['tmoney']?>元的项目 ' value="">
							
							<span>元</span>
						</div>
						<div class="twoelement modular7-con2">
							<p class="fixedelement2">参考链接</p>
							<input id="pro_href" type="url" class="changeelement" name="pro_href" placeholder='商品链接必须以‘http’开头' value="">
						</div>
					    <select id="s_county" class="hide" name="s_county"></select>
						<!--<div class="twoelement haveborder nobor">
							<p class="fixedelement2">筹款目的</p>
						</div>-->	
					</div>
				</div>
				<div class="modular34con4">
					<ul class="clearfix">
						<li data-cato="mould-34list1" class="float-left">
							<p class="current8"><span class='modular34i'><i class="modular34i2 icon-picture"></i><i class="modular34i1 icon-picture"></i></span>筹款目的</p>
						</li>
						<!--<li data-cato="mould-34list2" class="float-left iamright">
							<p><span class='modular34i'><i class="modular34i1 icon-picture"></i><i class="modular34i3 icon-picture"></i></span>仅图片</p>
						</li>-->
					</ul>
					<div id="mould-34list1" class="xjclass7 modular34con4con hide xjclass2">
						<div class="modular34con4contop">
							<!--<p class="phoneaddimg">
								<img width="100%" height="100%" src="<?= Yii::getAlias('@web') . '/' ?>style/images/phoneaddimg.png" alt="">
								
								<input type="file" name="Product[c_img][]" id="doc1" accept="image/*" />
							</p>-->
							<p class="changeelement">
								<textarea id="xjtextarea" placeholder='请填写筹款目的，有助于通过审核哦！' name="chouzmd" rows="3"></textarea> 
								<span><i></i></span>
							</p>
						</div>
						<div class="modular34con4con modular34con4con2 xjclass4">
							<ul class="clearfix xjclass6" id="dd1">
								
							</ul>
						</div>
					</div>
					<div id="mould-34list2" class="xjclass7 modular34con4con2 hide" style="padding:10px 0 10px 20px;">
						<div class="modular34con4contop">
							<p class="phoneaddimg">
								<img width="100%" height="100%" src="<?= Yii::getAlias('@web') . '/' ?>style/images/phoneaddimg.png" alt="">
								
								<input type="file" name="Product[c_img][]" id="doc2" accept="image/*" />
							</p>

						</div>
							
						<div class="modular34con4con2 xjclass4">
							<ul class="clearfix xjclass6" id="dd2" style="padding:10px 0 10px 0;">
								
							</ul>
						</div>
					</div>
				</div>
				<div class="modular6">
				<input type='hidden' name='term_id' />
			<p class="form-ok"><input id="tijiao-mask" class="resetform bgfeb528-wf" name="formok-btn" type="button" value="提交"></p>
		</div>
			</form>
		</section>
		<?php if (!empty($faqitishi) && $faqitishi!=""){ ?>
		<section class="modular8">
			
			<?= $faqitishi['content']; ?> <br>
		</section>
		<?php } ?>
	</div>
	<p id="tip-error"><span>表单验证错误信息</span></p>
	<script>

	$(document).ready(function(){
		
		
	    var UA=window.navigator.userAgent;  //使用设备
	    var CLICK="click";
	    if(/ipad|iphone|android/.test(UA)){   //判断使用设备
	        CLICK="tap";
	    };
		var catoFram=$(".xjclass7");
	    var subNav=$(".modular34con4 > ul li");
	    $("#mould-34list1").removeClass("hide");
	    subNav[0].className += " current8" ;
	    subNav[CLICK](function(event){
            event.preventDefault();
	        var _this=$(this);
	        var id=_this.data("cato"); 
	        var cur=$("#"+id);
	        subNav.find("p").removeClass("current8");
	        _this.find("p").addClass("current8");
	        catoFram.addClass("hide");
	        cur.scrollTop(0);        
	        cur.removeClass("hide");
			var onindex = subNav.index(this);
			console.log(onindex);
			if(onindex == 1){
				$("#doc1").attr("form","b");
				$("#xjtextarea").attr("form","b");
				$("#doc2").removeAttr("form");
				$("#xjtextarea").val("1");
			}else if(onindex == 0){
				$("#doc2").attr("form","b");
				$("#xjtextarea").removeAttr("form");
				$("#doc1").removeAttr("form");
				$("#xjtextarea").val("");
			}
		});
		$(".modular34con1word > p").css("line-height",$(".modular34con1word").height()+"px");
		$("#name").change(function(){
			$(this).next("i").show();
			$(this).css("background-color","#fff");
		});
		$(".rigd")[CLICK](function(){
			$(this).hide();
			$(this).siblings("#name").val("");
		});
		$(".bodyA").hide();
		$("#tijiao-mask").click(function(){
			<?php if(!empty($_GET['id'])): ?>
			var id = <?php echo $_GET['id']; ?>;
			<?php else: ?>
			var id = false;
			<?php endif ?>
			var onindex = 0;
			var flag2 = $("#doc2").attr("form");
			var flag1 = $("#doc1").attr("form");
			if(flag2)
			onindex = 0;
			if(flag1)
			onindex = 1;
		 
		 if(onindex == false){
			var area = $("#xjtextarea").val();
		}else{
			var area = true;
		}
		var pro_href = $("#pro_href").val();
		
		 var RegUrl = new RegExp();
		 RegUrl.compile('^((https|http|ftp|rtsp|mms)://)'
				+ '{1}(([0-9a-z_!~*\'().&=+$%-]+: )?[0-9a-z_!~*\'().&=+$%-]+@)?' //ftp的user@
				+ '(([0-9]{1,3}.){3}[0-9]{1,3}' // IP形式的URL- 199.194.52.184
				+ '|' // 允许IP和DOMAIN（域名）
				+ '([0-9a-zA-Z_!~*\'()-]+.)*' // 域名- www.
				+ '([0-9a-zA-Z][0-9a-zA-Z]{0,61})?[0-9a-zA-Z].' // 二级域名
				+ '[a-zA-Z]{2,6})' // first level domain- .com or .museum
				+ '(:[0-9]{1,4})?' // 端口- :80
				+ '((/?)|' // a slash isn't required if there is no file name
				+ '(/[0-9a-zA-Z_!~*\'().;?:@&=+$,%#-\\s]+)+/?)$');
		 if(RegUrl.test(pro_href)) {
			 var href=true;
		 	//ajax 验证是否为链接
			// $.ajax({
		        // type: "GET",
		        // cache: false,
		        // url: pro_href,
		        // data: "",
		        // success: function() {
		            // var href=1;
		        // },
		        // error: function() {
		            // var href=false;
		        // }
		    // });
		}else{
			var href=false;
		}
         var name = $("#name").val();
         var targetmoney = $("#targetmoney").val();
		 
		 var changemonety = true;
		 
		 /* var reg=/(^[1-9]{0,9}$)/; */
		 
			if(!id){
				$('#tip-error span').html('请选择请选择收货地址');
				$('#tip-error').show();
				setTimeout(function(){$('#tip-error').fadeOut(500);},1000);
			}else if(name == false){
				$('#tip-error span').html('请填写项目标题');
				$('#tip-error').show();
				setTimeout(function(){$('#tip-error').fadeOut(500);},1000);
				$("#name").focus();
			}else if(targetmoney == false){
				$('#tip-error span').html('请填写筹资金额');
				$('#tip-error').show();
				setTimeout(function(){$('#tip-error').fadeOut(500);},1000);
				$("#targetmoney").focus();
			}else if(targetmoney < 100){
				$('#tip-error span').html('筹资金额不小于100元');
				targetmoney= false;
				$('#tip-error').show();
				setTimeout(function(){$('#tip-error').fadeOut(500);},1000);
				$("#targetmoney").focus();
			}else if(href==false){
				$('#tip-error span').html('商品链接必须以“http”开头，请检查是否正确');
				$('#tip-error').show();
				setTimeout(function(){$('#tip-error').fadeOut(500);},2000);
				$("#pro_href").focus();
			}else if(area == false){
				$('#tip-error span').html('请填写筹款目的');
				$('#tip-error').show();
				setTimeout(function(){$('#tip-error').fadeOut(500);},1000);
				$("#xjtextarea").focus();
			}else if( name != false  && targetmoney != false && area != false ){
				$.post("/project/pdmoney",{money:targetmoney},function(result){
					if (result) {
						$("input[name='term_id']").val(result);
						$("#form").submit();
					}else{
						changemonety = false;
						$('#tip-error span').html('您目前只能发布'+ <?= $userinfo['tmoney']; ?> +'元以下的项目');
						$('#tip-error').show();
						setTimeout(function(){$('#tip-error').fadeOut(500);},1000);
						$("#targetmoney").focus();
					}
				});
			}
		});
	});
</script>
<script type="text/javascript">
	(function () {
		var viewImg = $("#dd");
		var imgurl = '';
		var imgcount = 0;
		$('#doc').localResizeIMG({
			width: 0,
			quality: 1,
			success: function (result) {
				var status = true;
				if (result.height > 1600) {
					status = false;
					alert("照片最大高度不超过1600像素");
				}
				if (viewImg.find("li").length > 3) {
					status = false;
					alert("最多上传4张照片");
				}
				if (status) {
					viewImg.append('<li><span class="pic_time"><span class="p_img"></span><em>50%</em></span></li>');
					viewImg.find("li:last-child").html('<span class="del"></span><img class="wh60" src="' + result.base64 + '"/><input type="hidden" id="doc'
					+ imgcount + '" name="Product[img][]" value="' + result.clearBase64 + '">');
					$(".del").on("click",function(){
						$(this).parent('li').remove();
						$("#doc").show();
					});
					imgcount++;
				}
			}
		});
	})();



	
</script>
</body>
</html>