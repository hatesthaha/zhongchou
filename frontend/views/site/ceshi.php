<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\models\Term;
use frontend\models\Setting;
use frontend\models\Member;
use frontend\models\Product;

$sname = Setting::find()->where(['code'=>'siteName'])->one()->value;
$sdes = Setting::find()->where(['code'=>'sitetitle'])->one()->value;
$this->title=$sname;
$dependency1 = [
    'class' => 'yii\caching\DbDependency',
    'sql' => 'SELECT MAX(updated_at) FROM slider',
];
//var_dump($dependency1);exit;
$dependency2 = [
    'class' => 'yii\caching\DbDependency',
    'sql' => 'SELECT MAX(`product`.`updated_at`),MAX(`product`.`shenhe_at`),MAX(`product`.`end_time`),MAX(`money`.`updated_at`) FROM product,money',//
];

$connection = \Yii::$app->db;

	if($this->beginCache('shoyelunbo', ['duration' => 3600*6 , 'dependency' => $dependency1])){ 
	//轮播图片
        $slider = new \frontend\models\Slider;
        $lunbo = $slider->find()->where(['status'=>"1"])->orderby("listorder desc")->asArray()->all();
		
	
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
	<meta name="description" content="<?= Html::encode($sdes) ?>" />	
	<title><?= Html::encode($this->title) ?></title>
	<?php $this->head() ?>
    <?= Html::cssFile('@web/style/css/font-awesome.min.css')?>
    <?= Html::cssFile('@web/style/css/reset.css') ?>
    <?= Html::cssFile('@web/style/css/style.css')?>
</head>
<body>
	<section class="bodyA"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/u0.gif" alt=""></section>
	<div id="body_h">
		<section class="pagetop">
<!-- 			<a class="pagetopleft" href="javascript:history.go(-1)"><i class='icon-angle-left'></i></a> -->
			<h2>仌仌众梦</h2>
			<a class="pagetopright" href="/"></a>
		</section>
		<section class="headerh"></section>
		<section class="bannerPane">
		    <div class="swipe">
		        <ul id="slider">
				<?php 
				//首页轮播图
				if($lunbo)
				{
					foreach($lunbo as $k=>$v)
					{
						?>
						 <li style="display:block;">
		                 <img width="100%" src="<?= Yii::getAlias('@web') . '/' ?>upload/<?= $v['banner'];?>" alt="商城网站" />
		                 <span class="swipe-tip"><?= $v['name'];?></span>
		                 </li>
					<?php }} ?>
		        </ul>
		        <div id="pagenavi">
				<?php 
				$key = array_keys($lunbo);
				foreach($key as $v)
				{
				
					if($v==0)
					{?>
					<a href="javascript:void(0);" class="active"><?= $v; ?></a>
					<?php }
					else
					{?>
					<a href="javascript:void(0);"><?= $v; ?></a>
					<?PHP }}?>
		            
		        </div>
		    </div>
		</section>
		<?php
			
				$this->endCache(); 
			}
		?>
		<section class="modular1">
			<div><p class="modular1-line"></p><p class="modular1-word">累计注册人数</p></div>
		</section>
		<section class="modular2 text-c">
		<?php
			$number = sprintf( "%08d",$member_num);
			$number = str_split($number);
			
		?>
			<span><?= $number[0]; ?></span>
			<span><?= $number[1]; ?></span>
			<span><?= $number[2]; ?></span>
			<span><?= $number[3]; ?></span>
			<span><?= $number[4]; ?></span>
			<span><?= $number[5]; ?></span>
			<span><?= $number[6]; ?></span>
			<span><?= $number[7]; ?></span>
		</section>
		<?php
			$connection = \Yii::$app->db;

			if($this->beginCache('shoyepro', ['duration' => 3600 , 'dependency' => $dependency2])){ 
			
			//公告
			$command = $connection->createCommand('SELECT `id`,`content`,`name`,`term_id` FROM `product` WHERE `shenhe`=1 AND `status`=2 ORDER BY `created_at` DESC LIMIT 0,5');
			$gonggao = $command->queryAll();
			
				$member = Member::find()->where('openid=:openid',[':openid'=>$session['openid']])->one();
				if(empty($member)){
					$newuser = new Member();
					$newuser->openid = $session['openid'];
					$newuser->save();
				}
				 $khterms = [
					['term_id'=>2,'zhouqi'=>1],
					['term_id'=>3,'zhouqi'=>3],
					['term_id'=>4,'zhouqi'=>5],
					['term_id'=>5,'zhouqi'=>7],
					['term_id'=>6,'zhouqi'=>9],
				];
			


			
			
			
				//查询term
				$command = $connection->createCommand('SELECT `id`,`name` FROM term WHERE `parent_id`=1');
				$terms = $command->queryAll();
				$term=[];
				foreach ($terms as $value) {
					$term[$value['id']] = $value['name'];
				}
				foreach ($khterms as $key => $khterm) {
					
					$command = $connection->createCommand('SELECT * FROM `product` WHERE `shenhe`=1 AND `status`=2 AND `product`.`term_id` = '.$khterm['term_id']);
					$product[$key+1][0] = $command->queryOne();
					$command = $connection->createCommand(sprintf('SELECT * FROM `product` WHERE `status`=0 AND `term_id`=%u AND `shenhe`=1 AND `sorted_at`>0 ORDER BY `sorted_at` ASC, `sort` ASC limit 0,2 ',$khterm['term_id']));
					//$product[$key+1][]
					$waiting = $command->queryAll();
					if(empty($waiting)){
						$command = $connection->createCommand(sprintf('SELECT `product`.* FROM `product`LEFT JOIN `member` ON `product`.`user_id`=`member`.`id` WHERE  `product`.`shenhe`=1 AND `sorted_at`=0 AND `product`.`term_id` =%u AND `product`.`status`=0 ORDER BY `member`.`prestige` DESC LIMIT 0,2',$khterm['term_id']));
						//$product[$key+1][]
						$waiting = $command->queryAll();
					}
					$product[$key+1][] = $waiting;
					$product[$key+1]['term'] = $term[$khterm['term_id']];
					$product[$key+1]['tid'] = $khterm['term_id'];
				}
				//var_dump($product);exit;
				foreach ($product as $key => $value) {
					if(@is_numeric($value[0]['total_money']) && @is_numeric($value[0]['target_money'])){
						$product[$key][0]['wanchengdu'] = ceil($value[0]['total_money']/$value[0]['target_money']*100);
					}
				}
				$command = $connection->createCommand('SELECT `id` FROM term WHERE `parent_id`=8');
				$term_yy = $command->queryAll();
				$yy_term = "(";
				foreach ($term_yy as $key => $value) {
					$yy_term .= $value['id'];
					if(count($term_yy)-1 != $key){ $yy_term .=',';}
				}
				$yy_term .= ")";
				$command = $connection->createCommand("SELECT `product`.* FROM `product`LEFT JOIN `member` ON `product`.`user_id`=`member`.`id` WHERE  `product`.`shenhe`=1 AND `product`.`term_id` in $yy_term AND `product`.`status`<>1 ORDER BY `member`.`prestige` DESC LIMIT 0,3");
				$product1[1] = $command->queryAll();
				$product1[1]['term'] = $term[8];
				$command = $connection->createCommand('SELECT `product`.* FROM `product`LEFT JOIN `member` ON `product`.`user_id`=`member`.`id` WHERE  `product`.`shenhe`=1 AND `product`.`term_id` = 7 AND `product`.`status`<>1 ORDER BY `member`.`prestige` DESC LIMIT 0,1');
				$product1[2] = $command->queryAll();
				$product1[2]['term'] = "声望专区";
		?>
		
		<p class="line1p bgdcdcdc"></p>
		<section class="modular3">
			<ul class="clearfix">
				<li class="modular3-li1">
					<a href="<?= Url::to(['project/buyshengwang','id'=>43,])?>">
						<p class="modular3-img"><img width="68%" src="<?= Yii::getAlias('@web') . '/' ?>style/images/indexnav1.png" alt="公益梦"></p></p>
						<p class="modular3-word">声望专区</p>
					</a>
				</li>
				<li class="modular3-li2">
					<a href="<?= Url::to(['search/searchitem','tid'=>2,])?>">
						<p class="modular3-img"><img width="68%" src="<?= Yii::getAlias('@web') . '/' ?>style/images/indexnav2.png" alt="白日梦"></p>
						<p class="modular3-word">白日梦</p>
					</a>
				</li>
				<li class="modular3-li3">
					<a href="<?= Url::to(['search/searchitem','tid'=>3,])?>">
						<p class="modular3-img"><img width="68%" src="<?= Yii::getAlias('@web') . '/' ?>style/images/indexnav3.png" alt="屌丝梦"></p>
						<p class="modular3-word">屌丝梦</p>
					</a>
				</li>
				<li class="modular3-li4">
					<a href="<?= Url::to(['search/searchitem','tid'=>4,])?>">
						<p class="modular3-img"><img width="68%" src="<?= Yii::getAlias('@web') . '/' ?>style/images/indexnav4.png" alt="土豪梦"></p>
						<p class="modular3-word">土豪梦</p>
					</a>
				</li>
				<li class="modular3-li5">
					<a href="<?= Url::to(['search/searchitem','tid'=>5,])?>">
						<p class="modular3-img"><img width="68%" src="<?= Yii::getAlias('@web') . '/' ?>style/images/indexnav5.png" alt="入道"></p>
						<p class="modular3-word">入道梦</p>
					</a>
				</li>
				<li class="modular3-li6">
					<a href="<?= Url::to(['search/searchitem','tid'=>6,])?>">
						<p class="modular3-img"><img width="68%" src="<?= Yii::getAlias('@web') . '/' ?>style/images/indexnav6.png" alt="超神"></p>
						<p class="modular3-word">超神梦</p>
					</a>
				</li>
				<li class="modular3-li7">
					<a href="<?= Url::to(['search/searchitem','tid'=>8,])?>">
						<p class="modular3-img"><img width="68%" src="<?= Yii::getAlias('@web') . '/' ?>style/images/indexnav7.png" alt="一元夺宝"></p>
						<p class="modular3-word">一元夺宝</p>
					</a>
				</li>
				<li class="modular3-li8">
					<a href="<?= Url::to(['search/searchitem',])?>">
						<p class="modular3-img"><img width="68%" src="<?= Yii::getAlias('@web') . '/' ?>style/images/indexnav8.png" alt="全部"></p>
						<p class="modular3-word">全部</p>
					</a>
				</li>
			</ul>
		</section>
		<p class="line1p bgdcdcdc"></p>
		<section class="notice modular4">
			<ul>
				<?php
				foreach ($gonggao as $key => $gg) {
					$aorb = Term::find()->where(['id'=>$gg['term_id']])->one();
				?>
				<li>
					<?php if($aorb['parent_id'] == "1"): ?>
					<a href="/project/projectdetails/?id=<?= $gg['id']; ?>">
					<?php else: ?>
					<a href="/yyzc/projectdetailsyy/?id=<?= $gg['id']; ?>">
					<?php endif ?>
						"<?= $gg['name'] ?>" 产品上线啦！ <b style="color:red">《点击查看详情》</b>
					</a>
				</li>
				<?php } ?>
			</ul>
		</section>
		

		
		<p class="line1p bgdcdcdc"></p>
		<div class="modular5">
			<section class="modular5-1 clearfix bort">
				<div class="width50 float-left">
					<h2 class="project-tit"><a href="<?= Url::to(['search/searchitem','tid'=>8,])?>"><span>一元夺宝</span>    </a></h2>
					<div class="project-con">
						<?php if(isset($product1[1][0])){ ?>
						<a class="bort borb" href="<?= Url::to(['yyzc/projectdetailsyy','id'=>$product1[1][0]['id'],])?>">
							<img class="project-left1 img1" width="100%" src="<?= Yii::getAlias('@web') . '/' ?><?php if(isset($product1[1][0]['img'])&&$product1[1][0]['img']!=""){ $img = explode(',', $product1[1][0]['img']); echo 'upload/'.$img[0]; }else{echo "style/images/nopicture.jpg";} ?>" alt="公益梦">
							<div class="project-word">
								<p class="project-wordt"><?= mb_substr(strip_tags(html_entity_decode($product1[1][0]['name'])),0,10,'utf-8')?></p>
								<p>目标金额：<?= $product1[1][0]['target_money'] ?> </p>
							</div>
						</a>
						<?php }else{ ?>
						<a class="bort borb" href="javascript:;">
							<img class="project-left1 img1" width="100%" src="<?= Yii::getAlias('@web') . '/' ?>style/images/noproduct.jpg" alt="公益梦">
							<div class="project-word">
								<p class="project-wordt">暂无项目</p>
							</div>
						</a>
						<?php } ?>
					</div>
				</div>
				<div class="width50 float-left">
					<h2 class="project-tit"><a href="<?= Url::to(['search/searchitem','tid'=>8,])?>"><!--<span>一元夺宝</span>-->更多</a></h2>
					<div>
						<div class="project-con">
							<?php if(isset($product1[1][1])){ ?>
							<a class="bort borb borl" href="<?= Url::to(['yyzc/projectdetailsyy','id'=>$product1[1][1]['id'],])?>">
								<img class="project-left2 img2" width="100%" src="<?= Yii::getAlias('@web') . '/'?><?php if(isset($product1[1][1]['img'])&&$product1[1][1]['img']!=""){ $img = explode(',', $product1[1][1]['img']); echo 'upload/'.$img[0]; }else{echo "style/images/nopicture.jpg";} ?>" alt="一元夺宝">
								<div class="project-word">
									<p class="project-wordt"><?= mb_substr(strip_tags(html_entity_decode($product1[1][1]['name'])),0,10,'utf-8')?></p>
									<p>目标金额：<?= $product1[1][1]['target_money'] ?></p>
								</div>
							</a>
							<?php }else{ ?>
							<a class="bort borb borl" href="javascript:;">
								<img class="project-left2 img2" width="100%" src="<?= Yii::getAlias('@web') . '/' ?>style/images/noproduct.jpg" alt="一元夺宝">
								<div class="project-word">
									<p class="project-wordt">暂无项目</p>
								</div>
							</a>
							<?php } ?>
						</div>
					</div>
					<div>
						<div class="project-con">
							<?php if(isset($product1[1][2])){ ?>
							<a class="borb borl" href="<?= Url::to(['yyzc/projectdetailsyy','id'=>$product1[1][2]['id'],])?>">
								<img class="project-left2 img2" width="100%" src="<?= Yii::getAlias('@web') . '/' ?><?php if(isset($product1[1][1]['img'])&&$product1[1][2]['img']!=""){  $img = explode(',', $product1[1][2]['img']); echo 'upload/'.$img[0]; }else{echo "style/images/nopicture.jpg";} ?>" alt="一元夺宝">
								<div class="project-word">
									<p class="project-wordt"><?= mb_substr(strip_tags(html_entity_decode($product1[1][2]['name'])),0,10,'utf-8')?></p>
									<p>目标金额：<?= $product1[1][2]['target_money'] ?></p>
								</div>
							</a>
							<?php }else{ ?>
							<a class="borb borl" href="javascript:;">
								<img class="project-left2 img2" width="100%" src="<?= Yii::getAlias('@web') . '/' ?>style/images/noproduct.jpg" alt="一元夺宝">
								<div class="project-word">
									<p class="project-wordt">暂无项目</p>
								</div>
							</a>
							<?php } ?>
						</div>
					</div>
				</div>
			</section>


			<!--此处为循环div开始-->
			<?php if(isset($product)){
				foreach ($product as $key => $value) {
			?>
			<section class="modular52 clearfix ">
				<p class="line1p bgdcdcdc"></p>
				<h2 class="project-tit"><a href="<?= Url::to(['search/searchitem','tid'=>$value['tid'],])?>"><span><?= $value['term'] ?></span>更多</a></h2>
				<div class="project-div">
					<div class="project-con borall">
						<?php if(isset($value[0]) &&$value[0]!=null){ ?>
						<a href="<?= Url::to(['project/projectdetails','id'=>$value[0]['id'],])?>">
							<img width="100%" class="img3" src="<?= Yii::getAlias('@web') . '/' ?><?php if(isset($value[0]['img'])&&$value[0]['img']!=""){  $img = explode(',', $value[0]['img']); echo 'upload/'.$img[0]; }else{echo "style/images/nopicture.jpg";} ?>" alt="<?= $value['term'] ?>">
							<div class="project-word">
								<p class="project-wordt"><?= mb_substr(strip_tags(html_entity_decode($value[0]['name'])),0,10,'utf-8')?></p>
								<p>目标金额：<?= $value[0]['target_money'] ?></p>
							</div>
							<div class="projectcircle">
								<div class="circle">
								    <div class="pie_left"><div class="left"></div></div>
								    <div class="pie_right"><div class="right"></div></div>
								    <div class="mask Greencolor">
								    	<p><?= isset($value[0]['wanchengdu'])?$value[0]['wanchengdu']:0 ?>%</p>
								    	<p class="hide"><span class="NUM"><?= isset($value[0]['wanchengdu'])?$value[0]['wanchengdu']:0 ?></span>%</p>
								    </div>
								</div>
							</div>
						</a>
						<?php }else{ ?>
						<a href="javascript:;">
							<img width="100%"  class="img3" src="<?= Yii::getAlias('@web') . '/' ?>style/images/noproduct.jpg" alt="<?= $value['term'] ?>">
							<div class="project-word">
								<p class="project-wordt">暂无项目</p>
							</div>
						</a>
						<?php } ?>
					</div>


					<div class="clearfix">
						<div class="project-con float-left project_down width50">
							<?php if(isset($value[1][0])){ ?>
								<a class="borl borb borr" href="<?= Url::to(['project/projectdetails','id'=>$value[1][0]['id'],])?>">
									<img class="hui-pagerq img3" width="100%" src="<?= Yii::getAlias('@web') . '/' ?><?php if(isset($value[1][0]['img'])&&$value[1][0]['img']!=""){ $img = explode(',', $value[1][0]['img']); echo 'upload/'.$img[0]; }else{echo "style/images/nopicture.jpg";} ?>" alt="<?= $value['term'] ?>">
									<div class="project-word">
										<p class="project-wordt"><?= mb_substr(strip_tags(html_entity_decode($value[1][0]['name'])),0,10,'utf-8')?></p>
										<p>目标金额：<?= $value[1][0]['target_money'] ?></p>
									</div>
								</a>
							<?php }else{ ?>
								<a class="borl borb borr" href="javascript:;">
									<img class="hui-pagerq img3" width="100%" src="<?= Yii::getAlias('@web') . '/' ?>style/images/noproduct.jpg" alt="<?= $value['term'] ?>">
									<div class="project-word">
										<p class="project-wordt">暂无项目</p>
									</div>
								</a>
							<?php } ?>
						</div>


						<div class="project-con float-left project_down width50">
							<?php if(isset($value[1][1])){ ?>
							<a class="borb borr" href="<?= Url::to(['project/projectdetails','id'=>$value[1][1]['id'],])?>">
								<img class="hui-pagerq img3" width="100%" src="<?= Yii::getAlias('@web') . '/'?><?php if(isset($value[1][1]['img'])&&$value[1][1]['img']!=""){ $img = explode(',', $value[1][1]['img']); echo 'upload/'.$img[0]; }else{echo "style/images/nopicture.jpg";} ?>" alt="<?= $value['term'] ?>">
								<div class="project-word">
									<p class="project-wordt"><?= mb_substr(strip_tags(html_entity_decode($value[1][1]['name'])),0,10,'utf-8')?></p>
									<p>目标金额：<?= $value[1][1]['target_money'] ?></p>
								</div>
							</a>
							<?php }else{ ?>
							<a class="borb borr" href="javascript:;">
								<img class="hui-pagerq img3" width="100%" src="<?= Yii::getAlias('@web') . '/' ?>style/images/noproduct.jpg" alt="<?= $value['term'] ?>">
								<div class="project-word">
									<p class="project-wordt">暂无项目</p>
								</div>
							</a>
							<?php } ?>
						</div>
					</div>
				</div>
			</section>
			<?php }} ?>
			<!--此处为循环div结束-->
			
		<div class="footerh"></div>
	</div>
	<?php
			
				$this->endCache(); 
			}
		?>
	<section>
				<ul class="footer clearfix">
					<li>
						<a href="<?= URL::to(['site/index'])?>">
							<img src="<?= Yii::getAlias('@web') . '/' ?>style/images/footer1.png" alt="首页"><p>首页</p>
						</a>
					</li>
					<!--<li>
						<a href="<?= URL::to(['search/searchitem'])?>">
							<img src="<?= Yii::getAlias('@web') . '/' ?>style/images/footer2.png" alt="全部"><p>全部</p>
						</a>
					</li>-->
					<li>
						<a href="/project/mylaunch">
							<img src="<?= Yii::getAlias('@web') . '/' ?>style/images/footer2.png" alt="全部"><p>发起</p>
						</a>
					</li>
					<li>
						<a href="http://0426.jiaoyinet.com/index.php?g=Wap&m=Forum&a=index&&token=gbaxyf1453078965&wecha_id=<?= $session['openid']?> &news_response=1">
							<img src="<?= Yii::getAlias('@web') . '/' ?>style/images/footer3.png" alt="社区"><p>社区</p>
						</a>
					</li>
					<li>
						<a href="<?= URL::to(['center/personalcenter'])?>">
							<img src="<?= Yii::getAlias('@web') . '/' ?>style/images/footer4.png" alt="个人中心"><p>个人中心</p>
						</a>
					</li>		
				</ul>
			</section>

<?= Html::jsFile('@web/style/js/touchscroll.js') ?>
<?= Html::jsFile('@web/style/js/touchscroll.dev.js') ?>
<?= Html::jsFile('@web/style/js/run.js') ?>
<?= Html::jsFile('@web/style/js/jquery-2.1.1.min.js') ?>
<?= Html::jsFile('@web/style/js/reset.js') ?>
<?= Html::jsFile('@web/style/js/index.js') ?>
<?= Html::jsFile('@web/style/js/grayscale.js') ?>

</body>
</html>
