<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_wxpay".
 *
 * @property integer $id
 * @property integer $gid
 * @property string $orderid
 * @property string $xml_data
 * @property string $ctime
 */
class LogWxpay extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_wxpay';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gid', 'orderid', 'xml_data', 'ctime'], 'required'],
            [['gid'], 'integer'],
            [['ctime'], 'safe'],
            [['orderid'], 'string', 'max' => 50],
            [['xml_data'], 'string', 'max' => 1024]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'gid' => 'Gid',
            'orderid' => 'Orderid',
            'xml_data' => 'Xml Data',
            'ctime' => 'Ctime',
        ];
    }
}
