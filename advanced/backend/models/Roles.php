<?php

namespace app\models;

use Yii;

class Roles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'roles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','created_at','updated_at' ], 'required'],
            [['level'], 'integer'],
            [['display_name','permission'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '角色名称',
            'display_name'=>'显示名称',

            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

}
