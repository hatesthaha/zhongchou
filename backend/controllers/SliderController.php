<?php

namespace backend\controllers;

use Yii;
use backend\models\Slider;
use backend\models\SliderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;
use backend\controllers\BackendController;

/**
 * SliderController implements the CRUD actions for Slider model.
 */
class SliderController extends BackendController
{
    

    /**
     * Lists all Slider models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SliderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Slider model.
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
     * Creates a new Slider model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Slider();
        if ($model->load(Yii::$app->request->post())) {
            $model->banner = UploadedFile::getInstance($model, 'banner');
            if($model->banner)
            {
            	$siteRoot = str_replace('\\', '/', realpath(dirname(dirname(dirname(__FILE__))) . '/')) . "/frontend/web/upload/";
                $imgName = mt_rand(1100,9900) .time() .'.'. $model->banner->extension;
                $model->banner->saveAs($siteRoot.$imgName);
                $model->banner = $imgName;
            }else{
				
				$model->banner = "";
			}
			
			$model->save();
			
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Slider model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
			
			$model->banner = UploadedFile::getInstance($model, 'banner');
            if($model->banner)
            {
            	$siteRoot = str_replace('\\', '/', realpath(dirname(dirname(dirname(__FILE__))) . '/')) . "/frontend/web/upload/";
                $imgName = mt_rand(1100,9900) .time() .'.'. $model->banner->extension;
                $model->banner->saveAs($siteRoot.$imgName);
                $model->banner = $imgName;
            }else{
                $new = $this->findModel($id);
                $model->banner = $new->banner;
			}
			
           	if($model->validate()){
					
				$model->setAttributes(Yii::$app->request->post());
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
     * Deletes an existing Slider model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Slider model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Slider the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Slider::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
