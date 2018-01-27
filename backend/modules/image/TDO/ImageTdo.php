<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 27.01.18
 * Time: 18:51
 */

declare(strict_types=1);

namespace backend\modules\image\TDO;


use backend\modules\image\services\ImageManager;

/**
 * Class Image
 * @package backend\modules\image\TDO
 */
class ImageTdo
{
    /**
     * @var \backend\modules\image\models\Image
     */
    private $image;

    /**
     * @var ImageManager
     */
    private $imageManager;

    /**
     * Image constructor.
     * @param \backend\modules\image\models\Image $image
     * @param ImageManager $imageManager
     */
    public function __construct(\backend\modules\image\models\Image $image, ImageManager $imageManager)
    {
        $this->image = $image;
        $this->imageManager = $imageManager;
    }

    /**
     * @return string
     */
    public function getUrlSrc(): string
    {
        return $this->imageManager->getUrl() . '/' . $this->image->src;
    }
}