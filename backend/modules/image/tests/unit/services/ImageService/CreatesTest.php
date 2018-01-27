<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 27.01.18
 * Time: 15:29
 */

namespace backend\modules\image\tests\unit\services\ImageService;

use backend\modules\image\models\Image;
use yii\helpers\FileHelper;

/**
 * Class CreatesTest
 * @package backend\modules\image\tests\unit\services\ImageService
 */
class CreatesTest extends Unit
{

    /**
     * @group image
     * @throws \yii\base\InvalidConfigException
     */
    public function testSuccessByRecordId()
    {
        $images = $this->service->creates($this->generateImages(), $class = static::class, $recordId = 2);

        foreach ($images as $image) {
            $this->assertFileExists($this->manager->getPath() . '/' . $image->src, 'Unable to save image');

            $this->tester->seeRecord(
                Image::class,
                [
                    'id' => $image->id,
                    'class' => $class,
                    'record_id' => $recordId,
                    'token' => null,
                    'src' => $image->src,
                ]
            );
        }
    }


    /**
     * @group image
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\base\Exception
     */
    public function testSuccessByToken()
    {
        $token = $this->manager->createToken();

        $images = $this->service->creates($this->generateImages(), $class = static::class);

        foreach ($images as $image) {
            $this->assertFileExists($this->manager->getPath() . '/' . $image->src, 'Unable to save image');

            $this->tester->seeRecord(
                Image::class,
                [
                    'id' => $image->id,
                    'class' => $class,
                    'record_id' => null,
                    'token' => $token,
                    'src' => $image->src,
                ]
            );
        }
    }


    /**
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function generateImages(): array
    {
        $path = codecept_data_dir() . '/650x650.png';

        return [
            $this->createUploadFile(
                pathinfo($path, PATHINFO_BASENAME),
                $path,
                FileHelper::getMimeType($path),
                filesize($path),
                UPLOAD_ERR_OK
            ),
            $this->createUploadFile(
                pathinfo($path, PATHINFO_BASENAME),
                $path,
                FileHelper::getMimeType($path),
                filesize($path),
                UPLOAD_ERR_OK
            ),
        ];
    }
}