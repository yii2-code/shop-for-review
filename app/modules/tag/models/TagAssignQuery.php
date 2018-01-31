<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 29.01.18
 * Time: 17:05
 */

namespace app\modules\tag\models;


use yii\db\ActiveQuery;

/**
 * Class TagAssignQuery
 * @package app\modules\tag\models
 */
class TagAssignQuery extends ActiveQuery
{
    /**
     * @param null $db
     * @return array|\yii\db\ActiveRecord[]|TagAssign
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @param null $db
     * @return array|null|\yii\db\ActiveRecord
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}