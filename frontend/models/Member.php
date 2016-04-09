<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "member".
 *
 * @property integer $id
 * @property string $name
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $phone
 * @property string $cardid
 * @property string $head
 * @property string $autograph
 * @property integer $sign
 * @property string $level
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $gender
 * @property string $email
 * @property string $signature
 * @property string $address
 * @property integer $product_id
 * @property integer $prestige
 * @property string $tmoney
 * @property string $search_record
 * @property string $seen
 */
class Member extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'member';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sign', 'created_at', 'updated_at', 'gender', 'product_id', 'prestige'], 'integer'],
            [['search_record', 'seen'], 'string'],
            [['name', 'auth_key', 'password_hash', 'password_reset_token', 'head', 'autograph', 'level', 'email', 'signature', 'address', 'tmoney'], 'string', 'max' => 255],
            [['phone', 'cardid'], 'string', 'max' => 64]
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
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'phone' => 'Phone',
            'cardid' => 'Cardid',
            'head' => 'Head',
            'autograph' => 'Autograph',
            'sign' => 'Sign',
            'level' => 'Level',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'gender' => 'Gender',
            'email' => 'Email',
            'signature' => 'Signature',
            'address' => 'Address',
            'product_id' => 'Product ID',
            'prestige' => 'Prestige',
            'tmoney' => 'Tmoney',
            'search_record' => 'Search Record',
            'seen' => 'Seen',
        ];
    }
}
