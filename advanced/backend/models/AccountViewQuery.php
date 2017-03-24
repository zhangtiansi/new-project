<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[AccountView]].
 *
 * @see AccountView
 */
class AccountViewQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return AccountView[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return AccountView|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}