<?php

namespace backend\controllers;

use Yii;
use backend\models\Member;
use backend\models\MemberSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;
use backend\controllers\BackendController;

/**
 * MemberController implements the CRUD actions for Member model.
 */
class MemberController extends BackendController
{
    

    /**
     * Lists all Member models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MemberSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Member model.
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
     * Creates a new Member model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Member();

        if ($model->load(Yii::$app->request->post())) {
			
            $model->head = UploadedFile::getInstance($model, 'head');
			
            if($model->head)
            {
            	$siteRoot = str_replace('\\', '/', realpath(dirname(dirname(dirname(__FILE__))) . '/')) . "/frontend/web/upload/";
                $imgName = mt_rand(1100,9900) .time() .'.'. $model->head->extension;
                $model->head->saveAs($siteRoot.$imgName);
                $model->head = $imgName;
            }
			$model->save();
			
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
	
	//发送临时消息
	public function actionSendmes($id)
    {
        $model = new Member();

        if ($model->load(Yii::$app->request->post())) {
			$member = Member::find()->where('id=:id', [':id'=>$id ])->asArray()->one();
			$touser = $member['openid'];
			$data['touser'] = $touser;
			$data['content'] = $model->message;
			$res = $this->kefumes($data);
			
            return $this->render('sendmes', [
                'model' => $model,
				'errcode' => $res->errcode
            ]);
        } else {
            return $this->render('sendmes', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Member model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
			
            $model->head = UploadedFile::getInstance($model, 'head');
			
            if($model->head)
            {
            	$siteRoot = str_replace('\\', '/', realpath(dirname(dirname(dirname(__FILE__))) . '/')) . "/frontend/web/upload/";
                $imgName = mt_rand(1100,9900) .time() .'.'. $model->head->extension;
                $model->head->saveAs($siteRoot.$imgName);
                $model->head = $imgName;
            }else{
				$new = $this->findModel($id);
                $model->head = $new->head;
			}
			
			
			$model->name = Yii::$app->request->post()['Member']['name'];
            $model->gender = Yii::$app->request->post()['Member']['gender'];
            $model->phone = Yii::$app->request->post()['Member']['phone'];
            $model->email = Yii::$app->request->post()['Member']['email'];
            $model->signature = Yii::$app->request->post()['Member']['signature'];
            $model->tmoney = Yii::$app->request->post()['Member']['tmoney'];
            $model->prestige = Yii::$app->request->post()['Member']['prestige'];
			$model->save();

			return $this->redirect(['index']);

        } else {
			$model->password_hash='';
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Member model.
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
     * Finds the Member model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Member the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Member::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
