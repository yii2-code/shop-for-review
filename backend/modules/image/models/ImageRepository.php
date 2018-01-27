<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 26.01.18
 * Time: 19:08
 */

declare(strict_types=1);

namespace backend\modules\image\models;


class ImageRepository
{
    public function findOne(int $id): ?Image
    {
        return Image::find()->id($id)->limit(1)->one();
    }
}