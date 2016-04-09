<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


/* @var $this yii\web\View */
/* @var $model backend\models\Product */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '项目管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-view">

    <p>
    <?= Html::a('返回', ['index'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '你确定要删除此项目吗？',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
			[
				'attribute' => '商品前台链接',
				'format' => 'raw',
				'value' =>  $model->term_id ==7? 'http://bingbingzm.com/project/projectdetails/'.$model->id : 'http://bingbingzm.com/yyzc/projectdetailsyy/'.$model->id
			],
            'content',
            'img',
            'c_img',
/*             'h_num',
            's_num', */
			[
                'attribute' => 'total_money',
                'value' => $model->total_money.'元',
            ],
			[
                'attribute' => 'target_money',
                'value' => $model->target_money.'元',
            ],
			[
                'attribute'=>'status',
                'value'=>$model->statusLabel,
            ],

            //'r_day',
            //'pay',
			[
                'attribute' => 'created_at',
                'format' =>  ['date', 'php:Y-m-d H:i:s'],
            ],
			[
                'attribute' => 'updated_at',
                'format' =>  ['date', 'php:Y-m-d H:i:s'],
            ],
            //'user_id',
			[
                'attribute' => 'end_time',
                'format' =>  ['date', 'php:Y-m-d H:i:s'],
            ],
            'search_num',
        ],
    ]) ?>

</div>
