<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_betlog".
 *
 * @property integer $id
 * @property integer $account_id
 * @property integer $bet_1
 * @property integer $bet_2
 * @property integer $bet_3
 * @property integer $bet_4
 * @property integer $bet_5
 * @property integer $bet_6
 * @property integer $mark
 */
class LogBetlog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_betlog';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account_id', 'bet_1', 'bet_2', 'bet_3', 'bet_4', 'bet_5', 'bet_6', 'mark'], 'required'],
            [['account_id', 'bet_1', 'bet_2', 'bet_3', 'bet_4', 'bet_5', 'bet_6', 'mark'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'account_id' => 'Account ID',
            'bet_1' => 'Bet 1',
            'bet_2' => 'Bet 2',
            'bet_3' => 'Bet 3',
            'bet_4' => 'Bet 4',
            'bet_5' => 'Bet 5',
            'bet_6' => 'Bet 6',
            'mark' => 'Mark',
        ];
    }
}
