<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gm_activity".
 *
 * @property integer $id
 * @property string $activity_name
 * @property string $activity_desc
 * @property string $activity_url
 * @property string $activity_begin
 * @property string $activity_end
 * @property integer $status
 * @property integer $activity_type
 * @property integer $total_fee
 * @property integer $reward_coin
 * @property integer $card_g
 * @property integer $card_s
 * @property integer $card_c
 * @property string $utime
 */
class GmActivity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gm_activity';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['activity_name', 'activity_desc', 'activity_url', 'activity_begin', 'activity_end', 'status', 'activity_type', 'total_fee', 'reward_coin', 'card_g', 'card_s', 'card_c', 'utime'], 'required'],
            [['status', 'activity_type', 'total_fee', 'reward_coin', 'card_g', 'card_s', 'card_c'], 'integer'],
            [['utime'], 'safe'],
            [['activity_name'], 'string', 'max' => 20],
            [['activity_desc'], 'string', 'max' => 200],
            [['activity_url'], 'string', 'max' => 255],
            [['activity_begin', 'activity_end'], 'string', 'max' => 22]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'activity_name' => 'Activity Name',
            'activity_desc' => 'Activity Desc',
            'activity_url' => 'Activity Url',
            'activity_begin' => 'Activity Begin',
            'activity_end' => 'Activity End',
            'status' => 'Status',
            'activity_type' => 'Activity Type',
            'total_fee' => 'Total Fee',
            'reward_coin' => 'Reward Coin',
            'card_g' => 'Card G',
            'card_s' => 'Card S',
            'card_c' => 'Card C',
            'utime' => 'Utime',
        ];
    }
}
