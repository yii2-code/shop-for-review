<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 04.02.18
 * Time: 17:46
 */

namespace app\modules\image\tests\unit\services\ImageUpload;


use app\modules\image\services\Image;
use app\modules\image\tests\stubs\UploadedFile;
use Codeception\Test\Unit;
use yii\helpers\FileHelper;

/**
 * Class CreateTest
 * @package app\modules\image\tests\unit\services\ImageUpload
 */
class CreateTest extends Unit
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
     * @group image
     * @throws \yii\base\InvalidConfigException
     */
    public function testSuccess()
    {
        $path = codecept_data_dir() . '/650x650.png';

        $file = $this->createUploadFile(
            pathinfo($path, PATHINFO_BASENAME),
            $path,
            FileHelper::getMimeType($path),
            filesize($path),
            UPLOAD_ERR_OK
        );
        $name = $this->service->create($file);
        $this->assertFileExists(codecept_output_dir('image/' . $name));
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