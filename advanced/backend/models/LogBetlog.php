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
 * @property integer $bid
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
            [['account_id', 'bet_1', 'bet_2', 'bet_3', 'bet_4', 'bet_5', 'bet_6'], 'required'],
            [['account_id', 'bet_1', 'bet_2', 'bet_3', 'bet_4', 'bet_5', 'bet_6', 'mark', 'bid'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'account_id' => 'UID',
            'bet_1' => '对子押注数',
            'bet_2' => '顺子押注数',
            'bet_3' => '金花押注数',
            'bet_4' => '顺金押注数',
            'bet_5' => '豹子押注数',
            'bet_6' => '3A押注数',
            'mark' => 'Mark',
            'bid' => '押注时时乐ID',
        ];
    }
}
