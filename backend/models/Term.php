<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use backend\models;
use yii\base\Model;
use yii\db\ActiveRecord;
use backend\models\Article;
use backend\models\Product;

/**
 * This is the model class for table "term".
 *
 * @property integer $id
 * @property string $name
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $parent_id
 */
class Term extends \yii\db\ActiveRecord
{
	const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_DELETED = -1;
    private $_statusLabel;
    public function behaviors()
    {
    	return [
    			[
    					'class' => TimestampBehavior::className(),
    					'attributes' => [
    							ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
    							ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
    					],
    			],
    	];
    }
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'term';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'created_at', 'updated_at', 'parent_id'], 'integer'],
			[['fmoney', 'dmoney'], 'number'], 
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '栏目',
            'status' => '状态',
			'fmoney' => '起始金额',
		    'dmoney' => '金额',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'parent_id' => '父级分类',
        ];
    }
	
	
	
    public static function get($parentId = 0, $array = array(), $level = 0, $add = 2, $repeat = '　')
    {
        $strRepeat = '';
        // add some spaces or symbols for non top level categories
        if ($level>1) {
            for($j = 0; $j < $level; $j ++)
            {
                $strRepeat .= $repeat;
            }
        }

        // i feel this is useless
        if($level>0)
            $strRepeat .= '';

        $newArray = array ();
        $tempArray = array ();

        //performance is not very good here
        foreach ( ( array ) $array as $v )
        {
            if ($v['parent_id'] == $parentId)
            {
                $newArray [] = array ('id' => $v['id'], 'name' => $v['name'], 'parent_id' => $v['parent_id'], 'created_at' => $v['created_at'], 'updated_at' => $v['updated_at'], 'str_label' => $strRepeat.$v['name'],'status'=>$v['status'],'dmoney'=>$v['dmoney']);

                $tempArray = self::get ( $v['id'], $array, ($level + $add), $add, $repeat);
                if ($tempArray)
                {
                    $newArray = array_merge ( $newArray, $tempArray );
                }
            }
        }
        return $newArray;
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

            self::STATUS_ACTIVE => Yii::t('app', '正常'),
            self::STATUS_INACTIVE => Yii::t('app', '前台不显示'),
            self::STATUS_DELETED => Yii::t('app', '删除'),
        ];
    }
	
    public static function isDel($id)
    {
        if (((Article::find()->where(['term_id'=>$id])->one()) !== null) or ((Product::find()->where(['term_id'=>$id])->one()) !== null) or ((self::find()->where(['parent_id'=>$id])->one()) != null)) {
			return true;
        } else {
            return false;
        }
    }
}
