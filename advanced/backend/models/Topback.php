<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "topback".
 *
 * @property integer $gid
 * @property string $name
 * @property string $reg_time
 * @property string $reg_channel
 * @property string $last_login
 * @property double $TotalFee
 * @property string $XiancaoBack
 * @property double $totalCost
 * @property integer $XiancaoBackNum
 * @property double $ClientFee
 * @property integer $ClientFeeNum
 * @property string $BackendFee
 * @property integer $BackendFeeNum
 * @property string $XiancaoFee
 * @property integer $XiancaoFeeNum
 */
class Topback extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'topback';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gid'], 'required'],
            [['gid', 'XiancaoBackNum', 'ClientFeeNum', 'BackendFeeNum', 'XiancaoFeeNum'], 'integer'],
            [['reg_time', 'last_login'], 'safe'],
            [['TotalFee', 'XiancaoBack', 'TotalCost', 'ClientFee', 'BackendFee', 'XiancaoFee'], 'number'],
            [['name'], 'string', 'max' => 256],
            [['reg_channel'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gid' => 'Gid',
            'name' => '昵称',
            'reg_time' => '注册时间',
            'reg_channel' => '注册渠道',
            'last_login' => '最后登录时间',
            'TotalFee' => '总充值',
            'XiancaoBack' => '总BACK',
            'TotalCost' => '总支出',
            'XiancaoBackNum' => 'XiancaoBackNum',
            'ClientFee' => '客户端Fee',
            'ClientFeeNum' => '客户端FeeNum',
            'BackendFee' => '后台Fee',
            'BackendFeeNum' => '后台FeeNum',
            'XiancaoFee' => 'XiancaoFee',
            'XiancaoFeeNum' => 'XiancaoFeeNum',
        ];
    }
}
