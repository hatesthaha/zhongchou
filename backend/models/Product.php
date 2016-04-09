<?php

namespace backend\models;

use Yii;
use yii\base\Model; 
use yii\behaviors\TimestampBehavior;
use backend\models\Term;
use yii\helpers\Html;
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
class Product extends \yii\db\ActiveRecord
{
	const SHENHE_ACTIVE = 1;
    const SHENHE_INACTIVE = 0;
	const SHENHE_JUJUE = 2;

    const YES_RECOMMEND = 1;
    const NO_RECOMMEND = -1;
	
	const STATUS_NSTARTED = 0;
	const STATUS_INACTIVE = 2;
	const STATUS_COMPLETE = 1;
	
    private $_shenheLabel;
    private $_statusLabel;
	private $_timg;

     public function relations()  
    {  
        return array(  
            'cid'=>array(self::HAS_MANY, 'money', 'cid'),  
        );  
    }  
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
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
            [['h_num', 's_num', 'top_ok', 'status', 'r_day', 'pay', 'created_at', 'updated_at', 'user_id', 'end_time', 'search_num', 'shenhe','term_id','sort','sorted_at','lucky_num'], 'integer'],
            [['total_money'], 'number','min'=>0],
			[['target_money'], 'number', 'min'=>1],
            [['name'], 'string', 'max' => 255],
			[['content', 'jujueyuanyin'], 'string'],
			[['img'], 'file', 'maxFiles' => 4,'extensions'=>'jpg,png,gif,jpeg'],
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
			'pro_href' => '参考链接',
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
            'wanchengdu' > '完成度',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'user_id' => '用户ID',
            'end_time' => '项目完成时间',
            'search_num' => '查询数量',
			'shenhe' => '是否审核',
			'term_id' => '所属栏目',
			'jujueyuanyin' => '拒绝原因',
			'url'=>'商品前台链接',
        ];
    }
    public static function getArrayShenhe()
    {
        return [
            self::SHENHE_ACTIVE => Yii::t('app', '已审核'),
            self::SHENHE_INACTIVE => Yii::t('app', '待审核'),
			self::SHENHE_JUJUE => Yii::t('app', '已拒绝'),
        ];
    }
	
	public static function getArrayTerm()
    {
		$terms = Term::find('name,id')->where('parent_id =1 and id<>8')->all();
		$reterm = [];
		foreach ($terms as $t) {
			$reterm[$t['id']] = Yii::t('app', $t['name']);
		}
        return $reterm;
    }
	
	public static function getArrayTermall()
    {
		$terms = Term::find('name,id')->where('parent_id in (1,8) and id<>8')->all();
		$reterm = [];
		foreach ($terms as $t) {
			$reterm[$t['id']] = Yii::t('app', $t['name']);
		}
        return $reterm;
    }
	
    public function getShenheLabel()
    {
        if ($this->_shenheLabel === null) {
            $shenhes = self::getArrayShenhe();
            $this->_shenheLabel = $shenhes[$this->shenhe];
        }
        return $this->_shenheLabel;
    }
	
    public static function getArrayStatus()
    {
        return [
            self::STATUS_NSTARTED => Yii::t('app', '尚未开始'),
            self::STATUS_INACTIVE => Yii::t('app', '进行中'),
			self::STATUS_COMPLETE => Yii::t('app', '已结束'),
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
	
	public  function getImgs ($img = "img")
	{
		$imgs = explode(',', $this->$img);
		$str_img = "";
		foreach ($imgs as $img) 
		{
			$str_img .=  Html::img(Yii::$app->params["fenxiangimg"].$img, ['width' => '100px']);
		}
		return $str_img;
	}
	
}
