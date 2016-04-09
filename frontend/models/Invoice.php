<?php

namespace frontend\models;

use Yii;
use frontend\models\Product;
use frontend\models\Member;
/**
 * This is the model class for table "invoice".
 *
 * @property integer $order_id
 * @property integer $pid
 * @property integer $uid
 * @property string $name
 * @property integer $phone
 * @property string $address
 * @property integer $status
 * @property string $invoice_no
 * @property integer $deliver_at
 * @property integer $over_at
 * @property integer $created_at
 */
class Invoice extends \yii\db\ActiveRecord
{
	 
	const STATUS_0 = 0;
	const STATUS_1 = 1;
	const STATUS_2 = 2;

	private $_statusLabel;
	 
    public static function tableName()
    {
        return 'invoice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid', 'uid', 'name', 'phone', 'address'], 'required'],
            [['pid', 'uid', 'status', 'deliver_at', 'over_at', 'created_at'], 'integer'],
            [['name','phone'], 'string', 'max' => 100],
            [['address', 'invoice_no'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => 'ID',
            'pid' => '项目名',
            'uid' => '用户名',
            'name' => '姓名',
            'phone' => '手机号',
            'address' => '地址',
            'status' => '状态',
            'invoice_no' => '物流单号',
            'deliver_at' => '发货时间',
            'over_at' => '收货时间',
            'created_at' => '添加时间',
        ];
    }
	
	public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'pid']);
    }
	
	public function getMember()
    {
        return $this->hasOne(Member::className(), ['id' => 'uid']);
    }
	
    public static function getArrayStatus()
    {
        return [
            self::STATUS_0 => Yii::t('app', '待发货'),
            self::STATUS_1 => Yii::t('app', '待收货'),
            self::STATUS_2 => Yii::t('app', '已完成'),
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
