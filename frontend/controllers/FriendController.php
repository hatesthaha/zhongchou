<?php
namespace frontend\controllers;

use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\Member;
use frontend\models\Friends;
use frontend\models\Address;
use frontend\models\Product;
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
class FriendController extends IsonloadController
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
    public function actionMyfans()
    {
        $session = Yii::$app->session;
        $phone = $session->get('live');
        $id = $session->get('id');
        if(!$phone){
            return $this->redirect('/register/register/?link='.$_SERVER["REQUEST_URI"]);
        }
		//公告
		$connection = \Yii::$app->db;
        $command = $connection->createCommand('SELECT `id`,`content`,`name`,`term_id` FROM `product` WHERE `shenhe`=1 AND `status`=2 ORDER BY `shenhe_at` DESC');
        $gonggao = $command->queryAll();
        $myf = Friends::findBySql("select * from friends where friends_id = ".$id." order by time desc")->one();
        return $this->render('myfans',['myf'=>$myf, 'gonggao'=>$gonggao]);
    }
    public function actionAddfriends()
    {
        $session = Yii::$app->session;
        $phone = $session->get('live');
        if(!$phone){
            return $this->redirect('/register/register/?link='.$_SERVER["REQUEST_URI"]);
        }
        $userinfo = Member::find()->where(['phone'=>$phone])->one();
        $id = $session->get('id');
        $friend = Friends::findBySql("select friends_id from friends where user_id = ".$id)->all();
        $L = "";
        foreach ($friend as $key => $value) {
            $L .= $value->friends_id.",";
        }
        $L = substr($L,0,-1);
        if(!empty($_GET['kw'])){
            $friendx = Member::findBySql("select * from member where phone != '".$phone."' and phone = '".$_GET['kw']."' or phone != '".$phone."' and name = '".$_GET['kw']."' order by created_at desc")->all();
            if(empty($friendx)){
                if(!empty($L)){
                    $friendx = Member::findBySql("select * from member where id not in (".$L.") and phone != ".$phone." order by created_at desc limit 0,5")->all();
                }else{
                    $friendx = Member::findBySql("select * from member where phone != ".$phone." order by created_at desc limit 0,5")->all();
                }
                return $this->render('addfriends',['friendx'=>$friendx,'userinfo'=>$userinfo,'NO'=>"1"]);
            }
            return $this->render('addfriends',['friendx'=>$friendx,'userinfo'=>$userinfo]);
        }else{
            if(!empty($L)){
                $friendx = Member::findBySql("select * from member where id not in (".$L.") and phone != ".$phone." order by created_at desc limit 0,5")->all();
            }else{
                $friendx = Member::findBySql("select * from member where phone != ".$phone." order by created_at desc limit 0,5")->all();
            }
                return $this->render('addfriends',['friendx'=>$friendx,'userinfo'=>$userinfo]);
        }
    }
    public function actionAdd()
    {
		$session = Yii::$app->session;
        $openid = $session->get('openid');
        $model = new Friends();
        $me = $_POST['me'];
        $ta = $_POST['other'];
        $check = Friends::find()->where(['user_id' => $me,'friends_id'=>$ta])->one();
        if(empty($check)){
            $model->user_id = $me;
            $model->friends_id = $ta;
            $model->time = time();
            $yes = $model->insert();
        }
		$member = Member::find()->where('id=:id', [':id'=> $ta])->asArray()->one();
        if($yes == true){
			
			//发送消息
			$data['touser'] = $openid;
			$data['content'] = "你添加了新好友【" . (empty($member['name']) ? (empty($member['phone']) ? '未命名用户' :$member['phone']) :$member['name'] ) . "】";
			
			
            echo json_encode(1);
			$this->kefumes($data);
        }else{
            echo json_encode(0);
        }
    }
    public function actionDel()
    {
        $me = $_POST['me'];
        $ta = $_POST['other'];
        $check = Friends::deleteAll('user_id = :me AND friends_id = :ta', [':me' => $me, ':ta' => $ta]);
        if(!empty($check)){
            echo json_encode($check);
        }else{
            echo json_encode(0);
        }
    }
    public function actionMyconcern()
    {
        $session = Yii::$app->session;
        $phone = $session->get('live');
        $id = $session->get('id');
        if(!$phone){
            return $this->redirect('/register/register/?link='.$_SERVER["REQUEST_URI"]);
        }
		$connection = \Yii::$app->db;
        $command = $connection->createCommand('SELECT `id`,`content`,`name`,`term_id` FROM `product` WHERE `shenhe`=1 AND `status`=2 ORDER BY `shenhe_at` DESC');
        $gonggao = $command->queryAll();
        $myc = Friends::findBySql("select * from friends where user_id = ".$id." order by time desc")->all();
        return $this->render('myconcern',['myc'=>$myc, 'gonggao'=>$gonggao]);
    }
    public function actionAccountitem()
    {
        $session = Yii::$app->session;
        $phone = $session->get('live');
        $me = $session->get('id');
        if(!$phone){
            return $this->redirect('/register/register/?link='.$_SERVER["REQUEST_URI"]);
        }
        if(empty($_GET['id'])){
			if (empty($_GET['uid'])) {
				 echo"<script>history.go(-1);</script>";exit;
			} else {
				 $openid = $_GET['uid'];
				$data = Member::find()->where('openid=:openid', [':openid'=>$openid])->one();
				if(!empty($data)){
					$fpro = Product::find()->where(['user_id'=>$data['id']])->all();
					$spro = Collect::find()->where(['user_id'=>$data['id']])->all();
					$isfrd = Friends::find()->where(['user_id'=>$me,'friends_id'=>$data['id']])->one();
				} else {
					echo"<script>history.go(-1);</script>";exit;
				}
				if(!empty($isfrd)){
					$yes = "1";
				}else{
					$yes = "0";
				}
				
			}
        }else{
            $id = $_GET['id'];
            $data = Member::find()->where(['id'=>$id])->one();
            $fpro = Product::find()->where(['user_id'=>$id])->all();
            $spro = Collect::find()->where(['user_id'=>$id])->all();
            $isfrd = Friends::find()->where(['user_id'=>$me,'friends_id'=>$id])->one();
            if(!empty($isfrd)){
                $yes = "1";
            }else{
                $yes = "0";
            }
        }
        return $this->render('accountitem',['data'=>$data,'fpro'=>$fpro,'spro'=>$spro,'yes'=>$yes,'me'=>$me]);
    }
}
