<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\web\View;
use backend\models\Yyzc;
use backend\models\Term;
use kartik\file\FileInput;
use xj\ueditor\Ueditor;
use dosamigos\datetimepicker\DateTimePicker;


/* @var $this yii\web\View */
/* @var $model backend\models\Product */
/* @var $form yii\widgets\ActiveForm */
$parentCatalog = ArrayHelper::merge([0 =>'请选择栏目'],[7 =>'公益梦'], ArrayHelper::map(Term::get(8, Term::find()->all()), 'id', 'str_label'));
unset($parentCatalog[$model->id]);
?>
<script src="/assets/a58c8f1b/jquery.js"></script>
<div class="product-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
	
    <?= $form->field($model, 'term_id')->dropDownList($parentCatalog) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>
	
    <?php
    echo '<label class="control-label">封面图片<br><span style="color:red;font-size:12px;padding-left:20px;letter-space:1px;">( 一元众筹最佳宽高比为 2:1；<!--公益梦首张图片比例为1:1，其他为5:2。只支持 "jpg, gif, jpeg, png" 的文件扩展名. 最多上传4张-->)</span></label>';
    echo FileInput::widget([
        'model' => $model,
        'attribute' => 'img[]',
        'pluginOptions' => [
            'uploadExtraData' => [
                'album_id' => 20,
                'cat_id' => 'Nature'
            ],
            'maxFileCount' => 4,
            'initialCaption'=> $model->img,
            "showUpload"=> false,
        ],
		'options'=>['multiple' => "multiple"],
    ]);
    ?>	
	
    <?php
    echo '<label class="control-label">项目图片<span style="color:red;font-size:12px;padding-left:20px;letter-space:1px;">(只支持 "jpg, gif, jpeg, png" 的文件扩展名. )</span></label>';
    echo FileInput::widget([
        'model' => $model,
        'attribute' => 'c_img[]',
        'pluginOptions' => [
            'uploadExtraData' => [
                'album_id' => 20,
                'cat_id' => 'Nature'
            ],
            'initialCaption'=> $model->c_img,
            "showUpload"=> false,
        ],
		'options'=>['multiple' => "multiple"],
    ]);
    ?>	

    <?= $form->field($model, 'target_money')->textInput() ?>

	
	<?php $end_time = !empty($model->end_time) ? date("Y-m-d",$model->end_time ) :date("Y-m-d",time()+86400*7); ?>
	
	<div class="form-group field-product-target_money" id="t_end" <?php if($model->term_id !=7 ) echo "style='display:none;'"?>>
	<label class="control-label" for="product-target_money">结束时间</label>
	<div style="width: 200px;">
            <?= DateTimePicker::widget([
                'name' => 'end_time',
                'value' => $end_time,
                'language' => 'zh-CN',
                'size' => 'ms',
                'clientOptions' => [
                    'startView' => 2,
                    'minView' => 2,
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd',
                    'todayBtn' => true
                ]
            ]); ?>
	</div>
	
	<div class="help-block"></div>
	</div>
	
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','id'=>'b_sub']) ?>
    </div>

    <?php ActiveForm::end(); ?>
	<script>
	$(document).ready(function(){
		
		 $("body").on("click", "#b_sub", function() {
			 if($("#yyzc-img").parents(".input-group-btn").siblings(".form-control").find(".file-caption-name").attr('title')==''||$("#yyzc-img").parents(".input-group-btn").siblings(".form-control").find(".file-caption-name").attr('title')==undefined){
                alert("封面图片必须上传");
                return false;
            }
            $('form').submit();
			 
		 });
		
		 $("#yyzc-term_id").change(function(){
			if($(this).val()!=7)
				$("#t_end").hide();
			else
				$("#t_end").show();
		}); 
	});
	</script>
</div>
