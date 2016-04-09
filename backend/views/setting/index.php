<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Setting;
Use yii\helpers\Url;
use kartik\file\FileInput;

$this->title = Yii::t('app', 'Settings');
$this->params['breadcrumbs'][] = $this->title;

$items = [];
foreach($settingParent as $parent)
{
    $item['label'] = Yii::t('app', $parent->code);

    $str = '';

    $children = Setting::find()->where(['parent_id' => $parent->id])->orderBy(['sort_order' => SORT_ASC, 'id' => SORT_ASC])->all();

    foreach($children as $child)
    {

        $str .= '<div class="form-group field-blogcatalog-parent_id"><label class="col-lg-2 control-label" for="blogcatalog-parent_id">' . Yii::t('app', $child->code) . '</label><div class="col-lg-3">';

        if($child->type == 'text')
            $str .= Html::textInput("Setting[$child->code]", $child->value, ["class" => "form-control"]);
        elseif($child->type == 'password')
            $str .= Html::passwordInput("Setting[$child->code]", $child->value, ["class" => "form-control"]);
        elseif($child->type == 'select') {
            $options = [];
            $arrayOptions = explode(',', $child->store_range);
            foreach($arrayOptions as $option)
                $options[$option] = Yii::t('app', $option);
            $str .= Html::dropDownList("Setting[$child->code]", $child->value, $options, ["class" => "form-control"]);
        }elseif($child->type == 'textarea'){
			$str .= Html::textarea("Setting[$child->code]", $child->value, ["class" => "form-control" , 'rows'=>6]);
        }elseif($child->type == 'input'){
        	$siteRoot = yii::$app->homeUrl.'upload/';
            $str .= '<input type="file" name="Setting[img]" value="'.$child->value.'"/>'.'<img style="width:100px;height:100px" src="'. $siteRoot.$child->value.'""/>';
        }

        $str .= '</div></div>';
    }

    $item['content'] = $str;

    array_push($items, $item);
}

?>

<style>
.tab-pane {padding-top: 20px;}
</style>

<div class="setting-form">
    <?php $form = ActiveForm::begin([
        'id' => 'setting-form',
        'options' => ['class' => 'form-horizontal','enctype' => 'multipart/form-data'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}{hint}</div>\n<div class=\"col-lg-5\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-2 control-label'],
        ],
    ]); ?>

    <?php
    echo \yii\bootstrap\Tabs::widget([
        'items' => $items,
        'options' => ['tag' => 'div'],
        'itemOptions' => ['tag' => 'div'],
        'headerOptions' => ['class' => 'my-class'],
        'clientOptions' => ['collapsible' => false],
    ]);
    ?>

    <div class="form-group">
        <label class="col-lg-2 control-label" for="">&nbsp;</label>
        <?= Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
