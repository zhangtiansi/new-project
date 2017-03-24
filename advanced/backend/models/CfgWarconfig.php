<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cfg_warconfig".
 *
 * @property integer $id
 * @property integer $di_coin
 * @property integer $shang_coin
 * @property integer $xia_coin
 * @property integer $seat_coin
 * @property integer $xia_turn
 * @property integer $ya_shui
 * @property integer $war_id
 * @property integer $stime
 * @property integer $robot_coin
 * @property integer $war_open
 * @property integer $max_coin
 * @property integer $seat_coin_min
 * @property integer $prize_shui
 * @property integer $prize_coin
 * @property integer $prize_coin_max
 * @property string $prize_name_max
 * @property integer $card_1
 * @property integer $card_2
 * @property integer $card_3
 * @property integer $card_type_1
 * @property integer $card_type_2
 * @property integer $card_type_3
 */
class CfgWarconfig extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cfg_warconfig';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['di_coin', 'shang_coin', 'xia_coin', 'seat_coin', 'xia_turn', 'ya_shui', 'stime', 'robot_coin', 'war_open', 'max_coin', 'prize_name_max'], 'required'],
            [['di_coin', 'shang_coin', 'xia_coin', 'seat_coin', 'xia_turn', 'ya_shui', 'war_id', 'stime', 'robot_coin', 'war_open', 'max_coin', 'seat_coin_min', 'prize_shui', 'prize_coin', 'prize_coin_max', 'card_1', 'card_2', 'card_3', 'card_type_1', 'card_type_2', 'card_type_3'], 'integer'],
            [['prize_name_max'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'di_coin' => '单人最高押注金币',
            'max_coin' => '全局上限金币',
            'shang_coin' => '上庄金币',
            'xia_coin' => '下庄金币',
            'xia_turn' => '下庄轮数',
            'seat_coin' => '上座金币',
            'seat_coin_min' => '下座位金币',
            'ya_shui' => '押注抽水%',
            'prize_shui' => '奖池抽水%',
            'war_id' => '当前id',
            'stime' => '每轮时间',
            'robot_coin' => '系统庄盈利',
            'war_open' => '功能开启状态1开启0关闭',
            'prize_coin' => '奖池金额',
            'prize_coin_max' => '喜金历史最大值',
            'prize_name_max' => '最大喜金中奖人',
            'card_1' => 'Card 1',
            'card_2' => 'Card 2',
            'card_3' => 'Card 3',
            'card_type_1' => 'Card Type 1',
            'card_type_2' => 'Card Type 2',
            'card_type_3' => 'Card Type 3',
        ];
    }
}
