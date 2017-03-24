<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log_dice_reslut".
 *
 * @property integer $bid
 * @property integer $point1
 * @property integer $point2
 * @property integer $point3
 */
class LogDiceReslut extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_dice_reslut';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bid', 'point1', 'point2', 'point3'], 'required'],
            [['bid', 'point1', 'point2', 'point3'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'bid' => 'Bid',
            'point1' => 'Point1',
            'point2' => 'Point2',
            'point3' => 'Point3',
        ];
    }
}
