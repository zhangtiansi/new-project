<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gm_week_card".
 *
 * @property integer $gid
 * @property integer $firstbg_tm
 * @property integer $buy_tm
 * @property string $lastbuy_tm
 * @property string $lastget_tm
 */
class GmWeekCard extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gm_week_card';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gid', 'firstbg_tm', 'buy_tm', 'lastbuy_tm'], 'required'],
            [['gid', 'firstbg_tm', 'buy_tm'], 'integer'],
            [['lastbuy_tm', 'lastget_tm'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gid' => 'Gid',
            'firstbg_tm' => 'Firstbg Tm',
            'buy_tm' => 'Buy Tm',
            'lastbuy_tm' => 'Lastbuy Tm',
            'lastget_tm' => 'Lastget Tm',
        ];
    }
}
