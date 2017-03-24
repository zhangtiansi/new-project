<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gm_player_score".
 *
 * @property integer $accout_id
 * @property integer $point
 * @property integer $score
 * @property integer $today_score
 * @property integer $week_score
 * @property integer $active_score
 * @property string $utime
 */
class GmPlayerScore extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gm_player_score';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['accout_id'], 'required'],
            [['accout_id', 'point', 'score', 'today_score', 'week_score', 'active_score'], 'integer'],
            [['utime'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'accout_id' => 'Accout ID',
            'point' => 'Point',
            'score' => 'Score',
            'today_score' => 'Today Score',
            'week_score' => 'Week Score',
            'active_score' => 'Active Score',
            'utime' => 'Utime',
        ];
    }
}
