<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "level".
 *
 * @property string $id
 * @property string $pic
 * @property integer $grade
 */
class Level extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'level';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['grade'], 'integer'],
            [['pic'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pic' => 'Pic',
            'grade' => 'Grade',
        ];
    }
}
