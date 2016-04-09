<?php

namespace backend\controllers;

use Yii;
use backend\models\Product;
use backend\models\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Term;
use yii\web\UploadedFile;
use yii\helpers\Url;
use frontend\controllers\SortController;
use xj\ueditor\Ueditor;
use backend\controllers\BackendController;
use backend\models\Member;
use backend\models\Mubannews;


/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends BackendController
{
    public function actions() {
return [
    'upload' => [
        'class' => \xj\ueditor\actions\Upload::className(),
        'uploadBasePath' => '@webroot', //file system path
        'uploadBaseUrl' => 'http://0412.jiaoyinet.com/upload', //web path
    'csrf' => true, //csrf校验
        'configPatch' => [
            'imageMaxSize' => 500 * 1024, //图片
            'scrawlMaxSize' => 500 * 1024, //涂鸦
            'catcherMaxSize' => 500 * 1024, //远程
            'videoMaxSize' => 1024 * 1024, //视频
            'fileMaxSize' => 1024 * 1024, //文件
            'imageManagerListPath' => '/', //图片列表
            'fileManagerListPath' => '/', //文件列表
        ],
        // OR Closure
        'pathFormat' => [
            'imagePathFormat' => 'image/{yyyy}{mm}{dd}/{time}{rand:6}',
            'scrawlPathFormat' => 'image/{yyyy}{mm}{dd}/{time}{rand:6}',
            'snapscreenPathFormat' => 'image/{yyyy}{mm}{dd}/{time}{rand:6}',
            'snapscreenPathFormat' => 'image/{yyyy}{mm}{dd}/{time}{rand:6}',
            'catcherPathFormat' => 'image/{yyyy}{mm}{dd}/{time}{rand:6}',
            'videoPathFormat' => 'video/{yyyy}{mm}{dd}/{time}{rand:6}',
            'filePathFormat' => 'file/{yyyy}{mm}{dd}/{time}{rand:6}',
        ],

        // For Closure
        'pathFormat' => [
            'imagePathFormat' => [$this, 'format'],
            'scrawlPathFormat' => [$this, 'format'],
            'snapscreenPathFormat' => [$this, 'format'],
            'snapscreenPathFormat' => [$this, 'format'],
            'catcherPathFormat' => [$this, 'format'],
            'videoPathFormat' => [$this, 'format'],
            'filePathFormat' => [$this, 'format'],
        ],

        'beforeUpload' => function($action) {
//          throw new \yii\base\Exception('error message'); //break
        },
        'afterUpload' => function($action) {
            /*@var $action \xj\ueditor\actions\Upload */

            //var_dump($action->result);
            //  'state' => string 'SUCCESS' (length=7)
            //  'url' => string '/attachment/201109/1425310269294251.jpg' (length=61)
            //  'relativePath' => string '201109/1425310269294251.jpg' ()
            //  'title' => string '1425310269294251.jpg' (length=20)
            //  'original' => string 'Chrysanthemum.jpg' (length=17)
            //  'type' => string '.jpg' (length=4)
            //  'size' => int 879394

            //throw new \yii\base\Exception('error message'); //break
        },
    ],
];
}

// for Closure Format
public function format(\xj\ueditor\actions\Uploader $action) {
    $fileext = $action->fileType;
    $filehash = sha1(uniqid() . time());
    $p1 = substr($filehash, 0, 2);
    $p2 = substr($filehash, 2, 2);
    return "{$p1}/{$p2}/{$filehash}.{$fileext}";
}
	// public function actions() {
 //        return [
 //            'upload' => [
 //                'class' => \xj\ueditor\actions\Upload::className(),
 //                'uploadBasePath' => '@webroot/upload', //file system path
 //                'uploadBaseUrl' => 'http://0412.jiaoyinet.com/upload', //web path
 //                'csrf' => true, //csrf校验
 //                'configPatch' => [
 //                    'imageMaxSize' => 500 * 1024, //图片
 //                    'scrawlMaxSize' => 500 * 1024, //涂鸦
 //                    'catcherMaxSize' => 500 * 1024, //远程
 //                    'videoMaxSize' => 1024 * 1024, //视频
 //                    'fileMaxSize' => 1024 * 1024, //文件
 //                    'imageManagerListPath' => '/', //图片列表
 //                    'fileManagerListPath' => '/', //文件列表
 //                ],
 //                // OR Closure
 //                'pathFormat' => [
 //                    'imagePathFormat' => 'image/{yyyy}{mm}{dd}/{time}{rand:6}',
 //                    'scrawlPathFormat' => 'image/{yyyy}{mm}{dd}/{time}{rand:6}',
 //                    'snapscreenPathFormat' => 'image/{yyyy}{mm}{dd}/{time}{rand:6}',
 //                    'snapscreenPathFormat' => 'image/{yyyy}{mm}{dd}/{time}{rand:6}',
 //                    'catcherPathFormat' => 'image/{yyyy}{mm}{dd}/{time}{rand:6}',
 //                    'videoPathFormat' => 'video/{yyyy}{mm}{dd}/{time}{rand:6}',
 //                    'filePathFormat' => 'file/{yyyy}{mm}{dd}/{time}{rand:6}',
 //                ],
 //                // For Closure
 //                'pathFormat' => [
 //                    'imagePathFormat' => [$this, 'format'],
 //                    'scrawlPathFormat' => [$this, 'format'],
 //                    'snapscreenPathFormat' => [$this, 'format'],
 //                    'snapscreenPathFormat' => [$this, 'format'],
 //                    'catcherPathFormat' => [$this, 'format'],
 //                    'videoPathFormat' => [$this, 'format'],
 //                    'filePathFormat' => [$this, 'format'],
 //                ],
 //                'beforeUpload' => function($action) {
 //                },
 //                'afterUpload' => function($action) {

 //                },
 //            ],
 //        ];
 //    }

	
	//  // for Closure Format
 //    public function format(\xj\ueditor\actions\Uploader $action) {
 //        $fileext = $action->fileType;
 //        $filehash = sha1(uniqid() . time());
 //        $p1 = substr($filehash, 0, 2);
 //        $p2 = substr($filehash, 2, 2);
 //        return "{$p1}/{$p2}/{$filehash}.{$fileext}";
 //    }  
	
    // public function behaviors()
    // {
    //     return [
    //         'verbs' => [
    //             'class' => VerbFilter::className(),
    //             'actions' => [
    //                 'delete' => ['post'],
    //             ],
    //         ],
    //     ];
    // }

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$model = new Product();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'model' => $model,
        ]);
    }
	
	/*
	测试模块
	*/
	public function actionCeshi()
    {
		//发送客服消息--模板消息
		$data['touser'] = $userinfo['openid'];
		$data['first'] = "您成功支付众筹项目【".$product['name']."】";
		$data['orderMoneySum'] = $userinfo['openid'];
		$data['orderProductName'] = $userinfo['openid'];
		$data['Remark'] = $userinfo['openid'];
       // $this->
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
		//var_dump($this->findModel($id)->img);exit;
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		$fmt="";
		$nry="";
        $model = new Product();

        if ($model->load(Yii::$app->request->post())) {
			
			$file = UploadedFile::getInstances($model, 'img');  
			$c_file = UploadedFile::getInstances($model, 'c_img'); 
			
			if(count($file)>4){
				$file = array_slice($file,0,4);
			}
			
			if($file){
				
				foreach ($file as $fl) {
				$siteRoot = str_replace('\\', '/', realpath(dirname(dirname(dirname(__FILE__))) . '/')) . "/frontend/web/upload/";
				$contractName = mt_rand(1100,9900) .time() .'.'. $fl->extension;
                $fl->saveAs($siteRoot.$contractName); 
				$fmt .= $contractName.",";
                } 
				$model->img = substr($fmt, 0, -1); //去掉逗号
			}else{
				
				$model->img="";
			}
			
			if($c_file){
				
				foreach ($c_file as $f2) {
					
					$siteRoot = str_replace('\\', '/', realpath(dirname(dirname(dirname(__FILE__))) . '/')) . "/frontend/web/upload/";
					
					$contractName = mt_rand(1100,9900) .time() .'.'. $f2->extension;
					
                    $f2->saveAs($siteRoot.$contractName); 

					$nry .= $contractName.",";
                } 
				$model->c_img = substr($nry, 0, -1);
			}else{
				$model->c_img = '';
			}

			if($model->validate()){
				/*$model->status = 2;
				$model->shenhe = 1;*/
				$model->setAttributes(Yii::$app->request->post());
				$model->save();
				return $this->redirect(['index']);
			}
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {	
        $model = $this->findModel($id);

		$fmt="";
		$nry="";

        if ($model->load(Yii::$app->request->post())) {
			$file = UploadedFile::getInstances($model, 'img');  
			$c_file = UploadedFile::getInstances($model, 'c_img'); 
			if(count($file)>4){
				$file = array_slice($file,0,4);
			}

			if($file){
				
				foreach ($file as $fl) {
					
				$siteRoot = str_replace('\\', '/', realpath(dirname(dirname(dirname(__FILE__))) . '/')) . "/frontend/web/upload/";
				
				$contractName = mt_rand(1100,9900) .time() .'.'. $fl->extension;
				
                $fl->saveAs($siteRoot.$contractName); 
				
				$fmt .= $contractName.",";
				
                }
				
				$model->img = substr($fmt, 0, -1); //去掉逗号				
			}else{
                $new = $this->findModel($id);
                $model->img = $new->img;
			}
			
			if($c_file){
				
				foreach ($c_file as $f2) {
					
					$siteRoot = str_replace('\\', '/', realpath(dirname(dirname(dirname(__FILE__))) . '/')) . "/frontend/web/upload/";
					
					$contractName = mt_rand(1100,9900) .time() .'.'. $f2->extension;
					
                    $f2->saveAs($siteRoot.$contractName); 

					$nry .= $contractName.",";
                } 
				
				$model->c_img = substr($nry, 0, -1);
			}else{
				$new = $this->findModel($id);
                $model->c_img = $new->c_img;
			}

			if($model->validate()){
					
				$model->setAttributes(Yii::$app->request->post());
				$model->xiugaitime = time();
				$model->save();
				return $this->redirect(['index']);
			}		
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        //$this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionShenhe($id){

        //天数为进一取整，当前周期为向下取整

        //栏目对应的周期天数
        $terms = [
           '2'=>1,
           '3'=>3,
           '4'=>5,
           '5'=>7,
           '6'=>9,
        ];
        $model = Product::findOne($id);
        $term_id =$model->term_id;
        $model1 = Product::find()->where(['term_id'=>$term_id,'shenhe'=>1,'status'=>2])->one();
        $now_zhouqi = floor(ceil(time()/86400)/$terms[$model->term_id]);
        if(empty($model1)){
            Product::updateAll(['shenhe' => Product::SHENHE_ACTIVE,'status'=>2,'sorted_at'=>$now_zhouqi,'shenhe_at'=>time(),'updated_at'=>$now_zhouqi], ['id' => $id]);
        }else{
            Product::updateAll(['shenhe' => Product::SHENHE_ACTIVE,'status'=>0,'shenhe_at'=>time(),'updated_at'=>$now_zhouqi], ['id' => $id]);

        }
			echo "<script>window.history.go(-1);</script>";
			
			$mubannews = Mubannews::find()->where('name=:name', [':name'=> "审核通过"])->asArray()->one();
			if (!empty($mubannews)) {
				$member = Member::find()->where('id=:id', [':id'=>$model->user_id ])->asArray()->one();//$model->user_id
				//var_dump($mubannews);exit;
				//发送客服消息--模板消息
				$data['template_id'] = $mubannews['template_id'];
				$data['touser'] = $member['openid'];
				$data['url'] = "http://bingbingzm.com/project/mylaunch";
				if (empty($mubannews['first'])) {
					$data['first']['value'] = "您的众筹项目【".$model['name']."】已审核通过";
				} else {
					$data['first']['value'] = sprintf($mubannews['first'], $model['name']);
				}
				$data[1]['key'] = 'keyword1';
				$data[2]['key'] = 'keyword2';
				$data[1]['value'] = '审核通过';
				$data[2]['value'] = date('Y-m-d H:i:s', time());
				$data['Remark']['value'] = "审核通过";
				
				$this->sendMobanmes($data);
				
			}
			exit;
       // return $this->redirect(Url::to(['index']));
    }
	
    public function actionUnshenhe($id){


        //栏目对应的周期天数
        $terms = [
           '2'=>1,
           '3'=>3,
           '4'=>5,
           '5'=>7,
           '6'=>9,
        ];
        $product = Product::findOne($id);
        $term_id = $product->term_id;
        if($product->status==2){
            Product::updateAll(['shenhe' => Product::SHENHE_INACTIVE,'status'=>0], ['id' => $id]);

            $connection = \Yii::$app->db;

        //天数为进一取整，当前周期为向下取整
        $now_zhouqi = floor(ceil(time()/86400)/$terms[$term_id]);
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
                    $command = $connection->createCommand(sprintf('SELECT `product`.* FROM `product` LEFT JOIN `member` ON `product`.`user_id`=`member`.`id`  WHERE `product`.`term_id`=%u AND `product`.`shenhe`=1 AND `product`.`sorted_at`=0 AND `product`.`status`=0 AND `product`.`updated_at`<%u ORDER BY `product`.`updated_at` ASC,`member`.`prestige` DESC',$term_id,$now_zhouqi));
                    $res2 = $command->queryAll();
                    if($res2){
                        foreach ($res2 as $key => $pro) {
                            $command = $connection->createCommand(sprintf('UPDATE `product` SET `sorted_at`=`updated_at`+1,`updated_at`=%u,`sort`=%u WHERE `id`=%u  AND `shenhe`=1 AND `status`=0' ,$now_zhouqi,$key+1,$pro['id']));
                            $command->execute();
                        }
                    }

                }
            return $this->redirect(Url::to(['index']));
        }else{
            Product::updateAll(['shenhe' => Product::SHENHE_INACTIVE], ['id' => $id]);
			echo "<script>window.history.go(-1);</script>";exit;
            //return $this->redirect(Url::to(['index']));
        }
    }
	
	public function actionJujue($id){
		$model = $model = Product::findOne($id);
        Product::updateAll(['shenhe' => Product::SHENHE_JUJUE], ['id' => $id]);
		$mubannews = Mubannews::find()->where('name=:name', [':name'=> "审核失败"])->asArray()->one();
			if (!empty($mubannews)) {
				$member = Member::find()->where('id=:id', [':id'=>$model->user_id ])->asArray()->one();//$model->user_id
				//var_dump($mubannews);exit;
				//发送客服消息--模板消息
				$data['template_id'] = $mubannews['template_id'];
				$data['touser'] = $member['openid'];
				$data['url'] = "http://bingbingzm.com/project/mylaunch";
				if (empty($mubannews['first'])) {
					$data['first']['value'] = "您的众筹项目【".$model['name']."】审核失败";
				} else {
					$data['first']['value'] = sprintf($mubannews['first'], $model['name']);
				}
				$data[1]['key'] = 'keyword1';
				$data[2]['key'] = 'keyword2';
				$data[1]['value'] = '审核失败';
				$data[2]['value'] = date('Y-m-d H:i:s', time());
				$data['Remark']['value'] = empty($mubannews['remark']) ? "审核失败" :$mubannews['remark'];
				
				$this->sendMobanmes($data);
				
			}
		return $this->redirect(Url::to(['/product/update', 'id'=> $id, 'type'=>'jujue']));
			echo "<script>window.history.go(-1);</script>";
			
			exit;
        //return $this->redirect(Url::to(['index']));
    }
	
	public function actionUnjujue($id){
        Product::updateAll(['shenhe' => Product::SHENHE_INACTIVE], ['id' => $id]);
			echo "<script>window.history.go(-1);</script>";exit;
       // return $this->redirect(Url::to(['index']));
    }

}
