<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gm_player_flag".
 *
 * @property integer $account_id
 * @property integer $login_time
 * @property integer $sign_num
 * @property integer $sign_mark
 * @property integer $item_index
 */
class GmPlayerFlag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gm_player_flag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account_id', 'login_time', 'sign_num', 'sign_mark', 'item_index'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'account_id' => 'Account ID',
            'login_time' => 'Login Time',
            'sign_num' => 'Sign Num',
            'sign_mark' => 'Sign Mark',
            'item_index' => 'Item Index',
        ];
    }
}
