<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Product;
use backend\models\Member;
use backend\models\invoice;

$this->title = '仌仌众梦后台管理系统';

$num = Member::find()->count(); 
$p_num = Product::find()->where('term_id in (2,3,4,5,6) and shenhe=0')->count();    
$mt_num = Product::find()->where('term_id in (2,3,4,5,6)')->count();
$pt_num = Product::find()->where('term_id not in (2,3,4,5,6)')->count();
$d_num = Invoice::find()->where('status=2')->count();
$result = Yii::$app->db->createCommand('select sum(tmoney) as total from member');
$data = $result->queryAll();
?>
<style>
table.form {
    background: #fff none repeat scroll 0 0;
    border-left: 1px solid #ddd;
    border-top: 1px solid #ddd;
    font-size: 14px;
    width: 100%;
}
table.form th {
    background: #f5f5f5 none repeat scroll 0 0;
    border-bottom: 1px solid #ddd;
    border-right: 1px solid #ccc;
    height: 32px;
    line-height: 30px;
    text-align: center;
}
table.form td {
    border-bottom: 1px solid #ddd;
    border-right: 1px solid #ddd;
    line-height: 28px;
    padding: 5px;
}
table.form .topTd, table.form .bottomTd {
    background: rgba(0, 0, 0, 0) url("../images/bgline.gif") repeat-x scroll 0 0;
    font-size: 0;
    height: 5px;
    padding: 0;
}
table.access_list td {
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    border-color: -moz-use-text-color -moz-use-text-color #ccc;
    border-image: none;
    border-style: none none dotted;
    border-width: medium medium 1px;
    padding: 8px;
}
table.access_list td label {
    display: inline-block;
    padding: 0 10px;
}
table.access_list td.access_left {
    border-right: 1px dotted #ccc;
    text-align: right;
}
table.form .ke-container {
    border: 1px solid #ccc;
    padding: 0;
}
table.form .ke-content {
    border: 0 none;
    padding: 0;
}
table.form .ke-container td, .ke-container th {
    border: 0 none;
    padding: 0;
}
table.form .ke-bottom {
    border: 0 none;
    padding: 0;
}
table.form .ke-bottom td, table.form .ke-bottom th {
    border: 0 none;
    padding: 0;
}
</style>
<div class="site-index">
<table class="form" cellpadding=0 cellspacing=0 border=1>
		<tr>
			<td colspan=2 class="topTd"></td>
		</tr>
		<tr>
			<td class="item_title" style="width:200px;">
				当前版本			</td>
			<td class="item_input">
				系统版本:1.542 <span id="version_tip"></span>
			</td>
		</tr>
		
		<tr>
			<td class="item_title" style="width:200px;">
				当前时间			</td>
			<td class="item_input">
				<?php echo date("Y-m-d H:i:s",time()); ?>			</td>
		</tr>
		<tr>
			<td class="item_title" style="width:200px;">
				注册人数
			</td>
			<td class="item_input">
				 <a href="/member/index"><?= $num ?>个</a>
			</td>
		</tr>
		<tr>
			<td class="item_title" style="width:200px;">
				项目待审核
			</td>
			<td class="item_input">
				 <a href="/product/index"><?=$p_num?>个</a>
			</td>
		</tr>
		<tr>
			<td class="item_title" style="width:200px;">
				用户发起项目总数
			</td>
			<td class="item_input">
				  <a href="/product/index"><?=$mt_num?>个</a>
			</td>
		</tr>
		<tr>
			<td class="item_title" style="width:200px;">
				公司发起项目总数
			</td>
			<td class="item_input">
				  <a href="/yyzc/index"><?=$pt_num?>个</a>
			</td>
		</tr>
		<tr>
			<td class="item_title" style="width:200px;">
				项目完成数
			</td>
			<td class="item_input">
				 <a href="/invoice/index"><?=$d_num?>个</a>
			</td>
		</tr>
		<tr>
			<td class="item_title" style="width:200px;">
				用户投资总金额
			</td>
			<td class="item_input">
				 ￥<?=$data[0]['total']?>元
			</td>
		</tr>
 		<tr>
			<td colspan=2 class="bottomTd"></td>
		</tr>
</table>	
</div>
