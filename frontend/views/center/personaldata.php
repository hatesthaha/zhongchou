<?php
use yii\helpers\Html;
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
	<title>个人资料</title>
	<?= Html::cssFile('@web/style/css/font-awesome.min.css') ?>
	<?= Html::cssFile('@web/style/css/reset.css') ?>
	<?= Html::cssFile('@web/style/css/style.css') ?>

<style>
.peosonalheaimg{
	height:2.5rem;
}
#dd{
	position: absolute;
    right: 10px;
    width: 2.7rem;
    border-radius: 50%;
    height: 2.7rem;
    top: 2px;
}
.modular16-con li{
	padding:0;
	border:0;
	position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
}
.wh60{
    width: 100%;
	height:100%;
}
.changeelement{
   text-align: right;
   color:#000;
   z-index: 10;
   
}
placeholder{
	color:#000;
}
.ddd2{
	
}
.dtupi{
	
}
</style>
</head>
<body>
	<section class="bodyA"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/u0.gif" alt=""></section>
	<div id="body_h" class="bgeee">
		<section class="pagetop">
			<a class="pagetopleft" onclick="history.go(-1)"><i class='icon-angle-left'></i></a>
			<h2>个人资料</h2>
			<a class="pagetopright formok-btn" href="/"></a>
		</section>
		<section class="headerh"></section>
		<section class="modular16">
			<form action="/center/editinformation" method="post">
				<div class="modular16-con">
				
					<div class="twoelement">
						<p class="fixedelement2">头像</p>
					    <p class="changeelement boxtext-r">
					    <?php if(!empty($userinfo['head'])){?>
					    <img class="peosonalheaimg" src="<?= Yii::getAlias('@web') . '/' ?>upload/<?= $userinfo['head']; ?>" alt="头像">
					    <?php }else{?>
					    <img class="peosonalheaimg" src="<?= Yii::getAlias('@web') . '/' ?>style/images/header-img.jpg" alt="头像">
					    <?php } ?>

					    <a ><input class="smallimginput"/></a></p>
						<p class="changeelement  boxtext-r phoneaddimg ddd2">
							<img width="100%" height="100%"  class="dtupi" src="<?= Yii::getAlias('@web') . '/' ?>style/images/phoneaddimg.png" alt=""><input type="file" id="doc" name="Member[head]" id="fileField">
						</p>
						<ul class="clearfix" id="dd">
										</ul>
					</div>		
					
					
					<div class="twoelement">
						<p class="fixedelement2">昵称</p>
					    <p class="changeelement boxtext-r text-r" style="padding:0 1rem;"><a ><input class="changeelement" type="text" id="username" name="username" placeholder="输入您的昵称" value="<?= $userinfo['name']?>"></a></p>
					</div>
					<div class="twoelement">
						<p class="fixedelement2">性别</p>
					    <p class="changeelement boxtext-r text-r" style="padding:0 1rem;">
						<a>
						   <select name="gender" id="gender" style="width:100%;display:block;direction: rtl;padding:0;color:#bbbbbb;">
								<option value="<?php echo $userinfo['gender']; ?>"><?php if($userinfo['gender'] == "1"){echo "男";}elseif($userinfo['gender'] == "2"){echo "女";}else{echo "请输入您的性别";}?></option>
								<option value="1">男</option>
								<option value="2">女</option>
								<option value="3">保密</option>
							</select>
						</a></p>
					</div>
					
					<div class="twoelement">
						<p class="fixedelement2">手机</p>
					    <p class="changeelement boxtext-r text-r" style="padding:0 1rem;"><a  href="/center/infophone" style="color:#bbbbbb;"><?php echo substr($userinfo['phone'],0,3); ?>****<?php echo substr($userinfo['phone'],7,4); ?></a><i class="rigd icon-angle-right"></i></p>
					</div>
					<div class="twoelement">
						<p class="fixedelement2">邮箱</p>
					    <p class="changeelement boxtext-r text-r" style="padding:0 1rem;"><a><input class="changeelement" type="text" name="email" placeholder="请输入您的邮箱" value="<?php echo $userinfo['email']; ?>"></a></p>
					</div>
				</div>
				<div class="modular16-con">
					<div class="twoelement">
						<p class="fixedelement2">个性签名</p>					    
					</div>
					<div style="padding: 0 2rem;">
						  <textarea name="editinformation" placeholder="限制输入24个汉字" rows="5" maxlength="50" style="width:98%;border:0;margin-top:1rem;"><?php echo $userinfo['signature']; ?></textarea>
						</div>
<!-- 					<div class="twoelement">
						<p class="fixedelement2">修改密码</p>
					    <p class="changeelement boxtext-r text-r" style="padding:0 1rem;"><a href="/center/infopassword" class="wid100db">&nbsp;</a><i class="rigd icon-angle-right"></i></p>
					</div> -->
				</div>
				<p class="form-ok"><input class="formok-btn bgfeb528-wf" name="formok-btn" type="submit" value="确认"></p>
<!-- 				<div class="modular6">
					<p class="form-ok"><input class="resetform bgfeb528-wf" name="formok-btn" type="button" value="安全退出" id="quit"></p>
				</div> -->
			</form>
		</section>
	</div>
	<p id="tip-error"><span>表单验证错误信息</span></p>
	
    <?= Html::jsFile('@web/style/js/jquery-2.1.3.min.js') ?>
	
	<?= Html::jsFile('@web/style/js/localResizeIMG2.js') ?>
	<?= Html::jsFile('@web/style/js/mobileBUGFix.mini.js') ?>
    <?= Html::jsFile('@web/style/js/reset.js') ?>


<script type="text/javascript">
    (function () {
        var viewImg = $("#dd");
        var imgurl = '';
        var imgcount = 0;
        $('#doc').localResizeIMG({
            width: 80,
            quality: 1,
            success: function (result) {
                var status = true;
                if (result.height > 100) {
                    status = false;
                    alert("照片最大高度不超过1600像素");
                }
                
                if (status) {
                    viewImg.append('<li><span class="pic_time"><span class="p_img"></span><em>50%</em></span></li>');
                    viewImg.find("li:last-child").html('<span class="del"></span><img class="wh60" src="' + result.base64 + '"/><input type="hidden" class="cstp" id="doc' + imgcount + '" name="Member[head][]" value="' + result.clearBase64 + '">');
					 var submitData={
						base64_string:result.clearBase64, 
						//'crsrf':'<?php echo yii::$app->getRequest()->getCsrfToken(); ?>',
					}; 
					$(".peosonalheaimg").remove();
					$.ajax({
					   type: "POST",
					   url: "/center/infohead",
					   data: submitData,
					   dataType:"json",
					   success: function(data){
							if(data==0){
								$('#tip-error span').html('服务器繁忙，稍后重试');
								$('#tip-error').show();
								setTimeout(function(){
									$('#tip-error').fadeOut(500);
								},1000);
							}else if(data==1){
								$('#tip-error span').html('头像成功上传');
								$('#tip-error').show();
								setTimeout(function(){
									$('#tip-error').fadeOut(500);
								},1000);
							}
					   }, 
						error:function(){ //上传失败 
						   $('#tip-error span').html('服务器繁忙，稍后重试');
							$('#tip-error').show();
							setTimeout(function(){
								$('#tip-error').fadeOut(500);
							},1000);
						}
					});
                    $(".del").on("click",function(){
                        $(this).parent('li').remove();
                        $("#doc").show();
                    });
                    imgcount++;
                }
            }
        });
    })();
		$(".formok-btn").click(function(event){
			event.preventDefault();
			var editinformation=$("textarea[name='editinformation']").val();
			if(editinformation.length > 14){
				$('#tip-error span').html('个签长度不符合规范');
				$('#tip-error').show();
				setTimeout(function(){
					$('#tip-error').fadeOut(500);
				},1000);
				$("textarea[name='editinformation']").focus();
			}else{
				$.ajax({
					   type: "POST",
					   url: "/center/editinformation",
					   data: {'editinformation':editinformation},
					   dataType:"json",
					   success: function(data){
							if(data==0){
								$('#tip-error span').html('服务器繁忙，稍后重试');
								$('#tip-error').show();
								setTimeout(function(){
									$('#tip-error').fadeOut(500);
								},1000);
							}else if(data==1){
								$('#tip-error span').html('修改成功');
								$('#tip-error').show();
								setTimeout(function(){
									$('#tip-error').fadeOut(500);
								},1000);
							}
					   }, 
						error:function(){ //上传失败 
						   $('#tip-error span').html('服务器繁忙，稍后重试');
							$('#tip-error').show();
							setTimeout(function(){
								$('#tip-error').fadeOut(500);
							},1000);
						}
					});
			}
		});
		$(".bodyA").hide();
</script>
<script>
	$(document).ready(function(){
		$('input[name=username]').change(function() { 
			var name=$("input[name='username']").val();
			 if(name.length > 10 || name.length==0){
				$('#tip-error span').html('昵称长度不合法');
				$('#tip-error').show();
				setTimeout(function(){
					$('#tip-error').fadeOut(500);
				},1000);
				$("input[name='username']").focus();
			}else{
				$.ajax({
					   type: "POST",
					   url: "/center/infoname",
					   data: {'name':name},
					   dataType:"json",
					   success: function(data){
							if(data==0){
								$('#tip-error span').html('服务器繁忙，稍后重试');
								$('#tip-error').show();
								setTimeout(function(){
									$('#tip-error').fadeOut(500);
								},1000);
							}else if(data==1){
								$('#tip-error span').html('昵称修改成功');
								$('#tip-error').show();
								setTimeout(function(){
									$('#tip-error').fadeOut(500);
								},1000);
							}
					   }, 
						error:function(){ //上传失败 
						   $('#tip-error span').html('服务器繁忙，稍后重试');
							$('#tip-error').show();
							setTimeout(function(){
								$('#tip-error').fadeOut(500);
							},1000);
						}
					});
			}
			
		});
		
		//性别改变
		$('select[name=gender]').change(function() { 
			var gender=$("select[name='gender']").val();
			 if(gender!=1 && gender!=2 && gender!=3 ){
				$('#tip-error span').html('性别出错');
				$('#tip-error').show();
				setTimeout(function(){
					$('#tip-error').fadeOut(500);
				},1000);
				$("select[name='gender']").focus();
			}else{
				$.ajax({
					   type: "POST",
					   url: "/center/infosex",
					   data: {'gender':gender},
					   dataType:"json",
					   success: function(data){
							if(data==0){
								$('#tip-error span').html('服务器繁忙，稍后重试');
								$('#tip-error').show();
								setTimeout(function(){
									$('#tip-error').fadeOut(500);
								},1000);
							}else if(data==1){
								$('#tip-error span').html('性别修改成功');
								$('#tip-error').show();
								setTimeout(function(){
									$('#tip-error').fadeOut(500);
								},1000);
							}
					   }, 
						error:function(){ //上传失败 
						   $('#tip-error span').html('服务器繁忙，稍后重试');
							$('#tip-error').show();
							setTimeout(function(){
								$('#tip-error').fadeOut(500);
							},1000);
						}
					});
			}
			
		});
		
		
		//邮箱
		$('input[name=email]').change(function() { 
			var email=$("input[name='email']").val();
			 if(!email){
				$('#tip-error span').html('请输入您的邮箱');
				$('#tip-error').show();
				setTimeout(function(){
					$('#tip-error').fadeOut(500);
				},1000);
				$("input[name='email']").focus();
			}else if(email.length > 50){
				$('#tip-error span').html('邮箱过长');
				$('#tip-error').show();
				setTimeout(function(){
					$('#tip-error').fadeOut(500);
				},1000);
				$("input[name='email']").focus();
			}else{
				$.ajax({
					   type: "POST",
					   url: "/center/infoemail",
					   data: {'email':email},
					   dataType:"json",
					   success: function(data){
							if(data==0){
								$('#tip-error span').html('服务器繁忙，稍后重试');
								$('#tip-error').show();
								setTimeout(function(){
									$('#tip-error').fadeOut(500);
								},1000);
						   }else if(data==2){
							   $('#tip-error span').html('邮箱已存在，请重试');
								$('#tip-error').show();
								setTimeout(function(){
									$('#tip-error').fadeOut(500);
								},1000);
						   }
						   else if(data==1){
								$('#tip-error span').html('邮箱修改成功');
								$('#tip-error').show();
								setTimeout(function(){
									$('#tip-error').fadeOut(500);
								},1000);
							}
					   }, 
						error:function(){ //上传失败 
						   $('#tip-error span').html('服务器繁忙，稍后重试');
							$('#tip-error').show();
							setTimeout(function(){
								$('#tip-error').fadeOut(500);
							},1000);
						}
					});
			}
			
		});
		
		
		
		
		$(".formok-btn").click(function(event){
			event.preventDefault();
			// var name=$("input[name='username']").val();
			// var sex=$("select[name='sex']").val();
			// var email=$("input[name='email']").val();
			var editinformation=$("textarea[name='editinformation']").val();
			if(editinformation.length > 24){
				$('#tip-error span').html('个签长度不符合规范');
				$('#tip-error').show();
				setTimeout(function(){
					$('#tip-error').fadeOut(500);
				},1000);
				$("textarea[name='editinformation']").focus();
			}else{
				$("#post").submit();
			}
			return;
			reg=/(^[1][358][0-9]{9}$)/;
			if(!name){
				$('#tip-error span').html('请输入您的昵称');
				$('#tip-error').show();
				setTimeout(function(){
					$('#tip-error').fadeOut(500);
				},1000);
				$("input[name='emailorphone']").focus();
			}else if(name.length > 10){
				$('#tip-error span').html('昵称过长');
				$('#tip-error').show();
				setTimeout(function(){
					$('#tip-error').fadeOut(500);
				},1000);
				$("input[name='emailorphone']").focus();
			}else{
				$(this).parents("form").submit();
			}
			if(!sex){
				$('#tip-error span').html('请选择性别');
				$('#tip-error').show();
				setTimeout(function(){
					$('#tip-error').fadeOut(500);
				},1000);
				$("select[name='sex']").focus();
			}else{
				$(this).parents("form").submit();
			}
			
			if(!email){
				$('#tip-error span').html('请输入您的邮箱');
				$('#tip-error').show();
				setTimeout(function(){
					$('#tip-error').fadeOut(500);
				},1000);
				$("input[name='email']").focus();
			}else if(email.length > 50){
				$('#tip-error span').html('邮箱过长');
				$('#tip-error').show();
				setTimeout(function(){
					$('#tip-error').fadeOut(500);
				},1000);
				$("input[name='email']").focus();
			}else{
				$.post("/register/checkemail",{email:email},function(result){
					if(result == "1"){
						$("#form").submit();
					}else{
						$('#tip-error span').html('此邮箱已被绑定，请更换重试');
						$('#tip-error').show();
						setTimeout(function(){$('#tip-error').fadeOut(500);},1000);
					}
				});
			}
			
			
			if(editinformation.length > 14){
				$('#tip-error span').html('个签长度不符合规范');
				$('#tip-error').show();
				setTimeout(function(){
					$('#tip-error').fadeOut(500);
				},1000);
				$("textarea[name='editinformation']").focus();
			}else{
				$("#post").submit();
			}
			
			
			
			
		});
		$(".bodyA").hide();
	})
</script>





<script>
	$(document).ready(function(){
	var UA=window.navigator.userAgent;  //使用设备
	var CLICK="click";
	if(/ipad|iphone|android/.test(UA)){   //判断使用设备
		CLICK="tap";
	};
	$(".bodyA").hide();
	$("#quit").click(function(){
		location.href = "/center/quit";
	})
	})
</script>
</body>
</html>