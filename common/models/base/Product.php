<?php

namespace common\models\base;

use Yii;

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

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'content' => Yii::t('app', 'Content'),
            'img' => Yii::t('app', 'Img'),
            'c_img' => Yii::t('app', 'C Img'),
            'h_num' => Yii::t('app', 'H Num'),
            's_num' => Yii::t('app', 'S Num'),
            'total_money' => Yii::t('app', 'Total Money'),
            'target_money' => Yii::t('app', 'Target Money'),
            'top_ok' => Yii::t('app', 'Top Ok'),
            'status' => Yii::t('app', 'Status'),
            'r_day' => Yii::t('app', 'R Day'),
            'pay' => Yii::t('app', 'Pay'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}
