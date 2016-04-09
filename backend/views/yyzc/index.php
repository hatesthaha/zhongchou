<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Yyzc;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '项目管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
/*.action-column{width:140px;}*/
</style>
<div class="product-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新建项目', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'name',
				
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
                    Yyzc::getArrayTerm(),
                    ['class' => 'form-control', 'prompt' => '请筛选']
                )
            ] ,
            //'content',
            //'img',
            //'c_img',
/* 			[
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
             //'top_ok',
			 [
                'attribute'=>'status',
                'format' => 'html',
				
                'value'=>function ($model) {
                    if ($model->status ===Yyzc::STATUS_COMPLETE) {
                        $class = 'label-success';
                    } elseif ($model->status === Yyzc::STATUS_NSTARTED) {
                        $class = 'label-warning';
                    } elseif ($model->status === Yyzc::STATUS_DELETED) {
                        $class = 'label-warning';
                    } else
						$class = 'label-danger';

                    return '<span class="label ' . $class . '">' . $model->statusLabel . '</span>';
                },
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'status',
                    Yyzc::getArrayStatus(),
                    ['class' => 'form-control', 'prompt' => '请筛选']
                )
            ],

            // 'r_day',
            // 'pay',
            // 'updated_at',
            // 'user_id',
            // 'end_time:datetime',
            // 'search_num',

                ['class' => 'yii\grid\ActionColumn',
                'header' => '操作',
                'template' => '{preview}{view}{update}{delete}',
                'buttons' => [

                    'view' => function ($url, $model, $key) {
                        return  Html::a('&nbsp;&nbsp;<span class="glyphicon glyphicon-eye-open" >查看</span>',  Yii::$app->getUrlManager()->createUrl(['yyzc/view', 'id' => $model->id]), ['title' => '查看'] ) ;
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a('&nbsp;&nbsp;<span class="glyphicon glyphicon-pencil">修改</span>', Yii::$app->getUrlManager()->createUrl(['yyzc/update', 'id' => $model->id]), ['title' => '修改'] ) ;
                    },
                    'delete' => function ($url, $model, $key) {
						if($model->status==Yyzc::STATUS_COMPLETE){
							$str="删除后不可恢复,你确定要删除此项吗？";
						}else{
							$str="不能删除,项目还没有完成！";
						}
                        return Html::a('&nbsp;&nbsp;<span class="glyphicon glyphicon-trash" >删除</span>', Yii::$app->getUrlManager()->createUrl(['yyzc/delete', 'id' => $model->id]), [
                            'title' => '删除',
                            'data'=>[
                                'confirm'=>$str,
                                'method'=>'post'
                            ]
                        ] ) ;
                    },

                ],
            ],
        ],
    ]); ?>

</div>
