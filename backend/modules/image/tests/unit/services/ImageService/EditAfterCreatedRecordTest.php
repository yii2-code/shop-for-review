<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 27.01.18
 * Time: 22:37
 */

namespace backend\modules\image\tests\unit\services\ImageService;

use backend\modules\image\models\Image;
use backend\modules\image\tests\fixtures\ImageFixture;


/**
 * Class EditAfterCreatedRecord
 * @package backend\modules\image\tests\unit\services\ImageService
 */
class EditAfterCreatedRecordTest extends Unit
{

    /**
     * @group image
     * @throws \backend\modules\image\tests\_generated\ModuleException
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