<?php

namespace backend\models;

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
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'img' => 'Img',
            'hit_num' => 'Hit Num',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
