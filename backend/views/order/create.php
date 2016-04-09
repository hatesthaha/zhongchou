<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Money */

$this->title = 'Create Money';
$this->params['breadcrumbs'][] = ['label' => 'Moneys', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="money-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
