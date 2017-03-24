<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "data_daily_user".
 *
 * @property integer $id
 * @property string $udate
 * @property string $channel
 * @property string $totalreg
 * @property string $loginp
 * @property string $loginnum
 * @property string $activenum
 * @property string $channelname
 */
class DataDailyUser extends \yii\db\ActiveRecord
{
    private $channelname;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'data_daily_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['udate', 'channel', 'totalreg', 'loginp', 'loginnum', 'activenum'], 'required'],
            [['udate','allreg','allregactive','channelname'], 'safe'],
            [['channel', 'totalreg', 'loginp', 'loginnum', 'activenum',], 'string', 'max' => 55]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'udate' => '日期',
            'channel' => '渠道',
            'totalreg' => '注册人数(IME)',
            'loginp' => '登录人数',
            'loginnum' => '登录人次',
            'activenum' => '活跃（参与过游戏）人数',
            'regactive' =>'注册活跃人数(IME)',
            'allreg'=>'注册人数(不限IME)',
            'allregactive'=>'注册活跃人数(不限IME)',
            'channelname'=>'查询渠道名',
        ];
    }
}
