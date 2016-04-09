<?php
namespace frontend\controllers;

use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\Member;
use frontend\models\Collect;
use frontend\models\Money;
use frontend\models\Address;
use frontend\models\Invoice;
use frontend\models\Friends;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\Product;
use frontend\models\Term;
use frontend\models\Article;
use yii\base\ErrorException;
use yii\data\Pagination;
use yii\web\UploadedFile; 
use yii\helpers\Html;
use frontend\models\UploadForm; 
use frontend\controllers\IsonloadController;

/**
 * Site controller
 */
class ProjectController extends IsonloadController
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
    public function actionMylaunch()
    {
        $session = Yii::$app->session;
        $phone = $session->get('live');
        if(!$phone){
            return $this->redirect('/register/register/?link='.$_SERVER["REQUEST_URI"]);
        }
		//用户发起的项目周期
		$termzq1 = Yii::$app->params['termzq1'];
		$uinfo = Member::find()->where(['phone'=>$phone])->one();
		$product_info = Product::find()->where(['user_id'=>$uinfo->id])->asArray()->all();
		foreach($product_info as $k => $v){
			if($v['sorted_at'] == 0){
				$v['sorted_at']  = floor(ceil(time()/86400)/$termzq1[$v['term_id']]);
			}
			if ($product_info[$k]['sorted_at'] !=0) {
				$product_info[$k]['paixu'] = Product::find()->where(
					'term_id=:term_id and status=0 and shenhe=1 and (sorted_at<:sorted_at
					 and sorted_at> 0 
					or ( sorted_at=:sorted_at and sort <=:sort))',
				[':term_id' => $v['term_id'] ,
					':sorted_at' => $v['sorted_at'] ,
					':sort' => $v['sort'],
				])
				->count();
			} else {
				$product_info[$k]['paixu'] = Product::find()->where(
					'term_id=:term_id and status=0 and shenhe=1 and sorted_at<:sorted_at',
				[':term_id' => $v['term_id'] ,
					':sorted_at' => $v['sorted_at'] ,
				])
				->count() +1;
			}
			if (in_array($v['term_id'], [2,3,4,5,6])) {
				$product_info[$k]['waittime'] = $product_info[$k]['paixu'] * $termzq1[$v['term_id']];
			}
			$termname = Yii::$app->params['termname'];
			$product_info[$k]['term'] = $termname[$v['term_id']];
			$img = explode(",",$v['img']);
			$product_info[$k]['img']=$img[0];
		}
		//var_dump($product_info);exit;
        return $this->render('mylaunch',['product'=>$product_info,'uinfo'=>$uinfo]);
    }

    public function actionCheck()
    {
        $id = $_POST['id'];
        $userinfo = Member::find()->where(['id'=>$id])->one();
		//当用户tmoney <100 ，提示用户不能发起项目
		if ($userinfo['tmoney']<100) {
			echo 3;
			exit;
		}
        $product = Product::findBySql('select * from product where user_id = '.$id.' and status != 1')->one();
        if(empty($userinfo['tmoney'])){
        	echo (0);
        }elseif(!empty($product)){
            echo (2);
        }else{
        	echo (1);
        }
    }
	
	public function actionPdmoney()
	{	
                $money = $_POST['money'];  //输入的目标金额
                $session = Yii::$app->session;
                $phone = $session->get('live');
                $info = Member::find()->where(['phone'=>$phone])->one();
                if(!empty($money) && preg_match("/^[0-9]+(.[0-9]{2})?$/",$money)){
                    if($info->tmoney>=1 && $money>=1 && $info->tmoney>=$money) 
                    echo 2;
                    elseif($info->tmoney>=1000 && $money>=1000 && $info->tmoney>=$money)
                    echo 3;
                    elseif($info->tmoney>=10000 && $money>=10000 && $info->tmoney>=$money)
                    echo 4;	
                    elseif($info->tmoney>=100000 && $money>=100000 && $info->tmoney>=$money)
                    echo 5;
                    elseif($info->tmoney>=500000 && $money>=500000 && $info->tmoney>=$money)
                    echo 6;				
                    else
                    echo "6";
                }else{
                    echo "";
                } 
	}
	
	public function actionWanttolaunch()
	{
                $session = Yii::$app->session;
                $phone = $session->get('live');
                $uid = $session->get('id');
                if(!$phone){
                return $this->redirect('/register/register/?link='.$_SERVER["REQUEST_URI"]);
                }

                $model = new Product();
                $userinfo = Member::find()->where(['phone'=>$phone])->one();
				 if($userinfo['tmoney'] <100){
                    echo "<script>alert('您还未达到发起项目的权限，请先为他人筹款提升权限吧！');history.go(-1);</script>";
                }

                $islau = Product::findBySql('select * from product where user_id = '.$uid.' and status != 1')->one();
                if(!empty($islau)){
                    echo "<script>alert('您还有项目未完成');history.go(-1);</script>";
                }
                if (Yii::$app->request->isPost) { 
                    $islau = Product::findBySql('select * from product where user_id = '.$uid.' and status != 1')->one();
                    if(!empty($islau)){
                        echo "<script>alert('您还有项目未完成');history.go(-1);</script>";
                    }


                    if($model->validate()){
                        if(!empty(Yii::$app->request->post()['chouzmd'])){
                            $model->content = Yii::$app->request->post()['chouzmd'];
                        }else{
                            $model->content='';
						}
                        $model->user_id = $userinfo->id;
                        $model->name = Yii::$app->request->post()['projectname'];
                        $model->target_money = Yii::$app->request->post()['chouzje'];
						
						$profenlei = Yii::$app->params['profenlei'];
						foreach ($profenlei as $key => $tj) {
							if (Yii::$app->request->post()['chouzje'] >= $tj) {
								$term_id = $key;
								break;
							}
						}
						
                        $model->term_id = $term_id;
					    $model->pro_href = Yii::$app->request->post()['pro_href'];
                        $model->top_ok = 0;
                        $model->total_money = 0;
                        $model->save();
                        $pid = $model->attributes['id'];
                        $add = Address::find()->where(['id'=>$_GET['id']])->one();
                        $this->ins($pid,$uid,$add['username'],$add['phone'],$add['province'],$add['city'],$add['county'],$add['address']);
                        
						return $this->redirect(['mylaunch']);
                    }
                }else{
					$faqitishi = Article::find()->where(['id' => "6"])->one();
                    if(!empty($_GET['id'])){
                        $address = Address::find()->where(['id'=>$_GET['id']])->one();
                        return $this->render('wanttolaunch',['address'=>$address,'userinfo'=>$userinfo]);
                    }else{
                        return $this->render('wanttolaunch',['noadd'=>"1",'userinfo'=>$userinfo, 'faqitishi' => $faqitishi]);
                    }
                }
	}
	
	public function actionXiugai()
	{
                $session = Yii::$app->session;
                $phone = $session->get('live');
                $uid = $session->get('id');
                if(!$phone){
                return $this->redirect('/register/register/?link='.$_SERVER["REQUEST_URI"]);
                }
				//有提交的修改
				if ( !Yii::$app->request->isPost) { 
					$get = Yii::$app->request->get();
					if (empty($get['pid']) || !is_numeric($get['pid']) || (!empty($get['aid'])) && !is_numeric($get['aid'])){
						return $this->redirect('/site/index');
					}
					$model = new Product();
					$userinfo = Member::find()->where(['phone'=>$phone])->one();
					if (empty($userinfo)){
						echo "<script>alert('检测不到您的身份，状态错误');history.go(-1);</script>";
						exit;
					}
					 if($userinfo['tmoney'] <100){
						echo "<script>alert('您还未达到发起项目的权限，请先为他人筹款提升权限吧！');history.go(-1);</script>";
					}
					//查找 对应的用户和产品
					$proinfo = Product::find()->where('id=:id and user_id=:uid',
					[':id' =>$get['pid'], ':uid'=>$userinfo['id'] ])->one();
					//找不到产品的话报错
					if(empty($proinfo) || $proinfo['shenhe']==1){
						return $this->redirect('/site/index');
					}
					$address = Address::find()->where('id='.$get['aid'])->one();
					if (empty($address)) {
						echo "<script>alert('地址状态错误，请重新选择');history.go(-1);</script>";
					}
					$faqitishi = Article::find()->where(['id' => "6"])->one();
					//var_dump($faqitishi);exit;
					//未审核是可以修改或者删除
					 return $this->render('xiugai',
					 ['proinfo'=>$proinfo, 'userinfo'=>$userinfo, 'address'=>$address, 'faqitishi'=> $faqitishi]);
				
					
				}else{ 
					
					$post = Yii::$app->request->post();
					$jiancha = Product::updateAll(
							[
							'name'=>$post['projectname'],
							'target_money'=> $post['chouzje'],
							'pro_href'=> $post['pro_href'],
							'content' => $post['chouzmd'],
							'shenhe' => 0,
							'term_id'=>$post['term_id'],
							'updated_at'=>time(),
							],
							'user_id=:uid and id=:id and shenhe<>1',
							[':uid'=>$uid, 'id'=>$post['pid']]
						);
					if ($post['aid'] !=0){
						$address = Address::find()->where('id='.$post['aid'])->asArray()->one();
						
					
						$jiancha1= Invoice::updateAll(
							[
								'name' => $address['username'],
								'phone'=> $address['phone'],
								'address'=> $address['province'].$address['city'].$address['county'].$address['address'],
							],
							'uid=:uid and pid=:pid',
							[':uid'=>$uid, ':pid'=>$post['pid']]
						);
						if(!$jiancha1){
							$jiancha2 = new Invoice();
							
							$jiancha2->uid=$uid;
							$jiancha2->pid=$post['pid'];
							$jiancha2->name = $address['username'];
							$jiancha2->phone = $address['phone'];
							$jiancha2->address= $address['province'].$address['city'].$address['county'].$address['address'];
							$jiancha2->status='-1';
							$jiancha2->created_at= time();
							$jiancha3 = $jiancha2->insert();
							
						}
					}
					return $this->redirect('/project/mylaunch');
					
				}
	}
	
	//取消发起
	public function actionCancel(){
		$session = Yii::$app->session;
        $phone = $session->get('live');
        $uid = $session->get('id');
        if(!$phone){
            return $this->redirect('/register/register/?link='.$_SERVER["REQUEST_URI"]);
        }
		$get = yii::$app->request->get();
		if (empty($get['pid']) || !is_numeric($get['pid'])) {
			echo "<script>alert('URL地址不合法');history.go(-1);</script>";
			exit;
		}
		
		$delpro = Product::deleteAll('id=:id and user_id=:uid and shenhe<>1', 
				[':id' =>$get['pid'], ':uid' => $uid]);
		if ($delpro) {
			
			$delinv = Invoice::deleteAll('pid=:id and uid=:uid', 
				[':id' =>$get['pid'], ':uid' => $uid]);
		}
		return $this->redirect('/project/mylaunch');
	}
    public function ins($a,$b,$c,$d,$e,$f,$g,$h)
    {
        $model = new Invoice();
        $model->pid = $a;
        $model->uid = $b;
        $model->name = $c;
        $model->phone = $d;
        $model->address = $e.$f.$g.$h;
        $model->status = '-1';
        $model->created_at = time();
        $model->insert();
    }
    public function actionCollect()
    {
		
		$session = Yii::$app->session;
        $openid = $session->get('openid');
        $id = $_POST['id'];
		$product = Product::find()->where('id=:id', [':id'=> $id])->asArray()->one();
		if (empty($product)) {
			echo json_encode(0);exit;
		}
        $who = $_POST['who'];
        $model = new Collect();
        $model->goods_id = $id;
        $model->user_id = $who;
        $model->created_at = time();
        $pd = $model->insert();
        if(!empty($pd)){
			$data['touser'] = $openid;
			$data['content'] = '你收藏了商品['.(empty($product['name']) ? "" : $product['name']).']';
            echo json_encode(1);
			
			$this->kefumes($data);
        }else{
            echo json_encode(0);
        }
    }
    public function actionDelcollect()
    {
		$session = Yii::$app->session;
        $openid = $session->get('openid');
        $id = $_POST['id'];
		$product = Product::find()->where('id=:id', [':id'=> $id])->asArray()->one();
		
        $who = $_POST['who'];
        $pd = Collect::deleteAll('goods_id = :goods_id AND user_id = :user_id', [':goods_id' => $id, ':user_id' => $who]);
        if(!empty($pd)){
			$data['touser'] = $openid;
			$data['content'] = '你删除了收藏夹中的商品['. (empty($product['name']) ? "" : $product['name']) .']';
			
            echo json_encode(1);
			$this->kefumes($data);
        }else{
            echo json_encode(0);
        }
    }
    public function actionProjectdetails()
    {
        $session = Yii::$app->session;
        $phone = $session->get('live');
		$member_id = $session->get('id');
        if(!empty($_GET['id'])){
            $id = $_GET['id'];
            $userinfo = Member::find()->where(['phone' => $phone])->one();
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
			
			//用户发起的项目周期
			$termzq1 = Yii::$app->params['termzq1'];
            $proinfo = Product::find()->where(['id'=>$id])->asArray()->one();
			
			//var_dump($proinfo);exit;
            $puinfo = Member::find()->where(['id'=>$proinfo['user_id']])->one();
            if($session['id']==$proinfo['user_id']){
                $isme=1;
            }else{
                $isme=0;
            }
            if(empty($proinfo)){
                echo"<script>alert('项目不存在');history.go(-1);</script>";
				exit;
            }elseif ($proinfo['shenhe'] == 1) {
				
				if ($proinfo['sorted_at'] != 0) {
					$proinfo['paixu'] = Product::find()->where(
						'term_id=:term_id and status=0 and shenhe=1 and (sorted_at<:sorted_at and sorted_at>0
						or ( sorted_at=:sorted_at and sort <=:sort))',
					[':term_id' => $proinfo['term_id'] ,
						':sorted_at' => $proinfo['sorted_at'] ,
						':sort' => $proinfo['sort'],
					])
					->count();
				} else {
					$proinfo['paixu'] = Product::find()->where(
						'term_id=:term_id and status=0 and shenhe=1 and sorted_at<:sorted_at and sorted_at>0',
					[':term_id' => $proinfo['term_id'] ,
						':sorted_at' => $proinfo['sorted_at'] ,
					])
					->count() +1;
				}
				if (in_array($proinfo['term_id'], [2,3,4,5,6])){
					$proinfo['waittime'] = $proinfo['paixu'] * $termzq1[$proinfo['term_id']];
				}
                $proinfo['img'] = explode(',',$proinfo['img']);
				
                $proinfo['c_img'] = explode(',',$proinfo['c_img']);
                //var_dump(Yii::$app->request->hostInfo . Yii::$app->request->getUrl());exit;


                //分享的数据
                $this->setting[0]['value'] = $proinfo['name'];    //标题
                $this->setting[1]['value'] = $proinfo['content'];    //描述
                $this->setting[3]['value'] = Yii::$app->request->hostInfo . Yii::$app->request->getUrl();    //link
                $this->setting[2]['value'] = Yii::$app->params['fenxiangimg'].$proinfo['img'][0];  
				if ($proinfo['term_id']==7 && !empty($proinfo['img'][0])) {
					unset($proinfo['img'][0]);
				}
				//var_dump($proinfo['img']);exit;				//imgurl 
				$jilu = Money::find()->where('cid=:cid and status=1', [':cid' => $proinfo['id']])
					->OrderBy(['updated_at'=>'desc'])->asArray()->limit(5)->all();
				if(!empty($jilu)) {
					foreach ($jilu as $key =>$value) {
						$user = Member::find()->where('id=:uid',[':uid'=>$value['uid']])->OrderBy('updated_at desc')->asArray()->one();
						$jilu[$key]['u'] = $user;
					}
				}
				$check = Friends::find()->where(['user_id' => $member_id,'friends_id'=>$proinfo['user_id']])->one();
				
				
				//var_dump($check);echo "<br><br>";exit;
				$tiaoshu = Money::find()->where('cid=:cid and status=1', [':cid' => $proinfo['id']])->count();
				$yeshu = floor($tiaoshu/5);
                return $this->render('projectdetails',
					['proinfo'=>$proinfo,'userinfo'=>$userinfo,'puinfo'=>$puinfo,
					'isme'=>$isme, 'jilu'=>$jilu, 'yeshu'=>$yeshu, 'check'=>$check]);
            } elseif ($proinfo['shenhe'] == 0 && $isme ==1) {
				$address = Invoice::find()->where('pid=:pid', [':pid'=>$proinfo['id']])->one();
				$faqitishi = Article::find()->where(['id' => "6"])->one();
				//var_dump($address);exit;
				//未审核是可以修改或者删除
				 return $this->render('xiugai',
				 ['proinfo'=>$proinfo, 'userinfo'=>$userinfo, 'puinfo'=>$puinfo,
				 'isme'=>$isme, 'address'=>$address, 'faqitishi'=>$faqitishi]);
				
				
			} elseif ($proinfo['shenhe'] == 2 && $isme ==1) {
				
				//拒绝后可以修改后重新提交, 可以删除
				$address = Invoice::find()->where('pid=:pid', [':pid'=>$proinfo['id']])->one();
				$faqitishi = Article::find()->where(['id' => "6"])->one();
				//var_dump($address);exit;
				//未审核是可以修改或者删除
				 return $this->render('xiugai',
				 ['proinfo'=>$proinfo, 'userinfo'=>$userinfo, 'puinfo'=>$puinfo,
				 'isme'=>$isme, 'address'=>$address, 'faqitishi'=> $faqitishi]);
				
				
			} else {
				 echo "<script>history.go(-1);</script>";
                exit;
			}
            if(!in_array($proinfo['term_id'], array(2,3,4,5,6,7))){
                echo "<script>history.go(-1);</script>";
                exit;
            }
        }else{
            echo"<script>history.go(-1);</script>";
        }
    }
	
	//购买声望值模块
	 public function actionBuyshengwang()
    {
        $session = Yii::$app->session;
        $phone = $session->get('live');
		$member_id = $session->get('id');
        // if(!empty($_GET['id'])){
            // $id = $_GET['id'];
            $userinfo = Member::find()->where(['phone' => $phone])->one();
            $seen = $userinfo['seen'];
            
			
			//用户发起的项目周期
		
            $proinfo = Product::find()->where(['term_id' => 7])->orderBy('created_at desc')->asArray()->one();
			
			
			
            if(empty($proinfo)){
                echo"<script>alert('项目不存在');history.go(-1);</script>";
				exit;
            }else{
				$id = $proinfo['id'];
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
				
				$puinfo = Member::find()->where(['id'=>$proinfo['user_id']])->one();
				
                $proinfo['img'] = explode(',',$proinfo['img']);
				
                $proinfo['c_img'] = explode(',',$proinfo['c_img']);
			
                //分享的数据
                $this->setting[0]['value'] = $proinfo['name'];    //标题
                $this->setting[1]['value'] = $proinfo['content'];    //描述
                $this->setting[3]['value'] = Yii::$app->request->hostInfo . Yii::$app->request->getUrl();    //link
                $this->setting[2]['value'] = Yii::$app->params['fenxiangimg'].$proinfo['img'][0]; 
				
				//$jilu = Money::find()->where('cid=:cid and status=1', [':cid' => $proinfo['id']])
					//->OrderBy(['updated_at'=>'desc'])->asArray()->limit(5)->all();
				if(!empty($jilu)) {
					foreach ($jilu as $key =>$value) {
						$user = Member::find()->where('id=:uid',[':uid'=>$value['uid']])->OrderBy('updated_at desc')->asArray()->one();
						$jilu[$key]['u'] = $user;
					}
				}
				
				//$tiaoshu = Money::find()->where('cid=:cid and status=1', [':cid' => $proinfo['id']])->count();
				//$yeshu = floor($tiaoshu/5);
                return $this->render('buyshengwang',
					['proinfo'=>$proinfo,'userinfo'=>$userinfo,'puinfo'=>$puinfo,
					//'isme'=>$isme, 'jilu'=>$jilu, 'yeshu'=>$yeshu, 'check'=>$check
					]); 
            }
			
        // }else{
            // echo"<script>history.go(-1);</script>";
        // }
    }
	
	
	
	
	//记录ajax 加载
	 public function actionJilujson()
    {
       $get= yii::$app->request->get();//limit '. (20*$get['page']-1) .',10
		if(!empty($get['page']) && !empty($get['id']) && is_numeric($get['id']) && is_numeric($get['page'])){
				$jilujson = Money::findBySql('SELECT * FROM money where cid=:cid and status=1 order by updated_at DESC limit :qishi ,5 ',
				[':cid'=>$get['id'], ':qishi'=>5*$get['page']])->asArray()->all();
				if(!empty($jilujson)) {
					foreach ($jilujson as $key =>$value) {
						$user = Member::find()->where('id=:uid',[':uid'=>$value['uid']])->OrderBy('updated_at desc')->asArray()->one();
						$jilujson[$key]['u'] = $user;
						//var_dump($jilu);echo "<br><br>";
					}
				}
			echo json_encode($jilujson);
		}else{
			$jilujson['status'] = 0;
			echo json_encode($jilujson);
		}
    }
	//添加好友
	public function actionAdd()
    {
		$session = Yii::$app->session;
        $member_id = $session->get('id');
        $openid = $session->get('openid');
		//返回值2 ，用户未登录
		if (empty($member_id)){
			echo json_encode(2);
		}
        $model = new Friends();
        $ta = $_POST['other'];
        $check = Friends::find()->where(['user_id' => $member_id,'friends_id'=>$ta])->one();
		$member = Member::find()->where('id=:id', [':id'=> $ta])->asArray()->one();;
        if(empty($check)){
            $model->user_id = $member_id;
            $model->friends_id = $ta;
            $model->time = time();
            $yes = $model->insert();
			
			echo json_encode($yes);
			if ($yes) {
				//发送消息
			$data['touser'] = $openid;
			$data['content'] = "你添加了新好友【" . (empty($member['name']) ? (empty($member['phone']) ? '未命名用户' :$member['phone']) :$member['name'] ) . "】";
			$this->kefumes($data);
			}
        }else {
			
			//已关注
			echo json_encode(3);
		}
       
    }
	
}

