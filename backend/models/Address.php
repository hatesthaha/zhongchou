<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "address".
 *
 * @property string $id
 * @property integer $userid
 * @property string $username
 * @property integer $phone
 * @property string $province
 * @property string $city
 * @property string $county
 * @property string $address
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 */
class Address extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'phone', 'created_at', 'updated_at', 'status'], 'integer'],
            [['username', 'province', 'city', 'county', 'address'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userid' => 'Userid',
            'username' => 'Username',
            'phone' => 'Phone',
            'province' => 'Province',
            'city' => 'City',
            'county' => 'County',
            'address' => 'Address',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }
}
