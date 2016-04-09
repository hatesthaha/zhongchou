<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use xj\ueditor\Ueditor;
use backend\models\Slider;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model backend\models\Slider */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="slider-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

     <?php
	    echo '<label class="control-label">图片上传<span id="message" style="color:red;font-size:12px;padding-left:20px;letter-space:1px;">(只支持 "jpg, gif,jpeg, png" 的文件扩展名. )</span></label>';
	    echo FileInput::widget([
	        'model' => $model,
	        'attribute' => 'banner',
	        'pluginOptions' => [
	
	            'uploadExtraData' => [
	                'album_id' => 20,
	                'cat_id' => 'Nature'
	            ],
	        	'allowedFileExtensions'=>['jpg','gif','jpeg', 'png'],
	            'maxFileCount' => 1,
	            'initialCaption'=> $model->banner,
	            "showUpload"=> false,
	        ]
	    ]);
    ?>

    <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'listorder')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->dropDownList(slider::getArrayStatus()) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','id'=>'b_sub']) ?>
    </div>

    <?php ActiveForm::end(); ?>
	<script>
	$(document).ready(function(){
		
		 $("body").on("click", "#b_sub", function() {
			 if($("#slider-banner").parents(".input-group-btn").siblings(".form-control").find(".file-caption-name").attr('title')==''||$("#slider-banner").parents(".input-group-btn").siblings(".form-control").find(".file-caption-name").attr('title')==undefined){
                alert("图片必须上传");
                return false;
            }
            $('form').submit();
			 
		 });
	});
	</script>
</div>
