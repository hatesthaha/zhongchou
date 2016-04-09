<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'content') ?>

    <?= $form->field($model, 'img') ?>

    <?= $form->field($model, 'c_img') ?>

    <?php // echo $form->field($model, 'h_num') ?>

    <?php // echo $form->field($model, 's_num') ?>

    <?php // echo $form->field($model, 'total_money') ?>

    <?php // echo $form->field($model, 'target_money') ?>

    <?php // echo $form->field($model, 'top_ok') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'r_day') ?>

    <?php // echo $form->field($model, 'pay') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <?php // echo $form->field($model, 'end_time') ?>

    <?php // echo $form->field($model, 'search_num') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
