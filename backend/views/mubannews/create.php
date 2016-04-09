<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Mubannews */

$this->title = '添加模板消息';
$this->params['breadcrumbs'][] = ['label' => '模板列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mubannews-create">
<?= Html::a('返回', ['index'], ['class' => 'btn btn-primary']) ?>
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
