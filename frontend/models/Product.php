<?php

namespace frontend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property string $name
 * @property string $content
 * @property string $img
 * @property string $c_img
 * @property integer $h_num
 * @property integer $s_num
 * @property double $total_money
 * @property double $target_money
 * @property integer $top_ok
 * @property integer $status
 * @property integer $r_day
 * @property integer $pay
 * @property integer $created_at
 * @property integer $updated_at
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['h_num', 's_num', 'top_ok', 'status', 'r_day', 'pay', 'created_at', 'updated_at'], 'integer'],
            [['total_money', 'target_money'], 'number'],
            [['name', 'content', 'img', 'c_img'], 'string', 'max' => 255]
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                //'value' => new Expression('NOW()'),
                //'value'=>$this->timeTemp(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'content' => 'Content',
            'img' => 'Img',
            'c_img' => 'C Img',
            'h_num' => 'H Num',
            's_num' => 'S Num',
            'total_money' => 'Total Money',
            'target_money' => 'Target Money',
            'top_ok' => 'Top Ok',
            'status' => 'Status',
            'r_day' => 'R Day',
            'pay' => 'Pay',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
