<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Product;
use backend\models\ProductSearch;
use backend\models\ProductRedu;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\InvoiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '已完成产品收支统计';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invoice-index">
   <p class="btn btn-success">
   <span >总计 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;总筹得：</span>
   &nbsp;<?= $zongchoude ?>元
   <span>&nbsp;&nbsp;&nbsp;&nbsp;总支出：&nbsp;</span>
   <?= $zongzhichu ?>元<span>&nbsp;&nbsp;&nbsp;&nbsp;总收入：&nbsp;
   </span><?= $zongshouru ?>元</p>&nbsp;&nbsp;&nbsp;
   <?php if(!empty($nowterm)){ ?>
   <p class="btn btn-success">
   <span >&nbsp;&nbsp;&nbsp;栏目总计 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
   <span ><?= $nowterm['name'] ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;总筹得：</span>
   &nbsp;<?= isset($tzongchoude)?$tzongchoude:0 ?>元
   <span>&nbsp;&nbsp;&nbsp;&nbsp;总支出：&nbsp;</span>
   <?= isset($tzongzhichu)?$tzongzhichu:0 ?>元<span>&nbsp;&nbsp;&nbsp;&nbsp;总收入：&nbsp;
   </span><?= isset($tzongshouru)?$tzongshouru:0 ?>元</p>
   <?php } ?>
   
   
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            [
                'label'=>'项目名称（点击可查看详情）',
                 'attribute' => 'name',
                'format'=>'raw',
                'value' => function($model){
                    $url = $model->pro_href;
                    return Html::a($model->name, $url, ['title' => '查看','target' => '_blank']);
                }
            ] ,
				[
				 'attribute' => 'term_id',
                 'format' => 'raw',
				
                'value'=>function ($model) {
					$tid = $model->getArrayTermall();
                    return empty($tid[$model->term_id])?'未设置':$tid[$model->term_id];
                },
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'term_id', 
                    ProductRedu::getArrayTerm(),
                    ['class' => 'form-control', 'prompt' => '请筛选']
                )
            ] ,
            [
                'attribute' => 'total_money',
                'value'=>function ($model) {
                    if($model->total_money)
                        return $model->total_money."元";
                    else
                        return '0元';
                }
            ],
            ['class' => 'yii\grid\ActionColumn',
                'header'=>'支出金额',
                'template' => '{zhichu_money}',
                'headerOptions' => ['width' => '110'],
                'buttons' => [
                        'zhichu_money'=>function ($url, $model, $key) {
                            return Html::activeInput('text', $model, 'zhichu_money',['class'=>'zhichu_money','style'=>['width'=>'50px;','text-align'=>'center;'],'data-url'=>$url,'data-key'=>$key]);
                        },
                ]
            ],
            [
                'attribute' => 'target_money',
                'label' => '筹得金额',
                'value' =>function ($model) {
                    if($model->target_money)
                        return $model->target_money."元";
                    else
                        return '0元';                    
                }
            ],  
            [
                'attribute' => 'zhichu_money',
                'label' => '支出金额',
                'value' =>function ($model) {
                    if($model->zhichu_money)
                        return $model->zhichu_money."元";
                    else
                        return '0元';                    
                }
            ], 
             [
                'attribute' => 'shouru_money',
                'label' => '收入金额',
                'value' =>function ($model) {
                    if($model->shouru_money !== null)
                        return $model->shouru_money."元";
                    else
                        return '未结算';                    
                }
            ],        
            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:Y-m-d']
            ],
        ],
    ]); ?>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('.zhichu_money').change(function(){
            bootbox.dialog({
                    message:'请耐心等待，处理中......'
                });
            var url = $(this).attr('data-url');
            var val = $(this).val();
        $.post(
                url,
                {'zhichu_money':val}, 
                function(data)
                {
                   if(data==2){
                    alert('保存失败，请重试！');
                   }
                   location.reload();
                }
                ).error(function() { bootbox.hideAll(); alert("没有权限");  });
            });
    });
</script>
