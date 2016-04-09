<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Mubannews */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mubannews-form">

    <?php $form = ActiveForm::begin(); ?>
	
	
    <?= $form->field($model, 'template_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'first')->textarea(['rows' => 2]) ?>
	
	
    <?= $form->field($model, 'remark')->textarea(['rows' =>3]) ?>

    <?= $form->field($model, 'key1')->textarea(['rows' => 3]) ?>

    <?= $form->field($model, 'key2')->textarea(['rows' => 6]) ?>

    <!--<?= $form->field($model, 'key3')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'key4')->textarea(['rows' => 6]) ?>-->


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '提交' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		<?= Html::a('返回', ['index'], ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
