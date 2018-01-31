<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 28.01.18
 * Time: 19:02
 */

namespace app\modules\image\tests\unit\services\ImageService;


use app\modules\image\models\Image;
use app\modules\image\tests\fixtures\ImageFixture;

/**
 * Class MaxPosition
 * @package app\modules\image\tests\unit\services\ImageService
 */
class MaxPositionTest extends Unit
{
    /**
     * @group image
     * @throws \app\modules\image\tests\_generated\ModuleException
     */
    public function testByToken()
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

        $max = $this->service->maxPosition($image->class);

        $this->assertEquals(2, $max);
    }

    /**
     * @group image
     * @throws \app\modules\image\tests\_generated\ModuleException
     */
    public function testRecordId()
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

        $max = $this->service->maxPosition($image->class, $image->record_id);

        $this->assertEquals(2, $max);
    }
}