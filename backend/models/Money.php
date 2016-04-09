<?php

namespace backend\models;

use Yii;
use backend\models\Product;

/**
 * This is the model class for table "money".
 *
 * @property integer $id
 * @property integer $uid
 * @property integer $cid
 * @property string $info
 * @property string $money
 * @property integer $created_at
 * @property integer $order_at
 * @property integer $pay_at
 * @property integer $deliver_at
 * @property integer $over_at
 * @property integer $status
 * @property string $order_num
 * @property integer $updated_at
 */
class Money extends \yii\db\ActiveRecord
{
    const ORDER_STATUS_0 = 0;
    const ORDER_STATUS_1 = 1;
    const ORDER_STATUS_2 = 2;
    const ORDER_STATUS_3 = 3;


    private $_statusLabel;


     public function relations()  
    {  
        return array(  
            'cname'=>array(self::BELONGS_TO, 'product', 'id'),  
            'uname'=>array(self::BELONGS_TO, 'member', 'id'),
        );  
    }  
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
            [[ 'created_at', 'order_at', 'pay_at', 'deliver_at', 'over_at', 'status', 'updated_at'], 'integer'],
            [['uid', 'cid','info'], 'string'],
            [['order_num'], 'required'],
            [['money'], 'string', 'max' => 255],
            [['order_num'], 'string', 'max' => 10],
            [['order_num'], 'unique']
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
            'info' => '寄语',
            'money' => '金额',
            'created_at' => '创建时间',
            'order_at' => '下单时间',
            'pay_at' => '支付时间',
            'deliver_at' => '发货时间',
            'over_at' => '收货时间',
            'status' => '状态',
            'order_num' => '订单号',
            'updated_at' => '更新时间',
        ];
    }

    public static function getArrayStatus(){
        return [
            self::ORDER_STATUS_0 =>yii::t('app','未付款'),
            self::ORDER_STATUS_1 =>yii::t('app','已付款待发货'),
            self::ORDER_STATUS_2 =>yii::t('app','已发货待收货'),
            self::ORDER_STATUS_3 =>yii::t('app','已收货订单完成'),
        ];
    }
    public  function getStatusLable(){
        if ($this->_statusLabel === null) {
            $statuses = self::getArrayStatus();
            $this->_statusLabel = $statuses[$this->status];
        }
        return $this->_statusLabel;
    }

    public function getMember(){
        return $this->hasOne(Member::className(),['id'=>'uid']);
    }
    //获取产品名称
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'cid']);
    }
}
