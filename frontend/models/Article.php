<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property string $term_id
 * @property string $title
 * @property string $content
 * @property string $seo_title
 * @property string $seo_keywords
 * @property string $seo_contents
 * @property integer $top_ok
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['seo_contents'], 'string'],
            [['top_ok', 'status', 'created_at', 'updated_at'], 'integer'],
            [['term_id', 'title', 'content', 'seo_title', 'seo_keywords'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'term_id' => 'Term ID',
            'title' => 'Title',
            'content' => 'Content',
            'seo_title' => 'Seo Title',
            'seo_keywords' => 'Seo Keywords',
            'seo_contents' => 'Seo Contents',
            'top_ok' => 'Top Ok',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
