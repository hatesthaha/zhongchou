<?php

namespace common\models\base;

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
            'id' => Yii::t('app', 'ID'),
            'term_id' => Yii::t('app', 'Term ID'),
            'title' => Yii::t('app', 'Title'),
            'content' => Yii::t('app', 'Content'),
            'seo_title' => Yii::t('app', 'Seo Title'),
            'seo_keywords' => Yii::t('app', 'Seo Keywords'),
            'seo_contents' => Yii::t('app', 'Seo Contents'),
            'top_ok' => Yii::t('app', 'Top Ok'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}
