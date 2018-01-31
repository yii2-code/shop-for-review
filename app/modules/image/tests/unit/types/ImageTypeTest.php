<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 26.01.18
 * Time: 21:28
 */

namespace app\modules\image\tests\unit\types;


use app\modules\image\types\ImageType;
use Codeception\Test\Unit;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * Class ImageTypeTest
 * @package app\modules\image\tests\unit\types
 */
class ImageTypeTest extends Unit
{

    /**
     * @group image
     * @throws \yii\base\InvalidConfigException
     */
    public function testOneSuccess()
    {
        $path = codecept_data_dir() . '/650x650.png';
        $type = new ImageType();
        $type->image = $this->createUploadFile(pathinfo($path, PATHINFO_BASENAME), $path, FileHelper::getMimeType($path), filesize($path), UPLOAD_ERR_OK);
        $this->assertTrue($type->validate(), 'Unable to validate type');
    }

    /**
     * @group image
     */
    public function testManySuccess()
    {
        $path = codecept_data_dir() . '/650x650.png';
        $type = new ImageType(2);
        $type->image = [
            $this->createUploadFile(pathinfo($path, PATHINFO_BASENAME), $path, filesize($path), filesize($path), UPLOAD_ERR_OK),
            $this->createUploadFile(pathinfo($path, PATHINFO_BASENAME), $path, filesize($path), filesize($path), UPLOAD_ERR_OK),
        ];

        $this->assertTrue($type->validate(), 'Unable to validate type');
    }

    /**
     * @group image
     */
    public function testEmpty()
    {
        $type = new ImageType();
        $this->assertFalse($type->validate());
        $this->assertArrayHasKey('image', $type->getErrors(), 'Attribute has not error');
    }

    /**
     * @group image
     * @throws \yii\base\InvalidConfigException
     */
    public function testMime()
    {
        $path = codecept_data_dir() . '/text.txt';
        $type = new ImageType();
        $type->image = $this->createUploadFile(pathinfo($path, PATHINFO_BASENAME), $path, FileHelper::getMimeType($path), filesize($path), UPLOAD_ERR_OK);
        $this->assertFalse($type->validate());
        $this->assertArrayHasKey('image', $type->getErrors(), 'Attribute has not error');
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