<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MemberSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '会员管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="member-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加会员', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'name',
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
             'phone',
            // 'cardid',
            // 'head',
            // 'autograph',
            // 'sign',
            [
                'attribute'=>'prestige',
                'format' => 'html',
                'value'=>function ($model) {
                    if ($model->prestige) {
                        return $model->prestige;
                    }else {
                        return 0;
                    }
                },
            ],
            // 'tmoney',
            [
                'attribute' => 'created_at',
                'format' =>  ['date', 'php:Y-m-d'],
            ],
            // 'updated_at',
            // 'gender',
            [
                'attribute'=>'email',
                'format' => 'html',
                'value'=>function ($model) {
                    if ($model->email) {
                        return $model->email;
                    }else {
                        return '';
                    }
                },
            ],
            // 'signature',
            // 'address',
            // 'product_id',
            // 'seen:ntext',
            // 'search_record:ntext',

            [
            		'class' => 'yii\grid\ActionColumn',
            		'header' => '操作',
            		'template' => '{view}{update}{delete}{sendmes}',
            		'headerOptions' => ['width' => '300'],
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
									'sendmes' => function ($url, $model, $key) {
		            					return Html::a('&nbsp;&nbsp;<span class="glyphicon glyphicon-pencil">客服消息</span>', $url, ['title' => '客服消息'] ) ;
		            				},
            							 
            				],
            ],
        ],
    ]); ?>

</div>
