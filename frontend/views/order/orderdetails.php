<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\models\Term;
$this->title="订单详情";
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
   	<?= Html::cssFile('@web/style/css/font-awesome.min.css')?>
    <?= Html::cssFile('@web/style/css/reset.css') ?>
    <?= Html::cssFile('@web/style/css/style.css')?>
</head>
<body>
	<section class="bodyA"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/u0.gif" alt=""></section>
	<div id="body_h" class="bgeaeaea">
		<section class="pagetop">
			<a class="pagetopleft" href="javascript:history.go(-1)"><i class='icon-angle-left'></i></a>
			<h2>订单详情</h2>
			<?php $aorb = Term::find()->where(['id'=>$order_detail['term_id']])->one(); ?>
			<?php if($aorb['parent_id'] == "1"): ?>
			<a class="pagetopright" href="<?php echo Url::to(['project/projectdetails'])."?id=".$order_detail['cid'];?>">查看项目</a>
			<?php else: ?>
			<a class="pagetopright" href="<?php echo Url::to(['yyzc/projectdetailsyy'])."?id=".$order_detail['cid'];?>">查看项目</a>
			<?php endif ?>
		</section>
		<section class="headerh"></section>
		<section class="modular13">
			<table>
				<tr>
					<td class="text-r">合计支付：</td>
					<td><span class="redco">￥<?= $order_detail['money']?></span><span class="bgfeb528-wf rigd rigd1"><?php if($order_detail['status']==0){echo'待支付';}elseif($order_detail['status']==1){echo'已支付';}elseif($order_detail['status']==2){echo '项目结束·支付超时';}elseif($order_detail['status']==3){echo '项目暂停·暂不能支付';} ?></span></td>
				</tr>
				<!--<tr>
					<td class="text-r">支持金额：</td>
					<td>￥<?= $order_detail['money']?></td>
				</tr>-->
				<!--<tr>
					<td class="text-r">份数：</td>
					<td>1</td>
				</tr>-->

			</table>
		</section>
		<section class="modular14">
			<div class="modular14-con1div">
				<?php if(isset($order_detail['faqiren']) &&$order_detail['faqiren']!=""){ ?>
					<p class="modular14-con11"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/header-img.jpg" alt="<?= $order_detail['faqiren']['name']?>">项目发起者：<?= $order_detail['faqiren']['name']?></p>
					<?php if(isset($order_detail['faqiren']['phone'])&&$order_detail['faqiren']['phone']!=""){?>
						<p class="modular14-con12 clearfix">
							<a class="float-left" href="sms:<?= $order_detail['faqiren']['phone']?>"><i class="icon-envelope-alt"></i>&nbsp;给我留言</a>
							<a class="float-right" href="tel:<?= $order_detail['faqiren']['phone']?>"><i class="icon-phone"></i>&nbsp;电话联系</a>
						</p>
					<?php } ?>
				<?php }?>
			</div>
			<div class="modular14-con1div">
				<p>订单号：<?= $order_detail['order_num']?></p>
				<p>下单时间：<?= date("Y-m-d H:i:s",$order_detail['created_at'])?></p>
				<p>备注：<?= mb_substr(strip_tags(html_entity_decode($order_detail['info'])),0,100,'utf-8')?></p>
			</div>
		</section>
		<div>
				<?php if($order_detail['status']==0){ ?>
				<p class="form-btn clearfix">
					<a class="float-left bghui-wc" href="javascript:cancel('<?= $order_detail['order_num']?>')">取消订单</a>
					<a class="float-right bgfeb528-wf" href="/pay/payinformation?pid=<?=$order_detail['cid']?>&jine=<?=$order_detail['money']?>&oid=<?=$order_detail['order_num']?>">继续支付</a>
				</p>
				<?php }if($order_detail['status']==1||$order_detail['status']==2){  ?>
					<p class="nextlinkpage">
						<a class="bghui-wc" href="javascript:cancel('<?= $order_detail['order_num']?>')">删除记录</a>
					</p>
				<?php } ?>
		</div>
	</div>
	<p id="tip-error"><span>表单验证错误信息</span></p>
<?= Html::jsFile('@web/style/js/jquery-2.1.1.min.js') ?>
<?= Html::jsFile('@web/style/js/reset.js') ?>
<script>
	$(document).ready(function(){
		$(".formok-btn").click(function(event){
	        event.preventDefault();
	        var phone=$("input[name='phone']").val();
	        	reg=/(^[1][34578][0-9]{9}$)/;
	    	if(!reg.test(phone)){
				$('#tip-error span').html('请正确输入手机号');
		        $('#tip-error').show();
		        setTimeout(function(){$('#tip-error').fadeOut(500);},1000);
	    		$("input[name='phone']").focus();
			}else{
				$(this).parents("form").submit();
			}
		});
		$(".bodyA").hide();

	})
	function cancel(order_id){
		var a=confirm('是否删除');
		if(a){
			location.href="<?= Url::to(['order/cancel'])?>?oid="+order_id;
		}
		/**$.get("<?= Url::to(['order/cancel'])?>?oid="+order_id,function(status){
	         	if(status==1){
			$('#tip-error span').html('取消订单成功，返回我的订单');
			$('#tip-error').show();
			setTimeout(function(){$('#tip-error').fadeOut(500);},1000);
			setTimeout(function(){
				location.href=<?php echo '"'.Url::to(['order/myorder']).'"';?>;
			},1000);
	         	}else{
			$('#tip-error span').html('取消订单失败');
			$('#tip-error').show();
			setTimeout(function(){$('#tip-error').fadeOut(500);},1000);
	         	}
	         })
			 */
	}
</script>
</body>
</html>