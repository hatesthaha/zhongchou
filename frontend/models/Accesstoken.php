<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "accesstoken".
 *
 * @property integer $id
 * @property string $access_token
 * @property string $expire_time
 * @property string $add_time
 */
class Accesstoken extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'accesstoken';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['access_token', 'expire_time', 'add_time'], 'required'],
            [['access_token'], 'string'],
            [['expire_time', 'add_time'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'access_token' => 'Access Token',
            'expire_time' => 'Expire Time',
            'add_time' => 'Add Time',
        ];
    }
}
