<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Invoice;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\InvoiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '订单管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invoice-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <!--<p>
        <?= Html::a('Create Invoice', ['create'], ['class' => 'btn btn-success']) ?>
    </p>-->

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'order_id',
            [
                'attribute' => 'pid',
                'value'=>function ($model) {
                    return $model->product['name'];
                },
            ],
             [
                'attribute' => 'uid',
                'value'=>function ($model) {
                    return $model->member['name'];
                },
            ],
            //'name',
            'phone',
            // 'address',
            [
                'attribute' =>'created_at',
                'format' =>['date','php:Y-m-d'],
            ],
            [
                'attribute'=>'status',
                'format' => 'html',
                'value' =>function($model){
                    if(isset($model->status)){
                        switch ($model->status) {
                            case -1:
                            return '进行中';
                            break;
                            case 0:
                            return '待发货';
                            break;
                            case 1:
                            return '待收货';
                            break;
                            case 2:
                            return '已完成';
                            break;
                            default:
                            return '状态错误';
                            break;
                        }
                    }
                },
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'status',
                    Invoice::getArrayStatus(),
                    ['class' => 'form-control', 'prompt' => '请筛选']
                )

            ],
            // 'invoice_no',
            // 'deliver_at',
            // 'over_at',

            ['class' => 'yii\grid\ActionColumn',
                'header' => '操作',
                'template' => '{preview}{view}{fahuo}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return  Html::a('&nbsp;&nbsp;<span class="glyphicon glyphicon-eye-open" >查看</span>',  Yii::$app->getUrlManager()->createUrl(['invoice/view', 'id' => $model->order_id]), ['title' => '查看'] ) ;
                    },  
                    'fahuo' => function ($url, $model, $key) {
						if(empty($model->invoice_no)){
                        return  Html::a('&nbsp;&nbsp;<span class="glyphicon glyphicon-comment" >发货</span>',  Yii::$app->getUrlManager()->createUrl(['invoice/fahuo', 'id' => $model->order_id]), ['title' => '发货'] ) ;
						}else{
							return '<span class="glyphicon glyphicon-comment" style="margin-left:5px;">已发货</span>';
						}
                    }, 					
                ],
            ],
        ],
    ]); ?>

</div>
