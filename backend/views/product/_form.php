<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use backend\models\Product;
use backend\models\ProductSearch;

use backend\models\Term;
use kartik\file\FileInput;
use xj\ueditor\Ueditor;
use dosamigos\datetimepicker\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
	<label class="control-label">详情链接</label>：<a href="<?= $model->pro_href ?>" target="_blank"><button><?= $model->name;$model->pro_href;?></button></a>
	<?php echo "<br><br>";?>
	
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
	<?= $form->field($model, 'content')->textarea(['maxlength' => true]) ?>
	     	
    <?php
	echo "<br><br>";
    echo '<label class="control-label">封面图片<span style="color:red;font-size:12px;padding-left:20px;letter-space:1px;">( 最佳宽高比： 5:2，只支持 "jpg, gif,jpeg, png" 的文件扩展名. )</span></label>';
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
	echo "<br><br>";
    echo '<label class="control-label">项目图片<span style="color:red;font-size:12px;padding-left:20px;letter-space:1px;">(只支持 "jpg, gif,jpeg, png" 的文件扩展名. )</span></label>';
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
	echo "<br><br>";
    ?>	

    <?= $form->field($model, 'target_money')->textInput() ?>

    <?= $form->field($model, 'shenhe')->dropDownList(Product::getArrayShenhe()) ?>
	
	<?= $form->field($model, 'jujueyuanyin')->textarea(['maxlength' => true, 'placeholder'=>"只在项目被决绝的情况下有效"]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

<?= Html::a('返回', ['index'], ['class' => 'btn btn-primary']) ?>  
<br><br><br><br><br><br><br><br><br><br><br><br> 
   </div>

    <?php ActiveForm::end(); ?>
<script>
	var type='<?php if(!empty($_GET['type'])){echo $_GET['type'];}?>';
	if (type=='jujue'){
		$("#product-jujueyuanyin").focus();
	}
</script>

</div>




