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
use frontend\models\Money;
use frontend\models\Lucky;
use frontend\models\Term;
use frontend\models\Invoice;
use frontend\models\Address;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\controllers\IsonloadController;

/**
 * Site controller
 */
class YyzcController extends IsonloadController
{
    public $SignPackage = [];
    public $setting = [];
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
	
	//一元众筹记录 ajax
	
	 public function actionYyn1json()
    {
        $get= yii::$app->request->get();//limit '. (20*$get['page']-1) .',10
		if(!empty($get['page']) && !empty($get['id']) && is_numeric($get['id']) && is_numeric($get['page'])){
			$peo = Money::findBySql('SELECT * FROM (SELECT * FROM `money` where cid = '.$get['id'].' ORDER BY `id` DESC) `money` where cid = '.$get['id'].' GROUP BY `uid` ORDER BY `id` DESC limit '. (20*$get['page']) .',10 ')->asArray()->all();
			foreach ($peo as $key =>$value) {
				$peo[$key]['time'] = date('Y-m-d H:i:s', $value['created_at']);
				$uinfo = Member::find()->where(['id'=>$value['uid']])->asArray()->one();
				$count = Money::find()->where(['uid'=>$uinfo['id'],'cid'=>$_GET['id']])->count();
				$peo[$key]['uinfo'] = $uinfo;
				$peo[$key]['count'] = $count;
			}
			echo json_encode($peo);
		}else{
			$peo['status'] = 0;
			echo json_encode($peo);
		}
    }
	
    public function actionItemlist()
    {
        $term = Term::find()->where(['parent_id'=>"8"])->all();
        if(!empty($_GET['cate'])){
            if($_GET['cate'] == "all"){
                $cate = "";
            }else{
                $cate = $_GET['cate'];
            }
        }
        if(!empty($_GET['cond'])){
            $cond = $_GET['cond'];
        }
        $termids = array();
        foreach($term as $key => $val){
            $termids[] = $val['id'];
        }
        if(empty($cate) && empty($cond)){
            $product = Product::find()->where(['term_id'=>$termids])->asArray()->all();
            return $this->render('itemlist',['term'=>$term,'product'=>$product]);
        }elseif(!empty($cate) && empty($cond)){
            if($cate == ""){
                $product = Product::find()->where(['term_id'=>$termids])->asArray()->all();
            }else{
                $product = Product::find()->where(['term_id'=>$cate])->asArray()->all();
            }
            return $this->render('itemlist',['term'=>$term,'product'=>$product]);
        }elseif(!empty($cate) && !empty($cond)){
            if($cate == ""){
                if($cond == "1"){
                    $product = Product::find()->where(['term_id'=>$termids])->orderby("created_at desc")->asArray()->all();
                    return $this->render('itemlist',['term'=>$term,'product'=>$product]);
                }elseif($cond == "2"){
                    $product = Product::find()->where(['term_id'=>$termids])->orderby("(total_money/target_money) asc")->asArray()->all();
                    return $this->render('itemlist',['term'=>$term,'product'=>$product]);
                }elseif($cond == "3"){
                    $product = Product::find()->where(['term_id'=>$termids])->orderby("total_money desc")->asArray()->all();
                    return $this->render('itemlist',['term'=>$term,'product'=>$product]);
                }elseif($cond == "4"){
                    $product = Product::find()->where(['term_id'=>$termids])->orderby("target_money asc")->asArray()->all();
                    return $this->render('itemlist',['term'=>$term,'product'=>$product]);
                }elseif($cond == "5"){
                    $product = Product::find()->where(['term_id'=>$termids])->orderby("target_money desc")->asArray()->all();
                    return $this->render('itemlist',['term'=>$term,'product'=>$product]);
                }
            }else{
                if($cond == "1"){
                    $product = Product::find()->where(['term_id'=>$cate])->orderby("created_at desc")->asArray()->all();
                    return $this->render('itemlist',['term'=>$term,'product'=>$product]);
                }elseif($cond == "2"){
                    $product = Product::find()->where(['term_id'=>$cate])->orderby("(total_money/target_money) asc")->asArray()->all();
                    return $this->render('itemlist',['term'=>$term,'product'=>$product]);
                }elseif($cond == "3"){
                    $product = Product::find()->where(['term_id'=>$cate])->orderby("total_money desc")->asArray()->all();
                    return $this->render('itemlist',['term'=>$term,'product'=>$product]);
                }elseif($cond == "4"){
                    $product = Product::find()->where(['term_id'=>$cate])->orderby("target_money asc")->asArray()->all();
                    return $this->render('itemlist',['term'=>$term,'product'=>$product]);
                }elseif($cond == "5"){
                    $product = Product::find()->where(['term_id'=>$cate])->orderby("target_money desc")->asArray()->all();
                    return $this->render('itemlist',['term'=>$term,'product'=>$product]);
                }
            }
        }elseif(empty($cate) && !empty($cond)){
            if($cond == "1"){
                $product = Product::find()->where(['term_id'=>$termids])->orderby("created_at desc")->asArray()->all();
                return $this->render('itemlist',['term'=>$term,'product'=>$product]);
            }elseif($cond == "2"){
                $product = Product::find()->where(['term_id'=>$termids])->orderby("(total_money/target_money) asc")->asArray()->all();
                return $this->render('itemlist',['term'=>$term,'product'=>$product]);
            }elseif($cond == "3"){
                $product = Product::find()->where(['term_id'=>$termids])->orderby("total_money desc")->asArray()->all();
                return $this->render('itemlist',['term'=>$term,'product'=>$product]);
            }elseif($cond == "4"){
                $product = Product::find()->where(['term_id'=>$termids])->orderby("target_money asc")->asArray()->all();
                return $this->render('itemlist',['term'=>$term,'product'=>$product]);
            }elseif($cond == "5"){
                $product = Product::find()->where(['term_id'=>$termids])->orderby("target_money desc")->asArray()->all();
                return $this->render('itemlist',['term'=>$term,'product'=>$product]);
            }
        }
    }
    public function actionProjectdetailsyy()
    {
        if(!empty($_GET['id'])){
            $id = $_GET['id'];
            $session = Yii::$app->session;
            $phone = $session->get('live');
            $me = $session->get('id');
            $userinfo = Member::find()->where(['id'=>$me])->one();

            $seen = $userinfo['seen'];
            if(strpos($seen,$id)===false){
                if(empty($seen)){
                    $data = array();
                    $new_seen = json_encode(array_merge($data,array($id)));
                    $pd = Member::updateAll(array('seen'=>$new_seen),'phone=:phone',array(':phone'=>$phone));
                }else{
                    $data = json_decode($seen);
                    $new_seen = json_encode(array_merge($data,array($id)));
                    $pd = Member::updateAll(array('seen'=>$new_seen),'phone=:phone',array(':phone'=>$phone));
                }
            }

            $product = Product::find()->where(['id'=>$id])->one();
            if(in_array($product['term_id'], array(2,3,4,5,6,7))){
                echo "<script>history.go(-1);</script>";
                exit;
            }
            if($product['total_money'] >= $product['target_money']){
                return $this->redirect('/yyzc/projectdetailsyyw/?id='.$id);
            }
            $fenxingimg = explode(',', $product['img']);
             //分享的数据
                $this->setting[0]['value'] = $product['name'];    //标题
                $this->setting[1]['value'] = $product['content'];    //描述
                $this->setting[3]['value'] = Yii::$app->request->hostInfo . Yii::$app->request->getUrl();    //link
                $this->setting[2]['value'] = Yii::$app->params['fenxiangimg'].$fenxingimg[0];    //imgurl 
               

            if(!$userinfo){
                return $this->render('projectdetailsyy',['product'=>$product,'needlogin'=>"1",'userinfo'=>$userinfo]);
            }else{
                return $this->render('projectdetailsyy',['product'=>$product,'userinfo'=>$userinfo]);
            }
        }else{
            echo "<script>history.go(-1);</script>";
        }
    }
    public function actionProjectdetailsyyw()
    {
        if(!empty($_GET['id'])){
            $id = $_GET['id'];
            $product = Product::find()->where(['id'=>$id])->one();
            if(in_array($product['term_id'], array(2,3,4,5,6,7))){
                echo "<script>history.go(-1);</script>";
                exit;
            }
            $total = $product['total_money'];
            $target = $product['target_money'];
            $endtime = $product['end_time'];
            if($total >= $target){
                if($endtime <= time()){
                    return $this->redirect('/yyzc/projectdetailsyyy/?id='.$id);
                }else{
                    $session = Yii::$app->session;
                    $phone = $session->get('live');
                    $me = $session->get('id');
                    $userinfo = Member::find()->where(['id'=>$me])->one();

                    $fenxingimg = explode(',', $product['img']);

                 //分享的数据
                    $this->setting[0]['value'] = $product['name'];    //标题
                    $this->setting[1]['value'] = $product['content'];    //描述
                    $this->setting[3]['value'] = Yii::$app->request->hostInfo . Yii::$app->request->getUrl();    //link
                    $this->setting[2]['value'] = Yii::$app->params['fenxiangimg'].$fenxingimg[0];    //imgurl 
                   
                    if(!$userinfo){
                        return $this->render('projectdetailsyyw',['product'=>$product,'needlogin'=>"1",'userinfo'=>$userinfo,'id'=>$id]);
                    }else{
                        return $this->render('projectdetailsyyw',['product'=>$product,'userinfo'=>$userinfo,'id'=>$id]);
                    }
                }
            }else{
                echo "<script>alert('非法进入页面');history.go(-1);</script>";
            }
        }else{
            echo "<script>history.go(-1);</script>";
        }
    }
    public function actionProjectdetailsyyy()
    {
        if(!empty($_GET['id'])){
            $id = $_GET['id'];
            $product = Product::find()->where(['id'=>$id])->one();
            if(in_array($product['term_id'], array(2,3,4,5,6,7))){
                echo "<script>history.go(-1);</script>";
                exit;
            }
            $total = $product['total_money'];
            $target = $product['target_money'];
            $endtime = $product['end_time'];
            if($total >= $target){
                if($endtime >= time()){
                    echo "<script>history.go(-1);</script>";
                }else{
                    $count = Lucky::find()->where(['cid'=>$id])->count();
                    $sum = Money::find()->where(['cid'=>$id,'status'=>"1"])->orderby("created_at desc")->limit(100)->sum("created_at");
                    $lucky = fmod(floatval($sum),$count) + 10000001;
                    $sort = Lucky::find()->where(['cid'=>$id,'lucky_num'=>$lucky])->one();
                    $who = Member::find()->where(['id'=>$sort['uid']])->one();
                    $times = Lucky::find()->where(['cid'=>$id,'uid'=>$sort['uid']])->count();
                    $time = Lucky::find()->where(['cid'=>$id,'uid'=>$sort['uid']])->orderby("created_at desc")->one();
                    $ins = Money::find()->where(['cid'=>$id,'uid'=>$sort['uid'],'status'=>"1"])->orderby("created_at desc")->one();
                    $invoicepd = Invoice::find()->where(['pid'=>$id,'uid'=>$sort['uid']])->one();
                    if(empty($invoicepd)){
                        $model = new Invoice();
                        $model->pid = $id;
                        $model->uid = $sort['uid'];
                        $model->name = $ins['name'];
                        $model->phone = $ins['phone'];
                        $model->address = $ins['address'];
                        $model->created_at = time();
                        $model->insert();
                    }

                    $fenxingimg = explode(',', $product['img']);
                    
                 //分享的数据
                    $this->setting[0]['value'] = $product['name'];    //标题
                    $this->setting[1]['value'] = $product['content'];    //描述
                    $this->setting[3]['value'] = Yii::$app->request->hostInfo . Yii::$app->request->getUrl();    //link
                    $this->setting[2]['value'] = Yii::$app->params['fenxiangimg'].$fenxingimg[0];    //imgurl 
                   
                    return $this->render('projectdetailsyyy',['product'=>$product,'lucky'=>$lucky,'who'=>$who,'times'=>$times,'time'=>$time]);
                }
            }else{
                echo "<script>alert('非法进入页面');history.go(-1);</script>";
            }
        }else{
            echo "<script>history.go(-1);</script>";
        }
    }
    public function actionProjectdetailsyyn1()
    {
        if(!empty($_GET['id'])){
            $cid = $_GET['id'];
            $product = Product::find()->where(['id'=>$cid])->one();
            if(in_array($product['term_id'], array(2,3,4,5,6,7))){
                echo "<script>history.go(-1);</script>";
                exit;
            }
            $peo = Money::findBySql('SELECT * FROM (SELECT * FROM `money` where cid = '.$cid.' ORDER BY `id` DESC) `money` where cid = '.$cid.' GROUP BY `uid` ORDER BY `id` DESC limit 0,20')->all();
			$cishu = Money::findBySql('SELECT * FROM (SELECT * FROM `money` where cid = '.$cid.' ORDER BY `id` DESC) `money` where cid = '.$cid.' GROUP BY `uid` ORDER BY `id` DESC')->count();
			$yeshu = floor($cishu/10);
			
            return $this->render('projectdetailsyyn1',['peo'=>$peo, 'yeshu'=>$yeshu]);
        }else{
            echo "<script>history.go(-1);</script>";
        }
    }
    public function actionProjectdetailsyyn2()
    {
        if(!empty($_GET['id'])){
            $cid = $_GET['id'];
            $cont = Product::find()->where(['id'=>$cid])->one();
            if(in_array($cont['term_id'], array(2,3,4,5,6,7))){
                echo "<script>history.go(-1);</script>";
                exit;
            }
            return $this->render('projectdetailsyyn2',['cont'=>$cont]);
        }else{
            echo "<script>history.go(-1);</script>";
        }
    }
    public function actionProjectdetailsyyn3()
    {
        if(!empty($_GET['id'])){
            $cid = $_GET['id'];
            $product = Product::find()->where(['id'=>$cid])->one();
            if(in_array($product['term_id'], array(2,3,4,5,6,7))){
                echo "<script>history.go(-1);</script>";
                exit;
            }
            $total = $product['total_money'];
            $target = $product['target_money'];
            $endtime = $product['end_time'];
            if($total >= $target){
                if($endtime >= time()){
                    echo "<script>history.go(-1);</script>";
                }else{
                    $result = Money::find()->where(['cid'=>$cid,'status'=>"1"])->orderby("created_at desc")->limit(100)->all();
                    $count = Lucky::find()->where(['cid'=>$cid])->count();
                    $sum = Money::find()->where(['cid'=>$cid,'status'=>"1"])->orderby("created_at desc")->limit(100)->sum("created_at");
                    $qy = fmod(floatval($sum),$count);
                    return $this->render('projectdetailsyyn3',['result'=>$result,'sum'=>$sum,'count'=>$count,'qy'=>$qy]);
                }
            }else{
                echo "<script>alert('非法进入页面');history.go(-1);</script>";
            }
        }else{
            echo "<script>history.go(-1);</script>";
        }
    }
    public function actionProjectdetailsyyyn1()
    {
        if(!empty($_GET['id'])){
            $cid = $_GET['id'];
            $product = Product::find()->where(['id'=>$cid])->one();
            if(in_array($product['term_id'], array(2,3,4,5,6,7))){
                echo "<script>history.go(-1);</script>";
                exit;
            }
            $total = $product['total_money'];
            $target = $product['target_money'];
            $endtime = $product['end_time'];
            if($total >= $target){
                if($endtime >= time()){
                    echo "<script>history.go(-1);</script>";
                }else{
                    $count = Lucky::find()->where(['cid'=>$cid])->count();
                    $sum = Money::find()->where(['cid'=>$cid,'status'=>"1"])->orderby("created_at desc")->limit(100)->sum("created_at");
                    $lucky = fmod(floatval($sum),$count) + 10000001;
                    $sort = Lucky::find()->where(['lucky_num'=>$lucky])->one();
                    $times = Lucky::find()->where(['uid'=>$sort['uid']])->count();
                    $nums = Lucky::find()->where(['uid'=>$sort['uid']])->all();
                    return $this->render('projectdetailsyyyn1',['times'=>$times,'nums'=>$nums,'lucky'=>$lucky]);
                }
            }else{
                echo "<script>alert('非法进入页面');history.go(-1);</script>";
            }
        }else{
            echo "<script>history.go(-1);</script>";
        }
    }
    public function actionTest()
    {
        echo "$a = $b";
        exit;
        $oid = $_GET['oid'];
        $jine = $_GET['jine'];
        $pid = $_GET['pid'];
        $find = Money::find()->where(['order_num' => $oid])->one();
        $findp = Product::find()->where(['id' => $pid])->one();

        if(empty($findp['lucky_num'])){
            for ($i=0; $i < $jine; $i++) {
                $data = 10000001 + $i;
                $model = new Lucky();
                $model->cid = $pid;
                $model->uid = $find['uid'];
                $model->lucky_num = $data;
                $model->insert();
            }
            Product::updateAll(['lucky_num'=>$data],['id'=>$pid]);
        }else{
            $k = $findp['lucky_num'] + 1;
            for ($i=0; $i < $jine; $i++) {
                $data = $k + $i;
                $model = new Lucky();
                $model->cid = $pid;
                $model->uid = $find['uid'];
                $model->lucky_num = $data;
                $model->insert();
            }
            Product::updateAll(['lucky_num'=>$data],['id'=>$pid]);
        }
    }
}
