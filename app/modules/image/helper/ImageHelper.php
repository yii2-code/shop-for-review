<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 06.02.18
 * Time: 17:38
 */

declare(strict_types=1);

namespace app\modules\image\helper;

/**
 * Class ImageHelper
 * @package app\modules\image\helper
 */
class ImageHelper
{
    /**
     * @param string $thumb
     * @param string $fileName
     * @return string
     */
    public static function constructThumbName(string $thumb, string $fileName): string
    {
        return "$thumb-$fileName";
    }
}