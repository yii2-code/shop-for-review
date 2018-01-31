<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 27.01.18
 * Time: 13:50
 */

namespace app\modules\image\tests\unit\services\ImageService;

use app\modules\image\models\Image;
use yii\helpers\FileHelper;

class CreateTest extends Unit
{


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
        $image = $this->service->create($file, $class = static::class, $position = 2, $recordId = 1, $main = Image::MAIN);
        $this->assertFileExists($this->manager->getPath() . '/' . $image->src, 'Unable to save image');
        $this->assertFileExists($this->manager->getThumbPath() . '/' . $this->manager->getThumbName('600x400', $image->src), 'Unable to save image');
        $this->tester->seeRecord(
            Image::class,
            [
                'id' => $image->id,
                'name' => $file->name,
                'class' => $class,
                'record_id' => $recordId,
                'src' => $image->src,
                'position' => $position,
                'main' => $main
            ]
        );
    }


}