<?php

	use yii\helpers\Url;
	$session = Yii::$app->session;
	
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