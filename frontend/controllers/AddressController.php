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
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\controllers\IsonloadController;

/**
 * Site controller
 */
class AddressController extends IsonloadController
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
    public function actionReceiptaddaddress()
    {
        $session = Yii::$app->session;
        $phone = $session->get('live');
        if(!$phone){
            return $this->redirect('/register/register/?link='.$_SERVER["REQUEST_URI"]);
        }
        if($_POST){
            $id = $session->get('id');
            $model = new Address();
            $model->userid = $id;
            $model->username = $_POST['name'];
            $model->phone = $_POST['phone'];
            $model->province = $_POST['s_province'];
            $model->city = $_POST['s_city'];
            $model->county = $_POST['s_county'];
            $model->address = $_POST['addressdetail'];
            $model->created_at = time();
            $model->insert();
            return $this->redirect('/address/receiptaddaddress2');
        }
        return $this->render('receiptaddaddress');
    }
    public function actionReceiptaddaddress3()
    {
        $session = Yii::$app->session;
        $phone = $session->get('live');
        if(!$phone){
            return $this->redirect('/register/register/?link='.$_SERVER["REQUEST_URI"]);
        }
        if($_POST){
            $id = $session->get('id');
            $model = new Address();
            $model->userid = $id;
            $model->username = $_POST['name'];
            $model->phone = $_POST['phone'];
            $model->province = $_POST['s_province'];
            $model->city = $_POST['s_city'];
            $model->county = $_POST['s_county'];
            $model->address = $_POST['addressdetail'];
            $model->created_at = time();
            $model->insert();
            if(!empty($_GET['type']) && !empty($_GET['pid'])){
                return $this->redirect('/address/manageaddress/?type=yy&pid='.$_GET['pid']);
            }elseif(!empty($_GET['xiugai']) && $_GET['xiugai'] = "true" && !empty($_GET['pid']) && is_numeric($_GET['pid'])){
				return $this->redirect('/address/manageaddress?xiugai=true&pid='.$_GET['pid']);
			} else{
                return $this->redirect('/address/manageaddress');
            }
        }
        return $this->render('receiptaddaddress3');
    }
    public function actionReceiptaddaddress2()
    {
        $session = Yii::$app->session;
        $phone = $session->get('live');
        if(!$phone){
            return $this->redirect('/register/register/?link='.$_SERVER["REQUEST_URI"]);
        }
        $id = $session->get('id');
        $add = Address::find()->where(['userid' => $id])->all();
        return $this->render('receiptaddaddress2',['add'=>$add]);
    }
    public function actionManageaddress()
    {
        $session = Yii::$app->session;
        $phone = $session->get('live');
        if(!$phone){
            return $this->redirect('/register/register/?link='.$_SERVER["REQUEST_URI"]);
        }
        $id = $session->get('id');
        $add = Address::find()->where(['userid' => $id])->all();
        return $this->render('manageaddress',['add'=>$add]);
    }
    public function actionChooseaddress()
    {
        $session = Yii::$app->session;
        $phone = $session->get('live');
        if(!$phone){
            return $this->redirect('/register/register/?link='.$_SERVER["REQUEST_URI"]);
        }
        $id = $session->get('id');
        $add = Address::find()->where(['userid' => $id])->all();
        return $this->render('chooseaddress',['add'=>$add]);
    }
    public function actionNoaddress()
    {
        $session = Yii::$app->session;
        $phone = $session->get('live');
        if(!$phone){
            return $this->redirect('/register/register/?link='.$_SERVER["REQUEST_URI"]);
        }
        return $this->render('noaddress');
    }
    public function actionReceiptaddress()
    {
        $session = Yii::$app->session;
        $phone = $session->get('live');
        if(!$phone){
            return $this->redirect('/register/register/?link='.$_SERVER["REQUEST_URI"]);
        }
        $id = !empty($_GET['id'])?$_GET['id']:0;
        $userid = $session->get('id');
        $pd = Address::find()->where(['id' =>$id,'userid'=>$userid])->one();
        if(!$pd){
            echo"<script>history.go(-1);</script>";
        }
        if($_POST){
            $id = $_POST['id'];
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $province = $_POST['s_province'];
            $city = $_POST['s_city'];
            $county = $_POST['s_county'];
            $address = $_POST['addressdetail'];
            $updated_at = time();
            Address::updateAll(array('username'=>$name,'phone'=>$phone,'province'=>$province,'city'=>$city,'county'=>$county,'address'=>$address,'updated_at'=>$updated_at),'id=:id',array(':id'=>$id));
            return $this->redirect('/address/receiptaddaddress2');
        }
        return $this->render('ReceiptAddress',['info'=>$pd]);
    }
    public function actionGodie()
    {
        $id = $_POST['id'];
        $pd = Address::findOne($id)->delete();
        if($pd){
            echo json_encode(1);
        }else{
            echo json_encode(0);
        }
    }
}
