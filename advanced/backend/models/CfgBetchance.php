<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cfg_betchance".
 *
 * @property integer $id
 * @property integer $chance
 * @property integer $odds
 */
class CfgBetchance extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cfg_betchance';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['chance', 'odds'], 'required'],
            [['chance', 'odds'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'chance' => 'Chance',
            'odds' => 'Odds',
        ];
    }
    public function getbetChance()
    {
        $db = \yii::$app->db;
        $res = $db->createCommand('SELECT * from cfg_betchance')
        ->queryAll();
        return $res;
    }
}
