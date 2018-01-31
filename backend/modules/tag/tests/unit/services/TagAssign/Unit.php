<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 31.01.18
 * Time: 13:52
 */

namespace backend\modules\tag\tests\unit\services\TagAssign;

use backend\modules\tag\services\TagAssignService;
use backend\modules\tag\tests\UnitTester;


/**
 * Class Unit
 * @package backend\modules\tag\tests\unit\services\TagAssign
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