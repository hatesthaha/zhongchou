<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Mubannews */

$this->title = '修改模板消息: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Mubannews', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="mubannews-update">
<?= Html::a('返回', ['index'], ['class' => 'btn btn-primary']) ?>
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
