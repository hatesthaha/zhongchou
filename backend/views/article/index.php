<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Article;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '文章管理');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', '创建'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'term_id',
                'value'=>function ($model) {
                    return $model->category->name;
                },
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'term_id',
                    \backend\models\Article::getArrayCategory(),
                    ['class' => 'form-control', 'prompt' => '请筛选']
                )
            ],
            'title',
            // 'seo_keywords',
            // 'seo_contents:ntext',
            // 'top_ok',
            [
                'attribute'=>'status',
                'format' => 'html',
                'value'=>function ($model) {
                    if ($model->status ===Article::STATUS_ACTIVE) {
                        $class = 'label-success';
                    } elseif ($model->status === Article::STATUS_INACTIVE) {
                        $class = 'label-warning';
                    } else {
                        $class = 'label-danger';
                    }

                    return '<span class="label ' . $class . '">' . $model->statusLabel . '</span>';
                },
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'status',
                    Article::getArrayStatus(),
                    ['class' => 'form-control', 'prompt' => '请筛选']
                )
            ],
            // 'created_at',
            // 'updated_at',
			[
                'attribute' => 'created_at',
                'format' => ['date', 'php:Y-m-d']
            ],

            ['class' => 'yii\grid\ActionColumn',
                'header' => '操作',
                'template' => '{preview}{view}{update}{send}{unsend}',
                'buttons' => [//{delete}
                    'view' => function ($url, $model, $key) {
                        return  Html::a('&nbsp;&nbsp;<span class="glyphicon glyphicon-eye-open" >查看</span>',  Yii::$app->getUrlManager()->createUrl(['article/view', 'id' => $model->id]), ['title' => '查看'] ) ;
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a('&nbsp;&nbsp;<span class="glyphicon glyphicon-pencil">修改</span>', Yii::$app->getUrlManager()->createUrl(['article/update', 'id' => $model->id]), ['title' => '修改'] ) ;
                    },
                    // 'delete' => function ($url, $model, $key) {
                        // return Html::a('&nbsp;&nbsp;<span class="glyphicon glyphicon-trash" >删除</span>', Yii::$app->getUrlManager()->createUrl(['article/delete', 'id' => $model->id]), [
                            // 'title' => '删除',
                            // 'data'=>[
                                // 'confirm'=>'你确定要删除此项吗？',
                                // 'method'=>'post'
                            // ]
                        // ] ) ;
                    // },
                    'send' => function ($url, $model, $key) {
                        return $model->status == Article::STATUS_INACTIVE ?
                            Html::a('&nbsp;&nbsp;<span class="glyphicon glyphicon-send">发布</span>', $url, ['title' => '发布'] ) : '';
                    },
                    'unsend' => function ($url, $model, $key) {
                        return $model->status == Article::STATUS_ACTIVE ?
                            Html::a('&nbsp;&nbsp;<span class="glyphicon glyphicon-comment">取消发布</span>', $url, ['title' => '取消发布'] ) : '';
                    },

                ],
            ],
        ],
    ]); ?>

</div>
