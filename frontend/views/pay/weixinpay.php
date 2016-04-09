<?php 
use yii\helpers\Html;
?>
<html>
<head>
    <meta charset="UTF-8">
	<meta content="yes" name="apple-mobile-web-app-capable">
	<meta content="yes" name="apple-touch-fullscreen">
	<meta name="data-spm" content="a215s">
	<meta content="telephone=no,email=no" name="format-detection">
	<meta content="fullscreen=yes,preventMove=no" name="ML-Config">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<meta name="description" content="仌仌众梦" />	
	<title>微信支付</title>
	<?= Html::cssFile('@web/style/css/font-awesome.min.css') ?>
	<?= Html::cssFile('@web/style/css/reset.css') ?>
	<?= Html::cssFile('@web/style/css/style.css') ?>
    <script type="text/javascript">
	//调用微信JS api 支付
	function jsApiCall()
	{
		WeixinJSBridge.invoke(
			'getBrandWCPayRequest',
			<?php echo $jsApiParameters; ?>,
			function(res){
				//alert(res.err_msg);
				WeixinJSBridge.log(res.err_msg);
				window.history.go(-5);
			}
		);
	}

	function callpay()
	{
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
		        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
		    }
		}else{
		    jsApiCall();
		}
	}
	//输出对象
	function writeObj(obj){ 
        var description = ""; 
        for(var i in obj){   
            var property=obj[i];   
            description+=i+" = "+property+"\n";  
        }   
        alert(description); 
    } 
	</script>
	<script type="text/javascript">
	window.onload = function(){
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', editAddress, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', editAddress); 
		        document.attachEvent('onWeixinJSBridgeReady', editAddress);
		    }
		}else{
			editAddress();
		}
	};
	</script>
</head>
<body>
	<section class="bodyA"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/u0.gif" alt=""></section>
	<div id="body_h" class="bgeaeaea">
		<section class="pagetop">
			<a class="pagetopleft" href="javascript:history.go(-1)"><i class='icon-angle-left'></i></a>
			<h2>订单详情</h2>
			<a class="pagetopright" href="/"></a>
		</section>
		<section class="headerh"></section>
		<p style="text-align: center; font-size: 14px;color: #333;margin: 15px 0 0;"><?= $name['name']?></p>
		<p style="text-align: center; font-size: 22px;color: #333;">￥<?= $jine/100 ?></p>
		<p class="clearfix" style="margin:20px 0 15px; background: #fff;border: 1px solid #dcdcdc;line-height: 38px;padding: 0 25px;text-align: right"><span style="float: left">收款方</span>仌仌众梦</p>
		<div>
			<p class="nextlinkpage">
				<a class="bgfeb528-wf" onclick="callpay()">立即支付</a>
			</p>
		</div>
	</div>
    <!-- <br/>
    <p style="text-align: center; font-size: 14px;color: #333;margin: 15px 0 0;">众筹网</p>
		<p style="text-align: center; font-size: 22px;color: #333;">￥<?= $jine/100 ?></p>
		<p class="clearfix" style="margin:20px 0 15px; background: #fff;border: 1px solid #dcdcdc;line-height: 38px;padding: 0 25px;text-align: right"><span style="float: left">收款方</span>众筹网</p>
		
	<div align="center">
		<button style="width:210px; height:50px; border-radius: 15px;background-color:#FE6714; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;" type="button" onclick="callpay()" >立即支付</button>
	</div> -->
<?= Html::jsFile('@web/style/js/jquery-2.1.1.min.js') ?>
<?= Html::jsFile('@web/style/js/reset.js') ?>
<script>
	
	//ISONE =0
	$(document).ready(function(){
		// $(".modular24 li").click(function(event){
		// 	$(".modular24word > div").removeClass("current5");
		// 	$(this).find(".modular24word > div").addClass("current5");
		// 	var zhifu=$(this).find(".modular24word > div").attr('id');
		// 	if (zhifu==4){
		// 		document.getElementById("form1").action="/pay/payconfirm?jine=<?= $jine?>&oid=<?= $oid ?>&pid=<?= $pid ?>";
		// 	}else if(zhifu==3){
		// 		document.getElementById("form1").action="/pay/weixin?jine=<?= $jine?>&oid=<?= $oid ?>&pid=<?= $pid ?>";
		// 	}
		// });
		$(".bgfeb528-wf").click(function(){
			this.disabled='disabled';
			$('#form1').submit();
		})
	});
	$(".bodyA").hide();
	
</script>
</body>
</html>


