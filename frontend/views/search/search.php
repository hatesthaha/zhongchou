<?php
	use yii\helpers\Html;
	use yii\helpers\Url;
	$this->title="搜索";
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
	<div id="body_h" class="bgeee">
		<section class="pagetop pagetopsearch">
			<div>
				<!--<form id='search' action="<?= Url::to(['search/search'])?>" method="post" >-->
					<input class="pagetopsearchinp" type="text" name="search" placeholder="请输入关键字">
				<!--</form>-->
				<a class="pagetopsearchtn">搜索</a>
			</div>
		</section>
		<section class="headerh"></section>
		<section class="modular15 bgfff modular19">
			<p class="modular15-titi">热门搜索</p>
			<div class="modular15-con">
				<ul class="modular19-con1 clearfix">
					<?php if(isset($hot)&&$hot!=""){
						foreach ($hot as $key => $value) { ?>
						<li>
							<a href="<?php echo Url::to(['search/search'])."?content=".$value['name'];?>"><span><?= mb_substr(strip_tags(html_entity_decode($value['name'])),0,6,'utf-8')?></span></a>
						</li>
					<?php }} ?>
				</ul>
			</div>
		</section>
		<section class="modular15 bgfff modular19">
			<p class="modular15-titi">最近搜索</p>
			<div class="modular19-con2">
				<ul class="clearfix">
					<?php if(isset($record_a)&&$record_a!=""){
						foreach ($record_a as $key => $value) { ?>
					<li>
						<p class="modular15-titi"><a href="<?php echo Url::to(['search/search'])."?content=".$value['word'];?>"><?= $value['word'] ?></a><i class="icon-remove" id="<?= $key ?>" ></i></p>
					</li>
					<?php } }?>
				</ul> 
			</div>
		</section>
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
		$(".modular19-con2 .modular15-titi i")[CLICK](function(event){
	        var id=$(this).attr('id');
	        $(this).parents(".modular15-titi").remove();
	         $.get("<?= Url::to(['search/delrecord'])?>?key="+id,function(status){
	         	if(status==1){
	         	}else{
			$('#tip-error span').html('删除记录失败');
			$('#tip-error').show();
			setTimeout(function(){$('#tip-error').fadeOut(500);},1000);
	         	}
			  });
	        // $.post(
	        // 	"<?= Url::to(['search/delrecord'])?>",
	        // 	{
	        // 		key:id
	        // 	},
	        //     function(res){
	        //     	alert(res);
	        //     }
	        //     );

		});
		$(".bodyA").hide();
		$(".pagetopsearchtn")[CLICK](function(event){
			var content= $(".pagetopsearchinp").val();
			location.href="/search/search/?content="+content;
		})
	})
</script>