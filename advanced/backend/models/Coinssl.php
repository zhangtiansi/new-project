<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "coinssl".
 *
 * @property integer $id
 * @property integer $gid
 * @property string $name
 * @property integer $point
 * @property integer $total_coin
 * @property integer $maxCoin
 * @property integer $totalwin
 * @property integer $totalbet
 * @property integer $totalchange
 * @property integer $winTime
 * @property string $ctime
 * @property integer $regtime
 */
class Coinssl extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'coinssl';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'gid', 'point', 'total_coin', 'maxCoin', 'totalwin', 'totalbet', 'totalchange', 'winTime', 'regtime'], 'integer'],
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
            'total_coin' => '总财产（金币）',
            'maxCoin' => '最大赢取金币',
            'totalwin' => '总赢取',
            'totalbet' => '总押注',
            'totalchange' => '总盈利',
            'winTime' => '中奖次数',
            'ctime' => '日期',
            'regtime' => '注册时间',
        ];
    }
}
