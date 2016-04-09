<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\MubannewsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mubannews-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'template_id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'first') ?>

    <?= $form->field($model, 'key1') ?>

    <?php // echo $form->field($model, 'key2') ?>

    <?php // echo $form->field($model, 'key3') ?>

    <?php // echo $form->field($model, 'key4') ?>

    <?php // echo $form->field($model, 'remark') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
