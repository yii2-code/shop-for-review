<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 05.02.18
 * Time: 16:28
 */

namespace app\modules\image\tests\unit\behaviors\UploadImageBehavior;

use app\modules\image\tests\stubs\ActiveRecord;
use yii\helpers\FileHelper;

/**
 * Class BeforeUpdateTest
 * @package app\modules\image\tests\unit\behaviors\UploadImageBehavior
 */
class BeforeUpdateTest extends Unit
{

    /**
     * @group image
     * @group test
     * @throws \yii\base\InvalidConfigException
     */
    public function testSuccess()
    {
        $src = '650x650.png';
        $thumb = '160x160';
        copy(codecept_data_dir($src), codecept_output_dir("behavior/$src"));
        copy(codecept_data_dir($src), codecept_output_dir("behavior/thumb/$thumb-$src"));

        $activeRecord = new ActiveRecord();

        $activeRecord->setOldAttributes(['file' => $src]);

        $path = codecept_data_dir('650x650.png');

        $file = $this->createUploadFile(
            pathinfo($path, PATHINFO_BASENAME),
            $path,
            FileHelper::getMimeType($path),
            filesize($path),
            UPLOAD_ERR_OK
        );

        $activeRecord->file = $file;

        $activeRecord->beforeSave(false);

        $this->assertFileExists(codecept_output_dir("behavior/{$activeRecord->file}"));
        $this->assertFileExists(codecept_output_dir("behavior/thumb/$thumb-{$activeRecord->file}"));
        $this->assertFileNotExists(codecept_output_dir("behavior/$src"));
        $this->assertFileNotExists(codecept_output_dir("behavior/thumb/$thumb-$src"));
    }
}