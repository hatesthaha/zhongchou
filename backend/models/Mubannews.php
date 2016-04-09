<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "mubannews".
 *
 * @property integer $id
 * @property string $template_id
 * @property string $name
 * @property string $first
 * @property string $key1
 * @property string $key2
 * @property string $key3
 * @property string $key4
 * @property string $remark
 */
class Mubannews extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mubannews';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['template_id', 'name'], 'required'],
            [['id'], 'integer'],
            [['first', 'key1', 'key2', 'key3', 'key4', 'remark'], 'string'],
            [['template_id'], 'string', 'max' => 64],
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
            'template_id' => '模板 ID',
            'name' => '标题',
            'first' => '首行信息',
            'key1' => 'Key1',
            'key2' => 'Key2',
            'key3' => 'Key3',
            'key4' => 'Key4',
            'remark' => '详情',
        ];
    }
}
