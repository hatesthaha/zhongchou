<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "jk".
 *
 * @property string $api
 * @property integer $num
 */
class Jk extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'jk';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['api', 'num'], 'required'],
            [['num'], 'integer'],
            [['api'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'api' => 'Api',
            'num' => 'Num',
        ];
    }
}
