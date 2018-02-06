<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 04.02.18
 * Time: 19:20
 */

namespace app\modules\image\tests\unit\services\Upload;

use app\modules\image\services\Config;
use app\modules\image\services\Upload;
use app\modules\image\tests\stubs\UploadedFile;

class Unit extends \Codeception\Test\Unit
{
    /**
     * @var
     */
    protected $unitTester;

    /**
     * @var Upload
     */
    public $service;

    /**
     *
     */
    protected function _before()
    {
        $config = new Config(
            codecept_output_dir('image'),
            codecept_output_dir('image/thumb'),
            '/image',
            '/image/thumb',
            [
                '160x160' => [
                    'weight' => 160,
                    'height' => 160,
                    'quality' => 100,
                ]
            ]
        );
        $this->service = new Upload($config);
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