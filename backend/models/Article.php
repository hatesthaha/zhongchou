<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
use backend\models\Term;
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
	const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = -1;
    const YES_RECOMMEND = 1;
    const NO_RECOMMEND = -1;
	
    private $_statusLabel;
	private $_tuijianLabel;
	
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                //'value' => new Expression('NOW()'),
                //'value'=>$this->timeTemp(),
            ],
        ];
    }
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
            [['term_id', 'title', 'content', 'seo_title', 'seo_keywords'], 'string']
        ];
    }

    public static function getArrayStatus()
    {
        return [
            self::STATUS_ACTIVE => Yii::t('app', '已发布'),
            self::STATUS_INACTIVE => Yii::t('app', '未发布'),
            self::STATUS_DELETED => Yii::t('app', '删除'),
        ];
    }
	
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'term_id' => '文章分类',
            'title' => '标题',
            'content' => '内容',
            'seo_title' => 'SEO标题',
            'seo_keywords' => 'SEO关键词',
            'seo_contents' => 'SEO描述',
            'top_ok' => '推荐',
            'status' => '发布状态',
			'logo' => '缩略图',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }
	
    public function getStatusLabel()
    {
        if ($this->_statusLabel === null) {
            $statuses = self::getArrayStatus();
            $this->_statusLabel = $statuses[$this->status];
        }
        return $this->_statusLabel;
    }
	
    public function getTuijianLabel()
    {
        if ($this->_tuijianLabel === null) {
            $tuijians = self::getArrayRecommend();
            $this->_tuijianLabel = $tuijians[$this->top_ok];
        }
        return $this->_tuijianLabel;
    }
	
    public function getCategory()
    {
        return $this->hasOne(Term::className(), ['id' => 'term_id']);
    }
	
    public static function getArrayCategory() 
    {
        return ArrayHelper::map(Term::find()->where(['parent_id'=>9])->all(), 'id', 'name');
    }
	//是否推荐
    public static function getArrayRecommend()
    {
    	return [self::NO_RECOMMEND=>'否',self::YES_RECOMMEND=>'是'];
    }
}
