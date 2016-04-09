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
	<title>收货地址</title>
	<?= Html::cssFile('@web/style/css/font-awesome.min.css') ?>
	<?= Html::cssFile('@web/style/css/reset.css') ?>
	<?= Html::cssFile('@web/style/css/style.css') ?>
</head>
<body>
	<section class="bodyA"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/u0.gif" alt=""></section>
	<div id="body_h" class="bgeee">
		<section class="pagetop">
			<a class="pagetopleft" href="javascript:history.go(-1)"><i class='icon-angle-left'></i></a>
			<h2>收货地址</h2>
			<a class="pagetopright formok-btn">完成</a>
		</section>
		<section class="headerh"></section>
		<section class="modular7">
			<form action="" method="post" id="ok">
				<input type="hidden" value="<?php echo !empty($_GET['id'])?$_GET['id']:0; ?>" name="id">
				<div class="modular7-con">
					<div class="twoelement">
						<p class="fixedelement2">收件人</p>
						<input id="name" type="text" class="changeelement" name="name" value="<?php echo $info['username']; ?>">
						<i class="rigd rigdx icon-remove hide"></i>
					</div>
					<div class="twoelement">
						<p class="fixedelement2">手机号</p>
						<input type="text" class="changeelement" name="phone" value="<?php echo $info['phone']; ?>">
					</div>
					<div class="twoelement">
						<p class="fixedelement2">所在省份</p>
						<select id="s_province" class="changeelement" name="s_province"></select>
						<i class="rigd icon-chevron-right"></i>
					</div>
					<div class="twoelement">
						<p class="fixedelement2">所在城市</p>
					    <select id="s_city" class="changeelement" name="s_city" ></select>  
						<i class="rigd icon-chevron-right"></i>
					</div>
					<div class="twoelement">
						<p class="fixedelement2">所在地区</p>
					    <select id="s_county" class="changeelement" name="s_county"></select>
						<i class="rigd icon-chevron-right"></i>
					</div>
				    
					<div class="twoelement haveborder nobor">
						<p class="fixedelement2">详细地址</p>
						<textarea class="changeelement" name="addressdetail" rows="2"><?php echo $info['address']; ?></textarea> 
					</div>	
				</div>
				<div class="modular6">
					<p class="form-ok"><input class="resetform bgfeb528-wf" name="formok-btn" type="button" value="删除" id="godie"></p>
				</div>
			</form>
		</section>
	</div>
	<p id="tip-error"><span>表单验证错误信息</span></p>
<?= Html::jsFile('@web/style/js/jquery-2.1.1.min.js') ?>
<?= Html::jsFile('@web/style/js/reset.js') ?>
<?= Html::jsFile('@web/style/js/area.js') ?>
<script>
var s=["s_province","s_city","s_county"];//三个select的name
var opt0 = ["<?php echo $info['province']; ?>","<?php echo $info['city']; ?>","<?php echo $info['county']; ?>"];//初始值
function _init_area(){  //初始化函数
	for(i=0;i<s.length-1;i++){
	  document.getElementById(s[i]).onchange=new Function("change("+(i+1)+")");
	}
	change(0);
}
</script>
<script>
	$(document).ready(function(){
		var UA=window.navigator.userAgent;  //使用设备
		var CLICK="click";
		if(/ipad|iphone|android/.test(UA)){   //判断使用设备
			CLICK="tap";
		};
		_init_area();
		var Gid  = document.getElementById ;
		var showArea = function(){
			Gid('show').innerHTML = "<h3>省" + Gid('s_province').value + " - 市" + 	
			Gid('s_city').value + " - 县/区" + 
			Gid('s_county').value + "</h3>"
		}
		// Gid('s_county').setAttribute('onchange','showArea()');
		$(".formok-btn").click(function(event){
			event.preventDefault();
			var phone=$("input[name='phone']").val();
			var name=$("input[name='name']").val();
			var s_province=$("#s_province").val();
			var s_city=$("#s_city").val();
			var s_county=$("#s_county").val();
			var addressdetail=$("textarea[name='addressdetail']").val();
			reg=/(^[1][358][0-9]{9}$)/;
			if(!reg.test(phone)){
				$('#tip-error span').html('请正确输入手机号');
				$('#tip-error').show();
				setTimeout(function(){
					$('#tip-error').fadeOut(500);
				},1000);
				$("input[name='phone']").focus();
			}else if(!name){
				$('#tip-error span').html('请输入收件人姓名');
				$('#tip-error').show();
				setTimeout(function(){
					$('#tip-error').fadeOut(500);
				},1000);
				$("input[name='name']").focus();
			}else if(!s_province){
				$('#tip-error span').html('请选择省份');
				$('#tip-error').show();
				setTimeout(function(){
					$('#tip-error').fadeOut(500);
				},1000);
				$("input[name='s_province']").focus();
			}else if(!s_city){
				$('#tip-error span').html('请选择城市');
				$('#tip-error').show();
				setTimeout(function(){
					$('#tip-error').fadeOut(500);
				},1000);
				$("input[name='s_city']").focus();
			}else if(!s_county){
				$('#tip-error span').html('请选择地区');
				$('#tip-error').show();
				setTimeout(function(){
					$('#tip-error').fadeOut(500);
				},1000);
				$("input[name='s_county']").focus();
			}else if(!addressdetail){
				$('#tip-error span').html('请输入地址');
				$('#tip-error').show();
				setTimeout(function(){
					$('#tip-error').fadeOut(500);
				},1000);
				$("input[name='addressdetail']").focus();
			}else{
				$("#ok").submit();
			}
		});
		$(".resetform")[CLICK](function(){
			$(".rigdx").hide();
		});
		$("#name").change(function(){
			$(this).next("i").show();
			$(this).css("background-color","#fff");
		});
		$(".rigd")[CLICK](function(){
			$(this).hide();
			$(this).siblings("#name").val("");
		});
		$(".bodyA").hide();
		$("#godie").click(function(){
			var id = <?php echo !empty($_GET['id'])?$_GET['id']:0; ?>;
			$.post("/address/godie",{id:id},function(result){
				if(result == "1"){
					$('#tip-error span').html('删除成功');
					$('#tip-error').show();
					setTimeout(function(){
						$('#tip-error').fadeOut(500);
					},1000);
					location.href = "/address/receiptaddaddress2";
				}else{
					$('#tip-error span').html('服务器繁忙，请稍后再试');
					$('#tip-error').show();
					setTimeout(function(){
						$('#tip-error').fadeOut(500);
					},1000);
				}
			});
		});
	})
wx.config({
    debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
    appId: 'wxb61ae4d58c99a3ea', // 必填，公众号的唯一标识
    timestamp: <?php echo time(); ?>, // 必填，生成签名的时间戳
    nonceStr: 'bingbingzm', // 必填，生成签名的随机串
    signature: '',// 必填，签名，见附录1
    jsApiList: [
    'onMenuShareTimeline',
    'onMenuShareAppMessage',
    ] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
});
wx.hideOptionMenu([
	
	]);
</script>
</body>
</html>