<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Slider;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SliderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '图片列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="slider-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加图片', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'name',
            //'banner',
            'link',
            //'content:ntext',
            [
                'attribute'=>'status',
                'format' => 'html',
                'value'=>function ($model) {
                    if ($model->status == Slider::STATUS_SUCCESS) {
                        $class = 'label-success';
                    } elseif ($model->status == Slider::STATUS_DELETED) {
                        $class = 'label-warning';
                    } else {
                        $class = 'label-danger';
                    }

                    return '<span class="label ' . $class . '">' . $model->statusLabel . '</span>';
                },
				'filter' => Html::activeDropDownList(
                    $searchModel,
                    'status',
                    Slider::getArrayStatus(),
                    ['class' => 'form-control', 'prompt' => '请筛选']
                )
            ],
            [
                'attribute' => 'created_at',
                'format' =>  ['date', 'php:Y-m-d'],
            ],
             'listorder',

           [
           'class' => 'yii\grid\ActionColumn',
           'header' => '操作',
           'template' => '{view}{update}{delete}',
           'headerOptions' => ['width' => '200'],
           'buttons' => [
		   				'view' => function ($url, $model, $key) {
		   					return  Html::a('&nbsp;&nbsp;<span class="glyphicon glyphicon-eye-open" >查看</span>', $url, ['title' => '查看'] ) ;
		   				},
		   				'update' => function ($url, $model, $key) {
		   					return Html::a('&nbsp;&nbsp;<span class="glyphicon glyphicon-pencil">修改</span>', $url, ['title' => '修改'] ) ;
		   				},
		   				'delete' => function ($url, $model, $key) {
		   					return Html::a('&nbsp;&nbsp;<span class="glyphicon glyphicon-trash" >删除</span>', $url, [
		   							'title' => '删除',
		   							'data'=>[
		   									'confirm'=>'你确定要删除吗？',
		   									'method'=>'post'
		   							]
							]) ;
		   				},
           					 
           		],
            ],
        ],
    ]); ?>

</div>
