<?php
namespace frontend\controllers;

use Yii;

use frontend\models\Member;

use frontend\models\Slider;

use yii\web\Controller;

use frontend\controllers\SortController;



/**
 * Site controller
 */
class SiteController extends SortController
{
    public $SignPackage = [];
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
			// [
				// 'class' => 'yii\filters\HttpCache',
				// 'only' => ['index'],
				// 'lastModified' => function ($action, $params) {
					// $q = new \yii\db\Query();
					//return 
					// $a = $q->from('product')->max('shenhe_at');
					// $b = $q->from('product')->max('end_time');
					//var_dump(($a>$b)?$a:$b);exit;
					
					// return ($a>$b)?$a:$b;
				// },
			// ],
            // 'access' => [
                // 'class' => AccessControl::className(),
                // 'only' => ['logout', 'signup'],
                // 'rules' => [
                    // [
                        // 'actions' => ['signup'],
                        // 'allow' => true,
                        // 'roles' => ['?'],
                    // ],
                    // [
                        // 'actions' => ['logout'],
                        // 'allow' => true,
                        // 'roles' => ['@'],
                    // ],
                // ],
            // ],
            // 'verbs' => [
                // 'class' => VerbFilter::className(),
                // 'actions' => [
                    // 'logout' => ['post'],
                // ],
            // ],
			// [
				// 'class' => 'yii\filters\PageCache',
				// 'only' => ['ceshi'],
				// 'duration' => 60,
				// 'variations' => [
					// \Yii::$app->language,
				// ],
			// ]
        ];
    }
	
    public function actions()
    {
		$this->SignPackage = $this->getSignPackage();
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
	
	//测试
    public function actionCeshi(){
		 $session = Yii::$app->session;
		if(empty($session['openid'])){
			require_once(Yii::getAlias('@vendor') . "/payment/wxpay/lib/WxPay.JsApiPay.php");
			$tools = new \JsApiPay();
			$session->set('openid', $tools->GetOpenid());
			$lifeTime = 3600*6;  // 保存6小时 
            session_set_cookie_params($lifeTime); 
		}
		$connection = \Yii::$app->db;
			//总注册人数
		$command = $connection->createCommand('SELECT COUNT(*) FROM member');
		$member_num = $command->queryScalar();
        return $this->render('ceshi',compact('member_num', 'session'));
    }
	
	
	
	
	
	
	
	//操作指南
    public function actionCaozuozhinan(){
		$get = yii::$app->request->get();
		if(!empty($get['isok']) && $get['isok'] == 1){
			$session = Yii::$app->session;
			if(empty($session['openid'])){
				require_once(Yii::getAlias('@vendor') . "/payment/wxpay/lib/WxPay.JsApiPay.php");
				$tools = new \JsApiPay();
				$session->set('openid', $tools->GetOpenid());
			}
			$newuser = new Member();
			$newuser->openid = $session['openid'];
			$newuser->save();
			return $this->redirect('/site/index');
		}
        $caozuozhinan = Article::find()->where(['id' => "5"])->one();
        return $this->render('caozuozhinan',['caozuozhinan'=>$caozuozhinan]);
    }
	
	//index
    public function actionIndex()
    {
		 $session = Yii::$app->session;
		if(empty($session['openid'])){
			require_once(Yii::getAlias('@vendor') . "/payment/wxpay/lib/WxPay.JsApiPay.php");
			$tools = new \JsApiPay();
			$session->set('openid', $tools->GetOpenid());
			$lifeTime = 3600*6;  // 保存6小时 
            session_set_cookie_params($lifeTime); 
		}
		$member = Member::find()->where('openid=:openid',[':openid'=>$session['openid']])->one();
		if(empty($member)){
			$newuser = new Member();
			$newuser->openid = $session['openid'];
			$newuser->save();
		}
		
        return $this->render('index',compact('session'));
    }
	
	
	
	//index
    public function actionIndexa()
    {
		$session = Yii::$app->session;
		if(empty($session['openid'])){
			require_once(Yii::getAlias('@vendor') . "/payment/wxpay/lib/WxPay.JsApiPay.php");
			$tools = new \JsApiPay();
			$session->set('openid', $tools->GetOpenid());
			$lifeTime = 3600*6;  // 保存6小时 
            session_set_cookie_params($lifeTime); 
		}
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
        //轮播图片
        $slider = new \frontend\models\Slider;
        $lunbo = $slider->find()->where(['status'=>"1"])->orderby("listorder desc")->asArray()->all();


        $connection = \Yii::$app->db;
        //公告
        $command = $connection->createCommand('SELECT `id`,`content`,`name`,`term_id` FROM `product` WHERE `shenhe`=1 AND `status`=2 ORDER BY `created_at` DESC LIMIT 0,5');
        $gonggao = $command->queryAll();
        //总注册人数
        $command = $connection->createCommand('SELECT COUNT(*) FROM member');
        $member_num = $command->queryScalar();
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
        // $command = $connection->createCommand('SELECT `product`.* FROM `product`LEFT JOIN `member` ON `product`.`user_id`=`member`.`id` WHERE  `product`.`shenhe`=1 AND `product`.`term_id` = 3 AND `product`.`status`<>1 ORDER BY `member`.`prestige` DESC LIMIT 0,3');
        // $product[2] = $command->queryAll();
        // $product[2]['term'] = $term[3];
        // $product[2]['tid'] = "3";
        // $command = $connection->createCommand('SELECT `product`.* FROM `product`LEFT JOIN `member` ON `product`.`user_id`=`member`.`id` WHERE  `product`.`shenhe`=1 AND  `product`.`term_id` = 4 AND `product`.`status`<>1 ORDER BY `member`.`prestige` DESC LIMIT 0,3');
        // $product[3] = $command->queryAll();
        // $product[3]['term'] = $term[4];
        // $product[3]['tid'] = "4";
        // $command = $connection->createCommand('SELECT `product`.* FROM `product`LEFT JOIN `member` ON `product`.`user_id`=`member`.`id` WHERE `product`.`shenhe`=1 AND  `product`.`term_id` = 5 AND `product`.`status`<>1 ORDER BY `member`.`prestige` DESC LIMIT 0,3');
        // $product[4] = $command->queryAll();
        // $product[4]['term'] =$term[5];
        // $product[4]['tid'] = "5";
        // $command = $connection->createCommand('SELECT `product`.* FROM `product`LEFT JOIN `member` ON `product`.`user_id`=`member`.`id` WHERE  `product`.`shenhe`=1 AND `product`.`term_id` = 6 AND `product`.`status`<>1 ORDER BY `member`.`prestige` DESC LIMIT 0,3');
        // $product[5] = $command->queryAll();
        // $product[5]['term'] = $term[6];
        // $product[5]['tid'] = "6";

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
		
        return $this->render('index',compact('product','product1','gonggao','member_num','lunbo','session'));
    }
}
