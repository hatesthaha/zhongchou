<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Article */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '文章管理'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-view">


    <p>
    <?= Html::a('返回', ['index'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
			[
				'attribute' => '文章前台链接',
				'format' => 'raw',
				'value' =>  'http://bingbingzm.com/center/commonproblem?aid='.$model->id
			],
            'term_id',
            'title',
            'seo_title',
            'seo_keywords',
            'seo_contents:ntext',
			[
                'attribute'=>'top_ok',
                'value'=>$model->TuijianLabel,
            ],
			[
                'attribute'=>'status',
                'value'=>$model->StatusLabel,
            ],			
			[
                'attribute' => 'created_at',
                'format' =>  ['date', 'php:Y-m-d'],
            ],
            [
                'attribute' => 'updated_at',
                'format' =>  ['date', 'php:Y-m-d'],
            ],
        ],
    ]) ?>

</div>
