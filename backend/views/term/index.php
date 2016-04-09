<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Term;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TermSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '分类管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="term-index">
    <p>
        <a class="btn btn-success" href="/term/create">新增分类</a>    </p>

<div id="w0" class="grid-view"><div class="summary">第<b>1-<?=$num?></b>条，共<b><?=$num?></b>条数据.</div>
<table class="table table-striped table-bordered"><thead>
<tr><th>#</th><th><a href="/term/index?sort=name" data-sort="name">栏目</a></th><th><a href="/term/index?sort=status" data-sort="status">状态</a></th><th><a href="/term/index?sort=created_at" data-sort="created_at">创建时间</a></th><th><a href="/term/index?sort=updated_at" data-sort="updated_at">更新时间</a></th><th width="200">操作</th></tr>
</thead>
<tbody>

<?php foreach($data as $key => $val) : ?>

<tr data-key="<?=$val['id']?>">

<td><?=$key+1?></td>

<td><?=$val['str_label']?></td>

<td><span class="label <?php if($val['status']==1){echo 'label-success';}elseif($val['status']==0){echo 'label-warning';}elseif($val['status']==-1){echo 'label-danger';}?>"><?php if($val['status']==1){echo '正常';}elseif($val['status']==0){echo '前台不显示';}elseif($val['status']==-1){echo '删除';}?></span></td>

<td><?= date('Y-m-d', $val['created_at']); ?></td>

<td><?= date('Y-m-d', $val['updated_at']); ?></td>

<td><a href="/term/<?=$val['id']?>" title="查看">&nbsp;&nbsp;<span class="glyphicon glyphicon-eye-open" >查看</span></a>

<a href="/term/update/<?=$val['id']?>" title="修改">&nbsp;&nbsp;<span class="glyphicon glyphicon-pencil">修改</span></a>

<?php if(term::isDel($val['id'])) $data = "该栏目下有子栏目或者有内容,不能删除！"; else $data = "你确定要删除该栏目吗？"; ?>

<a href="/term/delete/<?=$val['id']?>" title="删除" data-confirm="<?=$data?>" data-method="post">&nbsp;&nbsp;<span class="glyphicon glyphicon-trash" >删除</span></a></td>

</tr>

<?php endforeach;?>

</tbody></table>
</div>
</div>
