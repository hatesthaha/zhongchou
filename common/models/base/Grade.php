<?php

namespace common\models\base;

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
            'id' => Yii::t('app', 'ID'),
            'grade' => Yii::t('app', 'Grade'),
            'grade_icon' => Yii::t('app', 'Grade Icon'),
            'growth_needed' => Yii::t('app', 'Growth Needed'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}
