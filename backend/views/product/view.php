<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


/* @var $this yii\web\View */
/* @var $model backend\models\Product */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '项目管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-view">

   <p>
	<?= Html::a('返回', ['index'], ['class' => 'btn btn-primary']) ?>
      <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '你确定要删除此项目吗？',
                'method' => 'post',
            ],
        ]) ?>
    </p>
	<p>
	<br>
			<label class="control-label">详情链接</label>：<a href="<?= $model->pro_href ?>" target="_blank"><button><?= $model->name;$model->pro_href;?></button></a>
	</p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
			[
				'attribute' => 'url',
				'lable' => '商品前台链接',
				'format' => 'html',
				'value' =>  'http://bingbingzm.com/project/projectdetails/'.$model->id,
			],
            'content',
			[
				'attribute' => 'img',
				'lable' => '产品图集',
				'value' => $model->getImgs('img'),
				'format' => 'raw',
			],
			[
				'attribute' => 'c_img',
				'lable' => '详情图集',
				'value' => $model->getImgs('c_img'),
				'format' => 'raw',
			],
/*             'h_num',
            's_num', */
			[
                'attribute' => 'total_money',
                'value' => $model->total_money.'元',
            ],
			[
                'attribute' => 'target_money',
                'value' => $model->target_money.'元',
            ],
			[
                'attribute'=>'status',
                'value'=>$model->statusLabel,
            ],
			[
                'attribute'=>'shenhe',
                'value'=>$model->shenheLabel,
            ],
            //'r_day',
            //'pay',
			[
                'attribute' => 'created_at',
                'format' =>  ['date', 'php:Y-m-d H:i:s'],
            ],
			[
                'attribute' => 'updated_at',
                'format' =>  ['date', 'php:Y-m-d H:i:s'],
            ],
            //'user_id',
            'search_num',
        ],
    ]) ?>

</div>
