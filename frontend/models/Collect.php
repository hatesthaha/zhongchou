<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "collect".
 *
 * @property integer $id
 * @property integer $goods_id
 * @property integer $user_id
 * @property integer $created_at
 */
class Collect extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'collect';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_id', 'user_id', 'created_at'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'goods_id' => 'Goods ID',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
        ];
    }
}
