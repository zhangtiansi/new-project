<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_actrewards".
 *
 * @property integer $id
 * @property integer $gid
 * @property integer $point
 * @property integer $coin
 * @property integer $propid
 * @property integer $propnum
 * @property integer $card_g
 * @property integer $card_s
 * @property integer $card_c
 * @property integer $status
 * @property string $ctime
 * @property string $change_type
 * @property string $desc
 */
class LogActrewards extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_actrewards';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gid'], 'required'],
            [['gid', 'point', 'coin', 'propid', 'propnum', 'card_g', 'card_s', 'card_c', 'status'], 'integer'],
            [['ctime'], 'safe'],
            [['change_type'], 'string', 'max' => 22],
            [['desc'], 'string', 'max' => 50]
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
            'point' => 'Point',
            'coin' => 'Coin',
            'propid' => 'Propid',
            'propnum' => 'Propnum',
            'card_g' => 'Card G',
            'card_s' => 'Card S',
            'card_c' => 'Card C',
            'status' => 'Status',
            'ctime' => 'Ctime',
            'change_type' => 'Change Type',
            'desc' => 'Desc',
        ];
    }
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if($insert) {
                $this->ctime=date('Y-m-d H:i:s');
                return true;
            }
        }else {
            return false;
        }
        
    }
}
