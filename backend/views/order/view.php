<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Money */

$this->title = $model->product->name;
$this->params['breadcrumbs'][] = ['label' => '支付管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="money-view">


    <p>
        <?= Html::a('返回', ['index'], ['class' => 'btn btn-primary']) ?>
      <!--   <?= Html::a('操作', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '删除订单后前台用户将无法查看，确定删除该订单？',
                'method' => 'post',
            ],
        ]) ?> -->
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'uid',
                'value'=> $model->member->name,
            ],
             [
                'attribute' => 'cid',
                'value'=> $model->product->name,
            ],
			[
                'attribute' => 'money',
                'value' => $model->money.'元',
            ],
            // 'order_at',
            // 'pay_at',
            // 'deliver_at',
            // 'over_at',
			'order_num',
            [
                'attribute'=>'status',
                'value'=>$model->StatusLabel,
            ],	
            [
                'attribute' =>'pay_at',
                'format' =>['date','php:Y-m-d H:i:s'],
            ],
            [
                'attribute' =>'created_at',
                'format' =>['date','php:Y-m-d H:i:s'],
            ],
             [
                'attribute' =>'updated_at',
                'format' =>['date','php:Y-m-d H:i:s'],
            ],
            'info:ntext',
        ],
    ]) ?>

</div>
