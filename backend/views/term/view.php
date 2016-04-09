<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Term */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '分类管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="term-view">


    <p>
    <?= Html::a('返回', ['index'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确定要删除吗?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
			'parent_id',
            'name',
			[
				'attribute' => '栏目前台链接',
				'format' => 'raw',
				'value' =>  $model->parent_id ==1? 'http://bingbingzm.com/search/searchitem?tid='.$model->id : ($model->parent_id ==8?'http://bingbingzm.com/search/searchitem?tid='.$model->id :"不便于前台显示"),
			],
            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:Y-m-d H:i:s']
            ],
            [
                'attribute' => 'updated_at',
                'format' => ['date', 'php:Y-m-d H:i:s']
            ],
            
        ],
    ]) ?>

</div>
