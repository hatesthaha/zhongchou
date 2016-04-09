<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "ticket".
 *
 * @property integer $id
 * @property string $jsapi_ticket
 * @property string $expire_time
 * @property string $add_time
 */
class Ticket extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ticket';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['jsapi_ticket', 'expire_time', 'add_time'], 'required'],
            [['jsapi_ticket'], 'string'],
            [['expire_time', 'add_time'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'jsapi_ticket' => 'Jsapi Ticket',
            'expire_time' => 'Expire Time',
            'add_time' => 'Add Time',
        ];
    }
}
