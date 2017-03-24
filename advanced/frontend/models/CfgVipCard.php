<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cfg_vip_card".
 *
 * @property integer $card_id
 * @property string $card_name
 * @property integer $card_exp
 * @property integer $card_cost
 * @property string $ctime
 */
class CfgVipCard extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cfg_vip_card';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['card_name', 'card_exp', 'card_cost', 'ctime'], 'required'],
            [['card_exp', 'card_cost'], 'integer'],
            [['ctime'], 'safe'],
            [['card_name'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'card_id' => 'Card ID',
            'card_name' => 'Card Name',
            'card_exp' => 'Card Exp',
            'card_cost' => 'Card Cost',
            'ctime' => 'Ctime',
        ];
    }
}
