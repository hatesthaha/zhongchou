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
			<p class="modular15-titi">我要众筹<span>（已<?= isset($product['total_money'])?$product['total_money']:0 ?>人支持,剩余 <?php $num = $product['target_money'] - $product['total_money']; echo $num; ?> 人次）</span></p>
			<div class="modular34con1">
				<a class="modular34con1word" href="/address/chooseaddress/?type=yy&pid=<?= empty($product['id'])?$_GET['pid']:$product['id'] ?>">
					<div>
						<div>
						<?php if(!empty($noadd)): ?>
							请选择收货地址
						<?php else: ?>
							<p class="clearfix text-r"><span class="float-left">收货人：<?= $address['username']; ?></span><span class="modular17-cond"><?= $address['phone']; ?></span></p>
							<p class="modular17-cond">收货地址：<?= $address['province']; ?><?= $address['city']; ?><?= $address['county']; ?><?= $address['address']; ?></p>
						<?php endif ?>
						</div>
					</div>
					<p><i class="icon-angle-right"></i></p>
				</a>
			</div>
			<div class="modular15-con clearfix">
				<div style="height:40px;line-height:40px;">
					<span style="display:block;float:left;">众筹：</span>

					<span style="margin-top:5px; cursor: pointer;display: block;float:left; width: 27px;height: 27px;background: url(<?= Yii::getAlias('@web') . '/' ?>style/images/button_03.jpg) no-repeat;border: 1px solid #ddd;" onclick="cutBuyTimes()"></span>

					<input style="margin-top:5px; width: 119px;height: 27px;text-align: center;border: 1px solid #ddd;color: #333;outline: none;display:block;float:left;" type="text" name="money" onkeyup="bugTimesInput();this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'');" value="1" min="1" max="<?= $num; ?>" maxlength="7">

					<span style="margin-top:5px; cursor: pointer;display: block;float:left; width: 27px;height: 27px;background: url(<?= Yii::getAlias('@web') . '/' ?>style/images/button_05.jpg) no-repeat;border: 1px solid #ddd;" onclick="addBuyTimes()"></span>

				</div>

			</div>
		</section>
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
		})
		$(".bodyA").hide();
	});
	function bugTimesInput(){
		var money = $("input[name='money']").val();
		var max = <?= $num; ?>;
		if(money > max){
			$("input[name='money']").val(max);
		}
	}
	function addBuyTimes(){
		var money = $("input[name='money']").val();
		var max = <?= $num; ?>;
		if(money >= max){
			$("input[name='money']").val(max);
		}else{
			$("input[name='money']").val(parseInt(money)+1);
		}
	}
	function cutBuyTimes(){
		var money = $("input[name='money']").val();
		if(money <= 0){
			$("input[name='money']").val(0);
		}else{
			$("input[name='money']").val(money-1);
		}
	}
	function tijiao(){
		var jine=$("input[name='money']").val();
		if(jine <= 0){
			$('#tip-error span').html('请输入大于0的正整数');
			$('#tip-error').show();
			setTimeout(function(){$('#tip-error').fadeOut(500);},1000);
			return false;
		}
		<?php if(empty($_GET['id'])): ?>
			$('#tip-error span').html('请选择收货地址');
			$('#tip-error').show();
			setTimeout(function(){$('#tip-error').fadeOut(500);},1000);
			return false;
		<?php endif ?>

		 $.post("<?= Url::to(['order/xiadanyy'])?>",
		  {
		    'jine':jine,
		    'pid':<?= empty($product['id'])?$_GET['pid']:$product['id'] ?>,
		    'id':<?= $member_id; ?>,
		    <?php if(!empty($_GET['id'])): ?>
		    'aid':<?= $_GET['id']; ?>,
		    <?php endif ?>
		    '_csrf':'<?php echo yii::$app->request->getCsrfToken();?>'
		  },
		  function(respond){
		  	var res=JSON.parse(respond);
		  	if(res.status==1){
		  		//成功下单，进入支付页
		  		location.href='/pay/payinformation/?pid='+res.pid+'&jine='+res.jine+'&oid='+res.order_num;
		  	}else if(res.status==2){
		  		location.href='<?= Url::to(['register/signin']) ?>';
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