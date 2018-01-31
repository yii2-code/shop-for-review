<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 31.01.18
 * Time: 11:14
 */

namespace app\modules\tag\tests\unit\services\TagService;


use app\modules\tag\services\TagService;
use app\modules\tag\tests\UnitTester;
use Yii;

/**
 * Class Unit
 * @package app\modules\tag\tests\unit\services\TagService
 */
class Unit extends \Codeception\Test\Unit
{

    /** @var UnitTester */
    public $tester;

    /**
     * @var TagService
     */
    public $service;

    /**
     * @throws \yii\base\InvalidConfigException
     */
    protected function _before()
    {
        $this->service = Yii::createObject(TagService::class);
    }
}