<?php

namespace frontend\models;
use yii\behaviors\TimestampBehavior;

use Yii;

/**
 * This is the model class for table "lucky".
 *
 * @property string $id
 * @property integer $cid
 * @property integer $uid
 * @property integer $lucky_num
 */
class Lucky extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
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
        return 'lucky';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cid', 'uid', 'lucky_num'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cid' => 'Cid',
            'uid' => 'Uid',
            'lucky_num' => 'Lucky Num',
        ];
    }
}
