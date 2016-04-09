<?php

namespace backend\models;

use Yii;
use yii\base\Model; 
use yii\behaviors\TimestampBehavior;
use backend\models\Member;
/**
 * This is the model class for table "member".
 *
 * @property integer $id
 * @property string $name
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $phone
 * @property string $cardid
 * @property string $head
 * @property string $autograph
 * @property integer $sign
 * @property string $level
 * @property double $tmoney
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $gender
 * @property string $email
 * @property string $signature
 * @property string $address
 * @property integer $product_id
 * @property integer $prestige
 * @property string $seen
 * @property string $search_record
 */
class Member extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	const SEX_BAOMI = 0;
	const SEX_NAN = 1;
	const SEX_NV = 2;
	
	public $password;
	public $repassword;
	public $message;
	private $_sexLabel;
	
    public static function tableName()
    {
        return 'member';
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
            [['sign', 'phone','created_at', 'updated_at', 'gender', 'product_id', 'prestige','day','ceiling'], 'integer'],
            [['tmoney','phone'], 'number'],
            [['seen', 'search_record'], 'string'],
            [['auth_key', 'password_hash', 'password_reset_token', 'autograph', 'level', 'signature', 'address'], 'string', 'max' => 255],
            [['cardid'], 'string', 'max' => 64],
			[['head'], 'file', 'extensions'=>'jpg,png,gif,jpeg'],
			// E-mail
            ['email', 'string', 'max' => 100],
			['message', 'string', 'max' => 200],
            ['email', 'email'],
			['name', 'string', 'min' => 1, 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '用户名',
            'auth_key' => 'Auth Key',
            'password_hash' => '密码',
            'password_reset_token' => 'Password Reset Token',
            'phone' => '手机号',
            'cardid' => '身份证',
            'head' => '头像',
            'autograph' => 'Autograph',
            'sign' => '签到时间',
            'level' => '等级',
            'tmoney' => '投资总金额',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'gender' => '性别',
            'email' => '邮箱',
            'signature' => '个性签名',
            'address' => '地址',
            'product_id' => '项目ID',
            'prestige' => '声望值',
            'seen' => '项目ID',
            'search_record' => 'Search Record',
			'repassword' => '确认密码',
			'day' => '上线时间',
			'message' => '即时消息',
			'ceiling' => 'ceiling',
        ];
    }

	
     public static function getArraySex()
    {
        return [
            self::SEX_BAOMI => Yii::t('app', '保密'),
            self::SEX_NAN => Yii::t('app', '男'),
			self::SEX_NV => Yii::t('app', '女'),
        ];
    }
    public function getSexLabel()
    {
        if ($this->_sexLabel === null) {
            $SexLabel = self::getArraySex();
            $this->_sexLabel = $SexLabel[$this->gender];
        }
        return $this->_sexLabel;
    }
	
}
