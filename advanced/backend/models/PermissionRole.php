<?php

namespace app\models;

use Yii;

class PermissionRole extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'permission_role';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['roles_id','permission_id'], 'required'],
            [['roles_id','permission_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => '用户id',
            'permission_id' => '权限id'
        ];
    }

}
