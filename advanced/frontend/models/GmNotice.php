<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gm_notice".
 *
 * @property integer $id
 * @property string $name
 * @property integer $tag
 * @property integer $type
 * @property string $title
 * @property string $content
 * @property string $content_time
 * @property string $tips
 * @property string $utime
 * @property integer $status
 */
class GmNotice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gm_notice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'title', 'content', 'content_time', 'status'], 'required'],
            [['tag', 'type', 'status'], 'integer'],
            [['utime'], 'safe'],
            [['name'], 'string', 'max' => 20],
            [['title'], 'string', 'max' => 100],
            [['content'], 'string', 'max' => 512],
            [['content_time', 'tips'], 'string', 'max' => 256]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'tag' => 'Tag',
            'type' => 'Type',
            'title' => 'Title',
            'content' => 'Content',
            'content_time' => 'Content Time',
            'tips' => 'Tips',
            'utime' => 'Utime',
            'status' => 'Status',
        ];
    }
    
    public static function getNoticeList($type=0)
    {
        $keyword = "noticeList".$type;
        $data = Yii::$app->cache[$keyword];
        if ($data === false||count($data)==0) {
            if ($type!=0){
                $all = GmNotice::find()->where('`type` !=0 and `status`=0')->orderBy('utime DESC')->limit(20)->all();
            }else {
                $all = GmNotice::find()->where(['type'=>$type,'status'=>0])->orderBy('utime DESC')->limit(20)->all();
            }
            $lists= [];
//             print_r($all);
//             echo "<br>";
            foreach ($all as $notice){
                array_push($lists, $notice->attributes);
            }
            Yii::$app->cache->set($keyword, $lists,60);
        }else {
            $lists = $data;
        }
        return $lists;
    }
    public static function getNoticePlatform($type=0,$platform=0)//=0ios
    {
        $keyword = "noticeListPlatform".$type;
        $data = Yii::$app->cache[$keyword];
        if ($data === false||count($data)==0) {
            if ($type!=0){
                $all = GmNotice::find()->where('`type` !=0 and `status`=2')->orderBy('utime DESC')->limit(20)->all();
            }else {
                $all = GmNotice::find()->where(['type'=>$type,'status'=>0])->orderBy('utime DESC')->limit(20)->all();
            }
            $lists= [];
            //             print_r($all);
            //             echo "<br>";
            foreach ($all as $notice){
            array_push($lists, $notice->attributes);
            }
            Yii::$app->cache->set($keyword, $lists,60);
        }else {
        $lists = $data;
    }
    return $lists;
    }
    
}
