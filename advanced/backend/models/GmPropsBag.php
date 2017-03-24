<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gm_props_bag".
 *
 * @property integer $id
 * @property integer $account_id
 * @property integer $item_id
 * @property integer $item_num
 * @property integer $exp
 * @property string $name
 * @property integer $type
 * @property string $ctime
 * @property integer $page
 */
class GmPropsBag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gm_props_bag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account_id', 'item_id', 'item_num', 'name'], 'required'],
            [['account_id', 'item_id', 'item_num', 'exp', 'type', 'page'], 'integer'],
            [['ctime'], 'safe'],
            [['name'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'account_id' => 'Account ID',
            'item_id' => 'Item ID',
            'item_num' => 'Item Num',
            'exp' => 'Exp',
            'name' => 'Name',
            'type' => 'Type',
            'ctime' => 'Ctime',
            'page' => 'Page',
        ];
    }
}
