<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "large_coin_change".
 *
 * @property integer $id
 * @property integer $gid
 * @property integer $change_coin
 * @property integer $after_coin
 * @property integer $change_type
 * @property string $ctime
 */
class LargeCoinChange extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'large_coin_change';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gid', 'change_coin', 'after_coin', 'change_type'], 'integer'],
            [['ctime'], 'safe']
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
            'change_coin' => 'Change Coin',
            'after_coin' => 'After Coin',
            'change_type' => 'Change Type',
            'ctime' => 'Ctime',
        ];
    }
}
