<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "large_user_modify".
 *
 * @property integer $id
 * @property integer $gid
 * @property integer $before_money
 * @property integer $before_point
 * @property integer $before_point_box
 * @property integer $change_money
 * @property integer $change_point
 * @property integer $change_point_box
 * @property integer $after_money
 * @property integer $after_point
 * @property integer $after_point_box
 * @property string $ctime
 */
class LargeUserModify extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'large_user_modify';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gid', 'before_money', 'before_point', 'before_point_box', 'change_money', 'change_point', 'change_point_box', 'after_money', 'after_point', 'after_point_box'], 'integer'],
            [['ctime'], 'safe']
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
            'before_money' => 'Before Money',
            'before_point' => 'Before Point',
            'before_point_box' => 'Before Point Box',
            'change_money' => 'Change Money',
            'change_point' => 'Change Point',
            'change_point_box' => 'Change Point Box',
            'after_money' => 'After Money',
            'after_point' => 'After Point',
            'after_point_box' => 'After Point Box',
            'ctime' => 'Ctime',
        ];
    }
}
