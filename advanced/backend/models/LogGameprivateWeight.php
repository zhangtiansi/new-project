<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_gameprivate_weight".
 *
 * @property string $gameno
 * @property integer $win_uid
 * @property integer $win_coin
 * @property integer $loser_no
 * @property string $loser_uid
 * @property string $loser_vip
 * @property integer $loser_weight
 * @property string $ctime
 */
class LogGameprivateWeight extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_gameprivate_weight';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gameno', 'win_uid'], 'required'],
            [['win_uid', 'win_coin', 'loser_no', 'loser_weight'], 'integer'],
            [['ctime'], 'safe'],
            [['gameno', 'loser_vip'], 'string', 'max' => 32],
            [['loser_uid'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gameno' => 'Gameno',
            'win_uid' => 'Win Uid',
            'win_coin' => 'Win Coin',
            'loser_no' => 'Loser No',
            'loser_uid' => 'Loser Uid',
            'loser_vip' => 'Loser Vip',
            'loser_weight' => 'Loser Weight',
            'ctime' => 'Ctime',
        ];
    }
}
