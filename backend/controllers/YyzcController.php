<?php

namespace backend\controllers;

use Yii;
use backend\models\Yyzc;
use backend\models\YyzcSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Term;
use yii\web\UploadedFile;
use yii\helpers\Url;
use backend\controllers\BackendController;


/**
 * YyzcController implements the CRUD actions for Product model.
 */
class YyzcController extends BackendController
{
   
    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new YyzcSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
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
        $model = new Yyzc();
		
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
				$model->img = substr($fmt, 0, -1); //È¥µô¶ººÅ
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
				$model->status = 2;
				$model->shenhe = 1;
				
				$tid = Yii::$app->request->post()['Yyzc']['term_id'];

				if($tid == 7)
					$model->end_time = strtotime(Yii::$app->request->post()['end_time']);
				else
					$model->end_time = '';
				//$model->setAttributes(Yii::$app->request->post());

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
			// echo date('Y-m-d H:i:s',time());
			// var_dump( date('Y-m-d H:i:s', $model->end_time ) );exit;
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
				
				$model->img = substr($fmt, 0, -1); //È¥µô¶ººÅ				
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
			//var_dump($model->validate());exit;
			if($model->validate()){
				
				$tid = Yii::$app->request->post()['Yyzc']['term_id'];
				if($tid == 7)
					$model->end_time = strtotime(Yii::$app->request->post()['end_time']);
				else
					$model->end_time = '';
				//$model->setAttributes(Yii::$app->request->post());
				$model->save();
				return $this->redirect(['index']);
			}else{
				return $this->render('update', [
                'model' => $model,
				]);
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
		$data = $this->findModel($id);
		if($data->status==Yyzc::STATUS_COMPLETE){
			Yyzc::updateAll(['status'=>Yyzc::STATUS_DELETED],['id' =>$id]);
		}
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
        if (($model = Yyzc::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
