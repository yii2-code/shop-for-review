<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 29.01.18
 * Time: 15:33
 */

declare(strict_types=1);

namespace app\modules\tag\models;


/**
 * Class TagRepository
 * @package app\modules\tag\models
 */
class TagRepository
{
    /**
     * @param string $name
     * @return bool
     */
    public function existsByName(string $name): bool
    {
        return Tag::find()->name($name)->exists();
    }

    /**
     * @param int $id
     * @return bool
     */
    public function existsById(int $id): bool
    {
        return Tag::find()->id($id)->exists();
    }

    /**
     * @param string $name
     * @return Tag|null
     */
    public function findOneByName(string $name): ?Tag
    {
        return Tag::find()->name($name)->limit(1)->one();
    }

    /**
     * @param array $names
     * @return array|Tag[]
     */
    public function findByNames(array $names): array
    {
        return Tag::find()->names($names)->all();
    }
}