<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gm_activity".
 *
 * @property integer $id
 * @property string $activity_name
 * @property string $activity_desc
 * @property string $activity_begin
 * @property string $activity_end
 * @property integer $status
 * @property integer $activity_type
 * @property integer $total_fee
 * @property integer $reward_coin
 * @property integer $card_g
 * @property integer $card_s
 * @property integer $card_c
 * @property string $utime
 */
class GmActivity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gm_activity';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['activity_name', 'activity_desc', 'activity_begin', 'activity_end', 'status', 'activity_type', 'total_fee', 'reward_coin', 'card_g', 'card_s', 'card_c', 'utime'], 'required'],
            [['activity_begin', 'activity_end', 'utime'], 'safe'],
            [['status', 'activity_type', 'total_fee', 'reward_coin', 'card_g', 'card_s', 'card_c'], 'integer'],
            [['activity_name'], 'string', 'max' => 20],
            [['activity_desc'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'activity_name' => 'Activity Name',
            'activity_desc' => 'Activity Desc',
            'activity_begin' => 'Activity Begin',
            'activity_end' => 'Activity End',
            'status' => 'Status',
            'activity_type' => 'Activity Type',
            'total_fee' => 'Total Fee',
            'reward_coin' => 'Reward Coin',
            'card_g' => 'Card G',
            'card_s' => 'Card S',
            'card_c' => 'Card C',
            'utime' => 'Utime',
        ];
    }
    
    
    public function getLast($channel)
    {
        if ($channel<2000){//ios路径
            $keyword = "lastactios3";
        }else{
            $keyword = "lastactand3";
        }
        $data = Yii::$app->cache[$keyword];
        if ($data === false||count($data)==0) {
            $db = \yii::$app->db;
            $lists = $db->createCommand('SELECT activity_name,activity_desc,activity_url,activity_begin,activity_end FROM gm_activity  order by utime desc limit 1')
            ->queryOne();
            if ($channel<2000){//ios路径
//                 $lists['activity_url']=Yii::$app->params['adsurl'].'i'.$lists['activity_url'];
                $lists['activity_url']=Yii::$app->params['adsurl'].'1228.png';
            }else{
//                 $lists['activity_url']=Yii::$app->params['adsurl'].'a'.$lists['activity_url'];
                $lists['activity_url']=Yii::$app->params['adsurl'].'1228.png';
            }
            Yii::$app->cache->set($keyword, $lists,600);
        }else {
            $lists = $data;
        }
        return $lists;
    }
}
