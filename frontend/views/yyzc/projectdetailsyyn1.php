<?php
use yii\helpers\Html;
use frontend\models\Member;
use frontend\models\Money;
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
	<title>所有记录</title>
	<?= Html::cssFile('@web/style/css/font-awesome.min.css') ?>
	<?= Html::cssFile('@web/style/css/reset.css') ?>
	<?= Html::cssFile('@web/style/css/style.css') ?>
</head>
<body>
	<section class="bodyA"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/u0.gif" alt=""></section>
	<div id="body_h">
		<section class="pagetop">
			<a class="pagetopleft" href="javascript:history.go(-1)"><i class='icon-angle-left'></i></a>
			<h2>所有记录</h2>
			<a class="pagetopright" href="/"></a>
		</section>
		<section class="headerh"></section>
		<section class="modular42">
			<ul id="xialalist">
				<?php foreach ($peo as $key => $value): ?>
				<?php
					$uinfo = Member::find()->where(['id'=>$value['uid']])->one();
					$count = Money::find()->where(['uid'=>$uinfo['id'],'cid'=>$_GET['id']])->count();
				?>
				<li class="modular42-item">
					<p class="modular42-itemimg">
						<?php if(!empty($uinfo['head'])): ?>
						<img width="100%" height="100%" src="<?= Yii::getAlias('@web') . '/' ?>upload/<?= $uinfo['head']; ?>" alt="用户头像">
						<?php else: ?>
						<img width="100%" height="100%" src="<?= Yii::getAlias('@web') . '/' ?>style/images/header-img.jpg" alt="用户头像">
						<?php endif ?>
					</p>
					<div class="modular42-itemcon">
						<div>
							<p class="yellowco">
								<?php if(!empty($uinfo['name'])): ?>
								<?= $uinfo['name']; ?>
								<?php else: ?>
								<?= $uinfo['phone']; ?>
								<?php endif ?>
							</p>
							<p>1元众筹了<span class="redcol"><?= $count; ?></span>人次&nbsp;<span class="redcc"><?php echo date("Y-m-d H:i:s",$value['created_at']); ?></span></>
						</div>
					</div>
				</li>
				<?php endforeach ?>
			</ul>
		</section>
	</div>
<?= Html::jsFile('@web/style/js/jquery-2.1.1.min.js') ?>
<?= Html::jsFile('@web/style/js/reset.js') ?>
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
		
		
		
		//下拉加载
	var page=0;//当前页
	var pages=<?= $yeshu?>;//总页数
	var ajax=!1;//是否加载中
	var ul_obj = $('#xialalist');
	$(window).scroll(function(){
	    if(($(window).scrollTop() + $(window).height() > $(document).height()-40) && !ajax && pages > page){
			
		//alert(123);
	        page++;//当前页增加1
	        ajax=!0;//注明开始ajax加载中
	        $(".modular42").append('<div class="loading" style="text-align:center"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/loading.gif" alt=""></div> ');//出现加载图片
	        $.ajax({
	        	type: 'GET',
	        	url: '/yyzc/yyn1json?id=<?= $_GET['id']?>&page='+page,
	        	dataType: 'json',
	        	success: function(data){
					if(typeof(data.status)!='undefine'){
						console.log(data);
						var list = data;//.list;
						var li_clone =  "";
						for(var i= 0,l = list.length;i<l;i++){
							//alert(data['list'][0]['zhi1']);
							//处理数据并插入
							var userhead = list[i].uinfo.head;
								username = list[i].uinfo.name;
								count = list[i].count;
								time = list[i].time;
								phone = list[i].phone;
								li_clone +='<li class="modular42-item"><p class="modular42-itemimg">'
							if(userhead) {
							li_clone +='<img width="100%" height="100%" src="<?= Yii::getAlias('@web') . '/' ?>upload/'+userhead+'" alt="用户头像">';
							} else {
								li_clone +='<img width="100%" height="100%" src="<?= Yii::getAlias('@web') . '/' ?>style/images/header-img.jpg" alt="用户头像">';	
							}
							li_clone +='</p><div class="modular42-itemcon"><div><p class="yellowco">';
							if (username){
								li_clone += username;
							} else {
								li_clone += phone;
							}
							li_clone +='</p><p>1元众筹了<span class="redcol">'+count+'</span>人次&nbsp;<span class="redcc">'+time+'</span></></div></div></li>';

						};
						
						ul_obj.append(li_clone); //克隆元素
						//classpage(); //克隆元素样式
						$(".loading").addClass("hide");
						ajax=!1;//注明已经完成ajax加载
					}else {
						$(".loading").html("暂无内容！");
					}
	        	},
	            error: function(xhr, type){
	                $(".loading").html("暂无内容！");
	            }
	        });
		}else if(!ajax && pages == page){
			console.log(pages);
			console.log(page);
			page++;//当前页增加1
	        ul_obj.append('<div class="loading" style="text-align:center">暂无内容！</div> ');//出现加载图片
		}else if(!ajax && pages < page){

		};
	});
	})
</script>
</body>
</html>