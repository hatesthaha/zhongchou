<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Order;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MoneySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '支付管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="money-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            [
                'attribute' => 'uid',
                'value'=>function ($model) {
                    return $model->member->name;
                },
            ],
             [
                'attribute' => 'cid',
                'value'=>function ($model) {
                    return $model->product->name;
                },
            ],
            //'info:ntext',
			[
                'attribute' => 'money',
                'value'=>function ($model) {
					if($model->money)
						return $model->money."元";
					else
						return '0元';
				}
            ],
            [
                'attribute' =>'created_at',
                'format' =>['date','php:Y-m-d'],
            ],

            //'created_at',
            // 'order_at',
            // 'pay_at',
            // 'deliver_at',
            // 'over_at',
			'order_num',
            [
                'attribute'=>'status',
                'format' => 'html',
                'value' =>function($model){
                    if(isset($model->status)){
                        switch ($model->status) {
                            case 0:
                                return '未付款';
                                break;
                            case 1:
                                return '已付款';
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
                    Order::getArrayStatus(),
                    ['class' => 'form-control', 'prompt' => '请筛选']
                )

            ],
            // 'order_num',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn',
                'header' => '操作',
                'template' => '{preview}{view}{delete}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return  Html::a('&nbsp;&nbsp;<span class="glyphicon glyphicon-eye-open" >查看</span>',  Yii::$app->getUrlManager()->createUrl(['order/view', 'id' => $model->id]), ['title' => '查看'] ) ;
                    },  
                    'delete' => function ($url, $model, $key) {
                        return Html::a('&nbsp;&nbsp;<span class="glyphicon glyphicon-trash" >删除</span>', Yii::$app->getUrlManager()->createUrl(['order/delete', 'id' => $model->id]), [
                            'title' => '删除',
                            'data'=>[
                                'confirm'=>'你确定要删除此项吗？',
                                'method'=>'post'
                            ]
                        ] ) ;
                    },					
                ],
            ],
        ],
    ]); ?>

</div>
