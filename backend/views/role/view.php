<?php

use yii\helpers\Html;
use kartik\icons\Icon;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use backend\models\Auth;
$this->title = Yii::t('app', 'Role') . " $model->name";
$this->params['breadcrumbs'] = [
    [
        'label' => Yii::t('app', 'Roles'),
        'url' => ['/role']
    ],
    $model->name
];

?>
<link rel="stylesheet" href="<?= Yii::getAlias('@web') . '/' ?>ztree/css/demo.css" type="text/css">
<link rel="stylesheet" href="<?= Yii::getAlias('@web') . '/' ?>ztree/css/zTreeStyle/zTreeStyle.css" type="text/css">
<script src="<?= Yii::getAlias('@web') . '/' ?>ztree/js/jquery.ztree.core-3.5.js"></script>
<script src="<?= Yii::getAlias('@web') . '/' ?>ztree/js/jquery.ztree.excheck-3.5.js"></script>
<div class="row">
    <div class="col-lg-6">

        <?php
        echo DetailView::widget([
            'model' => $model,
            //'condensed' => true,
            //'hover' => true,
            //'mode' => DetailView::MODE_VIEW,
            //'enableEditMode' => false,
            /*'panel' => [
                'heading' => Icon::show('user') . Yii::t('auth', 'Role') .
                    Html::a(Icon::show('user') . Yii::t('auth', 'Update'), ['update', 'name' => $model->name], ['class' => 'btn-success btn-sm btn-dv pull-right']),
                //'type' => DetailView::TYPE_DEFAULT,
            ],*/
            'attributes' => [
                'name',
                'description',
           ],
        ]);
        ?>
    </div>

    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?= Yii::t('app', 'Permissions'); ?>
            </div>

            <div class="panel-body">

                <div class="zTreeDemoBackground left">

                    <ul id="newtree" class="ztree"></ul>
                </div>
            </div>
        </div>
    </div>

</div>
<SCRIPT type="text/javascript">

    var setting = {

        check: {
            enable: true
        },
        data: {
            simpleData: {
                enable: true
            }
        }
    };
    var zNodes =<?= json_encode($permissions) ?>;


    $.fn.zTree.init($("#newtree"), setting, zNodes);
    var treeObj = $.fn.zTree.getZTreeObj("newtree");

    treeObj.expandAll(true);


    $.each(<?= json_encode($model->_permissions) ?>,function(name,value) {
        var selnode = treeObj.getNodesByParam("action", value, null);
        if(selnode.length != 0){treeObj.checkNode(selnode[0], true, false); }

    });



    $('#cebutton').click(function(){
        var treeObj = $.fn.zTree.getZTreeObj("newtree");
        var nodes = treeObj.getCheckedNodes(true);
        var role = new Array();
        $.each(nodes,function(n,value) {
            role.push(value.action);

        });



        $('#selrole').val(role);
        $('#roleform').submit();
    })




    //-->
</SCRIPT>
