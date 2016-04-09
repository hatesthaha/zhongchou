<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Member */

$this->title = '添加会员';
$this->params['breadcrumbs'][] = ['label' => '会员管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="member-create">


    <div class="member-form">
	<br><br><br>
	<p>发送即时消息联系用户，只有用户近期点击过自定义标签或者触发过其他微信事件才能发送成功，而且不会保存在数据库，请谨慎操作 </p>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
	<?= $form->field($model, 'message')->textArea() ?>
	<p style="color:red;">
	<?php
		
	
		if (isset($errcode) ) {
			if ($errcode == 45015) {
				echo "发送失败：<br>用户近期未触发客服回复条件，回复时间超过限制 ";
			} elseif ($errcode == 40003) {
				echo "发送失败：<br>不合法的OPENID";
			} elseif ($errcode === 0) {
				echo "发送成功";
			} else {
				echo '发送失败：其他错误';
			}
		}
	

	?>
	</p>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '发送' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
			'data'=>[
				'confirm'=>'你确定发送此内容？',
				'method'=>'post'
			],
		] ) ?>
		<?= Html::a('返回', ['index'], ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

</div>
