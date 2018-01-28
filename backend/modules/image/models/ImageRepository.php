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
     * @param int $sort
     * @return array|Image[]
     */
    public function findByRecordIdClass(int $id, string $class, $sort = SORT_DESC): array
    {
        return Image::find()->recordId($id)->class($class)->orderBy(['position' => $sort])->all();
    }

    /**
     * @param string $token
     * @param string $class
     * @param int $sort
     * @return array|Image[]
     */
    public function findByTokenClass(string $token, string $class, $sort = SORT_DESC): array
    {
        return Image::find()->token($token)->class($class)->orderBy(['position' => $sort])->all();
    }


    /**
     * @param string $token
     * @param string $class
     * @return int
     */
    public function maxPositionByToken(string $token, string $class): int
    {
        return (int)Image::find()->token($token)->class($class)->max('position');
    }

    /**
     * @param int $id
     * @param string $class
     * @return int
     */
    public function maxPositionByRecordIdClass(int $id, string $class): int
    {
        return (int)Image::find()->recordId($id)->class($class)->max('position');
    }
}