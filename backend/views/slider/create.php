<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Slider */

$this->title = '添加图片';
$this->params['breadcrumbs'][] = ['label' => '轮动广告', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="slider-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
