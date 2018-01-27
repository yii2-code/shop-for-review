<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 27.01.18
 * Time: 18:51
 */

namespace backend\modules\image\TDO;


class Image
{
    /**
     * @var \backend\modules\image\models\Image
     */
    private $image;
    /**
     * @var string
     */
    private $url;

    public function __construct(\backend\modules\image\models\Image $image, string $url)
    {
        $this->image = $image;
        $this->url = $url;
    }

    public function getUrlSrc()
    {
        return $this->url . '/' . $this->image->src;
    }
}