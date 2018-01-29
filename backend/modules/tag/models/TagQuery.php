<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 29.01.18
 * Time: 15:37
 */

declare(strict_types=1);

namespace backend\modules\tag\models;

use yii\db\ActiveQuery;

/**
 * Class TagQuery
 * @package backend\modules\tag\models
 */
class TagQuery extends ActiveQuery
{
    /**
     * @param null $db
     * @return array|\yii\db\ActiveRecord[]|Tag[]
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @param null $db
     * @return array|null|\yii\db\ActiveRecord|Tag
     */
    public function one($db = null)
    {
        return parent::one($db);
    }


    /**
     * @param string $name
     * @return TagQuery
     */
    public function name(string $name): self
    {
        return $this->andWhere([Tag::tableName() . '.[[name]]' => $name]);
    }

    /**
     * @param int $id
     * @return TagQuery
     */
    public function id(int $id): self
    {
        return $this->andWhere([Tag::tableName() . '.[[id]]' => $id]);
    }
}