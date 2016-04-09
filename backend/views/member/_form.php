<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Member;
use backend\models\MemberSearch;

use kartik\file\FileInput;
use xj\ueditor\Ueditor;
use dosamigos\datetimepicker\DateTimePicker;
/* @var $this yii\web\View */
/* @var $model backend\models\Member */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="member-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
	
    <?= $form->field($model, 'gender')->dropDownList(member::getArraySex()) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
	
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?php
    echo '<label class="control-label">头像<span style="color:red;font-size:12px;padding-left:20px;letter-space:1px;">( 格式： 95*95，只支持 "jpg, gif,jpeg, png" 的文件扩展名. )</span></label>';
    echo FileInput::widget([
        'model' => $model,
        'attribute' => 'head',
        'pluginOptions' => [
            'uploadExtraData' => [
                'album_id' => 20,
                'cat_id' => 'Nature'
            ],
            'maxFileCount' => 4,
            'initialCaption'=> $model->head,
            "showUpload"=> false,
        ],
    ]);
    ?>	
	
    <?= $form->field($model, 'signature')->textInput(['maxlength' => true]) ?>
	
    <?= $form->field($model, 'tmoney')->textInput() ?>

    <?= $form->field($model, 'prestige')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
