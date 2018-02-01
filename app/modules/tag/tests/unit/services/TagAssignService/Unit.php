<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 31.01.18
 * Time: 13:52
 */

namespace app\modules\tag\tests\unit\services\TagAssignService;

use app\modules\tag\services\TagAssignService;
use app\modules\tag\tests\UnitTester;


/**
 * Class Unit
 * @package app\modules\tag\tests\unit\services\TagAssignService
 */
class Unit extends \Codeception\Test\Unit
{
    /** @var UnitTester */
    public $tester;

    /** @var TagAssignService */
    public $service;

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function _before()
    {
        $this->service = \Yii::createObject(TagAssignService::class);
    }
}