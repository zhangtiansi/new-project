<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rank_ssl_daily".
 *
 * @property integer $gid
 * @property integer $reward
 * @property integer $playnum
 */
class RankSslDaily extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rank_ssl_daily';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gid'], 'required'],
            [['gid', 'reward', 'playnum'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gid' => 'Gid',
            'reward' => 'Reward',
            'playnum' => 'Playnum',
        ];
    }
}
