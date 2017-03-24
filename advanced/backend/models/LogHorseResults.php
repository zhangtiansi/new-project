<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_horse_results".
 *
 * @property integer $bid
 * @property integer $result
 * @property string $ctime
 * @property integer $betCoin
 * @property integer $betNum
 * @property integer $rewardCoin
 * @property integer $playerNum
 */
class LogHorseResults extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_horse_results';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['result', 'betCoin', 'betNum', 'rewardCoin'], 'required'],
            [['result', 'betCoin', 'betNum', 'rewardCoin', 'playerNum'], 'integer'],
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
            'betCoin' => 'Bet Coin',
            'betNum' => 'Bet Num',
            'rewardCoin' => 'Reward Coin',
            'playerNum' => 'Player Num',
        ];
    }
}
