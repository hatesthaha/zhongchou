<?php

namespace backend\models;

use Yii;
use backend\models\Product;
use backend\models\Member;

/**
 * This is the model class for table "money".
 *
 * @property integer $id
 * @property integer $uid
 * @property integer $cid
 * @property string $info
 * @property double $money
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $order_at
 * @property integer $pay_at
 * @property integer $deliver_at
 * @property integer $over_at
 * @property string $order_num
 * @property integer $status
 * @property string $lucky
 * @property string $trade_no
 * @property string $payway
 */
class Order extends \yii\db\ActiveRecord
{
	
	const Order_STATUS_0 = 0;
	const Order_STATUS_1 = 1;

	private $_statusLabel;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'money';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'cid', 'created_at', 'updated_at', 'order_at', 'pay_at', 'deliver_at', 'over_at', 'status'], 'integer'],
            [['info', 'phone', 'name', 'address', 'payway'], 'string'],
            [['money'], 'number'],
            [['trade_no', 'payway'], 'required'],
            [['order_num'], 'string', 'max' => 10],
            [['trade_no'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => '用户名',
            'cid' => '项目名',
            'info' => '备注',
            'money' => '金额',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'order_at' => 'Order At',
            'pay_at' => '支付时间',
            'deliver_at' => '发货时间',
            'over_at' => '收货时间',
            'order_num' => '订单号',
            'status' => '状态',
            'name' => 'name',
	    'address' => '收获地址',
	    'phone' => '手机号',
            'trade_no' => '支付单号',
            'payway' => '支付方式',
        ];
    }
	
	public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'cid']);
    }
	
	public function getMember()
    {
        return $this->hasOne(Member::className(), ['id' => 'uid']);
    }
	
    public static function getArrayStatus()
    {
        return [
            self::Order_STATUS_0 => Yii::t('app', '未付款'),
            self::Order_STATUS_1 => Yii::t('app', '已付款'),
        ];
    }
    public function getStatusLabel()
    {
        if ($this->_statusLabel === null) {
            $statuses = self::getArrayStatus();
            $this->_statusLabel = $statuses[$this->status];
        }
        return $this->_statusLabel;
    }
}
