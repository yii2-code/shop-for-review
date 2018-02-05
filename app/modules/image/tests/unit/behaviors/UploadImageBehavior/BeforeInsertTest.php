<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 05.02.18
 * Time: 13:47
 */

namespace app\modules\image\tests\unit\behaviors\UploadImageBehavior;


use app\modules\image\tests\stubs\ActiveRecord;
use yii\helpers\FileHelper;

/**
 * Class BeforeInsertTest
 * @package app\modules\image\tests\unit\behaviors\UploadImageBehavior
 */
class BeforeInsertTest extends Unit
{

    /**
     * @group image
     * @throws \yii\base\InvalidConfigException
     */
    public function testSuccess()
    {
        $path = codecept_data_dir('650x650.png');

        $file = $this->createUploadFile(
            pathinfo($path, PATHINFO_BASENAME),
            $path,
            FileHelper::getMimeType($path),
            filesize($path),
            UPLOAD_ERR_OK
        );

        $activeRecord = new ActiveRecord();
        $activeRecord->file = $file;
        $activeRecord->beforeSave(true);

        $this->assertFileExists(codecept_output_dir('behavior/' . $activeRecord->file));
        $this->assertFileExists(codecept_output_dir('behavior/thumb/' . '160x160-' . $activeRecord->file));
    }

}