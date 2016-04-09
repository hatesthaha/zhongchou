<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Invoice */

$this->title = $model->product->name;
$this->params['breadcrumbs'][] = ['label' => '订单管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invoice-view">


    <p>
       <?= Html::a('返回', ['index'], ['class' => 'btn btn-primary']) ?>
        <!--<?= Html::a('Delete', ['delete', 'id' => $model->order_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>-->
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'order_id',
            [
                'attribute' => 'pid',
                'value'=> $model->product->name,
            ],
             [
                'attribute' => 'uid',
                'value'=> $model->member->name,
            ],
            'name',
            'phone',
            'address',
            [
                'attribute'=>'status',
                'value'=>$model->StatusLabel,
            ],	
            'invoice_no',
            [
                'attribute' =>'deliver_at',
                'format' =>['date','php:Y-m-d H:i:s'],
            ],
            [
                'attribute' =>'over_at',
                'format' =>['date','php:Y-m-d H:i:s'],
            ],
            [
                'attribute' =>'created_at',
                'format' =>['date','php:Y-m-d H:i:s'],
            ],
        ],
    ]) ?>

</div>
