<?php

namespace backend\controllers;

use Yii;
use backend\models\Term;
use backend\models\TermSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Command;
use backend\controllers\BackendController;

class TermController extends BackendController{
	
	public function actionIndex(){
		$data = Term::get(0, Term::find()->all());
        return $this->render('index', [
            'num' => count($data),
            'data' => $data,
        ]);
		
	}
    public function actionCreate()
    {
        $model = new Term();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
	
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
	
    public function actionDelete($id)
    {
		 if(!Term::isDel($id)){
			Term::updateAll(['status'=>Term::STATUS_DELETED],['id' =>$id]);
			}
		return $this->redirect(['index']);
        //$this->findModel($id)->delete();
    }
	
    protected function findModel($id)
    {
        if (($model = Term::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
}
	