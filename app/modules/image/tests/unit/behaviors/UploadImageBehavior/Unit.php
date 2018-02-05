<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 05.02.18
 * Time: 16:28
 */

namespace app\modules\image\tests\unit\behaviors\UploadImageBehavior;


use app\modules\image\tests\stubs\UploadedFile;

class Unit extends \Codeception\Test\Unit
{
    /**
     * @param $name
     * @param $tempName
     * @param $type
     * @param $size
     * @param $error
     * @return UploadedFile
     */
    public function createUploadFile($name, $tempName, $type, $size, $error): UploadedFile
    {
        return new UploadedFile([
            'name' => $name,
            'tempName' => $tempName,
            'type' => $type,
            'size' => $size,
            'error' => $error,
        ]);
    }
}