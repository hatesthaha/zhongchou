<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Term */

$this->title = '更新: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '分类管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="term-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
