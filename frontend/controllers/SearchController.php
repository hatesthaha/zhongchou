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
use frontend\models\Product;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\db\Query ;
use frontend\controllers\IsonloadController;

/**
 * Site controller
 */
class SearchController extends IsonloadController
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
    public function actionDelrecord(){
        $content = \yii::$app->request->get('key');
        $connection = \yii::$app->db;
        $member_id = 5;
        $cunzai=0;
        $sql_chaxun = "SELECT `search_record` FROM `member` where `id` = ".$member_id;
        $command = $connection->createCommand($sql_chaxun);
        $record = $command->queryColumn('search_record');
        if(isset($record[0])){
            $record1 = json_decode($record[0]);
            foreach ($record1 as $key => $value) {
                if($key == $content){
                    //发现记录
                    $cunzai = 1;
                }
                if($cunzai==1){
                    $value = isset($record1[$key+1])?$record1[$key+1]:null;
                    $record_a[$key]['time'] = isset($value->time)?$value->time:null;
                    $record_a[$key]['word'] = isset($value->word)?$value->word:null;
                }else{
                    $record_a[$key]['time'] = isset($value->time)?$value->time:null;
                    $record_a[$key]['word'] = isset($value->word)?$value->word:null;
                }
            }
            if($cunzai==1){
                unset($record_a[$key]);
                $connection->createCommand()->update('member', ['search_record' => json_encode($record_a)], 'id='.$member_id)->execute();
                echo 1;
            }else{
                echo 0;
            }
        }else{
            echo 0;
        }

    }
    public function actionSearch(){
        $content = \yii::$app->request->get('content');
        $connection = \yii::$app->db;
        $member_id = 5;
        $sql_chaxun = "SELECT `search_record` FROM `member` where `id` = ".$member_id;
        $command = $connection->createCommand($sql_chaxun);
        $record = $command->queryColumn('search_record');
		
		$termzq1 = Yii::$app->params['termzq1'];
          //有输入内容，进入搜索结果页
        if(isset($content ) && $content!=""){
            //保存用户搜索记录
            if(isset($member_id)&&is_numeric($member_id)&&$member_id!=0){

                //默认记录不存在
                $cunzai = 0;


                
                if(!empty($record[0])){
                    $record1 = json_decode($record[0]);
                        foreach ($record1 as $key => $value) {
                            if($value->word == $content){
                                //记录存在
                                $cunzai = 1;
                            }
                            if($cunzai==1){
                                $value = isset($record1[$key+1])?$record1[$key+1]:null;
                                $record_a[$key]['time'] = isset($value->time)?$value->time:null;
                                $record_a[$key]['word'] = isset($value->word)?$value->word:null;
                            }else{
                                $record_a[$key]['time'] = isset($value->time)?$value->time:null;
                                $record_a[$key]['word'] = isset($value->word)?$value->word:null;
                            }
                        }
                        //记录中不存在
                        if($cunzai == 0){

                            if(count($record1)<10){
                                $record_a[count($record1)]['time'] = time();
                                $record_a[count($record1)]['word'] = $content;
                            }else{
                                $record_a[0] = null;
                                foreach ($record_a as $key1 => $value1) {
                                    $record_a[$key1] = isset($record_a[$key1+1])?$record_a[$key1+1]:null;
                                }
                                $record_a[9]['time'] = time();
                                $record_a[9]['word'] = $content;

                            }
                        }else{
                            $record_a[$key]['time'] = time();
                            $record_a[$key]['word'] = $content;
                        }
                        // else{
                        //     $a = [['time'=>1,'name'=>'name1'],['time'=>2,'name'=>'name2'],['time'=>3,'name'=>'name3']];


                        //     function asc_sort($x,$y){
                        //         //echo 1;exit;
                        //         if($x['time']>$y['time']){
                        //             return 1;
                        //         }else{
                        //             return 0;
                        //         }
                        //     }
                        //     //asc_sort(1,2);
                        //     uasort($a, 'asc_sort');
                        //     var_dump($a);exit;
                        // }
                }else{
                     $record_a[0]['time'] = time();
                     $record_a[0]['word'] = $content;
                }
                $connection->createCommand()->update('member', ['search_record' => json_encode($record_a)], 'id='.$member_id)->execute();
            }

            // query builder
            $product = (new Query())
                ->select("*")
                ->from('product')
                ->where('shenhe=1 AND `term_id`<>7')
                ->andWhere('name LIKE :name', [':name' => "%".$content."%"])
                ->orderBy('`status`=2 DESC,`sorted_at`=0 ASC,`sorted_at` DESC,`sort` ASC')
                ->all();
                if($product!=null){
                    foreach ($product as $key => $value) {
                        $sql = "UPDATE product SET `search_num`=`search_num`+1 where `id` = ".$value['id'];
                        $command = $connection->createCommand($sql);
                        $command->execute();
						if(in_array($product[$key]['term_id'], [2, 3, 4, 5, 6])) {
							if ($product[$key]['sorted_at'] !=0) {
								$product[$key]['paixu'] = Product::find()->where(
									'term_id=:term_id and status=0 and shenhe=1 and (sorted_at<:sorted_at 
									and sorted_at>0 
									or ( sorted_at=:sorted_at and sort <=:sort))',
								[':term_id' => $value['term_id'] ,
									':sorted_at' => $value['sorted_at'] ,
									':sort' => $value['sort'],
								])
								->count();
							} else {
								$product[$key]['paixu'] = Product::find()->where(
									'term_id=:term_id and status=0 and shenhe=1 and sorted_at>0',
								[':term_id' => $value['term_id'] ,
								])
								->count() +1;
							}
							$product[$key]['waittime'] = $product[$key]['paixu'] * $termzq1[$value['term_id']];
						}
                    }

                }
			$session = Yii::$app->session;
            return $this->render('searchitemresult',compact('product', 'session'));
        }else{
            if(!empty($record[0])){
                $record2 = json_decode($record[0]);
                //没有输入内容，进入搜索页
                foreach ($record2 as $key => $value) {
                    $record_a[$key]['time'] = isset($value->time)?$value->time:null;
                    $record_a[$key]['word'] = isset($value->word)?$value->word:null;
                }
            }
            //var_dump($record_a);exit;
            // $session = Yii::$app->session;
            // $phone = $session->get('live');
            $command = $connection->createCommand("SELECT `name` FROM `product` WHERE `shenhe`=1 AND `name` IS NOT NULL ORDER BY `search_num`  DESC LIMIT 0,6");
            $hot = $command->queryAll();
            return $this->render('search',compact('record_a','hot'));
        }

    }
     /**
     * @筛选
     */
    public function actionSearchitem()
    {
        $arr=['1','2','3','4','5','6','7'];
        $arr_t=['2','3','4','5','6','7','8'];
        $connection = \Yii::$app->db;
        //$sql = "SELECT `product`.* FROM `product`LEFT JOIN `member` ON `product`.`user_id`=`member`.`id` WHERE `product`.`term_id` = $tid   ORDER BY `member`.`prestige` DESC";
        $request = yii::$app->request->get();
        if(isset($request['tid']) && is_numeric($request['tid']) && in_array($request['tid'], $arr_t)){
            //存在term_id 
                //1 sort tid 俩条件
                //sort=1:最新上线
                    // 2：目标金额
                    // 3：支持人数
                    // 4：筹款额
                //status=
                    // 1：众筹中
                    // 2：即将开始
                    // 3：已经结束
                    // 4: 暂停中
            $tid = $request['tid'];
            if($tid==8){
                //一元众筹，跳转
                return $this->redirect('/yyzc/itemlist');
            }
            //设置页面显示
            $condition[0] = $tid;
            if(isset($request['status']) && is_numeric($request['status']) && in_array($request['status'], [1,2,3,4])){
                //存在status

                        //三种筛选
                $status = $request['status'];
                //设置显示
                $condition[2] = $status;
                if($status==2){
                    //即将开始
                    if(isset($request['sort']) && is_numeric($request['sort']) && in_array($request['sort'], $arr)){
                        $sort = $request['sort'];
                        switch ($sort) {
                            case '1':
                                 $sql = sprintf('SELECT * FROM `product` WHERE `shenhe`=1 AND `status` =0 AND `term_id`=%u ORDER BY `sorted_at`=0 ASC ,`sort` ASC ,`shenhe_at` DESC',$tid);
                                 $condition[1] = 1;
                                break;
                            case '2':
                                 $sql = sprintf('SELECT * FROM `product` WHERE `shenhe`=1 AND `status` =0 AND `term_id`=%u ORDER BY `sorted_at`=0 ASC ,`sort` ASC ,`target_money` DESC',$tid);
                                $condition[1] = 2;
                                break;
                            case '3':
                                $sql = sprintf('SELECT * FROM `product` WHERE `shenhe`=1 AND `status` =0 AND `term_id`=%u ORDER BY `sorted_at`=0 ASC ,`sort` ASC ,`s_num` DESC',$tid);
                                $condition[1] = 3;
                                break;
                            case '4':
                                $sql = sprintf('SELECT * FROM `product` WHERE `shenhe`=1 AND `status` =0 AND `term_id`=%u ORDER BY `sorted_at`=0 ASC ,`sort` ASC ,`total_money` DESC',$tid);
                                $condition[1] = 4;
                                break;
                            default:
                                $sql = sprintf('SELECT * FROM `product` WHERE `shenhe`=1 AND `status` =0 AND `term_id`=%u ORDER BY `sorted_at`=0 ASC ,`sort` ASC ',$tid);
                                $condition[1] = 0;
                                break;
                        }
                        
                    }else{
                         $sql = sprintf('SELECT * FROM `product` WHERE `shenhe`=1 AND `status` =0 AND `term_id`=%u ORDER BY `sorted_at`=0 ASC ,`sort` ASC ',$tid);
                         $condition[1] = 0;
                    }
                    
                }else{
                    if($status = 1){//众筹中
                        $sta = 2;
                    }elseif($status = 3){
                        $sta = 1;//已完成
                    }
                    // elseif($status = 4){
                    //     $sta = 2;
                    // }
                    if(isset($request['sort']) && is_numeric($request['sort']) && in_array($request['sort'], $arr)){
                        $sort = $request['sort'];
                        switch ($sort) {
                            case '1':
                                 $sql = sprintf('SELECT * FROM `product` WHERE `shenhe`=1 AND `status`=%u AND `term_id`=%u ORDER BY `shenhe_at` DESC',$sta,$tid);
                                 $condition[1] = 1;
                                break;
                            case '2':
                                 $sql = sprintf('SELECT * FROM `product` WHERE `shenhe`=1 AND `status`=%u AND `term_id`=%u ORDER BY `target_money` DESC',$sta,$tid);
                                $condition[1] = 2;
                                break;
                            case '3':
                                $sql = sprintf('SELECT * FROM `product` WHERE `shenhe`=1 AND `status`=%u AND `term_id`=%u ORDER BY `s_num` DESC',$sta,$tid);
                                $condition[1] = 3;
                                break;
                            case '4':
                                $sql = sprintf('SELECT * FROM `product` WHERE `shenhe`=1 AND `status`=%u AND `term_id`=%u ORDER BY `total_money` DESC',$sta,$tid);
                                $condition[1] = 4;
                                break;
                            default:
                                $sql = sprintf('SELECT * FROM `product` WHERE `shenhe`=1 AND `status`=%u AND `term_id`=%u ORDER BY `sorted_at`=0 ASC ,`sort` ASC ',$sta,$tid);
                                $condition[1] = 0;
                                break;
                        }
                        
                    }else{
                         $sql = sprintf('SELECT * FROM `product` WHERE `shenhe`=1 AND `status`=%u AND `term_id`=%u ORDER BY `sorted_at`=0 ASC ,`sort` ASC ',$sta,$tid);
                         $condition[1] = 0;
                    }

                }
            }else{
                //4 不存在status
                //1 sort tid 俩条件
                //sort=1:最新上线
                    // 2：目标金额
                    // 3：支持人数
                    // 4：筹款额
                $condition[2] = 0;
                if(isset($request['sort']) && is_numeric($request['sort']) && in_array($request['sort'], $arr)){
                        $sort = $request['sort'];
                        switch ($sort) {
                            case '1':
                                 $sql = sprintf('SELECT * FROM `product` WHERE `shenhe`=1  AND `term_id`=%u ORDER BY `shenhe_at` DESC, `sorted_at`=0 ASC ,`sort` ASC',$tid);
                                 $condition[1] = 1;
                                break;
                            case '2':
                                 $sql = sprintf('SELECT * FROM `product` WHERE `shenhe`=1 AND `term_id`=%u ORDER BY  `target_money` DESC,`sorted_at`=0 ASC ,`sort` ASC ',$tid);
                                $condition[1] = 2;
                                break;
                            case '3':
                                $sql = sprintf('SELECT * FROM `product` WHERE `shenhe`=1 AND `term_id`=%u ORDER BY `s_num` DESC ,`sorted_at`=0 ASC ,`sort` ASC ',$tid);
                                $condition[1] = 3;
                                break;
                            case '4':
                                $sql = sprintf('SELECT * FROM `product` WHERE `shenhe`=1  AND `term_id`=%u ORDER BY `total_money` DESC, `sorted_at`=0 ASC ,`sort` ASC ',$tid);
                                $condition[1] = 4;
                                break;
                            default:
                                $sql = sprintf('SELECT * FROM `product` WHERE `shenhe`=1 AND `term_id`=%u ORDER BY `status`=2 DESC ,`status` ASC, `sorted_at`=0 ASC ,`sort` ASC ',$tid);
                                $condition[1] = 0;
                                break;
                        }
                        
                    }else{
                         $sql = sprintf('SELECT * FROM `product` WHERE `shenhe`=1 AND `term_id`=%u ORDER BY `status`=2 DESC,`status` ASC,  `sorted_at`=0 ASC ,`sort` ASC ',$tid);
                         $condition[1] = 0;
                    }
            }
        }else{
            //不存在 term_id
            $condition[0] = 0;
            if(isset($request['status']) && is_numeric($request['status']) && in_array($request['status'], [1,2,3,4])){
                //存在status

                 //2种筛选
                $status = $request['status'];
                //设置显示
                $condition[2] = $status;
                if($status==2){
                    //即将开始

                //1 sort tid 俩条件
                //sort=1:最新上线
                    // 2：目标金额
                    // 3：支持人数
                    // 4：筹款额
                    if(isset($request['sort']) && is_numeric($request['sort']) && in_array($request['sort'], $arr)){
                        $sort = $request['sort'];
                        switch ($sort) {
                            case '1':
                                 $sql = sprintf('SELECT * FROM `product` WHERE `shenhe`=1 AND `status`=0 AND `term_id`<>7 ORDER BY `shenhe_at` DESC, `sorted_at`=0 ASC ,`sort` ASC , `term_id` ASC');
                                 $condition[1] = 1;
                                break;
                            case '2':
                                 $sql = sprintf('SELECT * FROM `product` WHERE `shenhe`=1 AND `status`=0 AND `term_id`<>7  ORDER BY `target_money` DESC , `sorted_at`=0 ASC ,`sort` ASC , `term_id` ASC');
                                $condition[1] = 2;
                                break;
                            case '3':
                                $sql = sprintf('SELECT * FROM `product` WHERE `shenhe`=1 AND `status`=0 AND `term_id`<>7 ORDER BY `s_num` DESC , `sorted_at`=0 ASC ,`sort` ASC , `term_id` ASC');
                                $condition[1] = 3;
                                break;
                            case '4':
                                $sql = sprintf('SELECT * FROM `product` WHERE `shenhe`=1 AND `status`=0 AND `term_id`<>7  ORDER BY `total_money` DESC  ,`sorted_at`=0 ASC, `sort` ASC , `term_id` ASC');
                                $condition[1] = 4;
                                break;
                            default:
                                $sql = sprintf('SELECT * FROM `product` WHERE `shenhe`=1 AND `status`=0 AND `term_id`<>7  ORDER BY `sorted_at`=0 ASC , `sort` ASC , `term_id` ASC');
                                $condition[1] = 0;
                                break;
                        }
                        
                    }else{
                         $sql = sprintf('SELECT * FROM `product` WHERE `shenhe`=1 AND `status`=0 AND `term_id`<>7 ORDER BY `sorted_at`=0 ASC ,`sort` ASC ');
                         $condition[1] = 0;
                    }
                    
                }else{
                    if($status == 1){
                        $sta = 2;
                    }elseif($status == 3){
                        $sta = 1;
                    }
                    // elseif($status = 4){
                    //     $sta = 2;
                    // }
                    if(isset($request['sort']) && is_numeric($request['sort']) && in_array($request['sort'], $arr)){
                        $sort = $request['sort'];
                        switch ($sort) {
                            case '1':
                                 $sql = sprintf('SELECT * FROM `product` WHERE `shenhe`=1 AND `status`=%u AND `term_id`<>7 ORDER BY `shenhe_at` DESC ,`sorted_at`=0 ASC, `sort` ASC  , `term_id` ASC',$sta);
                                 $condition[1] = 1;
                                break;
                            case '2':
                                 $sql = sprintf('SELECT * FROM `product` WHERE `shenhe`=1 AND `status`=%u AND `term_id`<>7  ORDER BY `target_money` DESC ,`sorted_at`=0 ASC, `sort` ASC  , `term_id` ASC',$sta);
                                $condition[1] = 2;
                                break;
                            case '3':
                                $sql = sprintf('SELECT * FROM `product` WHERE `shenhe`=1 AND `status`=%u AND `term_id`<>7  ORDER BY `s_num` DESC  ,`sorted_at`=0 ASC , `sort` ASC, `term_id` ASC',$sta);
                                $condition[1] = 3;
                                break;
                            case '4':
                                $sql = sprintf('SELECT * FROM `product` WHERE `shenhe`=1 AND `status`=%u AND `term_id`<>7  ORDER BY `total_money` DESC  ,`sorted_at`=0 ASC , `sort` ASC, `term_id` ASC',$sta);
                                $condition[1] = 4;
                                break;
                            default:
                                $sql = sprintf('SELECT * FROM `product` WHERE `shenhe`=1 AND `term_id`<>7  ORDER BY `sorted_at`=0 ASC , `sort` ASC ,`term_id` ASC ');
                                $condition[1] = 0;
                                break;
                        }
                        
                    }else{
                         $sql = sprintf('SELECT * FROM `product` WHERE `shenhe`=1 AND `status`=%u AND `term_id`<>7 ORDER BY `sorted_at`=0 ASC ,`sort` ASC ',$sta);
                         $condition[1] = 0;
                    }

                }
            }else{
                //4 不存在status
                //1 sort
                //sort=1:最新上线
                    // 2：目标金额
                    // 3：支持人数
                    // 4：筹款额
                $condition[2] = 0;
                if(isset($request['sort']) && is_numeric($request['sort']) && in_array($request['sort'], $arr)){
                        $sort = $request['sort'];
                        switch ($sort) {
                            case '1':
                                 $sql = sprintf('SELECT * FROM `product` WHERE `shenhe`=1 AND `term_id`<>7 ORDER BY `shenhe_at` DESC, `sorted_at`=0 ASC ,`sort` ASC');
                                 $condition[1] = 1;
                                break;
                            case '2':
                                 $sql = sprintf('SELECT * FROM `product` WHERE `shenhe`=1 AND `term_id`<>7 ORDER BY  `target_money` DESC,`sorted_at`=0 ASC ,`sort` ASC ');
                                $condition[1] = 2;
                                break;
                            case '3':
                                $sql = sprintf('SELECT * FROM `product` WHERE `shenhe`=1 AND `term_id`<>7 ORDER BY `s_num` DESC ,`sorted_at`=0 ASC ,`sort` ASC ');
                                $condition[1] = 3;
                                break;
                            case '4':
                                $sql = sprintf('SELECT * FROM `product` WHERE `shenhe`=1 AND `term_id`<>7  ORDER BY `total_money` DESC, `sorted_at`=0 ASC ,`sort` ASC ');
                                $condition[1] = 4;
                                break;
                            default:
                                $sql = sprintf('SELECT * FROM `product` WHERE `shenhe`=1 AND `term_id`<>7 ORDER BY `status`=2 DESC , `status` ASC, `sorted_at`=0 ASC ,`sort` ASC ');
                                $condition[1] = 0;
                                break;
                        }
                        
                }else{
                    $sql = sprintf('SELECT * FROM `product` WHERE `shenhe`=1 AND `term_id`<>7 ORDER BY `status`=2 DESC , `status` ASC,`term_id` ASC, `sorted_at`=0 ASC ,`sort` ASC ');
                    $condition[1] = 0;
                }
            }
        }
        //var_dump($condition);exit;
        $command = $connection->createCommand($sql);
        $product = $command->queryAll();
		//用户发起的项目周期
		$termzq1 = Yii::$app->params['termzq1'];
        foreach ($product as $key => $value) {
            if(@is_numeric($value['total_money']) && @is_numeric($value['target_money'])){
                $product[$key]['wanchengdu'] = ceil($value['total_money']/$value['target_money']*100);
            }
			if(in_array($product[$key]['term_id'], [2, 3, 4, 5, 6])) {
				if ($product[$key]['sorted_at'] !=0) {
					$product[$key]['paixu'] = Product::find()->where(
						'term_id=:term_id and status=0 and shenhe=1 and ( sorted_at<:sorted_at 
									and sorted_at>0 
						or ( sorted_at=:sorted_at and sort <=:sort))',
					[':term_id' => $value['term_id'] ,
						':sorted_at' => $value['sorted_at'] ,
						':sort' => $value['sort'],
					])
					->count();
				} else {
					$product[$key]['paixu'] = Product::find()->where(
						'term_id=:term_id and status=0 and shenhe=1   and sorted_at>0',
					[
					':term_id' => $value['term_id'] ,
					])
					->count() +1;
				}
				$product[$key]['waittime'] = $product[$key]['paixu'] * $termzq1[$value['term_id']];
			}
        }
		$session = Yii::$app->session;
        return $this->render('searchitem',compact('product', 'condition', 'session'));
    }
}
