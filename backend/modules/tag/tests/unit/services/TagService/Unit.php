<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 31.01.18
 * Time: 11:14
 */

namespace backend\modules\tag\tests\unit\services\TagService;


use backend\modules\tag\services\TagService;
use backend\modules\tag\tests\UnitTester;
use Yii;

/**
 * Class Unit
 * @package backend\modules\tag\tests\unit\services\TagService
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