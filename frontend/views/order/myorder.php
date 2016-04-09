<?php 
use yii\helpers\Html;
use yii\helpers\Url;
$this->title="我的订单";
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
			<a class="pagetopleft" href="/center/personalcenter"><i class='icon-angle-left'></i></a>
			<h2>我的订单</h2>
			<a class="pagetopright" href="/"></a>
		</section>
		<section class="headerh"></section>
		<section class="modular26">
			<section class="pagenav">
				<ul class="modular26-tit clearfix">
					<li data-cato="mould-26list1" <?php if(empty($_GET['type']) || $_GET['type'] == "all"){echo "class='current6'";}?>>
						<a href=""><span>全部订单</span></a>
					</li>
					<li data-cato="mould-26list2" <?php if(!empty($_GET['type']) && $_GET['type'] == "dfh"){echo "class='current6'";}?>>
						<a href=""><span>待发货</span></a>
					</li>
					<li data-cato="mould-26list3" <?php if(!empty($_GET['type']) && $_GET['type'] == "dsh"){echo "class='current6'";}?>>
						<a href=""><span>待收货</span></a>
					</li>
					<li data-cato="mould-26list4" <?php if(!empty($_GET['type']) && $_GET['type'] == "dfk"){echo "class='current6'";}?>>
						<a href=""><span>待支付</span></a>
					</li>
				</ul>
			</section>
			<section id="mould-26list1" class="modular26con <?php if(!empty($_GET['type']) && $_GET['type'] != 'all'){echo 'hide';}?>">
				<ul>
					<?php 
					if(isset($product1) && !empty($product1)){
						foreach ($product1 as $key => $value) {
					?>
					<li>
						<a class="modular26condiv" href="<?= Url::to(['order/orderfahuo','oid'=>$value['order_id'],])?>">
							<p class="modular26conimg"><img width="100%" height="100%" src="<?= Yii::getAlias('@web') . '/' ?><?php if(isset($value['img'])&&$value['img']!=""){  $img = explode(',', $value['img']); echo 'upload/'.$img[0]; }else{echo "style/images/nopicture.jpg";} ?>"></p>
							<div class="modular26conword">
								<div>
									<h2><?= mb_substr(strip_tags(html_entity_decode($value['pname'])),0,10,'utf-8')?></h2>
									<p>金额：￥<?= $value['total_money']?$value['total_money']:0?></p>
									<?php if(!empty($value['invoice_no'])&&$value['invoice_no']>0){?><p>物流单号：<?= $value['invoice_no']?></p><?php } ?>
								</div>
							</div>
						</a>
						<?php 
							switch ($value['status']) {
								case '-1':
									echo '<p class="modular26conword2 text-r"><a class="yellowco" href="/">正在众筹中</a></p>';
									break;
								case '0':
									echo '<p class="modular26conword2 text-r"><a class="yellowco" href="/">待发货</a></p>';
									break;
								case '1':
									echo '<p class="modular26conword2 text-r">剩余'.$value['shenghuotianshu'].'天自动收货&nbsp;&nbsp;&nbsp;&nbsp;<a class="bgfeb528-wf" href="/order/queren?oid='.urlencode($value['order_id']).'">确认收货</a></p>';
									break;
								case '2':
									echo '<p class="modular26conword2 text-r"><a class="yellowco" href="/">已完成</a></p>';
									break;
								default:
									echo '<p class="modular26conword2 text-r"><a class="99cc" href="/">未知问题</a></p>';
									break;
							}
						?>
						
					</li>
					<?php }} ?>
					<?php 
					if(isset($product0) && !empty($product0)){
						foreach ($product0 as $key => $value) {
					?>
					<li>
						<a class="modular26condiv" href="<?= Url::to(['order/orderdetails','oid'=>$value['order_num'],])?>">
							<p class="modular26conimg"><img width="100%" height="100%" src="<?= Yii::getAlias('@web') . '/' ?><?php if(isset($value['img'])&&$value['img']!=""){  $img = explode(',', $value['img']); echo 'upload/'.$img[0]; }else{echo "style/images/nopicture.jpg";} ?>" alt="项目名称"></p>
							<div class="modular26conword">
								<div>
									<h2><?= mb_substr(strip_tags(html_entity_decode($value['pname'])),0,10,'utf-8')?></h2>
									<p>金额：￥<?= $value['money']?></p>
									<p>订单号：<?= $value['order_num']?></p>
								</div>
							</div>
						</a>
						<?php 
							switch ($value['status']) {
								case '0':
									echo '<p class="modular26conword2 text-r"><a class="bgfeb528-wf" href="/pay/payinformation?pid='.$value['cid'].'&jine='.$value['money'].'&oid='.$value['order_num'].'">支付</a></p>';
									break;
								case '1':
									echo '<p class="modular26conword2 text-r"><a class="yellowco" href="/">已支付</a></p>';
									break;
								case '2':
									echo '<p class="modular26conword2 text-r"><a class="yellowco" href="/">项目已结束·已超时</a></p>';
									break;
								case '3':
									echo '<p class="modular26conword2 text-r"><a class="yellowco" href="/">项目暂停中·不能支付</a></p>';
									break;
								default:
									echo '<p class="modular26conword2 text-r"><a class="99cc" href="/">未知问题</a></p>';
									break;
							}
						?>
						
					</li>
					<?php }} ?>
				</ul>
			</section>
			<!--待发货-->
			<section id="mould-26list2" class="modular26con <?php if(empty($_GET['type']) || $_GET['type'] != 'dfh'){echo 'hide';}?>">
				<ul>
					<?php 
					if(isset($waitdeliver) && !empty($waitdeliver)){
						foreach ($waitdeliver as $key => $value) {
							# code...
					?>
					<li>
						<a class="modular26condiv" href="<?= Url::to(['order/orderfahuo','oid'=>$value['invoice_no'],])?>">
							<p class="modular26conimg"><img width="100%" height="100%" src="<?= Yii::getAlias('@web') . '/' ?><?php if(isset($value['img'])&&$value['img']!=""){  $img = explode(',', $value['img']); echo 'upload/'.$img[0]; }else{echo "style/images/nopicture.jpg";} ?>" alt="项目名称"></p>
							<div class="modular26conword">
								<div>
									<h2><?= mb_substr(strip_tags(html_entity_decode($value['pname'])),0,10,'utf-8')?></h2>
									<p>金额：￥<?= $value['total_money']?$value['total_money']:0?></p>
									<p>物流单号：<?= $value['invoice_no']?></p>
								</div>
							</div>
						</a>
						<?php 
							switch ($value['status']) {
								case '0':
									echo '<p class="modular26conword2 text-r"><a class="yellowco" href="/">待发货</a></p>';
									break;
								case '1':
									echo '<p class="modular26conword2 text-r"><a class="bgfeb528-wf" href="/">确认收货</a></p>';
									break;
								case '2':
									echo '<p class="modular26conword2 text-r"><a class="yellowco" href="/">已完成</a></p>';
									break;
								default:
									echo '<p class="modular26conword2 text-r"><a class="99cc" href="/">未知问题</a></p>';
									break;
							}
						?>
						
					</li>
					<?php }} ?>
					
				</ul>
			</section>
			<!--待收货-->
			<section id="mould-26list3" class="modular26con <?php if(empty($_GET['type']) || $_GET['type'] != 'dsh'){echo 'hide';}?>">
				<ul>
					<?php 
					if(isset($waitreceipt) && !empty($waitreceipt)){
						foreach ($waitreceipt as $key => $value) {
							# code...
					?>
					<li>
						<a class="modular26condiv" href="<?= Url::to(['order/orderfahuo','oid'=>$value['order_id'],])?>">
							<p class="modular26conimg"><img width="100%" height="100%" src="<?= Yii::getAlias('@web') . '/' ?><?php if(isset($value['img'])&&$value['img']!=""){  $img = explode(',', $value['img']); echo 'upload/'.$img[0]; }else{echo "style/images/nopicture.jpg";} ?>" alt="项目名称"></p>
							<div class="modular26conword">
								<div>
									<h2><?= mb_substr(strip_tags(html_entity_decode($value['pname'])),0,10,'utf-8')?></h2>
									<p>金额：￥<?= $value['total_money']?$value['total_money']:0?></p>
									<p>物流单号：<?= $value['invoice_no']?></p>
								</div>
							</div>
						</a>
						<?php 
							switch ($value['status']) {
								case '0':
									echo '<p class="modular26conword2 text-r"><a class="yellowco" href="/">待发货</a></p>';
									break;
								case '1':
									echo '<p class="modular26conword2 text-r">剩余'.$value['shenghuotianshu'].'天自动收货&nbsp;&nbsp;&nbsp;&nbsp;<a class="bgfeb528-wf" href="/order/queren?oid='.urlencode($value['order_id']).'">确认收货</a></p>';
									break;
								case '2':
									echo '<p class="modular26conword2 text-r"><a class="yellowco" href="/">已完成</a></p>';
									break;
								default:
									echo '<p class="modular26conword2 text-r"><a class="99cc" href="/">未知问题</a></p>';
									break;
							}
						?>
						
					</li>
					<?php }} ?>
					
				</ul>
			</section>
			<!--未支付-->
			<section id="mould-26list4" class="modular26con <?php if(empty($_GET['type']) || $_GET['type'] != 'dfk'){echo 'hide';}?>">
				<ul>
					<?php 
					if(isset($nopay) && !empty($nopay)){
						foreach ($nopay as $key => $value) {
							# code...
					?>
					<li>
						<a class="modular26condiv" href="<?= Url::to(['order/orderdetails','oid'=>$value['order_num'],])?>">
							<p class="modular26conimg"><img width="100%" height="100%" src="<?= Yii::getAlias('@web') . '/' ?><?php if(isset($value['img'])&&$value['img']!=""){  $img = explode(',', $value['img']); echo 'upload/'.$img[0]; }else{echo "style/images/nopicture.jpg";} ?>"></p>
							<div class="modular26conword">
								<div>
									<h2><?= mb_substr(strip_tags(html_entity_decode($value['pname'])),0,10,'utf-8')?></h2>
									<p>金额：￥<?= $value['money']?></p>
									<p>订单号：<?= $value['order_num']?></p>
								</div>
							</div>
						</a>
						<?php 
							//if($value['uid'] ==$value['puid']){
								switch ($value['status']) {
									case '0':
										echo '<p class="modular26conword2 text-r"><a class="bgfeb528-wf" href="/pay/payinformation/?pid='.$value['cid'].'&jine='.$value['money'].'&oid='.$value['order_num'].'">支付</a></p>';
										break;
									case '1':
										echo '<p class="modular26conword2 text-r"><a class="yellowco" href="/">已支付</a></p>';
										break;
									case '2':
										echo '<p class="modular26conword2 text-r"><a class="yellowco" href="/">项目结束·支付超时</a></p>';
										break;
									case '3':
										echo '<p class="modular26conword2 text-r"><a class="yellowco" href="/">项目暂停·暂不能支付</a></p>';
										break;
									default:
										echo '<p class="modular26conword2 text-r"><a class="99cc" href="/">未知问题</a></p>';
										break;
								}
						?>
						
					</li>
					<?php }} ?>
					
				</ul>
			</section>
		</section>
		<div class="footerh"></div>
	</div>
	<?= $this->render('//layouts/footer_section', [
        //'model' => $model,
    ]) ?>
<?= Html::jsFile('@web/style/js/jquery-2.1.1.min.js') ?>
<?= Html::jsFile('@web/style/js/reset.js') ?>
<script>
	$(document).ready(function(){
		var UA=window.navigator.userAgent;  //使用设备
	    var CLICK="click";
	    if(/ipad|iphone|android/.test(UA)){   //判断使用设备
	        CLICK="tap";
	    }
		var catoFram=$(".modular26con");
	    var subNav=$(".modular26-tit li");
	    //$("#mould-26list3").removeClass("hide");
	    //subNav[0].className += " current6" ;
	    subNav[CLICK](function(event){
            event.preventDefault();
	        var _this=$(this);
	        var id=_this.data("cato"); 
	        var cur=$("#"+id);
	        subNav.removeClass("current6");
	        _this.addClass("current6");
	        catoFram.addClass("hide");
	        cur.scrollTop(0);        
	        cur.removeClass("hide");
	    });
		$(".bodyA").hide();
	})
</script>
</body>
</html>