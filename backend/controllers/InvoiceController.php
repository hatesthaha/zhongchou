<?php

namespace backend\controllers;

use Yii;
use backend\models\Invoice;
use backend\models\InvoiceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\BackendController;
use backend\models\Mubannews;
use backend\models\Member;
use backend\models\Product;

/**
 * InvoiceController implements the CRUD actions for Invoice model.
 */
class InvoiceController extends BackendController
{

    /**
     * Lists all Invoice models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InvoiceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
		$data = Invoice::find()->where(['status' => 1])->all();
		if(!empty($data)){
			foreach($data as $key=>$val){
				if((time()-$val->deliver_at) >= 10*60*60*24){
					
					Invoice::updateAll(['status'=>'2'],['order_id'=>$val->order_id]);
					
				}
			}
		}
		
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Invoice model.
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
     * Creates a new Invoice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Invoice();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Invoice model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
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

    /**
     * Deletes an existing Invoice model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

	
	public function actionFahuo($id){
		
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
			$model->status = 1;
			$model->invoice_no = Yii::$app->request->post()['Invoice']['invoice_no']; 
			$model->deliver_at = time(); 
			$model->save();
			
			$mubannews = Mubannews::find()->where('name=:name', [':name'=> "发货通知"])->asArray()->one();
			if (!empty($mubannews)) {
				$member = Member::find()->where('id=:id', [':id'=>$model->uid])->asArray()->one();//
				//var_dump($mubannews);exit;
				//发送客服消息--模板消息
				$data['template_id'] = $mubannews['template_id'];
				$data['touser'] = $member['openid'];
				$data['url'] = "http://bingbingzm.com/order/myorder/?type=dsh";
				if (empty($mubannews['first'])) {
					$data['first']['value'] = "您的众筹产品【".$model['name']."】已发货";
				} else {
					$data['first']['value'] = sprintf($mubannews['first'], $model['name']);
				}
				$product = Product::find()->where('id=:id', [':id'=>$model->pid])->asArray()->one();
				$data[1]['key'] = 'keyword1';
				$data[2]['key'] = 'keyword2';
				$data[3]['key'] = 'keyword3';
				$data[4]['key'] = 'keyword4';
				$data[1]['value'] = empty($product['name']) ? "未设置" : $product['name'];
				$data[2]['value'] = $model->wuliu;
				$data[3]['value'] = $model->invoice_no;
				$data[4]['value'] = $model->name .'|'. $model->address;
				$data['Remark']['value'] = empty($mubannews['Remark']) ? "请耐心等待" : $mubannews['Remark'] ;
				
				$this->sendMobanmes4($data);
				
			}
            return $this->redirect(['index']);
        } else {
            return $this->render('fahuo', [
                'model' => $model,
				'id' => $id,
            ]); 
        }
	}
    /**
     * Finds the Invoice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Invoice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Invoice::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
