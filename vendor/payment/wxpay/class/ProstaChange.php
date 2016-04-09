<?php
use wanhunet\wanhunet;
use frontend\models\Member;
use frontend\models\Money;
use frontend\models\Product;
use frontend\models\Invoice;

use frontend\models\Lucky;
use backend\models\Mubannews;
use yii\web\Controller;
use wanhunet\alipay\AlipayPay;
use wanhunet\alipay\lib\AlipaySubmit;
use wanhunet\alipay\Aliconfig;
use wanhunet\alipay\lib\AlipayNotify;
use wanhunet\alipay\lib\AlipayCore;
use yii\db\Query ;
use yii\helpers\Url;
use frontend\controllers\WeixinController;
/**
* Money 表支付完成后 ，触发Product表的变化
*
*/
class ProstaChange extends WeixinController
{
	
	function __construct($out_trade_no)
	{
		$this->statuschange($out_trade_no);
	}
	private function statuschange($out_trade_no){
		  $time = time();
		  $order = Money::find()->where(['order_num' => $out_trade_no])->one();
            $product = Product::find()->where(['id' => $order['cid']])->one();
            $pid = $order['cid'];
            $userinfo = Member::find()->where(['id'=>$order['uid']])->one();
			
			
			
			
			
			
            $jine = $order['money'];
            $term = array(2,3,4,5,6,7);
            $welfare = array(7);
            $mpro = array(2,3,4,5,6);
            //对应的项目total_money数额增加(所有)
            $ed_total = $product['total_money'];
            $now_total = $ed_total + $jine;
            Product::updateAll(['total_money'=>$now_total, '`s_num`'=>$product['s_num']+1, 'xiugaitime'=> time() ], ['id'=>$order['cid']]);
            //增加声望(公益梦)
            if (in_array($product['term_id'], $welfare)){
                $ed_prestige = $userinfo['prestige'];
                $now_prestige = $ed_prestige + $jine*10;
                Member::updateAll(['prestige'=>$now_prestige], ['id'=>$order['uid']]);
                // $finds = Product::find()->where(['id' => $pid])->one();
                // if($finds['total_money'] >= $finds['target_money']||time()>=$finds['end_time']){
                    // Product::updateAll(['end_time'=>$now_time,'status'=>1],['id'=>$pid]);
                // }
				
				//模板消息first
				// $data['first'] = "您成功支付购买声望值订单【".$product['name']."】";
				// $data['Remark'] = "感谢您的热心参与，您购买了 $jine 点声望值，有问题请进入个人中心查看常见问题和操作指南";
            }

            //增加发布项目金额的上限(普通项目)
            if (in_array($product['term_id'], [2,3,4,5,6])){
				//模板消息first
				//$data['first'] = "您成功支付众筹项目【".$product['name']."】";

                $ed_ceiling = $userinfo['ceiling'];//10
                $tmoney = $userinfo['tmoney'];
                $ed_day = $userinfo['day'];//16864
                $new_jine = $jine * 10;//10
                $now_ceiling = $ed_ceiling + $new_jine;//20
                $now_time_d = floor(time()/86400);//16864
                if($ed_day == $now_time_d){
                    if($ed_ceiling < 1000){
                        if($now_ceiling <= 1000){
                            Member::updateAll(['ceiling'=>$now_ceiling,'tmoney'=>$tmoney + $new_jine],['id'=>$order['uid']]);
							
							//模板消息	
							//$data['Remark'] = "感谢您的热心参与，您的发起权限增长至". $tmoney + 1000 - $ed_ceiling . "，有问题请进入个人中心查看常见问题和操作指南";
							
                        }elseif($now_ceiling >1000){
                            Member::updateAll(['ceiling'=>'1000','tmoney'=>$tmoney + 1000 - $ed_ceiling],['id'=>$order['uid']]);
							
							
							//模板消息	
							//$data['Remark'] = "感谢您的热心参与，您的发起权限增长至". $tmoney + 1000 - $ed_ceiling . "，有问题请进入个人中心查看常见问题和操作指南";
                        }
                    }
                }else{
                    if($new_jine < 1000){
                        Member::updateAll(['tmoney'=>$userinfo['tmoney'] + $new_jine,'ceiling'=>$new_jine,'day'=>$now_time_d],['id'=>$order['uid']]);
						
						
					//模板消息	
					//$data['Remark'] = "感谢您的热心参与，您的发起权限增长至". $userinfo['tmoney'] + $new_jine . "，有问题请进入个人中心查看常见问题和操作指南";
					
                    }elseif($jine >= 1000){
                        Member::updateAll(['tmoney'=>$userinfo['tmoney'] + 1000,'ceiling'=>'1000','day'=>$now_time_d],['id'=>$order['uid']]);
						
						
						//模板消息
						//$data['Remark'] = "感谢您的热心参与，您的发起权限增长至". $userinfo['tmoney'] + 1000 . "，有问题请进入个人中心查看常见问题和操作指南";
						
                    }
                    
                }
				
				
                $finds = Product::find()->where(['id' => $pid])->one();
				
				
				//模板消息first
				//$data['first'] = "您成功支付众筹项目【".$product['name']."】";
				
				
                if($finds['total_money'] >= $finds['target_money']){
                    Product::updateAll(['end_time'=>time(),'status'=>1],['id'=>$pid]);
	
                    Invoice::updateAll(['status'=>0],['pid'=>$pid]);
                    $connection = \Yii::$app->db;
                          //栏目对应的周期天数
                    $term_arr = [
                       '2'=>1,
                       '3'=>3,
                       '4'=>5,
                       '5'=>7,
                       '6'=>9,
                    ];
                    $term_id=$finds->term_id;
                    //天数为进一取整，当前周期为向下取整
                    $now_zhouqi = floor(ceil(time()/86400)/$term_arr[$term_id]);
                    //首先上线已排序的产品
                    $command = $connection->createCommand(sprintf('UPDATE `product` SET `status`=%u,`sorted_at`=%u ,`updated_at`=%u  WHERE `term_id`=%u AND `shenhe`=1 AND `status`=0 AND `sorted_at`>0 ORDER BY `sorted_at` ASC,`sorted_at` ASC LIMIT 1',2,0,$now_zhouqi,$term_id));
                    //判断是否上线成功
                    $isshangxian = $command->execute();
                    //如果没有上线成功
                    if($isshangxian==0){
                        //检查此栏目下是否有未排序产品
                        $command = $connection->createCommand(sprintf('SELECT `product`.`id` FROM `product` LEFT JOIN `member` ON `product`.`user_id`=`member`.`id`  WHERE `product`.`term_id`=%u AND `product`.`shenhe`=1 AND `product`.`status`=0 AND `product`.`sorted_at`=0 ORDER BY `member`.`prestige` DESC LIMIT 0,1',$term_id));
                        $res1 = $command->queryOne();
                        if($res1){
                            $command = $connection->createCommand(sprintf('UPDATE `product` SET `status`=2,`sorted_at`=0,`updated_at`=%u WHERE `id`=%u  AND `shenhe`=1',$now_zhouqi,$res1['id']));
                            $command->execute();
                        }
                        //上线完成后。对所有产品进行排序，sorted_at=updated_at+1；
                        // $command = $connection->createCommand(sprintf('SELECT `product`.* FROM `product` LEFT JOIN `member` ON `product`.`user_id`=`member`.`id`  WHERE `product`.`term_id`=%u AND `product`.`shenhe`=1 AND `product`.`sorted_at`=0 AND `product`.`status`=0 AND `product`.`updated_at`<%u ORDER BY `product`.`updated_at` ASC,`member`.`prestige` DESC',$term_id,$now_zhouqi));
                        // $res2 = $command->queryAll();
                        // if($res2){
                        //     foreach ($res2 as $key => $pro) {
                        //         $command = $connection->createCommand(sprintf('UPDATE `product` SET `sorted_at`=`updated_at`+1,`updated_at`=%u,`sort`=%u WHERE `id`=%u  AND `shenhe`=1 AND `status`=0' ,$now_zhouqi,$key+1,$pro['id']));
                        //         $command->execute();
                        //     }
                        // }

                    }
                }

            }

            //一元众筹发送随机码(一元众筹)
            if (!in_array($product['term_id'], $term)){
                $oid = $order['order_num'];
                $jine = $order['money'];
                $pid = $order['cid'];
				//模板消息first
				// $data['first'] = "您已成功支付一元众筹项目【".$product['name']."】";
				// $data['Remark'] = "感谢您参与一元众筹，有问题请进入个人中心查看常见问题和操作指南，祝您好运哦！";
                if($product['total_money'] < $product['target_money']){
                    if(empty($product['lucky_num'])){
                        for ($i=0; $i < $jine; $i++) {
                            $data = 10000001 + $i;
                            $model = new Lucky();
                            $model->cid = $pid;
                            $model->uid = $order['uid'];
                            $model->lucky_num = $data;
                            $model->insert();
                        }
                        Product::updateAll(['lucky_num'=>$data],['id'=>$pid]);
                    }else{
                        $k = $product['lucky_num'] + 1;
                        for ($i=0; $i < $jine; $i++) {
                            $data = $k + $i;
                            $model = new Lucky();
                            $model->cid = $pid;
                            $model->uid = $order['uid'];
                            $model->lucky_num = $data;
                            $model->insert();
                        }
                        Product::updateAll(['lucky_num'=>$data],['id'=>$pid]);
                    }
                }
                $finds = Product::find()->where(['id' => $pid])->one();
                if($finds['total_money'] >= $finds['target_money'] && empty($finds['end_time'])){
                    $now_time = time() + 300;
                    Product::updateAll(['end_time'=>$now_time],['id'=>$pid]);
                }
            }
			
			$data = [];
			$mubannews = Mubannews::find()->where('name=:name', [':name'=> "订单支付成功"])->asArray()->one();
			if (!empty($mubannews)) {
				
				//发送客服消息--模板消息
				$data['template_id'] = $mubannews['template_id'];
				$data['touser'] = $userinfo['openid'];
				$data['url'] = "http://bingbingzm.com/order/myorder";
				if (empty($mubannews['first'])) {
					$data['first']['value'] = "您的订单【". (empty($product['name']) ? "未设置" : $product['name']) ."】支付成功";
				} else {
					$data['first']['value'] = sprintf($mubannews['first'], $product['name']);
				}
				
				$data[1]['key'] = 'orderMoneySum';
				$data[2]['key'] = 'orderProductName';
				
				$data[1]['value'] = $order['money']."元";
				$data[2]['value'] = "时间:".date('Y-m-d H:i:s', time());
				
				$data['Remark']['value'] = empty($mubannews['Remark']) ? "订单支付成功通知" : $mubannews['Remark'] ;
				 if (in_array($product['term_id'], $welfare)){
					 
					$now_prestige = $ed_prestige + $jine*10;
					$data['Remark']['value'] = empty($mubannews['Remark']) ? ("购买声望值成功：购买点数为 ". $jine*10 ."  当前声望为 ".$now_prestige ) : $mubannews['Remark'] ;
				}
				
				$this->sendMobanmes($data);
			}
			
			//发送客服消息--模板消息
			// $this->sendMobanmes($data);
	}
}
