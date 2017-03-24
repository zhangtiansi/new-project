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
            [['act_type'], 'integer'],
            [['begin_tm', 'end_tm'], 'safe'],
            [['name', 'act_title'], 'string', 'max' => 30],
            [['act_desc'], 'string', 'max' => 255],
            [['name', 'act_title'], 'unique', 'targetAttribute' => ['name', 'act_title'], 'message' => 'The combination of Name and Act Title has already been taken.']
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
            'act_title' => 'Act Title',
            'act_desc' => 'Act Desc',
            'act_type' => 'Act Type',
            'begin_tm' => 'Begin Tm',
            'end_tm' => 'End Tm',
        ];
    }
}
