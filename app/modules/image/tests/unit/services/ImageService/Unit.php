<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 27.01.18
 * Time: 15:29
 */

namespace app\modules\image\tests\unit\services\ImageService;


use app\modules\image\services\ImageManager;
use app\modules\image\services\ImageManagerInterface;
use app\modules\image\services\ImageService;
use app\modules\image\tests\stubs\UploadedFile;
use app\modules\image\tests\UnitTester;

class Unit extends \Codeception\Test\Unit
{

    /**
     * @var UnitTester
     */
    public $tester;

    /**
     * @var ImageService
     */
    public $service;

    /** @var ImageManager */
    public $manager;

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function _before()
    {
        /** @var ImageManager $manager */
        $this->manager = \Yii::createObject(ImageManagerInterface::class);
        $this->service = $this->manager->createService();
    }

    /**
     * @param $name
     * @param $tempName
     * @param $type
     * @param $size
     * @param $error
     * @return UploadedFile
     */
    public function createUploadFile($name, $tempName, $type, $size, $error): UploadedFile
    {
        return new UploadedFile([
            'name' => $name,
            'tempName' => $tempName,
            'type' => $type,
            'size' => $size,
            'error' => $error,
        ]);
    }
}