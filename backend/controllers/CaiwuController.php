<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use backend\controllers\BackendController;
use yii\web\ForbiddenHttpException;
use wanhunet\wanhunet;
use backend\models\Product;
use backend\models\ProductSearch;
use backend\models\ProductWancheng;
use backend\models\ProductRedu;
use backend\models\Term;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class CaiwuController extends BackendController
{

    /**
     * Lists all chanpin rdu models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductRedu();
        //var_dump($searchModel);exit;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new ProductRedu();
        return $this->render('index', compact('searchModel', 'dataProvider', 'model'));
    }

   /**
     * Lists all chanpin rdu models.
     * @return mixed
     */
    public function actionShouzhi()
    {
        $searchModel = new ProductWancheng();
		$get = yii::$app->request->get();
		if (!empty($get['ProductWancheng']['term_id']) && $get['ProductWancheng']['term_id'] !="" && is_numeric($get['ProductWancheng']['term_id'])) {
			if (in_array($get['ProductWancheng']['term_id'], [2, 3, 4, 5, 6, 7])){
				$where = " and term_id=".$get['ProductWancheng']['term_id'];
				$nowterm = Term::find()->where('id=:id',[':id'=>$get['ProductWancheng']['term_id']])->one();
			} elseif(is_numeric($get['ProductWancheng']['term_id'])) {
				$where = " and term_id=8 ";
				$nowterm = Term::find()->where('id=8')->one();
			}
		}else {
			$where = "";
			$nowterm = [];
		}
        $zongzhichu = ProductWancheng::find()->where(
            '`status`=:sta and `shouru_money` is not null',
            [':sta' => 1]
            )->sum('zhichu_money');
        $zongchoude = ProductWancheng::find()->where(
            '`status`=:sta and `shouru_money` is not null',
            [':sta' => 1]
            )->sum('total_money');
        $zongshouru = ProductWancheng::find()->where(
            '`status`=:sta and `shouru_money` is not null',
            [':sta' => 1]
            )->sum('shouru_money');
			
		 $tzongzhichu = ProductWancheng::find()->where(
            '`status`=:sta and `shouru_money` is not null'.$where,
            [':sta' => 1]
            )->sum('zhichu_money');
        $tzongchoude = ProductWancheng::find()->where(
            '`status`=:sta and `shouru_money` is not null'.$where,
            [':sta' => 1]
            )->sum('total_money');
        $tzongshouru = ProductWancheng::find()->where(
            '`status`=:sta and `shouru_money` is not null'.$where,
            [':sta' => 1]
            )->sum('shouru_money');
			
			
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        $model = new ProductWancheng();
        return $this->render(
            'shouzhi',
             compact('searchModel', 'dataProvider',
			 'model', 'zongzhichu', 'zongchoude',
			 'zongshouru', 'tzongzhichu',
			 'tzongchoude', 'tzongshouru', 'nowterm'));
    }
    public function actionZhichu_money($id)
    {
        $model = $this->findModel($id);
       //&& $model->save()
        $post = Yii::$app->request->post();
        if (is_numeric($post['zhichu_money'])) {
            $model->zhichu_money = $post['zhichu_money'];
            $model->shouru_money = $model->total_money - $post['zhichu_money'];
            if ($model->save()) {
                echo 1;
            } else {
                echo 2;
            }
        } else {
            echo 2;
        }
    }

    /**
     * Lists all chanpin rdu models.
     * @return mixed
     */
    public function actionWanchengdu()
    {
         $searchModel = new ProductRedu();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new ProductRedu();
		//var_dump($model->getArrayTerm());exit;
        return $this->render('wanchengdu', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductWancheng::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
