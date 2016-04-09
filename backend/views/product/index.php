<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\CGridView;
use backend\models\Product;
use backend\models\Member;
use backend\models\invoice;
use backend\models\term;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '项目管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
.action-column{width:155px;}
</style>
<div class="product-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <!--<?= Html::a('新建项目', ['create'], ['class' => 'btn btn-success']) ?>-->
    </p>

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
					$tid = $model->getArrayTerm();
                    return $tid[$model->term_id];
                },
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'term_id', 
                    Product::getArrayTerm(),
                    ['class' => 'form-control', 'prompt' => '请筛选']
                )
            ] ,
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
             [
                'attribute'=>'shenhe',
                'format' => 'html',
                'value'=>function ($model) {
                    if ($model->shenhe ===Product::SHENHE_ACTIVE) {
                        $class = 'label-success';
                    } elseif ($model->shenhe === Product::SHENHE_INACTIVE) {
                        $class = 'label-warning';
                    } else {
                        $class = 'label-danger';
                    }

                    return '<span class="label ' . $class . '">' . $model->shenheLabel . '</span>';
                },
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'shenhe',
                    Product::getArrayShenhe(),
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

                ['class' => 'yii\grid\ActionColumn',
                'header' => '操作',
				 'headerOptions' => ['width'=>'250px'],
                'template' => '{preview}{view}{update}{shenhe}{unshenhe}{jujue}{unjujue}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return  Html::a('&nbsp;&nbsp;<span class="glyphicon glyphicon-eye-open" >查看</span>',  Yii::$app->getUrlManager()->createUrl(['product/view', 'id' => $model->id]), ['title' => '查看'] ) ;
                    },
					 'update' => function ($url, $model, $key) {
                        return  Html::a('&nbsp;&nbsp;<span class="glyphicon glyphicon-eye-open" >编辑</span>',  Yii::$app->getUrlManager()->createUrl(['product/update', 'id' => $model->id]), ['title' => '编辑'] ) ;
                    },

                    'shenhe' => function ($url, $model, $key) {
                        return $model->shenhe == Product::SHENHE_INACTIVE ?
                            Html::a('&nbsp;&nbsp;<span class="glyphicon glyphicon-send">审核</span>', $url, ['title' => '审核'] ) : '';
                    },
                    'unshenhe' => function ($url, $model, $key) {
                        return $model->shenhe == Product::SHENHE_ACTIVE ?
                            Html::a('&nbsp;&nbsp;<span class="glyphicon glyphicon-comment">取消审核</span>', $url, ['title' => '取消审核'] ) : '';
                    },
                    'jujue' => function ($url, $model, $key) {
                        return $model->shenhe == Product::SHENHE_INACTIVE ?
						Html::a('&nbsp;&nbsp;<span class="glyphicon glyphicon-send">拒绝</span>', $url, ['title' => '拒绝'] ) : '';
                    },
                    'unjujue' => function ($url, $model, $key) {
                        return $model->shenhe == Product::SHENHE_JUJUE ?
						Html::a('&nbsp;&nbsp;<span class="glyphicon glyphicon-send">取消拒绝</span>', $url, ['title' => '取消拒绝'] ) : "";
                    },					
                ],
            ],
        ],
    ]); ?>

</div>
