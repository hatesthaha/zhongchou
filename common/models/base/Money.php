<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "money".
 *
 * @property integer $id
 * @property integer $uid
 * @property integer $cid
 * @property string $info
 * @property string $money
 * @property integer $created_at
 * @property integer $updated_at
 */
class Money extends \yii\db\ActiveRecord
{
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
            [['uid', 'cid', 'created_at', 'updated_at'], 'integer'],
            [['info'], 'string'],
            [['money'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'uid' => Yii::t('app', 'Uid'),
            'cid' => Yii::t('app', 'Cid'),
            'info' => Yii::t('app', 'Info'),
            'money' => Yii::t('app', 'Money'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}
