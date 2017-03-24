<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_dailyranks".
 *
 * @property integer $id
 * @property string $cdate
 * @property integer $gid
 * @property string $rank_type
 * @property integer $value
 * @property integer $rank
 */
class LogDailyranks extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_dailyranks';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cdate', 'gid', 'rank_type', 'value', 'rank'], 'required'],
            [['cdate'], 'safe'],
            [['gid', 'value', 'rank'], 'integer'],
            [['rank_type'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cdate' => 'Cdate',
            'gid' => 'Gid',
            'rank_type' => 'Rank Type',
            'value' => 'Value',
            'rank' => 'Rank',
        ];
    }
}
