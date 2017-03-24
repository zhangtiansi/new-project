<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_friends_msgs".
 *
 * @property integer $id
 * @property integer $from_uid
 * @property integer $to_uid
 * @property integer $type
 * @property integer $status
 * @property string $msg_content
 * @property string $ctime
 */
class LogFriendsMsgs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_friends_msgs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from_uid', 'to_uid', 'type', 'status', 'msg_content'], 'required'],
            [['from_uid', 'to_uid', 'type', 'status'], 'integer'],
            [['ctime'], 'safe'],
            [['msg_content'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'from_uid' => 'From Uid',
            'to_uid' => 'To Uid',
            'type' => 'Type',
            'status' => 'Status',
            'msg_content' => 'Msg Content',
            'ctime' => 'Ctime',
        ];
    }
    
    public static function getunreadlist()
    {
        $db=Yii::$app->db_readonly;
        $sql='select t1.from_uid as fid,count(id) as unread, FROM_UNIXTIME(max(UNIX_TIMESTAMP(t1.ctime))) as latest,t2.name,t2.money,t2.point,t2.point_box,t2.level,t2.power 
            from log_friends_msgs t1,gm_player_info t2 
            where t1.status=1 and t1.to_uid=0 and t1.from_uid=t2.account_id 
            group by  fid order by latest desc limit 20';
        $res = $db->createCommand($sql)
        ->queryAll();
        return $res;
    }
    
    public static function getresponselist()
    {
        $db=Yii::$app->db_readonly;
        $sql='SELECT t1.to_uid as fid, max(t1.ctime) as latest,t2.name,t2.money,t2.point,t2.point_box,t2.level,t2.power
             from log_friends_msgs t1,gm_player_info t2 
             WHERE  t1.from_uid=0  and t1.to_uid=t2.account_id  group by fid order by latest desc limit 20';
        $res = $db->createCommand($sql)
        ->queryAll();
        return $res;
    }
    
    //
    public static function Fetch($fid)
    {
        $db=Yii::$app->db_readonly;
        $param=[':from_uid'=>$fid];
        $sql='select * from (select t1.from_uid as fid, t1.to_uid as tid,t1.msg_content as content, t1.ctime as mtime,t2.name
            from log_friends_msgs t1,gm_player_info t2
            where t1.to_uid=0 and t1.from_uid=t2.account_id and  t1.from_uid=:from_uid
            union
            select t1.from_uid as fid, t1.to_uid as tid,t1.msg_content as content, t1.ctime as mtime,t2.name
            from log_friends_msgs t1,gm_player_info t2
            where t1.from_uid=0 and t1.to_uid=t2.account_id and  t1.to_uid=:from_uid
            order by mtime desc limit 20) as tb order by mtime asc';
        $res = $db->createCommand($sql)
        ->bindValues($param)
        ->queryAll();
        return $res;
    }
    public static function ReadAll($tid)
    {
        $a = LogFriendsMsgs::updateAll(['status'=>2],['from_uid'=>$tid,'to_uid'=>0,'status'=>1,'type'=>0]);
        Yii::error("update all result ".$a);
    }
    
    public static function SendCustomer($tid,$msg)
    {
        $newMsg = new LogFriendsMsgs();
        $newMsg->from_uid = 0;
        $newMsg->to_uid = $tid;
        $newMsg->msg_content = $msg;
        $newMsg->ctime = date('Y-m-d H:i:s');
        $newMsg->status=10;
        $newMsg->type=0;
        if ($newMsg->save()){
            LogFriendsMsgs::updateAll(['status'=>2],['from_uid'=>$tid,'to_uid'=>0,'status'=>1,'type'=>0]);
            return true;
        }else {
            Yii::error('send new msg failed '.print_r($newMsg->getErrors(),true));
            return false;
        }
    }
}
