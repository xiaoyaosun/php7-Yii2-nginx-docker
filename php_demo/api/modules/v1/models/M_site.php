<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "site".
 *
 * @property string $id
 * @property integer $isWork
 * @property string $last_create_time
 * @property string $last_update_time
 */
class M_wifi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'site';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['isWork'], 'integer'],
            [['last_create_time', 'last_update_time'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'isWork' => 'Is Work',
            'last_create_time' => 'Last Create Time',
            'last_update_time' => 'Last Update Time',
        ];
    }
}
