<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cfg_gift_reward".
 *
 * @property integer $id
 * @property string $reward_name
 * @property integer $chance
 * @property integer $threshold
 * @property integer $coin_pool
 * @property integer $reward
 * @property string $ctime
 * @property integer $gift_id
 * @property string $gfit_name
 */
class CfgGiftReward extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cfg_gift_reward';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['reward_name', 'chance', 'threshold', 'coin_pool', 'reward', 'gift_id', 'gfit_name'], 'required'],
            [['chance', 'threshold', 'coin_pool', 'reward', 'gift_id'], 'integer'],
            [['ctime'], 'safe'],
            [['reward_name'], 'string', 'max' => 20],
            [['gfit_name'], 'string', 'max' => 11]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'reward_name' => 'Reward Name',
            'chance' => 'Chance',
            'threshold' => 'Threshold',
            'coin_pool' => 'Coin Pool',
            'reward' => 'Reward',
            'ctime' => 'Ctime',
            'gift_id' => 'Gift ID',
            'gfit_name' => 'Gfit Name',
        ];
    }
}
