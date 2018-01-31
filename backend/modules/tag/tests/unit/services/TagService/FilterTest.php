<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 31.01.18
 * Time: 11:13
 */

namespace backend\modules\tag\tests\unit\services\TagService;


/**
 * Class FilterTest
 * @package backend\modules\tag\tests\unit\services\TagService
 */
class FilterTest extends Unit
{
    /**
     * @group tag
     */
    public function testNull()
    {
        $array = [null, 'test', null];
        $this->assertEquals(['test'], $this->service->filter($array));
    }

    /**
     * @group tag
     */
    public function testTrim()
    {
        $array = ['test1', '  test2', 'test3  '];
        $this->assertEquals(['test1', 'test2', 'test3'], $this->service->filter($array));
    }

    /**
     * @group tag
     */
    public function testUnique()
    {
        $array = ['test1', '  test2', 'test1  '];
        $this->assertEquals(['test1', 'test2'], $this->service->filter($array));
    }
}