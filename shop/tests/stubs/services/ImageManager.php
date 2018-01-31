<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 31.01.18
 * Time: 15:49
 */

namespace shop\tests\stubs\services;


use app\modules\image\services\ImageManagerInterface;

class ImageManager implements ImageManagerInterface
{
    public function createService()
    {
        return $this;
    }

    public function editAfterCreatedRecord()
    {

    }
}