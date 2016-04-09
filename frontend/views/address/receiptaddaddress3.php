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
			<form action="" method="post">
				<div class="modular7-con">
					<div class="twoelement">
						<p class="fixedelement2">收件人</p>
						<input id="name" type="text" class="changeelement" name="name" value="">
						<i class="rigd rigdx icon-remove hide"></i>
					</div>
					<div class="twoelement">
						<p class="fixedelement2">手机号</p>
						<input type="text" class="changeelement" name="phone">
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
						<textarea class="changeelement" name="addressdetail" rows="3"></textarea>
					</div>
				</div>
			</form>
		</section>
	</div>
	<p id="tip-error"><span>表单验证错误信息</span></p>
<?= Html::jsFile('@web/style/js/jquery-2.1.1.min.js') ?>
<?= Html::jsFile('@web/style/js/reset.js') ?>
<?= Html::jsFile('@web/style/js/area.js') ?>
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
		var name=$("input[name='name']").val();
		var phone=$("input[name='phone']").val();
		var s_province=$("#s_province").val();
		var s_city=$("#s_city").val();
		var s_county=$("#s_county").val();
		var addressdetail=$("textarea[name='addressdetail']").val();
		reg=/(^[1][358][0-9]{9}$)/;
		if(!name){
			$('#tip-error span').html('请输入收件人');
			$('#tip-error').show();
			setTimeout(function(){$('#tip-error').fadeOut(500);},1000);
			$("input[name='name']").focus();
		}else if(!reg.test(phone)){
			$('#tip-error span').html('请正确输入手机号');
			$('#tip-error').show();
			setTimeout(function(){$('#tip-error').fadeOut(500);},1000);
			$("input[name='phone']").focus();
		}else if(!s_province){
			$('#tip-error span').html('请选择省份');
			$('#tip-error').show();
			setTimeout(function(){$('#tip-error').fadeOut(500);},1000);
			$("select[name='s_province']").focus();
		}else if(!s_city){
			$('#tip-error span').html('请选择城市');
			$('#tip-error').show();
			setTimeout(function(){$('#tip-error').fadeOut(500);},1000);
			$("select[name='s_city']").focus();
		}else if(!s_county){
			$('#tip-error span').html('请选择地区');
			$('#tip-error').show();
			setTimeout(function(){$('#tip-error').fadeOut(500);},1000);
			$("select[name='s_county']").focus();
		}else if(!addressdetail){
			$('#tip-error span').html('请填写地址');
			$('#tip-error').show();
			setTimeout(function(){$('#tip-error').fadeOut(500);},1000);
			$("textarea[name='addressdetail']").focus();
		}else{
			$("form").submit();
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
	})
</script>
</body>
</html>