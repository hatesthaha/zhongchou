<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Term */

$this->title = '创建分类';
$this->params['breadcrumbs'][] = ['label' => '分类管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="term-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
