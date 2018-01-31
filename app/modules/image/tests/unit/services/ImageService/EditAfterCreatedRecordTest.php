<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 27.01.18
 * Time: 22:37
 */

namespace app\modules\image\tests\unit\services\ImageService;

use app\modules\image\models\Image;
use app\modules\image\tests\fixtures\ImageFixture;


/**
 * Class EditAfterCreatedRecord
 * @package app\modules\image\tests\unit\services\ImageService
 */
class EditAfterCreatedRecordTest extends Unit
{

    /**
     * @group image
     * @throws \app\modules\image\tests\_generated\ModuleException
     */
    public function testSuccess()
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
        $image = $this->tester->grabFixture('image', 1);

        \Yii::$app->session->set($this->manager->getIdentitySession(), $image->token);

        $this->service->editAfterCreatedRecord($recordId = 1, $image->class);

        $this->tester->seeRecord(
            Image::class,
            [
                'id' => $image->id,
                'record_id' => $recordId,
                'token' => null,
            ]
        );
    }
}