<?php

namespace backend\models;

use Yii;
use yii\base\Model; 
use yii\behaviors\TimestampBehavior;
use backend\models\Term;
/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property string $name
 * @property string $content
 * @property string $img
 * @property string $c_img
 * @property integer $h_num
 * @property integer $s_num
 * @property double $total_money
 * @property double $target_money
 * @property integer $top_ok
 * @property integer $status
 * @property integer $r_day
 * @property integer $pay
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $user_id
 * @property integer $end_time
 * @property integer $search_num
 */
class Yyzc extends \yii\db\ActiveRecord
{

    const YES_RECOMMEND = 1;
    const NO_RECOMMEND = -1;
	
	const STATUS_DELETED = -1;
	const STATUS_NSTARTED = 0;
	const STATUS_INACTIVE = 2;
	const STATUS_COMPLETE = 1;
	
    private $_statusLabel;
	private $_timg;
	
    /**
     * @inheritdoc
     */
    public static function tableName()    {
        return 'product';
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
            [['h_num', 's_num', 'top_ok', 'status', 'r_day', 'pay', 'created_at', 'updated_at', 'user_id', 
			'end_time', 'search_num', 'shenhe'], 'integer'],
			//[['end_time'], 'integer', 'min'=>time()],
			[['term_id'], 'integer'],
			[['term_id'], 'match', 'pattern'=>'/[1-9]+/', 'message'=>"请选择所属栏目"],
            [['total_money', 'target_money'], 'number'],
			[['target_money'], 'required'],
            [['name'], 'string',],
			[['name'], 'required'],
			[['content'], 'string'],
			[['img'], 'file','maxFiles' => 4,'extensions'=>'jpg,png,gif,jpeg'],
			[['c_img'], 'file', 'extensions'=>'jpg,png,gif,jpeg']
        ];
    }
	
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '项目名称',
            'content' => '内容',
            'img' => '封面图',
            'c_img' => '内容图',
            'h_num' => '关注数',
            's_num' => '支持数',
            'total_money' => '已筹金额',
            'target_money' => '目标金额',
            'top_ok' => '是否推荐',
            'status' => '状态',
            'r_day' => '剩余天数',
            'pay' => '排序',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'user_id' => '用户ID',
            'end_time' => '项目完成时间',
            'search_num' => '查询数量',
			'shenhe' => '是否审核',
			'term_id' => '所属栏目',
        ];
    }
	
	
	
	public static function getArrayTerm()
    {
		$terms = Term::find('name,id')->where('parent_id =8 or id=7')->all();
		$reterm = [];
		foreach ($terms as $t) {
			$reterm[$t['id']] = Yii::t('app', $t['name']);
		}
        return $reterm;
    }
	
    public static function getArrayStatus()
    {
        return [
            self::STATUS_NSTARTED => Yii::t('app', '尚未开始'),
            self::STATUS_INACTIVE => Yii::t('app', '进行中'),
			self::STATUS_COMPLETE => Yii::t('app', '已结束'),
			self::STATUS_DELETED  => Yii::t('app', '删除'),
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
/*     public function getShowimg()
    {
		$img = explode(',',$this->c_img);
		foreach($img as $k => $v)
			$this->_timg .="<img src='"<?= Yii::getAlias('@web') . '/' ?>"upload/$v'/>";
        echo $this->_timg;
    } */
	//是否推荐
    public static function getArrayRecommend()
    {
    	return [self::NO_RECOMMEND=>'否',self::YES_RECOMMEND=>'是'];
    }
	
}
