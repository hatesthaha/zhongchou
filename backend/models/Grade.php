<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "grade".
 *
 * @property integer $id
 * @property string $grade
 * @property integer $grade_icon
 * @property string $growth_needed
 * @property integer $created_at
 * @property integer $updated_at
 */
class Grade extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'grade';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['grade_icon', 'created_at', 'updated_at'], 'integer'],
            [['grade', 'growth_needed'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'grade' => 'Grade',
            'grade_icon' => 'Grade Icon',
            'growth_needed' => 'Growth Needed',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
