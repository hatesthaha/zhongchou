<?php
use frontend\models\Money;
use frontend\models\Product;
require_once(Yii::getAlias('@vendor') . "/payment/wxpay/lib/WxPay.Api.php");
require_once(Yii::getAlias('@vendor') . "/payment/wxpay/lib/WxPay.Notify.php");
require_once(Yii::getAlias('@vendor') . "/payment/wxpay/lib/log.php");

require_once(Yii::getAlias('@vendor') . "/payment/wxpay/class/ProstaChange.php");
// $logHandler= new CLogFileHandler(Yii::getAlias('@vendor') . "/payment/wxpay/logs/".date('Y-m-d').'.log');
// $log = Log::Init($logHandler, 15);
class PayNotifyCallBack extends WxPayNotify
{
	//查询订单
	public function Queryorder($transaction_id)
	{
		$input = new WxPayOrderQuery();
		$input->SetTransaction_id($transaction_id);
		$result = WxPayApi::orderQuery($input);
		if(array_key_exists("return_code", $result)
			&& array_key_exists("result_code", $result)
			&& $result["return_code"] == "SUCCESS"
			&& $result["result_code"] == "SUCCESS")
		{
			return true;
		}
		return false;
	}
	
	//重写回调处理函数
	public function NotifyProcess($data, &$msg)
	{
	    $time= time();
        $money_model = Money::updateAll(['status'=>1,'trade_no'=>$data['transaction_id'],'payway'=>'wxpay','updated_at'=>time()],['order_num'=>$data['out_trade_no']]); 
	    
		
		
		
            if ($money_model) {
				new \ProstaChange($data['out_trade_no']);
                Yii::info("订单支付成功！订单号：".$data['transaction_id']);
                return true;
            } else {
                Yii::error("订单支付失败！订单号：".$data['transaction_id']);
            }
	    
		return false;
	}
}
