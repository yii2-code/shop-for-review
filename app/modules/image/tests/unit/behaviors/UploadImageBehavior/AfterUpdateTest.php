<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 05.02.18
 * Time: 16:50
 */

namespace app\modules\image\tests\unit\behaviors\UploadImageBehavior;


use app\modules\image\tests\stubs\ActiveRecord;
use yii\helpers\FileHelper;

/**
 * Class AfterUpdateTest
 * @package app\modules\image\tests\unit\behaviors\UploadImageBehavior
 */
class AfterUpdateTest extends Unit
{

    /**
     * @group image
     */
    public function testSuccess()
    {
        $src = '650x650.png';
        $thumb = '160x160';
        FileHelper::createDirectory(codecept_output_dir('behavior/thumb'));
        copy(codecept_data_dir($src), codecept_output_dir("behavior/$src"));
        copy(codecept_data_dir($src), codecept_output_dir("behavior/thumb/$thumb-$src"));

        $activeRecord = new ActiveRecord();

        $activeRecord->afterSave(false, ['file' => $src]);

        $this->assertFileNotExists(codecept_output_dir("behavior/$src"));
        $this->assertFileNotExists(codecept_output_dir("behavior/thumb/$thumb-$src"));
    }
}