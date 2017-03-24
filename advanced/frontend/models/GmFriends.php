<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gm_friends".
 *
 * @property integer $id
 * @property integer $uid
 * @property integer $fid
 * @property string $ctime
 * @property integer $type
 */
class GmFriends extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gm_friends';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'fid', 'ctime'], 'required'],
            [['uid', 'fid', 'type'], 'integer'],
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
            'uid' => 'Uid',
            'fid' => 'Fid',
            'ctime' => 'Ctime',
            'type' => 'Type',
        ];
    }
}
