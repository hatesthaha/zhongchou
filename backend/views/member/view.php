<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Member */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '会员管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="member-view">

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
            'name',
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
            'phone',
            //'cardid',
            'head',
            //'autograph',
            //'sign',
            //'level',
			[
                'attribute' => 'tmoney',
                'value' => $model->tmoney.'元',
            ],
            [
                'attribute' => 'created_at',
                'format' =>  ['date', 'php:Y-m-d H:i:s'],
            ],
            [
                'attribute' => 'updated_at',
                'format' =>  ['date', 'php:Y-m-d H:i:s'],
            ],
			[
                'attribute'=>'gender',
                'value'=>$model->sexLabel,
            ],
            'email:email',
            'signature',
            //'address',
            //'product_id',
            'prestige',
            //'seen:ntext',
            //'search_record:ntext',
        ],
    ]) ?>

</div>
