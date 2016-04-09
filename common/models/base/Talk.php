<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "talk".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $img
 * @property integer $hit_num
 * @property integer $created_at
 * @property integer $updated_at
 */
class Talk extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'talk';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hit_num', 'created_at', 'updated_at'], 'integer'],
            [['title', 'content', 'img'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'content' => Yii::t('app', 'Content'),
            'img' => Yii::t('app', 'Img'),
            'hit_num' => Yii::t('app', 'Hit Num'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}
