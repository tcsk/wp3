<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Scedule]].
 *
 * @see Scedule
 */
class SceduleQuery extends \yii\db\ActiveQuery {
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Scedule[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Scedule|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }
}
