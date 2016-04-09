<?php 
use yii\helpers\Html;
use yii\helpers\Url;
$this->title="订单信息";
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
	<div id="body_h" class="bgeaeaea">
		<section class="pagetop">
			<a class="pagetopleft" href="javascript:history.go(-1)"><i class='icon-angle-left'></i></a>
			<h2>订单信息</h2>
			<a class="pagetopright" href="/"></a>
		</section>
		<section class="headerh"></section>
		<section class="modular15">
			<p class="modular15-titi"><?php if ($product['term_id'] == 7) {echo "购买声望"; } else {echo '帮他圆梦';}?><span>（已<?= isset($product['s_num'])?$product['s_num']:0 ?>人<?php if ($product['term_id'] == 7) {echo "购买"; } else {echo '支持';}?>）</span></p>
			<div class="modular15-con clearfix">
				<ul class="clearfix">
					<li>
						<a class="current1" id='1' href=""><span>￥1</span></a>
					</li>
					<li>
						<a id='5' href=""><span>￥5</span></a>
					</li>
					<li>
						<a id='10' href=""><span>￥10</span></a>
					</li>
					<li>
						<a id='30' href=""><span>￥30</span></a>
					</li>
					<li>
						<a id='50' href=""><span>￥50</span></a>
					</li>
					<li>
						<a id='100' href=""><span>￥100</span></a>
					</li>
				</ul>
			</div>
		</section>
		<section class="modular15">
			<p class="modular15-titi">自定义金额</p>
			<div class="modular15-con">
				<textarea id="zdy" name="custom" rows="1" placeholder="请输入整数金额"></textarea> 
			</div>
		</section>
		<?php if ($product['term_id'] != 7) { ?>
		<section class="modular15">
			<p class="modular15-titi">寄语</p>
			<div class="modular15-con">
				<textarea name="information" rows="1" placeholder="选填：请输入捐赠寄语"></textarea> 
			</div>
		</section>
		<?php } ?>
		<div>
			<p class="nextlinkpage">
				<a class="bgfeb528-wf" href="javascript:tijiao();">立即提交</a>
			</p>
		</div>
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
	    };
		$(".modular15-con ul li a")[CLICK](function(event){
	        event.preventDefault();
	        $(".modular15-con ul li a").removeClass("current1");
			$(this).addClass("current1");
			$("#zdy").val('');
		})
		$(".bodyA").hide();
	});
	function tijiao(){
		var jine=$(".current1").attr('id');
		var info=$("textarea[name='information']").val();
		var zdy = $("textarea[name='custom']").val();
		if(!isNaN(zdy) && zdy >0){
			jine = zdy;
			
			if (typeof(jine.toString().split(".")[1])!=='undefined' && jine.toString().split(".")[1].length >0){
				$('#tip-error span').html('您输入的金额不合法');
				$('#tip-error').show();
				setTimeout(function(){$('#tip-error').fadeOut(500);},1000);
				return;
			}
		}
		
		 $.post("<?= Url::to(['order/xiadan'])?>",
		  {
		    'jine':jine,
		    'info':info,
		    'pid':<?= $product['id'] ?>,
		    'id':<?= $member_id; ?>,
		    '_csrf':'<?php echo yii::$app->request->getCsrfToken();?>'
		  },
		  function(respond){
		  	var res=JSON.parse(respond);
		  	if(res.status==1){
		  		//成功下单，进入支付页
		  		location.href='/pay/payinformation/?pid='+res.pid+'&jine='+res.jine+'&oid='+res.order_num;
		  	}else if(res.status==2){
		  		location.href='<?= Url::to(['register/signin']) ?>';
		  	}else if(res.status==3){
				$('#tip-error span').html('不能购买自己的产品');
				$('#tip-error').show();
				setTimeout(function(){$('#tip-error').fadeOut(500);},1000);
		  	}else if(res.status==4){
				$('#tip-error span').html('您输入的金额不合法');
				$('#tip-error').show();
				setTimeout(function(){$('#tip-error').fadeOut(500);},1000);
		  	}else{
				$('#tip-error span').html('服务器繁忙，请稍后重试');
				$('#tip-error').show();
				setTimeout(function(){$('#tip-error').fadeOut(500);},1000);
		  	}
		  });
	}
</script>
</body>
</html>