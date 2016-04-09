<?php

namespace common\models\base;

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
            [['sign', 'created_at', 'updated_at'], 'integer'],
            [['name', 'auth_key', 'password_hash', 'password_reset_token', 'head', 'autograph', 'level'], 'string', 'max' => 255],
            [['phone', 'cardid'], 'string', 'max' => 64]
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
            'auth_key' => Yii::t('app', 'Auth Key'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'phone' => Yii::t('app', 'Phone'),
            'cardid' => Yii::t('app', 'Cardid'),
            'head' => Yii::t('app', 'Head'),
            'autograph' => Yii::t('app', 'Autograph'),
            'sign' => Yii::t('app', 'Sign'),
            'level' => Yii::t('app', 'Level'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}
