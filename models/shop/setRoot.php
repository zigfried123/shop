<?php

namespace app\models\shop;

/**
 * This is the ActiveQuery class for [[FormRoot]].
 *
 * @see FormRoot
 */
class setRoot extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return FormRoot[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return FormRoot|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
