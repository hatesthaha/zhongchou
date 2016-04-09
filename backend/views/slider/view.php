<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Slider */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '轮动广告', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="slider-view">


    <p>
    <?= Html::a('返回', ['index'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '你确定要删除吗?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'banner',
            'link',
            'content:ntext',
            [
                'attribute' => 'status',
                'value' => $model->statusLabel,
            ],
            'listorder',
			[
                'attribute' => 'created_at',
                'format' =>  ['date', 'php:Y-m-d H:i:s'],
            ],
            [
                'attribute' => 'updated_at',
                'format' =>  ['date', 'php:Y-m-d H:i:s'],
            ],
        ],
    ]) ?>

</div>
