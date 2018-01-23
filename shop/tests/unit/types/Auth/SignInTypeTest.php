<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 19.01.18
 * Time: 15:13
 */

namespace shop\tests\unit\types\Auth;


use Codeception\Test\Unit;
use shop\types\Auth\SignInType;

/**
 * Class SignInTypeTest
 * @package shop\tests\unit\types\Auth
 */
class SignInTypeTest extends Unit
{
    /**
     * @group auth
     */
    public function testSuccess()
    {
        $type = new SignInType();
        $type->login = 'test';
        $type->password = 'password';
        $this->assertTrue($type->validate(), 'Unable to validate type');
    }

    /**
     * @group auth
     */
    public function testRequired()
    {
        $type = new SignInType();
        $this->assertFalse($type->validate(), 'The Model validates');
        $this->assertArrayHasKey('login', $type->getErrors(), 'Property login has not error');
        $this->assertArrayHasKey('login', $type->getErrors(), 'Property password has not error');
    }
}