<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_war_result".
 *
 * @property integer $war_id
 * @property integer $men_1
 * @property integer $men_2
 * @property integer $men_3
 * @property integer $men_4
 * @property string $men_card_1
 * @property string $men_card_2
 * @property string $men_card_3
 * @property string $men_card_4
 * @property string $ctme
 * @property integer $banker
 * @property string $banker_card
 */
class LogWarResult extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_war_result';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['war_id', 'men_1', 'men_2', 'men_3', 'men_4', 'men_card_1', 'men_card_2', 'men_card_3', 'men_card_4', 'banker', 'banker_card'], 'required'],
            [['war_id', 'men_1', 'men_2', 'men_3', 'men_4', 'banker'], 'integer'],
            [['ctme'], 'safe'],
            [['men_card_1', 'men_card_2', 'men_card_3', 'men_card_4', 'banker_card'], 'string', 'max' => 256]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'war_id' => 'War ID',
            'men_1' => 'Men1(1负2胜)',
            'men_2' => 'Men2(1负2胜)',
            'men_3' => 'Men3(1负2胜)',
            'men_4' => 'Men4(1负2胜)',
            'men_card_1' => 'Men1牌型',
            'men_card_2' => 'Men2牌型',
            'men_card_3' => 'Men3牌型',
            'men_card_4' => 'Men4牌型',
            'ctme' => '时间',
            'banker' => '庄',
            'banker_card' => '庄牌型',
        ];
    }
}
