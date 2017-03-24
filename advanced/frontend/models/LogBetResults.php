<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_bet_results".
 *
 * @property integer $bid
 * @property integer $result
 * @property string $ctime
 * @property integer $coin
 * @property integer $player_num
 */
class LogBetResults extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_bet_results';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['result', 'coin'], 'required'],
            [['result', 'coin', 'player_num'], 'integer'],
            [['ctime'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'bid' => 'Bid',
            'result' => 'Result',
            'ctime' => 'Ctime',
            'coin' => 'Coin',
            'player_num' => 'Player Num',
        ];
    }
}
