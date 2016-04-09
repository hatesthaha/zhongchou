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
	<title>每日签到</title>
	<?= Html::cssFile('@web/style/css/font-awesome.min.css') ?>
	<?= Html::cssFile('@web/style/css/reset.css') ?>
	<?= Html::cssFile('@web/style/css/style.css') ?>
</head>
<body>
	<section class="bodyA"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/u0.gif" alt=""></section>
	<div id="body_h">
		<section class="pagetop">
			<a class="pagetopleft" href="/center/personalcenter"><i class='icon-angle-left'></i></a>
			<h2>每日签到</h2>
			<a class="pagetopright" href="/"></a>
		</section>
		<section class="headerh"></section>
		<section>
			<img width="100%" src="<?= Yii::getAlias('@web') . '/' ?>style/images/signed.jpg" alt="每日签到">
			<div class="modular18">
				<p class="signbtn"><span id="signedbtn">签到</span></p>
				<div>
					<p><img class="block" width="100%" src="<?= Yii::getAlias('@web') . '/' ?>style/images/signed2.png" alt="每日签到"></p>
					<div class="signdatabox">
						<table class="signdata clearfix">
							<tr class="topnobort">
								<td><span>日</span></td>
								<td><span>一</span></td>
								<td><span>二</span></td>
								<td><span>三</span></td>
								<td><span>四</span></td>
								<td><span>五</span></td>
								<td><span>六</span></td>
							</tr>
							<tr>
								<td><span>&nbsp;</span></td>
								<td><span>&nbsp;</span></td>
								<td><span>&nbsp;</span></td>
								<td><span>&nbsp;</span></td>
								<td><span>&nbsp;</span></td>
								<td class="day1"><span>1</span><i class="icon-ok hide"></i></td>
								<td class="day2"><span>2</span><i class="icon-ok hide"></i></td>
							</tr>
							<tr>
								<td class="day3"><span>3</span><i class="icon-ok hide"></i></td>
								<td class="day4"><span>4</span><i class="icon-ok hide"></i></td>
								<td class="day5"><span>5</span><i class="icon-ok hide"></i></td>
								<td class="day6"><span>6</span><i class="icon-ok hide"></i></td>
								<td class="day7"><span>7</span><i class="icon-ok hide"></i></td>
								<td class="day8"><span>8</span><i class="icon-ok hide"></i></td>
								<td class="day9"><span>9</span><i class="icon-ok hide"></i></td>
							</tr>
							<tr>
								<td class="day10"><span>10</span><i class="icon-ok hide"></i></td>
								<td class="day11"><span>11</span><i class="icon-ok hide"></i></td>
								<td class="signedok day12"><span>12</span><i class="icon-ok hide"></i></td>
								<!--给td加上signedok这个class表示这天签到-->
								<td class="signedok day13"><span>13</span><i class="icon-ok hide"></i></td>
								<td class="signedok day14"><span>14</span><i class="icon-ok hide"></i></td>
								<td class="day15"><span>15</span><i class="icon-ok hide"></i></td>
								<td class="day16"><span>16</span><i class="icon-ok hide"></i></td>
							</tr>
							<tr>
								<td class="day17"><span>17</span><i class="icon-ok hide"></i></td>
								<td class="day18"><span>18</span><i class="icon-ok hide"></i></td>
								<td class="day19"><span>19</span><i class="icon-ok hide"></i></td>
								<td class="day20"><span>20</span><i class="icon-ok hide"></i></td>
								<td class="day21"><span>21</span><i class="icon-ok hide"></i></td>
								<td class="day22"><span>22</span><i class="icon-ok hide"></i></td>
								<td class="day23"><span>23</span><i class="icon-ok hide"></i></td>
							</tr>
							<tr class="topnoborb">
								<td class="day24"><span>24</span><i class="icon-ok hide"></i></td>
								<td class="day25"><span>25</span><i class="icon-ok hide"></i></td>
								<td class="day26"><span>26</span><i class="icon-ok hide"></i></td>
								<td class="day27"><span>27</span><i class="icon-ok hide"></i></td>
								<td class="day28"><span>28</span><i class="icon-ok hide"></i></td>
								<td class="day29"><span>29</span><i class="icon-ok hide"></i></td>
								<td class="day30"><span>30</span><i class="icon-ok hide"></i></td>
							</tr>
							<tr class="topnoborb">
								<td class="day31"><span>31</span><i class="icon-ok hide"></i></td>
								<td><span>&nbsp;</span></td>
								<td><span>&nbsp;</span></td>
								<td><span>&nbsp;</span></td>
								<td><span>&nbsp;</span></td>
								<td><span>&nbsp;</span></td>
								<td><span>&nbsp;</span></td>
							</tr>
						</table>
					</div>
				</div>
				<div class="modular6">
					<p class="yellowco2 font14">签到规则说明：</p>
					<p>每签到一次可获得1声望值。</p>
				</div>
			</div>
		</section>
	</div>
	<p id="tip-error"><span>表单验证错误信息</span></p>
<?= Html::jsFile('@web/style/js/jquery-2.1.1.min.js') ?>
<?= Html::jsFile('@web/style/js/reset.js') ?>
<script>
	$(document).ready(function(){
		var myDate = new Date();
		day = myDate.getDate();
		$("#signedbtn").click(function(event){
			event.preventDefault();
			$(".signdata td").each(function(){
				var Th = $(this);
				if(Th.hasClass("signedok")){
				}else{
					var thisC = String($(this).attr('class')).substring(3);
					var thisCNN = parseInt(thisC);
					if(day == thisCNN){
						Th.addClass("signedok");
						$("#signedbtn").html("已签到");
					}
				}
			});
		});
		$(".bodyA").hide();
	})
</script>
</body>
</html>