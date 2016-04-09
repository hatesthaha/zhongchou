<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "signed".
 *
 * @property string $id
 * @property integer $user_id
 * @property string $day_array
 */
class Signed extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'signed';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['day_array'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'day_array' => 'Day Array',
        ];
    }
}
