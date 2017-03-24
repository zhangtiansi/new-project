<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gm_optact".
 *
 * @property integer $id
 * @property string $name
 * @property string $act_title
 * @property string $act_desc
 * @property integer $act_type
 * @property string $begin_tm
 * @property string $end_tm
 * @property integer $standard
 * @property integer $diamond
 * @property integer $coin
 * @property integer $propid
 * @property integer $propnum
 * @property integer $vcard_g
 * @property integer $vcard_s
 * @property integer $vcard_c
 * @property integer $status
 */
class GmOptact extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gm_optact';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'act_title', 'begin_tm', 'end_tm'], 'required'],
            [['act_type', 'standard', 'diamond', 'coin', 'propid', 'propnum', 'vcard_g', 'vcard_s', 'vcard_c', 'status'], 'integer'],
            [['begin_tm', 'end_tm'], 'safe'],
            [['name', 'act_title'], 'string', 'max' => 30],
            [['act_desc'], 'string', 'max' => 255],
            [['name', 'act_title'], 'unique', 'targetAttribute' => ['name', 'act_title'], 'message' => 'title已经被使用']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'act_title' => '标题',
            'act_desc' => '描述',
            'act_type' => '类型2为充值满送',
            'begin_tm' => '起始时间',
            'end_tm' => '结束时间',
            'standard' => '标准值',
            'diamond' => '送钻石数',
            'coin' => '送金币数',
            'propid' => '送道具id',
            'propnum' => '道具数',
            'vcard_g' => '金卡数',
            'vcard_s' => '银卡数',
            'vcard_c' => '铜卡数',
            'status' => '状态',
        ];
    }
    
    public static function getOptactList(){
        $ar = GmOptact::find()->all();
        return $ar;
    }
}
