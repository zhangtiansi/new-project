<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "coinall".
 *
 * @property integer $id
 * @property integer $gid
 * @property string $name
 * @property integer $point
 * @property integer $total_coin
 * @property integer $maxCoin
 * @property integer $maxType
 * @property integer $minCoin
 * @property integer $minType
 * @property integer $totalchange
 * @property string $ctime
 * @property integer $regtime
 */
class Coinall extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'coinall';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'gid', 'point', 'total_coin', 'maxCoin', 'maxType', 'minCoin', 'minType', 'totalchange', 'regtime'], 'integer'],
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
            'name' => '昵称',
            'point' => '钻石',
            'total_coin' => '总金币(财产)',
            'maxCoin' => '最大获利金币',
            'maxType' => '最大获利类型',
            'minCoin' => '最大付出金币',
            'minType' => '最大付出类型',
            'totalchange' => '总盈亏',
            'ctime' => '日期',
            'regtime' => '注册时间',
        ];
    }
    
    public function getMaxchangeType()
    {
        //一对一
        return $this->hasOne(CfgCoinChangetype::className(), ['cid' => 'maxType']);
    
    }
    public function getMinchangeType()
    {
        //一对一
        return $this->hasOne(CfgCoinChangetype::className(), ['cid' => 'minType']);
    
    }
    
    public function getPlayer()
    {
        //一对一
        return $this->hasOne(GmPlayerInfo::className(), ['account_id' => 'gid']);
    }
}
