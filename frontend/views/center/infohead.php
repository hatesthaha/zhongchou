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
	<title>编辑头像</title>
	<?= Html::cssFile('@web/style/css/font-awesome.min.css') ?>
	<?= Html::cssFile('@web/style/css/reset.css') ?>
	<?= Html::cssFile('@web/style/css/style.css') ?>
	<?= Html::jsFile('@web/style/js/jquery-2.1.3.min.js') ?>
	
	<?= Html::jsFile('@web/style/js/localResizeIMG2.js') ?>
	<?= Html::jsFile('@web/style/js/mobileBUGFix.mini.js') ?>

</head>
<body>
	<section class="bodyA"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/u0.gif" alt=""></section>
	<div id="body_h">
		<section class="pagetop">
			<a class="pagetopleft" href="/center/personaldata"><i class='icon-angle-left'></i></a>
			<h2>编辑头像</h2>
			<a class="pagetopright" href="/"></a>
		</section>
		<section class="headerh"></section>
		<section class="modular8">
			<form action="" method="post" enctype='multipart/form-data'>
				<div class="modular34con4">
					<div id="mould-34list2" class="modular34con4con modular34con4con2">
						<li>
							<p class="phoneaddimg">
								<img width="100%" height="100%" src="<?= Yii::getAlias('@web') . '/' ?>style/images/phoneaddimg.png" alt=""><input type="file" id="doc" name="Member[head]" id="fileField">
							</p>
						</li>
					</div>
					<div class="xjclass3">
						<ul class="clearfix" id="dd">
						</ul>
					</div>
				</div>
				<p class="form-ok"><input class="formok-btn bgfeb528-wf" name="formok-btn" type="submit" value="确认"></p>
			</form>
		<br /><p style="font-size:12px;color:#666;">*只能上传格式为jpg,jpeg,png的图片</p>
		</section>
	</div>
	<p id="tip-error"><span>表单验证错误信息</span></p>
<?= Html::jsFile('@web/style/js/reset.js') ?>
<script>
	$(document).ready(function(){
		$(".formok-btn").click(function(event){
			event.preventDefault();
			var img=$("#img0").attr("src");
			var s = img.indexOf("blob");
			if(s < 0){
				$('#tip-error span').html('请选择新头像或直接返回');
				$('#tip-error').show();
				setTimeout(function(){
					$('#tip-error').fadeOut(500);
				},1000);
				$("select[name='sex']").focus();
			}else{
				$(this).parents("form").submit();
			}
		});
		$(".bodyA").hide();
	})
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
                if (viewImg.find("li").length > 0) {
                    status = false;
                    alert("最多上传1张照片");
                }
                if (status) {
                    viewImg.append('<li><span class="pic_time"><span class="p_img"></span><em>50%</em></span></li>');
                    viewImg.find("li:last-child").html('<span class="del"></span><img class="wh60" src="' + result.base64 + '"/><input type="hidden" class="cstp" id="doc' + imgcount + '" name="Member[head][]" value="' + result.clearBase64 + '">');
                    var submitData={
						base64_string:result.clearBase64, 
						//'crsrf':'<?php echo yii::$app->getRequest()->getCsrfToken(); ?>',
					}; 
					$.ajax({
					   type: "POST",
					   url: "/center/infohead",
					   data: submitData,
					   dataType:"json",
					   success: function(data){
							alert(data);
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
			var img=$(".cstp").val();
			if(!img){
				$('#tip-error span').html('请选择头像');
				$('#tip-error').show();
				setTimeout(function(){
					$('#tip-error').fadeOut(500);
				},1000);
			}else{
				$(this).parents("form").submit();
			}
		});
		$(".bodyA").hide();
</script>
</body>
</html>