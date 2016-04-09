<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Term;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\Term */
/* @var $form yii\widgets\ActiveForm */


$parentCatalog = ArrayHelper::merge([0 =>'顶级分类'], ArrayHelper::map(Term::get(0, Term::find()->all()), 'id', 'str_label'));
unset($parentCatalog[$model->id]);

?>

<div class="term-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
	
    <?= $form->field($model, 'parent_id')->dropDownList($parentCatalog) ?>

    <?= $form->field($model, 'status')->dropDownList(Term::getArrayStatus()) ?>

	<!--<?= $form->field($model, 'dmoney', ['labelOptions' => ['label' => '金额(提示：只能项目类可以输入除了一元众筹、和公益梦)']])->textInput() ?>-->

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
