<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Product;
use backend\models\ProductSearch;
use backend\models\ProductRedu;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\InvoiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '产品完成度统计';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invoice-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'name',
            
            [
                'label'=>'项目名称（点击可查看详情）',
                 'attribute' => 'name',
                'format'=>'raw',
                'value' => function($model){
                    $url = $model->pro_href;
                    return Html::a($model->name, $url, ['title' => '查看','target' => '_blank']);
                }
            ] ,
			
			[
				 'attribute' => 'term_id',
                 'format' => 'raw',
				
                'value'=>function ($model) {
					$tid = $model->getArrayTermall();
					//var_dump($tid);exit;
                    return empty($tid[$model->term_id])?'未设置':$tid[$model->term_id];
                },
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'term_id', 
                    ProductRedu::getArrayTerm(),
                    ['class' => 'form-control', 'prompt' => '请筛选']
                )
            ] ,

            [
                'attribute' => '完成度',
                'value' =>function ($model) {
                    if($model->target_money && $model->total_money)
                        return sprintf('%.2f', $model->total_money/$model->target_money*100) .' %';
                    else
                        return '0.00 %';                    
                },
            ], 
            //'content',
            //'img',
            //'c_img',
            /* [
                'attribute' => 'h_num',
                'value'=>function ($model) {
                    if($model->h_num)
                        return $model->h_num;
                    else
                        return '0';
                }
            ],
            [
                'attribute' => 's_num',
                'value' =>function ($model) {
                    if($model->s_num)
                        return $model->s_num;
                    else
                        return '0';                 
                }
            ], */
            [
                'attribute' => 'total_money',
                'value'=>function ($model) {
                    if($model->total_money)
                        return $model->total_money."元";
                    else
                        return '0元';
                }
            ],
            [
                'attribute' => 'target_money',
                'value' =>function ($model) {
                    if($model->target_money)
                        return $model->target_money."元";
                    else
                        return '0元';                    
                }
            ],      
            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:Y-m-d']
            ],
            [
                'attribute' => 'end_time',
                'value' =>function ($model) {
                    if($model->end_time)
                        return date('Y-m-d', $model->end_time);
                    else
                        return '未完成';                    
                },
            ],
             //'top_ok',
             [
                'attribute'=>'status',
                'format' => 'html',
                
                'value'=>function ($model) {
                    if ($model->status ===Product::STATUS_COMPLETE) {
                        $class = 'label-success';
                    } elseif ($model->status === Product::STATUS_NSTARTED) {
                        $class = 'label-warning';
                    } else {
                        $class = 'label-danger';
                    }

                    return '<span class="label ' . $class . '">' . $model->statusLabel . '</span>';
                },
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'status',
                    Product::getArrayStatus(),
                    ['class' => 'form-control', 'prompt' => '请筛选']
                )
            ],
            // 'r_day',
            // 'pay',
            //'created_at',
            // 'updated_at',
            // 'user_id',
            // 'end_time:datetime',
            // 'search_num',
        ],
    ]); ?>

</div>
