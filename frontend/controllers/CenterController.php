<?php
namespace frontend\controllers;

use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\Member;
use frontend\models\Address;
use frontend\models\Friends;
use frontend\models\Article;
use frontend\models\Signed;
use frontend\models\Collect;
use frontend\models\Product;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile; 
use frontend\controllers\IsonloadController;
use frontend\controllers\SortController;
/**
 * Site controller
 */
class CenterController extends IsonloadController
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
    public function actionEditinformation()
    {
        $session = Yii::$app->session;
        $phone = $session->get('live');
        if(!$phone){
            return $this->redirect('/register/register/?link='.$_SERVER["REQUEST_URI"]);
        }
        if($_POST){
            $editinformation = htmlspecialchars($_POST['editinformation']);
            $session = Yii::$app->session;
            $phone = $session->get('live');
            $res = Member::updateAll(array('signature'=>$editinformation),'phone=:phone',array(':phone'=>$phone));
            echo 1;exit;
        }
      echo 0;
    }
    public function actionInfoemail()
    {
        $session = Yii::$app->session;
        $phone = $session->get('live');
        if(!$phone){
            return $this->redirect('/register/register/?link='.$_SERVER["REQUEST_URI"]);
        }
        if($_POST){
            $email = htmlspecialchars($_POST['email']);
            $session = Yii::$app->session;
            $phone = $session->get('live');
			$check = Member::find()->where(['email'=>$email])->one();
			//邮箱已存在
			if($check){
				echo 2;exit;
			}
            $res = Member::updateAll(array('email'=>$email),'phone=:phone',array(':phone'=>$phone));
			echo $res;exit;
        }
        echo 0;
    }
    public function actionInfoname()
    {
        $session = Yii::$app->session;
        $phone = $session->get('live');
        if(!$phone){
            return $this->redirect('/register/register/?link='.$_SERVER["REQUEST_URI"]);
        }
        if($_POST){
            $name = htmlspecialchars($_POST['name']);
            $session = Yii::$app->session;
            $phone = $session->get('live');
            $res = Member::updateAll(array('name'=>$name),'phone=:phone',array(':phone'=>$phone));
            echo $res;exit;
        }
        echo 0;
    }
    public function actionInfosex()
    {
        $session = Yii::$app->session;
        $phone = $session->get('live');
        if(!$phone){
            return $this->redirect('/register/register/?link='.$_SERVER["REQUEST_URI"]);
        }
        if($_POST){
            $sex = htmlspecialchars($_POST['gender']);
            $session = Yii::$app->session;
            $phone = $session->get('live');
            $res = Member::updateAll(array('gender'=>$sex),'phone=:phone',array(':phone'=>$phone));
			echo $res;exit;
        }
        echo 0;
    }
    public function actionInfohead()
    {
        $session = Yii::$app->session;
        $phone = $session->get('live');
        if(!$phone){
            return $this->redirect('/register/register/?link='.$_SERVER["REQUEST_URI"]);
        }
        if (Yii::$app->request->isPost) {
            $model = new Member();
			$file = Yii::$app->request->post();
			$contractName = mt_rand(1100,9900) .time() .'.jpeg';
			$filedir = 'upload/' .$contractName;
			$base64=base64_decode($file["base64_string"]);
			$save = file_put_contents($filedir, $base64);  
            $res = Member::updateAll(array('head'=>$contractName),'phone=:phone',array(':phone'=>$phone));
			if($save && $res){
				echo 1;
			}
        }
		echo 0;
    }
    public function actionInfopassword()
    {
        $session = Yii::$app->session;
        $phone = $session->get('live');
        if(!$phone){
            return $this->redirect('/register/register/?link='.$_SERVER["REQUEST_URI"]);
        }
        if($_POST){
            $password = $_POST['password'];
            $session = Yii::$app->session;
            $phone = $session->get('live');
            $password_hash = MD5($password);
            Member::updateAll(array('password_hash'=>$password_hash),'phone=:phone',array(':phone'=>$phone));
            return $this->redirect('/register/register');
        }
        return $this->render('infopassword',['phone'=>$phone]);
    }
    public function actionInfophone()
    {
        $session = Yii::$app->session;
        $phone = $session->get('live');
        if(!$phone){
            return $this->redirect('/register/register/?link='.$_SERVER["REQUEST_URI"]);
        }
        if($_POST){
            $phone = htmlspecialchars($_POST['phone']);
            $session = Yii::$app->session;
            $openid = $session['openid'];
            Member::updateAll(array('phone'=>$phone),'openid=:openid',array(':openid'=>$openid));

            $session->set('live', $phone);
            $lifeTime = 3600*6;  // 保存一天 
            session_set_cookie_params($lifeTime); 
            if(!empty($_GET['link'])){
                return $this->redirect($_GET['link']);
            }else{
                return $this->redirect('/center/personaldata');
            }

            return $this->redirect('/register/register');
        }
        return $this->render('infophone');
    }
    public function actionPersonalcenter()
    {
        $session = Yii::$app->session;
        $phone = $session->get('live');
        $id = $session->get('id');
        if(!$phone){
            return $this->redirect('/register/register/?link='.$_SERVER["REQUEST_URI"]);
        }
        $userinfo = Member::find()->where(['phone' => $phone])->one();
        $addpd = Address::find()->where(['userid' => $id])->one();
        $focus = Friends::find()->andWhere(['user_id' => $id])->count('id');
        $fans = Friends::find()->andWhere(['friends_id' => $id])->count('id');
        return $this->render('PersonalCenter',['userinfo'=>$userinfo,'addpd'=>$addpd,'focus'=>$focus,'fans'=>$fans]);
    }
    public function actionCommonproblem()
    {
        $session = Yii::$app->session;
        $phone = $session->get('live');
        if(!$phone){
            return $this->redirect('/register/register/?link='.$_SERVER["REQUEST_URI"]);
        }
		if (empty($_GET['aid'])){
			$commonproblem = Article::find()->where(['id' => "2"])->one();
		}elseif(is_numeric($_GET['aid'])){
			$commonproblem = Article::find()->where(['id' => $_GET['aid']])->one();
		}
		if(empty($commonproblem)){
			$commonproblem = Article::find()->where(['id' => "2"])->one();
		}
        return $this->render('commonproblem',['commonproblem'=>$commonproblem]);
    }
	
	/**
	资格说明模块
	*/
	 public function actionZigeshuoming()
    {
        $session = Yii::$app->session;
        $uid = $session->get('id');
        if(!$uid){
            return $this->redirect('/register/signin/?link='.$_SERVER["REQUEST_URI"]);
        }
		$userinfo = Member::find()->where('id=:id', [':id'=>$uid])->asArray()->one();
		$zigeshuoming = Article::find()->where(['id' => 8])->one();
		if(empty($zigeshuoming)){
			$zigeshuoming = Article::find()->where(['id' => "2"])->one();
		}
        return $this->render('zigeshuoming',['zigeshuoming'=>$zigeshuoming, 'userinfo'=>$userinfo ]);
    }
	
    public function actionMycollection()
    {
        $session = Yii::$app->session;
        $phone = $session->get('live');
        $id = $session->get('id');
        if(!$phone){
            return $this->redirect('/register/signin/?link='.$_SERVER["REQUEST_URI"]);
        }
        $coll = Collect::find()->where(['user_id' => $id])->All();

        $goodids = array();
        foreach($coll as $key => $value){
            $goodids[] = $value['goods_id'];
        }
        $collect = Product::find()->where(['id' => $goodids])->all();
        return $this->render('mycollection',['collect'=>$collect]);
    }
    public function actionPersonaldata()
    {
        $session = Yii::$app->session;
        $phone = $session->get('live');
        if(!$phone){
            return $this->redirect('/register/signin/?link='.$_SERVER["REQUEST_URI"]);
        }
        $userinfo = Member::find()->where(['phone' => $phone])->one();
        return $this->render('personalData',['userinfo'=>$userinfo]);
    }
    public function actionVintroduce()
    {
        $session = Yii::$app->session;
        $phone = $session->get('live');
        if(!$phone){
            return $this->redirect('/register/signin/?link='.$_SERVER["REQUEST_URI"]);
        }
        $userinfo = Member::find()->where(['phone' => $phone])->one();
        return $this->render('vintroduce',['userinfo'=>$userinfo]);
    }
    public function actionSigned()
    {
        $session = Yii::$app->session;
        $phone = $session->get('live');
        $id = $session->get('id');
        if(!$phone){
            return $this->redirect('/register/signin/?link='.$_SERVER["REQUEST_URI"]);
        }
        $data = Signed::find()->where(['user_id' => $id])->one();
        $monthcheck = date("m",time());
        $actmonth = sprintf("%02d",$data['month']);
        if($monthcheck != $actmonth){
            $empty = NULL;
            Signed::updateAll(array('day_array'=>$empty),'user_id=:user_id',array(':user_id'=>$id));
        }
        $data = Signed::find()->where(['user_id' => $id])->one();
        $day = str_replace("[","",$data['day_array']);
        $day = str_replace("]","",$day);
        $break = json_decode($data['day_array']);
        $key = count($break)-1;
        if(empty($break[$key])){
            $break[$key] = 0;
        }
        return $this->render('signed',['id'=>$id,'day'=>$day,'pd'=>$break[$key]]);
    }
    public function actionCheck_ins()
    {
        $session = Yii::$app->session;
        $user_id = $session->get('id');
        if(empty($_POST['id'])){
            echo json_encode(1);
        }else{
            $id = $_POST['id'];
            $month = date("m",time());
            $day = sprintf ( "%02d",date("d",time()));
            $find = Signed::find()->where(['user_id' => $id])->one();
            $stra = $find['day_array'];
            $strb = strval($day);
            $strc = $find['month'];
            if($month == $strc){
                if(!strstr($stra,$strb)){
                    $data = json_decode($find['day_array']);
                    $sign = array_merge($data,array($day));
                    $sign = json_encode($sign);
                    $pd = Signed::updateAll(array('day_array'=>$sign),'user_id=:user_id',array(':user_id'=>$id));
                    if(!empty($pd)){
                        $prestige = Member::find()->where(['id'=>$user_id])->one();
                        $prestige['prestige'] += 1 ;
                        $up = Member::updateAll(array('prestige'=>$prestige['prestige']),'id=:id',array(':id'=>$user_id));
                        if(!empty($up)){
                            echo json_encode(2);
                        }
                    }else{
                        echo json_encode(3);
                    }
                }else{
                    echo json_encode(4);
                }
            }else{
                $data = array();
                $dataa = json_encode($data);
                Signed::updateAll(array('day_array'=>$dataa,"month"=>$month),'user_id=:user_id',array(':user_id'=>$id));
                $sign = array_merge($data,array($day));
                $sign = json_encode($sign);
                $pd = Signed::updateAll(array('day_array'=>$sign),'user_id=:user_id',array(':user_id'=>$id));
                if(!empty($pd)){
                    $prestige = Member::find()->where(['id'=>$user_id])->one();
                    $prestige['prestige'] += 1 ;
                    $up = Member::updateAll(array('prestige'=>$prestige['prestige']),'id=:id',array(':id'=>$user_id));
                    if(!empty($up)){
                        echo json_encode(2);
                    }
                }else{
                    echo json_encode(3);
                }
            }
        }
    }
    public function actionAboutus()
    {
        // $session = Yii::$app->session;
        // $phone = $session->get('live');
		$get = Yii::$app->request->get();
        // if(!$phone){
            // return $this->redirect('/register/signin/?link='.$_SERVER["REQUEST_URI"]);
        // }
		if (!empty($get['id']) && is_numeric($get['id'])) {
			$aboutus = Article::find()->where(['id' => $get['id']])->one();
		} else {
			$aboutus = Article::find()->where(['id' => "1"])->one();
		}
        return $this->render('aboutus',['aboutus'=>$aboutus]);
    }
    public function actionQuit()
    {
        $session = Yii::$app->session;
        $session->remove('live');
        $session->remove('id');
        return $this->redirect('/register/signin');
    }
}
