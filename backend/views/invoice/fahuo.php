<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Money */

$this->title = $model->product->name;
$this->params['breadcrumbs'][] = ['label' => '支付管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="content1">
    <div id="warning"></div>
    <form method="post" action="/invoice/fahuo/<?=$id?>">
    <div style="font-size:14px;margin-bottom:5px;">请输入您的物流单号</div>
    <dl>
        <dt>物流单号:</dt>
        <dd>
		<input class="text" name="Invoice[invoice_no]" style="width:195px;" type="text">
		</dd>
		<dt>物流公司:</dt>
        <dd>
		<input class="text" name="Invoice[wuliu]" style="width:195px;" type="text">
		</dd>
    </dl>
    <div class="btn">
        <input class="btn1" value="确认" type="submit">
        <input class="btn2" value="取消" type="button">
    </div></form>
</div>