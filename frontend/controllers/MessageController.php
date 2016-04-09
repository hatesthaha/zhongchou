<?php
namespace frontend\controllers;

use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\Member;
use frontend\models\Message;
use frontend\models\Product;
use frontend\models\Address;
use frontend\models\Setting;
use frontend\models\Collect;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\controllers\IsonloadController;

/**
 * Site controller
 */
class MessageController extends IsonloadController
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
    public function actionMynews()
    {
        $session = Yii::$app->session;
        $phone = $session->get('live');
        if(!$phone){
            return $this->redirect('/register/register/?link='.$_SERVER["REQUEST_URI"]);
        }
        $setting = Setting::find()->where(['parent_id'=>"3"])->all();
        //var_dump($setting[1]);exit;
        $userinfo = Member::find()->where(['phone'=>$phone])->one();
        $id = $session->get('id');
        $message = Message::findBySql("select * from (select * from `message` where to_id = ".$id." order by `created_at` desc) `message` group by from_id order by `created_at` desc")->limit(20)->all();
        //$message = Message::findBySql("select * from message where to_id = ".$id." group by from_id order by id desc")->all();
        $product = Product::findBySql("select * from product where shenhe = 1 and created_at > ".$userinfo->created_at." order by id desc")->limit(20)->all();
        $myprow = Collect::findBySql("select * from collect where user_id = ".$id." order by id desc")->all();
        if(!empty($myprow)){
            foreach ($myprow as $key => $value) {
                $mypro = Product::findBySql("select * from product where id = ".$value['goods_id']." order by id desc")->all();
            }
        }
        if(!empty($mypro)){
            return $this->render('mynews',['userinfo'=>$userinfo,'message'=>$message,'product'=>$product,'mypro'=>$mypro]);
        }else{
            return $this->render('mynews',['userinfo'=>$userinfo,'message'=>$message,'product'=>$product]);
        }
    }
    public function actionReply()
    {
        $session = Yii::$app->session;
        $phone = $session->get('live');
        if(!$phone){
            return $this->redirect('/register/register/?link='.$_SERVER["REQUEST_URI"]);
        }
        if($_POST){
            $id = $session->get('id');
            if(empty($_GET['to'])){
                echo"<script>history.go(-2);</script>";
            }else{
                $from = $_GET['to'];
                $to = $id;
                $message = $_POST['editinformation'];
                $model = new Message();
                $model->from_id = $to;
                $model->to_id = $from;
                $model->message = $message;
                $model->created_at = time();
                $model->updated_at = $model->created_at + 7200;
                $model->insert();
                return $this->redirect('/message/privateletter/?from='.$from.'&me='.$to);
            }
        }
        return $this->render('reply');
    }
    public function actionPrivateletter()
    {
        $session = Yii::$app->session;
        $phone = $session->get('live');
        if(!$phone){
            return $this->redirect('/register/register/?link='.$_SERVER["REQUEST_URI"]);
        }
        if(empty($_GET['from']) || empty($_GET['me'])){
            echo"<script>history.go(-1);</script>";
        }else{
            $from = $_GET['from'];
            $me = $_GET['me'];
            $userinfo = Member::find()->where(['phone' => $phone])->one();
            $ta = Member::find()->where(['id' => $from])->one();
            $message = Message::findBySql('SELECT * FROM message where from_id = '.$from.' and to_id = '.$me.' or from_id = '.$me.' and to_id = '.$from)->all();
            $pd = Message::findBySql('SELECT * FROM message where from_id = '.$from.' and to_id = '.$me.' order by id DESC')->one();
            if($pd['type'] != "1"){
                Message::updateAll(array('type'=>'1'),'id=:id',array(':id'=>$pd['id']));
            }
            return $this->render('privateletter',['message'=>$message,'userinfo'=>$userinfo,'ta'=>$ta]);
        }
    }
}
