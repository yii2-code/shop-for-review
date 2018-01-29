<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 29.01.18
 * Time: 15:33
 */

declare(strict_types=1);

namespace backend\modules\tag\models;


/**
 * Class TagRepository
 * @package backend\modules\tag\models
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
}