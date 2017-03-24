<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "coingame".
 *
 * @property integer $id
 * @property integer $gid
 * @property string $name
 * @property integer $point
 * @property integer $total_coin
 * @property integer $maxCoin
 * @property integer $totalchange
 * @property integer $winTime
 * @property string $ctime
 * @property integer $regtime
 */
class Coingame extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'coingame';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'gid', 'point', 'total_coin', 'maxCoin', 'totalchange', 'winTime', 'regtime'], 'integer'],
            [['gid'], 'required'],
            [['ctime'], 'safe'],
            [['name'], 'string', 'max' => 256]
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
            'name' => 'Name',
            'point' => '钻石',
            'total_coin' => '总财产',
            'maxCoin' => '最大金币',
            'totalchange' => '总盈亏',
            'winTime' => '总盈利次数',
            'ctime' => '日期',
            'regtime' => '注册时间',
        ];
    }
}
