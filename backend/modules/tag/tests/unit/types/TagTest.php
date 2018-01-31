<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 31.01.18
 * Time: 12:31
 */

namespace backend\modules\tag\tests\unit\types;


use backend\modules\tag\types\TagType;
use Codeception\Test\Unit;

/**
 * Class TagTest
 * @package backend\modules\tag\tests\unit\types
 */
class TagTest extends Unit
{
    /**
     * @group tag
     */
    public function testSuccess()
    {
        $type = new TagType();
        $type->tag = 'tag';
        $this->assertTrue($type->validate(), 'Unable to validate type');
    }

    /**
     * @group tag
     */
    public function testRequired()
    {
        $type = new TagType();
        $this->assertFalse($type->validate());
        $this->assertArrayHasKey('tag', $type->getErrors(), 'Attribute has not error');
    }

    /**
     * @group tag
     */
    public function testTrim()
    {
        $type = new TagType();
        $type->tag = ' test ';
        $this->assertTrue($type->validate(), 'Unable to validate type');
        $this->assertEquals('test', $type->tag);
    }
}