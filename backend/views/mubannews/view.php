<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Mubannews */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Mubannews', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mubannews-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
<?= Html::a('返回', ['index'], ['class' => 'btn btn-primary']) ?>
        <!--<?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>-->
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'template_id',
            'name',
            'first:ntext',
			
            'remark:ntext',
            'key1:ntext',
            'key2:ntext',
            'key3:ntext',
            'key4:ntext',
        ],
    ]) ?>

</div>
