<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 27.01.18
 * Time: 13:55
 */

namespace app\modules\image\tests\stubs;


class UploadedFile extends \yii\web\UploadedFile
{
    public function saveAs($file, $deleteTempFile = true)
    {
        return copy($this->tempName, $file);
    }
}