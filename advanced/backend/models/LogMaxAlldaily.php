<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_max_alldaily".
 *
 * @property integer $id
 * @property integer $gid
 * @property integer $maxCoin
 * @property integer $maxType
 * @property integer $minType
 * @property integer $minCoin
 * @property integer $totalchange
 * @property string $ctime
 */
class LogMaxAlldaily extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_max_alldaily';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gid'], 'required'],
            [['gid', 'maxCoin', 'maxType', 'minType', 'minCoin', 'totalchange'], 'integer'],
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
            'maxCoin' => 'Max Coin',
            'maxType' => 'Max Type',
            'minType' => 'Min Type',
            'minCoin' => 'Min Coin',
            'totalchange' => 'Totalchange',
            'ctime' => 'Ctime',
        ];
    }
}
