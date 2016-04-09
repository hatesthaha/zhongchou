<?php

use yii\helpers\Html;
use yii\grid\GridViewechart;
use backend\models\Product;
use backend\models\ProductSearch;
use backend\models\ProductRedu;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\InvoiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '产品热度统计';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invoice-index">
    <?= GridViewechart::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'name',
            
            [
                'label'=>'项目名称',
                 'attribute' => 'name',
                'format'=>'raw',
                'value' => $model->name,
            ] ,
			
			
			[
				 'attribute' => 'term_id',
                 'format' => 'raw',
				
                'value'=>function ($model) {
					$tid = $model->getArrayTerm();
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
                'attribute' => 'h_num',
            ],
            [
                'attribute' => 's_num',
                'value' =>function ($model) {
                    if($model->s_num)
                        return $model->s_num;
                    else
                        return '0';                 
                }
            ],   
            [
                'attribute' => 'search_num',
                'value' =>function ($model) {
                    if($model->s_num)
                        return $model->search_num;
                    else
                        return '0';                 
                }
            ],      
            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:Y-m-d']
            ],
            [
                'attribute'=>'status',
                'format' => 'html',
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'status',
                    Product::getArrayStatus(),
                    ['class' => 'form-control', 'prompt' => '请筛选']
                )
            ],
        ]
        ]); 
    ?>

</div>
