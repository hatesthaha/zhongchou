<?php

namespace backend\models;

use Yii;
use yii\base\Model; 
use yii\behaviors\TimestampBehavior;
use backend\models\Slider;
/**
 * This is the model class for table "slider".
 *
 * @property integer $id
 * @property string $name
 * @property string $banner
 * @property string $link
 * @property string $content
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Slider extends \yii\db\ActiveRecord
{
	
	const STATUS_DELETED = -1;

    CONST STATUS_SUCCESS = 1;
	
	private $_statusLabel;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'slider';
    }
	
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
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['status', 'created_at', 'updated_at', 'listorder'], 'integer'],
            [['name', 'banner', 'link'], 'string', 'max' => 255],
			[['banner'], 'file', 'extensions'=>'jpg,png,gif,jpeg']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '图片标题',
            'banner' => '图片Banner',
            'link' => '图片链接',
            'content' => '图片简介',
            'status' => '状态',
            'listorder' => '排序(数字越大越靠前)',
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
    /**
     * @inheritdoc
     */
    public static function getArrayStatus()
    {
        return [
            self::STATUS_SUCCESS => Yii::t('app', '启用'),
            self::STATUS_DELETED => Yii::t('app', '不启用'),
        ];
    }
}
