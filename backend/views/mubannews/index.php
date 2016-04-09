<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MubannewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '模板消息管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mubannews-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加模板', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'template_id',
            'name',
            'first:ntext',
            //'key1:ntext',
            // 'key2:ntext',
            // 'key3:ntext',
            // 'key4:ntext',
            'remark:ntext',

            ['class' => 'yii\grid\ActionColumn',
				'header' =>"操作",
				'template' => '{view}{update}',//{delete}
				'headerOptions' => ['width' => '200'],
                'buttons' => [
				  'view' => function ($url, $model, $key) {
                        return  Html::a('&nbsp;&nbsp;<span class="glyphicon glyphicon-eye-open" >查看</span>',  Yii::$app->getUrlManager()->createUrl(['mubannews/view', 'id' => $model->id]), ['title' => '查看'] ) ;
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a('&nbsp;&nbsp;<span class="glyphicon glyphicon-pencil">修改</span>', Yii::$app->getUrlManager()->createUrl(['mubannews/update', 'id' => $model->id]), ['title' => '修改'] ) ;
                    },
                    // 'delete' => function ($url, $model, $key) {
                        // return Html::a('&nbsp;&nbsp;<span class="glyphicon glyphicon-trash" >删除</span>', Yii::$app->getUrlManager()->createUrl(['mubannews/delete', 'id' => $model->id]), [
                            // 'title' => '删除',
                            // 'data'=>[
                                // 'confirm'=>'你确定要删除此项吗？',
                                // 'method'=>'post'
                            // ]
                        // ] ) ;
                    // },
				]
			],
        ],
    ]); ?>

</div>
