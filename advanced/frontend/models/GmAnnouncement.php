<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gm_announcement".
 *
 * @property integer $id
 * @property string $content
 * @property string $pic
 * @property integer $status
 * @property string $ctime
 */
class GmAnnouncement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gm_announcement';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content', 'pic', 'status', 'ctime'], 'required'],
            [['status'], 'integer'],
            [['ctime'], 'safe'],
            [['content'], 'string', 'max' => 250],
            [['pic'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => 'Content',
            'pic' => 'Pic',
            'status' => 'Status',
            'ctime' => 'Ctime',
        ];
    }
    
    public function getLast()
    {
        $keyword = "lastannouncement24";
        $data = Yii::$app->cache[$keyword];
        if ($data === false||count($data)==0) {
            $db = \yii::$app->db;
            $lists = $db->createCommand('SELECT content,pic FROM gm_announcement where status = 0 order by ctime desc limit 1')
            ->queryOne();
            $lists['pic']=Yii::$app->params['adsurl'].$lists['pic'];
            Yii::$app->cache->set($keyword, $lists,600);
        }else {
            $lists = $data;
        }
            return $lists;
    }
    
}
