<?php
namespace frontend\controllers;

use wanhunet\wanhunet;
use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\Member;
use frontend\models\Address;
use frontend\models\Invoice;
use frontend\models\Money;
use frontend\models\Product;
use frontend\models\Lucky;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use wanhunet\alipay\AlipayPay;
use wanhunet\alipay\lib\AlipaySubmit;
use wanhunet\alipay\Aliconfig;
use wanhunet\alipay\lib\AlipayNotify;
use wanhunet\alipay\lib\AlipayCore;
use yii\db\Query ;
use yii\helpers\Url;
use frontend\controllers\SortController;
/**
 * Site controller
 */
class PayController extends SortController
{
    public $SignPackage = [];
    /**
     * @inheritdoc
     */
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
                    'wxpay-order-notify' => ['post'],
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
    public function actionIspay(){
        $oid = yii::$app->request->post('oid');
        if(!isset($oid)){
            echo 0;exit;
        }
        $find = Money::find()->where(['order_num' => $oid])->one();
        if($find['status']==1){
            echo 0;
        }else{
            echo 1;
        }
    }
    public function actionPayinformation()
    {
        $jine = yii::$app->request->get('jine');
        $oid = yii::$app->request->get('oid');
        $pid = yii::$app->request->get('pid');
        $name = (new Query())->select("status")->from('product')->Where('id ='.$pid)->one();
        if($name['status']==1){
            echo "<script>alert('您所支持的项目已筹款完成，不用再支付啦！');history.back();</script>";exit;
        }







        //支付成功后
        // $oid = $_GET['oid'];
        // $jine = $_GET['jine'];
        // $pid = $_GET['pid'];
        // if(!empty($oid)){
        //     $find = Money::find()->where(['order_num' => $oid])->one();
        //     $findp = Product::find()->where(['id' => $pid])->one();
        //     if(empty($find['lucky'])){
        //         $find['lucky'] = array();
        //         for ($i=0; $i < $jine+1; $i++) {
        //             $find['lucky'] = array_merge($find['lucky'],array(10000000 + $i));
        //         }
        //         $k = array_slice($find['lucky'],-1,1);
        //         Money::updateAll(array('lucky'=>$find['lucky']),'order_num=:oid',array(':oid'=>$oid));
        //         Product::updateAll(array('lucky_num'=>$k[0]),'id=:pid',array(':pid'=>$pid));
        //     }else{
        //         $data = json_decode($find['lucky']);
        //         $k = $findp['lucky_num'];
        //         for ($i=0; $i < $jine+1; $i++) {
        //             $find['lucky'] = array_merge($data,array($k + $i));
        //         }
        //         Money::updateAll(array('lucky'=>$find['lucky']),'oid=:oid',array(':oid'=>$oid));
        //     }
        //     exit;
        // }













        return $this->render('payinformation',compact('jine','oid','pid'));
    }
    //向支付宝建立请求
    public function actionPayconfirm()
    {
        header("Content-type:text/html;charset=utf-8");
        $jine = Yii::$app->request->get()['jine'];
        $oid = Yii::$app->request->get()['oid'];
        $pid = Yii::$app->request->get()['pid'];
        $name = (new Query())->select("name")->from('product')->Where('id ='.$pid)->one();
        $alipay_config['partner'] =  Yii::$app->params['aliPartner'];
        $alipay_config['seller_email'] =  Yii::$app->params['aliSellerEmail'];
        $alipay_config['key'] = Yii::$app->params['aliKey'];
        $alipay_config['sign_type']    = strtoupper('MD5');
        $alipay_config['input_charset']= strtolower('utf-8');
        $alipay_config['cacert']    = getcwd().'\\cacert.pem';
        $alipay_config['transport']    = 'http';

        //支付类型
        $payment_type = "1";
        //必填，不能修改
        //服务器异步通知页面路径
        $notify_url = Yii::$app->params["frontendurl"]."pay/notify";
        //需http://格式的完整路径，不能加?id=123这类自定义参数

        //页面跳转同步通知页面路径
        $return_url = Yii::$app->params["frontendurl"]."pay/return";
        //需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/


        //商品展示地址
        $show_url = '';
        //需以http://开头的完整路径，例如：http://www.商户网址.com/myorder.html

        //防钓鱼时间戳
        $anti_phishing_key = "";
        //若要使用请调用类文件submit中的query_timestamp函数

        //客户端的IP地址
        $exter_invoke_ip = "";
        //非局域网的外网IP地址，如：221.0.0.1


        /************************************************************/

        //构造要请求的参数数组，无需改动
        $parameter = array(
                "service" => "create_direct_pay_by_user",
                "partner" => trim($alipay_config['partner']),
                "seller_email" => trim($alipay_config['seller_email']),
                "payment_type"  => $payment_type,
                "notify_url"    => $notify_url,
                "return_url"    => $return_url,
                "out_trade_no"  => trim($oid),
                "total_fee" => $jine,
                "subject" => $name['name'],
                "show_url"  => $show_url,
                "anti_phishing_key" => $anti_phishing_key,
                "exter_invoke_ip"   => $exter_invoke_ip,
                "_input_charset"    => trim(strtolower($alipay_config['input_charset']))
        );
        //建立请求
        $alipaySubmit = new AlipaySubmit($alipay_config);
        $html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认支付");
        echo $html_text;
    }
    //支付宝异步通知，更新支付状态
    public function actionNotify()
    {
        if($_POST['trade_no']){
            $time = time();
            Money::updateAll(array('status'=>1,'trade_no'=>$_POST['trade_no'],'payway'=>'alipay','updated_at' => $time),'order_num=:order_num',array(':order_num'=>$_POST['out_trade_no']));
            $order = Money::find()->where(['order_num' => $_POST['out_trade_no']])->one();
            $product = Product::find()->where(['id' => $order['cid']])->one();
            $userinfo = Member::find()->where(['id'=>$order['uid']])->one();
            $jine = $order['money'];
            $term = array(2,3,4,5,6,7);
            $welfare = array(7);
            $mpro = array(2,3,4,5,6);
            //对应的项目total_money数额增加(所有)
            $ed_total = $product['total_money'];
            $now_total = $ed_total + $jine;
            Product::updateAll(['total_money'=>$now_total,'s_num'=>$product['s_num']+1],['id'=>$order['cid']]);
            //增加声望(公益梦)
            if (in_array($product['term_id'], $welfare)){
                $ed_prestige = $userinfo['prestige'];
                $now_prestige = $ed_prestige + ($jine * 10);
                Member::updateAll(['prestige'=>$now_prestige],['id'=>$order['uid']]);
                $finds = Product::find()->where(['id' => $pid])->one();
                if($finds['total_money'] >= $finds['target_money']||time()>=$finds['end_time']){
                    Product::updateAll(['end_time'=>$now_time,'status'=>1],['id'=>$pid]);
                }

            }

            //增加发布项目金额的上限(普通项目)
            if (in_array($product['term_id'], $mpro)){
                $ed_ceiling = $userinfo['ceiling'];//10
                $ed_day = $userinfo['day'];//16864
                $new_jine = $jine *10;//10
                $now_ceiling = $ed_ceiling + $new_jine;//20
                $now_time_d = floor(time()/86400);//16864
                if($ed_day == $now_time_d){
                    if($ed_ceiling < 1000){
                        if($now_ceiling <= 1000){
                            Member::updateAll(['ceiling'=>$now_ceiling],['id'=>$order['uid']]);
                        }elseif($now_ceiling >1000){
                            Member::updateAll(['ceiling'=>'1000'],['id'=>$order['uid']]);
                        }
                    }
                }else{
                    if($new_jine < 1000){
                        Member::updateAll(['tmoney'=>$ed_ceiling,'ceiling'=>$new_jine,'day'=>$now_time_d],['id'=>$order['uid']]);
                    }elseif($jine >= 1000){
                        Member::updateAll(['tmoney'=>$ed_ceiling,'ceiling'=>'1000','day'=>$now_time_d],['id'=>$order['uid']]);
                    }
                    
                }


                $finds = Product::find()->where(['id' => $pid])->one();
                if($finds['total_money'] >= $finds['target_money']){
                    Product::updateAll(['end_time'=>$now_time,'status'=>1],['id'=>$pid]);
                    Invoice::updateAll(['status'=>0],['pid'=>$pid]);
                    $connection = \Yii::$app->db;
                          //栏目对应的周期天数
                    $term_arr = [
                       '2'=>1,
                       '3'=>3,
                       '4'=>5,
                       '5'=>7,
                       '6'=>9,
                    ];
                    $term_id=$finds->term_id;
                    //天数为进一取整，当前周期为向下取整
                    $now_zhouqi = floor(ceil(time()/86400)/$term_arr[$term_id]);
                    //首先上线已排序的产品
                    $command = $connection->createCommand(sprintf('UPDATE `product` SET `status`=%u,`sorted_at`=%u ,`updated_at`=%u  WHERE `term_id`=%u AND `shenhe`=1 AND `status`=0 AND `sorted_at`>0 ORDER BY `sorted_at` ASC,`sorted_at` ASC LIMIT 1',2,0,$now_zhouqi,$term_id));
                    //判断是否上线成功
                    $isshangxian = $command->execute();
                    //如果没有上线成功
                    if($isshangxian==0){
                        //检查此栏目下是否有未排序产品
                        $command = $connection->createCommand(sprintf('SELECT `product`.`id` FROM `product` LEFT JOIN `member` ON `product`.`user_id`=`member`.`id`  WHERE `product`.`term_id`=%u AND `product`.`shenhe`=1 AND `product`.`status`=0 AND `product`.`sorted_at`=0 ORDER BY `member`.`prestige` DESC LIMIT 0,1',$term_id));
                        $res1 = $command->queryOne();
                        if($res1){
                            $command = $connection->createCommand(sprintf('UPDATE `product` SET `status`=2,`sorted_at`=0,`updated_at`=%u WHERE `id`=%u  AND `shenhe`=1',$now_zhouqi,$res1['id']));
                            $command->execute();
                        }
                        //上线完成后。对所有产品进行排序，sorted_at=updated_at+1；
                        // $command = $connection->createCommand(sprintf('SELECT `product`.* FROM `product` LEFT JOIN `member` ON `product`.`user_id`=`member`.`id`  WHERE `product`.`term_id`=%u AND `product`.`shenhe`=1 AND `product`.`sorted_at`=0 AND `product`.`status`=0 AND `product`.`updated_at`<%u ORDER BY `product`.`updated_at` ASC,`member`.`prestige` DESC',$term_id,$now_zhouqi));
                        // $res2 = $command->queryAll();
                        // if($res2){
                        //     foreach ($res2 as $key => $pro) {
                        //         $command = $connection->createCommand(sprintf('UPDATE `product` SET `sorted_at`=`updated_at`+1,`updated_at`=%u,`sort`=%u WHERE `id`=%u  AND `shenhe`=1 AND `status`=0' ,$now_zhouqi,$key+1,$pro['id']));
                        //         $command->execute();
                        //     }
                        // }

                    }
                }

            }

            //一元众筹发送随机码(一元众筹)
            if (!in_array($product['term_id'], $term)){
                $oid = $order['order_num'];
                $jine = $order['money'];
                $pid = $order['cid'];
                if($product['total_money'] < $product['target_money']){
                    if(empty($product['lucky_num'])){
                        for ($i=0; $i < $jine; $i++) {
                            $data = 10000001 + $i;
                            $model = new Lucky();
                            $model->cid = $pid;
                            $model->uid = $order['uid'];
                            $model->lucky_num = $data;
                            $model->insert();
                        }
                        Product::updateAll(['lucky_num'=>$data],['id'=>$pid]);
                    }else{
                        $k = $product['lucky_num'] + 1;
                        for ($i=0; $i < $jine; $i++) {
                            $data = $k + $i;
                            $model = new Lucky();
                            $model->cid = $pid;
                            $model->uid = $order['uid'];
                            $model->lucky_num = $data;
                            $model->insert();
                        }
                        Product::updateAll(['lucky_num'=>$data],['id'=>$pid]);
                    }
                }
                $finds = Product::find()->where(['id' => $pid])->one();
                if($finds['total_money'] >= $finds['target_money'] && empty($finds['end_time'])){
                    $now_time = time() + 300;
                    Product::updateAll(['end_time'=>$now_time],['id'=>$pid]);
                }
            }


            


            echo "success";
        }else{
            echo "fail";
        }
    }
    //支付宝支付成功页面
        public function actionReturn($out_trade_no)
    {
        return $this->render('paysuccess');
    }





    //微信支付  微信支付
     public function actionWeixin()
    {
        
        $jine = Yii::$app->request->get()['jine'];
        $oid = Yii::$app->request->get()['oid'];
        $pid = Yii::$app->request->get()['pid'];
        $jine = $jine*100;
        $name = (new Query())->select("name,status")->from('product')->Where('id ='.$pid)->one();
        $money = (new Query())->select("status")->from('money')->Where(['`order_num`' =>$oid])->one();
        if($money['status']==1){
            echo "<script>alert('此订单已支付，不用再支付啦！');history.back(-2);</script>";exit;
        }
        if($name['status']!=2){
            echo "<script>alert('您所支持的项目已筹款完成或者还未开始，请勿支付支付啦！');history.back();</script>";exit;
        }
        if(empty($jine) || empty($oid) ||empty($pid))
        {
            echo '请输入金额';
        }
        else
        {
            require_once(Yii::getAlias('@vendor') . "/payment/wxpay/lib/WxPay.Api.php");
            require_once(Yii::getAlias('@vendor') . "/payment/wxpay/lib/WxPay.JsApiPay.php");
            $tools = new \JsApiPay();
			
			$session = Yii::$app->session;
			if (!empty($session['openid'])) {
				$openId = $session['openid'];
			} else {
				$openId = $tools->GetOpenid();
			}
            $input = new \WxPayUnifiedOrder();
            $input->SetBody($name['name']);
            $input->SetAttach("test");
            $input->SetOut_trade_no($oid);
            $input->SetTotal_fee($jine);
            $input->SetTime_start(date("YmdHis"));
            $input->SetTime_expire(date("YmdHis", time() + 1800));
            $input->SetGoods_tag("test");
            $input->SetNotify_url(Yii::$app->params["frontendurl"].'pay/wxpaynotify');
            $input->SetTrade_type("JSAPI");
            $input->SetOpenid($openId);
            $orderform = \WxPayApi::unifiedOrder($input);
            $jsApiParameters = $tools->GetJsApiParameters($orderform);
            return $this->render('weixinpay',compact('jine','oid','pid','name','jsApiParameters'));  
        }
       
    }
    public function actionWxpaynotify()
    { 
        //Yii::$app->response->format = Response::FORMAT_RAW;
        require_once(Yii::getAlias('@vendor') . "/payment/wxpay/class/PayNotifyCallBack.php");
        $notify = new \PayNotifyCallBack();
        $notify->Handle(false);
        
    }
    
}
