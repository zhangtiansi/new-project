<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_bet_results".
 *
 * @property integer $bid
 * @property integer $result
 * @property string $ctime
 * @property integer $betCoin
 * @property integer $coin
 * @property integer $player_num
 * @property integer $coin_pool
 */
class LogBetResults extends \yii\db\ActiveRecord
{
    public static $px=[1=>"对子",2=>"顺子",3=>"金花",4=>"散牌",5=>"顺金",6=>"豹子",7=>"3A"];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_bet_results';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['result', 'betCoin', 'coin', 'coin_pool'], 'required'],
            [['result', 'betCoin', 'coin', 'player_num', 'coin_pool'], 'integer'],
            [['ctime'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'bid' => 'Bid',
            'result' => '开奖结果',
            'ctime' => '时间',
            'betCoin' => '押注金额',
            'coin' => '开奖奖金总数',
            'player_num' => '中奖人数',
            'coin_pool' => '当前奖池总数',
        ];
    }
    
    public function getRecent()
    {
        $db = \yii::$app->db;
        $res = $db->createCommand('SELECT bid,result,ctime,betCoin,coin,player_num,coin_pool from log_bet_results order by bid desc limit 1')
        ->queryOne();
        switch ($res['result']){
            case 1:
                $res['result']="对子";
                break;
            case 2:
                $res['result']="顺子";
                break;
            case 3:
                $res['result']="金花";
                break;                
            case 4:
                $res['result']="散牌";
                break;            
            case 5:
                $res['result']="顺金";
                break;   
            case 6:
                $res['result']="豹子";
                break;
            case 7:
                $res['result']="三A";
                break;
            default:
                return ;
        }
        return $res;
    }
    
}
