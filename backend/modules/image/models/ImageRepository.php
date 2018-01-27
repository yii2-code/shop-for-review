<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 26.01.18
 * Time: 19:08
 */

declare(strict_types=1);

namespace backend\modules\image\models;


/**
 * Class ImageRepository
 * @package backend\modules\image\models
 */
class ImageRepository
{
    /**
     * @param int $id
     * @return Image|null
     */
    public function findOne(int $id): ?Image
    {
        return Image::find()->id($id)->limit(1)->one();
    }


    /**
     * @param int $id
     * @param string $class
     * @return array|Image[]
     */
    public function findByRecordIdClass(int $id, string $class): array
    {
        return Image::find()->recordId($id)->class($class)->all();
    }

    /**
     * @param string $token
     * @param string $class
     * @return array|Image[]
     */
    public function findByTokenClass(string $token, string $class): array
    {
        return Image::find()->token($token)->class($class)->all();
    }
}