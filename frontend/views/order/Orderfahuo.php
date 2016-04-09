<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\models\Term;
$this->title="货单详情";
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
			<a class="pagetopright" href="/"></a>
		</section>
		<section class="headerh"></section>
		<section class="modular26con modular46">
			<ul>
				<li>
					<a class="modular26condiv" href="javascript:;">
						<p class="modular26conimg"><img width="100%" height="100%" src="<?= Yii::getAlias('@web') . '/' ?><?php if(isset($order_detail['img'])&&$order_detail['img']!=""){  $img = explode(',', $order_detail['img']); echo 'upload/'.$img[0]; }else{echo "style/images/nopicture.jpg";} ?>" alt="项目名称"></p>
						<div class="modular26conword">
							<div>
								<h2><?= empty($order_detail['pname'])?'未获取到项目名称':$order_detail['pname'] ?></h2>
								<p>金额：￥<?= empty($order_detail['total_money'])?0:$order_detail['total_money'] ?></p>
								<?php if(!empty($order_detail['status']) &&$order_detail['status']>0){ ?><p>发货单号：<?= empty($order_detail['invoice_no'])?0:$order_detail['invoice_no'] ?></p> <?php } ?>
							</div>
						</div>
					</a>
				</li>
			</ul>
		</section>
		<section class="modular47">
			<table>
				<?php if(!empty($order_detail['status']) &&$order_detail['status']>0){ ?>
				<tr>
					<td class="text-r">发货单号：</td>
					<td><?= empty($order_detail['invoice_no'])?0:$order_detail['invoice_no'] ?></td>
				</tr>
				<?php } ?>
				<tr>
					<td class="text-r">订单状态：</td>
					<td><span class="redco"><?php if(!empty($order_detail['status']) &&$order_detail['status']==0){echo "待发货";}elseif(!empty($order_detail['status']) &&$order_detail['status']==1){echo "已发货";}elseif(!empty($order_detail['status']) &&$order_detail['status']==2){echo '已完成';}elseif(!empty($order_detail['status']) &&$order_detail['status']==-1){echo '正在众筹中';} ?></span></td>
				</tr>
				<tr>
					<td class="text-r">下单时间：</td>
					<td><?= date("Y-m-d H:i:s",$order_detail['created_at'])?></td>
				</tr>
				<tr>
					<td class="text-r">联系电话：</td>
					<td><?= $order_detail['phone']?></td>
				</tr>
				<tr>
					<td class="text-r">收货地址：</td>
					<td><?= $order_detail['name']?><br><?= mb_substr(strip_tags(html_entity_decode($order_detail['address'])),0,100,'utf-8')?></td>
				</tr>
				<?php if($order_detail['status']==1){ ?>
				<tr>
					<td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;剩余<?= $order_detail['shenghuotianshu']?>天自动收货</td>
				</tr>
				<?php }?> 
			</table>
		</section>
		<div>
			<?php if(!empty($order_detail['status']) &&$order_detail['status']==1){ ?>
			<p class="nextlinkpage">
				<a class="bgfeb528-wf" href="javascript:querenshouhuo(<?= $order_detail['pid']?>,<?= $order_detail['invoice_no']?>);">确认收货</a>
			</p>
			<?php } else if(!empty($order_detail['status']) &&$order_detail['status']==2) {?>
			<p class="nextlinkpage">
						<a class="bghui-wc" href="javascript:cancelfahuo('<?= $order_detail['pid']?>')">删除已完成订单</a>
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
	function querenshouhuo(pid,oid){
		 $.get(
		 	"<?= Url::to(['order/querenajax'])?>?pid="+pid+"&oid="+oid,
		 	function(status){
			 	var res=JSON.parse(status);
		        if(res==0){
			  		location.href='<?= Url::to(['register/signin']) ?>';
		        }else if(res.status==1){
					$('#tip-error span').html('确认收货成功');
					$('.nextlinkpage').remove();
					$('#tip-error').show();
					setTimeout(function(){$('#tip-error').fadeOut(500);},1000);
				}else{
					$('#tip-error span').html('确认收货失败');
					$('#tip-error').show();
					setTimeout(function(){$('#tip-error').fadeOut(500);},1000);
		        }
	        });
	}
	function cancelfahuo(order_id){
		var a=confirm('是否删除');
		if(a){
			location.href="<?= Url::to(['order/cancelfahuo'])?>?oid="+order_id;
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