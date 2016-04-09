<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\web\View;
use backend\models\Article;
use kartik\file\FileInput;
use xj\ueditor\Ueditor;

/* @var $this yii\web\View */
/* @var $model backend\models\Article */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'term_id')->dropDownList(ArrayHelper::map(\backend\models\Term::get(0, \backend\models\Term::find()->where(['status'=>1])->asArray()->all()), 'id', 'str_label')) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
	
    <?= $form->field($model, 'seo_title')->textInput() ?>

    <?= $form->field($model, 'seo_keywords')->textInput() ?>

    <?= $form->field($model, 'seo_contents')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'top_ok')->dropDownList(Article::getArrayRecommend());?>

    <?= $form->field($model, 'status')->dropDownList(\backend\models\Article::getArrayStatus()) ?>

 	<?php
    //外部TAG
    echo Html::tag('script', $model->content, [
       'id' => Html::getInputId($model, 'content'),
       'name' => Html::getInputName($model, 'content'),
       'type' => 'text/plain',
    ]);
    echo Ueditor::widget([
        'model' => $model,
        'attribute' => 'content',
        'renderTag' => false,
        'jsOptions' => [
            'serverUrl' => yii\helpers\Url::to(['upload']),
            'autoHeightEnable' => true,
            'autoFloatEnable' => true
        ],
    ]);
    ?> 

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', '创建') : Yii::t('app', '更新'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
