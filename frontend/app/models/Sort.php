<?php

namespace frontend\app\models;

use Yii;

/**
 * This is the model class for table "sort".
 *
 * @property integer $pid
 * @property integer $uid
 * @property integer $sort
 * @property integer $sorted_at
 * @property integer $term_id
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Sort extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sort';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid', 'uid', 'term_id'], 'required'],
            [['pid', 'uid', 'sort', 'sorted_at', 'term_id', 'status', 'created_at', 'updated_at'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pid' => 'Pid',
            'uid' => 'Uid',
            'sort' => 'Sort',
            'sorted_at' => 'Sorted At',
            'term_id' => 'Term ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
