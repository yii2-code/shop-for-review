<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 04.02.18
 * Time: 17:46
 */

namespace app\modules\image\tests\unit\services\Image;

use yii\helpers\FileHelper;

/**
 * Class CreateTest
 * @package app\modules\image\tests\unit\services\Image
 */
class UploadTest extends Unit
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
        $name = $this->service->upload($file);
        $this->assertFileExists(codecept_output_dir('image/' . $name));
    }

}