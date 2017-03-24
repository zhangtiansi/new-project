<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_hour_playerinfo".
 *
 * @property integer $gid
 * @property string $name
 * @property integer $point
 * @property integer $money
 * @property integer $level
 * @property integer $power
 * @property integer $charm
 * @property string $chour
 */
class LogHourPlayerinfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_hour_playerinfo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gid'], 'required'],
            [['gid', 'point', 'money', 'level', 'power', 'charm'], 'integer'],
            [['chour'], 'safe'],
            [['name'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'=>'id',
            'gid' => 'Gid',
            'name' => '昵称',
            'point' => '钻石',
            'money' => '总金币',
            'level' => '等级',
            'power' => 'VIP',
            'charm' => '魅力',
            'chour' => '时间',
        ];
    }
    
    public static function getHis($gid)
    {
//         $keyword = 'playerinfohist'.$gid;
//         $data = Yii::$app->cache[$keyword];
        $allres = [];
//         if ($data === false||count($data)==0) {
            $db=Yii::$app->db_readonly;
            $sql='SELECT date_format(chour,"%Y-%m-%d.%H") as chour,money FROM log_hour_playerinfo WHERE gid=:gid ORDER BY id desc limit 40';
            $params=[':gid'=>$gid];
            $allres=$res = $db->createCommand($sql)
            ->bindValues($params)
            ->queryAll();
//             Yii::$app->cache->set($keyword, $allres,3000);
//         }else {
//             $allres=$data;
//         }
        return $allres;
    }
    public static function getHisCoin($gid)
    {
        //         $keyword = 'playerinfohist'.$gid;
        //         $data = Yii::$app->cache[$keyword];
        $allres = [];
        //         if ($data === false||count($data)==0) {
        $db=Yii::$app->db_readonly;
        $types=[23,1,3,4,5,14,20,30];
        $allres=[];
        foreach ($types as $v){
            $sql='SELECT t2.c_name,date_format(t1.chour,"%Y-%m-%d.%H") as chour,totalchange FROM log_hour_coinchange t1, cfg_coin_changetype t2 WHERE t1.gid=:gid and t1.change_type=t2.cid and t1.change_type=:type ORDER BY id desc limit 40';
            $params=[':gid'=>$gid,':type'=>$v];
            $res = $db->createCommand($sql)
            ->bindValues($params)
            ->queryAll();
            array_push($allres, $res);
        }
        $resCag=[];
        $resCag['xA']=[];
        $resCag['xData']=[];
//         var_dump($allres);
        foreach ($allres as $k=>$v){
            $arrayNUM =[];
            $cname='';
            foreach ($v as $kk=>$vv){
                if ($k==0){
                    array_push($resCag['xA'], $vv['chour']);
                }
                $cname=$vv['c_name'];
                array_push($arrayNUM, intval($vv['totalchange']/10000));
            }
            $arrayNUM=array_reverse($arrayNUM);
            array_push($resCag['xData'], ['name'=>$cname,'data'=>$arrayNUM]);
        }
        $resCag['xA']=array_reverse($resCag['xA']);
        return $resCag;
   }
}
