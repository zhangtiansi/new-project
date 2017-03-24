<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lottery_ssq".
 *
 * @property integer $expect
 * @property string $opencode
 * @property string $opentime
 */
class LotterySsq extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lottery_ssq';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['expect', 'opencode', 'opentime'], 'required'],
            [['expect'], 'integer'],
            [['opentime'], 'safe'],
            [['opencode'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'expect' => 'Expect',
            'opencode' => 'Opencode',
            'opentime' => 'Opentime',
        ];
    }
}
