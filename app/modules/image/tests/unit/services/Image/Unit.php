<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 04.02.18
 * Time: 19:20
 */

namespace app\modules\image\tests\unit\services\Image;

use app\modules\image\services\Image;
use app\modules\image\tests\stubs\UploadedFile;

class Unit extends \Codeception\Test\Unit
{
    /**
     * @var
     */
    protected $unitTester;

    /**
     * @var Image
     */
    public $service;

    /**
     *
     */
    protected function _before()
    {
        $this->service = new Image(
            codecept_output_dir('image'),
            codecept_output_dir('image/thumb'),
            [
                '160x160' => [
                    'weight' => 160,
                    'height' => 160,
                    'quality' => 100,
                ]
            ]
        );
    }

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