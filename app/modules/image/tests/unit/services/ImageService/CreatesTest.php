<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 27.01.18
 * Time: 15:29
 */

namespace app\modules\image\tests\unit\services\ImageService;

use app\modules\image\models\Image;
use app\modules\image\tests\fixtures\ImageFixture;
use yii\helpers\FileHelper;

/**
 * Class CreatesTest
 * @package app\modules\image\tests\unit\services\ImageService
 */
class CreatesTest extends Unit
{

    /**
     * @group image
     * @throws \app\modules\image\tests\_generated\ModuleException
     * @throws \yii\base\InvalidConfigException
     */
    public function testSuccessByRecordId()
    {
        $this->tester->haveFixtures(
            [
                'image' => [
                    'class' => ImageFixture::class,
                    'dataFile' => codecept_data_dir() . '/image.php'
                ]
            ]
        );

        /** @var Image $image */
        $image = $this->tester->grabFixture('image', 3);


        $images = $this->service->creates($this->generateImages(), $class = $image->class, $recordId = $image->record_id);

        foreach ($images as $index => $image) {
            $this->assertFileExists($this->manager->getPath() . '/' . $image->src, 'Unable to save image');

            $this->tester->seeRecord(
                Image::class,
                [
                    'id' => $image->id,
                    'class' => $class,
                    'record_id' => $recordId,
                    'token' => null,
                    'src' => $image->src,
                    'position' => $index + 3,
                    'main' => null,
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

        foreach ($images as $index => $image) {
            $this->assertFileExists($this->manager->getPath() . '/' . $image->src, 'Unable to save image');

            $this->tester->seeRecord(
                Image::class,
                [
                    'id' => $image->id,
                    'class' => $class,
                    'record_id' => null,
                    'token' => $token,
                    'src' => $image->src,
                    'position' => ++$index,
                    'main' => $index == 1 ? Image::MAIN : null,
                ]
            );
        }
    }

    public function testPosition()
    {

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