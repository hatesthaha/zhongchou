<?php
namespace frontend\controllers;

use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\Member;
use frontend\models\Signed;
use frontend\models\Setting;
use frontend\models\Address;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\controllers\SortController;


/**
 * Site controller
 */
class RegisterController extends SortController
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
    public function actionRegister()
    {
        $session = Yii::$app->session;
        if(empty($session['openid'])){
            require_once(Yii::getAlias('@vendor') . "/payment/wxpay/lib/WxPay.JsApiPay.php");
            $tools = new \JsApiPay();
            $session->set('openid', $tools->GetOpenid());
        }
        if($_POST){
            if($_POST['phone'] && $_POST['code']){
                $model = new Member();
                $model->phone = $_POST['phone'];
                $model->created_at = time();
                //$model->password_hash = MD5($_POST['password']);
                $model->openid = $session['openid'];
                $find = Member::find()->where(['openid' => $session['openid']])->one();
                if($find){
                    Member::updateAll(array('updated_at'=>time(),'phone'=>$_POST['phone']),'openid=:openid',array(':openid'=>$session['openid']));
                    $userinfo = Member::find()->where(['phone'=>$_POST['phone'],'openid'=>$session['openid']])->one();
                }else{
                    $find1 = Member::find()->where(['phone' => $_POST['phone']])->one();
                    if($find1){
                        Member::updateAll(array('updated_at'=>time(),'phone'=>$_POST['phone'] ,'openid'=>$session['openid']),'phone=:phone',array(':phone'=>$_POST['phone']));
                    }else{
                        $pd = $model->insert();
                    }
                    $userinfo = Member::find()->where(['phone'=>$_POST['phone'],'openid'=>$session['openid']])->one();
                    if(!empty($pd)){
                        $smodel = new Signed();
                        $smodel->user_id = $userinfo->id;
                        $smodel->insert();
                    }
                }
                $session->set('live', $userinfo['phone']);
                $session->set('id', $userinfo['id']);
                $lifeTime = 3600*6;  // 保存一天 
                session_set_cookie_params($lifeTime); 
                if(!empty($_GET['link'])){
                    return $this->redirect($_GET['link']);
                }else{
                    return $this->redirect('/center/personalcenter');
                }
            }
        }
        //var_dump( $GLOBALS['_openid']);exit;
        return $this->render('register');
    }
    public function actionForgetpassword()
    {
        if($_POST){
            if($_POST['phone'] && $_POST['code'] && $_POST['password']){
                $model = new Member();
                $model->phone = $_POST['phone'];
                $model->created_at = time();
                $model->password_hash = MD5($_POST['password']);
                $find = Member::find()->where(['phone' => $_POST['phone']])->one();
                if($find){
                    Member::updateAll(array('password_hash'=>$model->password_hash,'updated_at'=>time()),'phone=:phone',array(':phone'=>$model->phone));
                }else{
                    $model->insert();
                }
                return $this->redirect('/register/signin');
            }
        }
        return $this->render('forgetpassword');
    }
    public function actionSignin()
    {
        if($_POST){
            $emailorphone = $_POST['emailorphone'];
            $jc = "@";
            $password = $_POST['password'];
            $password_hash = MD5($password);

            if(strpos($emailorphone,$jc)!==false){
                $userinfo = Member::find()->where(['email' => $emailorphone,'password_hash' => $password_hash])->one();
            }else{
                $userinfo = Member::find()->where(['phone' => $emailorphone,'password_hash' => $password_hash])->one();
            }
            if($userinfo){
                $session = Yii::$app->session;
                $session->set('live', $userinfo['phone']);
                $session->set('id', $userinfo['id']);
                $lifeTime = 3600*6;  // 保存一天 
                session_set_cookie_params($lifeTime); 
                if(!empty($_GET['link'])){
                    return $this->redirect($_GET['link']);
                }else{
                    return $this->redirect('/center/personalcenter');
                }
            }else{
                return $this->redirect('/register/signin/?login=error');
            }
        }
        return $this->render('signin');
    }
    public function actionAgreement()
    {
        return $this->render('agreement');
    }
    public function actionCheckcode()
    {
        $code = $_POST['code'];
        $arr = $_POST['phone'];
        $session = Yii::$app->session;
        $dbcode = $session[$arr.'code'];
        if($code == $dbcode){
            $res = 1;
        }else{
            $res = 0;
        }
        echo json_encode($res);
    }
    public function actionGetnow()
    {
		$data = Setting::find()->where(['parent_id' => '4'])->all();
		$uid = $data[0]['value'];		//数字用户名
		$pwd = $data[1]['value'];		//密码
		$http = $data[2]['value'];
		
        $arr = $_POST['phone'];
		$mobile	 = $arr;
        $arra=array();
        while(count($arra)<6){
        $arra[]=rand(1,9);
        $arra=array_unique($arra);
        }
        $arra=implode($arra);
		$content = "你好，验证码：{$arra}【仌仌众筹】";		//内容
		$content = mb_convert_encoding($content,"GBK","UTF-8");
        $session = Yii::$app->session;
        $session->set($arr.'code', $arra);

		$res = $this->sendSMS($uid,$pwd,$mobile,$content,$http);
		echo json_encode(array("res"=>$res,"arra"=>$arra));
    }
	
	public function sendSMS($uid,$pwd,$mobile,$content,$http,$time='',$mid='')
	{
		$data = array
			(
			'uid'=>$uid,					//数字用户名
			'pwd'=>strtolower(md5($pwd)),	//MD5位32密码
			'mobile'=>$mobile,				//号码
			'content'=>$content,			//内容 如果对方是utf-8编码，则需转码iconv('gbk','utf-8',$content); 如果是gbk则无需转码
			'time'=>$time,		//定时发送
			'mid'=>$mid						//子扩展号
			);
		$re= $this->postSMS($http,$data);			//POST方式提交
		if( trim($re) == '100' )
		{
			return true;
		}
		else 
		{
			return $re;
		}
	}
	
	public function postSMS($url,$data)
	{
		$post='';
		$row = parse_url($url);
		$host = $row['host'];
		$port = 80;
		$file = $row['path'];
		while (list($k,$v) = each($data)) 
		{
			$post .= rawurlencode($k)."=".rawurlencode($v)."&";	//转URL标准码
		}
		$post = substr( $post , 0 , -1 );
		$len = strlen($post);
		$fp = @fsockopen( $host ,$port, $errno, $errstr, 10);
		if (!$fp) {
			return "$errstr ($errno)\n";
		} else {
			$receive = '';
			$out = "POST $file HTTP/1.0\r\n";
			$out .= "Host: $host\r\n";
			$out .= "Content-type: application/x-www-form-urlencoded\r\n";
			$out .= "Connection: Close\r\n";
			$out .= "Content-Length: $len\r\n\r\n";
			$out .= $post;		
			fwrite($fp, $out);
			while (!feof($fp)) {
				$receive .= fgets($fp, 128);
			}
			fclose($fp);
			$receive = explode("\r\n\r\n",$receive);
			unset($receive[0]);
			return implode("",$receive);
		}
	}
	
	
	
    public function actionCheckphone()
    {
        $arr = $_POST['phone'];
        $check = Member::find()->where(['phone'=>$arr])->one();
        if(empty($check)){
            echo json_encode(1);
        }else{
            echo json_encode(0);
        }
    }
    public function actionCheckemail()
    {
        $arr = $_POST['email'];
        $check = Member::find()->where(['email'=>$arr])->one();
        if(empty($check)){
            echo json_encode(1);
        }else{
            echo json_encode(0);
        }
    }
}
