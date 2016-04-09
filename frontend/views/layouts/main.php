<?php

use yii\helpers\Html;
use frontend\models\Setting;

$route = Yii::$app->controller->getRoute();
if($route=='project/projectdetails' || $route=='yyzc/projectdetailsyy' || $route=='yyzc/projectdetailsyyw' || $route=='yyzc/projectdetailsyyy'){
	$setting = $this->context->setting;
}else{
	$setting = Setting::find()->where(['parent_id'=>"3"])->all();	
}
if (empty($setting)){
	$setting = Setting::find()->where(['parent_id'=>"3"])->all();	
}
$SignPackage = $this->context->SignPackage;
?>
<?= $content ?>
<?= Html::jsFile('@web/style/js/jweixin-1.0.0.js') ?>
<script>
	wx.config({
			debug: false,
			appId: '<?= $SignPackage["appId"]; ?>',
			timestamp: '<?= $SignPackage["timestamp"]; ?>',
			nonceStr: '<?= $SignPackage["nonceStr"]; ?>',
			signature: '<?= $SignPackage["signature"]; ?>',
			jsApiList: [
				'onMenuShareTimeline',
				'onMenuShareAppMessage',
				'hideOptionMenu',
				'showOptionMenu',
				'hideMenuItems'
			]
		});
		wx.ready(function () {
			wx.hideMenuItems({
				menuList: [
					//'menuItem:copyUrl',
					'menuItem:openWithQQBrowser',
					'menuItem:share:email',
					'menuItem:openWithSafari',
					"menuItem:share:qq",
					"menuItem:readMode",
					"menuItem:favorite"
				],
				success: function (res) {
				},
				fail: function (res) {
				}
			});
			shareFn();
		});
		wx.error(function (res) {
			//alert(res.errMsg);
		});
		function shareFn() {
			title = '<?= $setting[0]["value"]; ?>';
			desc = '<?= $setting[1]["value"]; ?>';
			link = '<?= $setting[3]["value"]; ?>';
			imgurl = '<?= $setting[2]["value"]; ?>'
			wx.onMenuShareAppMessage({
				title: title,
				desc: desc,
				link: link,
				imgUrl: imgurl,
				trigger: function (res) {
				},
				success: function (res) {
				},
				cancel: function (res) {
				},
				fail: function (res) {
				}
			});
			wx.onMenuShareTimeline({
				title: desc,
				link: link,
				imgUrl: imgurl,
				trigger: function (res) {
				},
				success: function (res) {
				},
				cancel: function (res) {
				},
				fail: function (res) {
				}
			});
		}

</script>
