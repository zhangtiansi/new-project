<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_buycards".
 *
 * @property integer $id
 * @property integer $gid
 * @property integer $cardtype
 * @property string $buy_tm
 * @property string $buy_orderid
 */
class LogBuycards extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_buycards';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gid', 'cardtype', 'buy_tm', 'buy_orderid'], 'required'],
            [['gid'], 'integer'],
            [['buy_tm'], 'safe'],
            [['buy_orderid', 'cardtype'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'gid' => 'Gid',
            'cardtype' => 'Cardtype',
            'buy_tm' => 'Buy Tm',
            'buy_orderid' => 'Buy Orderid',
        ];
    }
}
