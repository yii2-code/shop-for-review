<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 29.01.18
 * Time: 15:23
 */

declare(strict_types=1);

namespace app\modules\tag\models;


use DomainException;
use yii\db\ActiveRecord;

/**
 * Class Tag
 * @package app\modules\tag\models
 * @property $id int
 * @property $name string
 */
class Tag extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%tag}}';
    }

    /**
     * @param string $name
     * @return Tag
     */
    public static function create(string $name): self
    {
        $repository = new TagRepository();
        if ($repository->existsByName($name)) {
            throw new DomainException(sprintf('Unable to create tag because the name "%s" have already been taken.', $name));
        }
        $model = new static();
        $model->name = $name;
        return $model;
    }

    /**
     * @return TagQuery
     */
    public static function find(): TagQuery
    {
        return new TagQuery(static::class);
    }
}