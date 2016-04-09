<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\User;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create ') . Yii::t('app', 'User'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'username',
            // 'auth_key',
            // 'password_hash',
            // 'password_reset_token',
            'email:email',
            [
                'attribute' => 'status',
                'format' => 'html',
                'value' => function ($model) {
                        if ($model->status === $model::STATUS_ACTIVE) {
                            $class = 'label-success';
                        } elseif ($model->status === $model::STATUS_INACTIVE) {
                            $class = 'label-warning';
                        } else {
                            $class = 'label-danger';
                        }

                        return '<span class="label ' . $class . '">' . $model->statusLabel . '</span>';
                    },
                'filter' => Html::activeDropDownList(
                        $searchModel,
                        'status',
                        $arrayStatus,
                        ['class' => 'form-control', 'prompt' => Yii::t('app', 'Please Filter')]
                    )
            ],
            //'created_at',
            [
                'attribute' => 'created_at',
                'format' => ['date', 'Y-M-d'],
            ],
            //'updated_at',

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
