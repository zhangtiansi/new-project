<?php

namespace app\models;

use Yii;
use yii\data\Sort;

/**
 * This is the model class for table "log_mail".
 *
 * @property integer $id
 * @property integer $gid
 * @property integer $from_id
 * @property string $title
 * @property string $content
 * @property string $ctime
 * @property integer $status
 */
class LogMail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_mail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gid', 'title', 'content', 'ctime', 'status'], 'required'],
            [['gid', 'from_id', 'status'], 'integer'],
            [['content'], 'string'],
            [['ctime'], 'safe'],
            [['title'], 'string', 'max' => 50]
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
            'from_id' => 'From ID',
            'title' => 'Title',
            'content' => 'Content',
            'ctime' => 'Ctime',
            'status' => 'Status',
        ];
    }
    
    public static function getMailList($gid)
    {
        $lsSys = LogMail::find()
                ->where(['status'=>0,'gid'=>$gid,'from_id'=>0])
                ->orderBy('id DESC')
                ->limit(10)->all();
        $lsUser = LogMail::find()
                ->where(['status'=>0,'gid'=>$gid])
                ->andWhere('from_id != 0')
                ->orderBy('id DESC')
                ->limit(10)->all();
        $res = [];
        if (count($lsSys)>0){
            $res['csys']=count($lsSys);
            $res['sysList']=[];
            foreach ($lsSys as $V){
                array_push($res['sysList'], array_merge($V->attributes,['from_name'=>"系统"]));
            }
        }
        if (count($lsUser)>0){
            $res['cUser']=count($lsUser);
            $res['userList']=[];
            foreach ($lsUser as $V){
                array_push($res['userList'], array_merge($V->attributes,['from_name'=>$V->fromPlayer->name]));
            }
        }
        return $res;
    }
    
    public static function readMail($id)
    {
        $ml = LogMail::findOne($id);
        if (is_object($ml))
        {
            $ml->status=1;
            $ml->save();
        }
        return true;
    }
    
    public static function getUnread($gid){
        $c = LogMail::find()->where(['gid'=>$gid,'status'=>0])->count();
        return $c;
    }
    public function getFromPlayer()
    {//一对一
        return $this->hasOne(GmPlayerInfo::className(), ['account_id' => 'from_id']);
    }
    
}
