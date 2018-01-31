<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 31.01.18
 * Time: 11:12
 */

declare(strict_types=1);

namespace backend\modules\tag\services;


/**
 * Class TagService
 * @package backend\modules\tag\services
 */

use backend\modules\tag\models\Tag;
use backend\modules\tag\types\TagType;
use RuntimeException;

/**
 * Class TagService
 * @package backend\modules\tag\services
 */
class TagService
{
    /**
     * @return TagType
     */
    public function createType(): TagType
    {
        return new TagType();
    }

    /**
     * @param array $array
     * @return array
     */
    public function filter(array $array): array
    {
        $array = array_filter($array);
        $array = array_map('trim', $array);
        $array = array_unique($array);
        return array_values($array);
    }

    /**
     * @param TagType $type
     * @return Tag
     */
    public function create(TagType $type): Tag
    {
        $tag = Tag::create($type->tag);

        $this->save($tag);

        return $tag;
    }

    /**
     * @param Tag $model
     */
    public function save(Tag $model)
    {
        if (!$model->save()) {
            throw new RuntimeException('Unable to save model');
        }
    }
}