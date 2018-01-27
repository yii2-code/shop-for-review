<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 26.01.18
 * Time: 19:06
 */

declare(strict_types=1);

namespace backend\modules\image\models;


use yii\db\ActiveQuery;

/**
 * Class ImageQuery
 * @package backend\modules\image\models
 */
class ImageQuery extends ActiveQuery
{
    /**
     * @param null $db
     * @return array|null|\yii\db\ActiveRecord|Image
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @param null $db
     * @return array|\yii\db\ActiveRecord[]|Image[]
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @param int $id
     * @return ImageQuery
     */
    public function id(int $id): self
    {
        return $this->andWhere([Image::tableName() . '.[[id]]' => $id]);
    }


    /**
     * @param int $id
     * @return ImageQuery
     */
    public function recordId(int $id): self
    {
        return $this->andWhere([Image::tableName() . '.[[record_id]]' => $id]);
    }

    /**
     * @param string $class
     * @return ImageQuery
     */
    public function class(string $class): self
    {
        return $this->andWhere([Image::tableName() . '.[[class]]' => $class]);
    }

    /**
     * @param string $token
     * @return ImageQuery
     */
    public function token(string $token): self
    {
        return $this->andWhere([Image::tableName() . '.[[token]]' => $token]);
    }
}