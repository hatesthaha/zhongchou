<?php
namespace frontend\controllers;

use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\Member;
use frontend\models\Product;
use backend\models\Mubannews;
use frontend\models\Money;
use frontend\models\Address;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\db\Query ;
use frontend\models\Invoice;
use frontend\controllers\IsonloadController;

/**
 * Site controller
 */
class OrderController extends IsonloadController
{
    public $SignPackage = [];
    /**
     * @inheritdoc
     */
    function init(){
        $this->zidongshouhuo();
    }
    function zidongshouhuo(){

        $session = Yii::$app->session;
        $phone = $session->get('live');
        $member_id = $session->get('id');
        if(!$member_id){
            return $this->redirect('/register/register/?link='.$_SERVER["REQUEST_URI"]);
        }
        $time = time()-(86400*10);
	
		$find = Invoice::find()->where(" `uid`=:member_id AND `deliver_at`<:time AND `status`=1",
			[':member_id'=>$member_id, ':time'=>$time])->asArray()->all();
		if ($find) {
			$isshouhuo = Invoice::updateAll(['`status`'=>2,'`over_at`'=>time()], 
				" `uid`=:member_id AND `deliver_at`<:time AND `status`=1",
				[':member_id'=>$member_id,':time'=>$time]);
				$pname = "";
				$order_num = "";
				if ($isshouhuo) {
					foreach ($find as $key =>$val) {
						$pro = Product::find()->where('id=:id', [':id' =>$val['pid']])->asArray()->one();
						$pname .= '【'. $pro['name'] .'】';
						$order_num .= '【' . $val['invoice_no'] . '】';
					}
					
					$mubannews = Mubannews::find()->where('name=:name', [':name'=> "订单状态更新"])->asArray()->one();
					$member = Member::find()->where('id=:id', [':id'=>$member_id])->asArray()->one();
					//发送客服消息--模板消息
					$data['template_id'] = $mubannews['template_id'];
					$data['touser'] = $member['openid'];
					$data['url'] = "http://bingbingzm.com/order/myorder/";
					if (empty($mubannews['first'])) {
						$data[0]['value'] = "您的众筹产品".$pname."已自动收货";
					} else {
						$data[0]['value'] = sprintf($mubannews['first'], $pname);
					}
					$data[0]['key'] = 'first';
					$data[1]['key'] = 'OrderSn';
					$data[2]['key'] = 'OrderStatus';
					$data[3]['key'] = 'remark';
					
					$data[1]['value'] = $order_num;
					$data[2]['value'] = '已自动收货';
					$data[3]['value'] = empty($mubannews['Remark']) ? "发货时间达到十天自动收货" : $mubannews['Remark'] ;
					
					$res = $this->sendMobanmes1($data);
				}
				
				
		}
		
    }
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
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
    //货单详情
    public function actionOrderfahuo(){
            $session = Yii::$app->session;
            $phone = $session->get('live');
            $member_id = $session->get('id');
            if(!$member_id){
                return $this->redirect('/register/register/?link='.$_SERVER["REQUEST_URI"]);
            }
            $order_num = yii::$app->request->get('oid');
            if($order_num){
                $order_detail = (new Query())
                    ->select("*")
                    ->from('invoice')
                    ->Where("uid = $member_id")//参数绑定的方法
                    ->andWhere('order_id = :name', [':name' => $order_num])
                    ->one();
                if($order_detail){
                    $pid = (new Query())
                    ->select("*")
                    ->from('product')
                    ->Where("id =".$order_detail['pid'])//参数绑定的方法
                    ->one();
                    $order_detail['term_id'] = $pid['term_id'];
                    $order_detail['pname'] = $pid['name'];
                    $order_detail['img'] = $pid['img'];
                    $order_detail['total_money'] = $pid['total_money'];
                    $order_detail['shenghuotianshu'] = floor((86400*10 -(time()-$order_detail['deliver_at']))/86400);
                    //var_dump($order_detail);exit;
                    return $this->render('orderfahuo',compact('order_detail'));
                }
                return $this->render('orderfahuo',compact('order_detail'));
            }
    }

//订单详情
    public function actionOrderdetails(){
            $session = Yii::$app->session;
            $phone = $session->get('live');
            $member_id = $session->get('id');
            if(!$member_id){
                return $this->redirect('/register/register/?link='.$_SERVER["REQUEST_URI"]);
            }
            $order_num = yii::$app->request->get('oid');
            if($order_num){
                $order_detail = (new Query())
                    ->select("*")
                    ->from('money')
                    ->Where("uid = $member_id and isshow=0")//参数绑定的方法
                    ->andWhere('order_num = :name', [':name' => $order_num])
                    ->one();
                if($order_detail){
                    $pid = (new Query())
                    ->select("*")
                    ->from('product')
                    ->Where("id =".$order_detail['cid'])//参数绑定的方法
                    ->one();
					 if(!empty($pid)){
						  $order_detail['faqiren'] = (new Query())
						->select("*")
						->from('member')
						->Where("id =".$pid['user_id'])//参数绑定的方法
						->one();
						$order_detail['term_id'] = $pid['term_id'];
						if($pid['status']==1 && $order_detail['status']==0){
							$order_detail['status']=2;
						}
						if($pid['status']==0 && $order_detail['status']==0){
							$order_detail['status']=3;
						}
					} else {
						 $yanzheng = (new Money)->deleteAll('uid = :name and order_num=:oid', [':name' =>$member_id,':oid'=>$order_num]);//参数绑定的方法
						echo "<script>alert('此订单已失效！');history.back();</script>";exit;
					}
                   
                    //var_dump($order_detail);exit;
                    return $this->render('orderdetails',compact('order_detail'));
                }
                return $this->render('orderdetails',compact('order_detail'));
            }
    }

//取消订单
    
    public function actionCancel(){

            $session = Yii::$app->session;
            $phone = $session->get('live');
            $member_id = $session->get('id');
            if(!$member_id){
                return $this->redirect('/register/register/?link='.$_SERVER["REQUEST_URI"]);
            }
        $content = \yii::$app->request->get('oid');
        if(isset($content) && $content!="" ){
            $yanzheng = (new Money)->deleteAll('uid = :name and order_num=:oid', [':name' =>$member_id,'oid'=>$content]);//参数绑定的方法
            return $this->redirect('/order/myorder');
            exit;
            
        }else{
             return $this->redirect('/order/myorder');
            exit;
        }
       

    }
	
	
	
	//取消订单
    
    public function actionCancelfahuo(){

            $session = Yii::$app->session;
            $phone = $session->get('live');
            $member_id = $session->get('id');
            if(!$member_id){
                return $this->redirect('/register/register/?link='.$_SERVER["REQUEST_URI"]);
            }
        $content = \yii::$app->request->get('oid');
        if(isset($content) && $content!="" ){
            Invoice::updateAll(['`isshow`'=>1]," `uid`=:member_id AND `status`=2 AND `order_id`=:id",[':member_id'=>$member_id,':id'=>$content]);//参数绑定的方法
            return $this->redirect('/order/myorder');
            exit;
            
        }else{
             return $this->redirect('/order/myorder');
            exit;
        }
       

    }
	
	
	
	
	
    //下单
    
    public function actionXiadan(){
       $data = yii::$app->request->post();
	   $pid = $data['pid'];
       if(is_numeric($data['id'])){
            $member_id = $data['id'];
        }
            if(empty($member_id)){
                //返回状态2  未登录
                $respond['status'] = 2;
                echo json_encode($respond);
                exit;
            }
       if(is_numeric($data['jine']) && $data['jine'] > 0 && is_numeric($data['pid'])){
            if(!preg_match("/^[0-9]+(.[0-9]{1,2})?$/",$data['jine'])){
                $respond['status'] = 4;
                echo json_encode($respond); 
                exit;
            }
            $connection = \Yii::$app->db;
            $product = (new Query())
                ->select("user_id")
                ->from('product')
                ->Where('id = :name', [':name' =>$data['pid']])//参数绑定的方法
                ->one();
                if($member_id == $product['user_id']){
                    //不能购买自己的产品
                    $respond['status'] = 3;
                    echo json_encode($respond); 
                    exit;
                }

            $order_num = substr($member_id, -1).substr(MD5(time()),0,8).rand(0,9);

            // $money = new Money; 
            // $money->money = $data['jine'] ;
            // $money->uid = $member_id;
            // $money->cid = $data['pid'];
            // $money->order_num = $order_num;
            // if($data['info']!=""){
            //     $money->info = $data['info'];

            // }
            $command = $connection->createCommand()->insert('money', [
                'money' => $data['jine'],
                'created_at' => time(),
                'uid' => $member_id,
                'cid'=> $data['pid'],
                'order_num'=> $order_num,
                'status'=>0,
                //'info'=>$data['info'],
            ]);

            if($command->execute() > 0){
                //返回状态1，成功下单，进入支付选择页面
                $respond['status'] = 1;
                $respond['jine'] = $data['jine'];
                $respond['order_num'] = $order_num;
				$respond['pid'] = $pid;
             echo json_encode($respond); 
             }else{
              //返回状态1 下单失败
               $respond['status'] = 0;
                echo json_encode($respond); 
             }
        
       }

    }

	
	//下订单ajax
    public function actionXiadanyy(){
       $data = yii::$app->request->post();
       if(is_numeric($data['id'])){
            $member_id = $data['id'];
        }
        if(empty($member_id)){
                //返回状态2  未登录
                $respond['status'] = 2;
                echo json_encode($respond);
                exit;
        }

                //var_dump($data);exit;
        if(empty($data['aid'])|| !is_numeric($data['aid'])){
                //返回状态3  没选择地址
                $respond['status'] = 3;
                echo json_encode($respond);
                exit;
        }else{
            $connection = \Yii::$app->db;
            $address = (new Query())
                ->select("*")
                ->from('address')
                ->Where('id = :name', [':name' =>$data['aid']])//参数绑定的方法
                ->one();
            if(empty($address)){
                //返回状态3  没选择地址
                $respond['status'] = 3;
                echo json_encode($respond);
                exit;
            }
        }
       if(is_numeric($data['jine']) && $data['jine'] > 0 && is_numeric($data['pid'])){
            $product = (new Query())
                ->select("user_id")
                ->from('product')
                ->Where('id = :name', [':name' =>$data['pid']])//参数绑定的方法
                ->one();
            $order_num = substr($member_id, -1).substr(MD5(time()),0,8).rand(0,9);
            $command = $connection->createCommand()->insert('money', [
                'money' => $data['jine'],
                'created_at' => time(),
                'uid' => $member_id,
                'cid'=> $data['pid'],
                'order_num'=> $order_num,
                'status'=>0,
                'name' =>$address['username'],
                'phone' => $address['phone'],
                'address'=> $address['province'].$address['city'].$address['county'].$address['address'],
                //'info'=>$data['info'],
            ]);
            if($command->execute() > 0){
                //返回状态1，成功下单，进入支付选择页面
                $respond['status'] = 1;
                $respond['jine'] = $data['jine'];
                $respond['order_num'] = $order_num;
                $respond['pid'] = $data['pid'];
             echo json_encode($respond); 
             }else{
              //返回状态1 下单失败
               $respond['status'] = 0;
                echo json_encode($respond); 
             }
       }
    }
    //确认收货
    public function actionQueren(){
        $session = Yii::$app->session;
        $phone = $session->get('live');
        $member_id = $session->get('id');
        if(!$member_id){
            return $this->redirect('/register/register/?link='.$_SERVER["REQUEST_URI"]);
        }
        $content = \yii::$app->request->get('oid');
        $content = urldecode($content);
        //echo $content;exit;
        if(isset($content) && $content!="" ){
            Invoice::updateAll(['`status`'=>2,'`over_at`'=>time()]," `uid`=:member_id AND `status`=1 AND `order_id`=:id",[':member_id'=>$member_id,':id'=>$content]);//参数绑定的方法
            return $this->redirect('/order/myorder');
            exit;
            
        }else{
            return $this->redirect('/order/myorder');
            exit;
        }

    }
    //取消订单
    
    public function actionQuerenajax(){

        $session = Yii::$app->session;
        $phone = $session->get('live');
        $member_id = $session->get('id');
        if(!$member_id){
            //返回状态2  未登录
            $respond['status'] = 0;
            echo json_encode($respond);
            exit;
        }
        $content = \yii::$app->request->get('oid');
		
        if(isset($content) && $content!="" ){
			$invoice = Invoice::find()->where(" `uid`=:member_id AND `status`=1 AND `invoice_no`=:id",[':member_id'=>$member_id,':id'=>$content])->asArray()->one();
			if ($invoice) {
				$yanzheng = Invoice::updateAll(['`status`'=>2,'`over_at`'=>time()]," `uid`=:member_id AND `status`=1 AND `invoice_no`=:id",[':member_id'=>$member_id,':id'=>$content]);//参数绑定的方法//参数绑定的方法
				if($yanzheng){
					 //确认收货成功
					$respond['status'] = 1;
					echo json_encode($respond);

						$product = Product::find()->where('id=:id', [':id' =>$invoice['pid']])->asArray()->one();
						$mubannews = Mubannews::find()->where('name=:name', [':name'=> "订单状态更新"])->asArray()->one();
						$member = Member::find()->where('id=:id', [':id'=>$member_id])->asArray()->one();
						//发送客服消息--模板消息
						$data['template_id'] = $mubannews['template_id'];
						$data['touser'] = $member['openid'];
						$data['url'] = "http://bingbingzm.com/order/myorder/";
						if (empty($mubannews['first'])) {
							$data[0]['value'] = "您的众筹产品".$product['name']."已收货";
						} else {
							$data[0]['value'] = sprintf($mubannews['first'], $product['name']);
						}
						$data[0]['key'] = 'first';
						$data[1]['key'] = 'OrderSn';
						$data[2]['key'] = 'OrderStatus';
						$data[3]['key'] = 'remark';
						
						$data[1]['value'] = $content;
						$data[2]['value'] = '已确认收货';
						$data[3]['value'] = empty($mubannews['Remark']) ? "您已确认收货，感谢您的参与" : $mubannews['Remark'] ;
						
						$res = $this->sendMobanmes1($data);
					exit;
				}else{
					//确认收货失败
					$respond['status'] = 2;
					echo json_encode($respond);
					exit;
				}
			}
            
        }else{
            //确认收货失败
            $respond['status'] = 2;
            echo json_encode($respond);
            exit;
        }
       

    }
    //选择金额，准备下单
    
    public function actionOrderinformation(){
         // $member_id = 1;
            $session = Yii::$app->session;
            $phone = $session->get('live');
            $member_id = $session->get('id');
            if(!$member_id){
                return $this->redirect('/register/register/?link='.$_SERVER["REQUEST_URI"]);
            }
        $pid = yii::$app->request->get('pid');
        //echo $pid;exit;
        if(isset($pid) && $pid !="" && is_numeric($pid)){

            $product = (new Query())
                ->select("id,user_id,s_num,term_id")
                ->from('product')
                ->Where('id = :name', [':name' =>$pid])//参数绑定的方法
                ->one();
        }else{
            echo "<script>history.go(-1);</script>"; exit;
        }
        //var_dump($product);exit;
        //自己的项目不能下单
        if(isset($product) && $product['user_id'] ==$member_id){
            echo "<script>history.go(-1);</script>";
            exit;
        }
        //var_dump($product);exit;
        return $this->render('orderinformation',compact('product','member_id'));
    }
	
	  //选择金额，准备下单
    
    public function actionBuyshengwang(){
         // $member_id = 1;
            $session = Yii::$app->session;
            $phone = $session->get('live');
            $member_id = $session->get('id');
            if(!$member_id){
                return $this->redirect('/register/register/?link='.$_SERVER["REQUEST_URI"]);
            }
        $pid = yii::$app->request->get('pid');
        //echo $pid;exit;
        if(isset($pid) && $pid !="" && is_numeric($pid)){

            $product = (new Query())
                ->select("id,user_id,s_num,term_id")
                ->from('product')
                ->Where('id = :name', [':name' =>$pid])//参数绑定的方法
                ->one();
        }else{
            echo "<script>history.go(-1);</script>"; exit;
        }
        //var_dump($product);exit;
        //自己的项目不能下单
        if(isset($product) && $product['user_id'] ==$member_id){
            echo "<script>history.go(-1);</script>";
            exit;
        }
        //var_dump($product);exit;
        return $this->render('buyshengwang',compact('product','member_id'));
    }

    public function actionOrderinformationyy(){
         // $member_id = 1;
            $session = Yii::$app->session;
            $phone = $session->get('live');
            $member_id = $session->get('id');
            if(!$member_id){
                return $this->redirect('/register/register/?link='.$_SERVER["REQUEST_URI"]);
            }
        $pid = yii::$app->request->get('pid');
        //echo $pid;exit;
        if(isset($pid) && $pid !="" && is_numeric($pid)){
            $product = (new Query())
                ->select("*")
                ->from('product')
                ->Where('id = :name', [':name' =>$pid])//参数绑定的方法
                ->one();
        }else{
            echo "<script>history.go(-1);</script>"; exit;
        }
        if(isset($product) && $product['user_id'] ==$member_id){
            echo "<script>history.go(-1);</script>";
            exit;
        }
        //var_dump($product);exit;
        if(!empty($_GET['id'])){
            $address = Address::find()->where(['id'=>$_GET['id']])->one();
            return $this->render('orderinformationyy',['address'=>$address,'product'=>$product,'member_id'=>$member_id]);
        }else{
            return $this->render('orderinformationyy',['noadd'=>"1",'product'=>$product,'member_id'=>$member_id]);
        }

        return $this->render('orderinformationyy',['noadd'=>"1",'product'=>$product,'member_id'=>$member_id]);
    }

    //我的订单
    public function actionMyorder(){
            $session = Yii::$app->session;
            $phone = $session->get('live');
            $member_id = $session->get('id');
            if(!$member_id){
                return $this->redirect('/register/register/?link='.$_SERVER["REQUEST_URI"]);
            }
            $product0 = (new Query())
                ->select("*")
                ->from('money')
                ->Where('uid = :name and isshow=0', [':name' =>$member_id])//参数绑定的方法
                ->orderBy('created_at DESC')
                ->all();
            $nopay = array();
            $waitdeliver = array();
            $waitreceipt = array();
            if(isset($product0) && !empty($product0)){
                foreach ($product0 as $key => $value) {
                    $product_name = (new Query())
                        ->select("id,user_id,name,img,status")
                        ->from('product')
                        ->Where('id ='.$value['cid'])//参数绑定的方法
                        ->one();
                        $product0[$key]['pname'] = $value['pname'] = $product_name['name'];
                        $product0[$key]['puid'] = $value['puid'] = $product_name['user_id'];
                        $product0[$key]['img'] = $value['img'] = $product_name['img'];
                        $product0[$key]['cid'] = $value['cid'] = $product_name['id'];
						//支付超时
                        if($product_name['status']==1 && $value['status']==0){
                            $product0[$key]['status'] = $value['status'] = 2;
                        }
						//支付暂停
						if($product_name['status']==0 && $value['status']==0){
                            $product0[$key]['status'] = $value['status'] = 3;
                        }
                        $product0[$key]['ispay'] = 1;
                    if($value['status'] == 0 || $value['status']==2 || $value['status']==3){
                        $nopay[] = $value;
                    }
                }
            }
            //var_dump($nopay);exit;
            $product1 = (new Query())
                ->select("*")
                ->from('invoice')
                ->Where('uid = :name and isshow=0', [':name' =>$member_id])//参数绑定的方法
                ->orderBy('created_at DESC')
                ->all();
            if(!empty($product1)){
                foreach ($product1 as $key => $value1) {
                    $product_name = (new Query())
                        ->select("user_id,total_money,name,img")
                        ->from('product')
                        ->Where('id ='.$value1['pid'])//参数绑定的方法
                        ->one();
                        $product1[$key]['pname'] = $value1['pname'] = $product_name['name'];
                        $product1[$key]['puid'] = $value1['puid'] = $product_name['user_id'];
                        $product1[$key]['img'] = $value1['img'] = $product_name['img'];
                        $product1[$key]['total_money'] = $value1['total_money'] = $product_name['total_money'];
                        $product1[$key]['shenghuotianshu'] = $value1['shenghuotianshu'] =floor((86400*10 -(time()-$value1['deliver_at']))/86400);
                        $product1[$key]['ispay'] = 0;
                    if($value1['status'] == 0){
                        $waitdeliver[] = $value1;
                    }
                    if($value1['status'] == 1){
                        $waitreceipt[] = $value1;
                    }
                }
            }
       return $this->render('myorder',compact('product0','product1','nopay','waitdeliver','waitreceipt'));
    }
}
