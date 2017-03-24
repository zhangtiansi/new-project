<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gm_version".
 *
 * @property integer $id
 * @property string $cur_version
 * @property string $update_url
 * @property string $version_code
 * @property integer $force
 * @property string $channel
 * @property string $ctime
 */
class GmVersion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gm_version';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cur_version', 'update_url', 'version_code', 'force', 'channel', 'ctime'], 'required'],
            [['force'], 'integer'],
            [['ctime'], 'safe'],
            [['cur_version', 'version_code'], 'string', 'max' => 20],
            [['update_url'], 'string', 'max' => 255],
            [['channel'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cur_version' => 'Cur Version',
            'update_url' => 'Update Url',
            'version_code' => 'Version Code',
            'force' => 'Force',
            'channel' => 'Channel',
            'ctime' => 'Ctime',
        ];
    }
    
    public function checkUpdate($verCode,$channel)
    {
        
        
    }
    
}
